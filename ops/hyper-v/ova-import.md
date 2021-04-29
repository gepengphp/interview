# `ova` 模板文件导入 `Hyper-v` 虚拟机

`SAS Studio` 的学生版提供 `ova` 模板安装，`Hyper-v` 不支持导入 `ova` 模板，需要转换成 `vhdx` 格式。

### 过程

- 把 `ova` 模板以 `7-zip` 格式解压，解压出 `vmdk` 文件；
- [下载](https://www.microsoft.com/en-us/download/details.aspx?id=42497)安装 Microsoft Virtual Machine Converter；
- 以管理员身份打开 `powershell`，执行以下命令：
	```sh
	# Import the Converter Powershell Module
	Import-Module "C:\Program Files\Microsoft Virtual Machine Converter\MvmcCmdlet.psd1"
	# Convert the VMware .vmdk to a Hyper-V .vhdx
	ConvertTo-MvmcVirtualHardDisk -SourceLiteralPath "D:\Debian8\Debian8-disk1.vmdk" -DestinationLiteralPath "D:\Debian8.vhdx" -VhdType DynamicHardDisk -VhdFormat Vhdx
	```
- 使用生成的 `vhdx` 文件，创建 `Hyper-v` 虚拟机。


### 参考

[https://oitibs.com/convert-ova-to-vhdx-for-hyper-v/](https://oitibs.com/convert-ova-to-vhdx-for-hyper-v/)
