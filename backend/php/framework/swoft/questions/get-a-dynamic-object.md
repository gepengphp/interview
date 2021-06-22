# 根据需要动态获取一个存在注解绑定关系的类对象，并调用其方法

> 基于 v2.0.10

**需求描述:**   
　　在做 `CUCM` 话机集成项目时，`CUCM` 会遵循 `syslog` 协议将日志以 `UDP` 方式推送给 `syslog` 服务端。需要开启一个 `UDPServer` 作为 `syslog server`。并实时处理日志内容。   

**问题描述：**   
　　服务端接收到的日志的内容具有固定的格式，解析后将某格式的内容交由对应的类或方法处理，所以需要动态获取某对象并调用其方法。   
　　`Swoft` 的类没有办法想原始 `PHP` 一样 “new”。需要在 `BeanFactory` 中获取，否则注解绑定的成员属性值为 `null`，因为没有解析注解并将对应类创建并注入给该属性的过程。

**解决过程：**   
- Swoft 框架在启动服务时扫描所有文件，并解析其注解，并将对用的类初始化后 **注入** 给成员变量，如一个标准的 Rpc service 成员变量：
    ```php
    namespace App\Process;

    use Swoft\Bean\Annotation\Mapping\Bean;
    use Swoft\Process\Process;
    use Swoft\Process\UserProcess;
    use App\Rpc\Lib\FooInterface;

    /**
     *
     * Class FooProcess - Custom process
     *
     * @package App\Process
     * 
     * Bean 注解，不知道作用，需要看源码或了解 java 的注解作用，如果没声明 Bean 注解，不会解析成员变量并完成注入
     * @Bean()
     */
    class FooProcess extends UserProcess
    {
        /**
         * @Reference(pool="foo.pool")
         * 
         * @var FooInterface
         */
        private $fooService;

        public function run(Process $process): void
        {
            $this->fooService->fooMethod();
        }
    }
    ```
- `Swoft` 框架在启动时会将初始化添加了 `Bean` 注解的进程 `FooProcess`，并根据 `FooInterface` 接口声明将创建一个临时类（文件纯放在系统的临时目录），初始这个临时类，并将其绑定给成员属性 `$fooService`，并将 `FooProcess` 存放到 `BeanFactory` 中。   
- 所以，通过 `new` 创建的一个方法，成员属性的值是 null，不能使用。   
- 获取需要到 `BeanFactory` 中到 `FooProcess`，代码如下：   
    ```php
    $fooClass = \App\FooClass::class;
    // 或
    $fooClass = 'App\FooClass';
    // 注意：
    //     这里的 $fooClass 类路径前不能加“\”，如：“\App\FooClass”。否则无法通过类名在 BeanFactory 中获取到对象

    $result = call_user_func_array(
        [ \Swoft\Bean\BeanFactory::getBean($fooClass), 'fooMethod' ],
        [ $fooParams ]
    );
    ```
