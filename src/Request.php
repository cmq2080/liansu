<?php
/**
 * 描述：
 * Created at 2021/5/30 21:44 by mq
 */

namespace liansu;


class Request
{
    private static function _get($method, $key = null, $default = '')
    {
        if ($method === 'GET') {
            return $key === null ? $_GET : ($_GET[$key] ?? $default);
        } else if ($method === 'POST') {
            return $key === null ? $_POST : ($_POST[$key] ?? $default);
        } else if ($method === 'ALL') {
            return $key === null ? $_REQUEST : ($_REQUEST[$key] ?? $default);
        }

        return $default;
    }

    public static function __callStatic($name, $arguments)
    {
        // TODO: Implement __callStatic() method.
        if (in_array(strtoupper($name), ['GET', 'POST', 'ALL']) === true) {
            return self::_get(strtoupper($name), $arguments[0] ?? null, $arguments[1] ?? '');
        }
    }
}