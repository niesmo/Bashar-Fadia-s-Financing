<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template extends CI_Controller {
	public function index(){
		$this->load->view('templates/head.php');
		$this->load->view('templates/header.php');
		$this->load->view('pages/template.php');
		$this->load->view('templates/footer.php');
	}
}

/* End of file template.php */
/* Location: ./application/controllers/template.php */