<?php
/**
 * @desc 路由规则
 * @author zhaoyang
 * @date 2018年5月3日 下午7:59:20
 */
$defaultRouters = [
    '/' => [
        'namespace' => DEFAULT_MODULE_NAMESPACE . '\\Controllers',
        'module' => DEFAULT_MODULE,
        'controller' => 'index',
        'action' => 'index'
    ],
    '/:controller' => [
        'namespace' => DEFAULT_MODULE_NAMESPACE . '\\Controllers',
        'module' => DEFAULT_MODULE,
        'controller' => 1,
        'action' => 'index'
    ],
    '/:controller/:action' => [
        'namespace' => DEFAULT_MODULE_NAMESPACE . '\\Controllers',
        'module' => DEFAULT_MODULE,
        'controller' => 1,
        'action' => 2
    ],
    '/:controller/:action/:params' => [
        'namespace' => DEFAULT_MODULE_NAMESPACE . '\\Controllers',
        'module' => DEFAULT_MODULE,
        'controller' => 1,
        'action' => 2,
        'params' => 3
    ]
];

$routers = [ ];
foreach (MODULE_ALLOW_LIST as $v) {
    $vUcfirst = ucfirst($v);
    $routers['/' . $v] = [
        'namespace' => APP_NAMESPACE . '\\' . $vUcfirst . '\\Controllers',
        'module' => $v,
        'controller' => 'Index',
        'action' => 'index'
    ];
    $routers['/' . $v . '/:controller'] = [
        'namespace' => APP_NAMESPACE . '\\' . $vUcfirst . '\\Controllers',
        'module' => $v,
        'controller' => 1,
        'action' => 'index'
    ];
    $routers['/' . $v . '/:controller/:action'] = [
        'namespace' => APP_NAMESPACE . '\\' . $vUcfirst . '\\Controllers',
        'module' => $v,
        'controller' => 1,
        'action' => 2
    ];
    $routers['/' . $v . '/:controller/:action/:params'] = [
        'namespace' => APP_NAMESPACE . '\\' . $vUcfirst . '\\Controllers',
        'module' => $v,
        'controller' => 1,
        'action' => 2,
        'params' => 3
    ];
}
return array_merge($defaultRouters, $routers);