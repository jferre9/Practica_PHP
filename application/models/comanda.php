<?php

class Comanda extends CI_Model {

    public $id;
    public $taula_id;
    public $actiu;
    public $preu_final;
    public $data_pagament;

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function taules_ocupades() {
        $this->db->select('taula_id');
        $this->db->where('actiu', 1);
        $query = $this->db->get('comanda');

        $data = array();
        foreach ($query->result() as $row) {
            $data[] = $row->taula_id;
        }
        return $data;
    }

    /**
     * 
     * @param type $taula_id
     * @return type fals si no hi ha cap comanda activa per la taula o l'array amb les columnes de la comanda
     */
    public function get_comanda_activa($taula_id) {
        $query = $this->db->get_where('comanda', array('taula_id' => $taula_id, 'actiu' => 1));
        
        if ($query->num_rows() == 1) {
            return $query->first_row('array');
        } else {
            return false;
        }
    }
    
    /**
     * Crea una comanda activa per la taula o retorna la ja existent
     * @param type $taula_id
     * @return array Array amb les columnes de la comanda
     */
    public function crear($taula_id) {
        $comanda = $this->get_comanda_activa($taula_id);
        if ($comanda) {
            return $comanda;
        }
        //tot té valor predeterminat excepte la taula_id
        $this->db->insert('comanda',array('taula_id'=>$taula_id));
        return $this->get_comanda_activa($taula_id);
        
    }

}
