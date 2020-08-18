# canal 同步 kafka

## 修改instance 配置文件
```
vi conf/example/instance.properties
```
```
...
canal.instance.master.address=127.0.0.1:3306
...
# username/password,数据库的用户名和密码
canal.instance.dbUsername = canal
canal.instance.dbPassword = canal
...
# mq config
canal.mq.topic=example
# 针对库名或者表名发送动态topic
#canal.mq.dynamicTopic=mytest,.*,mytest.user,mytest\\..*,.*\\..*
canal.mq.partition=0
# hash partition config
#canal.mq.partitionsNum=3
#库名.表名: 唯一主键，多个表之间用逗号分隔
#canal.mq.partitionHash=mytest.person:id,mytest.role:id
```
```
# 动态 topic
# 指定匹配的表达式，针对匹配的表会发送到各自表名的 topic 上
# 【database\\..*】解释（更多格式见参考）：
#     database  | \\                           | . | .*
#     数据库名   | 保留一个转义字符，转义“.”符号  | . | 匹配表名的正则
canal.mq.dynamicTopic=database\\..*
```

## 参考
[https://blog.csdn.net/weixin_35852328/article/details/87600871](https://blog.csdn.net/weixin_35852328/article/details/87600871)

