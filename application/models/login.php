<?php
class login extends CI_Model {

  public $nom;
  public $pass;
  

  public function __construct()
  {
          // Call the CI_Model constructor
          parent::__construct();
  }

 

  public function insert_entry($nom, $pass)
  {
    $this->nom    = $nom; 
    $this->pass    = $pass; 
    $this->db->insert('login', $this);
  }
  
 


}