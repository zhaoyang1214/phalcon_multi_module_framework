<?php
/** 
 * @desc curl工具类 
 * @author zhaoyang 
 * @date 2018年6月13日 下午8:08:28 
 */
namespace Library\Tools;

class HttpCurl {

    // 句柄
    private $_ch;

    // 请求地址
    private $_url;

    // 是否做https验证
    private $_httpsVerify;

    // 连接过期时间
    private $_timeout;

    // 启用时是否将头文件的信息作为数据流输出
    private $_header;

    private $_option = [ ];

    private $_error = null;

    /** 
     * @desc 初始化 
     * @param string $url 地址
     * @param bool $httpsVerify 是否进行https验证
     * @param int $timeout 超时时间
     * @param bool $header 启用时是否将头文件的信息作为数据流输出
     * @author zhaoyang 
     * @date 2018年6月13日 下午9:00:53 
     */
    public function __construct(string $url, bool $httpsVerify = false, int $timeout = 30, bool $header = false) {
        $this->_url = $url;
        $this->_httpsVerify = $httpsVerify;
        $this->_timeout = $timeout;
        $this->_header = $header;
        $this->init();
    }

    /** 
     * @desc 基本初始化 
     * @author zhaoyang 
     * @date 2018年6月13日 下午8:13:37 
     */
    private function init() {
        $this->_ch = curl_init();
        // 让 cURL 自己判断使用哪个版本
        $this->_option[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_NONE;
        // 在HTTP请求中包含一个"User-Agent: "头的字符串
        $this->_option[CURLOPT_USERAGENT] = $_SERVER['HTTP_USER_AGENT'];
        // 需要获取的 URL 地址
        $this->_option[CURLOPT_URL] = $this->_url;
        // 在尝试连接时等待的秒数。设置为0，则无限等待
        $this->_option[CURLOPT_CONNECTTIMEOUT] = $this->_timeout;
        // 允许 cURL 函数执行的最长秒数
        $this->_option[CURLOPT_TIMEOUT] = $this->_timeout;
        // 只获取页面内容，但不输出
        $this->_option[CURLOPT_RETURNTRANSFER] = true;
        // 发送所支持的编码类型，false发送所有
        $this->_option[CURLOPT_ENCODING] = false;
        // 启用时会将头文件的信息作为数据流输出
        $this->_option[CURLOPT_HEADER] = $this->_header;
        // cURL 验证对等证书
        $this->_option[CURLOPT_SSL_VERIFYPEER] = $this->_httpsVerify;
        // 服务器认证ssl
        $this->_option[CURLOPT_SSL_VERIFYHOST] = $this->_httpsVerify;
        // 追踪句柄的请求字符串
        $this->_option[CURLINFO_HEADER_OUT] = true;
    }

    /** 
     * @desc 设置option
     * @param string|array $option 选项
     * @param mixed $value 值
     * @return object $this 
     * @author zhaoyang 
     * @date 2018年6月13日 下午8:17:37 
     */
    public function setOption($option, $value = null) {
        if (is_array($option)) {
            $this->_option = $option + $this->_option;
        } else {
            $this->_option[$option] = $value;
        }
        return $this;
    }

    /** 
     * @desc 发送get请求 
     * @author zhaoyang 
     * @date 2018年6月13日 下午9:15:16 
     */
    public function execGet() {
        curl_setopt_array($this->_ch, $this->_option);
        $result = curl_exec($this->_ch);
        $this->_error = [ 
            'errno' => curl_errno($this->_ch),
            'error' => curl_error($this->_ch)
        ];
        curl_close($this->_ch);
        return $result;
    }

    /** 
     * @desc 发送post请求
     * @param array|string $requestData 要发送的数据
     * @param bool $json 是否发送json格式数据
     * @param int $jsonOptions json配置
     * @author zhaoyang 
     * @date 2018年6月13日 下午9:15:33 
     */
    public function execPost($requestData = null, bool $json = true, int $jsonOptions = null) {
        if ($requestData !== null) {
            if ($json) {
                $isString = is_string($requestData);
                (!$isString || ($isString && is_null(json_decode($requestData)))) && $requestData = json_encode($requestData, $jsonOptions);
                if (!isset($this->_option[CURLOPT_HTTPHEADER])) {
                    $this->_option[CURLOPT_HTTPHEADER] = [ 
                        'Content-Type: application/json; charset=utf-8',
                        'Accept: application/json',
                        'Content-Length:' . strlen($requestData)
                    ];
                }
            }
            $this->_option[CURLOPT_POSTFIELDS] = $requestData;
        }
        $this->_option[CURLOPT_POST] = true;
        curl_setopt_array($this->_ch, $this->_option);
        $result = curl_exec($this->_ch);
        $this->_error = [ 
            'errno' => curl_errno($this->_ch),
            'error' => curl_error($this->_ch)
        ];
        curl_close($this->_ch);
        return $result;
    }

    /** 
     * @desc 获取错误 
     * @return array 
     * @author zhaoyang 
     * @date 2018年6月13日 下午9:30:23 
     */
    public function getError() {
        return $this->_error;
    }
}