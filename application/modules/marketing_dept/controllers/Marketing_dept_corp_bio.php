<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Marketing_dept_corp_bio extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_corp');
	}


	public function index()
	{
		error_reporting(0);
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='marketing_dept'){
			$d['judul']="Business Overview";
			$d['class'] = "corp";
            $d['category'] = $this->model_corp->create_category_karyawan_bulan('');
			$d['karyawan'] = $this->model_corp->data_chart_karyawan_bulan('');
			$d['aktif'] = $this->model_corp->data_chart_status('Aktif');
			$d['resign'] = $this->model_corp->data_chart_status('Resign');
			$d['habis_kontrak'] = $this->model_corp->data_chart_status('Habis Kontrak');
			$d['permanen'] = $this->model_corp->data_chart_status('permanen');
			$d['content']= 'corp/bio';

			$this->load->view('marketing_dept_home',$d);
		}else{
			redirect('kmg','refresh');
		}
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
