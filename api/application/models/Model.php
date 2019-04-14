<?php

class Model extends CI_Model {

    public function __construct(){
        $this->load->database();
        if(isset($_COOKIE['qq'])){
            $this->user = $this->qq(base64_decode($_COOKIE['qq']));
        }
    }
    
    public function get_client_ip (){
        if (getenv('HTTP_CLIENT_IP')){
            $ip=getenv('HTTP_CLIENT_IP');
        }elseif (getenv('HTTP_X_FORWARDED_FOR')){
            $ip=getenv('HTTP_X_FORWARDED_FOR');
        }elseif (getenv('HTTP_X_FORWARDED')){
            $ip=getenv('HTTP_X_FORWARDED');
        }elseif (getenv('HTTP_FORWARDED_FOR')){
            $ip=getenv('HTTP_FORWARDED_FOR');
        }elseif (getenv('HTTP_FORWARDED')){
            $ip=getenv('HTTP_FORWARDED');
        }else {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    
    function get_info($url){    
        $ch = curl_init();

        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//绕过ssl验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        //执行并获取HTML文档内容
        $output = curl_exec($ch);

        //释放curl句柄
        curl_close($ch);
        return $output;
    }

    public function end($data,$return=false){

        // Everything has its end.

        if($return){
            return json_encode($data);
        }else{
            echo json_encode($data);
        }
        exit;
    }

    public function qq($qq){
        $urlPre='http://r.qzone.qq.com/fcg-bin/cgi_get_portrait.fcg?g_tk=1518561325&uins=';
        $data=file_get_contents($urlPre.$qq);
        $data=iconv("GBK","UTF-8",$data);
        $pattern = '/portraitCallBack\((.*)\)/is';
        preg_match($pattern,$data,$result);
        $result = $result[1];
        if(isset(json_decode($result, true)[$qq][6])){
            return array(
                "name" => json_decode($result, true)[$qq][6],
                "avatar" => 'https://avatar.dawnlab.me/qq/'.$qq,
                "qq" => $qq
            );
        }else{
            return array(
                "name" => 'QQ号不存在',
                "avatar" => 'https://avatar.dawnlab.me/qq/'.$qq,
                "qq" => $qq
            );
        }
    }

    public function category($cid) {
        $this->db->where('cid',$cid);
        $query = $this->db->get('category');
        $array = $query->row_array();
        return $array;
    }

    public function filter($array,$single=false){
        if(!$single){
            $x=0;
            while( isset($array[$x]['article']) ){
                if($array[$x]['anonymous'] == 'true'){
                    $array[$x]['author'] = array(
                        "name" => '匿名用户',
                        "avatar" => 'https://static.hdslb.com/images/akari.jpg',
                        "qq" => "10000"
                    );
                }else{
                    $array[$x]['author'] = $this->Model->qq($array[$x]['author']);
                }
                $array[$x]['time'] = date('n月j日 H:i',$array[$x]['time']);
                $array[$x]['category'] = $this->Model->category($array[$x]['cid'])['name'];
                $array[$x]['article'] = json_decode($array[$x]['article'],true);
                $x++;
            }
        }else{
            if($array['anonymous'] == 'true'){
                $array['author'] = array(
                    "name" => '匿名用户',
                    "avatar" => 'https://static.hdslb.com/images/akari.jpg',
                    "qq" => "10000"
                );
            }else{
                $array['author'] = $this->Model->qq($array['author']);
            }
            $array['time'] = date('n月j日 H:i',$array['time']);
            $array['category'] = $this->Model->category($array['cid'])['name'];
            $array['article'] = json_decode($array['article'],true);
        }
        return $array;
    }
}