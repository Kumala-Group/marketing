<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hd_adm_home extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database('default', TRUE);
	}


	public function index()
	{
		error_reporting(0);
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if (!empty($cek) && $level == 'karyawan') {
			$d['judul'] = "Dashboard";
			$d['class'] = "home";
			$d['category'] = '';
			$d['karyawan'] = '';
			$d['aktif'] = '';
			$d['resign'] = '';
			$d['habis_kontrak'] = '';
			$d['permanen'] = '';
			$d['content'] = 'hd_adm_isi';
			$this->load->view('hd_adm_home', $d);
		} else {
			redirect('login', 'refresh');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */