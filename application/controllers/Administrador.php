<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Administrador extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
//        if ($this->session->userdata('email') != "admin") {
//            redirect('login');
//        }
    }

    public function index() {
        echo $this->session->userdata('email');
        $this->load->view('welcome_message');
    }
    
    public function afegir() {
        $this->load->view('registre');
    }

}
