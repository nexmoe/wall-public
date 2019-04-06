<?php
class Controller extends CI_Controller {

    public function __construct(){
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        $this->load->model('Model');
        $this->load->database();
    }

    public function cookie() {
        $a = array(
            'state' => 1,
        );
        $post = json_decode(file_get_contents("php://input"),true);
        setcookie('qq', base64_encode($post['qq']), time()+60*60*24*365, '/');
        $this->Model->end($a);
    }

    public function edit(){
        $a = array(
            'state' => 1,
            'info' => '你的内容已经发布成功了，正带你回到首页。'
        );

        $post = json_decode(file_get_contents("php://input"),true);

        if(!isset($this->Model->user)){
            $a['state'] = 2;
            $a['info'] = '你没有登录！';
            $this->Model->end($a);
        }

        if(!isset($post['article'][0])){
            $a['state'] = 0;
            $a['info'] = '你没有编写任何内容，请添加你需要发布的内容！';
            $this->Model->end($a);
        }

        $this->db->insert('message', array(
            'cid' => $post['category'],
            'anonymous' => $post['anonymous'],
            'author' => $this->Model->user['qq'],
            'article' => json_encode($post['article']),
            'time' => time()
        ));
        $this->Model->end($a);
    }

    public function reply() {
        $a = array(
            'state' => 1,
            'info' => '回复成功！'
        );

        $post = json_decode(file_get_contents("php://input"),true);

        if(!isset($this->Model->user)){
            $a['state'] = 0;
            $a['info'] = '你没有登录！';
            $this->Model->end($a);
        }

        if($post['text'] == NULL){
            $a['state'] = 0;
            $a['info'] = '你没有编写任何内容，请添加你需要发布的内容！';
            $this->Model->end($a);
        }

        $this->db->insert('comment', array(
            'mid' => $post['mid'],
            'parent' => $post['coid'],
            'author' => $this->Model->user['qq'],
            'text' => $post['text'],
            'time' => time()
        ));

        $coid = $this->db->insert_id();

        if($post['coid']!==0){
            $this->db->where('coid',$post['coid']);
            $this->db->select('author');
            $query = $this->db->get('comment');
            $uid = $query->row_array();
        }else{
            $this->db->where('mid',$post['mid']);
            $this->db->select('author');
            $query = $this->db->get('message');
            $uid = $query->row_array();
        }

        $this->db->insert('notice', array(
            'type' => 'reply',
            'mid' => $post['mid'],
            'coid' => $coid,
            'uid' => $uid['author'],
            'time' => time()
        ));

        $this->Model->end($a);
    }

    public function picupload() {
        $this->load->model('Sina');

        //准备本地图片文件
        $saveFile = $_FILES["file"]["tmp_name"];
        //要上传的文件本地路径

        //生成cookie
        $path = str_replace("api\\","",FCPATH);
        $path = str_replace("api/","",$path);
        $config = include $path."config.php";

        $cookie = $this->Sina->weiboLogin($config['sina']['username'],$config['sina']['password']);

        //上传图片到微博图床
        $data = $this->Sina->weiboUpload($saveFile,$cookie,$multipart = true) ;

        echo $this->Sina->getImageUrl(json_decode($data,true)['data']['pics']['pic_1']['pid']);

    }

    public function notice($readall=false) {
        if(!$readall) {
            $post = json_decode(file_get_contents("php://input"),true);

            
        }
    }
}