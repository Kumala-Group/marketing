<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);

class Henkel_adm_n_jt_inv_supp extends CI_Controller {

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
			$d['judul']="Pemberitahuan Jatuh Tempo Pembelian";
			$d['class'] = "pemberitahuan";
			$d['data'] = $this->model_isi->data_n_jt_inv_supp();
			$d['content']= 'pemberitahuan/view_n_jt_invoice_supplier';
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

			$q = $this->db_kpp->get_where("n_jt_inv_supp",$id);
			$row = $q->num_rows();
			if($row>0){
				$this->db_kpp->delete("n_jt_inv_supp",$id);
			}
			redirect('henkel_adm_n_jt_inv_supp','refresh');
		}else{
			redirect('henkel','refresh');
		}

	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
