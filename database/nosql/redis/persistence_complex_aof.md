# Redis 持久化总结 AOF

`AOF`，`Append Only File`。

- 配置， redis.conf 配置文件的 `APPEND ONLY MODE` 下
    - `appendonly`，默认值是 no。Reids 默认的持久化方式是 `RDB`，如果需要开始 `AOf`，需要改为 yes。
    - `appendfilename`，默认是 appendonly.aof，aof文件名。
    - `appendfsync`，`AOF` 持久化策略的配置。
        - `no` 表示不执行 fsync，由操作系统保证数据同步到磁盘，速度最快，但是不太安全。
        - `always` 表示每次写入都执行 fsync，以保证数据同步到磁盘，效率很低。
        - `everysec` 表示每秒执行一次 fsync，可能会导致丢失这 1s 数据。通常选择 `everysec`，兼顾安全性和效率。
    - `no-appendfsync-on-rewrite`，默认值为 no。在 `AOF` 重写或者写入 `RDB` 文件的时候，会执行大量 IO，此时对于 everysec 和 always 的 `AOF` 模式来说，执行 fsync 会造成阻塞过长时间，no-appendfsync-on-rewrite 字段设置为默认设置为 no。如果对延迟要求很高的应用，这个字段可以设置为 yes，否则还是设置为 no，这样对持久化特性来说这是更安全的选择。设置为 yes 表示 rewrite 期间对新写操作不 fsync,暂时存在内存中,等 rewrite 完成后再写入，默认为 no，建议 yes。Linux 的默认 fsync 策略是 30 秒。可能丢失 30 秒数据。
    - `auto-aof-rewrite-percentage`，默认值为 100。`AOF` 自动重写配置，当目前 aof 文件大小超过上一次重写的 aof 文件大小的百分之多少进行重写，即当 aof 文件增长到一定大小的时候，Redis 能够调用 bgrewriteaof 对日志文件进行重写。当前 aof 文件大小是上次日志重写得到 aof 文件大小的二倍（设置为 100）时，自动启动新的日志重写过程。
    - `auto-aof-rewrite-min-size`, 64mb。设置允许重写的最小 aof 文件大小，避免了达到约定百分比但尺寸仍然很小的情况还要重写。
    - `aof-load-truncated`。aof 文件可能在尾部是不完整的，当 Redis 启动的时候，aof 文件的数据被载入内存。  
    重启可能发生在 Redis 所在的主机操作系统宕机后，尤其在ext4 文件系统没有加上 `data=ordered` 选项，出现这种现象：Redis 宕机或者异常终止不会造成尾部不完整现象，可以选择让 Redis 退出，或者导入尽可能多的数据。  
    如果选择的是 yes，当截断的 aof 文件被导入的时候，会自动发布一个 log 给客户端然后 load。如果是 no，用户必须手动 `redis-check-aof` 修复 aof 文件才可以。默认值为 yes。
    - `dir`。`AOF` 保存文件的位置和 `RDB` 保存文件的位置一样，都是通过 redis.conf 配置文件的 dir 配置。

- 恢复数据  
    重启 Redis 之后就会进行 AOF 文件的载入。  
　　异常修复命令：`redis-check-aof --fix` 进行修复

- `AOF` 重写  
    由于 `AOF` 持久化是 Redis 不断将写命令记录到 aof 文件中，随着 Redis 不断的进行，`AOF` 的文件会越来越大，占用服务器内存越大以及 AOF 恢复要求时间越长。为了解决这个问题，Redis 新增了重写机制，当 aof 文件的大小超过所设定的阈值时，Redis 就会启动 aof 文件的内容压缩，只保留可以恢复数据的最小指令集。可以使用命令 `bgrewriteaof` 来重新。  
    比如如下情况：
    ```sh
    > flashall
    OK
    > sadd languages "php"
    (integer) 1
    > sadd languages "js" "css" "html"
    (integer) 3
    > srem languages "html"
    (integer) 1
    > sadd languages "go" "java"
    (integer) 2
    > sdiff languages
    1) "php"
    2) "js"
    3) "css"
    4) "go"
    5) "java"
    ```
    如果不进行 `rewirte`，那么 aof 文件中将保留 4 条命令，重写后只保留一条命令：
    ```sh
    sadd languages "php" "js" "css" "go" "java"
    ```

    aof 文件重写触发机制：当前大小超过上一次重写后的大小（也就是说默认 Redis 会记录上次重写时的 `AOF` 大小）的 {$`auto-aof-rewrite-min-size`}% 且 aof 文件大小超过 {$`auto-aof-rewrite-min-size`}。  
    我们知道 Redis 是单线程工作，如果重写 `AOF` 需要比较长的时间，那么在重写 `AOF` 期间，Redis 将长时间无法处理其他的命令，这显然是不能忍受的。Redis 为了克服这个问题，解决办法是将 `AOF` 重写程序放到子程序中进行，这样有两个好处：  
        1 子进程进行 `AOF` 重写期间，服务器进程（父进程）可以继续处理其他命令。  
        2 子进程带有父进程的数据副本，使用子进程而不是线程，可以在避免使用锁的情况下，保证数据的安全性。  
    使用子进程解决了上面的问题，但是新问题也产生了：因为子进程在进行 `AOF` 重写期间，服务器进程依然在处理其它命令，这新的命令有可能也对数据库进行了修改操作，使得当前数据库状态和重写后的 aof 文件状态不一致。  
    为了解决这个数据状态不一致的问题，Redis 服务器设置了一个 `AOF` 重写缓冲区，这个缓冲区是在创建子进程后开始使用，当 Redis 服务器执行一个写命令之后，就会将这个写命令也发送到 `AOF` 重写缓冲区。当子进程完成 `AOF` 重写之后，就会给父进程发送一个信号，父进程接收此信号后，就会调用函数将 `AOF` 重写缓冲区的内容都写到新的 aof 文件中。

- 优点
    - `AOF` 持久化的方法提供了多种的同步频率，即使使用默认的同步频率每秒同步一次，Redis 最多也就丢失 1 秒的数据而已。
    - aof 文件使用 Redis 命令追加的形式来构造，因此，即使 Redis 只能向 aof 文件写入命令的片断，使用 `redis-check-aof` 工具也很容易修正 aof 文件。
    - aof 文件的格式可读性较强，这也为使用者提供了更灵活的处理方式。例如，如果我们不小心错用了 `FLUSHALL` 命令，在重写还没进行时，我们可以手工将最后的 `FLUSHALL` 命令去掉，然后再使用 `AOF` 来恢复数据。

- 缺点  
    - 对于具有相同数据的的 Redis，aof 文件通常会比 `RDB` 文件体积更大。
    - 虽然 `AOF` 提供了多种同步的频率，默认情况下，每秒同步一次的频率也具有较高的性能。但在 Redis 的负载较高时，`RDB` 比 `AOF` 具好更好的性能保证。
    - `RDB` 使用快照的形式来持久化整个 Redis 数据，而 `AOF` 只是将每次执行的命令追加到 aof 文件中，因此从理论上说，`RDB` 比 `AOF` 方式更健壮。官方文档也指出，`AOF` 的确也存在一些 BUG，这些 BUG 在 `RDB` 没有存在。


## 其他参考
[https://www.cnblogs.com/ysocean/p/9114268.html#_label1_1](https://www.cnblogs.com/ysocean/p/9114268.html#_label1_1)  
