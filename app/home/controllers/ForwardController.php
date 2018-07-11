<?php
namespace App\Home\Controllers;

use Common\BaseController;

class ForwardController extends BaseController {

    public function indexAction() {
        return $this->forward('test');
    }
    
    public function testAction() {
        echo __METHOD__,'<br>';
        return $this->forward('test2?a=aaa&b=bbb', 'c=ccc');
    }

    public function test2Action (){
        echo __METHOD__,'<br>';
        var_dump($this->get());
        return $this->forward('index/index/f?e=ee', ['d'=>'ddd']);
    }
    
    public function test3Action (){
        echo __METHOD__,'<br>';
        var_dump($this->get());
        // 如果需要调用其他模块的控制器，需要在配置文件中添加相应的需要注册的命名空间
        // 'App\\Admin\\Controllers' => APP_PATH . 'admin/controllers' . DS
        // 一般推荐使用redirect跳转的其他模块
        return $this->forward('App\Admin\Controllers\index/index?e=ee', ['d'=>'ddd']);
    }
}