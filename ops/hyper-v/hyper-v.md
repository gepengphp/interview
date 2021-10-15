# Windows Hyper-v 虚拟机

## windows 家庭版
windows 家庭版中的`启动和关闭 windows 功能`中没有 `Hyper-V` 选项，将一下代码保存为 `bat` 脚本后，以管理员身份运行。
```cmd
pushd "%~dp0"
dir /b %SystemRoot%\servicing\Packages\*Hyper-V*.mum >hyper-v.txt
for /f %%i in ('findstr /i . hyper-v.txt 2^>nul') do dism /online /norestart /add-package:"%SystemRoot%\servicing\Packages\%%i"
del hyper-v.txt
Dism /online /enable-feature /featurename:Microsoft-Hyper-V-All /LimitAccess /ALL
```

## SLAT
家庭版 Windows 功能中没有 Hyper-v 选项的原因：需要 CPU 支持 `SLAT` 功能。
我的机器 CPU 是 "Intel(R) Core(TM) i7-10510U CPU @ 1.80GHz   2.30 GHz"，在网上的资料中，i7 CPU 有 SLAT 支持。   
但是显示的结果却是不支持。   
[详见](../../basic/computer/windows/slat.md)。

## Hyper-V 虚拟机联网
// todo 没搞懂，Hyper-V 的虚拟交换机分`内部`、`外部`、`专用`。分别对应内网、外网和不知道。  
可以创建对内、对外的多个交换机，来对应 linux 的多个网卡。  
会在 windows 网络设置中创建对应的网络适配器。还会有桥接等适配器。需要搞懂 windows 的网络适配器和 linux 的多网卡。

## 检查点
// todo 还不知道是干嘛用的，怎么用