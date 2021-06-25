# `foreach` 的 `value` 传引用的坑

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
