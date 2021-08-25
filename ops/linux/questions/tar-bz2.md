# tar 解压 bz2，报错：tar (child): lbzip2: Cannot exec: No such file or directory

CentOS 默认没有安装 bzip2 压缩软件，直接使用 tar 解压会报错：
```sh
> tar xvjf x.tar.bz2
tar (child): lbzip2: Cannot exec: No such file or directory 
tar (child): Error is not recoverable: exiting now 
tar: Child returned status 2 
tar: Error is not recoverable: exiting now
```

需要安装 bzip2
```sh
yum -y install bzip2
```
