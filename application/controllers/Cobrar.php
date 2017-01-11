<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cobrar extends CI_Controller {

    public function __construct() {
        parent::__construct();

        permisos('cobrar', 'cobrar');
        $this->load->model('comanda');
        $this->load->model('detall');
        $this->load->helper('xmldatabase');
        $this->load->helper('form');
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
        $data['taula_id'] = '';
        
        
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
        
        if (!$this->comanda->get_estat_taula($taula_id)) {
            redirect(site_url('/cobrar'));
            return;
        }
        $comanda = $this->comanda->get_comanda_activa($taula_id);
        
        $data['comanda'] = $comanda;
        
        
        $data['taules'] = $taules;
        
        $detalls = get_detalls_taula($xml,$taula_id);
        $data['detalls'] = $detalls;
        
        $total = 0;
        foreach ($detalls as $value) {
            $total += floatval($value["preu"]);
        }
        $data['total'] = $total;
        
        
        $data['productes'] = get_productes($xml);
        $data['taula_id'] = $taula_id;
        
        
        $data['vista'] = 'cobrar';
        $this->load->view('template', $data);
    }
    
    
    public function afegir($taula_id, $producte_id) {
        $xml = simplexml_load_file('public/frankfurt.xml');
        
        if (!$this->comanda->get_estat_taula($taula_id)) {
            redirect(site_url('/cobrar'));
            return;
        }
        $comanda = $this->comanda->get_comanda_activa($taula_id);
        
        
        $producte = get_producte($xml,$producte_id);
        if (!$producte) {
            $this->session->set_flashdata('error',"No existeix el producte");
            redirect(site_url("/cobrar/$taula_id"));
            return;
        }
        $res = $this->detall->afegir($comanda['id'],$producte_id,$producte['preu'],0);
        if (!$res) {
            $this->session->set_flashdata('error',"Error al afegir el producte;");
            redirect(site_url("/cobrar/$taula_id"));
            return;
        }
        
        redirect(site_url("/cobrar/taula/$taula_id"));
    }
    
    public function eliminar($taula_id, $detall_id) {
        
        if (!$this->detall->eliminar($detall_id)) {
            $this->session->set_flashdata('error',"Error al eliminar el detall");
        }
        
        redirect(site_url("/cobrar/taula/$taula_id"));
    }
    
    public function finalitzar($comanda_id = NULL) {
        if ($comanda_id == NULL) {
            redirect(site_url("/cobrar"));
            return;
        }
        
        $res = $this->comanda->finalitzar($comanda_id);
        if (!$res) {
            $this->session->set_flashdata('error',"Error al finalitzar la comanda");
            redirect(site_url("/cobrar"));
        } else {
            redirect(site_url("/factura/$comanda_id"));
        }
        
    }
    
    public function factura($comanda_id = NULL) {
        if ($comanda_id == NULL) {
            redirect(site_url("/cobrar"));
            return;
        }
    }
    
    public function facturapdf($comanda_id = NULL) {
        if ($comanda_id == NULL) {
            redirect(site_url("/cobrar"));
            return;
        }
    }
    
    public function historic($pagina = 0) {
        $pagina = intval($pagina);
        $historic = $this->comanda->get_historic($pagina);
        var_dump($historic);
    }
    
    
}
