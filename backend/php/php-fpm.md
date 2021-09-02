# php -m与网页访问phpinfo() 展示扩展信息不一致

环境
- CentOS8
- PHP7.2.23
- OpenResty

因为通过安装包方式安装PHP时没有安装pdo_mysql扩展，于是我尝试单独安装扩展，安装过程很顺利，但是"phpinfo()"中就是看到不到扩展信息。

并且“php -m”中也不显示对应的扩展信息，起初怀疑是因为php.ini中没有增加extension=pdo_mysql.so导致，
但是加上之后php-fpm启动报错，经google查询不解决问题（在这点花了比较多时间）。

然后干脆重装PHP，期望通过“./configrue”过程直接安装相应扩展，重装后“神奇现象”出现了：“php -m”中显示了pdo_mysql扩展，但是"phpinfo()"中依然不显示。

这时我只能怀疑是php-pfm的问题了。

于是全盘扫描php-fpm执行文件
```php
[root@mypc ~]# find / -name php-fpm -type f
/usr/local/bin/php-fpm
/usr/local/sbin/php-fpm
/opt/php-7.2.23/sapi/fpm/php-fpm
```

发现有3个php-fpm文件，/usr/local/bin/php-fpm 这个是我一直在用的。
注意，/opt/php-7.2.23 是我的php安装包目录，既然有多个，是不是我运行错了呢？而且显示我应该运行我安装包中的。

理所当然的，/opt/php-7.2.23/sapi/fpm/php-fpm启动后，"phpinfo()" 与 “php -m”里的扩展信息一致了！


总结

当我第一次单独安装扩展时，安装包中的php文件和php-fpm文件都发送了变化，但是/usr/local/bin/中的php文件和php-fpm文件未被覆盖。
所以“php -m”和"phpinfo()"都不显示新扩展。

当我重新安装PHP的时候，/usr/local/bin/中的php文件被覆盖了，但是php-fpm文件没变，所以“php -m”中有新扩展，而"phpinfo()"没有。

php-fpm文件生成时php包含哪些扩展，已经写在php-fpm文件中了，新添加扩展会覆盖安装包中的php-fpm文件，但是不会覆盖/usr/local/bin/中的。
所以我再怎么重启 /usr/local/bin/php-fpm，"phpinfo()"中就是没啥变化。（这里是这次主要的坑）


解决方案
每次动态安装扩展后，手动覆盖你要执行的php-fpm文件；或者每次直接执行安装包中的php-fpm文件。


