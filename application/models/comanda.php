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
        $this->db->from('comanda');
        $this->db->join('detall', 'comanda.id = detall.comanda_id');
        $this->db->where('actiu', 1);
        $this->db->group_by('comanda.id');
        $this->db->having('count(detall.id) > 0');

        //var_dump($this->db->get_compiled_select());
        $query = $this->db->get();

        $data = array();
        foreach ($query->result() as $row) {
            $data[] = $row->taula_id;
        }
        return $data;
    }

    /**
     * 
     * @param type $taula_id
     * @return bool TRUE ocupada FALSE lliure
     */
    public function get_estat_taula($taula_id) {
        $this->db->select('detall.id');
        $this->db->from('comanda');
        $this->db->join('detall', 'comanda.id = detall.comanda_id');
        $this->db->where(array('comanda.actiu' => '1', 'comanda.taula_id' => $taula_id));

        $query = $this->db->get();

        return $query->num_rows() > 0;
    }

    public function get_historic($pagina, $limit) {
        
        

        $this->db->select('id,preu_final,data_pagament');
        $this->db->from('comanda');
        $this->db->where('actiu', 0);
        $this->db->limit($pagina * $limit + $limit, $pagina * $limit);
//        var_dump($this->db->get_compiled_select());
        $query = $this->db->get();
        
        $data = array();
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    /**
     * 
     * @param type $taula_id
     * @return type fals si no hi ha cap comanda activa per la taula o l'array amb les columnes de la comanda
     */
    public function get_comanda_activa($taula_id) {
        /* $this->db->select('comanda.*');
          $this->db->from('comanda');
          $this->db->join('detall','detall.comanda_id = comanda.id');
          $this->db->where(array('taula_id' => $taula_id, 'actiu' => 1));
          $this->db->group_by('comanda.id');
          $this->db->having('count(detall.id) > 0');

          $query = $this->db->get(); */
        $query = $this->db->get_where('comanda', array('taula_id' => $taula_id, 'actiu' => 1));


        if ($query->num_rows() == 1) {
            return $query->first_row('array');
        } else {
            return FALSE;
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
        $this->db->insert('comanda', array('taula_id' => $taula_id));
        return $this->get_comanda_activa($taula_id);
    }

    public function get_detalls_taula($taula_id) {

        $query = $this->db->query('SELECT detall.id, detall.producte_id, detall.preu
                FROM detall 
                JOIN comanda on detall.comanda_id = comanda.id
                WHERE comanda.actiu = 1
                AND comanda.taula_id = ?
                ORDER BY producte_id, preu', $taula_id);

        //, SUM(detall.preu) as preu_linia, COUNT(*) as quantitat
        //GROUP BY detall.producte_id, detall.preu
        $data = array();
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    
    /**
     * Retorna els detalls de la comanda finalitzada
     * @param type $comanda_id
     * @return type
     */
    public function get_detalls_comanda($comanda_id) {
        $query = $this->db->get_where('detall',array('comanda_id'=>$comanda_id, 'actiu'=>0));
        $data = array();
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    
    public function get_total_comanda($comanda_id) {
        $this->db->select('preu_total');
        $this->db->from('comanda');
        $this->db->where(array('comanda_id'=>$comanda_id));
        //TODO
    }

    public function finalitzar($comanda_id) {

        $query = $this->db->query("UPDATE comanda c 
        SET c.actiu = '0', 
        c.data_pagament = NOW(),
        preu_final = (SELECT SUM(d.preu) FROM detall d WHERE d.comanda_id = c.id)
        WHERE c.actiu = 1 AND c.id = ?", $comanda_id);

        return $this->db->affected_rows() == 1;
    }

}
