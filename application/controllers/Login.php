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
        $this->load->view('template', $data);
    }

    public function recuperar() {
        if ($this->input->post('email') && $this->usuari->comprovar_email($this->input->post('email'))) {
            
            
            
            $config = Array(
                'protocol' => 'sendmail',
                'smtp_host' => 'your domain SMTP host',
                'smtp_port' => 25,
                'smtp_user' => 'SMTP Username',
                'smtp_pass' => 'SMTP Password',
                'smtp_timeout' => '4',
                'mailtype' => 'html',
                'charset' => 'iso-8859-1'
            );
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");

            $this->email->from('your mail id', 'Anil Labs');
            $data = array(
                'userName' => 'Anil Kumar Panigrahi'
            );
            $this->email->to($userEmail);  // replace it with receiver mail id
            $this->email->subject($subject); // replace it with relevant subject

            $body = $this->load->view('emails/anillabs.php', $data, TRUE);
            $this->email->message($body);
            $this->email->send();
        }
        $data['vista'] = 'recuperar';
        $this->load->view('template', $data);
    }

}
