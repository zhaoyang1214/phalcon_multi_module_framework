<?php
namespace App\Home\Controllers;

use Common\BaseController;

class UrlController extends BaseController {
    
    public function indexAction() {
        $this->view->url1 = $this->url->get('url/test1');
    }
    
    public function test1Action(){
        echo __METHOD__;
        exit;
    }
    
    public function test2Action(){
        echo __METHOD__;
        exit;
    }
}