<?php
class View extends CI_Controller {

    public function __construct(){
        parent::__construct();
        header("Access-Control-Allow-Origin: *");
        header('Content-type: application/json');
        $this->load->model('Model');
    }

    public function data($page="home") {
      $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file', 'key_prefix' => 'data_'));
      if (!$foo = $this->cache->get($page)){
        $foo = $this->Model->get_info('https://mixcm.github.io/mixcm-home/'.$page.'.json');
        $this->cache->save($page, $foo, 43200);
      }
      echo $foo;
    }

    public function user(){
      $array = array(
        'avatar' => $this->Model->user['avatar'],
      );
      echo json_encode($array);
    }

}
