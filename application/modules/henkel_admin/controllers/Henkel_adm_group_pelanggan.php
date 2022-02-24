<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_group_pelanggan extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_group_pelanggan');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Data Group Pelanggan";
			$d['class'] = "pustaka";
			$d['data'] = $this->model_group_pelanggan->all();
			$d['kode_group_pelanggan'] = $this->create_kd();
			$d['content'] = 'group_pelanggan/view';
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

			$last_kd = $this->model_group_pelanggan->last_kode();
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
			$id['id_group_pelanggan']= $this->input->post('id_group_pelanggan');
			$dt['kode_group_pelanggan'] 			= $this->input->post('kode_group_pelanggan');
			$dt['nama_group'] 			= $this->input->post('nama_group');
			$dt['margin_min'] 			= $this->input->post('margin_min');
			$dt['margin_max'] 			= $this->input->post('margin_max');

			if($this->model_group_pelanggan->ada($id)){
				$this->model_group_pelanggan->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_group_pelanggan'] 	= $this->model_group_pelanggan->cari_max_group_pelanggan();
				$this->model_group_pelanggan->insert($dt);
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
			$id['id_group_pelanggan']	= $this->input->get('cari');

			if($this->model_group_pelanggan->ada($id)) {
				$dt = $this->model_group_pelanggan->get($id);
				//$dt = $this->model_prodi->get2($id);

				$d['id_group_pelanggan']	= $dt->id_group_pelanggan;
				$d['kode_group_pelanggan']	= $dt->kode_group_pelanggan;
				$d['nama_group']	= $dt->nama_group;
				$d['margin_min']	= $dt->margin_min;
				$d['margin_max']	= $dt->margin_max;

				echo json_encode($d);
			} else {
				$d['id_group_pelanggan']		= '';
				$d['kode_group_pelanggan']	 = '';
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
			$id['id_group_pelanggan']	= $this->uri->segment(3);

			if($this->model_group_pelanggan->ada($id))
			{
				$this->model_group_pelanggan->delete($id);
			}
			redirect('henkel_adm_group_pelanggan','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
