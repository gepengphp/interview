# id 混淆


## 代码

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

## 调用
```php
SIDHelper::encodeId(113); # 371869
SIDHelper::decodeId(371869); # 113
```
