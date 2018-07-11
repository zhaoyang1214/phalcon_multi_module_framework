<?php
namespace App\Home\Controllers;

use Common\BaseController;

class CryptController extends BaseController {
    
    public function indexAction() {
        $text = '123456';
        $encrypt = $this->crypt->encrypt($text);
        var_dump($this->crypt);
        var_dump('二进制密文：' . $encrypt, '明文：' . $this->crypt->decrypt($encrypt));
        $base64 = $this->crypt->encryptBase64($text);// 相当于base64_encode($this->crypt->encrypt($text));
        var_dump('以base64编码密文：' . $base64, '明文：' . $this->crypt->decryptBase64($base64));
        
        $text = '123456';
        $key = ',lkop/[pl^**pkffwer';
        $encrypt = $this->crypt->encrypt($text, $key); // 传递key就会使用传递的秘钥
        var_dump($this->crypt);
        var_dump('明文：' . $this->crypt->decrypt($encrypt, $key));
        var_dump('不传递key则使用默认key,解不出明文：' . $this->crypt->decrypt($encrypt));
        // 可以配置config来改变key
        $this->config->services->crypt->key = $key;
        $crypt = $this->di->get('crypt');//由于使用set注册的，而不是setShared，所以这种用法每次都会生成新的对象
        var_dump('配置秘钥后解出明文：' . $crypt->decrypt($encrypt), $crypt);
        exit;
    }
}