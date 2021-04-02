# Java 安装

### 操作系统：
```sh
$ cat /etc/redhat-release 
CentOS Linux release 7.2.1511 (Core)
```

# 安装
- 下载 jdk
    本次安装的是之前下载 `jdk14`：jdk-8u271-linux-x64.tar.gz

- 安装
```sh
# 创建目录
> mkdir /usr/local/java

# 解压安装包到上面目录
> tar -zxvf jdk-8u271-linux-x64.tar.gz -C /usr/local/java/

# 配置环境变量，文件末尾添加如下内容：
# export JAVA_HOME=/usr/local/java/jdk1.8.0_271
# export JRE_HOME=${JAVA_HOME}/jre
# export CLASSPATH=.:${JAVA_HOME}/lib:${JRE_HOME}/lib
# export PATH=${JAVA_HOME}/bin:$PATH
> vi /etc/profile

# 使环境变量生效
> source /etc/profile

# 创建软链
> ln -s /usr/local/java/jdk1.8.0_271/bin/java /usr/bin/java

# 检查
> java -version
java version "1.8.0_271"
Java(TM) SE Runtime Environment (build 1.8.0_271-b09)
Java HotSpot(TM) 64-Bit Server VM (build 25.271-b09, mixed mode)
```
