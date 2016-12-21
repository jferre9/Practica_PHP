<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        //$this->load->helper('form');
    }

    public function index() {
        $data['error'] = false;
        if ($this->input->post('enviar')) {
            $this->load->database();
            $this->load->model('usuari');
            $email = $this->input->post('email');
            $pass = $this->input->post('pass');
            $usuari = $this->usuari->login($email,$pass);
            if ($usuari) {
                $this->session->set_userdata($usuari);
                var_dump($usuari);
                if ($usuari['email'] === 'admin') {
                    redirect(site_url('administrador'));
                    return;
                }
                if ($usuari['cambrer']) {
                    redirect(site_url('cambrer'));
                    return;
                }
                if ($usuari['cuiner']) {
                    redirect(site_url('cuiner'));
                    return;
                }
                if ($usuari['cobrar']) {
                    redirect(site_url('cobrar'));
                    return;
                }
                
            } else {
                $data['error'] = 'Usuari o contrasenya incorrectes';
            }
            
        }
        $this->load->view('login',$data);
    }
    
    

}
