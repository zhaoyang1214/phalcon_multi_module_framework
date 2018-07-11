<?php
namespace App\Home\Controllers;

use Common\BaseController;

class SecurityController extends BaseController {

    public function indexAction() {
        
        $this->view->username = $this->get('username');
        
        // 或者使用会话袋接受参数，需要使用会话袋传递参数
        // $this->view->username = $this->persistent->username;
    }
    
    public function loginAction() {
        if ($this->request->isPost()) {
            // return $this->response->redirect('login', true);  <==> return $this->success('', 'login', true, true);
            // return $this->response->redirect('security/login'); <==> return $this->success('', 'security/login', true);
            // return $this->response->redirect('url/index'); <==> return $this->success('', 'url/index', true);
            // return $this->forward('url/index'); <==> return $this->success('', 'url/index');
            
            if (!$this->security->checkToken()) {
                return $this->error('口令错误');
            }
            
            // 这里并不赞同密码明文传输，建议用MD5加密后传输
            $rules = [
                ['username', 'presenceof', '用户名不能为空'],
                ['username', 'stringlength', '用户名长度必须大于等于6|用户名长度必须小于等于12', [6,12], 1],
                ['password', 'presenceof', '密码不能为空']
            ];
            $validateRes = $this->validate->addRules($rules)->validate($this->post());
            
            /* // 如果需要对参数进行单独过滤，则可以使用如下方法
            $requestData = [
                'username' => $this->post('username', ['alphanum']),// 增加一个字母数字过滤
                'password' => $this->post('password', 'trim'),// 仅使用trim过滤
            ];
            $validateRes = $this->validate->addRules($rules)->validate($requestData); */
            
            if (count($validateRes) > 0){
                return $this->error($validateRes[0]->getMessage());
            }
            $username = $this->post('username');
            $password = $this->post('password');
            
            /* $username = $requestData['username'];
            $password = $requestData['password']; */
            
            // 假设根据账号查出密码为$2y$08$QjRnSTNqbUNoM08vNVJYbueEgW4J0xBO92y2FFDYCoPNi4BbnptvC  ($this->security->hash('123456'))
            $findPwd = '$2y$08$QjRnSTNqbUNoM08vNVJYbueEgW4J0xBO92y2FFDYCoPNi4BbnptvC';
            if(!$this->security->checkHash($password, $findPwd)){
                return $this->error('账号或密码错误');
            }
            // 通常都是把用户信息保存在session中，这里只是模拟使用
            return $this->success('登录成功', 'index?username=' . $username);
            // 或者使用pathinfo模式传递参数，这种方式必须有控制器名
            return $this->success('登录成功', 'security/index/username/' . $username);
            
            // 或者使用会话袋传递参数(数据保存在session中，有效期与session一致),不过该参数只能在本类中使用
            $this->persistent->username = $username;
            return $this->success('登录成功', 'index');
        }
    }
    
}