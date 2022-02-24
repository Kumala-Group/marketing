<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hd_adm_n_baru extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_n_baru');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$d['judul']=" Data Karyawan Baru";
			$d['class'] = "n_baru";
			$d['data'] = $this->model_n_baru->all();
			$d['content'] = 'n_baru/view';
			$this->load->view('hd_adm_home',$d);
		}else{
			redirect('login','refresh');
		}
	}

	

	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$id['id_n_baru']	= $this->uri->segment(3);

			if($this->model_n_baru->ada($id))
			{
				$this->model_n_baru->delete($id);
			}
			redirect('hd_adm_n_baru','refresh');
		}
		else
		{
			redirect('login','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
