# 快速排序

PHP
```php
function qsort($array)
{
    if (count($array) < 1) {
        return $array;
    }

    $middle = [0];
    for ($i = 1;$i < count($array);$i ++) {
        if ($array[$i] < $middle) {
            $left[] = $array[$i];
        } else {
            $right[] = $array[$i];
        }
    }

    $left = qsort($left);
    $right = qsort($right);

    return array_merge($left, [$middle], $right);
}
```