<?php
namespace App\Home\Controllers;

use Common\BaseController;

class FlashController extends BaseController {
    
    public function indexAction() {
        
    }
    
    public function forwardAction() {
        // 如果立即输出设为true,设置消息时会立即输出
        if($this->config->services->flash->implicit_flush){
            $this->flash->success('这是一个 flash success 消息【立即输出】');
            exit;
        }
        $this->flash->success('这是一个 flash success 消息【来自forward】');
        $this->flashSession->error('这是一个 flashSession error 消息【来自forward】');
        // 使用forward时$this->flash和$this->flashSession均可，建议使用$this->flash
        return $this->forward('index');
    }
    
    public function redirectAction() {
        $this->flash->error('这是一个 flash error 消息【来自response redirect】');
        $this->flashSession->success('这是一个 flashSession success 消息【来自response redirect】');
        // 使用response->redirect时，只能使用$this->flashSession（保存在session），使用$this->flash无效
        return $this->response->redirect('flash/index');
    }
}