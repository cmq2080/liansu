<?php
namespace liansu;

class Route
{
    private static $rules = [];

    /**
     * 功能：初始化路由规则
     * Created at 2020/7/25 18:26 by mq
     */
    public static function init()
    {
        self::$rules = Config::get('route');
    }

    /**
     * 功能：路由处理
     * Created at 2020/7/25 18:32 by mq
     */
    public static function run($r)
    {
        // 设置默认的controller和action
        $controller = Config::get('default_controller', '');
        $action = Config::get('default_action', '');

        // 截取
        $names = explode('@', $r);
        $controller = (isset($names[0]) === true && $names[0]) ? $names[0] : $controller;
        $controller = self::getController($controller);

        $action = (isset($names[1]) === true && $names[1]) ? $names[1] : $action;

        // 验证路由
        if (class_exists($controller) === false) {
            echo $controller;
            throw new \Exception('controller不存在');
        }

        $class = new \ReflectionClass($controller);
        if ($class->hasMethod($action) === false) { // 通过反射类来查找action的有无，我当时有点猛~~~
            throw new \Exception('action不存在');
        }
        $method = $class->getMethod($action);
        if ($method->isStatic() === true || $method->isPublic() === false) { // 然后再看该方法是否是动态、公有的
            throw new \Exception('action错误');
        }

        return ['controller' => $controller, 'action' => $action];
    }

    /**
     * 功能：获取控制器
     * Created at 2020/10/4 20:37 by mq
     * @param $controller
     * @return mixed|string
     */
    private static function getController($controller)
    {
        if (isset(self::$rules[$controller]) === true) { // 优先采用自定义路由映射
            $controller = self::$rules[$controller];
        }
        $controller = 'app\\' . str_replace('.', '\\', str_replace('/', '\\', $controller));

        return $controller;
    }
}