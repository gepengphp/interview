# Gitlab

## 安装

### 安装
```sh
# 新建 gitlab-ce 镜像源
> vi /etc/yum.repos.d/gitlab_gitlab-ce.repo
# 写入如下内容
# [gitlab-ce]
# name=Gitlab CE Repository
# baseurl=https://mirrors.tuna.tsinghua.edu.cn/gitlab-ce/# yum/el$releasever/
# gpgcheck=0
# enabled=1

# 安装
> yum install gitlab-ce
# 使配置生效并启动 gitlab
> gitlab-ctl reconfigure
```

### 配置域名

```sh
> vi /var/opt/gitlab/nginx/conf/gitlab-http.conf
# 修改端口和域名
# listen *:80;
# server_name gitlab.domain.com;
# set $http_host_with_default "gitlab.domain.com";

```

### 修改密码
```sh
> gitlab-rails console production
> user = User.where(id:1).first
> user.password='123456'
> user.save!
```


### todo 常用命令、切换nginx、邮箱配置等
