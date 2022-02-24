<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ban extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_ban');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='ban_admin'){
			$d['judul']=" Data BAN";
			$d['class'] = "management_user";

			$d['data'] = $this->db_ban->query("SELECT *	FROM ban ORDER BY id_ban");
			$d['content'] = 'ban/view';
			$this->load->view('ban_home',$d);
		}else{
			redirect('login','refresh');
		}
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
