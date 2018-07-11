<?php
namespace App\Home\Models;

use Common\BaseModel;
// use Common\Validate;

class Robots extends BaseModel {
    
    public function initialize() {
        parent::initialize();
        $this->setSource('ph_robots');
    }
    
    /** 
     * @desc 插入之前验证 
     * @author zhaoyang 
     * @date 2018年5月16日 下午10:57:48 
     */
    public function beforeValidationOnCreate() {
        $rules = [
            //表示name插入时必须验证
            ['name', 'regex', '姓名必须为6-10位数字字母下划线', '/^[a-zA-Z\d_]{6,10}$/', 1],
            // 或者这么写
//             ['name', 'alnum', '姓名必须为字母数字', '', 1],
//             ['name', 'stringlength', '姓名长度为6-10位', [6,10], 1],
            ['name', 'uniqueness', '姓名已存在', '', 1],
            // 表示插入时必须验证
            ['type', 'inclusionin', '类型只能为1,2,3', [1,2,3], 1],
            // 也可以这么写
//             ['type', 'callback', '类型只能为1,2,3', function ($data) {
//                                                     $type = $data->type ?? null;
//                                                     if (in_array($type, [1, 2, 3])){
//                                                         return true;
//                                                     }else{
//                                                         return false;
//                                                     }
//                                                 }, 1],
            // 表示插入时必须验证
            ['weight', 'digit', '重量只能为数字', '', 1],
            ['weight', 'between', '重量只能在1-200之间', [1, 200], 1],
            // 或者这么写
//             ['weight', 'regex', '重量只能在1-200之间的整数', '/^(1\d?\d?)|200$/', 1],
        ];
        $validate = $this->getDI()->getValidate()->addRules($rules);
//         $validate = new Validate();
//         $validate = $validate->addRules($rules);
        return $this->validate($validate);
    }
    
    /** 
     * @desc 更新之前验证 
     * @author zhaoyang 
     * @date 2018年5月16日 下午10:57:57 
     */
    public function beforeValidationOnUpdate() {
        $rules = [
            //表示name更新时必须验证
            ['name', 'regex', '姓名必须为6-10位数字字母下划线', '/^[a-zA-Z\d_]{6,10}$/', 1],
            ['name', 'uniqueness', '姓名已存在', '', 1],
            // 表示更新时存在即验证
//             ['type', 'inclusionin', '类型只能为1,2,3', [1,2,3]],
            //或者
            ['type', 'callback', '类型只能为1,2,3', function ($data) {
                $type = $data->type ?? null;
                return $data->checkType($type);
            }, 1],
            // 表示更新时存在即验证
            ['weight', 'digit', '重量只能为数字'],
            ['weight', 'between', '重量只能在1-200之间', [1, 200]],
        ];
        $validate = $this->getDI()->getValidate()->addRules($rules);
        return $this->validate($validate);
    }
    
    public function checkType($type){
        if (in_array($type, [1, 2, 3])){
            return true;
        }else{
            return false;
        }
    }
}