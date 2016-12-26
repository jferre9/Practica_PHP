<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        //$this->load->helper('form');
    }

    public function index() {
        $this->session->set_userdata('loguejat',FALSE);
        $data['error'] = false;
        $controlador = $this->session->flashdata('controlador');
        
        if ($controlador != NULL) $this->session->set_flashdata('controlador',$controlador);
        else $controlador = 'welcome';
        
        if ($this->input->post('enviar')) {
            $this->load->database();
            $this->load->model('usuari');
            $email = $this->input->post('email');
            $pass = $this->input->post('pass');
            $usuari = $this->usuari->login($email,$pass);
            var_dump($usuari);
            if ($usuari) {
                $usuari['loguejat'] = TRUE;
                $this->session->set_userdata($usuari);
                var_dump($usuari);
                redirect(site_url($controlador));
                
                
            } else {
                $data['error'] = 'Usuari o contrasenya incorrectes';
            }
            
        }
        
        $data['vista'] = 'login';
        $this->load->view('template',$data);
    }
    
    

}
