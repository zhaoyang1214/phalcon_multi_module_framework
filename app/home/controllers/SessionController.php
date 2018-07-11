<?php
namespace App\Home\Controllers;

use Common\BaseController;

class SessionController extends BaseController {
    
    public function initialize() {
        echo '<pre>';
        $this->view->disable();
    }

    public function setAction() {
        $this->session->set('name', 'zhaoyang');
        var_dump($this->session);
        exit;
    }
    
    public function getAction() {
        var_dump($this->session->get('name'), $this->session->getId(), $this->session);
        exit;
    }
    
    public function removeAction() {
        if($this->session->has('name')){
            var_dump($this->session->remove('name'));
        }else{
            echo 'name不存在';
        }
    }
}