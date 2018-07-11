<?php
namespace App\Home\Controllers;

use Common\BaseController;

class CacheController extends BaseController {

    public function initialize() {
        echo '<pre>';
        $this->view->disable();
    }

    public function setAction() {
        // 默认使用frontend使用data序列化数据，backend使用file存储（会在home下生成相关目录和文件），
        $cache = $this->cache;
        // 使用memcache存储
//         $cache = $this->di->get('cache', [ 
//             [ 
//                 'backend' => [ 
//                     'adapter' => 'memcache'
//                 ]
//             ]
//         ]);
        
        $res = $cache->save('info', [ 
            'name' => 'zhaoy',
            'addr' => 'xiamen'
        ]);
        var_dump($cache, $res);
    }

    public function getAction() {
        $info = $this->cache->get('info');
//         $info = $this->di->get('cache', [ 
//             [ 
//                 'backend' => [ 
//                     'adapter' => 'memcache'
//                 ]
//             ]
//         ])->get('info');
        var_dump($info);
    }

    public function deleteAction() {
        $cache = $this->cache;
//         $cache = $this->di->get('cache', [ 
//             [ 
//                 'backend' => [ 
//                     'adapter' => 'memcache'
//                 ]
//             ]
//         ]);
        if ($cache->exists('info')) {
            $res = $cache->delete('info');
            var_dump($res);
        } else {
            echo 'info不存在';
        }
    }

}