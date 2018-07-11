<?php
namespace App\Home\Controllers;

use Common\BaseController;
use Phalcon\Application\Exception;

class IndexController extends BaseController {

    public function indexAction() {
        echo __METHOD__, '<br>';
        var_dump($this->get());
        exit();
    }

    public function testAction() {
        // throw new \Exception('系统错误');
        
        // $this->config->application->debug->state = false;// 错误会写入error下的path文件中
        try {
            $this->test1Action();
        } catch (\Exception $e) {
            throw new Exception('系统错误:' . $e->getMessage(), -10000, $e);
        }
        throw new Exception('test错误');
    }

    public function test1Action() {
        throw new Exception('test1错误');
    }
}