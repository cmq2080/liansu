<?php
namespace liansu\database;

use liansu\Config;

class DB
{
    private static $type = 'mysql';
    private static $server;
    private static $username;
    private static $password;
    private static $database;
    private static $charset = 'utf8';
    private static $port = 3306;
    private static $prefix = '';

    public static $instance;

    public static function connect($config = null)
    {
        if ($config === null) { // 默认从db配置文件中获取
            $config = Config::get('db', []);
        }
        if (!$config) {
            throw new \Exception('连接配置未找到');
        }

        // 相当于重置了一次数据库链接，所以实例也得重置
        self::$instance = null;
        foreach ($config as $name => $value) {
            if (in_array($name, ['type', 'server', 'username', 'password', 'database', 'charset', 'port', 'prefix']) === true) {
                self::$$name = $value;
            }
        }
    }

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new \Medoo\Medoo([
                'database_type' => self::$type,
                'server' => self::$server,
                'username' => self::$username,
                'password' => self::$password,
                'database_name' => self::$database,
                'charset' => self::$charset,
                'port' => self::$port,
                'prefix' => self::$prefix,
            ]);
        }

        return self::$instance;
    }
}