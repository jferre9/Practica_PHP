<?php
class User extends CI_Model {

  public $nom;
  

  public function __construct()
  {
          // Call the CI_Model constructor
          parent::__construct();
  }

 

  public function insert_entry($nom)
  {
    $this->nom    = $nom; 
    $this->db->insert('user', $this);
  }
  
  public function elimina($id)
  {
    $this->db->delete('user', array('id' => $id));
  }


}