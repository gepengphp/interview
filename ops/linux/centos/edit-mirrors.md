# 修改 CentOS 镜像源

```sh
# 先安装 wget
> yum install wget -y

> cd /etc/yum.repos.d/
# 备份镜像源
> mv CentOS-Base.repo CentOS-Base.repo.backup
# 下载 163 镜像源
> wget http://mirrors.163.com/.help/CentOS7-Base-163.repo
# 生成缓存
> yum makecache
# 更新镜像源
> yum -y update
```