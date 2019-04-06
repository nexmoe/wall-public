<?php
class View extends CI_Controller {

    public function __construct(){
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        parent::__construct();
        $this->load->model('Model');
        $this->load->database();
        $this->count = 0;
    }

    public function get_ip (){
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

    public function user(){
        if(isset($this->Model->user)){
            echo json_encode($this->Model->user);
        }else{
            echo '{"state":0,"qq":"776194970","name":"\u6298\u5f71\u8f7b\u68a6","avatar":"https:\/\/avatar.dawnlab.me\/qq\/776194970"}';
        }
    }

    public function category($cid=NULL) {
        if( !isset($cid) ){
            $query = $this->db->get('category');
            $array = $query->result_array();
            echo json_encode($array);
        }else{
            $query = $this->db->get('category');
            $this->db->where('cid',$cid);
            $array = $query->row_array();

            $this->db->order_by('time', 'DESC');
            $this->db->where('cid',$cid);
            $query = $this->db->get('message');
            $array_message = $query->result_array();
            $array_message = $this->Model->filter($array_message);
            $a = array(
                'category' => $array,
                'message' => $array_message, 
            );
            echo json_encode($a);
        }
    }

    public function message($mid=NULL) {
        if( !isset($mid) ){
            $this->db->order_by('time', 'DESC');
            $query = $this->db->get('message');
            $array = $query->result_array();
            $array = $this->Model->filter($array);
        }else{
            $this->db->where('mid',$mid);
            $query = $this->db->get('message');
            $array = $query->row_array();
            $array['comment'] = $this->comment($mid);
            $array = $this->Model->filter($array,true);
        }
        echo json_encode($array);
    }

    public function comment($mid){
        $this->db->where('mid',$mid);
        $this->db->where('parent',0);
        $query = $this->db->get('comment');
        $array = $query->result_array();
        $this->count += count($array);
        $x=0;
        while( isset($array[$x]['text']) ){
            $array[$x]['author'] = $this->Model->qq($array[$x]['author']);
            $array[$x]['time'] = date('n月j日 H:i',$array[$x]['time']);
            $array[$x]['children'] = $this->comment_children($array[$x]['coid']);
            $x++;
        }
        return array(
            'count' => $this->count,
            'data' => $array,
        );
    }

    public function comment_children($coid){
        $this->db->where('parent',$coid);
        $query = $this->db->get('comment');
        $array = $query->result_array();
        $this->count += count($array);
        $x=0;
        while( isset($array[$x]['text']) ){
            $array[$x]['author'] = $this->Model->qq($array[$x]['author']);
            $array[$x]['time'] = date('n月j日 H:i',$array[$x]['time']);
            $array[$x]['children'] = $this->comment_children($array[$x]['coid']);
            $array[$x]['parent'] = $this->reply($array[$x]['parent']);
            $x++;
        }
        return $array;
    }

    public function reply($coid){
        $this->db->where('coid',$coid);
        $query = $this->db->get('comment');
        $array = $query->row_array();
        return $this->Model->qq($array['author']);
    }

    public function notice($count=false){

        if(!isset($this->Model->user)){
            $this->Model->end('');
        }

        $uid = $this->Model->user['qq'];
        if(!$count){
            $this->db->where('uid',$uid);
            $this->db->order_by('time', 'DESC');
            $this->db->select('type,time,mid,coid,read');
            $query = $this->db->get('notice');
            $array = $query->result_array();
            $x=0;
            while(isset($array[$x])){
                $this->db->where('coid',$array[$x]['coid']);
                $this->db->select('author,text');
                $query = $this->db->get('comment');
                $array[$x]['origin'] = $query->row_array();
                $array[$x]['origin']['author'] = $this->Model->qq($array[$x]['origin']['author']);
                $x++;
            }

            $this->Model->end($array);
        }else{
            $this->db->where('uid',$uid);
            $this->db->where('read',false);
            $this->db->from('notice');
            echo $this->db->count_all_results();
        }
    }

    public function music(){
        header('Content-type: text/html');
        $data['url'] = $_GET['url'];
        $this->load->view('music', $data);
    }
}