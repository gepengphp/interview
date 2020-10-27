# 安装

### 服务器信息
```sh
$ cat /etc/redhat-release 
CentOS Linux release 7.6.1810 (Core)
```

### 安装过程
```sh
$ cd /soft/
$ wget https://download.redis.io/releases/redis-6.0.8.tar.gz
$ tar zxvf redis-6.0.8.tar.gz
$ cd redis-6.0.8/
$ make
# 安装失败，一大堆错误，百度后说是 gcc 版本过低。
# 重新下载 4.x 版本
$ wget http://download.redis.io/releases/redis-4.0.11.tar.gz # 下载
$ tar zxf redis-4.0.11.tar.gz # 解压
$ cd redis-4.0.11
$ make
$ cd src
$ mkdir /usr/local/redis
$ make install PREFIX=/usr/local/redis
$ cd /usr/local/redis
$ mkdir etc
$ cp /soft/redis-4.0.11/redis.conf etc
$ vi etc/redis.conf
# redis 默认前台启动。修改[daemonize no]为[daemonize yes]
/usr/local/redis/bin/redis-server /usr/local/redis/etc/redis.conf # 启动 redis
```