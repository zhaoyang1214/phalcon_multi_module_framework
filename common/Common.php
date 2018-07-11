<?php
/**
 * @desc 基础工具类
 * @author zhaoyang
 * @date 2018年5月4日 下午11:21:11
 */
namespace Common;

use Phalcon\Text;

class Common {

    /**
     * @desc 格式化目录
     * @author zhaoyang
     * @date 2018年5月4日 下午11:21:27
     */
    public static function dirFormat(string $path) {
        $path = str_replace('\\', '/', $path);
        $path = preg_replace_callback('/(\{.+\})/U', function ($matches) {
            return date(rtrim(ltrim($matches[0], '{'), '}'));
        }, $path);
        return $path;
    }

    /**
     * @desc 创建目录
     * @param string $pathname 路径
     * @param int $mode 文件夹权限默认情况下，模式是0777
     * @param bool $recursive 规定是否设置递归模式
     * @param resource $context 规定文件句柄的环境。Context 是可修改流的行为的一套选项。
     * @return bool
     * @author zhaoyang
     * @date 2018年5月4日 下午11:21:43
     */
    public static function mkdir(string $pathname, int $mode = 0777, bool $recursive = true, $context = null) {
        if(empty($pathname)){
            return false;
        }
        if (is_dir($pathname)) {
            return true;
        }
        return is_resource($context) ? mkdir($pathname, $mode, $recursive, $context) : mkdir($pathname, $mode, $recursive);
    }

    /**
     * @desc 将数组中键名下划线转换为驼峰
     * @param array|object $arr
     * @param bool $lcfirst 首字母是否小写
     * @return mixed
     * @author zhaoyang
     * @date 2018年5月4日 下午11:22:21
     */
    public static function convertArrKeyUnderline($arr, $lcfirst=true) {
        $type = is_array($arr) ? 1 : (is_object($arr) ? 2 : 0);
        if ($type) {
            foreach ($arr as $k => $v) {
                $key = $k;
                if (strpos($key, '_') !== false) {
                    $key = Text::camelize($key);
                    $lcfirst && $key = lcfirst($key);
                    if ($type == 1) {
                        unset($arr[$k]);
                    } else {
                        unset($arr->$k);
                    }
                }
                if (is_array($v) || is_object($v)) {
                    $v = static::convertArrKeyUnderline($v);
                }
                if ($type == 1) {
                    $arr[$key] = $v;
                } else {
                    $arr->$key = $v;
                }
            }
        }
        return $arr;
    }
    
}