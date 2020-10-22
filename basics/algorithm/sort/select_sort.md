# 选择排序

PHP
```php
function select_sort($array)
{
    $len = count($array);
    if ($len < 1) return $array;

    for ($i = 0;$i < $len;$i ++) { // 外层循环控制轮数，即选择谁进行比对。
        $p = $i; // 设最小值位当前值

        for ($j = $i + 1;$j < $len;$i ++) { // 循环剩下的元素的索引，与预设最小值进行比对，如果小，改变最小值
            if ($array[$p] > $array[$j]) {
                $p = $j;
            }
        }

        if ($p != $i) { // 如果最小值，与当前值不一样，说明当前值比较大，交换。
            $tmp = $array[$i];
            $array[$i] = $array[$p];
            $array[$p] = $tmp;
        }
    }

    return $array;
}
```