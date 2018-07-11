<?php
namespace App\Home\Controllers;

use Common\BaseController;
use App\Home\Models\Robots;

class ModelsCacheController extends BaseController {

    public function initialize() {
        echo '<pre>';
        $this->view->disable();
    }

    public function indexAction() {
        $robotsList = Robots::find([
            'cache' => [
                'key' => 'mykey',
                'lifetime' => 120,
                // 也可以使用指定的组件服务来缓存数据
                // 'service' => 'modelsCache'
            ]
        ]);
        foreach ($robotsList as $robot){
            echo $robot->id,' ',$robot->name,' ',$robot->type,' ',$robot->weight,'<br/>';
        }
    }

}