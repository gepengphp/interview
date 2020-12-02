# Swagger

### 安装
```sh
$ npm install -g http-server
$ wget https://github.com/swagger-api/swagger-editor/releases/download/v2.10.4/swagger-editor.zip
$ unzip swagger-editor.zip
$ mv swagger-editor /home/wwwroot/node/
$ http-server swagger-editor -p 8081 # 指定端口
```
报错： http-server command not found
```sh
$ npm root -g # 查看 node_modules 目录
/usr/local/node/lib/node_modules
# 添加 /usr/local/node/lib/node_modules/http-server/bin 目录到环境变量
vi /etc/profile
source /etc/profile
```

### 资源
[官网](https://swagger.io/)  
