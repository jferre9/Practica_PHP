<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}
  
  public function hola($nom, $cognom)
	{
    $data['nom'] = "$nom $cognom";
    $data['data'] = "Nadal";
		$this->load->view('vista1', $data);
	}
  
  public function afegir()
	{
    if ($this->input->post('enviar')) {
      $this->load->database();
      echo "Han eviat: ".$this->input->post('nom');
      $this->load->model('user');
      $this->user->insert_entry($this->input->post('nom'));
      
    }
		$this->load->view('vista2');
	}
  public function eliminar($id)
	{
      $this->load->database();
      $this->load->model('user');
      $this->user->elimina($id);
	}
  
  public function login() {
    if ($this->input->post('enviar')) {
      $this->load->database();
      echo "Han eviat: ".$this->input->post('nom');
      $this->load->model('login');
      $this->login->insert_entry($this->input->post('nom'),$this->input->post('pass'));
      
    }
    $this->load->view('vista3');
  }
  
}
