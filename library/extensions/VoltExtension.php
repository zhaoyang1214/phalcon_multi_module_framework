<?php
/**
 * @desc volt模板引擎扩展
 * @author zhaoyang
 * @date 2018年5月5日 下午9:06:34
 */
namespace Library\Extensions;

class VoltExtension {
    
    /**
     * @desc Triggered before trying to compile any function call in a template
     * @author zhaoyang
     * @date 2018年5月5日 下午9:06:55
     */
    public function compileFunction($name, $arguments) {
        if (function_exists($name)) {
            return $name . '(' . $arguments . ')';
        }
    }
    
    /**
     * @desc Triggered before trying to compile any filter call in a template
     * @author zhaoyang
     * @date 2018年5月5日 下午9:07:07
     */
    public function compileFilter($name, $arguments) {
        if (function_exists($name)) {
            return $name . '(' . $arguments . ')';
        }
    }
    
    /**
     * @desc Triggered before trying to compile any expression. This allows the developer to override operators
     * @author zhaoyang
     * @date 2018年5月5日 下午9:07:21
     */
    public function resolveExpression($arguments) {
        
    }
    
    /**
     * @desc Triggered before trying to compile any expression. This allows the developer to override any statement
     * @author zhaoyang
     * @date 2018年5月5日 下午9:07:43
     */
    public function compileStatement($arguments) {
        
    }
}