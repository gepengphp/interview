# `strtotime` 大小月 bug

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
