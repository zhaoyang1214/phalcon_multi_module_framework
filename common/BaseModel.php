<?php
/**
 * @desc 基础模型
 * @author: ZhaoYang
 * @date: 2018年6月19日 下午9:31:51
 */
namespace Common;

use Phalcon\Mvc\Model;

class BaseModel extends Model {

    /**
     * @desc 初始化
     * @author: ZhaoYang
     * @date: 2018年6月19日 下午9:32:08
     */
    public function initialize() {
        $dbConfig = $this->di->getConfig()->services->db;
        $this->useDynamicUpdate($dbConfig->use_dynamic_update);
        $ormOptions = Common::convertArrKeyUnderline($dbConfig->orm_options->toArray());
        $this->setup($ormOptions);
    }
}