<?php
/**
 * @desc 注册cli服务
 * @author: ZhaoYang
 * @date: 2018年6月17日 下午6:51:16
 */
// 引入配置文件
$config = require BASE_PATH . 'config/config_' . NOW_ENV . '.php';

// 引入cli配置文件
$cliConfig = require BASE_PATH . 'cli/config/config_' . NOW_ENV . '.php';

use Common\Common;
use Phalcon\Cache\Backend\Factory as CacheBackendFactory;
use Phalcon\Cache\Frontend\Factory as CacheFrontendFactory;
use Phalcon\Cli\Dispatcher;
use Phalcon\Config;
use Phalcon\Crypt;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Db\Profiler;
use Phalcon\Di\FactoryDefault\Cli;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Logger\Adapter\File as LoggerAdapterFile;
use Phalcon\Logger\Formatter\Line as LoggerFormatterLine;
use Library\Plugins\DbProfilerPlugin;
use Phalcon\Text;

$di = new Cli();

/**
 * @desc 注册配置服务
 * @author: ZhaoYang
 * @date: 2018年6月17日 下午6:55:44
 */
$di->setShared('config', function () use ($config, $cliConfig) {
    $config = new Config($config);
    $config->merge(new Config($cliConfig));
    return $config;
});

/**
 * @desc 注册调度器服务
 * @author: ZhaoYang
 * @date: 2018年6月18日 下午4:38:04
 */
$di->setShared('dispatcher', function () {
    $dispatcher = new Dispatcher();
    return $dispatcher;
});

/**
 * @desc 注册性能分析组件
 * @author zhaoyang
 * @date 2018年5月20日 下午9:34:33
 */
$di->setShared('profiler', function () {
    $profiler = new Profiler();
    return $profiler;
});
    
/**
 * @desc 注册数据库(连接)服务
 * @author zhaoyang
 * @date 2018年5月14日 下午9:01:36
 */
$di->setShared('db', function () {
    $dbConfig = $this->getConfig()->services->db->toArray();
    $mysql = new Mysql($dbConfig['mysql']);
    if ($dbConfig['logged'] ?? false) {
        $eventsManager = new EventsManager();
        $eventsManager->attach('db', new DbProfilerPlugin());
        $mysql->setEventsManager($eventsManager);
    }
    return $mysql;
});
    
/**
 * @desc 注册日志服务
 * @author zhaoyang
 * @date 2018年5月19日 下午6:20:36
 */
$di->set('logger', function (string $file = null, array $line = null) {
    $config = $this->getConfig()->services->logger;
    $linConfig = clone $config->line;
    !is_null($line) && $linConfig = $linConfig->merge(new Config($line));
    $loggerFormatterLine = new LoggerFormatterLine($linConfig->format, $linConfig->date_format);
    $fileConfig = $config->file;
    if (empty($file)) {
        $file = $fileConfig->info;
    } else if (array_key_exists($file, $fileConfig->toArray())) {
        $file = $fileConfig->$file;
    }
    $file = Common::dirFormat($file);
    $dir = dirname($file);
    $mkdirRes = Common::mkdir($dir);
    if (!$mkdirRes) {
        throw new \Exception('创建目录 ' . $dir . ' 失败');
    }
    $loggerAdapterFile = new LoggerAdapterFile($file);
    $loggerAdapterFile->setFormatter($loggerFormatterLine);
    return $loggerAdapterFile;
});

/**
 * @desc 注册加密服务
 * @author zhaoyang
 * @date 2018年5月28日 下午8:17:46
 */
$di->set('crypt', function (string $key = null, int $padding = null, string $cipher = null) {
    $cryptConfig = $this->getConfig()->services->crypt;
    $crypt = new Crypt();
    if (!empty($cryptConfig->key) || !empty($padding)) {
        $crypt->setKey($key ?? $cryptConfig->key);
    }
    if (!empty($cryptConfig->padding) || !empty($key)) {
        $crypt->setPadding($padding ?? $cryptConfig->padding);
    }
    if (!empty($cryptConfig->cipher) || !empty($cipher)) {
        $crypt->setCipher($cipher ?? $cryptConfig->cipher);
    }
    return $crypt;
});

/**
 * @desc 注册缓存
 * @author zhaoyang
 * @date 2018年5月30日 下午10:30:29
 */
$di->set('cache', function (array $options = []) {
    $cacheConfig = $this->getConfig()->services->cache;
    $frontendConfig = $cacheConfig->frontend;
    if (isset($options['frontend']['adapter'])) {
        $frontendOption = new Config($options['frontend']);
        if (array_key_exists($options['frontend']['adapter'], $frontendConfig->toArray())) {
            $frontendOptionClone = clone $frontendConfig->{$options['frontend']['adapter']};
            $frontendOptionClone->merge($frontendOption);
            $frontendOption = $frontendOptionClone;
        }
    } else {
        $frontendOption = clone $frontendConfig->data;
        $frontendOption->adapter = 'data';
    }
    $frontendOption = Common::convertArrKeyUnderline($frontendOption->toArray());
    if (version_compare(PHALCON_VERSION, '3.2.0', '>')) {
        $frontendCache = CacheFrontendFactory::load($frontendOption);
    } else {
        $frontendClassName = 'Phalcon\\Cache\\Frontend\\' . Text::camelize($frontendOption['adapter']);
        $frontendCache = new $frontendClassName($frontendOption);
    }
    $backendConfig = $cacheConfig->backend;
    if (isset($options['backend']['adapter'])) {
        $backendOption = new Config($options['backend']);
        if (array_key_exists($options['backend']['adapter'], $backendConfig->toArray())) {
            $backendOptionClone = clone $backendConfig->{$options['backend']['adapter']};
            $backendOptionClone->merge($backendOption);
            $backendOption = $backendOptionClone;
        }
    } else {
        $backendOption = clone $backendConfig->file;
        $backendOption->adapter = 'file';
    }
    if ($backendOption->adapter == 'file') {
        if (empty($dir = $backendOption->cache_dir)) {
            throw new \Exception('缓存目录不能为空');
        }
        $dir = Common::dirFormat($dir);
        $mkdirRes = Common::mkdir($dir);
        if (!$mkdirRes) {
            throw new \Exception('创建目录 ' . $dir . ' 失败');
        }
    }
    $backendOption = Common::convertArrKeyUnderline($backendOption->toArray());
    if (version_compare(PHALCON_VERSION, '3.2.0', '>')) {
        $backendOption['frontend'] = $frontendCache;
        $backendCache = CacheBackendFactory::load($backendOption);
    } else {
        $backendClassName = 'Phalcon\\Cache\\Backend\\' . Text::camelize($backendOption['adapter']);
        $backendCache = new $backendClassName($frontendCache, $backendOption);
    }
    return $backendCache;
});
    
/**
 * @desc 注册 modelsMetadata服务
 * @author zhaoyang
 * @date 2018年6月2日 下午10:39:43
 */
$di->setShared('modelsMetadata', function () {
    $modelsMetadataConfig = $this->getConfig()->services->models_metadata;
    $backendConfig = $this->getConfig()->services->cache->backend;
    $optionsArr = $modelsMetadataConfig->options->toArray();
    if (!isset($optionsArr['adapter'])) {
        throw new \Exception('modelsMetadata必须设置adapter');
    }
    if (array_key_exists($optionsArr['adapter'], $backendConfig->toArray())) {
        $backendOption = clone $backendConfig->{$optionsArr['adapter']};
        $optionsArr = $backendOption->merge(new Config($optionsArr))->toArray();
    }
    if ($optionsArr['adapter'] == 'files') {
        if (empty($optionsArr['meta_data_dir'])) {
            throw new \Exception('缓存目录不能为空');
        }
        $dir = Common::dirFormat($optionsArr['meta_data_dir']);
        $mkdirRes = Common::mkdir($dir);
        if (!$mkdirRes) {
            throw new \Exception('创建目录 ' . $dir . ' 失败');
        }
    }
    $optionsArr = Common::convertArrKeyUnderline($optionsArr);
    $modelsMetadataClassName = 'Phalcon\\Mvc\\Model\\MetaData\\' . Text::camelize($optionsArr['adapter']);
    $modelsMetadata = new $modelsMetadataClassName($optionsArr);
    return $modelsMetadata;
});
    
/**
 * @desc 注册modelsCache服务
 * @author zhaoyang
 * @date 2018年6月3日 下午6:22:31
 */
$di->set('modelsCache', function (array $options = []) {
    $modelsCacheConfig = clone $this->getConfig()->services->models_cache;
    !empty($options) && $modelsCacheConfig->merge(new Config($options));
    $options = $modelsCacheConfig->toArray();
    $modelsCache = $this->get('cache', [
        $options
    ]);
    return $modelsCache;
});

return $di;