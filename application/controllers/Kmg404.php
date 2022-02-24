<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kmg404 extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	}

	public function index()
	{
		$this->output->set_status_header('404');
		$this->load->view('kmg404');
	}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
