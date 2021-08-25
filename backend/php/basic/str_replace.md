# `str_repace` 函数的问题

`str_replace` 函数在替换字符串时，`$search` 和 `$replace` 两个参数可以传递数组，问题是，在替换时会按照数组顺序依次替换。   
可能会导致字符被多次替换。   
如：

```php
$str = '> test';
/**
 * 替换 XML 中的特殊字符为实体字符
 */
$str = \str_replace(
    ['<', '>', '&', '\'', '"'],
    ['&lt;', '&gt;', '&amp;', '&apos;', '&quot;'],
    $str
);

// 匹配到 “>” 时，字符串变为【&lt; test】
// 匹配到 “&” 时，字符串变为【&amp;lt; test】
// 最终 xml 中的字符串被显示为【&lt; test】
```