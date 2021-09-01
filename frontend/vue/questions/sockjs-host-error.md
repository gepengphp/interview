# sockjs.js?9be2:1609 GET http://192.168.0.121:8080/sockjs-node/info?t=1619326975370 net::ERR_INTERNET

### 问题描述

修改 `vue-cli-service serve` 协议为 https 后，报错：   
```
sockjs.js?9be2:1609 GET https://192.168.0.121:8080/sockjs-node/info?t=1619326975370 net::ERR_INTERNET
```

### 解决过程
- 网上找到的办法都是修改【/node_modules/sockjs-client/dist/sockjs.js】文件，不可行。
如：[https://blog.csdn.net/mo911108/article/details/116124306](https://blog.csdn.net/mo911108/article/details/116124306)    
- 访问 https://192.168.0.121:8080/sockjs-node/info?t=1619326975370 这个报错地址，发现确实无法访问。   
- 把域名换成 `localhost` 之后，可以访问，因为本地启动的服务访问域名就是 `localhost`。   

- 所以，修改项目根目录下 `vue.config.js`
    ```js
    devServer: {
        host: "localhost"
    }
    ```
    修改后，sockjs-node链接的访问域名就换成了 `localhost`，问题解决。 


// todo 补全 sockjs 的作用。
sockjs-node是一个JavaScript库，提供跨浏览器JavaScript的API，创建了一个低延迟、全双工的浏览器和web服务器之间通信通道。在项目运行以后，network会一直调用这个接口。如果没有使用，那么就一直会报这个异常。


### 参考
[https://stackoverflow.com/questions/65422967/fresh-vuejs-get-http-192-168-1-1028080-sockjs-node-infot-1608719207155-net/65423282](https://stackoverflow.com/questions/65422967/fresh-vuejs-get-http-192-168-1-1028080-sockjs-node-infot-1608719207155-net/65423282)