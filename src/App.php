<?php
/**
 * 描述：
 * Created at 2021/5/30 21:24 by mq
 */

namespace liansu;


class App
{
    private static $instance = null;
    private $routeParam = 'r';
    private $namespace = 'app';
    private $initItems = [
        'liansu/Config',
        'liansu/Route',
    ];

    private $defaultApp = 'index@index';

    private $_controller = '';
    private $_action = '';

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        // 定义常量们
        defined('PUBLIC_DIRECTORY') || define('PUBLIC_DIRECTORY', realpath($_SERVER['DOCUMENT_ROOT']));
        defined('ROOT_DIRECTORY') || define('ROOT_DIRECTORY', realpath(PUBLIC_DIRECTORY . '/..'));
        defined('CONFIG_DIRECTORY') || define('CONFIG_DIRECTORY', realpath(ROOT_DIRECTORY . '/config'));
        defined('VENDOR_DIRECTORY') || define('VENDOR_DIRECTORY', realpath(ROOT_DIRECTORY . '/vendor'));
        defined('RUNTIME_DIRECTORY') || define('RUNTIME_DIRECTORY', realpath(ROOT_DIRECTORY . '/runtime'));

        // 初始化各个类
        $this->runInitItems();
    }

    public function run()
    {
        // 接收参数
        $app = Request::get($this->routeParam);
        if (!$app) {
            $app = $this->defaultApp;
        }
        if (!$app) {
            throw new \Exception('No App Found');
        }

        // 找寻路由
        $app = Route::find($app);

        // 解析路由
        $controller = Route::parseStr($app);
        $controller = $this->namespace . '\\' . $controller;
        $action = Route::parseStr($app, 'action');
//        var_dump($controller);
//        var_dump($action);

        // 实例化控制器类并执行动作
        Route::execute($controller, $action);
    }

    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }

    public function setRouteParam($routeParam)
    {
        $this->routeParam = $routeParam;
        return $this;
    }

    public function setDefaultApp($app)
    {
        $this->defaultApp = $app;
    }

    public function addInitItems(...$initItems)
    {
        foreach ($initItems as $initItem) {
            if (is_array($initItem) === true) {
                foreach ($initItem as $item) {
                    $this->initItems[] = $item;
                }
            } else {
                $this->initItems[] = $initItem;
            }
        }
    }

    private function runInitItems()
    {
        foreach ($this->initItems as $initItem) {
            $initItem = str_replace('/', '\\', $initItem);
            if (class_exists($initItem) === false) {
                throw new \Exception('初始化类不存在');
            }
            $initItem::initialize();
        }
    }

    public function setController($controller)
    {
        $this->_controller = $controller;
        return $this;
    }

    public function getController()
    {
        return $this->_controller;
    }

    public function setAction($action)
    {
        $this->_action = $action;
        return $this;
    }

    public function getAction()
    {
        return $this->_action;
    }

}