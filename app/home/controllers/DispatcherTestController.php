<?php
/** 
 * @desc 测试调度器 
 * @author zhaoyang 
 * @date 2018年5月7日 下午10:13:47 
 */
namespace App\Home\Controllers;

use Phalcon\Mvc\Controller;

class DispatcherTestController extends Controller {
    
    public function index1Action($param1, $param2, $param3, $param4) {
        var_dump($param1, $param2, $param3, $param4);
        exit;
    }
    
    public function index2Action() {
        echo '使用dispatcher分别获取参数：';
        var_dump($this->dispatcher->getParam(0));
        var_dump($this->dispatcher->getParam(1));
        var_dump($this->dispatcher->getParam(2));
        var_dump($this->dispatcher->getParam(3));
        echo '<hr/>使用dispatcher获取所有参数:';
        var_dump($this->dispatcher->getParams());
        echo '<hr/>使用router获取所有参数:';
        var_dump($this->router->getParams());
        exit;
    }
    
    public function index3Action() {
        echo '使用dispatcher分别获取参数：';
        var_dump($this->dispatcher->getParam('a'));
        var_dump($this->dispatcher->getParam('b'));
        echo '<hr/>使用dispatcher获取所有参数:';
        var_dump($this->dispatcher->getParams());
        exit;
    }
}