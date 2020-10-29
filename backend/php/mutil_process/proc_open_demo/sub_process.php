<?php

$stime = microtime(true);

$pid = getmypid();

// echo '[sub pid ' . $pid . '] sub process start.', PHP_EOL;

$url = fgets(STDIN); // 获取标准输入
// echo '[sub pid ' . $pid . '] main process input: ' . $url, PHP_EOL;

// $response = file_get_contents($url);
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
