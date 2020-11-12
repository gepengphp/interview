# Centos 7 自带 git 升级

自带的 git 版本 `1.8.3.1`。

```sh
> cat /etc/centos-release # 查看 Linux 发行版
CentOS Linux release 7.4.1708 (Core) 
> git --version # 查看版本号
git version 1.8.3.1
```

### 升级
```sh
> yum remove git # 删除
> yum install -y curl-devel expat-devel gettext-devel openssl-devel zlib-devel asciidoc xmlto perl-devel perl-CPAN autoconf* # 准备安装
> cd /soft
> wget https://github.com/git/git/archive/v2.29.2.zip # 找到最新的发行版本，下载
> unzip v2.29.2.zip
> cd git-2.29.2/
> make configure
GIT_VERSION = 2.29.2
    GEN configure
> ./configure --prefix=/usr/local/git --with-iconv=/usr/local/lib/libiconv
> make all doc
> make install install-doc install-html
> echo "export PATH=$PATH:/usr/local/git/bin" >> /etc/bashrc
> source /etc/bashrc
```

> 注意：执行 `git --version` 后如果还是老版本，可能是因为 `/usr/bin/` 目录中存在原 `git` 命令文件，需要删除后重新执行 `source /etc/bashrc`
