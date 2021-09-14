# SNMP 扩展安装

CentOS7、php7.2.14、lnmp.sh 安装的环境

## 安装过程

```sh
> cd /soft/lnmp1.7/src/php-7.4.12/ext/snmp/
> /usr/local/php/bin/phpize
# 这个时候会在当前目录中生成 configure 执行文件
> ./configure --with-php-config=/usr/local/php/bin/php-config --with-snmp
# 编译时需要填写一些 snmp 默认配置信息，其中最主要的是 snmp 的默认协议
> make && make install
> vi /usr/local/php/conf.d/snmp.ini
# 输入 extension = snmp.so
```
