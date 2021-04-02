# 无法 `su` 切换 `jenkins` 用户的问题

`jenkins` 安装后不能切换到 `jenkins` 用户，导致远端 `ssh` 认证等无法实现。  

`cat /etc/passwd` 发现 `jenkins`用户被设置为了/bin/false。  

```sh
$ cat /etc/passwd
jenkins:x:989:987:Jenkins Continuous Integration Server:/var/lib/jenkins:/bin/false

# 修改 /bin/false 为 /bin/bash
$ vi /etc/passwd

# 再次切换用户到 jenkins，发现用户切换到“bash-4.2”
$ su jenkins

# 编辑用户环境变量，加入：export PS1='[\u@\h \W]\$'
$ vi ~/.bash_profile

# 环境变量生效
$ source ~/.bash_profile
```