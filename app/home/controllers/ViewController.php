<?php
/**
 * @desc 测试视图
 * @author zhaoyang
 * @date 2018年5月4日 下午5:45:49
 */
namespace App\Home\Controllers;

use Phalcon\Mvc\Controller;

class ViewController extends Controller {

    public function voltAction() {
        $this->view->name = 'volt';
    }

    public function phpAction() {
        $this->view->name = 'php';
    }

    public function indexAction() {
        // 不指定缓存key，默认使用md5(控制器名/方法名)
        // 如果配置文件safekey设为true,则$cacheKey = md5(md5('view/index'));
        $cacheKey = md5('view/index');
        $view = $this->view;
        $view->cache(true);
        if ($view->getCache()->exists($cacheKey)) {
            return;
        }
        // 查询数据
        // ...
        $view->key = $cacheKey;
        $view->age = '11aa';
        $view->arr = [1, 2, 3, time()];
    }
}