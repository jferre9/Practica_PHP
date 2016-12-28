<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cuiner extends CI_Controller {

    public function __construct() {
        parent::__construct();

        permisos('cuiner', 'cuiner');
        $this->load->model('detall');
        $this->load->helper('form');
    }

    public function index($id_categoria = NULL) {
        
        
        $xml = simplexml_load_file('public/frankfurt.xml');
        
        
        $xpath = $xml->xpath("//categoria");
        
        
        
        $categories = array('0'=>"Selecciona una categoria");
        foreach ($xpath as $value) {
            //var_dump($value);
            //echo "<br>value= ".(string)$value['id']."<br>";
            $categories[(string)$value['id']] = (string)$value['nom'];
        }
        $data['categories'] = $categories;
        
        
        $productes = $this->detall->get_detalls_no_iniciats();
        for ($i = 0; $i < count($productes); ) {
//            echo "<br>";
//            var_dump($productes[$i]);
//            echo "<br>id producte =".$productes[$i]['producte_id']."<br>";
            $producte_xml = $xml->xpath("//producte[@id='".$productes[$i]['producte_id']."']")[0];
            if ($id_categoria != NULL && isset($categories[$id_categoria])) { //amb SQL seria molt mes senzill
                if ($producte_xml["categoria"] != $id_categoria) {
                    array_splice($productes, $i);//borro el producte si s'està filtrant
                    continue;
                }
            }
            
            $productes[$i]["categoria"] = $categories[(string)$producte_xml["categoria"]];
            $i++;
        }
        $data['productes'] = $productes;
        
        $data['id_categoria'] = $id_categoria;
        
        
        
        $data['vista'] = 'cuiner';
        $this->load->view('template', $data);
    }
    
    public function acabar($producte_id = NULL) {
        
    }
    
    public function comencar($producte_id = NULL) {
        
    }

}
