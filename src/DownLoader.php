<?php

namespace SzcDownLoader;

class DownLoader
{
    private $timeout;
    private $maxredirs;

    /**
     * DownLoadImg constructor.
     * @param int $timeout 超时时间
     * @param int $maxredirs 最大http重定向次数
     */
    public function __construct(int $timeout = 3, int $maxredirs = 3)
    {
        if (!is_int($timeout) && $timeout > 0) {
            $this->timeout = 3;
        } else {
            $this->timeout = $timeout;
        }

        if (!is_int($maxredirs) && $maxredirs > 0) {
            $this->timeout = 3;
        } else {
            $this->maxredirs = $maxredirs;
        }
    }

    /**
     * 进行下载的方法
     *
     * @param $url
     * @return array [
     *   'result'     => false, 下载结果
     *   'url'        => '',    请求地址
     *   'msg'        => '',    错误信息
     *   'data'       => ''     图片数据
     * ]
     */
    public function download($url)
    {
        $rt = [
            'result' => false,
            'url' => $url,
            'msg' => '',
            'data' => ''
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);      // 将获取的信息以字符串形式返回
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS, $this->maxredirs);  // 指定最多的 HTTP 重定向次数
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);      // 允许 cURL 函数执行的最长秒数

        $res = curl_exec($ch);                                         // 获取数据
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);        // 获取状态码

        // 请求出错，包括超时
        if (curl_errno($ch)) {
            $rt['msg'] = 'Curl error: ' . curl_error($ch);
            return $rt;
        }

        // 状态码非200
        if ($httpCode != 200) {
            $rt['msg'] = 'Curl 请求返回非200状态码';
            return $rt;
        }

        $rt['result'] = true;
        $rt['data'] = $res;
        return $rt;
    }
}