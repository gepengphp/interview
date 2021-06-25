# `trim`

`trim` 会去掉符合**删除字符**中的全部字符，直到遇到一个不是**删除字符**的停止
```
echo trim('http://www.baidu.com', 'https://');
// www.baidu.com
```
