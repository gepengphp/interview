# 安装 Jenkins

### rmp 安装
```sh
wget http://pkg.jenkins-ci.org/redhat-stable/jenkins-2.7.3-1.1.noarch.rpm -c
rpm -ivh jenkins-2.7.3-1.1.noarch.rpm
vi /etc/sysconfig/jenkins 
```

### 配置
```sh
$ service jenkins status
● jenkins.service - LSB: Jenkins Continuous Integration Server
   Loaded: loaded (/etc/rc.d/init.d/jenkins; bad; vendor preset: disabled)
   Active: active (exited) since 一 2020-11-23 19:14:34 CST; 36s ago
     Docs: man:systemd-sysv-generator(8)
  Process: 109952 ExecStop=/etc/rc.d/init.d/jenkins stop (code=exited, status=0/SUCCESS)
  Process: 109974 ExecStart=/etc/rc.d/init.d/jenkins start (code=exited, status=0/SUCCESS)

11月 23 19:14:33 kaifa-1 systemd[1]: Starting LSB: Jenkins Continuous Integration Server...
11月 23 19:14:33 kaifa-1 runuser[109975]: pam_unix(runuser:session): session opened for user jenkins by (uid=0)
11月 23 19:14:34 kaifa-1 runuser[109975]: pam_unix(runuser:session): session closed for user jenkins
11月 23 19:14:34 kaifa-1 jenkins[109974]: Starting Jenkins [  确定  ]
11月 23 19:14:34 kaifa-1 systemd[1]: Started LSB: Jenkins Continuous Integration Server.
```

根据启动文件 `/etc/rc.d/init.d/jenkins` 找到配置文件
```sh
$ vi /etc/rc.d/init.d/jenkins
```
`# Check for existence of needed config file and read it
JENKINS_CONFIG=/etc/sysconfig/jenkins`


修改配置文件 `/etc/sysconfig/jenkins`，修改监听域名和端口。
