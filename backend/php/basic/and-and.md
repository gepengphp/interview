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
