<?php
namespace App\Home\Controllers;

use Common\BaseController;
use Phalcon\Logger;

class LoggerController extends BaseController {

    public function indexAction() {
        // 对于非单例模式(set())
        // 以下四种写法均为同一实例（单例）
        // $this->logger
        // $this->di['logger']
        // $this->di->getShared('logger')
        // $this->getDi()->getShared('logger')
        // 以下四种写法均为不同实例（不同对象）
        // $this->di->getLogger()
        // $this->getDi()->getLogger()
        // $this->di->get('logger')
        // $this->di->get('logger', 参数)
        
        // 对于单例模式(setShared())
        // 以上所有写法均为同一实例（单例）
        
        
        $this->logger->log('This is an info message1', Logger::INFO);
        
        $this->logger->info('This is an info message2');
        
        $this->di->getLogger()->info('This is an info message3');
        
        $this->getDi()->getLogger()->info('This is an info message4');
        
        $this->di['logger']->info('This is an info message5');
        
        $this->di->get('logger')->info('This is an info message6');
        
        $this->di->get('logger', [
            null,
            [
                'format' => '[%type%][%date%] %message%',
                'date_format' => 'm-d H:i:s'
            ]
        ])->info('This is an info message7');
        
        $this->di->get('logger', ['alert'])->alert('This is an alert message1');
        
        $this->di->get('logger', [
            'alert',
            [
                'format' => '[%type%][%date%] %message%',
                'date_format' => 'm-d H:i:s'
            ]
        ])->alert('This is an alert message2');
        
        $file = BASE_PATH . 'runtime/' . MODULE_NAME . '/logs/alert1111/{Y/m/d}/{YmdH}.log';
        
        $this->di->get('logger', [$file])->alert('This is an alert1111 message');
        
        exit();
    }

}