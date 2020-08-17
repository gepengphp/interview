# Composer

## 全局配置
```
composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/
composer config -g --unset repos.packagist
```

## 项目配置
```
composer config repo.packagist composer https://mirrors.aliyun.com/composer/
composer config --unset repos.packagist
```

## 删除依赖
```
composer remve xxx/xxx
composer dumpautoload
```