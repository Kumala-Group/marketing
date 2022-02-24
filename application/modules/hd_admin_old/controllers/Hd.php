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
			$d['judul']=" Data Ban";
			$d['class'] = "ban";
			$d['data'] = $this->model_ban->all();
			$d['content'] = 'ban/view';
			$this->load->view('ban_home',$d);
		}else{
			redirect('login','refresh');
		}
	}

	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='admin_hrd'){
			$id['id_ban']	= $this->uri->segment(3);

			if($this->model_ban->ada($id))
			{
				$this->model_ban->delete($id);
			}
			redirect('ban','refresh');
		}
		else
		{
			redirect('login','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
