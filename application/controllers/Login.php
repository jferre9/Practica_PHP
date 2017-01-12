<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('usuari');
        $this->session->set_userdata('loguejat', FALSE);
    }

    public function index() {
        $data['error'] = false;
        $controlador = $this->session->flashdata('controlador');

        if ($controlador != NULL)
            $this->session->set_flashdata('controlador', $controlador);
        else
            $controlador = 'home';

        if ($this->input->post('enviar')) {
            $email = $this->input->post('email');
            $pass = $this->input->post('pass');
            $usuari = $this->usuari->login($email, $pass);
            //var_dump($usuari);
            if ($usuari) {
                $usuari['loguejat'] = TRUE;
                $this->session->set_userdata($usuari);
                //var_dump($usuari);
                redirect(site_url($controlador));
            } else {
                $data['error'] = 'Usuari o contrasenya incorrectes';
            }
        }

        $data['vista'] = 'login';
        $this->load->view('template', $data);
    }

    public function recuperar($id = NULL, $codi = NULL) {

        $email = $this->input->post('email');

        if ($email && $dades = $this->usuari->recuperar_email($email)) {

            //var_dump($dades);

            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.googlemail.com',
                'smtp_port' => 465,
                'smtp_user' => 'w2.joan.ferre@gmail.com',
                'smtp_pass' => '123456789AA',
                'mailtype' => 'html',
                'charset' => 'iso-8859-1'
            );

            //var_dump($this->usuari->comprovar_email($this->input->post('email')));
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");

            $this->email->from('w2.joan.ferre@gmail.com', 'Frankfurt');
            $this->email->to($email);
//            $this->email->cc('another@another-example.com');
//            $this->email->bcc('them@their-example.com');

            $this->email->subject('Recuperar la contrasenya');
            $this->email->message("<a href='" . site_url("login/modificar/" . $dades['id'] . "/" . $dades['codi']) . "'>Recuperar</a>");

            $this->email->send();
        }
        $data['vista'] = 'recuperar';
        $this->load->view('template', $data);
    }

    public function modificar($id = NULL, $codi = NULL) {
        if ($id == NULL || $codi == NULL) {
            redirect(site_url('login'));
        }
        
        $error = FALSE;
        
        $pass = $this->input->post('pass');
        if ($pass) {
            if ($pass != $this->input->post('passconf')) {
                $error = "La contrasenya no coincideix";
            } else if ($this->usuari->modificar_contrasenya($id,$codi,$pass)) {
                $data['ok'] = "Contrasenya modificada correctament";
            } else {
                $error = "Error al modificar la contrasneya";
            }
        }
        $data['error'] = $error;
        
        $data['id'] = $id;
        $data['codi'] = $codi;
 
        $data['vista'] = 'recuperar_form';
        $this->load->view('template', $data);
    }

}
