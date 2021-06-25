# `|` 的应用

`按位或` 运算符
```php
class videoHandle
{
    const WATERMARK   = 0b00000001; // 水印
    const TRANSCODING = 0b00000010; // 转码
    const COMPRESS    = 0b00000100; // 压缩
    // const ...

    private $strategy = 0;

    private $strategies = [
        self::WATERMARK,
        self::TRANSCODING,
        self::COMPRESS,
    ];

    /**
     * 设置策略
     */
    public function setStrategy($strategy)
    {
        $this->strategy = $strategy;
        return $this;
    }

    /**
     * 开始任务
     */
    public function start()
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy & $this->strategy) {
                // do something
            }
        }
    }
}
$handle = new videoHandle();
$handle->setStrategy(videoHandle::WATERMARK | videoHandle::TRANSCODING) // 设置视频处理策略
    ->start();
```
