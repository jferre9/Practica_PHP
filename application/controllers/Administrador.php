<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Administrador extends CI_Controller {

    public function __construct() {
        parent::__construct();

        permisos('admin', 'administrador');
        $this->load->model('usuari');
    }

    public function index() {
        echo $this->session->userdata('email');
        $this->load->model('usuari');
        $data['usuaris'] = $this->usuari->llista_usuaris();


        //$data['sessio'] = carrega_sessio();
        $data['vista'] = 'administrador';
        $this->load->view('template', $data);
    }

    public function afegir() {
        $this->load->helper('form');
        $this->load->library('form_validation');

        if ($this->input->post('enviar')) {

            $this->form_validation->set_rules('email', 'Email', 'strtolower|required|valid_email|is_unique[usuari.email]|max_length[32]', array(
                'required' => "No has introduit l'%s",
                'valid_email' => "L'%s no és vàlid",
                'is_unique' => "Ja existeix un usuari amb aquest %s",
                'max_length' => "L'%s no pot tenir més de 32 caràcters"
            ));
            $this->form_validation->set_rules('nom', 'Nom', 'required|min_length[2]|max_length[32]', array(
                'required' => "No has introduit el %s",
                'min_length' => "El %s ha de tenir com a mínim 2 caràcters",
                'max_length' => "El %s no pot tenir més de 32 caràcters"
            ));
            $this->form_validation->set_rules('cognoms', 'Cognom', 'required|min_length[2]|max_length[32]', array(
                'required' => "No has introduit el %s",
                'min_length' => "El %s ha de tenir com a mínim 2 caràcters",
                'max_length' => "El %s no pot tenir més de 32 caràcters"
            ));
            $this->form_validation->set_rules('pass', 'Contrasenya',
                    //'required|alpha_dash|min_length[4]',
                    'required|min_length[4]', array(
                'required' => "No has introduit la %s",
                //'alpha_dash' => "La %s no pot contenir caràcters especials",
                'min_length' => "La %s ha de tenir com a mínim 4 caràcters",
            ));
            $this->form_validation->set_rules('passconf', 'Confirmació de contrasenya', 'required|matches[pass]', array(
                'required' => "No has introduit la %s",
                'matches' => "Les contrasenyes no són iguals"
            ));

            if ($this->form_validation->run()) {
                echo "Tot correcte";
                unset($_POST['enviar']);
                unset($_POST['passconf']);
                $this->usuari->insert_entry($_POST);//TODO treure $_POST

                redirect('administrador');
                return;
            }
        }

        $data['vista'] = 'registre';
        $this->load->view('template', $data);
    }

    public function editar($id = NULL) {
        if ($id == NULL) {
            redirect('administrador');
            return;
        }
        $usuari = $this->usuari->get_usuari($id);
        if (!$usuari || $usuari['email'] == 'admin') {
            redirect('administrador');
            return;
        }
        $data['usuari'] = $usuari;

        $this->load->helper('form');
        $this->load->library('form_validation');


        if ($this->input->post('enviar')) {
                $modificacions = array(
                    'nom' => $this->input->post('nom'),
                    'cognoms' => $this->input->post('cognoms'),
                    'cuiner' => (bool)$this->input->post('cuiner'),
                    'cambrer' => (bool)$this->input->post('cambrer'),
                    'cobrar' => (bool)$this->input->post('cobrar'),
                    );
                
            if ($this->input->post('email') != $usuari['email']) {
                $this->form_validation->set_rules('email', 'Email', 'strtolower|required|valid_email|is_unique[usuari.email]|max_length[32]', array(
                    'required' => "No has introduit l'%s",
                    'valid_email' => "L'%s no és vàlid",
                    'is_unique' => "Ja existeix un usuari amb aquest %s",
                    'max_length' => "L'%s no pot tenir més de 32 caràcters"
                ));
                $modificacions['email'] = $this->input->post('email');
            }

            $this->form_validation->set_rules('nom', 'Nom', 'required|min_length[2]|max_length[32]', array(
                'required' => "No has introduit el %s",
                'min_length' => "El %s ha de tenir com a mínim 2 caràcters",
                'max_length' => "El %s no pot tenir més de 32 caràcters"
            ));
            $this->form_validation->set_rules('cognoms', 'Cognom', 'required|min_length[2]|max_length[32]', array(
                'required' => "No has introduit el %s",
                'min_length' => "El %s ha de tenir com a mínim 2 caràcters",
                'max_length' => "El %s no pot tenir més de 32 caràcters"
            ));

            if ($this->input->post('pass') != "") {
                $this->form_validation->set_rules('pass', 'Contrasenya',
                        //'required|alpha_dash|min_length[4]',
                        'required|min_length[4]', array(
                    'required' => "No has introduit la %s",
                    //'alpha_dash' => "La %s no pot contenir caràcters especials",
                    'min_length' => "La %s ha de tenir com a mínim 4 caràcters",
                ));
                $this->form_validation->set_rules('passconf', 'Confirmació de contrasenya', 'required|matches[pass]', array(
                    'required' => "No has introduit la %s",
                    'matches' => "Les contrasenyes no són iguals"
                ));
                $modificacions['pass'] = $this->input->post('pass');
                
                
                
            }
            
            
            if ($this->form_validation->run()) {
                
                $this->usuari->modificar($id,$modificacions);

                redirect('administrador');
                return;
            }
            
        }


        $data['vista'] = 'edicio_admin';
        $this->load->view('template', $data);
    }

    public function borrar($id = NULL) {
        if ($id == NULL) {
            redirect('administrador');
            return;
        }

        if (!$this->usuari->eliminar($id)) {
            $this->session->set_flashdata('error', "No s'ha pogut eliminar l'usuari");
        }
        redirect('administrador');
    }

}
