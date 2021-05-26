# 基础

## `&&` 和 `and` 区别
优先级不同，`&&` > `=` > `and`
```php
if ($a = 'aa' && 'bb') {
    var_dump($a);
}
// bool(true)

if ($a = 'aa' and 'bb') {
    var_dump($a);
}
// string(2) "aa"
```
> **建议**：使用 `and` 或 使用 `()` 标明优先级

## `strtotime` 大小月 bug
当前时间为 `2018-07-31`，执行 `date("Y-m-d",strtotime("-1 month"))` 输出结果为 `2018-07-01`。
原因：
- 先做 -1 month, 那么当前是07-31, 减去一以后就是06-31.
- 再做日期规范化, 因为6月没有31号, 所以就好像2点60等于3点一样, 6月31就等于了7月1
只要涉及大小月的最后一天，都存在这种情况。验证：
```php
var_dump(date('Y-m-d', strtotime('-1 month', strtotime('2017-03-31'))));
// string(10) "2017-03-03"
var_dump(date('Y-m-d', strtotime('+1 month', strtotime('2017-08-31'))));
// string(10) "2017-10-01"
var_dump(date('Y-m-d', strtotime('next month', strtotime('2017-01-31'))));
// string(10) "2017-03-03"
var_dump(date('Y-m-d', strtotime('last month', strtotime('2017-03-31'))));
// string(10) "2017-03-03"
```
PHP5.3后, `date` 新增了 `first day of` 和 `last day of` 修正短语, 来明确这个问题, 也就是你可以限定好不要让date自动 `规范化`：
```php
var_dump(date('Y-m-d', strtotime('last day of -1 month', strtotime('2017-03-31'))));
// string(10) "2017-02-28"
var_dump(date('Y-m-d', strtotime('first day of +1 month', strtotime('2017-08-31'))));
// string(10) "2017-09-01"
var_dump(date('Y-m-d', strtotime('first day of next month', strtotime('2017-01-31'))));
// string(10) "2017-02-01"
var_dump(date('Y-m-d', strtotime('last day of last month', strtotime('2017-03-31'))));
// string(10) "2017-02-28"
```

## `trim`
`trim` 会去掉符合**删除字符**中的全部字符，直到遇到一个不是**删除字符**的停止
```
echo trim('http://www.baidu.com', 'https://');
// www.baidu.com
```

## `array_column` 用法
```php
$users = [
    [
        'id' => 11,
        'name' => 'zhangsan',
    ],
    [
        'id' => 12,
        'name' => 'lisi',
    ],
    [
        'id' => 13,
        'name' => 'wangwu',
    ],
];
array_column($users, 'name');
// [ 0 => 'zhangsan', 1 => 'lisi', 2 => 'wangwu' ]

array_column($users, 'name', 'id');
// [ 11 => 'zhangsan', 12 => 'lisi', 13 => 'wangwu' ]

array_column($users, null, 'id');
// [
//     11 => [ 'id' => 11, 'name' => 'zhangsan' ],
//     12 => [ 'id' => 12, 'name' => 'lisi' ],
//     13 => [ 'id' => 13, 'name' => 'wangwu' ],
// ]
```

## 浮点运算精度
涉及到 PHP 存储小数方式，太长了去百度。
```php
var_dump(intval(0.58 * 100));
// int(57)
var_dump(.1 + .7);
// float(0.8)
var_dump((.1 + .7) == .8));
// false
```
- 如果时金额（两位小数），乘 100 后再计算，再除 100；
- 使用 `BCMath` 扩展包

## 类型约束隐式转换
PHP 的类型约束并非强类型，符合隐式转换规则的类型，会自动进行转换。  
```php
function trans(bool $b) {
    var_dump($b);
}
trans('false');
// bool(true)
```
> **场景**：`.env` 文件中，配置变量 `IS_PRO=false`，通过 `env()` 函数获取后值为 `string(5) false`，作为参数传入方法时会被转换为 `bool true`。

## `getenv`
`getenv`、`setenv` 函数都是非线程安全的。  
在 Apache 服务下都可能产生安全问题，如：
- 获取不到环境变量；
- 部署多个项目获取到另一个项目的环境变量；
Apache 使用线程处理请求，当一个进程同时有几个线程的时候，就比较容易发生「串值」的情况。
nginx + PHP-FPM 没有影响，nginx 通过 fpm 处理 PHP 请求，进程间相互独立。
CLI 模式同理不受影响。
> **建议**：在 Apache 环境下尽量避免使用 `getenv`、`setenv` 函数，如 Laravel 框架部署时执行 `php artisan config:cache` 对配置文件进行缓存。

## `md5` 和 `sha1` 的比较问题
```php
$md5_1 = md5('240610708');
$md5_2 = md5('QNKCDZO');
var_dump($md5_1); // string(32) "0e462097431906509019562988736854"
var_dump($md5_2); // string(32) "0e830400451993494058024219903391"
var_dump($md5_1 == $md5_2); // bool(true)

$sha_1 = sha1('aaO8zKZF');
$sha_2 = sha1('aa3OFF9m');
var_dump($sha_1); // string(40) "0e89257456677279068558073954252716165668"
var_dump($sha_2); // string(40) "0e36977786278517984959260394024281014729"
var_dump($sha_1 == $sha_2); // bool(true)
```
使用 == 号时，如果比较一个数字和字符串或者比较涉及到数字内容的字符串，则字符串会被转换为数值并且比较按照数值来进行；两个字符串恰好以 0e 的科学记数法开头，字符串被隐式转换为浮点数，实际上也就等效于 0×10^0 ，因此比较起来是相等的。  
> **建议**：PHP中的Hash校验，应该使用 `===`，而不应该使用 `==`。另外如果生产环境版本足够高的话（PHP >= 5.6.0），最好使用 `hash_equals()` 函数。

> 扩展： 
```php
var_dump( 0 == "a" ); //true
var_dump( "0" == "a" ); //false
```

## 返回 `null` 的函数
返回 `null` 的函数：`trim`、`md5`、`explode`、`strpos`、`strcmp`。
设置 `error_reporting(0);` 关闭报错后，不报错，但可能影响判断
```php
$arr = [];
var_dump(trim($arr) === null);         // true
var_dump(md5($arr) === null);          // true
var_dump(explode(',', $arr) === null); // true
var_dump(strpos($arr, 'a') === null);  // true
var_dump(strcmp($arr, 'a') === null);  // true
```


## `foreach` 的 `value` 传引用的坑
```php
$a = ['a', 'b', 'c'];

foreach ($a as &$value) {
    echo $value, PHP_EOL;
}
// a
// b
// c
echo $value, PHP_EOL;
// c

foreach ($a as $value) {
    echo $value, PHP_EOL;
}
// a
// b
// b
echo $value, PHP_EOL;
// b
```
第一个循环，第一次：声明 `$value`，赋给 `$a[0]` 的引用  
第一个循环，第二次：声明 `$value`，赋给 `$a[1]` 的引用  
第一个循环，第三次：声明 `$value`，赋给 `$a[2]` 的引用  
第二个循环，第一次：声明 `$value`，将 `$a[0]` 的值赋给 `$value` 的引用，即改变 `$a[2]` 的值为 'a';  
第二个循环，第二次：声明 `$value`，将 `$a[1]` 的值赋给 `$value` 的引用，即改变 `$a[2]` 的值为 'b';  
第二个循环，第三次：声明 `$value`，将 `$a[2]` 的值赋给 `$value` 的引用，即改变 `$a[2]` 的值为 'b';  
> **建议**：`foreach` 后必须使用 `unset` 清除引用

## `|` 的应用
`按位或` 运算符
```php
class videoHandle
{
    const WATERMARK   = 0b00000001; // 水印
    const TRANSCODING = 0b00000010; // 转码
    const COMPRESS    = 0b00000100; // 压缩
    // const ...

    private $strategy = 0;

    private $strategies = [
        self::WATERMARK,
        self::TRANSCODING,
        self::COMPRESS,
    ];

    /**
     * 设置策略
     */
    public function setStrategy($strategy)
    {
        $this->strategy = $strategy;
        return $this;
    }

    /**
     * 开始任务
     */
    public function start()
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy & $this->strategy) {
                // do something
            }
        }
    }
}
$handle = new videoHandle();
$handle->setStrategy(videoHandle::WATERMARK | videoHandle::TRANSCODING) // 设置视频处理策略
    ->start();
```

## `Filesystem` 函数缓存
php 检查一个文件时，会缓存结果。同一个脚本多次检查同一个文件，需要使用 `clearstatcache` 函数。
以下是受 `clearstatcache` 影响的函数。
```php
stat()
lstat()
file_exists()
is_writable()
is_readable()
is_executable()
is_file()
is_dir()
is_link()
filectime()
fileatime()
filemtime()
fileinode()
filegroup()
fileowner()
filesize()
filetype()
fileperms()
```

## `sscanf`、`fscanf` 函数的应用
常用于从固定格式字符串中解析关键信息，如日志，效率比正则高很多。

使用时注意
```php
# 正确情况，返回值是匹配到的变量数量，异常返回 -1
> var_dump(sscanf('<190>May 04 2021 16:35:09.123 UTC %test', '<%d>%s %d %d %d:%d:%d.%d UTC %%%s', $f, $d, $m, $y, $h, $min, $s, $ms, $msg));
int(9) # 匹配到的变量数量
> var_dump(compact('f', 'm', 'y', 'h', 'min', 's', 'ms', 'msg'));
array(8) {
  ["f"]   => int(190)
  ["m"]   => int(4)
  ["y"]   => int(2021)
  ["h"]   => int(16)
  ["min"] => int(35)
  ["s"]   => int(9)
  ["ms"]  => int(123)
  ["msg"] => string(4) "test"
}

# 错误情况 1：当无法匹配到对应内容时将停止解析，未匹配的变量值为 NULL
# 注意，当匹配停止时，sscanf 函数就会返回，并不会对后面的变量进行任何操作，所以如果是在一个循环中，需要视情况提前 unset 所有变量，以防后面的循环使用前面变量的值
> var_dump(sscanf('<190>May aa 2021 16:35:09.123 UTC %te st', '<%d>%s %d %d %d:%d:%d.%d UTC %%%s', $f, $d, $m, $y, $h, $min, $s, $ms, $msg));
int(2)
> var_dump(compact('f', 'm', 'y', 'h', 'min', 's', 'ms', 'msg'));
array(8) {
  ["f"]   => int(190)
  ["m"]   => int(4)
  ["y"]   => NULL
  ["h"]   => NULL
  ["min"] => NULL
  ["s"]   => NULL
  ["ms"]  => NULL
  ["msg"] => NULL
}

# 错误情况 2：匹配内容默认按空格进行分隔，所以无法匹配一段带有空格的内容
> var_dump(sscanf('<190>May 04 2021 16:35:09.123 UTC %test something', '<%d>%s %d %d %d:%d:%d.%d UTC %%%s', $f, $d, $m, $y, $h, $min, $s, $ms, $msg));
int(9)
> var_dump(compact('f', 'm', 'y', 'h', 'min', 's', 'ms', 'msg'));
array(8) {
  ["f"]   => int(190)
  ["m"]   => int(4)
  ["y"]   => int(2021)
  ["h"]   => int(16)
  ["min"] => int(35)
  ["s"]   => int(9)
  ["ms"]  => int(123)
  ["msg"] => string(4) "test" # 这里无法匹配到 test something，只能匹配到 test
}
```
