# NAS

网络附属存储，`Network Attached Storage`。   

`NAS` 被定义为一种特殊的专用数据存储服务器，包括存储器件（例如磁盘阵列、CD/DVD驱动器、磁带驱动器或可移动的存储介质）和内嵌系统软件，可提供跨平台文件共享功能。   

linux 可以直接挂在 `NAS` 存储。
```sh
# 建立一个挂载存储的文件夹“nas”.
> mkdir /mnt/nas

# 挂载
> mount -o username=user,password=password //172.16.10.27/data /mnt/nas

# 查看挂载
> df -h

# 系统重启后，挂载点会丢失
# 编辑 fstab
> vi /etc/fstab
# 输入 //172.16.10.27/data /mnt/nas cifs username=user,password=password  0 0
```
