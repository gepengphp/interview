# PHP 读取 syslog

读取日志的场景使用正则的处理效率太低，使用 `fscanf` 方法。   

```php
$fn = 'sys.log';
$fp = fopen($fn, 'r');
while(! feof($fp)) {
  $r[] = fscanf($fp, "%s %s %s %s my: %s %s %s\n");
}
print_r($r);
```

> 相关函数 `sscanf`   
