<?php
/**
 * 描述：
 * Created at 2021/6/6 22:44 by mq
 */

namespace liansu;


use liansu\trait_set\ViewTrait;

class Controller
{
    use ViewTrait;

    public function success($msg = '操作成功', $data = [])
    {
        $data['_cmd'] = [];
        Response::json(Response::SUCCESS, $msg, $data);
    }

    public function error($msg = '操作失败', $data = [], $stat = 1)
    {
        $data['_cmd'] = [];
        Response::json($stat, $msg, $data);
    }

    public function json($stat, $msg = '', $data = [])
    {
        Response::json($stat, $msg, $data);
    }
}