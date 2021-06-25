# 浮点运算精度

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
