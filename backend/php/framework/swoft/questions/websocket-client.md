# Websocket 客户端

> 基于 v2.0.10

**需求描述:**   
　　在做 `CUCM` 话机集成项目时，`CMS` 服务会开启一个 `Websocket` 服务端，下发参会、呼叫、挂断等事件消息，可以通过 `Websocket` 客户端订阅消息。   

**问题描述：**   
　　存在多个 `CMS` 服务，需要启动一个进程（`Process`），拿到所有 `CMS` 服务地址，启动多个协程创建每一个 `CMS` 服务对应的 `Websocket` 客户端。   
　　需要满足 `CMS` 定义的自己消息通信、认证（`ACK`）方式。   

**遇到的问题和解决过程：**   
- 协程中需要设置协程上下文


**具体实现代码：**

- app/Process/UcxCmxProcess.php
    ```php
    declare(strict_types=1);

    namespace App\Process;

    use Swoole\Coroutine;
    use Swoft\Process\UserProcess;
    use Swoft\Process\Process;
    use Swoft\Process\UserProcess;
    use Swoft\Bean\Annotation\Mapping\Bean;
    use Swoft\Rpc\Client\Annotation\Mapping\Reference;
    use App\Process\CmxEvent\EventClient;
    use App\Process\CmxEvent\EventClientStorager;
    use App\Process\CmxEvent\MessageAck;
    use App\Rpc\Lib\ServerInterface;
    use App\Common\Log\Log;

    /**
    *
    * Class WebsocketClientProcess - Custom process
    *
    * @package App\Process
    *
    * @Bean()
    */

    class WebsocketClientProcess extends UserProcess
    {
        /**
         * CMS 微服务
         * @Reference(pool="cms.pool")
         * 
         * @var ServerInterface
         */
        private $serverService;

        public function run(Process $process): void
        {
            // 获取所有 CMS 服务的信息
            $servers = $this->serverService->getActiveServerList();
            if (empty($servers)) {
                Log::info('没有启用的思科会议服务');
                return;
            }

            $cCount = count($servers); // 启动协程数量
            $chan = new \Swoole\Coroutine\Channel($cCount); // 创建通道

            foreach ($servers as $server) {
                // 协程化 websocket 客户端
                go(function () use ($server) {
                    // 设置协程上下文，否则报错，Swoft 框架会根据协程 ID 获取协程对应的上下文对象
                    \Swoft\Context\Context::set(\App\Common\UdpContext::new());
                    $cId = Coroutine::getCid();

                    // ↓↓↓ 以下是核心：
                    // 因为根据不同的事件，需要创建对应的处理类来处理业务逻辑，
                    // 而业务逻辑中可能还需要创建协程，
                    // 而 websocket 客户端需要在各个协程中调用，
                    // 所以，创建一个客户端存储器，专门存放所有的 websocket 客户端

                    // 设置 websocket 客户端存储器，协程调用时统一使用存储器中的客户端对象
                    EventClientStorager::set(
                        $cId, 
                        new EventClient(
                            $server['host'],
                            $server['port'],
                            $server['username'],
                            $server['password'],
                            $server
                        )
                    );
                    // ↑↑↑ 核心结束

                    // 获取当前协程的客户端对象
                    $client = EventClientStorager::get($cId);
                    $client->init()->auth(); // 初始化链接并授权，创建链接之后需要经过 CMS 的授权过程

                    $subsribeStatus = $client->subscript(); // 发起订阅

                    // 死循环，等待接收消息
                    while (true) {
                        $message = $client->recvMessage(2);
                        if (null === $message) {
                            continue;
                        }

                        $eventClassName = \ucfirst($message['message']['type']) . 'Event';
                        $eventClass = 'App\\Process\\CmxEvent\\Events\\' . $eventClassName;
                        // 省略代码：
                        //     判断事件处理类是否存在
                        //     判断事件处理类是否实现了事件接口

                        $nextClosure = null;
                        try {
                            // 调用对应处理类的方法
                            $nextClosure = call_user_func_array(
                                // todo 此处可能造成内存溢出，需要后续测试
                                [ \Swoft\Bean\BeanFactory::getBean($eventClass), 'handle' ],
                                [ $message ]
                            );
                        } catch (\Exception $e) {
                            // do something ...
                        }
                        if (false === $nextClosure) {
                            // do something ...
                        }

                        // 回复 ACK 消息
                        $client->messageAck($message['message']['messageId']);
                        if ($nextClosure instanceof \Closure) {
                            $nextClosure();
                        }
                    }
                });
            }

            // 暂时阻塞主进程，等待协程结束，方式协程重复启动客户端。
            for ($i = 0;$i < $cCount;$i ++) {
                $chan->pop();
            }
        }
    }
    ```

- app/Process/SysService/CmxEvent/EventClientStorager.php
    ```php
    namespace App\Process\CmxEvent;

    use Swoole\Coroutine;
    use App\Process\SysService\EventClient;

    /**
     * 事件订阅客户端存储器
     */
    class EventClientStorager
    {
        // 存储器
        private static $clients = [];

        /**
         * 获取协程对应的客户端
         */
        public static function get(int $cId): ?EventClient
        {
            return self::$clients[$cId] ?? null;
        }

        /**
         * 获取协程对应的最近一个客户端
         * 因为协程启动的协程没有客户端，需要根据协程父 ID 获取到父协程的客户端
         */
        public static function getCloset(int $cId = null): ?EventClient
        {
            if (null === $cId) {
                $cId = Coroutine::getCid();
            }
            if (false === $cId || -1 === $cId) {
                return null;
            }
            return isset(self::$clients[$cId]) ? self::$clients[$cId] : self::getCloset(Coroutine::getPcid());
        }

        /**
         * 设置协程客户端
         */
        public static function set(int $cId, EventClient $eventClient)
        {
            self::$clients[$cId] = $eventClient;
        }
    }
    ```

- app/Process/SysService/CmxEvent/EventClient.php   
这个类包含了许多与 `CMS` 交互的认证方式，除了 `init` 和 `auth` 方法之外，可以忽略
```php
<?php

namespace App\Process\SysService\CmxEvent;

use App\Process\SysService\CmxEvent\MessageAck;
use App\Process\SysService\CmxEvent\SubscriptionIndexStorage;
use App\Common\Log\Log;

class EventClient
{
    /**
     * cms server host
     */
    private $host;
    
    /**
     * cms server port
     */
    private $port;
    
    /**
     * cms server http auth username
     */
    private $username;
    
    /**
     * cms server http auth password
     */
    private $password;
    
    /**
     * cms server data
     */
    private $server;

    private $client = null;

    private $messageId = 0;

    public function __construct(string $host, int $port, string $username, string $password, array $server)
    {
        $this->host     = $host;
        $this->port     = $port;
        $this->username = $username;
        $this->password = $password;
        $this->server   = $server;
    }

    public function getServerData()
    {
        return $this->server;
    }

    public function init(): self
    {
        $this->client = new \Swoole\Coroutine\Http\Client($this->host, $this->port, true);
        $this->client->setHeaders([
            'Host'                  => $this->host,
            'pragma'                => 'no-cache',
            'Upgrade'               => 'WebSocket',
            'Connection'            => 'Upgrade',
            'Sec-WebSocket-Key'     => \base64_encode($this->_generateRandomString(16, false, true)),
            'Sec-WebSocket-Version' => '13',
        ]);
        return $this;
    }

    public function auth(): self
    {
        $authToken = $this->getAuthToken(); // 获取认证 token
        $this->client->get('/events/v1?authToken=' . $authToken); // 链接 websocket 服务端
        return $this;
    }

    public function subscript(): bool
    {
        // 订阅消息
        $subscriptions = [
            [
                'index'    => 1,
                'type'     => 'calls',
                'elements' => [ 'name', 'participants' ]
            ]
        ];

        $calls = SubscriptionIndexStorage::getCalls();
        if (!empty($calls)) {
            foreach ($calls as $index => $call) {
                $subscriptions[] = [
                    'index'    => $index,
                    'type'     => 'callRoster',
                    'call'     => $call,
                    'elements' => [ 'name', 'uri', 'state' ]
                ];
            }
        }
        $res = $this->pushMessage([ 'type' => 'subscribeRequest', 'subscriptions' => $subscriptions ]);
        if (!$res) {
            return false;
        }
        
        $message = $this->recvMessage();
        if (!$this->isMessageAckSuccess($message)) {
            return false;
        }
        
        // subscribe request pedding ack
        while (true) {
            $message = $this->recvMessage();
            // 这里缺少判断 $message['message']['subscriptions']['state'] === 'pedding'，不确定是否应该缺少
            if ($this->isMessage($message) && $message['message']['type'] === 'subscriptionUpdate') {
                $this->messageAck($message['message']['messageId']);
                break;
            }
        }

        // subscribe request active ack
        while (true) {
            $message = $this->recvMessage();
            if ($message == null) {
                continue;
            }
            // 这里缺少判断 $message['message']['subscriptions']['state'] === 'active'，不确定是否应该缺少
            if ($this->isMessage($message) && $message['message']['type'] === 'subscriptionUpdate') {
                $this->messageAck($message['message']['messageId']);
                break;
            }
        }

        return true;
    }
    
    public function pushMessage(array $content): bool
    {
        $messageId = ++ $this->messageId;
        $content = [
            'type'    => 'message',
            'message' => array_merge(
                [ 'messageId' => $messageId ],
                $content
            )
        ];
        $content = \json_encode($content);
        Log::info(\sprintf('%s <green>--></green> <yellow>%s</yellow> %s', env('LOCAL_IP', '127.0.0.1'), $this->host, $content));
        return $this->client->push($content);
    }

    /**
     * 消息 ACK
     */
    public function messageAck(int $messageId): bool
    {
        $content = [
            'type'    => 'messageAck',
            'messageAck' => [
                'messageId' => $messageId,
                'status'    => 'success'
            ]
        ];
        $content = \json_encode($content);
        Log::info(\sprintf('%s <green>==></green> <yellow>%s</yellow> %s', env('LOCAL_IP', '127.0.0.1'), $this->host, $content));
        return $this->client->push($content);
    }

    /**
     * 接收消息
     */
    public function recvMessage(int $timeout = 0): ?array
    {
        $data = $this->client->recv($timeout);
        if (false === $data) {
            return null;
        }
        $message = $this->formatMessage($data->data);
        Log::info(\sprintf('%s <green>%s</green> <yellow>%s</yellow> %s', env('LOCAL_IP', '127.0.0.1'), $this->isMessage($message) ? '<--' : '<==', $this->host, $data->data));
        return $message;
    }

    public function isMessageAck(array $message): bool
    {
        return ($message['type'] ?? '') === 'messageAck' ? true : false;
    }

    public function isMessageAckSuccess(array $message): bool
    {
        return (
            ($message['type'] ?? '') === 'messageAck'
            && ($message['messageAck']['status'] ?? '') === 'success'
        ) ? true : false;
    }

    public function isMessage(array $message): bool
    {
        return ($message['type'] ?? '') === 'message' ? true : false;
    }

    /**
     * 格式化 message
     * 原始信息以 json 格式传输，需要格式化 message
     */
    public function formatMessage(string $data): array
    {
        $message = [];
        // do something ...
        return $message;
    }
    
    /**
     * 获取 AuthToken
     * CMS 提供接口 通过 BasicAuth 方式获取到 AuthToken，用于 Websocket 认证
     */
    private function getAuthToken(string $protocol = 'https'): ?string
    {
        $authToken = 'token';
        return $authToken;
    }

    /**
     * 
     */
    private function _generateRandomString(int $length = 10, bool $addSpaces = true, bool $addNumbers = true): string
	{  
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!"ยง$%&/()=[]{}';
		$useChars = array();
		// select some random chars:    
		for ($i = 0;$i < $length;$i ++) {
			$useChars[] = $characters[mt_rand(0, strlen($characters) - 1)];
		}
		// add spaces and numbers:
		if ($addSpaces === true) {
			array_push($useChars, ' ', ' ', ' ', ' ', ' ', ' ');
		}
		if ($addNumbers === true) {
			array_push($useChars, rand(0, 9), rand(0, 9), rand(0, 9));
		}
		shuffle($useChars);
		$randomString = trim(implode('', $useChars));
		$randomString = substr($randomString, 0, $length);
		return $randomString;
	}
}
```
