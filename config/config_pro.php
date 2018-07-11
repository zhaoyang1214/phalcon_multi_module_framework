<?php
/**
 * @desc 全局配置文件
 * @author zhaoyang
 * @date 2018年5月3日 下午7:54:47
 */
return [
    // 应用配置
    'application' => [
        'debug' => [
            'state' => false,
            'path' => BASE_PATH . 'runtime/debug/{YmdH}.log'
        ],
        'error' => [
            'path' => BASE_PATH . 'runtime/error/{YmdH}.log'
        ],
        // 自动加载
        'loader' => [
            // 文件扩展名
            'extensions' => [
                'php'
            ],
            'classes' => [
                'Smarty' => BASE_PATH . 'library/vendors/smarty/Smarty.class.php'
            ],
            'namespaces' => [
                'Common' => BASE_PATH . 'common/',
                'Library\\Adapter' => BASE_PATH . 'library/adapter/',
                'Library\\Extensions' => BASE_PATH . 'library/extensions/',
                'Library\\Plugins' => BASE_PATH . 'library/plugins/',
                'Library\\Tools' => BASE_PATH . 'library/tools/',
                'Library\\Validators' => BASE_PATH . 'library/validators/'
            ],
            'files' => [
            ],
            'directories' => [
            ]
        ]
    ],
    // 服务配置
    'services' => [
        // mysql数据库配置
        'db' => [
            // 是否记录执行的mysql语句
            'logged' => true,
            // 记录执行时间超过0秒的mysql语句
            'max_execute_time' => 0,
            // 比较时间到小数点后几位
            'scale' => 5,
            'log_path' => BASE_PATH . 'runtime/mysql/{Y/m/d}/{YmdH}.log',
            // 使用动态更新
            'use_dynamic_update' => true,
            // ORM选项配置
            'orm_options' => [
                // 是否对字段是否为空的判断
                'not_null_validations' => false
            ],
            'mysql' => [
                'host' => 'localhost',
                'port' => 3306,
                'username' => 'root',
                'password' => '123456',
                'dbname' => 'phalcon',
                'charset' => 'utf8'
            ]
        ],
        // 调度器配置
        'dispatcher' => [
            // 处理 Not-Found错误配置
            'notfound' => [
                // 错误码及错误提示
                'status_code' => 404,
                'message' => 'Not Found',
                // 错误跳转的页面
                'namespace' => DEFAULT_MODULE_NAMESPACE . '\\Controllers',
                'controller' => 'error',
                'action' => 'error404'
            ]
        ],
        // volt引擎相关配置
        'view_engine_volt' => [
            // 编译模板目录
            'compiled_path' => BASE_PATH . 'runtime/' . DEFAULT_MODULE . '/compiled/volt' . DS,
            // 是否实时编译
            'compile_always' => false,
            // 附加到已编译的PHP文件的扩展名
            'compiled_extension' => '.php',
            // 使用这个替换目录分隔符
            'compiled_separator' => '%%',
            // 是否要检查在模板文件和它的编译路径之间是否存在差异
            'stat' => true,
            // 模板前缀
            'prefix' => '',
            // 支持HTML的全局自动转义
            'autoescape' => false
        ],
        // smarty引擎相关配置,直接配置smarty参数
        'view_engine_smarty' => [
            'compile_dir' => BASE_PATH . 'runtime/' . DEFAULT_MODULE . '/compiled/smarty' . DS,
            'caching' => false,
            'cache_lifetime' => 3600,
            'cache_dir' => BASE_PATH . 'runtime/' . DEFAULT_MODULE . '/cache/smarty' . DS
        ],
        // 模板相关配置
        'view' => [
            // 模板路径
            'view_path' => APP_PATH . DEFAULT_MODULE . '/views' . DS,
            // 模板引擎,根据模板后缀自动匹配视图引擎，不启用则设为false
            'engines' => [
                '.volt' => 'viewEngineVolt',
                '.phtml' => 'viewEnginePhp',
                '.html' => 'viewEngineSmarty'
            ],
            'disable_level' => [
                'level_action_view' => false,
                'level_before_template' => true,
                'level_layout' => true,
                'level_after_template' => true,
                'level_main_layout' => true
            ]
        ],
        // 过滤器设置
        'filter' => [
            // 过滤类型，支持string、trim、absint、int、email、float、int!、float!、alphanum、striptags、lower、upper、url、special_chars
            'default_filter' => 'string,trim'
        ],
        // 文件日志,formatter常用line，adapter常用file
        'logger' => [
            'line' => [
                'format' => '[%date%][%type%] %message%',
                'date_format' => 'Y-m-d H:i:s'
            ],
            'file' => [
                'alert' => BASE_PATH . 'runtime/' . DEFAULT_MODULE . '/logs/alert/{Y/m/d}/{YmdH}.log',
                'critical' => BASE_PATH . 'runtime/' . DEFAULT_MODULE . '/logs/critical/{Y/m/d}/{YmdH}.log',
                'debug' => BASE_PATH . 'runtime/' . DEFAULT_MODULE . '/logs/debug/{Y/m/d}/{YmdH}.log',
                'error' => BASE_PATH . 'runtime/' . DEFAULT_MODULE . '/logs/error/{Y/m/d}/{YmdH}.log',
                'emergency' => BASE_PATH . 'runtime/' . DEFAULT_MODULE . '/logs/emergency/{Y/m/d}/{YmdH}.log',
                'info' => BASE_PATH . 'runtime/' . DEFAULT_MODULE . '/logs/info/{Y/m/d}/{YmdH}.log',
                'notice' => BASE_PATH . 'runtime/' . DEFAULT_MODULE . '/logs/notice/{Y/m/d}/{YmdH}.log',
                'warning' => BASE_PATH . 'runtime/' . DEFAULT_MODULE . '/logs/warning/{Y/m/d}/{YmdH}.log'
            ]
        ],
        // session配置
        'session' => [
            // 是否自动开启 SESSION
            'auto_start' => true,
            'options' => [
                'adapter' => 'files',
                'unique_id' => DEFAULT_MODULE
            ]
            // @formatter:off
            /* // phalcon提供了四种适配器，分别是files、memcache、redis、libmemcached
             'options' => [
             'adapter'    => 'memcache',
             'unique_id' => DEFAULT_MODULE,
             'prefix' => DEFAULT_MODULE,
             'persistent' => true,
             'lifetime' => 3600
             ],
             'options' => [
             'adapter'    => 'redis',
             'unique_id' => DEFAULT_MODULE,
             'prefix' => DEFAULT_MODULE,
             'auth' => '',
             'persistent' => false,
             'lifetime' => 3600,
             'index' => 1
             ] */
            // @formatter:on
        ],
        // 加密配置
        'crypt' => [
            // 加密秘钥
            'key' => DEFAULT_MODULE,
            // 填充方式，默认是0（PADDING_DEFAULT），1（PADDING_ANSI_X_923）、2（PADDING_PKCS7）、3（PADDING_ISO_10126）、4（PADDING_ISO_IEC_7816_4）、5（PADDING_ZERO）、6（PADDING_SPACE）
            'padding' => '',
            // 加密方法，默认是"aes-256-cfb"
            'cipher' => ''
        ],
        // cookies配置
        'cookies' => [
            // 是否使用加密,使用加密必须要设置crypt 的key值
            'use_encryption' => true
        ],
        // 缓存配置
        'cache' => [
            'frontend' => [
                // 数据处理方式，支持data（序列化）、json、base64、none、output、igbinary、msgpack
                'data' => [
                    'lifetime' => 172800
                ],
                'output' => [
                    'lifetime' => 172800
                ]
            ],
            'backend' => [
                // 数据缓存方式，支持memcache、file、redis、mongo、apc、apcu、libmemcached、memory、xcache
                'file' => [
                    'cache_dir' => BASE_PATH . 'runtime/' . DEFAULT_MODULE . '/cache/',
                    // 对保存的键名进行md5加密
                    'safekey' => true,
                    'prefix' => ''
                ],
                'memcache' => [
                    'host' => 'localhost',
                    'port' => '11211',
                    'persistent' => false,
                    'prefix' => '',
                    // 默认情况下禁用对缓存键的跟踪
                    'stats_key' => ''
                ],
                'redis' => [
                    'host' => '127.0.0.1',
                    'port' => 6379,
                    'auth' => '',
                    'persistent' => false,
                    'prefix' => '',
                    'stats_key' => '',
                    'index' => 0
                ]
            ]
        ],
        // 模型元数据缓存配置
        'models_metadata' => [
            'options' => [
                // 适配器，默认使用memory(内存),还支持apc、apcu、files、libmemcached、memcache、redis、session、xcache
                'adapter' => 'files',
                'meta_data_dir' => BASE_PATH . 'runtime/' . DEFAULT_MODULE . '/models_metadata/'
            ]
            // @formatter:off
            /* 'options' => [
             'adapter' => 'files',
             'meta_data_dir' => BASE_PATH . 'runtime/' . DEFAULT_MODULE . '/models_metadata/'
             ],
             'options' => [
             'adapter'    => 'memcache',
             'unique_id' => DEFAULT_MODULE,
             'prefix' => DEFAULT_MODULE,
             'persistent' => true,
             'lifetime' => 3600
             ],
             'options' => [
             'adapter' => 'memory',
             ],
             'options' => [
             'adapter'    => 'redis',
             'unique_id' => DEFAULT_MODULE,
             'prefix' => DEFAULT_MODULE,
             'auth' => '',
             'persistent' => false,
             'lifetime' => 3600,
             'index' => 1
             ],
             'options' => [
             'adapter' => 'session',
             'prefix' => DEFAULT_MODULE,
             ] */
            // @formatter:on
        ],
        // 模型缓存配置
        'models_cache' => [
            'frontend' => [
                'adapter' => 'data',
                'lifetime' => 86400
            ],
            'backend' => [
                'adapter' => 'file',
                'cache_dir' => BASE_PATH . 'runtime/' . DEFAULT_MODULE . '/models_cache/'
            ]
        ],
        // 视图缓存配置
        'view_cache' => [
            'frontend' => [
                'adapter' => 'output',
                'lifetime' => 86400
            ],
            'backend' => [
                'adapter' => 'file',
                'cache_dir' => BASE_PATH . 'runtime/' . DEFAULT_MODULE . '/cache/view/',
                'prefix' => ''
            ]
        ],
        // url配置
        'url' => [
            'base_uri' => '/',
            'static_base_uri' => '/',
            'base_path' => ''
        ],
        'flash' => [
            // 消息class属性值
            'css_classes' => [
                'error' => 'alert alert-danger',
                'success' => 'alert alert-success',
                'notice' => 'alert alert-info',
                'warning' => 'alert alert-warning'
            ],
            // 是否在生成的html中设置自动转义模式
            'autoescape' => true,
            // 是否必须使用HTML隐式格式化输出
            'automatic_html' => true,
            // 是否立即输出，为true时，调用$this->flash->message()或其他设置消息(例如success)时，消息立即输出(echo)
            // 为false时，消息不会输出，会保存在flash对象中并返回消息$res = $this->flash->success('my message');
            'implicit_flush' => false
        ],
        'flash_session' => [
            // 消息class属性值
            'css_classes' => [
                'error' => 'alert alert-danger',
                'success' => 'alert alert-success',
                'notice' => 'alert alert-info',
                'warning' => 'alert alert-warning'
            ],
            // 是否在生成的html中设置自动转义模式
            'autoescape' => true,
            // 是否必须使用HTML隐式格式化输出
            'automatic_html' => true,
            // 是否立即输出，必须设为true（默认为true），否则调用->output()不输出
            'implicit_flush' => true
        ],
        // 安全配置
        'security' => [
            // 设置由openssl伪随机生成器生成的字节数
            'random_bytes' => 16,
            // 设置默认hash,0=7(CRYPT_BLOWFISH_Y),1(CRYPT_STD_DES),2(CRYPT_EXT_DES),3(CRYPT_MD5),4(CRYPT_BLOWFISH),5(CRYPT_BLOWFISH_A),6(CRYPT_BLOWFISH_X),8(CRYPT_SHA256),9(CRYPT_SHA512)
            'default_hash' => 7,
            'work_factor' => 8
        ]
    ]
    
];