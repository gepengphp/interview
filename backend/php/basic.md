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
```
function trans(bool $b) {
    var_dump($b);
}
trans('false');
// bool(true)
```
》 **场景**：`.env` 文件中，配置变量 `IS_PRO=false`，通过 `env()` 函数获取后值为 `string(5) false`，作为参数传入方法时会被转换为 `bool true`。