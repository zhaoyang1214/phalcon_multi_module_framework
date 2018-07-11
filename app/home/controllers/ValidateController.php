<?php
/** 
 * @desc 验证 
 * @author zhaoyang 
 * @date 2018年5月11日 下午4:34:57 
 */
namespace App\Home\Controllers;

use Common\BaseController;
use Common\Validate;

class ValidateController extends BaseController {

    public function indexAction() {
        $data = [ 
            // 'username' => 'zhangsan',
            'password' => 123,
            'terms' => 'yes',
            'tel' => '11111',
            // 'age' => '9a',
            'id_number' => '522426198111055653'
        ];
        $rules = [ 
            // ['username', 'presenceof', '用户名不能为空', '', 1, ['cancelOnFail' => true]],验证失败后停止后面的验证
            // [['username', 'age'], 'presenceof', ['username'=>'用户名不能为空','age'=>'年龄不能为空']],
            
            // @formatter:off
            ['username', 'presenceof', '用户名不能为空'],
            ['age', 'presenceof', '年龄不能为空'],
            ['username', 'stringlength', '用户名长度必须大于等于10|用户名长度必须小于等于12', [10,12], 1],
            ['password', 'confirmation', '两次密码必须一致', 'confirmPassword'],
            ['start_time', 'date', '开始时间格式错误', 'Y-m-d H:i:s'],
            // 由于有0的存在，加上第六个参数，检查搜索的数据与数组的值的类型是否相同
            ['status', 'inclusionin', '状态必须只能为0或1或2', [0,1,2], 1, ['strict' => true]],
            ['terms', 'identical', '必须接受条款和协议', 'yes', 1],
            ['tel', 'regex', '手机号格式错误', '/^1[34578]\d{9}$/', 1],
            ['age', 'callback', '年龄必须小于200', function($data){return isset($data['age']) && $data['age']<200 ? true:false; },1],
            ['id_number', 'idnumber', '身份证号错误'],
            // @formatter:on
            // ['age', 'between', '年龄必须在0-150岁之间', [0,150], 1],
        ];
        // var_dump($data, $rules);
        $validate = $this->validate;
        $validate->addRules($rules);
        $messages = $validate->validate($data);
        var_dump($messages, count($messages), $messages->current()->getMessage());
        foreach ($messages as $message){
            echo $message, "<br>";
        }
        exit();
        /* $validate = new Validate();
        $messages = $validate->addRules($rules)->validate($data);
        if ($messages->count()) {
            return $this->sendJson($messages->current()->getMessage(), 10001);
        } */
    }

}