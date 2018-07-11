<?php
namespace App\Admin\Controllers;

use Common\BaseController;

class IndexController extends BaseController {

    public function indexAction() {
        echo __METHOD__, '<br>';
        var_dump($this->get());
        exit();
    }
}