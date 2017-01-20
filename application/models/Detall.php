<?php

class Detall extends CI_Model {

    public $id;
    public $producte_id;
    public $preu;
    public $comanda_id;
    public $estat;

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function get_detalls_taula($taula_id) {
        $this->db->select('detall.*');
        $this->db->from('detall');
        $this->db->join('comanda', 'detall.comanda_id = comanda.id');
        $this->db->where(array('taula_id' => $taula_id, 'actiu' => '1'));
        $query = $this->db->get();

        $data = array();
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    
    public function get_detalls_no_iniciats() {
        $this->db->select('detall.*, comanda.taula_id');
        $this->db->from('detall');
        $this->db->join('ordre', 'detall.id = ordre.detall_id');//nomes estan a la taula ordre si no han estat iniciats
        $this->db->join('comanda','comanda.id = detall.comanda_id');
        $this->db->order_by('ordre.ordre');
        $query = $this->db->get();

        $data = array();
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    
    public function get_detalls_iniciats() {
        $this->db->select('detall.*, comanda.taula_id');
        $this->db->from('detall');
        $this->db->join('comanda','comanda.id = detall.comanda_id');
        $this->db->where(array('estat'=>1));
        $query = $query = $this->db->get();
        
        
        $data = array();
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
        
    }
    
    public function iniciar($id) {
        $this->db->trans_start();

        
        $detall = $this->get_detall($id);
        if (!$detall || $detall['estat'] != 0) {
            $this->db->trans_complete();
            return false;
        }
        
        $this->db->set('estat',1);
        $this->db->where('id',$id);
        $this->db->update('detall');
        
        $this->db->where('detall_id',$id);
        $this->db->delete('ordre');        
        
        $this->db->set('ordre', 'ordre-1', FALSE);
        $this->db->where('ordre >=', $detall["ordre"]);
        $this->db->update('ordre');
        
        $this->db->trans_complete();

        return $this->db->trans_status();
    }
    
    public function finalitzar($id) {

        $detall = $this->get_detall($id);
        if (!$detall || $detall['estat'] !== '1'){
            return FALSE;
        }
        
        $this->db->set('estat',2);
        $this->db->where('id',$id);
        $this->db->update('detall');
        
        if ($this->db->affected_rows() == 0) return FALSE;
        return TRUE;
    }
    
    /**
     * Obte el detall amb el seu ordre o fals si no existeix
     * @param type $detall_id
     * @return type 
     */
    private function get_detall($detall_id) {
        $this->db->select('detall.*, ordre.ordre, comanda.actiu');
        $this->db->from('detall');
        $this->db->join('ordre', 'detall.id = ordre.detall_id', 'LEFT');
        $this->db->join('comanda','detall.comanda_id = comanda.id');
        $this->db->where(array('detall.id' => $detall_id));

        $query = $this->db->get();

        if ($query->num_rows() != 1) {
            return FALSE;
        }
        return $query->first_row('array');
    }

    public function eliminar($id) {
        $this->db->trans_start();

        
        $detall = $this->get_detall($id);
        if (!$detall || $detall["actiu"] === '0') {//no es pot eliminar detalls de comandes finalitzades
            $this->db->trans_complete();
            return FALSE;
        }
        

        $this->db->delete('detall', array('id' => $id));

        if ($detall['ordre'] != NULL) {
            //l'ordre te un on delete cascade
            //s'ha de restar l'ordre dels posteriors
            $this->db->set('ordre', 'ordre-1', FALSE);
            $this->db->where('ordre >=', $detall["ordre"]);
            $this->db->update('ordre');
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        }
        return TRUE;
    }

    
    public function afegir($comanda_id, $producte_id, $preu, $cuinar) {
        //$this->db->db_debug = FALSE;
        $this->db->trans_start();

        $estat = $cuinar == 0? 2: 0;
        
        $this->db->insert('detall', array('producte_id' => $producte_id,
            'preu' => $preu,
            'comanda_id' => $comanda_id,
            'estat' => $estat));

        //id del detall inserit
        $insert_id = $this->db->insert_id();


        if ($estat == 0) {
            //selecciono l'ultim ordre de la comanda o si no n'hi ha cap l'ultim de tots
            $query = $this->db->query("SELECT IFNULL("
                    . "(SELECT MAX(ordre.ordre) "
                    . "FROM ordre JOIN detall ON detall.id = ordre.detall_id JOIN comanda ON comanda.id = detall.comanda_id WHERE comanda.id = ?), "
                    . "(SELECT MAX(ordre) from ordre)) as max;", array($comanda_id));

            $row = $query->row_array();

            $ordre = 1;
            if (isset($row)) {
                $ordre = $row['max'];
            }

            //faig lloc pel nou ordre
            $this->db->set('ordre', 'ordre+1', FALSE);
            $this->db->where('ordre >=', $ordre + 1);
            $this->db->update('ordre');


            $this->db->insert('ordre', array('detall_id' => $insert_id, 'ordre' => $ordre + 1));
            
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return false;
        }
        return true;
    }

    public function test() {
        $this->db->select('detall.*,ordre.ordre');
        $this->db->from('detall');
        $this->db->join('ordre', 'detall.id = ordre.detall_id', 'LEFT');
        $this->db->where(array('estat' => 2));

        $query = $this->db->get();

        //var_dump($query->row_array());
    }

    public function test2() {
        $comanda_id = 2;
        $query = $this->db->query("SELECT IFNULL("
                . "(SELECT MAX(ordre.ordre) "
                . "FROM ordre JOIN detall ON detall.id = ordre.detall_id JOIN comanda ON comanda.id = detall.comanda_id WHERE comanda.id = ?), "
                . "(SELECT MAX(ordre) from ordre)) as max;", array($comanda_id));

        $row = $query->row_array();

        $ordre = 1;
        if (isset($row)) {
            $ordre = $row['max'];
        }
        echo "ordre = " . $ordre . " ###########<br>";
    }

}
