<?php
namespace liansu;

use liansu\controller\Controller;
use liansu\database\DB;
use liansu\request\Request;

class App extends Base
{
    protected function __construct()
    {
        parent::__construct();
        // 定义目录
        defined('VENDOR_DIRECTORY') or define('VENDOR_DIRECTORY', __DIR__ . '/../../..');
        defined('ROOT_DIRECTORY') or define('ROOT_DIRECTORY', VENDOR_DIRECTORY . '/..');
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
        $r = Request::get('r');
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