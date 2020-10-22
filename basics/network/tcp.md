# TCP/IP 协议

TCP/IP 协议是一个面向链接的的安全可靠的传输协议。三次握手的机制是为了保证能建立一个安全可靠的链接。

### 三次握手
建立连接需要三次握手。

TCP 报文结构：
![tcp_ip](./asset/tcp_protocol.jpg)
名词解释：  
- 源端口号。16位，两个字节，取值范围 0 ~ 65535。  
- 目标端口号。16位，两个字节，取值范围 0 ~ 65535。  
- 序号。32位。

|  客户端 |   | 服务端 |
| - | - | - |
| Closed |  | Closed |
|  |  | Listen |
| 第一次握手<br>客户端发起 | ---------------><br>SYN=1,seq=x |  |
| SYN_SENT |  |  |
|  | <---------------<br>SYN=1,ACK=1<br>ack=x=1,seq=y | 第二次握手<br>服务端发送应答给客户，<br>表示服务端能收到客户端信息。 |
|  |  |  SYS_RCVD |
| 第三次握手<br>客户端收到服务端应答，<br>给服务端回复应答，<br>表示能够收到服务端信息。 | ---------------><br>ACK=1,seq=y+1<br>ack=y+1 | 
| ESTAB_LISHED | <- 开始传输数据 -> | ESTAB_LISHED |


### 四次挥手
数据传输结束后，通信的双方都可以释放连接，并停止发送数据。  
这里假设客户端发起关闭请求。  

|  客户端 |   | 服务端 |
| - | - | - |
| ESTAB_LISHED | <- 开始传输数据 -> | ESTAB_LISHED |
| 第一次挥手<br>客户端发起关闭请求 | ---------------><br>FIN=1,seq=u |  |
| FIN_WAIT1 |  |  |
|  | <---------------<br>ACK=1,seq=v<br>ack=u+1 | 第二次挥手<br>收到，通知应用关闭。 |
| FIN_WAIT2 |  | 应用关闭中  |
|  | <---------------<br>FIN=1,ACK=1,<br>seq=w,ack=u+1 | 第三次挥手<br>应用已关闭，可以关闭链接，<br>且不会再像客户端发送数据包。 |
| 第四次握手<br>收到，客户端应答，且奴会在发送数据包。 | ---------------><br>ACK=1,<br>seq=u+1,ack=w+1 | Closed |
| TIME_WAIT |  | Closed |
| Closed |  | Closed |

// todo 名词解释及其他基础协议和传输流程。

## 参考资料
[从一根电线到 TCP/IP](https://www.bilibili.com/video/BV197411t7sv?p=1)  
https://blog.csdn.net/xy010902100449/article/details/48274635  
https://blog.csdn.net/qq_31869107/article/details/81327494  