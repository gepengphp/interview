# 网络

## Chrome 80 Cookie 跨域 Samesite Lax 的错误
### 问题表现：通过 `iframe` 加载另一个站点，登录成功，但跳转回登录页面。  
### 排查过程：
1. 查看系统磁盘，session 是否写入成功。
2. 通过新标签打开网站，可以正常登录。
3. 查看登录请求详情，Response header 中 `set-cookie` 显示 ：**⚠️this set-cookie didn't specify a "SameSite" attribute and was defaulted to "sameSite=Lax", and was blocked because it came from a cross-site response witch was not the response to a top-level navigation. the site-cookie had to have been set with "SameSite=None" to enable cross-site usage.**
4. 定位问题：设置 `cookie` 失败。

### 解决：  
一、 chrome 浏览器访问：[chrome://flags/#same-site-by-default-cookies](chrome://flags/#same-site-by-default-cookies)，设置该项为禁用状态，重启。

二、设置 `cookie` 时添加 `SameSite` 设置
```
Set-Cookie: widget_session=abc123; SameSite=None; Secure
```

### `SameSite` 属性
它可以设置三个值。
- Strict
- Lax
- None

**`Strict`**。最为严格，完全禁止第三方 `Cookie`，跨站点时，任何情况下都不会发送 `Cookie`。换言之，只有当前网页的 `URL` 与请求目标一致，才会带上 `Cookie`。

**`Lax`**。规则稍稍放宽，大多数情况也是不发送第三方 `Cookie`，但是导航到目标网址的 `GET` 请求除外。

导航到目标网址的 GET 请求，只包括三种情况：链接，预加载请求，GET 表单。详见下表。
| 请求类型 | 示例 | 正常情况 | Lax |
| ---- | ---- | ---- | ---- |
| 链接 | \<a href="..."></a> | 发送 Cookie | 发送 Cookie |
| 预加载 | \<link rel="prerender" href="..."/> | 发送 Cookie | 发送 Cookie |
| GET 表单 | \<form method="GET" action="..."> | 发送 Cookie | 发送 Cookie |
| POST 表单 | \<form method="POST" action="..."> | 发送 Cookie | 不发送 |
| iframe | \<iframe src="..."></iframe> | 发送 Cookie | 不发送 |
| AJAX | $.get("...") | 发送 Cookie | 不发送 |
| Image | \<img src="..."> | 发送 Cookie | 不发送 |
设置了Strict或Lax以后，基本就杜绝了 CSRF 攻击。当然，前提是用户浏览器支持 SameSite 属性。

**`None`**。Chrome 计划将 `Lax` 变为默认设置。这时，网站可以选择显式关闭 `SameSite` 属性，将其设为 `None`。不过，前提是必须同时设置 `Secure` 属性（Cookie 只能通过 `HTTPS` 协议发送），否则无效。
```
# 无效
Set-Cookie: widget_session=abc123; SameSite=None
# 有效
Set-Cookie: widget_session=abc123; SameSite=None; Secure
```

### 参考
[阮一峰博客](http://www.ruanyifeng.com/blog/2019/09/cookie-samesite.html)  
http://www.chromium.org/updates/same-site  
