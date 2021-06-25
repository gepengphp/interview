# 隐式转换 1 （类型约束）

PHP 的类型约束并非强类型，符合隐式转换规则的类型，会自动进行转换。  
```php
function trans(bool $b) {
    var_dump($b);
}
trans('false');
// bool(true)
```
> **场景**：`.env` 文件中，配置变量 `IS_PRO=false`，通过 `env()` 函数获取后值为 `string(5) false`，作为参数传入方法时会被转换为 `bool true`。   
这很 **危险**，可能导致换件变量所起的作用完全相反。
