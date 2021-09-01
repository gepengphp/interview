# CGI

`CGI`（Common Gateway Interface）通用网关接口。

`CGI` 是 Web 服务器和一个独立的进程之间的协议，它会把 HTTP 请求 Request 的 Header 头设置成进程的环境变量，HTTP 请求的 Body 正文设置成进程的标准输入，进程的标准输出设置为 HTTP 响应 Response，包含 Header 头和 Body 正文。


对于一个 `CGI` 程序，主要的工作是从环境变量和标准输入中读取数据，然后处理数据，最后向标准输出中输出数据。

环境变量
环境变量中存储的叫做 `Request Meta-Variables`，也就是诸如 `QUERY_STRING`、`PATH_INFO` 之类的，这些都是由 Web 服务器通过环境变量传递给 `CGI` 程序的，`CGI` 程序也是从环境变量中读取的。
标准输出
中存放的往往是用户通过 PUTS 或 POST 提交的数据，这些数据也是由 Web 服务器传递过来的。

// todo 需要整理，CGI的工作内容包括什么，与nginx、apache的环境变量之间有哪些关系，如PATH_INFO、QUERY_STRING、HEADER等常用变量

### 参考
[https://www.jianshu.com/p/c4dc22699a42](https://www.jianshu.com/p/c4dc22699a42)