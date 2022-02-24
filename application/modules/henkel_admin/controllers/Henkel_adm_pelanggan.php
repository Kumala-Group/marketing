<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_pelanggan extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_pelanggan');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Data Pelanggan";
			$d['class'] = "master";
			$d['data'] = $this->model_pelanggan->all();
			$d['kode_pelanggan_henkel'] = $this->create_kd_henkel();
			$d['kode_pelanggan_oli'] = $this->create_kd_oli();
			$d['content'] = 'pelanggan/view';
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

			$last_kd = $this->model_pelanggan->last_kode_henkel();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = "PLHNKL".sprintf("%03s", $no_akhir);
			}else{
				$kd = 'PLHNKL001';
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

			$last_kd = $this->model_pelanggan->last_kode_oli();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = "PLOLI".sprintf("%03s", $no_akhir);
			}else{
				$kd = 'PLOLI001';
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
			$limit = $this->input->post('limit');
			$id['id_pelanggan']= $this->input->post('id_pelanggan');
			$dt['kode_pelanggan'] 			= $this->input->post('kode_pelanggan');
			$dt['kode_group_pelanggan'] 			= $this->input->post('group_pelanggan');
			$dt['nama_pelanggan'] 			= $this->input->post('nama_pelanggan');
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
			if (empty($limit)) {
				$limit = 0;
			} else {
				$limit = remove_separator2($this->input->post('limit'));
			}
			$dt['limit_beli'] 			= $limit;

			if($this->model_pelanggan->ada($id)){
				$this->model_pelanggan->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_pelanggan'] 	= $this->model_pelanggan->cari_max_pelanggan();
				$this->model_pelanggan->insert($dt);
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
			$id['id_pelanggan']	= $this->input->get('cari');

			if($this->model_pelanggan->ada($id)) {
				$dt = $this->model_pelanggan->get($id);
				//$dt = $this->model_prodi->get2($id);

				$d['id_pelanggan']	= $dt->id_pelanggan;
				$d['kode_pelanggan'] 	= $dt->kode_pelanggan;
				$kode_group_pelanggan=$this->model_pelanggan->getKd_group_pelanggan($dt->kode_group_pelanggan);
				$data = $this->db_kpp->from('group_pelanggan')->get();
				if(count($kode_group_pelanggan)>0){
					foreach ($kode_group_pelanggan as $row) {
						$d['group_pelanggan'] ='<option value="'.$row->kode_group_pelanggan.'">'.$row->nama_group.'</option>';
						$d['nama_group_pelanggan'] = $row->nama_group;
						$d['group_pelanggan'] .='<option value="">--Pilih Group Pelanggan--</option>';
						  foreach ($data->result() as $dt_group) {
								$d['group_pelanggan'] .='<option value="'.$dt_group->kode_group_pelanggan.'">'.$dt_group->nama_group.'</option>';
							}
					}
				}
				$d['nama_pelanggan'] 	= $dt->nama_pelanggan;
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
				$d['deposit']	= $dt->deposit;
				$d['keterangan']	= $dt->keterangan;
				$d['npwp']	= $dt->npwp;
				$d['limit']	= $dt->limit_beli;

				echo json_encode($d);
			} else {
				$d['id_pelanggan']		= '';
				$d['kode_pelanggan']  	= '';
				$d['nama_pelanggan']  	= '';
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
				$d['deposit']	= '';
				$d['keterangan']	= '';
				$d['npwp']	= '';
				$d['limit']	= '';
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
			$id['id_pelanggan']	= $this->uri->segment(3);

			if($this->model_pelanggan->ada($id))
			{
				$this->model_pelanggan->delete($id);
			}
			redirect('henkel_adm_pelanggan','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
