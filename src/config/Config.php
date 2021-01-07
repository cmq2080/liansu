<?php
namespace liansu\config;

class Config
{
    private static $vars = [];

    /**
     * 功能：初始化配置
     * Created at 2020/7/25 18:27 by mq
     */
    public static function init()
    {
        $files = scandir(CONFIG_DIRECTORY);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..' || is_file(CONFIG_DIRECTORY . '/' . $file) === false) { // 不是文件，算了
                continue;
            }
            if (pathinfo($file, PATHINFO_EXTENSION) !== 'php') { // 还必须得是php文件
                continue;
            }

            // app.php文件作主配置
            if (pathinfo($file, PATHINFO_BASENAME) === 'app.php') {
                self::$vars = require_once CONFIG_DIRECTORY . '/' . $file;
            } else { // 其它文件做辅配置，级别低一级
                $key = pathinfo($file, PATHINFO_FILENAME);
                self::$vars[$key] = require_once CONFIG_DIRECTORY . '/' . $file;
            }
        }
    }

    /**
     * 功能：获取配置
     * Created at 2020/7/25 18:29 by mq
     * @param $name
     * @param string $default
     * @return array|mixed|null
     */
    public static function get($name, $default = '')
    {
        // 以.为分界，数组分级获取
        $keys = explode('.', $name);
        $var = self::$vars;
        foreach ($keys as $key) {
            if (isset($var[$key]) === false) {
                return $default;
            }

            $var = $var[$key];
        }

        return $var;
    }

    /**
     * 功能：设置配置
     * Created at 2020/7/25 18:29 by mq
     * @param $name
     * @param $value
     */
    public static function set($name, $value)
    {
        // 直接设置，不分级
        self::$vars[$name] = $value;
    }

    public static function all()
    {
        return self::$vars;
    }
}