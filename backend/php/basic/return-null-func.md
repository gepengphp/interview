# 返回 `null` 的函数

返回 `null` 的函数：`trim`、`md5`、`explode`、`strpos`、`strcmp`。
设置 `error_reporting(0);` 关闭报错后，不报错，但可能影响判断，进而导致业务逻辑错误。
```php
$arr = [];
var_dump(trim($arr) === null);         // true
var_dump(md5($arr) === null);          // true
var_dump(explode(',', $arr) === null); // true
var_dump(strpos($arr, 'a') === null);  // true
var_dump(strcmp($arr, 'a') === null);  // true
```
