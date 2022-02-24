<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);

class Henkel_adm_n_stok_kritis extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_isi');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']="Pemberitahuan Stok Kritis";
			$d['class'] = "pemberitahuan";
			$d['data'] = $this->model_isi->data_n_stok_kritis();
			$d['content']= 'pemberitahuan/view_n_stok_kritis';
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}


	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id']	= $this->uri->segment(3);

			$q = $this->db_kpp->get_where("n_stok_kritis",$id);
			$row = $q->num_rows();
			if($row>0){
				$this->db_kpp->delete("n_stok_kritis",$id);
			}
			redirect('henkel_adm_n_stok_kritis','refresh');
		}else{
			redirect('henkel','refresh');
		}

	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
