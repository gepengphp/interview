# 隐式转换 2 （in_array）

一次在过滤一个二位数组的多余字段时，联合使用了 `array_filter`和 `in_array` 方法，写出一个 bug。   
也可以理解为由 `类型转换` 引起。

代码如下：
```php

$data = [
    0 => [
        'a' => 'a',
        'b' => 'b',
        'c' => 'c',
    ],
    1 => [
        'a' => 'a',
        'b' => 'b',
        'c' => 'c',
    ],
];
$allowKeys = [ 'a', 'b' ];

// 这里写错了，忘记 data 是一个二维数组了，应该在外面添加一层循环
$data = array_filter($data, function ($key) use ($keys) {
    return in_array($key, $keys);
}, ARRAY_FILTER_USE_KEY);

print_r($data);
```

将错就错，在这种情况下，输出的结果为如下：   
```
Array(
    0 => Array(
        'a' => 'a',
        'b' => 'b',
        'c' => 'c'
    )
)
```
原因：in_array 比对时，也会做类型转换；   
0 和 'a'、'b' 比较时，'a'、'b' 会转换成整型：0；    
所以第一个元素会返回“true”。

> in_array 方法第三个参数为可选参数，默认值时 false，可以设置为 true，这样 in_array 会同时检查搜索的数据与数组的值的类型是否相同。


> 1  所有字符串比对的场景，如果缺少类型约束，最好都要考虑类型转换的问题。   
2  除非特殊需要，使用 in_array 函数时，习惯指定第三个参数，这样也可以增加函数的执行效率。