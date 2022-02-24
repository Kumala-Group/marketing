<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_saldo_awal_perkiraan extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_saldo_awal_perkiraan');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']="Saldo Awal Perkiraan";
			$d['class'] = "akuntansi";
			$d['data'] = $this->model_saldo_awal_perkiraan->all();
			$d['kode_saldo_awal_perkiraan'] = $this->create_kd();
			$d['content'] = 'saldo_awal_perkiraan/view';
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function create_kd()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){

			$last_kd = $this->model_saldo_awal_perkiraan->last_kode();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = "GPL".sprintf("%03s", $no_akhir);
				//echo json_encode($d);
			}else{
				$kd = 'GPL001';
				//echo json_encode($d);
			}
			return $kd;
		}else{
			redirect('henkel','refresh');
		}

	}

	public function simpan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_saldo_awal_perkiraan']= $this->input->post('id_saldo_awal_perkiraan');
			$dt['kode_saldo_awal_perkiraan'] 			= $this->input->post('kode_saldo_awal_perkiraan');
			$dt['nama_group'] 			= $this->input->post('nama_group');
			$dt['margin_min'] 			= $this->input->post('margin_min');
			$dt['margin_max'] 			= $this->input->post('margin_max');

			if($this->model_saldo_awal_perkiraan->ada($id)){
				$this->model_saldo_awal_perkiraan->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_saldo_awal_perkiraan'] 	= $this->model_saldo_awal_perkiraan->cari_max_saldo_awal_perkiraan();
				$this->model_saldo_awal_perkiraan->insert($dt);
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
			$id['id_saldo_awal_perkiraan']	= $this->input->get('cari');

			if($this->model_saldo_awal_perkiraan->ada($id)) {
				$dt = $this->model_saldo_awal_perkiraan->get($id);
				//$dt = $this->model_prodi->get2($id);

				$d['id_saldo_awal_perkiraan']	= $dt->id_saldo_awal_perkiraan;
				$d['kode_saldo_awal_perkiraan']	= $dt->kode_saldo_awal_perkiraan;
				$d['nama_group']	= $dt->nama_group;
				$d['margin_min']	= $dt->margin_min;
				$d['margin_max']	= $dt->margin_max;

				echo json_encode($d);
			} else {
				$d['id_saldo_awal_perkiraan']		= '';
				$d['kode_saldo_awal_perkiraan']	 = '';
				$d['nama_group']		= '';
				$d['margin_min']		= '';
				$d['margin_max']		= '';

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
			$id['id_saldo_awal_perkiraan']	= $this->uri->segment(3);

			if($this->model_saldo_awal_perkiraan->ada($id))
			{
				$this->model_saldo_awal_perkiraan->delete($id);
			}
			redirect('henkel_adm_saldo_awal_perkiraan','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
