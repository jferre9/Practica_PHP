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
    
    public function get_detalls_no_iniciats($taula_id) {
        $this->db->select('detall.*');
        $this->db->from('detall');
        $this->db->join('comanda','detall.comanda_id = comanda.id');
        $this->db->where(array('taula_id'=>$taula_id));
        $query = $this->db->get();
        
        $data = array();
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    
    public function eliminar_no_iniciat($id) {
        $this->db->trans_start();
        
        $this->db->select('detall.*,ordre.ordre');
        $this->db->from('detall');
        $this->db->join('ordre','detall.id = ordre.detall_id');
        $this->db->where(array('id'=>$id,'estat'=>0));
        
        $query = $this->db->get();
        
        if ($query->num_rows() != 1) {
            $this->db->trans_complete();
            return false;
        }
        $detall = $query->first_row('array');
        
        //l'ordre te un on delete cascade
        
        $this->db->delete('detall',array('id'=>$id));
        
        //s'ha de restar l'ordre dels posteriors
        $this->db->set('ordre','ordre-1',FALSE);
        $this->db->where('ordre >=',$detall["ordre"]);
        $this->db->update('ordre');
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        }
        return TRUE;
        
    }

    public function afegir($comanda_id, $producte_id, $preu) {
        $this->db->db_debug = FALSE;
        $this->db->trans_start();

        $this->db->insert('detall', array('producte_id' => $producte_id,
            'preu' => $preu,
            'comanda_id' => $comanda_id));

        //id del detall inserit
        $insert_id = $this->db->insert_id();

        
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
        $this->db->set('ordre','ordre+1',FALSE);
        $this->db->where('ordre >=',$ordre+1);
        $this->db->update('ordre');
        
        
        $this->db->insert('ordre',array('detall_id'=>$insert_id,'ordre' => $ordre+1));

        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE) {
            return false;
        }
        return true;
    }

    public function test() {
        $this->db->db_debug = FALSE;
        $this->db->trans_start();
        $this->db->query("insert into detall values('asd')");
        $this->db->trans_complete();
        echo "despres trans_complete";
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
        echo "ordre = ".$ordre . " ###########<br>";
    }

}
