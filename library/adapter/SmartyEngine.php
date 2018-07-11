<?php
/**
 * @desc smarty引擎适配器
 * @author: ZhaoYang
 * @date: 2018年6月21日 下午8:19:50
 */
namespace Library\Adapter;

use Phalcon\Mvc\View\Engine;
use Phalcon\DiInterface;

class SmartyEngine extends Engine {

    protected $_options = [ ];

    protected $_smarty = null;

    public function __construct($view, DiInterface $di) {
        parent::__construct($view, $di);
    }

    /**
     * @desc 设置smarty选项
     * @param array $options
     * @author: ZhaoYang
     * @return: object $this
     * @date: 2018年6月21日 下午8:45:42
     */
    public function setOptions(array $options) {
        $this->_options = $options;
        return $this;
    }

    /**
     * @desc 获取选项
     * @author: ZhaoYang
     * @date: 2018年6月21日 下午8:47:44
     */
    public function getOptions() {
        return $this->_options;
    }

    /**
     * @desc 获取smarty编译器
     * @author: ZhaoYang
     * @date: 2018年6月21日 下午8:48:00
     */
    public function getSmarty() {
        if (is_null($this->_smarty)) {
            $smarty = new \Smarty();
            foreach ($this->_options as $k => $v) {
                $smarty->$k = $v;
            }
            // 注入di调度器到模板
            $smarty->assign('di', $this->_dependencyInjector);
            $this->_smarty = $smarty;
        }
        return $this->_smarty;
    }

    /**
     * @desc 使用模板引擎呈现视图
     * @param string $path 模板文件
     * @param array $params 参数
     * @author: ZhaoYang
     * @date: 2018年6月21日 下午9:08:03
     */
    public function render($path, $params, $mustClean = false) {
        $view = $this->_view;
        $smarty = $this->getSmarty();
        $smarty->template_dir = $view->getViewsDir();
        $smarty->assign($params);
        if ($mustClean) {
            $view->setContent($smarty->fetch($path));
        } else {
            $smarty->display($path);
        }
    }
}