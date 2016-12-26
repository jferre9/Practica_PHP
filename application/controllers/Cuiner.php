<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cuiner extends CI_Controller {

    public function __construct() {
        parent::__construct();

        permisos('cuiner', 'cuiner');
        $this->load->model('comanda');
        $this->load->model('detall');
    }

    public function index() {
        
        
        $xml = simplexml_load_file('public/frankfurt.xml');
        
        
        $taules = $xml->children('taula');
        
        
        
        var_dump($taules);
        
        $ocupades = $this->comanda->taules_ocupades();
        
        var_dump($ocupades);
        
        
        $data['vista'] = 'cuiner';
        $this->load->view('template', $data);
    }

}
