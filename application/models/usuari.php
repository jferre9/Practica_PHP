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
    
    public function llista_usuaris() {
        $this->db->select('id,email,CONCAT(nom," ",cognoms) as nom,cambrer,cuiner,cobrar');
        $this->db->where('email !=', 'admin');
        $query = $this->db->get('usuari');
        
        $data = false;
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    
    
    public function get_usuari($id) {
        $this->db->select('id,email,nom,cognoms,cambrer,cuiner,cobrar');
        $this->db->where('id',$id);
        $query = $this->db->get('usuari');
        
        if ($query->num_rows() == 1) {
            return $query->first_row('array');
        } else {
            return FALSE;
        }
    }
    
    public function modificar($id,$data) {
        if (isset($data['pass'])) {
            $data['pass'] = md5($data['pass']);
        }
        
        $this->db->set($data);
        $this->db->where('id',$id);
        $this->db->update('usuari');
        
    }


    
    public function eliminar($id) {
        $usuari = $this->get_usuari($id);
        if ($usuari && $usuari['email'] != 'admin') {
            $this->db->delete('usuari',array('id' => $id));
            return TRUE;
        }
        return FALSE;
    }


    public function login($email, $pass) {
        $this->db->select('id,email,cambrer,cuiner,cobrar');
        $this->db->where('email', strtolower($email));
        $this->db->where('pass', md5($pass));
        $query = $this->db->get('usuari');
        
        if ($query->num_rows() == 1) {
            return $query->first_row('array');
        } else {
            return FALSE;
        }
    }

}
