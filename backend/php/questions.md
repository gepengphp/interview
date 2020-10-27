# 问题

### 一次服务器降配引起的 CPU、内存、IO 跑满的问题
- 问题描述：  
    曾经的服务已经迁移，剩下一台服务器继续跑就服务提供一些支持。但是几乎已经没有访问量了。所以做了降配处理。  
    但是将配置后，CPU、内存、IO 都跑慢了，终端连不上，任何命令都无法分配内存的错误。如：
    ```sh
    $ free
    -bash: fork: Cannot allocate memory
    $ free
    free: error while loading shared libraries: libgcrypt.so.11: failed to map segment from shared object: Cannot allocate memory
    ```
    几乎做不了任何事，只能重启。
- 排查过程：  
    重启后，根据 `top` 命令查看内存占用，发现 php-fpm 进程的内存占用开始上涨，结束 php-fpm 进程后，回复正常。
- 问题分析：  
    原有配置为 8 核 16 G，减配后是 2 核 4 G。但是之前 php-fpm 进程数在减配前是根据压测设置的最大值：动态模式 - 初始启动 700 个 - 最高 2000 个。每个 php-fpm 进程大概占用 60 - 70MB 的内存。在 php-fpm 刚启动时，700 个进程并没有执行任务，所以每个进程占用内存较低，系统资源空闲很多，但后续请求会随机访问任意一个 php-fpm 进程，导致 php-fpm 整体占用的内存越来越多，最终占用全部系统资源。
- 解决办法：  
    修改 php-fpm 配置。
    - 将启动进程数 `start_servers` 调小；
    - 将 `max_requests` 调小，这条没啥用，除非调成 1；
    
