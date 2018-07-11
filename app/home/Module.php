<?php
/**
 * @desc 模块配置
 * @author zhaoyang
 * @date 2018年5月3日 下午8:49:49
 */
namespace App\Home;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Config\Adapter\Php as ConfigAdapterPhp;

class Module implements ModuleDefinitionInterface {

    // 模块配置文件目录
    private static $_configPath = __DIR__ . '/config/config_' . NOW_ENV . '.php';

    public function registerAutoloaders(DiInterface $di = NULL) {
        $this->registerConfigService($di);
        $config = $di->getConfig();
        $loaderConfig = $config->application->loader->toArray();
        $loader = new Loader();
        $loader->registerClasses($loaderConfig['classes'])
        ->registerNamespaces($loaderConfig['namespaces'])
        ->registerFiles($loaderConfig['files'])
        ->registerDirs($loaderConfig['directories'])
        ->register();
    }

    public function registerServices(DiInterface $di) {
        // 这里可以注册和重写服务
        // 注册配置文件服务,合并主配置和模块配置
        // $this->registerConfigService($di);
    }

    /**
     * @desc 注册配置服务
     * @author zhaoyang
     * @date 2018年5月3日 下午8:50:51
     */
    private function registerConfigService(DiInterface $di) {
        $config = $di->getConfig();
        $di->setShared('config', function () use ($config) {
            $moduleConfigPath = self::$_configPath;
            if (is_file($moduleConfigPath)) {
                $override = new ConfigAdapterPhp($moduleConfigPath);
                $config->merge($override);
            }
            return $config;
        });
    }
}