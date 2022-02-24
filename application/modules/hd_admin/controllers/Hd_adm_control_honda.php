<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hd_adm_control_honda extends CI_Controller {

	public function __construct() {
	    parent::__construct();
	}

	public function index() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$d['judul']=" Data Pengaduan";
			$d['class'] = "control_honda";
			// $d['data'] = array(
				
			// );
			$d['content'] = 'hd_adm_isi';//buka tampilan seluruh pengaduan
			$this->load->view('hd_adm_home',$d);
		}else{
			redirect('login','refresh');
		}
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
