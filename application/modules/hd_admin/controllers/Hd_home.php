<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hd_adm_home extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->database('default', TRUE);

			$this->load->model('model_absensi');
				$this->load->model('model_perusahaan');
	}


	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$d['judul']="Dashboard";
			$d['class'] = "home";
			$d['content']= 'hd_adm_isi';


			$this->load->view('hd_adm_home',$d);
		}else{
			redirect('login','refresh');
		}
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
