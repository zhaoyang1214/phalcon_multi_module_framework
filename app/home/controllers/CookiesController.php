<?php
namespace App\Home\Controllers;

use Common\BaseController;

class CookiesController extends BaseController {

    public function initialize() {
        echo '<pre>';
        // $this->config->services->cookies->use_encryption = false;
        $this->view->disable();
    }

    public function indexAction() {
        var_dump($this->cookies);
    }

    public function setAction() {
        $this->cookies->set('name', 'zhaoyang<a>aaa</a>', time() + 1000)->set('address', 'xiamen', time() + 100);
        
        // 如果不想设置address,可以删除
        $this->cookies->delete('address');
        var_dump($this->cookies);
    }

    public function getAction() {
        // 由于cookie存储在客户端，为了安全需过滤，这里使用string过滤
        var_dump($this->cookies->has('name'), $this->cookies->get('name')->getValue('string'), $this->cookies->get('address')->getValue('string'));
    }

    public function deleteAction() {
        if ($this->cookies->has('name')) {
            $this->cookies->set('name', null, time() - 1);
            echo '删除成功';
        } else {
            echo 'name不存在';
        }
    }

}