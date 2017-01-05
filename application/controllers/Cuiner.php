<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cuiner extends CI_Controller {

    public function __construct() {
        parent::__construct();

        permisos('cuiner', 'cuiner');
        $this->load->model('detall');
        $this->load->helper('form');
        $this->load->helper('xmldatabase');
    }

    public function index() {
        if ($this->input->post('categoria') != NULL) {
            $id_categoria = $this->input->post('categoria') == '0' ? NULL : $this->input->post('categoria');
            $this->session->set_userdata('filtre', $id_categoria);
        } else {
            $id_categoria = $this->session->userdata('filtre');
        }

        $xml = simplexml_load_file('public/frankfurt.xml');

        $categories = get_categories($xml);
        $data['categories'] = $categories;


        $productes = $this->detall->get_detalls_no_iniciats();
//        for ($i = 0; $i < count($productes);) {
////            echo "<br>";
//            //var_dump($productes[$i]);
//            //echo "<br>";
////            echo "<br>id producte =".$productes[$i]['producte_id']."<br>";
//            $producte_xml = $xml->xpath("//producte[@id='" . $productes[$i]['producte_id'] . "']")[0];
//            if ($id_categoria != NULL && isset($categories[$id_categoria])) { //amb SQL seria molt mes senzill
//                if ($producte_xml["categoria"] != $id_categoria) {
//
//                    array_splice($productes, $i, 1); //borro el producte si s'està filtrant
//                    continue;
//                }
//            }
//
//            $productes[$i]["nom"] = (string) $producte_xml["nom"];
//            $productes[$i]["taula"] = (string) $xml->xpath("//taula[@id='" . $productes[$i]['taula_id'] . "']/@nom")[0];
//            $productes[$i]["categoria"] = $categories[(string) $producte_xml["categoria"]];
//            $i++;
//        }
        dades_producte($xml,$productes,$categories,$id_categoria);

        $data['productes'] = $productes;

        $productes_iniciats = $this->detall->get_detalls_iniciats();
//        for ($i = 0; $i < count($productes_iniciats); $i++) {
//            $producte_xml = $xml->xpath("//producte[@id='" . $productes_iniciats[$i]['producte_id'] . "']")[0];
//
//            $productes_iniciats[$i]["nom"] = (string) $producte_xml["nom"];
//            $productes_iniciats[$i]["taula"] = (string) $xml->xpath("//taula[@id='" . $productes_iniciats[$i]['taula_id'] . "']/@nom")[0];
//            $productes_iniciats[$i]["categoria"] = $categories[(string) $producte_xml["categoria"]];
//        }
        dades_producte($xml, $productes_iniciats, $categories);

        $data['productes_iniciats'] = $productes_iniciats;

        $data['id_categoria'] = $id_categoria;

        $data['error'] = $this->session->flashdata('error');

        $data['vista'] = 'cuiner';
        $this->load->view('template', $data);
    }

    public function acabar($detall_id = NULL) {
        if (!$this->detall->finalitzar($detall_id)) {
            $this->session->set_flashdata('error', "Error al finalitzar");
        }
        redirect(site_url('/cuiner'));
    }

    public function iniciar($detall_id = NULL) {
        if (!$this->detall->iniciar($detall_id)) {
            $this->session->set_flashdata('error', "Error al iniciar");
        }
        redirect(site_url('/cuiner'));
    }

}
