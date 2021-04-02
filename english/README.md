`agent` 代理人
- `Http User-Agent` 简称 UA，它是一个特殊字符串头，使得服务器能够识别客户使用的操作系统及版本、CPU 类型、浏览器及版本、浏览器渲染引擎、浏览器语言、浏览器插件等。

`composer` 作曲家

`fresh` 新鲜

`expect` 期望；预期

`scope` 范围

`solve` 解决

`resolve` 解决；解析；分析
- `composer install` 报错：**Your requirements could not be resolved to an installable set of packages.** 要求的一组安装包不能被解决，原因：系统、php版本、扩展等与 `composer.lock` 中的包版本不匹配，统一环境或删除 `lock` 后 `install`

`alias` [ˈeɪliəs] 化名；别名；又名

`clause` [klôz] 从句; 分句; 子句；条款
- `mysql` `from` 子句查询条件使用外部字段报错：**Unknown column 'table.column' in 'where clause'** 。where 子句中没有字段“table.column”

`closure` [ˈkləʊʒə(r)] 闭包；停业，关闭; 倒闭; (路或桥的) 暂时封闭。
- `PHP` 匿名函数，是 php5.3 的时候引入的,又称为 `Anonymous functions`。

`algorithm` [ˈælɡərɪðəm] 算法；计算程序

`associate` [əˈsəʊsieɪt , əˈsəʊsiət] 联想; 联系; 关联
- 简写 `assoc`，编程中很常见。
```sh
C:\> assoc /? ---
显示或修改文件扩展名关联

ASSOC [.ext[=[fileType]]]

  .ext      指定跟文件类型关联的文件扩展名
  fileType  指定跟文件扩展名关联的文件类型

键入 ASSOC 而不带参数，显示当前文件关联。如果只用文件扩展
名调用 ASSOC，则显示那个文件扩展名的当前文件关联。如果不为
文件类型指定任何参数，命令会删除文件扩展名的关联。
C:\> assoc .txt
.txt=txtfile
C:\> assoc .mp4
.mp4=WMP11.AssocFile.MP4
```
- php 相关函数，`mysql_fetch_assoc`、`array_diff_assoc`、`array_uintersect_assoc`、`is_assoc` 等，表示**关联数组**（key => value 数组)

`support` [səˈpɔːt] 支持; 拥护; 鼓励; 帮助; 援助; 资助; 赞助;

`invoke` [ɪnˈvəʊk] 调用
- php 魔法函数 `__invoke`，当对象被当作方法调用时，如果声明 `invoke` 方法，则执行。

`recursive` [rɪˈkɜːsɪv] 递归

`standard` [ˈstændəd] 标准

`native` [ˈneɪtɪv] 本地，本土，土著
- vue 事件修饰符。件绑定事件时候，必须加上native ，否则会认为监听的是来自Item组件自定义的事件
  ```js
  <Item @click.native="shijian()"></Item>
  ```

`dependency` [dɪˈpendənsi] 依赖
- Maven 配置中，添加依赖包的标签名称
    ```xml
    <!--web依赖包，web应用必备-->
    <dependency>
        <groupId>org.springframework.boot</groupId>
        <artifactId>spring-boot-starter-web</artifactId>
    </dependency>
    ```




