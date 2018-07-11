<?php
/** 
 * @desc SQL语句性能分析插件 
 * @author zhaoyang 
 * @date 2018年5月20日 下午7:08:56 
 */
namespace Library\Plugins;

use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;

class DbProfilerPlugin extends Plugin {

    /** 
     * @desc 执行sql语句前执行 
     * @param Event $event 事件
     * @param $connection 数据库连接
     * @author zhaoyang 
     * @date 2018年5月20日 下午9:35:32 
     */
    public function beforeQuery(Event $event, $connection) {
        $this->profiler->startProfile($connection->getSQLStatement(), $connection->getSqlVariables(), $connection->getSQLBindTypes());
    }
    
    /** 
     * @desc 执行sql语句前执行 
     * @param Event $event 事件
     * @param $connection 数据库连接 
     * @author zhaoyang 
     * @date 2018年5月20日 下午9:37:36 
     */
    public function afterQuery(Event $event, $connection) {
        $profiler = $this->profiler;
        $profiler->stopProfile();
        $profile = $profiler->getLastProfile();
        $sql = $profile->getSQLStatement();
        $params = $profile->getSqlVariables();
        $params = json_encode($params);
        $executeTime = $profile->getTotalElapsedSeconds();
        $profiler->reset();
        $dbConfig = $this->config->services->db;
        $maxExecuteTime = isset($dbConfig->max_execute_time) && is_float($dbConfig->max_execute_time) ? $dbConfig->max_execute_time : 0;
        $scale = intval($dbConfig->scale);
        if(bccomp($executeTime , $maxExecuteTime, $scale) != -1){
            $this->di->get('logger', [$dbConfig->log_path])->info("$sql $params $executeTime");
        }
    }
}
