<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_home extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->database('default', TRUE);
		  $this->load->model('model_isi');
	}


	public function index()
	{
		error_reporting(0);
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']="Dashboard";
			$d['class'] = "home";
			$d['category'] = $this->model_isi->create_category_penjualan();
			$d['category_ar'] = $this->model_isi->create_category_ar();
			$d['tot_penjualan'] = $this->model_isi->data_chart_tot_penjualan();
			$d['tot_ar'] = $this->model_isi->data_chart_tot_ar();
			$d['content']= 'henkel_adm_isi';

			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
