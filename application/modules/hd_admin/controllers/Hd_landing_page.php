<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hd_landing_page extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->database('default', TRUE);
	}


	public function index()
	{
		error_reporting(0);
			$d['judul']="Dashboard";
			$d['class'] = "home";
			$d['category'] = '';
			$d['karyawan'] = '';
			$d['aktif'] = '';
			$d['resign'] = '';
			$d['habis_kontrak'] ='';
			$d['permanen'] = '';
			//$d['content']= 'hd_adm_isi';

			$this->load->view('hd_landing_page',$d);
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
