<?php
// 模块名称
define('MODULE_NAME', 'home');
// 模块命名空间
define('MODULE_NAMESPACE', APP_NAMESPACE . '\\Home');

return [ 
    // 应用配置
    'application' => [ 
        'debug' => [ 
            'state' => true,
            'path' => '' // BASE_PATH . 'runtime/' . MODULE_NAME . '/debug/{YmdH}.log'
        ],
        'error' => [ 
            'path' => BASE_PATH . 'runtime/' . MODULE_NAME . '/error/{YmdH}.log'
        ],
        'loader' => [ 
            'namespaces' => [ 
                MODULE_NAMESPACE . '\\Controllers' => APP_PATH . MODULE_NAME . '/controllers' . DS,
                MODULE_NAMESPACE . '\\Models' => APP_PATH . MODULE_NAME . '/models' . DS
            ]
        ]
    ],
    // 服务配置
    'services' => [ 
        // 调度器配置
        'dispatcher' => [ 
            // 模块默认的命名空间
            'module_default_namespaces' => MODULE_NAMESPACE . '\\Controllers',
            // 处理 Not-Found错误配置
            'notfound' => [ 
                // 错误码及错误提示
                'status_code' => 404,
                'message' => 'Not Found',
                // 错误跳转的页面
                'namespace' => MODULE_NAMESPACE . '\\Controllers',
                'controller' => 'error',
                'action' => 'error404'
            ]
        ],
        // volt引擎相关配置
        'view_engine_volt' => [ 
            // 编译模板目录
            'compiled_path' => BASE_PATH . 'runtime/' . MODULE_NAME . '/compiled/volt' . DS,
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
        // 模板相关配置
        'view' => [ 
            // 模板路径
            'view_path' => APP_PATH . MODULE_NAME . '/views' . DS,
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
                'dateFormat' => 'Y-m-d H:i:s'
            ],
            'file' => [ 
                'alert' => BASE_PATH . 'runtime/' . MODULE_NAME . '/logs/alert/{Y/m/d}/{YmdH}.log',
                'critical' => BASE_PATH . 'runtime/' . MODULE_NAME . '/logs/critical/{Y/m/d}/{YmdH}.log',
                'debug' => BASE_PATH . 'runtime/' . MODULE_NAME . '/logs/debug/{Y/m/d}/{YmdH}.log',
                'error' => BASE_PATH . 'runtime/' . MODULE_NAME . '/logs/error/{Y/m/d}/{YmdH}.log',
                'emergency' => BASE_PATH . 'runtime/' . MODULE_NAME . '/logs/emergency/{Y/m/d}/{YmdH}.log',
                'info' => BASE_PATH . 'runtime/' . MODULE_NAME . '/logs/info/{Y/m/d}/{YmdH}.log',
                'notice' => BASE_PATH . 'runtime/' . MODULE_NAME . '/logs/notice/{Y/m/d}/{YmdH}.log',
                'warning' => BASE_PATH . 'runtime/' . MODULE_NAME . '/logs/warning/{Y/m/d}/{YmdH}.log'
            ]
        ],
        'session' => [ 
            'auto_start' => true,
            'options' => [ 
                'adapter' => 'files',
                'unique_id' => MODULE_NAME
            ]
        ],
        // 加密配置
        'crypt' => [ 
            // 加密秘钥
            'key' => MODULE_NAME,
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
            'backend' => [ 
                // 数据缓存方式，支持memcache、file、redis、mongo、apc、apcu、libmemcached、memory、xcache
                'file' => [ 
                    'cache_dir' => BASE_PATH . 'runtime/' . MODULE_NAME . '/cache/'
                ]
            ]
        ],
        // 模型元数据缓存配置
        'models_metadata' => [ 
            'options' => [ 
                // 适配器，默认使用memory(内存),还支持apc、apcu、files、libmemcached、memcache、redis、session、xcache
                'adapter' => 'files',
                'meta_data_dir' => BASE_PATH . 'runtime/' . MODULE_NAME . '/models_metadata/'
            ]
        ],
        // 模型缓存配置
        'models_cache' => [ 
            'frontend' => [ 
                'adapter' => 'data',
                'lifetime' => 86400
            ],
            'backend' => [ 
                'adapter' => 'file',
                'cache_dir' => BASE_PATH . 'runtime/' . MODULE_NAME . '/models_cache/'
            ]
        ],
        // 视图缓存配置
        'view_cache' => [ 
            'frontend' => [ 
                'adapter' => 'output',
                'lifetime' => 20
            ],
            'backend' => [ 
                'adapter' => 'file',
                'cache_dir' => BASE_PATH . 'runtime/' . MODULE_NAME . '/cache/view/',
                'safekey' => false,
                'prefix' => ''
            ]
        ],
        // url配置
        'url' => [ 
            'base_uri' => '/' . MODULE_NAME . '/',
            'static_base_uri' => '/' . MODULE_NAME . '/static/',
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
            // 是否立即输出，必须设为true，否则调用->output()不输出
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