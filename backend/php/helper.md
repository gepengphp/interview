# 助手函数

### `bin_split` 
- 定义  
    整数按位分割为数组，输入 2，返回 [2]，输入 100，返回 [3, 6, 7]
- 代码
    ```php
    /**
     * 数字按位分割为数组
     */
    function bin_split(int $number): array
    {
        $a = [];

        $bin = decbin($number);
        $binLen = strlen($bin);
        for ($i = 0;$i < $binLen;$i ++) {
            if ($number & pow(2, $i)) {
                $a[] = $i + 1;
            }
        }
        vdump($a);

        return $a;
    }
    ```
- 参数  
    | 参数 | 描述 |
    | ---- | ---- | 
    | number | 必需。需要分割的十进制数 |
- 返回值  
    一个数组。包含 number 按位分割后的为真的位对应的十进制数。
- 实例
    ```php
    > var_dump(bin_split(1));
    array(4) {
      [0]=> int(1)
    }
    > var_dump(bin_split(2));
    array(4) {
      [0]=> int(2)
    }
    > var_dump(bin_split(3));
    array(4) {
      [0]=> int(1)
      [1]=> int(2)
    }
    > var_dump(bin_split(100));
    array(4) {
      [0]=> int(1)
      [1]=> int(3)
      [2]=> int(6)
      [3]=> int(7)
    }
    ```
