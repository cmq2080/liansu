<?php
/**
 * 描述：
 * Created at 2020/12/19 21:06 by mq
 */

namespace liansu\config;


trait ConfigTrait
{
    public function setRouteParam($routeParam)
    {
        Config::set('default_route_param', $routeParam);
    }

    public function setAppNamespace($appNamespace)
    {
        Config::set('app_namespace', $appNamespace);
    }
}