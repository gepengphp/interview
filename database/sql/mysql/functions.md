# 方法

## MySQL 字符串函数

- `CONCAT`  
CONCAT(str1, str2, …)  
合并多个字符串
返回结果为连接参数产生的字符串。如有任何一个参数为NULL ，则返回值为 NULL（见：sql 1）。  
**注意：**  
如果所有参数均为非二进制字符串，则结果为非二进制字符串；   
如果自变量中含有任一二进制字符串，则结果为一个二进制字符串；  
一个数字参数被转化为与之相等的二进制字符串格式；若要避免这种情况，可使用显式类型 cast（见：sql 2）。  
Mysql 中的二进制类型有：BIT、BINARY、VARBINARY、TINYBLOB、BLOB、MEDIUMBLOB 和 LONGBLOB。
```sql
-- sql 1
SELECT CONCAT ('Hello', ' ', 'world.');
->Hello world.
SELECT CONCAT ('Hello', NULL, 'world.');
->(NULL)

-- sql 2
SELECT CONCAT(01, 10, 11);
->11011 -- 二进制类型会省略掉前面的 0
SELECT CONCAT('01', 10, 11);
->011011
```

- `concat_ws`  
CONCAT_WS(separator, str1, str2, ...)  
    - separator 分隔符   
    
    合并多个字符串，并添加分隔符

    **注意：**
    如果分隔符为 NULL，则结果为 NULL。函数会忽略任何分隔符参数后的 NULL 值（见 sql 2）。
```sql
-- sql 1
SELECT CONCAT_WS(',', 10, 11);
->10,11
SELECT CONCAT_WS(',', 01, 02);
->1,2
SELECT CONCAT_WS(',', '01', '02');
->01,02

-- sql 2
SELECT CONCAT_WS(NULL, 10, 11);
->(NULL)
SELECT concat_ws(',', '01', '02', NULL);
->01,02

-- ERROR 
SELECT CONCAT_WS(',');
-- 错误代码： 1582
-- Incorrect parameter count in the call to native function 'concat_ws'
```

- `group_concat`  
group_concat([DISTINCT] 要连接的字段 [Order BY ASC/DESC 排序字段] [Separator '分隔符'])
```sql
SELECT * FROM articles;
id    user_id    title
1     1          PHP从入门到送外卖
2     1          Mysql从删库到跑路
3     2          pronhub

SELECT user_id, GROUP_CONCAT(title) AS titles FROM articles GROUP BY user_id;
user_id    title
1          PHP从入门到送外卖,Mysql从删库到跑路
2          pronhub

SELECT user_id, GROUP_CONCAT(title separator ';') AS titles FROM articles GROUP BY user_id;
user_id    title
1          PHP从入门到送外卖;Mysql从删库到跑路
2          pronhub

SELECT user_id, GROUP_CONCAT(title ORDER BY title ASC separator ';') AS titles FROM articles GROUP BY user_id;
user_id    title
1          Mysql从删库到跑路;PHP从入门到送外卖
2          pronhub
```


## MySQL 数字函数


## MySQL 日期函数

- `ADDDATE`  
DATE_ADD(date,INTERVAL expr type)
    - date 参数是合法的日期表达式。
    - expr 参数是您希望添加的时间间隔。
    - type 参数可以是下列值：
        - MICROSECOND 微秒
        - SECOND 秒
        - MINUTE 分钟
        - HOUR 小时
        - DAY 天
        - WEEK 星期
        - MONTH 月
        - QUARTER 季度
        - YEAR 年
        - SECOND_MICROSECOND、MINUTE_MICROSECOND、MINUTE_SECOND、HOUR_MICROSECOND、HOUR_SECOND、HOUR_MINUTE、DAY_MICROSECOND、DAY_SECOND、DAY_MINUTE、DAY_HOUR、YEAR_MONTH 复合单位（见 sql 2）

给时间添加指定的时长
```sql
-- sql 1
SELECT ADDDATE('2020-09-10', INTERVAL 1 DAY);
->2020-09-11 -- 加 1 天
SELECT ADDDATE('2020-09-10', INTERVAL 1 HOUR);
->2020-09-10 01:00:00 -- 加 1 小时
SELECT ADDDATE('2020-09-10', INTERVAL -1 QUARTER);
->2020-06-10 -- 减 1 季度

-- sql 2
SELECT ADDDATE('2020-09-10', INTERVAL '1:2' MINUTE_SECOND);
->2020-09-10 00:01:02 -- 加 1 分 2 秒
SELECT ADDDATE('2020-09-10', INTERVAL '1:0:2' HOUR_SECOND);
->2020-09-10 01:00:02 -- 加 1 小时 2秒
SELECT ADDDATE('2020-09-10', INTERVAL '-1:4:10' HOUR_SECOND);
->2020-09-09 22:55:50 -- 减 1 小时 4 分 10 秒

-- ERROR 负号只能在开头起作用，不能在每一个单位前单独起作用，会统一按照正数计算
SELECT ADDDATE('2020-09-10', INTERVAL '1:4:-10' HOUR_SECOND);
->2020-09-10 01:04:10
```



## MySQL 高级函数

- `IFNULL`  
常用于可能是 null 的字段设置默认值
```sql
SELECT IFNULL(NULL, NOW()) AS `now`;
-> 2020-09-10 16:56:56
```


## 文档
[菜鸟教程 Mysql 函数](https://www.runoob.com/mysql/mysql-functions.html)