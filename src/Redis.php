<?php

namespace homevip;

class Redis
{
    /**
     * 连接资源池
     *
     * @var [Redis Object]
     */
    private $redis;


    /**
     * 配置
     *
     * @var [array]
     */
    private static $config;


    /**
     * 定义实例
     *
     * @var [object]
     */
    private static $instance;


    /**
     * 初始化操作
     *
     * @param array $config
     */
    public function __construct()
    {
        try {
            $this->redis = new \Redis();
            $this->redis->connect(self::$config['host'], self::$config['port']);
            if ('' != self::$config['password']) {
                $this->redis->auth(self::$config['password']);
            }
            $this->redis->select(self::$config['db']);
        } catch (\Exception $e) {
            echo 'redis 服务异常! ' . $e->getMessage();
        }
    }


    /**
     * 返回静态实例
     *
     * @return object
     */
    public static function instance(array $config = []): object
    {
        if (!self::$instance instanceof self) {
            self::$config   = $config; // 配置参数

            self::$instance = new self();
        }
        return self::$instance;
    }


    /**
     * 当类中不存在该方法,直接调用call 实现调用底层redis相关的方法
     *
     * @param [type] $name 方法名
     * @param [type] $args 参数
     * @return void
     */
    public function __call($name, $args)
    {
        return $this->redis->$name(...$args);
    }
}
