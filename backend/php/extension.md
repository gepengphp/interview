# PHP 扩展安装

## `ext` 目录中的扩展

`ext` 目录中的扩展是 php 自带的扩展，不需要下载，依赖 `phpize` 直接可以编译安装。

统一安装方式：

```sh
# 进入 php 源码 ext 目录
> cd php/ext

# 进入 xx 扩展目录
> cd xx

> phpize
> ./configure --with-php-config=/usr/local/php/bin/php-config --with-xx
> make && make install
```

## `phpize`

## 扩展安装记录
- [snmp](./extension/snmp.md)
- [swoole](./swoole.md)
