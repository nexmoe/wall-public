<?php
class Main extends CI_Controller {

    public function __construct(){
        parent::__construct();
        header("Access-Control-Allow-Origin: *");
        header('Content-type: application/json');
        $this->load->model('Model');
    }
}