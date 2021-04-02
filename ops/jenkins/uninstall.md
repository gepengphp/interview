# 卸载 Jenkins

卸载 rpm 安装的 jenkins。   

```sh
# 查找安装的 jenkins
> rpm -qa |grep jenkins
jenkins-2.7.3-1.1.noarch

# 卸载
> rpm -e jenkins-2.7.3-1.1.noarch

# 查找残留文件
> find / -iname jenkins

# 删除残留文件
> find / -iname jenkins | xargs -n 1000 rm -rf
```
