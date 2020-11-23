# 找不到 java 运行环境

找不到 java，或者 java 版本过低都可能导致 jenkins 服务启动失败。

```sh
$ systemctl status jenkins.service
● jenkins.service - LSB: Jenkins Continuous Integration Server
   Loaded: loaded (/etc/rc.d/init.d/jenkins; bad; vendor preset: disabled)
   Active: failed (Result: exit-code) since 一 2020-11-23 18:46:42 CST; 8s ago
     Docs: man:systemd-sysv-generator(8)
  Process: 106537 ExecStart=/etc/rc.d/init.d/jenkins start (code=exited, status=1/FAILURE)

11月 23 18:46:42 kaifa-1 systemd[1]: Starting LSB: Jenkins Continuous Integration Server...
11月 23 18:46:42 kaifa-1 runuser[106538]: pam_unix(runuser:session): session opened for user jenkins by (uid=0)
11月 23 18:46:42 kaifa-1 jenkins[106537]: Starting Jenkins bash: /usr/bin/java: 没有那个文件或目录
11月 23 18:46:42 kaifa-1 runuser[106538]: pam_unix(runuser:session): session closed for user jenkins
11月 23 18:46:42 kaifa-1 jenkins[106537]: [失败]
11月 23 18:46:42 kaifa-1 systemd[1]: jenkins.service: control process exited, code=exited status=1
11月 23 18:46:42 kaifa-1 systemd[1]: Failed to start LSB: Jenkins Continuous Integration Server.
11月 23 18:46:42 kaifa-1 systemd[1]: Unit jenkins.service entered failed state.
11月 23 18:46:42 kaifa-1 systemd[1]: jenkins.service failed.
```

```sh
$ journalctl -xe
11月 23 18:38:23 kaifa-1 polkitd[1135]: Registered Authentication Agent for unix-process:105605:109563233 (system bus name :1.836 [/usr/bin/pkttyagent --notify-fd 5 --fallback], object path /or
11月 23 18:38:23 kaifa-1 systemd[1]: Starting LSB: Jenkins Continuous Integration Server...
11月 23 18:38:23 kaifa-1 runuser[105612]: pam_unix(runuser:session): session opened for user jenkins by (uid=0)
11月 23 18:38:23 kaifa-1 jenkins[105611]: Starting Jenkins bash: /usr/bin/java: 没有那个文件或目录
11月 23 18:38:23 kaifa-1 runuser[105612]: pam_unix(runuser:session): session closed for user jenkins
11月 23 18:38:23 kaifa-1 jenkins[105611]: [失败]
11月 23 18:38:23 kaifa-1 systemd[1]: jenkins.service: control process exited, code=exited status=1
11月 23 18:38:23 kaifa-1 systemd[1]: Failed to start LSB: Jenkins Continuous Integration Server.
11月 23 18:38:23 kaifa-1 systemd[1]: Unit jenkins.service entered failed state.
11月 23 18:38:23 kaifa-1 systemd[1]: jenkins.service failed.
11月 23 18:38:23 kaifa-1 polkitd[1135]: Unregistered Authentication Agent for unix-process:105605:109563233 (system bus name :1.836, object path /org/freedesktop/PolicyKit1/AuthenticationAgent,
```

`Starting Jenkins bash: /usr/bin/java: 没有那个文件或目录`
安装 java 后，添加到 jenkins 配置文件中的候选启动 java 启动文件目录。
```sh
$ vi /etc/init.d/jenkins # 找到 candidates，添加 /usr/local/java/jdk1.8.0_271/bin/java
$ systemctl daemon-reload # 重新加载配置
```
