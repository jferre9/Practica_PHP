<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cambrer extends CI_Controller {

    public function __construct() {
        parent::__construct();

        permisos('cambrer', 'cambrer');
        $this->load->model('comanda');
        $this->load->model('detall');
        $this->load->helper('form');
        $this->load->helper('xmldatabase');
    }

    public function index() {



        $xml = simplexml_load_file('public/frankfurt.xml');
        //var_dump($xml);


        if ($this->input->post('taula')) {
            $taula = $this->input->post('taula');
            if ($taula != '0') {
                redirect(site_url("/cambrer/taula/$taula"));
                return;
            }
        }

        $taules = get_taules($xml, TRUE);

        $productes = array();

        $productes_xml = $xml->xpath('//producte');



        $data['taules'] = $taules;

        $data['taula_id'] = '';
        
        $error = $this->session->flashdata('error');
        if ($error != NULL) {
            $data['error'] = $error;
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

        $data['taula_estat'] = $this->comanda->get_estat_taula($taula_id) ? "Ocupada" : "Lliure";

        $data['taula_id'] = $taula_id;
        $data['taula_nom'] = (string) $xpath[0]["nom"];

        $taules = get_taules($xml);
        $data['taules'] = $taules;


        $productes = get_productes($xml);
        $data['productes'] = $productes;

        

        //$data['productes_demanats'] = $this->detall->get_detalls_no_iniciats($taula_id);

        $productes_demanats = $this->detall->get_detalls_taula($taula_id);

        dades_producte_cambrer($xml, $productes_demanats);


        $data['productes_demanats'] = $productes_demanats;
        
        $error = $this->session->flashdata('error');
        if ($error != NULL) {
            $data['error'] = $error;
        }

        $data['vista'] = 'cambrer';
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
        
        var_dump($comanda);

        $preu = (double) $xpath[0]["preu"];

        $cuinar = (int) $xml->xpath("//categoria[@id='" . (string) $xpath[0]['categoria'] . "']/@cuinar")[0];


        $afegir = $this->detall->afegir($comanda["id"], $producte_id, $preu, $cuinar);

        if (!$afegir) {
            $this->session->set_flashdata('error', "Error al afegir el producte");
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


        if (!$this->detall->eliminar($detall_id)) {
            $this->session->set_flashdata('error', "Error al eliminar el producte");
        }
        redirect(site_url("/cambrer/taula/$taula_id"));
    }

    public function test() {
        $this->detall->test();
        echo "<br>fi test";
    }

    public function test2() {
        $res = $this->detall->eliminar(6);
        echo "<br>resultat = $res<br>";
    }

}
