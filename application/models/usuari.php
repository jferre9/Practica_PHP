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
    public $codi;

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function insert_entry($data) {
        $data['pass'] = md5($data['pass']);
        $this->db->insert('usuari', $data);
    }

    /*
     * Retorna fals si no existeix o un array amb el codi generat i la id
     */

    public function recuperar_email($email) {
        $this->db->select('id');
        $this->db->where(array('email' => $email, 'email !=' => 'admin'));
        $query = $this->db->get('usuari');

        $row = $query->row();

        if (!isset($row)) return FALSE;
        
        $id = $row->id;
        
        $codi = md5(rand().time());
        
        var_dump($codi);
        $this->db->set('recuperar',$codi);
        $this->db->where('id',$id);
        $this->db->update('usuari');
//        
        return array('id'=>$id,'codi'=>$codi);
    }

    
    public function modificar_contrasenya($id,$codi,$pass) {
        $this->db->set('pass',md5($pass));
        $this->db->set('recuperar', 'NULL', FALSE);
        $this->db->where(array('id' => $id, 'recuperar' => $codi));
        $this->db->update('usuari');
        
        if ($this->db->affected_rows() == 0) return FALSE;
        return TRUE;
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
        $this->db->where('id', $id);
        $query = $this->db->get('usuari');

        if ($query->num_rows() == 1) {
            return $query->first_row('array');
        } else {
            return FALSE;
        }
    }

    public function modificar($id, $data) {
        if (isset($data['pass'])) {
            $data['pass'] = md5($data['pass']);
        }

        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update('usuari');
    }

    public function eliminar($id) {
        $usuari = $this->get_usuari($id);
        if ($usuari && $usuari['email'] != 'admin') {
            $this->db->delete('usuari', array('id' => $id));
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
