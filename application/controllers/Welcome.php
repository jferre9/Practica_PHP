<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();

        loguejat();
    }

    public function index() {
        //var_dump($this->session->userdata('loguejat'));
        $this->load->model('usuari');
        $data['usuaris'] = $this->usuari->llista_usuaris();
        //var_dump($data);
        $data['vista'] = 'welcome_message';
        $this->load->view('template', $data);
    }
    
    
    public function modficar() {
        
    }

}
