# 安装

操作系统：CentOS 7
> 注意：如果没有网络，需要提前准备依赖。

### 安装依赖
```sh
yum install -y subversion autoconf automake libtool gcc-c++
yum install -y ncurses-devel make libtiff-devel libjpeg-devel
```

### 最快安装（推荐）
```sh
wget http://www.freeswitch.org/eg/Makefile && make install
```

### 从 Git 仓库安装
```sh
git clone git://git.freeswitch.org/freeswitch.git
cd freeswitch
./bootstrap.sh
./configure
make install
```

### 解压源码包安装
此次安装用的这个
```sh
> wget http://files.freeswitch.org/freeswitch-1.2.rc2.tar.bz2
> tar xvjf http://files.freeswitch.org/freeswitch-1.2.rc2.tar.bz2
> cd freeswitch-1.2
> ./configure

# 编译报错，还是缺少了一个相关依赖
# no usable zlib; please install zlib devel package or equivalent
yum install -y zlib-devel

# ↓↓↓ 编译成功
Registering you for ClueCon http://www.cluecon.com ..... See you in August. ;-)


-------------------------- FreeSWITCH configuration --------------------------

  Locations:
      Selected layout: 

      prefix:          /usr/local/freeswitch
      exec_prefix:     ${prefix}
      bindir:          ${exec_prefix}/bin
      libdir:          ${exec_prefix}/lib
      modulesdir:      /usr/local/freeswitch/mod
      sysconfdir:      /usr/local/freeswitch/conf
      runtimedir:      /usr/local/freeswitch/run
      logfiledir:      /usr/local/freeswitch/log

------------------------------------------------------------------------------
# ↑↑↑ 编译成功

> make install

# make 过程中报错
# libs/esl/src/esl.c:573:27: error: argument to ‘sizeof’ in ‘snprintf’ call is the same expression as the destination; did you mean to provide an explicit length

```

### 参考
[1 FreeSWITCH 中文文档](http://www.dujinfang.com/2010/04/14/freeswitch-chu-bu.html)   
[2 CentOS 7.2安装配置 FreeSwitch X-Lite](https://www.linuxidc.com/Linux/2017-04/143229.htm)，这篇文章编译时报错比较全。   

### 附录
摘自参考 2 中，其他报错，以防网站删除。   

此次安装过程中，以下错误只遇到了第 2 个，其他依赖均以在编译前安装完成。
```sh
# 1. The C++ compiler does not work. Please (re)install the C++ compiler
> yum install gcc-c++
# 2. no usable zlib; please install zlib devel package or equivalent
> yum install zlib-devel
# 3. Library requirements (sqlite3 >= 3.6.20) not met;
> yum install sqlite-devel
# 4. Library requirements (libcurl >= 7.19) not met;
> yum install curl-devel
# 5. Library requirements (libpcre >= 7.8) not met;
> yum install pcre-devel
# 6. Library requirements (speex >= 1.2rc1 speexdsp >= 1.2rc1) not met;
> yum install speex-devel
# 7. You need to either install libldns-dev or disable mod_enum in modules.conf
> yum install ldns-devel
# 8. You need to either install libedit-dev (>= 2.11) or configure with –disable-core-libedit-support
> yum install libedit-devel
# 9. OpenSSL >= 1.0.1e and associated developement headers required
> yum install openssl-devel
```

// todo 没装完，下次从新来