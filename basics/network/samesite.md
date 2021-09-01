# SameSite

### 问题
在使用 `vue-cli-service serve` 启动一个前端项目，并加载 `vue-baidu-map` 时，Chrome 浏览器报错：Indicate whether to send a cookie in a cross-site request by specifying its SameSite attribute。

### 原因
`serve` 启动的时 `http` 服务，而 baidu 地图接口是 https 协议。

### 解决办法
所以需要启动 https 服务。   
[vue-cli https serve 配置](../../frontend/vue/vue-cli/https-serve.md)

### 参考
[https://stackoverflow.com/questions/65087673/vue-cookies-not-able-to-set-samesite-and-secure-attributes](https://stackoverflow.com/questions/65087673/vue-cookies-not-able-to-set-samesite-and-secure-attributes)   
[阮一峰《Cookie 的 SameSite 属性》](https://www.ruanyifeng.com/blog/2019/09/cookie-samesite.html)   
