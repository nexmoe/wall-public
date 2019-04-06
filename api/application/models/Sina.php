<?php

class Sina extends CI_Model {

    public function __construct() {
    }

    /**
     * 新浪微博登录
     * @param  string $u 微博账户
     * @param  string $p 密码
     * @return string    返回cookie
     */
    public function weiboLogin($u, $p) {
        $loginUrl = 'https://login.sina.com.cn/sso/login.php?client=ssologin.js(v1.4.15)&_=1403138799543';
        $loginData['entry'] = 'sso';
        $loginData['gateway'] = '1';
        $loginData['from'] = 'null';
        $loginData['savestate'] = '30';
        $loginData['useticket'] = '0';
        $loginData['pagerefer'] = '';
        $loginData['vsnf'] = '1';
        $loginData['su'] = base64_encode($u);
        $loginData['service'] = 'sso';
        $loginData['sp'] = $p;
        $loginData['sr'] = '1920*1080';
        $loginData['encoding'] = 'UTF-8';
        $loginData['cdult'] = '3';
        $loginData['domain'] = 'sina.com.cn';
        $loginData['prelt'] = '0';
        $loginData['returntype'] = 'TEXT';
        return $this->loginPost($loginUrl, $loginData);
    }

    /**
     * 发送微博登录请求
     * @param  string $url 接口地址
     * @param  array $data 数据
     * @return json   返回cookie
     */
    public function loginPost($url, $data) {
        $tmp = '';
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $tmp .= $key . "=" . $value . "&";
            }
            $post = trim($tmp, "&");
        } else {
            $post = $data;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $return = curl_exec($ch);
        curl_close($ch);
        $preg = "/SUB=.*?;/";
        preg_match($preg, $return, $arr);
        return $arr['0'];
    }

    /**
     * 上传图片到微博图床
     * @param $file 图片文件/图片url
     * @param $multipart 上传方式，true采用本地上传，false采用url上传
     * @return 返回的json数据
     */
    public function weiboUpload($file, $cookie, $multipart = TRUE) {

        $url = "http://picupload.service.weibo.com/interface/pic_upload.php?mime=image%2Fjpeg&data=base64&url=0&markpos=1&logo=&nick=0&marks=1&app=miniblog";

        if ($multipart) {
            $url .= '&cb=http://weibo.com/aj/static/upimgback.html?_wv=5&callback=STK_ijax_' . time();
            if (class_exists('CURLFile')) {
                // php 5.5
                $post['pic1'] = new \CURLFile(realpath($file));
            } else {
                $post['pic1'] = '@' . realpath($file);
            }
        } else {
            $post['b64_data'] = base64_encode(file_get_contents($file));

        }
        // Curl提交
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_VERBOSE => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array("Cookie:" . $cookie),
            CURLOPT_POSTFIELDS => $post,
        ));
        $output = curl_exec($ch);
        curl_close($ch);
        preg_match('/({.*)/i', $output, $match);
        if (!isset($match[1])) return '';
        return $match[1];
    }

    /**
     * 获取不同尺寸的图片链接
     * @param string $pid 微博图床pid，或者微博图床链接(带后缀)。
     * @param string $size 图片尺寸 0-7(数字越大尺寸越大)
     * @param bool $https (true) 是否使用 https 协议
     * @return string 图片链接 当 $pid 既不是 pid 也不是合法的微博图床链接时返回空值
     */
    public function getImageUrl($pid, $size = 0, $https = TRUE) {
        $sizeArr = array('large', 'mw1024', 'mw690', 'bmiddle', 'small', 'thumb180', 'thumbnail', 'square');
        $pid = trim($pid);
        $size = $sizeArr[$size];
        // 传递 pid
        $data = array(
            'large' => $this->geturl($pid, 'large')
        );
        return json_encode($data);
    }

    /**
     * 获取图片链接
     * @param string $pid 微博图床pid，或者微博图床链接(带后缀)。
     * @param string $size 图片尺寸 0-7(数字越大尺寸越大)
     * @param bool $https (true) 是否使用 https 协议
     * @return string 图片链接 当 $pid 既不是 pid 也不是合法的微博图床链接时返回空值
     */
    public function getUrl($pid, $size) {
        $https = true;

        if (preg_match('/^[a-zA-Z0-9]{32}$/', $pid) === 1) {
            return ($https ? 'https' : 'http') . '://' . ($https ? 'ws' : 'ww')
            . ((crc32($pid) & 3) + 1) . ".sinaimg.cn/" . $size
            . "/$pid." . ($pid[21] === 'g' ? 'gif' : 'jpg');
        }
        // 传递 url
        $url = $pid;
        $imgUrl = preg_replace_callback('/^(https?:\/\/[a-z]\.bilibili\.com\/)' . '(large|bmiddle|mw1024|mw690|small|square|thumb180|thumbnail)' . '(\/[a-z0-9]{32}\.(jpg|gif))$/i', function ($match) use ($size) {
            return $match[1] . $size . $match[3];
        }, $url, -1, $count);

        if ($count === 0) {
            return '';
        }
        return $imgUrl;

    }

}