# Twemproxy

一个快速的单线程代理程序，支持 Memcached ASCII协议和更新的Redis协议。它全部用C写成，使用Apache 2.0 License授权。项目在Linux上可以工作，而在OSX上无法编译，因为它依赖了epoll API.   

特性：   

- 速度快

- 轻量级

- 维护持久的服务器连接

- Keeps connection count on the backend caching servers low.

- 启用请求和响应的管道

- 支持代理到多个服务器

- 同时支持多个服务器池

- 多个服务器自动分享数据

- 实现了完整的 memcached ascii 和 redis 协议.

- 服务器池配置简单，通过一个 YAML 文件即可

- Supports multiple hashing modes including consistent hashing and distribution.

- 可配置在失败时禁用某个节点

- Observability through stats exposed on stats monitoring port.

- 支持 Linux, *BSD, OS X and Solaris (SmartOS)
