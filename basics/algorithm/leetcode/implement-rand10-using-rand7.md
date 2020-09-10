# [470. 用 Rand7() 实现 Rand10()](https://leetcode-cn.com/problems/implement-rand10-using-rand7/)
已有方法 rand7 可生成 1 到 7 范围内的均匀随机整数，试写一个方法 rand10 生成 1 到 10 范围内的均匀随机整数。


**提示:**  
rand7 已定义。


## 舍去法

rand7生成7个整数，没有办法均匀的映射成10个整数，但是运行两次rand7可以生成49个数字，如果这49个数字是均匀分布的，舍去多余的9个，剩下的40个正好可以用模10运算映射到10个整数上。

```php
/*
 * The rand7() API is already defined for you.
 * @return a random integer in the range 1 to 7
 * function rand7();
*/

class Solution {
    /**
     * @param 
     * @return Integer
     */
    function rand10() {
        do {
            $i = 7 * (rand7() - 1) + rand7(); // 1 ~ 49
            return $i % 10 + 1;
        } while ($i > 40)
    }
}
```

这个算法做到了从40个数字均匀映射到1到10，这个说法有些抽象，进一步形象的来说明，考虑如下的种子矩阵：
> int seed7[7][7] = {  
>   {1 , 2 , 3 , 4 , 5 , 6 , 7},  
> 	{8 , 9 , 10, 1 , 2 , 3 , 4},  
> 	{5 , 6 , 7 , 8 , 9 , 10, 1},  
> 	{2 , 3 , 4 , 5 , 6 , 7 , 8},  
> 	{9 , 10, 1 , 2 , 3 , 4 , 5},  
> 	{6 , 7 , 8 , 9 , 10, 0 , 0},  
>   {0 , 0 , 0 , 0 , 0 , 0 , 0}  
> };

如果用 x=0...6, y=1...7，则变换 i=7x+y 与矩阵中每个元素位置与 (x,y) 唯一对应，也就是 x 选择行，y 选择列，如果 x 和 y 都是均匀分布，那么这 49 个位置有相同的被选中的概率 = 1/49。下面这行代码实现了这个变换：  
> $i = 7 * (rand7() - 1) + rand7();

其中7*(rand7()-1)相当于选择种子矩阵中的行，第二个rand7相当于选择列，而最后的模10+1运算，就恰好生成了矩阵中每个元素的值，但是(i>40)这个循环条件把最后的9个值变为了0。因此代码1等价于在种子矩阵中做选择。  


## 参考
https://blog.csdn.net/stone688598/article/details/6853989