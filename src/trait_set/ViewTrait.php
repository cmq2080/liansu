<?php
/**
 * 描述：
 * Created at 2021/7/17 21:33 by mq
 */

namespace liansu\trait_set;


trait ViewTrait
{
    protected $assigns = [];
    protected $viewHandler;

    public function assign($key, $value)
    {
        $this->assigns[$key] = $value;
    }
}