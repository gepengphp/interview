# Consul

[Consul 官网下载](./https://www.consul.io/downloads.html)  

### 安装过程
```sh
$ cd /soft

# 下载
$ wget https://releases.hashicorp.com/consul/1.9.1/consul_1.9.1_linux_amd64.zip

# 解压
$ unzip consul_1.9.1_linux_amd64.zip

# 拷贝
$ mkdir /usr/local/consul
$ mv consul /usr/local/consul

# 查看是否安装成功
$ cd /usr/local/consul
$ ./consul
Usage: consul [--version] [--help] <command> [<args>]

Available commands are:
    acl            Interact with Consul's ACLs
    agent          Runs a Consul agent
    catalog        Interact with the catalog
    config         Interact with Consul's Centralized Configurations
    connect        Interact with Consul Connect
    debug          Records a debugging archive for operators
    event          Fire a new event
    exec           Executes a command on Consul nodes
    force-leave    Forces a member of the cluster to enter the "left" state
    info           Provides debugging information for operators.
    intention      Interact with Connect service intentions
    join           Tell Consul agent to join cluster
    keygen         Generates a new encryption key
    keyring        Manages gossip layer encryption keys
    kv             Interact with the key-value store
    leave          Gracefully leaves the Consul cluster and shuts down
    lock           Execute a command holding a lock
    login          Login to Consul using an auth method
    logout         Destroy a Consul token created with login
    maint          Controls node or service maintenance mode
    members        Lists the members of a Consul cluster
    monitor        Stream logs from a Consul agent
    operator       Provides cluster-level tools for Consul operators
    reload         Triggers the agent to reload configuration files
    rtt            Estimates network round trip time between nodes
    services       Interact with services
    snapshot       Saves, restores and inspects snapshots of Consul server state
    tls            Builtin helpers for creating CAs and certificates
    validate       Validate config files/directories
    version        Prints the Consul version
    watch          Watch for changes in Consul

# 启动，查看 http://virtualhost:8500/ui/dc1/services
$ ./consul agent -dev -ui -client 0.0.0.0
```

### 加入开启自启动
```sh
# 添加到 systemctl 服务，其中 ExecStart 是启动脚本，放到 console 所在目录
$ echo '[Unit]
Description=consul-service

After=network.target

[Service]
Type=forking
PIDFile=/run/consul-service.pid
ExecStart=/usr/local/consul/consul.start.sh
ExecReload=/bin/kill -SIGHUP $MAINPID
ExecStop=/bin/kill -SIGINT $MAINPID

[Install]
WantedBy=multi-user.target graphical.target
'> /usr/lib/systemd/system/consul.service

# 添加启动脚本
$ echo '#!/bin/bash
/usr/local/consul/consul agent -server -bootstrap-expect 1 -node=ipt-1 -data-dir=/usr/local/consul/data/ -log-file=/usr/local/consul/log/consul_log-$(date +%Y-%m-%d--%H-%M) -bind=127.0.0.1 -client=0.0.0.0 -ui
' > /usr/local/consul/consul.start.sh

# 创建日志保存目录
$ mkdir -p /usr/local/consul/log

# 启用服务
$ systemctl enable consul.service

# 启动服务
$ systemctl start consul

# 关闭服务
$ systemctl stop consul
```


然后就是集群配置，了解 consul 参数后继续。

### 参考
[https://www.tizi365.com/archives/501.html](.https://www.tizi365.com/archives/501.html)  
[https://blog.csdn.net/liuzhuchen/article/details/81913562](https://blog.csdn.net/liuzhuchen/article/details/81913562)  
[https://blog.csdn.net/liuzhuchen/article/details/81913562](https://blog.csdn.net/liuzhuchen/article/details/81913562)  
[https://studygolang.com/articles/22531?fr=sidebar](https://studygolang.com/articles/22531?fr=sidebar)  
[https://segmentfault.com/a/1190000015751859](https://segmentfault.com/a/1190000015751859)  
[https://zhuanlan.zhihu.com/p/122340918](https://zhuanlan.zhihu.com/p/122340918)  
