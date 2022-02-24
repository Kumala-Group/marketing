<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_r_pembelian extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_r_pembelian');
			$this->load->model('model_item');
	}

	public function simpan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_r_pembelian']= $this->input->post('id_r_pembelian');
			$dt['id_retur_pembelian'] = $this->input->post('id_retur_pembelian');
			$dt['kode_item'] = $this->input->post('kode_item');
			$harga=$this->input->post('harga_satuan');
			$dt['harga_retur'] = remove_separator2($harga);
			$dt['qty_retur'] = $this->input->post('jumlah');
			$dt['diskon'] = $this->input->post('diskon');

			if($this->model_r_pembelian->ada($id)){
				$this->model_r_pembelian->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_r_pembelian'] 	= $this->model_r_pembelian->cari_max_r_pembelian();
				$this->model_r_pembelian->insert($dt);
				echo "Data Sukses diSimpan";
			}
		}else{
			redirect('henkel','refresh');
		}

	}

	public function t_simpan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_t_r_pembelian']= $this->input->post('id_r_pembelian');
			$dt['id_retur_pembelian'] = $this->input->post('id_retur_pembelian');
			$dt['kode_item'] = $this->input->post('kode_item');
			$total=$this->input->post('total');
			$dt['harga_retur'] = remove_separator2($total);
			$dt['qty'] = $this->input->post('jumlah_beli');
			$dt['qty_retur'] = $this->input->post('jumlah');
			$dt['diskon'] = $this->input->post('diskon');

			if($this->model_r_pembelian->t_ada($id)){
				$this->model_r_pembelian->t_update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_t_r_pembelian'] 	= $this->model_r_pembelian->t_cari_max_r_pembelian();
				$this->model_r_pembelian->t_insert($dt);
				echo "Data Sukses diSimpan";
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function kode_gudang($kode_gudang)
	{
		$parent = $this->modeldb_kpp->getKd_item($kode_gudang);
		if(count($parent)>0){
			$output='';
			$output.='<option value="">-- Pilih Parent --</option>';
			foreach ($parent as $dt) {
				$output.='<option value="'.$dt->kode_item.'">'.$dt->kode_item.'</option>';
			}
		}else {
			$output='';
			$output.='<option value="">-- Pilih Parent --</option>';
		}
		return $output;
	}

	public function cari()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_r_pembelian']	= $this->input->get('cari');
			if($this->model_r_pembelian->ada($id)) {
				$dt = $this->model_r_pembelian->get($id);
				$d['id_r_pembelian']	= $dt->id_r_pembelian;
				$d['id_retur_pembelian']	= $dt->id_retur_pembelian;
				$d['kode_item'] = $dt->kode_item;
				//$d['harga_item'] = separator_harga2($dt->harga_retur);
				$d['jumlah']	= $dt->qty;
				$d['jumlah_retur']	= $dt->qty_retur;
				$d['diskon']	= $dt->diskon;
				$data = $this->db_kpp->from('item')->where('kode_item',$dt->kode_item)->get();
				foreach($data->result() as $dt)
				{
					$d['nama_item'] = $dt->nama_item;
					$d['harga_item'] = separator_harga2($dt->harga_tebus_dpp);
				}
				echo json_encode($d);

			} else {
				$d['id_r_pembelian']	= '';
				$d['id_pesanan_r_pembelian']	= '';
				$d['kode_gudang'] = '';
				$d['kode_item'] = '';
				$d['nama_item'] = '';
				$d['harga_item'] = '';
				$d['jumlah']	= '';
				$d['diskon']	= '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function t_cari()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_t_r_pembelian']	= $this->input->get('cari');
			if($this->model_r_pembelian->t_ada($id)) {
				$dt = $this->model_r_pembelian->t_get($id);
				$d['id_r_pembelian']	= $dt->id_t_r_pembelian;
				$d['id_retur_pembelian']	= $dt->id_retur_pembelian;
				$d['kode_item'] = $dt->kode_item;
				//$d['harga_item'] = separator_harga2($dt->harga_retur);
				$d['jumlah']	= $dt->qty;
				$d['jumlah_retur']	= $dt->qty_retur;
				$d['diskon']	= $dt->diskon;
				$data = $this->db_kpp->from('item')->where('kode_item',$dt->kode_item)->get();
				foreach($data->result() as $dt)
				{
					$d['nama_item'] = $dt->nama_item;
					$d['harga_item'] = separator_harga2($dt->harga_tebus_dpp);
				}
				echo json_encode($d);

			} else {
				$d['id_t_r_pembelian']	= '';
				$d['id_retur_pembelian']	= '';
				$d['kode_item'] = '';
				$d['nama_item'] = '';
				$d['harga_item'] = '';
				$d['jumlah']	= '';
				$d['jumla_retur']	= '';
				$d['diskon']	= '';
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
			$id['id_r_penjualan']	= $this->input->post('id_h');

			if($this->model_r_penjualan->ada($id))
			{
				$this->model_r_penjualan->delete($id);
			}
		}
		else
		{
			redirect('henkel','refresh');
		}

	}

	public function t_hapus()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_t_r_penjualan']	= $this->input->post('id_h');

			if($this->model_r_penjualan->t_ada($id))
			{
				$this->model_r_penjualan->t_delete($id);
			}
		}
		else
		{
			redirect('henkel','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
