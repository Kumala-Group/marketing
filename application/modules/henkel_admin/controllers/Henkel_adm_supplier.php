<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_supplier extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_supplier');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Data Supplier";
			$d['class'] = "master";
			$d['data'] = $this->model_supplier->all();
			$d['kode_supplier_henkel'] = $this->create_kd_henkel();
			$d['kode_supplier_oli'] = $this->create_kd_oli();
			$d['content'] = 'supplier/view';
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function create_kd_henkel()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){

			$last_kd = $this->model_supplier->last_kode_henkel();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = "SPHNKL".sprintf("%03s", $no_akhir);
			}else{
				$kd = 'SPHNKL001';
			}
			return $kd;
		}else{
			redirect('henkel','refresh');
		}
	}

	public function create_kd_oli()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){

			$last_kd = $this->model_supplier->last_kode_oli();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = "SPOLI".sprintf("%03s", $no_akhir);
			}else{
				$kd = 'SPOLI001';
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
			$id['id_supplier']= $this->input->post('id_supplier');
			$dt['kode_supplier'] 			= $this->input->post('kode_supplier');

			$dt['nama_supplier'] 			= $this->input->post('nama_supplier');
			$dt['alamat'] 			= $this->input->post('alamat');
			$dt['kota'] 			= $this->input->post('kota');
			$dt['telepon'] 			= $this->input->post('telepon');
			$dt['email'] 			= $this->input->post('email');
			$dt['kontak'] 			= $this->input->post('kontak');
			$dt['provinsi'] 			= $this->input->post('provinsi');
			$dt['kodepos'] 			= $this->input->post('kodepos');
			$dt['fax'] 			= $this->input->post('fax');
			$dt['no_rekening'] 			= $this->input->post('no_rekening');
			$dt['nama_rekening'] 			= $this->input->post('nama_rekening');
			$dt['nama_bank'] 			= $this->input->post('nama_bank');
			$dt['keterangan'] 			= $this->input->post('keterangan');
			$dt['npwp'] 			= $this->input->post('npwp');

			if($this->model_supplier->ada($id)){
				$this->model_supplier->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_supplier'] 	= $this->model_supplier->cari_max_supplier();
				$this->model_supplier->insert($dt);
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
			$id['id_supplier']	= $this->input->get('cari');

			if($this->model_supplier->ada($id)) {
				$dt = $this->model_supplier->get($id);
				//$dt = $this->model_prodi->get2($id);

				$d['id_supplier']	= $dt->id_supplier;
				$d['kode_supplier'] 	= $dt->kode_supplier;
				$d['nama_supplier'] 	= $dt->nama_supplier;
				$d['alamat'] = $dt->alamat;
				$d['kota']	= $dt->kota;
				$d['telepon']	= $dt->telepon;
				$d['email']	= $dt->email;
				$d['kontak'] = $dt->kontak;
				$d['provinsi']	= $dt->provinsi;
				$d['kodepos']	= $dt->kodepos;
				$d['fax']	= $dt->fax;
				$d['no_rekening']	= $dt->no_rekening;
				$d['nama_rekening'] = $dt->nama_rekening;
				$d['nama_bank']	= $dt->nama_bank;
				$d['keterangan']	= $dt->keterangan;
				$d['npwp']	= $dt->npwp;

				echo json_encode($d);
			} else {
				$d['id_supplier']		= '';
				$d['kode_supplier']  	= '';
				$d['nama_supplier']  	= '';
				$d['alamat'] 	= '';
				$d['kota']		= '';
				$d['telepon'] 		= '';
				$d['email']	= '';
				$d['kontak']		= '';
				$d['provinsi']  	= '';
				$d['kodepos'] 	= '';
				$d['fax']		= '';
				$d['no_rekening'] 			= '';
				$d['nama_rekening'] 		= '';
				$d['nama_bank']	= '';
				$d['keterangan']	= '';
				$d['npwp']	= '';
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
			$id['id_supplier']	= $this->uri->segment(3);

			if($this->model_supplier->ada($id))
			{
				$this->model_supplier->delete($id);
			}
			redirect('henkel_adm_supplier','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
