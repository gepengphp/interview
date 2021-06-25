# `Filesystem` 函数缓存

php 检查一个文件时，会缓存结果。同一个脚本多次检查同一个文件，需要使用 `clearstatcache` 函数。
以下是受 `clearstatcache` 影响的函数。
```php
stat()
lstat()
file_exists()
is_writable()
is_readable()
is_executable()
is_file()
is_dir()
is_link()
filectime()
fileatime()
filemtime()
fileinode()
filegroup()
fileowner()
filesize()
filetype()
fileperms()
```
