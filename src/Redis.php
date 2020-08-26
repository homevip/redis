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
     * 初始化操作
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        try {
            $this->redis = new \Redis();
            $this->redis->connect($config['host'], $config['port']);
            if ('' != $config['password']) {
                $this->redis->auth($config['password']);
            }
            $this->redis->select($config['db']);
        } catch (\Exception $e) {
            echo 'redis 服务异常! ' . $e->getMessage();
        }
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
