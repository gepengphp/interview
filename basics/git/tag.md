# Tag



```sh
# 当前版本打标签
> git tag -a v5.2 -m 'first refactor version'

# 指定版本打标签
> git tag -a v5.2 c741d19d180f -m 'first refactor version'

# 推送标签
> git push origin --tags

# 推送指定标签
> git push origin v5.2

# 删除标签
> git tag -d v5.2

# 删除远程标签
> git push origin :refs/tags/v5.2

# 查看标签
> git tag -n

# 查看标签详情
> git show v5.2
```
