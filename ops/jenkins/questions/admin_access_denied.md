# 管理员 Access denied

> 版本：`2.222.3`  

修改权限失误后，Access Denied。admin 用户各种没有权限。

解决：jenkins 用户权限保存在 `config.xml` 文件中。直接修改配置，还原 admin 的操作权限。
> 其他用户权限也在这里，注意不要误操作影响其他用户权益。

```xml
<hudson>
  <authorizationStrategy class="hudson.security.GlobalMatrixAuthorizationStrategy">
    <permission>hudson.model.Computer.Configure:admin</permission>
    <permission>hudson.model.Computer.Connect:admin</permission>
    <permission>hudson.model.Computer.Create:admin</permission>
    <permission>hudson.model.Computer.Delete:admin</permission>
    <permission>hudson.model.Computer.Disconnect:admin</permission>
    <permission>hudson.model.Hudson.Administer:admin</permission>
    <permission>hudson.model.Hudson.Read:admin</permission>
    <permission>hudson.model.Item.Build:admin</permission>
    <permission>hudson.model.Item.Cancel:admin</permission>
    <permission>hudson.model.Item.Configure:admin</permission>
    <permission>hudson.model.Item.Create:admin</permission>
    <permission>hudson.model.Item.Delete:admin</permission>
    <permission>hudson.model.Item.Discover:admin</permission>
    <permission>hudson.model.Item.Read:admin</permission>
    <permission>hudson.model.Item.Workspace:admin</permission>
    <permission>hudson.model.Run.Delete:admin</permission>
    <permission>hudson.model.Run.Update:admin</permission>
    <permission>hudson.model.View.Configure:admin</permission>
    <permission>hudson.model.View.Create:admin</permission>
    <permission>hudson.model.View.Delete:admin</permission>
    <permission>hudson.model.View.Read:admin</permission>
    <permission>hudson.scm.SCM.Tag:admin</permission>
  </authorizationStrategy>
  <securityRealm class="hudson.security.HudsonPrivateSecurityRealm">
    <disableSignup>false</disableSignup>
    <enableCaptcha>false</enableCaptcha>
  </securityRealm>
</hudson>
```