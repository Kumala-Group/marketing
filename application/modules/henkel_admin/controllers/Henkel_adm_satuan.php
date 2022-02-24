<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_satuan extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_satuan');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Data Satuan";
			$d['class'] = "master";
			$d['data'] = $this->model_satuan->all();
			$d['content'] = 'satuan/view';
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

/*
	public function create_kd()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){

			$last_kd = $this->model_satuan->last_kode();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = "SAT".sprintf("%03s", $no_akhir);
				//echo json_encode($d);
			}else{
				$kd = 'SAT001';
				//echo json_encode($d);
			}
			return $kd;
		}else{
			redirect('henkel','refresh');
		}

	}
*/

	public function simpan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_satuan']= $this->input->post('id_satuan');

			$dt['kode_satuan'] 			= $this->input->post('kode_satuan');
			$dt['satuan'] 			= $this->input->post('satuan');

			if($this->model_satuan->ada($id)){
				$this->model_satuan->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_satuan'] 	= $this->model_satuan->cari_max_satuan();
				$this->model_satuan->insert($dt);
				echo "Data Sukses diSimpan";
			}
		}else{
			redirect('henkel','refresh');
		}

	}

	public function cari()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_satuan']	= $this->input->get('cari');

			if($this->model_satuan->ada($id)) {
				$dt = $this->model_satuan->get($id);
				//$dt = $this->model_prodi->get2($id);

				$d['id_satuan']	= $dt->id_satuan;
				$d['kode_satuan']	= $dt->kode_satuan;
				$d['satuan'] 	= $dt->satuan;

				echo json_encode($d);
			} else {
				$d['id_satuan']		= '';
				$d['kode_satuan']	= '';
				$d['satuan']  	= '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_satuan']	= $this->uri->segment(3);

			if($this->model_satuan->ada($id))
			{
				$this->model_satuan->delete($id);
			}
			redirect('henkel_adm_satuan','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
