# PHP 多进程之 `proc_open`
手册：[https://www.php.net/manual/zh/function.proc-open.php](https://www.php.net/manual/zh/function.proc-open.php)  

### Demo
- [子进程脚本](./proc_open_demo/sub_process.php)
- [主进程脚本](./proc_open_demo/main_process.php)

### 运行Demo

```sh
> php main_process.php
main process start [pid 26908] # 父进程开始及 pid
main process process open finished, waiting # 子进程创建完成，开始等待结果
sub process [sub pid 3412] [run_time 4.0002539157867], resource: {"pid":3412,"url":"https:\/\/api.apiopen.top\/getSingleJoke?sid=28654780","microtimes":[1603964647.843694,1603964651.843948],"data":{"rand":4}}. # 第一个子进程执行了 4 秒
sub process [sub pid 14908] [run_time 5.0009119510651], resource: {"pid":14908,"url":"https:\/\/api.apiopen.top\/getJoke?page=1&count=2&type=video","microtimes":[1603964647.843694,1603964652.844606],"data":{"rand":5}}. # 第二个子进程执行了 5 秒
main process end [pid 25776] [run_time 5.1136298179626] # 父进程执行了 5+ 秒
```

> 确实没有 `go` 的 `goroutine` 好用
