<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_ticketing extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('model_login');
	}

	public function index()
	{

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		$d['logo']    = $this->db->select('*')->get('kumalagroup.partners')->result();
		$d['version'] = $this->db->select('MAX(versi_update) as versi_update')->where('brand', 'KMG')->get('db_helpdesk.update_versi')->row();

		if ($this->form_validation->run() == FALSE){
			$this->load->view('login_ticketing', $d);
		}else{			
			$u = $this->input->post('username');
			$p = $this->input->post('password');
			$this->model_login->getLoginDataTicketing($u, $p);
		}
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('login_ticketing','refresh');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
