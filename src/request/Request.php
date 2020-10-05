<?php
/**
 * 描述：
 * Created at 2020/7/25 18:33 by mq
 */

namespace liansu\request;


class Request
{
    /**
     * 功能：获取get请求值
     * Created at 2020/7/25 18:50 by mq
     * @param null $key
     * @param string $default
     * @return string
     */
    public static function get($key = null, $default = '')
    {
        // name/1,i,s:t,e
        if ($key === null) {
            return $_GET;
        }

        return $_GET[$key] ?? $default;
    }

    /**
     * 功能：获取post请求值
     * Created at 2020/7/25 18:51 by mq
     * @param null $key
     * @param string $default
     * @return string
     */
    public static function post($key = null, $default = '')
    {
        if ($key === null) {
            return $_POST;
        }

        return $_POST[$key] ?? $default;
    }

    /**
     * 功能：获取请求值
     * Created at 2020/7/25 19:24 by mq
     * @param null $key
     * @param string $default
     * @return string
     */
    public static function all($key = null, $default = '')
    {
        if ($key === null) {
            return $_REQUEST;
        }

        return $_REQUEST[$key] ?? $default;
    }

    /**
     * 功能：获取请求方法
     * Created at 2020/7/25 18:50 by mq
     * @return string
     */
    public static function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'] ?? '';
    }

    /**
     * 功能：判断请求方法是否为...
     * Created at 2020/7/25 18:50 by mq
     * @param $method
     * @return bool
     */
    public static function isMethod($method)
    {
        $method = strtoupper($method);
        return $_SERVER['REQUEST_METHOD'] === $method;
    }
}