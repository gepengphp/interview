# UDP Server 的问题
> 基于 v2.0.10

**需求描述:**   
　　在做 `CUCM` 话机集成项目时，`CUCM` 会遵循 `syslog` 协议将日志以 `UDP` 方式推送给 `syslog` 服务端。需要开启一个 `UDPServer` 作为 `syslog server`。并实时处理日志内容。

**问题描述：**   
　　`Swoft` 框架没有为 `UDPServer` 编写完整的服务段代码，文档也没有关于 `UDPServer` 的相关说明，只在 `TCPServer` 的说明中提到 `type` 配置项关于 `UCPServer` 类型的说明，而这个类型是 `Swoole` 的预定义常量，与 `Swoft` 框架没有必然关系。    
　　总结以下就是：`Swoole` 支持 `UDPServer`，但是 `Swoft` 并没有像 `TCPServer` 一样将 UDPServer 完整集成进 Swoft 框架中，做到开箱即用。


**详细问题和解决过程：**   
- `Swoft` 的 `UDPServer` 在 `bean.php` 文件中配置，默认键名 `'tcpServer'`。   
- `'tcpServer'` 数组配置没有 `type` 选项，`type` 选项默认值为 `SWOOLE_SOCK_TCP`，需要添加 `type` 选项，并设置其值为 `SWOOLE_SOCK_UDP`。   
- 设置事件绑定的处理类，添加 `on` 选项，并设置 `SwooleEvent::PACKET` 事件的处理类。

**代码实现：**    

- app/bean.php
    ```php
    'tcpServer'          => [
        'port'  => 514,
        // 设置事件类处理类
        'on'    => [
            SwooleEvent::PACKET => bean(\App\Listener\UdpPacketListener::class),
        ],
        // 设置Server协议为UDP，这个值是 Swoole 的预定义常量，具体参照 Swoole 的 TCPServer 文档
        'type'  => SWOOLE_SOCK_UDP,
        'debug' => 1,
        'setting' => [
            'worker_num' => 2,
        ],
    ],
    ```
- App\Listener\UdpPacketListener.php
    ```php
    declare(strict_types=1);

    namespace App\Listener;

    use Swoole\Server;
    use Swoft\Event\Annotation\Mapping\Listener;
    use Swoft\Event\EventInterface;
    use Swoft\Server\Contract\PacketInterface;
    use Swoft\Event\EventHandlerInterface;
    use Swoft\Log\Helper\CLog;

    /**
    * Class UdpPacketListener
    *
    * @since 2.0
    *
    * @Listener()
    */
    class UdpPacketListener implements PacketInterface, EventHandlerInterface
    {
        /**
         * 接收消息事件绑定方法
         * 
         * @param \Swoole\Server $server UDPServer 服务对象
         * @param string $log UDP 消息内容
         * @param array $clientInfo 客户端信息，包含客户端 IP 等
         */
        public function onPacket(Server $server, string $log, array $clientInfo): void
        {
            // 此方法运行在协程中，需要设置协程上下文。
            // Swoft 框架会通过协程 ID 获取上下文，上下文中包含会话需要的内容。
            // 比如 Http 服务的上下文中存放着 Request 对象。
            // 具体去看源码。
            \Swoft\Context\Context::set(\App\Common\UdpContext::new());

            Log::info($log);

            // 以下是业务代码：
            // 根据 log 内容解析出需要做的处理此 log 的处理类，动态获取类并执行对应方法
            // Swoft 的类没有办法想原始 PHP 一样 “new”。需要在 BeanFactory 中获取，否则注解绑定的成员属性值为 null，因为没有解析注解并将对应类创建并注入给该属性的过程
            // 详细参见另一个问题
            $eventHandle = 'some class';
            $handle = 'some method';
            call_user_func_array(
                [ \Swoft\Bean\BeanFactory::getBean($eventHandle, $handle ],
                [ $clientInfo, $message,  $params ]
            );
        }
        
        public function handle(EventInterface $event): void{}
    }
    ```

- App\Common\UdpContext.php
    ```php
    declare(strict_types=1);

    namespace App\Common;

    use Swoft\Bean\Annotation\Mapping\Bean;
    use Swoft\Bean\Concern\PrototypeTrait;
    use Swoft\Context\AbstractContext;

    /**
    * Class UdpContext
    *
    * @since 2.0
    *
    * @Bean(scope=Bean::PROTOTYPE)
    */
    class UdpContext extends AbstractContext
    {
        use PrototypeTrait;

        /**
        * Create context replace of construct
        *
        * @param Request  $request
        * @param Response $response
        *
        * @return HttpContext
        */
        public static function new(): self
        {
            $instance = self::__instance();

            return $instance;
        }
    }
    ```
    