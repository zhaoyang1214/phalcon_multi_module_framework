<?php
namespace App\Home\Controllers;

use Common\BaseController;
use Library\Tools\HttpCurl;

class HttpCurlController extends BaseController {

    public function indexAction() {
        // 简化请求流程，不做签名和加密
        /* $requestData = [
            'a' => '10a',
            'b' => 15
        ]; */
        $requestData = [
            'a' => 10,
            'b' => 15
        ];
        $url = 'http://phalcon.com/admin/index/test';
        $httpCurl = new HttpCurl($url);
        $res = $httpCurl->execPost($requestData);
        if($res === false){
            var_dump($httpCurl->getError());
            exit;
        }
        var_dump($res, json_decode($res, true));
        exit;
    }
}