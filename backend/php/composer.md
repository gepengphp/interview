# Composer

> 适用版本 `version 1.8.5`

## 最佳实践

- 取消 php.ini `disable_functions` 中的 `proc_open`、`proc_get_status` 函数。  

- 创建项目

- 修改镜像地址
    ```sh
    composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/ # 全局
    composer config repo.packagist composer https://mirrors.aliyun.com/composer/ # 项目
    ```

- 开发环境
    ```sh
    composer search monolog # 查询
    composer search require monolog # 安装
    composer remove xxx/xxx # 删除依赖
    composer dumpautoload # 更新 autoload
    ```

- 将 `composer.lock` 加入版本管理工具

- 生产环境
    ```sh
    composer install --no-dev # 安装
    ```


## 常用命令
```sh
# 设置阿里云镜像
composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/
# 解除镜像并恢复到 packagist 官方源
composer config -g --unset repos.packagist
# 初始化
composer init

# 安装
composer require package 

# 更新
composer update
# 更新指定包
composer update package package2
composer update package/*
# 模拟更新
composer update --dry-run
# 跳过 require-dev 字段中列出的包
composer update --no-dev

# 查看
# 查看已安装依赖包
composer show
# 查看依赖包详情
composer show package
# 查看全部
composer show --all

# 依赖性检测
# 检测是否被其他包依赖，并列出他们
composer depends --recursive monolog/monolog
# 检测依赖树
composer depends --tree monolog/monolog

# 依赖包状态检测
composer status
composer status -v

# 更新自己
composer self-update

# 更新 autoload
composer dump
composer dumpautoload
composer dump-autoload
```

## 性能调优
jenkins 默认占用内存比较大，需要调整参数，限制内存占用。   

yum 安装 Jenkins 的 catalina.sh 文件在 `/etc/sysconfig/jenkins/`。
`JENKINS_JAVA_OPTIONS` 选项添加参数 `-Xms512m -Xmx1024m -XX:PermSize=256m -XX:MaxPermSize=512m`

```ini
JENKINS_JAVA_OPTIONS="-Djava.awt.headless=true -Xms512m -Xmx1024m -XX:PermSize=256m -XX:MaxPermSize=512m"
```

> `catalina` 是 Tomcat 服务器使用的 Apache 实现的 servlet 容器的名字。   
Tomcat的核心分为3个部分：  
（1）Web容器---处理静态页面；   
（2）catalina --- 一个servlet容器-----处理 servlet；   
（3）还有就是 JSP 容器，它就是把 jsp 页面翻译成一般的 servlet。   

## 文档
https://docs.phpcomposer.com/03-cli.html#install