# 坑

# UPDATE SET
更新字段使用 “,” 分隔，如果误操作，使用 “AND” 分隔，可能造成严重后果。   
```sql
-- 查看原内容
> SELECT id, column1, column2 FROM `table` WHERE id=1;
+-------+-------+-------+
| 6     | foo1  | foo2  |
+-------+-------+-------+

> UPDATE `table` SET `column1`='11' AND `column2`='22' WHERE id=1;
共 1 行受到影响

-- 查看执行后的内容
> SELECT id, column1, column2 FROM `table` WHERE id=1;
+-------+-------+-------+
| 6     | 0     | foo2  |
+-------+-------+-------+

> UPDATE `table` SET `column1`='11' AND `column2`='foo2' WHERE id=1;
共 1 行受到影响

-- 查看执行后的内容
> SELECT id, column1, column2 FROM `table` WHERE id=1;
+-------+-------+-------+
| 6     | 1     | foo2  |
+-------+-------+-------+
```
> **原因**：使用 “AND” 时，mysql 语法解释器将 `'11' AND `column2`='22'` 作为一个表达式，将表达式的结果更新给了字段 `column1`，决定 `column1` 结果的是 `AND` 两边的条件。
