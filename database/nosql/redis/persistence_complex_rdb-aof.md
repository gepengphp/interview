# RDB-AOF 混合持久化

Redis 4.0 之后，新增了 `RDB-AOF` 混合持久化方式。  
这种方式结合了 `RDB` 和 `AOF` 的优点，既能快速加载又能避免丢失过多的数据。

具体配置为：`aof-use-rdb-preamble`。设置为 yes 表示开启，设置为 no 表示禁用。

当开启混合持久化时，主进程先 fork 出子进程将现有内存副本全量以 `RDB` 方式写入 aof 文件中，然后将缓冲区中的增量命令以 `AOF` 方式写入 aof 文件中，写入完成后通知主进程更新相关信息，并将新的含有 `RDB` 和 `AOF` 两种格式的 aof 文件替换旧的 aof 文件。

简单来说：混合持久化方式产生的文件一部分是 `RDB` 格式，一部分是 `AOF` 格式。

这种方式优点我们很好理解，缺点就是不能兼容 Redis4.0 之前版本的备份文件了。

## 参考
[https://www.cnblogs.com/ysocean/p/9114267.html](https://www.cnblogs.com/ysocean/p/9114267.html)