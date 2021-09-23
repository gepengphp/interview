# Swoole

[官网](https://www.swoole.com/)

## 安装

CenotOS7、PHP7.4、lnmp脚本安装环境

找到指定的[版本](https://github.com/swoole/swoole-src/releases)，下载。   

```sh
# 下载4.5.6版本
> wget https://github.com/swoole/swoole-src/archive/refs/tags/v4.5.6.zip
> unzip swoole-src-master.zip
> cd swoole-src-master

# 编译扩展
> /usr/local/php/bin/phpize
> ./configure --with-php-config=/usr/local/php/bin/php-config
> make
> make install
# 省略编译过程，编译完成：
----------------------------------------------------------------------
Libraries have been installed in:
   /soft/swoole-src-master/modules

If you ever happen to want to link against installed libraries
in a given directory, LIBDIR, you must either use libtool, and
specify the full pathname of the library, or use the '-LLIBDIR'
flag during linking and do at least one of the following:
   - add LIBDIR to the 'LD_LIBRARY_PATH' environment variable
     during execution
   - add LIBDIR to the 'LD_RUN_PATH' environment variable
     during linking
   - use the '-Wl,--rpath -Wl,LIBDIR' linker flag
   - have your system administrator add LIBDIR to '/etc/ld.so.conf'

See any operating system documentation about shared libraries for
more information, such as the ld(1) and ld.so(8) manual pages.
----------------------------------------------------------------------

Build complete.
Don t forget to run 'make test'.

> mv /soft/swoole-src-master/modules/swoole.so /usr/local/php/lib/php/extensions/no-debug-non-zts-20190902
> vi /usr/local/php/conf.d/swoole.ini
# 输入 extension = "swoole.so"

# 查看扩展
> php --ri swoole

swoole

Swoole => enabled
Author => Swoole Team <team@swoole.com>
Version => 4.7.2-dev
Built => Sep 23 2021 10:57:48
coroutine => enabled with boost asm context
epoll => enabled
eventfd => enabled
signalfd => enabled
cpu_affinity => enabled
spinlock => enabled
rwlock => enabled
pcre => enabled
zlib => 1.2.7
mutex_timedlock => enabled
pthread_barrier => enabled
futex => enabled
async_redis => enabled

Directive => Local Value => Master Value
swoole.enable_coroutine => On => On
swoole.enable_library => On => On
swoole.enable_preemptive_scheduler => Off => Off
swoole.display_errors => On => On
swoole.use_shortname => On => On
swoole.unixsock_buffer_size => 8388608 => 8388608
```
