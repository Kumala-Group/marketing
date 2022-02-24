<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hd_adm_solving extends CI_Controller {

	public function __construct() {
	    parent::__construct();
		$this->load->model('model_ticketing');
	}

	public function index() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$d['judul']=" Data Tiket Selesai";
			$d['class'] = "ticketing";
			$d['data'] = $this->model_ticketing->alldone();
			$d['content'] = 'ticketing/view_solving';
			$this->load->view('hd_adm_home',$d);
		}else{
			redirect('login','refresh');
		}
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
