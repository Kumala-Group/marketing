<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Biodata_karyawan extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_karyawan');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$d['judul']=" biodata_karyawan";
			$d['class'] = "pustaka";
			$d['data'] = $this->model_karyawan->all();
			$d['content'] = 'biodata_karyawan/view';
			$this->load->view('hd_adm_home',$d);
		}else{
			redirect('login','refresh');
		}
	}



}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
