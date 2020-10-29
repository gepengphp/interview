<?php
/**
 * 访问url，返回数据
 */
$stime = microtime(true);

$pid = getmypid(); // 子进程 pid
$url = fgets(STDIN); // 获取标准输入

// $response = file_get_contents($url);
// 换成随机一个随机数，并休眠，结果比较直观
$rand = rand(1, 5);
sleep($rand);
$response = [
    'rand' => $rand,
];

$etime = microtime(true);

// 输出数据
echo \json_encode([
    'pid' => $pid,
    'url' => $url,
    'microtimes' =>[ $stime, $etime ],
    'data' => $response,
], JSON_UNESCAPED_UNICODE);

fwrite(STDERR, '[sub pid ' . $pid . '] sub process error.'); // 将信号写入标准错误
