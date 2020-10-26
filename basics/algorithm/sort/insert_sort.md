# 插入排序

PHP
```php
function insert_sort($array)
{
    $len = count($array);
    if ($len < 1) return $array;

    for ($i = 1;$i < $len;$i ++) { // 外层循环，被插入元素的索引
        $tmp = $array[$i]; // 设，当前需要被插入的值，用来比较
        for ($j = $i - 1;$j >= 0;$ --) { // 内层从 被插入的值 - 1，往前找，如果大于被插入的值，则交换，即“将 被插入的值 插入”到对应的位置。
            if ($tmp < $array[$j]) {
                $array[$j + 1] = $array[$j];
                $array[$j] = $tmp;
            }
            break; // 已经找到 内层的值因为前面的已经排序了，所以不需要继续比对了。
        }
    }

    return $array;
}

$array = [ 4, 6, 8, 2, 5, 9 ];
```