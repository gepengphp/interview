# `sscanf`、`fscanf` 函数的应用

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
