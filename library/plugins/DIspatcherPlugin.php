<?php
/**
 * @desc 调度器插件
 * @author zhaoyang
 * @date 2018年5月6日 下午11:48:50
 */
namespace Library\Plugins;

use Exception;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Dispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatcherException;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;

class DIspatcherPlugin extends Plugin {

    /**
     * @desc 处理 Not-Found 错误
     * @author zhaoyang
     * @date 2018年5月6日 下午11:49:22
     */
    public function beforeException(Event $event, MvcDispatcher $dispatcher, Exception $exception) {
        $isAjax = $this->request->isAjax();
        $notfoundConfig = $this->config->services->dispatcher->notfound;
        // 处理404异常,你可以根据自己的业务特点来处理
        if ($exception instanceof DispatcherException) {
            if ($isAjax) {
                $this->response->setStatusCode($notfoundConfig->status_code, $notfoundConfig->message)->setContent($notfoundConfig->message)->send();
                // $this->response->setJsonContent([
                // 'status' => $notfoundConfig->status_code,
                // 'message' => $notfoundConfig->message
                // ])->send();
                exit();
            }
            $dispatcher->forward([
                'namespace' => $notfoundConfig->namespace,
                'controller' => $notfoundConfig->controller,
                'action' => $notfoundConfig->action
            ]);
            return false;
        }
        
        // 代替控制器或者动作不存在时的路径
        switch ($exception->getCode()) {
            case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
            case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                if ($isAjax) {
                    $this->response->setStatusCode($notfoundConfig->status_code, $notfoundConfig->message)->setContent($notfoundConfig->message)->send();
                    // $this->response->setJsonContent([
                    // 'status' => $notfoundConfig->status_code,
                    // 'message' => $notfoundConfig->message
                    // ])->send();
                    exit();
                }
                $dispatcher->forward([
                    'namespace' => $notfoundConfig->namespace,
                    'controller' => $notfoundConfig->controller,
                    'action' => $notfoundConfig->action
                ]);
                return false;
        }
    }
    
    /** 
     * @desc 组合pathinfo参数 
     * @author zhaoyang 
     * @date 2018年5月7日 下午10:27:38 
     */
    public function beforeDispatchLoop(Event $event, MvcDispatcher $dispatcher) {
        $params = $dispatcher->getParams();
        $newParams = [ ];
        foreach ($params as $k => $v) {
            if ($k & 1) {
                $newParams[$params[$k - 1]] = $v;
            }
        }
        $dispatcher->setParams($newParams);
    }
}
