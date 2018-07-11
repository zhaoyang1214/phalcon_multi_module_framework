<?php
namespace App\Home\Controllers;

use Common\BaseController;

class SmartyController extends BaseController {

    public function indexAction() {
        $this->view->name = 'smarty';
        $this->view->state = '模板引擎启用成功';
    }
}