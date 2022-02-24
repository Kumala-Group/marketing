<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Marketing_dept_home extends CI_Controller {

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
		if(!empty($cek) && $level=='marketing_dept'){
			$d['judul']="Dashboard";
			$d['class'] = "home";
			$d['content']= 'marketing_dept_isi';

			$this->load->view('marketing_dept_home',$d);
		}else{
			redirect('kmg','refresh');
		}
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
