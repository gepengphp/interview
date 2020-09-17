# 调试时遇到问题

## 问题 Result Maps collection does not contain value for java.util.Map
过程：写了两段select，参数为【resultMap="java.util.Map"】，调用另一条sql时报错，报错位置与错误无关，所以无法直接定位到问题。
找到文章 https://codeleading.com/article/95842482079/ ：
其根本原因无非就两点 ：
1. mapper 标签的namespace地址有问题与你的DAO类路径不一致。
2. 看下resultMap与resultType是否混淆 （最多的是这种）
```
    <select id="xxxxxx" resultMap="java.util.Map">
```
> **注意**： 在你找 resultMap 与 resultType 是否混淆的时候，不要只顾与在报错的地方找！ 也不是仅仅在关联的XML里面找！是在这个工程全部的 .XML 文件下找 切记！！！ 切记！！！

---

## 问题 vscode 运行java 错误：找不到或无法加载主类
为解决，尝试办法：
在 XxxApplication.java 目录运行 javac -d. .\XxxApplication.java
修改项目或 run code 插件 java 启动命令参数，添加【-d.】
    "code-runner.executorMap": {
        "java": "cd $dir && javac -d. $fileName && java $fileNameWithoutExt",
    }

临时解决方法：使用 idea 运行一次后，vscode 可以正常运行。
可以与多模块项目有关。

---

## 问题 MyBatis insert LAST_INSERT_ID()
insert 接口参数不能指定 `@Param` 注解，一旦指定，MyBatis 不能 map 中添加主键 id
userMapper.java
```java
// 错误
int insert(@Param Map<String, Object> user);
// 正确
int insert(Map<String, Object> user);
```
userMapper.xml
```xml
<insert id="insert">
    INSERT INTO `user` (`name`) VALUES (#{name})
    <selectKey keyProperty="user_id" order="after" resultType="int">
        SELECT LAST_INSERT_ID()
    </selectKey>
</insert>
```
userService.java
```java
Map<String, Object> user = new HashMap<String, Object>(){{
    put("name", "bulabulabin");
}};
userMapper.insert(user);
int userId = user.get("user_id");
```

---

## 问题 mybatis框架中进行参数非空或者字符串比较判断时
```xml
<!-- ERROR -->
<if test="mnyType == '1'">
```
因为 mybatis 是用 OGNL 表达式解析的，在 OGNL 表达式中 ‘1’ 会被解析成字符串，又因为 Java 是强类型的，char 和 string 会导致不相等，所以 if 标签中的 SQL 不会被解析。

因此单个字符要写到双引号里面或者使用 .toString() 才可以，比如正确的写法如下
```xml
<if test="mnyType == '1'.toString()">
或
<if test='mnyType == "1"'>
```