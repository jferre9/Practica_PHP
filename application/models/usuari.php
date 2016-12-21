<?php

class Usuari extends CI_Model {

    public $id;
    public $email;
    public $nom;
    public $cognoms;
    public $pass;
    public $cambrer;
    public $cuiner;
    public $cobrar;
    

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function insert_entry($data) {
        $data['pass'] = md5($data['pass']);
        $this->db->insert('usuari', $data);
    }

    public function elimina($id) {
        $this->db->delete('user', array('id' => $id));
    }
    
    public function login($nom, $pass) {
        $this->db->select('id,email,cambrer,cuiner,cobrar');
        $this->db->where('nom', $nom);
        $this->db->where('pass', md5($pass));
        $query = $this->db->get('usuari');
        
        if ($query->num_rows() == 1) {
            return $query->first_row('array');
        } else {
            return false;
        }
    }

}