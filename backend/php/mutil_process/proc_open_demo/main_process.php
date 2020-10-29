<?php

$pid = getmypid();

echo 'main process start [pid ' . $pid . ']', PHP_EOL;

$command = 'php sub_process.php'; // 子进程执行的命令
$tmpDir = sys_get_temp_dir();
$cwd = null;

$urls = [
    'https://api.apiopen.top/getSingleJoke?sid=28654780',
    'https://api.apiopen.top/getJoke?page=1&count=2&type=video',
];

$stime = microtime(true); // 记录开始时间

$pipesSet = []; // 管道集合
foreach ($urls as $i => $url) { // 循环创建管道，有脚本处理任务
    $pipesSet[$i]['process'] = proc_open($command, [
        0 => ['pipe', 'r'], // 标准输入
        1 => ['pipe', 'w'], // 标准输出
        2 => ['file', $tmpDir . DIRECTORY_SEPARATOR . 'pipe_demo.log', 'a'], // 标准错误流
    ], $pipesSet[$i]['pipes'], $cwd);
    fwrite($pipesSet[$i]['pipes'][0], $url); // 通过管道传输数据给子进程
    fclose($pipesSet[$i]['pipes'][0]); // 关闭通道输入流
}

for ($i = 0;$i < count($pipesSet);$i ++) { // 遍历通道集合
    $line = fgets($pipesSet[$i]['pipes'][1]); // 读取子进程标准输出，这里是阻塞的
    fclose($pipesSet[$i]['pipes'][1]); // 关闭通道输出流
    proc_close($pipesSet[$i]['process']); // 关闭通道
    
    $data = \json_decode($line, true);
    // 输出子进程 pid、run_time、返回内容
    echo 'sub process [sub pid ' . $data['pid'] . '] [run_time ' . ($data['microtimes'][1] - $data['microtimes'][0]) . '], resource: ' . $line . '.', PHP_EOL;
}

$etime = microtime(true);
// 输出父进程执行时间
echo 'main process start [pid ' . $pid . '] [run_time ' . ($etime - $stime) . ']', PHP_EOL;
