<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cambrer extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        permisos('cambrer', 'cambrer');
        $this->load->model('comanda');
        $this->load->model('detall');
        $this->load->helper('form');
    }
    
    

    public function index() {
        
        
        
        $xml = simplexml_load_file('public/frankfurt.xml');
        //var_dump($xml);
        
        $taules_xml = $xml->xpath('//taula');
        
        if ($this->input->post('taula')) {
            $taula = $this->input->post('taula');
            if ($taula != '0') {
                redirect(site_url("/cambrer/taula/$taula"));
            }
        }
        
        $taules = array('0'=>"Selecciona una taula");
        foreach ($taules_xml as $taula) {
            $taules[(string)$taula["id"]] = (string)$taula["nom"];
        }
        
        $productes = array();
        
        $productes_xml = $xml->xpath('//producte');
        
        
        
        $data['taules'] = $taules;
        
        if ($this->input->post('taula')) {
            $data['seleccionada'] = $this->input->post('taula');
            
        } else {
            $data['seleccionada'] = '';
        }
        
        $data['vista'] = 'cambrer';
        $this->load->view('template', $data);
    }
    
    
    public function taula($taula_id = NULL) {
        if ($taula_id == NULL) {
            redirect(site_url('/cambrer'));
            return;
        }
        
        $xml = simplexml_load_file('public/frankfurt.xml');
        
        $xpath = $xml->xpath("//taula[@id='$taula_id']");
        if (count($xpath) != 1) {
            redirect(site_url('/cambrer'));
            return;
        }
        
        $data['taula_id'] = $taula_id;
        $data['taula_nom'] = (string)$xpath[0]["nom"];
        
        $taules_xml = $xml->xpath('//taula');
        
        
        
        foreach ($taules_xml as $taula) {
            $taules[(string)$taula["id"]] = (string)$taula["nom"];
        }
        $data['taules'] = $taules;
        
        
        $productes = array();
        
        $productes_xml = $xml->xpath('//producte');
        foreach ($productes_xml as $producte) {
            $productes[(string)$producte["id"]] = (string)$producte["nom"];
        }
        $data['productes'] = $productes;
        
        if ($this->session->flashdata('error') != NULL) $data['error'] = $this->session->flashdata('error');
        
        $data['productes_demanats'] = $this->detall->get_detalls_no_iniciats($taula_id);
        
        $data['vista'] = 'taula';
        $this->load->view('template', $data);
        
    }
    
    public function afegir($taula_id = NULL, $producte_id = NULL) {
        if ($taula_id == NULL) {
            redirect(site_url('/cambrer'));
            return;
        }
        
        $xml = simplexml_load_file('public/frankfurt.xml');
        
        $xpath = $xml->xpath("//taula[@id='$taula_id']");
        if (count($xpath) != 1) {
            redirect(site_url('/cambrer'));
            return;
        }
        
        if ($producte_id == NULL) {
            redirect(site_url("/cambrer/taula/$taula_id"));
            return;
        }
        
        $xpath = $xml->xpath("//producte[@id='$producte_id']");
        if (count($xpath) != 1) {
            redirect(site_url("/cambrer/taula/$taula_id"));
            return;
        }
        
        
        //la taula i el producte existeixen
        $comanda = $this->comanda->crear($taula_id);
        
        $preu = (double)$xpath[0]["preu"];
        
        $afegir = $this->detall->afegir($comanda["id"],$producte_id,$preu);
        
        if (!$afegir) {
            $this->session->set_flashdata('error',"Error al afegir el producte");
        }
        
        redirect(site_url("/cambrer/taula/$taula_id"));
    }
    
    public function eliminar($taula_id = NULL, $detall_id = NULL) {
        if ($taula_id == NULL) {
            redirect(site_url('/cambrer'));
            return;
        }
        
        $xml = simplexml_load_file('public/frankfurt.xml');
        
        $xpath = $xml->xpath("//taula[@id='$taula_id']");
        if (count($xpath) != 1) {
            redirect(site_url('/cambrer'));
            return;
        }
        
//        if ($producte_id == NULL) {
//            redirect(site_url("/cambrer/taula/$taula_id"));
//            return;
//        }
//        
//        $xpath = $xml->xpath("//producte[@id='$producte_id']");
//        if (count($xpath) != 1) {
//            redirect(site_url("/cambrer/taula/$taula_id"));
//            return;
//        }
//        //la taula i el producte existeixen
//        
//        $comanda = $this->comanda->get_comanda_activa($taula_id);
//        if (!$comanda) {
//            redirect(site_url("/cambrer/taula/$taula_id"));
//            return;
//        }
        
        
        if (!$this->detall->eliminar_no_iniciat($detall_id)) {
            $this->session->set_flashdata('error',"Error al eliminar el producte");
        }
        redirect(site_url("/cambrer/taula/$taula_id"));
    }
    
    public function test() {
        $this->detall->test();
        echo "fi test";
    }
    
    public function test2() {
        $res = $this->detall->eliminar(6);
        echo "<br>resultat = $res<br>";
    }
    
    
    
}