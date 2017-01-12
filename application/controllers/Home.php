<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();

        loguejat();
    }

    public function index() {
        //var_dump($this->session->userdata('loguejat'));
        //var_dump($data);
        $data['error'] = $this->session->flashdata('error');
        
        
        $data['vista'] = 'welcome_message';
        $this->load->view('template', $data);
    }
    
    

}
