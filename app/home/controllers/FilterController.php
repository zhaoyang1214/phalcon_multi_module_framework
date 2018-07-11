<?php
/** 
 * @desc 过滤器 
 * @author zhaoyang 
 * @date 2018年5月8日 下午8:34:43 
 */
namespace App\Home\Controllers;

use Common\BaseController;

class FilterController extends BaseController {
    
    public function getAction() {
        var_dump('$this->dispatcher->getParams()方法获取参数(pathinfo参数)', $this->dispatcher->getParams());
        echo '<hr/>';
        var_dump('$this->request->getQuery()方法获取参数($_GET)', $this->request->getQuery());        
        echo '<hr/>';
        var_dump('$this->get()方法获取参数(使用string,trim过滤)', $this->get());
        echo '<hr/>';
        var_dump('$this->get(null, \'string\')方法获取参数(使用string过滤)', $this->get(null, 'string'));
        echo '<hr/>';
        var_dump('$this->get(null, false)方法获取参数(不过滤)', $this->get(null, false));
        echo '<hr/>';
        var_dump('$this->get(\'a\')方法获取参数(使用string,trim过滤)', $this->get('a'));
        echo '<hr/>';
        var_dump('$this->get(\'a\', \'int\')方法获取参数(使用int过滤)', $this->get('a', 'int'));
        echo '<hr/>';
        var_dump('$this->get(\'c\', [\'int\'])方法获取参数(使用int,string,trim过滤)', $this->get('c', ['int']));
        echo '<hr/>';
        var_dump('$this->get(\'d\', false)方法获取参数(不过滤)', $this->get('d', false));
        exit;
    }
     
    public function postAction() {
        if($this->request->isPost()){
            var_dump('$this->request->getPost()方法获取参数($_POST)', $this->request->getPost());
            echo '<hr/>';
            var_dump('$this->post()方法获取参数(使用string,trim过滤)', $this->post());
            echo '<hr/>';
            var_dump('$this->post(null, \'string\')方法获取参数(使用string过滤)', $this->post(null, 'string'));
            echo '<hr/>';
            var_dump('$this->post(null, false)方法获取参数(不过滤)', $this->post(null, false));
            echo '<hr/>';
            var_dump('$this->post(\'a\')方法获取参数(使用string,trim过滤)', $this->post('a'));
            echo '<hr/>';
            var_dump('$this->post(\'a\', \'int\')方法获取参数(使用int过滤)', $this->post('a', 'int'));
            echo '<hr/>';
            var_dump('$this->post(\'c\', [\'int\'])方法获取参数(使用int,string,trim过滤)', $this->post('c', ['int']));
            echo '<hr/>';
            var_dump('$this->post(\'d\', false)方法获取参数(不过滤)', $this->post('d', false));
            exit;
        }else {
            $url = 'http://phalcon.com/filter/post';
            $data = $this->get(null, false);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_exec($ch);
            curl_close($ch);
        }
    }
    
    public function requestAction(){
        if($this->request->isPost()){
            var_dump('$this->request->get()方法获取参数($_GET or $_POST)', $this->request->get());
            echo '<hr/>';
            var_dump('$this->request()方法获取参数(使用string,trim过滤)', $this->request());
            echo '<hr/>';
            var_dump('$this->request(null, \'string\')方法获取参数(使用string过滤)', $this->request(null, 'string'));
            echo '<hr/>';
            var_dump('$this->request(null, false)方法获取参数(不过滤)', $this->request(null, false));
            echo '<hr/>';
            var_dump('$this->request(\'a\')方法获取参数(使用string,trim过滤)', $this->request('a'));
            echo '<hr/>';
            var_dump('$this->request(\'a\', \'int\')方法获取参数(使用int过滤)', $this->request('a', 'int'));
            echo '<hr/>';
            var_dump('$this->request(\'c\', [\'int\'])方法获取参数(使用int,string,trim过滤)', $this->request('c', ['int']));
            echo '<hr/>';
            var_dump('$this->request(\'d\', false)方法获取参数(不过滤)', $this->request('d', false));
            exit;
        }else {
            $url = $this->request->getScheme() . '://' . $this->request->getHttpHost() . $this->request->getURI();
            $data = [
                'c' => 'postCCC',
                'e' => '<a>eee</a>'
            ];
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_exec($ch);
            curl_close($ch);
        }
    }
    
    public function jsonAction() {
        if($this->request->isPost()){
            var_dump('$this->request->getJsonRawBody(true)方法获取参数(file_get_contents("php://input"))', $this->request->getJsonRawBody(true));
            echo '<hr/>';
            var_dump('$this->json()方法获取参数(使用string,trim过滤)', $this->json());
            echo '<hr/>';
            var_dump('$this->json(null, \'string\')方法获取参数(使用string过滤)', $this->json(null, 'string'));
            echo '<hr/>';
            var_dump('$this->json(null, false)方法获取参数(不过滤)', $this->json(null, false));
            echo '<hr/>';
            var_dump('$this->json(\'a\')方法获取参数(使用string,trim过滤)', $this->json('a'));
            echo '<hr/>';
            var_dump('$this->json(\'a\', \'int\')方法获取参数(使用int过滤)', $this->json('a', 'int'));
            echo '<hr/>';
            var_dump('$this->json(\'c\', [\'int\'])方法获取参数(使用int,string,trim过滤)', $this->json('c', ['int']));
            echo '<hr/>';
            var_dump('$this->json(\'d\', false)方法获取参数(不过滤)', $this->json('d', false));
            exit;
        }else {
            $url = 'http://phalcon.com/filter/json';
            $data = $this->get(null, false);
            $data = json_encode($data);
            $ch = curl_init($url);
            $httpHeaders = [
                'Content-Type: application/json; charset=utf-8',
                'Accept: application/json',
                'Content-Length:' . strlen($data)
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeaders);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_exec($ch);
            curl_close($ch);
        }
    }
    
}