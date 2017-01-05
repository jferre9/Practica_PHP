<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cobrar extends CI_Controller {

    public function __construct() {
        parent::__construct();

        permisos('cobrar', 'cobrar');
        $this->load->model('comanda');
        $this->load->model('detall');
        $this->load->helper('xmldatabase');
    }

    public function index() {
        
        if ($this->input->post('taula')) {
            $taula = $this->input->post('taula');
            if ($taula != '0') {
                redirect(site_url("/cobrar/taula/$taula"));
                return;
            }
        }
        
        $xml = simplexml_load_file('public/frankfurt.xml');
        
        $taules = get_taules_ocupades($xml);
        $data['taules'] = $taules;
        
        
        $data['vista'] = 'cobrar';
        $this->load->view('template', $data);
    }
    
    public function taula($taula_id = NULL) {
        if ($taula_id == NULL) {
            redirect(site_url('/cobrar'));
            return;
        }
        
        $xml = simplexml_load_file('public/frankfurt.xml');
        
        $taules = get_taules_ocupades($xml);
        if (!isset($taules[$taula_id])) {
            redirect(site_url('/cobrar'));
            return;
        }
        
        
        $data['taules'] = $taules;
        
        //$productes = get_detalls_taula(&$xml,$taula_id);
        $this->comanda->get_detalls_taula($taula_id);
        
    }
    
}
