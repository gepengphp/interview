# ID 混淆
当自增 ID 直接暴露时，容易被爬虫暴力爬取，所以需要将 ID 混淆后输出。

## 多次偏移

### 代码：  
```php
class SIDHelper
{
    private static $offset = 371850;

    public static function setOffset($offset)
    {
        self::$offset = $offset;
        return self::class;
    }


    /**
     * public static string EncodeID(int id)
     */
    public static function encodeID(int $id)
    {
        $sid = ($id & 0xff000000);
        $sid += ($id & 0x0000ff00) << 8;
        $sid += ($id & 0x00ff0000) >> 8;
        $sid += ($id & 0x0000000f) << 4;
        $sid += ($id & 0x000000f0) >> 4;
        $sid ^= self::$offset;
        return (string) $sid;
    }

    public static function decodeID(string $sid)
    {
        $sid ^= self::$offset;
        $id = ($sid & 0xff000000);
        $id += ($sid & 0x00ff0000) >> 8;
        $id += ($sid & 0x0000ff00) << 8;
        $id += ($sid & 0x000000f0) >> 4;
        $id += ($sid & 0x0000000f) << 4;
        return (int) $id;
    }
}
```
**注意：**`$offset` 偏移量值越大，混淆后的结果越大，可以通过改变偏移量调整混淆后的id大小。但需要注意混淆效率。

### 调用
```php
SIDHelper::encodeId(113); # 371869
SIDHelper::decodeId(371869); # 113
```

## 多次 HASH 后拼接
// todo 待整理

众所周知，在web应用的API中，总是会出现数据库item的id。比如GET /posts/1表示获取id为1的文章内容。这样做十分简洁，但存在被人爬数据的风险。比如我可以大致猜测或者试一下id的范围，1,2,3...10000这样迭代地爬数据。如果服务器不做访问限制，很轻易就能把所有数据就能爬下来。而且，这样的数字id也会暴露一些信息，比如id小的一般是更早创建的。

所以要对id进行混淆，混淆有这么几个特点：

它是一个无符号整数到字符串的一一对应的函数
双向的，混淆之后可以恢复，所以不能用hash
不表现出递增的特征
不用像加密那样强，也不用有密钥
没有整数范围的限制。这一条是我加的，google能搜到很多id混淆的方法但它们可能要求id在2^32-1之内，比如对2^32求一个multiplicative inverse，这是一个不错的方法但因为这个限制我没有采用它。
最简单的一个方法是找一个比较大的数字进行异或，比如1-10跟1093420374进行异或的结果是这样的：

1 : 1093420375
2 : 1093420372
3 : 1093420373
4 : 1093420370
5 : 1093420371
6 : 1093420368
7 : 1093420369
8 : 1093420382
9 : 1093420383
10: 1093420380
但这比较容易被人猜出是异或，需要再加上别的操作

我看到的一个比较好的方法也是我目前在用的是：

对id求个hash，取前16字节，作为segment1
对segment1求hash，取前8字节，作为segment2
将segment2转换为整数，加上id，再变回byte array
将segment1和segment2连接起来再求个hash，取前8字节，作为segment3（用于恢复时的验证）
连接segment1、2、3，做base64，得到混淆后的id
恢复的时候只用

base64解码
取前16字节得到segment1，后8字节得到segment3，剩余字节是segment2
验证hash(segmemt1+segment2)是否等于segment3
int(segment2)-int(hash(segment1))得到id


### 原文地址
[https://segmentfault.com/a/1190000002806999](https://segmentfault.com/a/1190000002806999)