# Git commit message
git 提交说明规范。  
git 每次提交代码，都要写 Commit message（提交说明），否则就不允许提交。  

### 好处
- 提供更多的历史信息，方便快速浏览。  
    比如，下面的命令显示上次发布后的变动，每个commit占据一行。你只看行首，就知道某次 commit 的目的。
    ```sh
    $ git log <last tag> HEAD --pretty=format:%s
    ```
- 可以过滤某些commit（比如文档改动），便于快速查找信息。  
    比如，下面的命令仅仅显示本次发布新增加的功能。
    ```sh
    $ git log <last release> HEAD --grep feature
    ```
- 可以直接从commit生成Change log。

### 格式
包括三个部分：Header，Body 和 Footer
```sh
# 格式：
<type>(<scope>): <subject>
// 空一行
<body>
// 空一行
<footer>

# 格式解释：
<类型>[可选的作用域]: <描述>

[可选的正文]

[可选的脚注]

# 例1：  
fix(DAO):用户查询缺少username属性 

# 例2：
feat(Controller):用户查询接口开发
```
其中，Header 是必需的，Body 和 Footer 可以省略。  
不管是哪一个部分，任何一行都不得超过 50 个字符（或 100 个字符）。这是为了避免自动换行影响美观。  

### Header
- `type`  （**必需**）  
    用于说明 commit 的类别，只允许使用以下标识：  

    - feat：新功能（feature）。
    - fix/to：修复 bug，可以是 QA 发现的 BUG，也可以是研发自己发现的 BUG。
        - fix：产生 diff 并自动修复此问题。适合于一次提交直接修复问题
        - to：只产生 diff 不自动修复此问题。适合于多次提交。最终修复问题提交时使用fix
    - docs：文档（documentation）。
    - style：格式（不影响代码运行的变动）。
    - refactor：重构（即不是新增功能，也不是修改 bug 的代码变动）。
    - perf：优化相关，比如提升性能、体验。
    - test：增加测试。
    - chore：构建过程或辅助工具的变动。
    - revert：回滚到上一个版本。
    - merge：代码合并。
    - sync：同步主线或分支的 Bug。
- `scope` （**可选**）
    用于说明 commit 影响的范围，比如数据层、控制层、视图层等等，视项目不同而不同。  
    如果你的修改影响了不止一个 `scope`，你可以使用 `*` 代替。  
- `subject` （**必需**）
    commit 目的的简短描述，不超过50个字符。  
    建议使用中文（感觉中国人用中文描述问题能更清楚一些）。  
    结尾不加句号或其他标点符号。  

### Body
Body 部分是对本次 commit 的详细描述，可以分成多行。下面是一个范例。  

有两个注意点。  
- 使用第一人称现在时，比如使用 change 而不是 changed 或changes。  
- 应该说明代码变动的动机，以及与以前行为的对比。例：  
    ```git
    REAKING CHANGE: isolate scope bindings definition has changed.

    To migrate the code follow the example below:

    Before:

    scope: {
      myAttr: 'attribute',
    }

    After:

    scope: {
      myAttr: '@',
    }

    The removed `inject` wasn't generaly useful for directives so there should be no code using it.
    ```
- 关闭 Issue
    如果当前 commit 针对某个issue，那么可以在 Footer 部分关闭这个 issue 。  
    ```
    Closes #234
    ```
    也可以一次关闭多个 issue 。
    ```
    Closes #123, #245, #992
    ```

### Revert
还有一种特殊情况，如果当前 commit 用于撤销以前的 commit，则必须以 `revert:` 开头，后面跟着被撤销 Commit 的 Header。
```git
revert: feat(pencil): add 'graphiteWidth' option

This reverts commit 667ecc1654a317a13331b17617d973392f415f02.
```
Body 部分的格式是固定的，必须写成 `This reverts commit <hash>.`，其中的hash是被撤销 commit 的 SHA 标识符。  
如果当前 commit 与被撤销的 commit，在同一个发布（release）里面，那么它们都不会出现在 Change log 里面。如果两者在不同的发布，那么当前 commit，会出现在 Change log 的Reverts小标题下面。

### 生成 Change log
// todo 没生成过，去生成。

### 工具
- [Commitizen](https://github.com/commitizen/cz-cli)  
- [validate-commit-msg](https://github.com/kentcdodds/validate-commit-msg)  
- [conventional-changelog](https://github.com/ajoslin/conventional-changelog)  



### Footer
Footer 部分只用于两种情况。
- 不兼容变动
    如果当前代码与上一个版本不兼容，则 Footer 部分以BREAKING CHANGE开头，后面是对变动的描述、以及变动理由和迁移方法。

### 监控服务
涉及发布流程，可以在持续交付流程中对 message 格式进行验证，并通知相关人员。

// todo 在项目中使用，验证并补全截图

## 参考

[阮一峰的网络日志 Commit message 和 Change log 编写指南](http://www.ruanyifeng.com/blog/2016/01/commit_message_change_log.html)

[知乎 - Git commit message 规范](https://zhuanlan.zhihu.com/p/69989048)

[知乎：阿里技术 - 如何规范你的Git commit？](https://zhuanlan.zhihu.com/p/182553920?utm_source=wechat_session)  

[conventional commits](https://link.zhihu.com/?target=https%3A//www.conventionalcommits.org/zh/v1.0.0-beta.3/) `必读` 介绍约定式提交标准。

[Angular规范](https://link.zhihu.com/?target=https%3A//github.com/angular/angular/blob/22b96b9/CONTRIBUTING.md%23-commit-message-guidelines) `必读` 介绍Angular标准每个部分该写什么、该怎么写。

[@commitlint/config-conventional](https://link.zhihu.com/?target=https%3A//github.com/conventional-changelog/commitlint/tree/master/%2540commitlint/config-conventional%23type-enum) `必读` 介绍commitlint的校验规则config-conventional，以及一些常见passes/fails情况。