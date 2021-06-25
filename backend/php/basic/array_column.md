# `array_column` 用法

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
