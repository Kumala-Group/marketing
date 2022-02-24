<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_item');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Data Item";
			$d['class'] = "master";
			$d['data'] = $this->model_item->all();
			$d['kode_item_henkel'] = $this->create_kd_henkel();
			$d['kode_item_oli'] = $this->create_kd_oli();
			$d['content'] = 'item/view';
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

			$last_kd = $this->model_item->last_kode_henkel();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = "HNKL".sprintf("%03s", $no_akhir);
			}else{
				$kd = 'HNKL001';
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

			$last_kd = $this->model_item->last_kode_oli();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = "OLI".sprintf("%03s", $no_akhir);
			}else{
				$kd = 'OLI001';
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
			error_reporting(0);
			date_default_timezone_set('Asia/Makassar');
			$id['id_item']= $this->input->post('id_item');
			$dt['kode_item'] 			= $this->input->post('kode_item');
			$dt['nama_item'] 			= $this->input->post('nama_item');
			$dt['harga_tebus_dpp'] 			= remove_separator2($this->input->post('harga_tebus_dpp'));
			$dt['harga_pricelist'] 			= remove_separator2($this->input->post('harga_pricelist'));
			$dt['ongkos_kirim'] 			= remove_separator2($this->input->post('ongkos_kirim'));
			$dt['kode_satuan'] 			= $this->input->post('satuan');
			$dt['tipe'] 			= $this->input->post('tipe');
			$dt['stock_kritis'] 			= $this->input->post('stock_kritis');
			$dt['admin'] = $this->session->userdata('nama_lengkap');
			$dt['w_insert'] = date('Y-m-d H:i:s');
			if($this->model_item->ada($id)){
				$dt['w_update'] = date('Y-m-d H:i:s');
				$this->model_item->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_item'] 	= $this->model_item->cari_max_item();
				$this->model_item->insert($dt);
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
			$id['id_item']	= $this->input->get('cari');

			if($this->model_item->ada($id)) {
				$dt = $this->model_item->get($id);
				$d['id_item']	= $dt->id_item;
				$d['kode_item'] 	= $dt->kode_item;
				$d['nama_item'] 	= $dt->nama_item;
				$d['harga_tebus_dpp']	= separator_harga2($dt->harga_tebus_dpp);
				$d['harga_pricelist'] 	= separator_harga2($dt->harga_pricelist);
				$d['ongkos_kirim'] 	= separator_harga2($dt->ongkos_kirim);
				$kode_satuan=$this->model_item->getKd_satuan($dt->kode_satuan);
				$data = $this->db_kpp->from('satuan')->get();
				if(count($kode_satuan)>0){
					foreach ($kode_satuan as $row) {
						$d['satuan'] ='<option value="'.$row->kode_satuan.'">'.$row->satuan.'</option>';
						$d['satuan'] .='<option value="">--Pilih Satuan--</option>';
							foreach ($data->result() as $dt_satuan) {
								$d['satuan'] .='<option value="'.$dt_satuan->kode_satuan.'">'.$dt_satuan->satuan.'</option>';
							}
					}
				}
				$d['tipe'] = $dt->tipe;
				$d['stock_kritis']	= $dt->stock_kritis;

				echo json_encode($d);
			} else {
				$d['id_item']		= '';
				$d['kode_item']		= $this->create_kd();
				$d['nama_item']  	= '';
				$d['harga_tebus_dpp']		= '';
				$d['harga_pricelist']  	= '';
				$d['ongkos_kirim']  	= '';
				$d['satuan']		= '';
				$d['tipe'] 			= '';
				$d['stock_kritis']	= '';
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
			$id['id_item']	= $this->uri->segment(3);

			if($this->model_item->ada($id))
			{
				$this->model_item->delete($id);
			}
			redirect('henkel_adm','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
