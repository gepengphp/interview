# 服务端配置

### 业务需求描述
`CUCM CallManager` 服务端日志可以通过 `syslog` 方式推送到指定服务器，然后通过 `syslog` 读取 `CUCM` 日志信息。   

### 环境
系统：`CentOS7`   。`CentOS7` 自带 `rsyslog`，直接配置就可以使用。

### 配置
```sh
# 修改配置
> vi /etc/rsyslog.conf
# line 15. 取消以下两行注释，打开 udp syslog 接口端口
# $ModLoad imudp
# $UDPServerRun 514
# line 19. 取消以下两行注释，打开 tcp syslog 接口端口
# $ModLoad imtcp
# 20 $InputTCPServerRun 514

# 修改启动参数
> vi /etc/sysconfig/rsyslog
# SYSLOGD_OPTIONS="-r -m 0"
# -r 选项可接受其它主机的日志信息

# 重启
> systemctl restart rsyslog

# 查看 rsyslog 进程
> ps -ef |grep rsyslog
root      50563      1  0 15:24 ?        00:00:00 /usr/sbin/rsyslogd -n -r -m 0
root      51056 129089  0 15:26 pts/3    00:00:00 grep --color=auto rsyslog

# 查看 514 端口
> netstat -nao |grep 514
tcp      0   0 0.0.0.0:514     0.0.0.0:*     LISTEN      off (0.00/0/0)
```

> **注意**：经测试，`CUCM` 发送 `syslog` 使用的是 `UDP` 协议，关闭 `TCP Mod` 也可以接收日志。

// todo 补全以下内容
### 日志级别
### 存储位置
### 存储方式
### 子系统
### 动作
### 日志滚动

### 参考
[https://www.cnblogs.com/long-cnblogs/p/10497321.html](https://www.cnblogs.com/long-cnblogs/p/10497321.html)   
[https://www.cnblogs.com/skyofbitbit/p/3674664.html](https://www.cnblogs.com/skyofbitbit/p/3674664.html)   
[https://www.cnblogs.com/hanyifeng/p/5463338.html](https://www.cnblogs.com/hanyifeng/p/5463338.html)   
