<?php
/**
 * 描述：
 * Created at 2020/7/25 18:39 by mq
 */

namespace liansu;


class Base
{
    public static $instance = null;

    /**
     * 功能：获取实例
     * Created at 2020/7/25 18:41 by mq
     * @return Base|null
     */
    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    protected function __construct()
    {
    }
}