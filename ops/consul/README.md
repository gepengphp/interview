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
$ /usr/local/consul/consul

# dev 模式启动，查看 http://virtualhost:8500/ui/dc1/services
$ ./consul agent -dev -ui -client 0.0.0.0
```


### ~~设置配置文件~~
~~配置文件项参照 [consul.io/docs/agent/options#configuration_files](https://www.consul.io/docs/agent/options#configuration_files)~~ 
> 注意：这段暂时没用了，因为【集群搭建中已经使用 shell 的方式编写启动脚本，并 `动态获取` 启动参数，相较配置文件更加灵活，但是以下配置是经过验证的，暂时保留，具有参考意义】 。

```sh
$ mkdir /usr/local/consul/config
$ echo '{
  "datacenter": "ipt-dev",
  "data_dir": "/usr/local/consul/data",
  "bootstrap_expect": 1,
  "bind_addr": "127.0.0.1",
  "client_addr": "0.0.0.0",
  "log_file": "/usr/local/consul/log/consul_log",
  "log_level": "INFO",
  "node_name": "ipt-dev-181:8500",
  "server": true,
  "ports": {
    "http": 8500
  },
  "ui_config": {
    "enabled": true
  }
}
' > /usr/local/consul/config/8500.json
#启动命令可以简化为
/usr/local/consul/consul agent -file-config=/usr/local/consul/config/8500.json
```

### 集群搭建
集群分为 server、client 端。目前测试环境机器有限，所以单机上部署了多个应用，consul 的 server 和 client 也部署同一台机器上。

- consul 安装
```sh
$ wget https://releases.hashicorp.com/consul/1.9.1/consul_1.9.1_linux_amd64.zip
$ unzip consul_1.9.1_linux_amd64.zip
$ mkdir /usr/local/consul
$ mv consul /usr/local/consul/
$ ln -s /usr/local/consul/consul /usr/bin/
$ consul -v
```

- 添加 server 端系统服务
```sh
# 添加服务，文件内容见 附 1
$ vi /etc/systemd/system/consul-server.service
# 添加启动脚本，脚本内容见 附 2
$ vi /usr/local/consul/consul-server.start.sh
# 提前创建 server 配置文件夹，consul 的 data 目录可以随服务自行创建，但 config 目录需要手动创建
$ mkdir /usr/local/consul/server.d
# 编写 consul server 配置文件，文件内容见 附 3
$ vi /usr/local/consul/server.d/server.ini
# 设置 consul server 服务自启动
$ systemctl enable consul-server.service
# 启动 consul server
$ systemctl start consul-server.service
```

> 在安装过程中出现如下问题需要注意：  
> - 从节点需要添加 `-join={leaderIP}` 参数，使其加入集群。  
> - 报错：Failed to join 192.168.125.118: Member 'server1' has conflicting node ID 'b76ff298-accd-05ff-8c64-5d79d866dfa9' with this agent's ID  
>   因为从模板中创建的机器，已经存在 `node id`，需要删除后重启服务。如果还不行，添加 `-node-id=$(uuidgen | awk '{print tolower($0)}')` 参数也是一个办法，但是最后采用的是在配置文件中指定一个 UUID。
> - 如果 node id 更换，因集群会记住更换前的 id，导致抛出多余的警告日志。
> - `-node` 参数直接使用机器 `hostname`，所以需要注意设置个机器 `hostname`。
> - 当前集群数量是 `3`，但测试中发现集群中挂掉两个节点时，集群不可用，是否扩容到 5 台。

- 添加 client 端系统服务
```sh
$ mkdir /usr/local/consul/client.d
// todo 2021-01-21 停在这里
$ 
```

### 附
- 1 consul systemd 服务注册
```
[Unit]
Description=Iot iaas consul server
Wants=network-online.target
After=network-online.target

[Service]
ExecStart=/usr/local/consul/consul-server.start.sh
Restart=always
RestartSec=10

[Install]
WantedBy=multi-user.target
```

- 2 consul server 启动脚本
```
#!/bin/sh

BASE_PATH=$(cd `dirname $0`;pwd)
INI_PATH=$BASE_PATH/server.d/server.ini
LEADER=`cat $INI_PATH | sed '/^leader=/!d;s/.*=//'`

if [ -n $LEADER ]; then
    JOIN=""
else
    JOIN="-join ${LEADER}"
fi

/usr/bin/consul agent -server -ui \
-bootstrap-expect=3 \
-node=$(echo `hostname`) \
-node-id=$(cat $BASE_PATH/server.d/server.ini | sed '/^uuid=/!d;s/.*=//') \
-bind=$(ifconfig ens33 | grep 'inet ' | cut -d ' ' -f 10) \
-client=0.0.0.0 \
-config-dir=$BASE_PATH/server.d \
-data-dir=/usr/local/consul/data
```

- 3 consul server 配置文件
```
# 节点 UUID，每个节点 UUID 不能冲突，否则无法加入集群。UUID 最好不要发生变化，consul 集群会保留之前的节点 UUID，如果变化会产生不必要的 WARN 日志
uuid=22222222-49ad-41e1-b2b2-222222222222
# 集群 Leader IP 地址，Leader 节点不需要配置，非 Leader 节点必须配置，否则无法加入集群
leader=192.168.3.101
```


### 参考
[https://www.tizi365.com/archives/501.html](.https://www.tizi365.com/archives/501.html)  
[https://blog.csdn.net/liuzhuchen/article/details/81913562](https://blog.csdn.net/liuzhuchen/article/details/81913562)  
[https://blog.csdn.net/liuzhuchen/article/details/81913562](https://blog.csdn.net/liuzhuchen/article/details/81913562)  
[https://studygolang.com/articles/22531?fr=sidebar](https://studygolang.com/articles/22531?fr=sidebar)  
[https://segmentfault.com/a/1190000015751859](https://segmentfault.com/a/1190000015751859)  
[https://zhuanlan.zhihu.com/p/122340918](https://zhuanlan.zhihu.com/p/122340918)  
