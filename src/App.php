<?php
namespace liansu;

use liansu\config\Config;
use liansu\config\ConfigTrait;
use liansu\controller\Controller;
use liansu\database\DB;
use liansu\request\Request;
use liansu\route\Route;

class App
{
    use ConfigTrait;

    public static $instance = null;

    /**
     * 功能：获取实例
     * Created at 2020/12/19 20:31 by mq
     * @return App|null
     */
    public static function instance()
    {
        if (self::$instance === null || get_class(self::$instance) !== static::class) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    protected function __construct()
    {
        // 定义目录
        defined('ROOT_DIRECTORY') or define('ROOT_DIRECTORY', realpath(__DIR__ . '/../../../..'));
        defined('VENDOR_DIRECTORY') or define('VENDOR_DIRECTORY', ROOT_DIRECTORY . '/vendor');
        defined('APP_DIRECTORY') or define('APP_DIRECTORY', ROOT_DIRECTORY . '/app');
        defined('CONFIG_DIRECTORY') or define('CONFIG_DIRECTORY', ROOT_DIRECTORY . '/config');
        defined('RUNTIME_DIRECTORY') or define('RUNTIME_DIRECTORY', ROOT_DIRECTORY . '/runtime');

        // 各个辅助类初始化
        Config::init();
        DB::connect(Config::get('db'));
        Route::init();
    }

    public function run()
    {
        // 初始化
        // 获取请求
        // 解析路由
        // 创建控制器实例
        // 运行控制器实例并响应
        $rParams = Config::get('default_route_param', 'r');
        $r = Request::get($rParams);
        $result = Route::run($r);
        $controller = $result['controller'];
        $action = $result['action'];

        $this->takeAction(new $controller, $action);
    }

    private function takeAction(Controller $controller, $action)
    {
        // 2020-7-25 19:36:01，连速框架正式alive
        // 记住这个时刻！！！
        $controller->$action();
    }
}