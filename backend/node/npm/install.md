# NPM 安装

### 官网下载
官网下载[地址](https://nodejs.org/en/download/)  

### 安装过程
```sh
> cd /soft
> wget https://nodejs.org/dist/v14.15.0/node-v14.15.0-linux-x64.tar.xz
> tar -xvf node-v14.15.0-linux-x64.tar.xz
> mkdir /usr/local/node
> mv node-v10.14.1-linux-x64/* /usr/local/node
> vi /etc/bashrc # 添加目录【/usr/loca/node/bin】到 PATH 变量
> source /etc/bashrc # 环境变量生效（当前会话）
> node -v
v14.15.0
> npm -v
6.14.8
```

### 修改镜像源
```sh
> npm get registry # 查看镜像源
https://registry.npmjs.org/ # 原源
> npm config set registry https://registry.npm.taobao.org # 切换阿里镜像源
> npm get registry
https://registry.npm.taobao.org/ # 阿里源
```
