# VSCode 提示 “go: go.mod file not found in current directory or any parent directory; see 'go help modules'

解决方案：
```sh
go env -w GO111MODULE=off
```
