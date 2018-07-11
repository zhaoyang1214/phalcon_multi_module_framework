<?php
// phalcon版本
define('PHALCON_VERSION', Phalcon\Version::get());

//重新命名文件分隔符，建议路径后面加上分隔符
define('DS', DIRECTORY_SEPARATOR);

// 应用程序名称（应用程序所在目录名）
define('APP_NAME', 'app');

// 顶级命名空间
define('APP_NAMESPACE', 'App');

// 项目根目录
define('BASE_PATH', dirname(__DIR__) . DS);

// 应用程序所在目录
define('APP_PATH', BASE_PATH . APP_NAME . DS);

// 模块列表
// @formatter:off
define('MODULE_ALLOW_LIST', ['home', 'admin']);
// @formatter:on

// 默认模块
define('DEFAULT_MODULE', 'home');

// 默认模块命名空间
define('DEFAULT_MODULE_NAMESPACE', APP_NAMESPACE . '\\Home');

// 默认使用的配置文件名
define('NOW_ENV', 'dev');