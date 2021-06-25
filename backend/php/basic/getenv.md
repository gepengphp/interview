# `getenv`

`getenv`、`setenv` 函数都是非线程安全的。  
在 Apache 服务下都可能产生安全问题，如：
- 获取不到环境变量；
- 部署多个项目获取到另一个项目的环境变量；
Apache 使用线程处理请求，当一个进程同时有几个线程的时候，就比较容易发生「串值」的情况。
nginx + PHP-FPM 没有影响，nginx 通过 fpm 处理 PHP 请求，进程间相互独立。
CLI 模式同理不受影响。
> **建议**：在 Apache 环境下尽量避免使用 `getenv`、`setenv` 函数，如 Laravel 框架部署时执行 `php artisan config:cache` 对配置文件进行缓存。
