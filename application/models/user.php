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

}
