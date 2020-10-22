# 冒泡排序

PHP
```php
function bubble_sort($array)
{
    if (count($array) < 1) return $array;

    for ($i = 0;$i < count($array);$i ++) {
        for ($j = $i + 1;$j < count($array)1;$j ++) {
            if ($array[$i] > $array[$j]) {
                $tmp = $array[$i];
                $array[$i] = $array[$j];
                $array[$j] = $array[$i];
            }
        }
    }

    return $array;
}
```