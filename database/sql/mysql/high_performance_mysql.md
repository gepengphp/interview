# 高性能 MySQL （第三版）

《高性能 MySQL （第三版）》读书笔记

- 1.1 [MySQL 逻辑架构](#1.1)

## 第一章
### [1.1 MySQL 逻辑架构](1.1)

![MySQL 服务器逻辑架构图](../../../asset/imgs/mysql_logical_architecture_diagram.jpg)

大部分 MySQL 比较有意思的部分，都在第二层，包括：查询解析、分析、优化、缓存以及所有有的内置函数，所有跨存储引擎的功能都在这一层：存储过程、触发器、视图。