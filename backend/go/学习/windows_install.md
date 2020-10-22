# windows 安装 go

### 下载 go
https://golang.google.cn/dl/

### 添加环境变量 `PATH`
```cmd
C:\www\server\go\bin
```

### 更换代理

https://github.com/goproxy/goproxy.cn/blob/master/README.zh-CN.md
```sh
# go env -w GO111MODULE=on
go env -w GO111MODULE=off # 关闭 GO111MODULE
go env -w GOPROXY=https://goproxy.cn,direct
```