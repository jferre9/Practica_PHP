<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cambrer extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        permisos('cambrer', 'cambrer');
    }

    public function index() {
        
        $data['vista'] = 'welcome_message';
        $this->load->view('template',$data);
    }

}
