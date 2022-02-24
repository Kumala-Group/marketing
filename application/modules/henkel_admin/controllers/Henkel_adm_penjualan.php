<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_penjualan extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_penjualan');
			$this->load->model('model_item');
	}

	public function simpan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_penjualan']= $this->input->post('id_penjualan');
			$dt['id_pesanan_penjualan'] = $this->input->post('id_pesanan_penjualan');
			$dt['kode_gudang'] = $this->input->post('kode_gudang');
			$harga_jual=$this->input->post('harga_jual');
			$dt['harga_jual'] = remove_separator2($harga_jual);
			$dt['kode_item'] = $this->input->post('kode_item');
			$dt['qty'] = $this->input->post('jumlah');
			$dt['diskon'] = $this->input->post('diskon');

			if($this->model_penjualan->ada($id)){
				$this->model_penjualan->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_penjualan'] 	= $this->model_penjualan->cari_max_penjualan();
				$this->model_penjualan->insert($dt);
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
			$id['id_t_penjualan']= $this->input->post('id_penjualan');
			$dt['id_pesanan_penjualan'] = $this->input->post('id_pesanan_penjualan');
			$dt['kode_gudang'] = $this->input->post('kode_gudang');
			$dt['kode_item'] = $this->input->post('kode_item');
			$harga_jual=$this->input->post('harga_jual');
			$dt['harga_jual'] = remove_separator($harga_jual);
			$dt['qty'] = $this->input->post('jumlah');
			$dt['diskon'] = $this->input->post('diskon');

			if($this->model_penjualan->t_ada($id)){
				$this->model_penjualan->t_update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_t_penjualan'] 	= $this->model_penjualan->t_cari_max_penjualan();
				$this->model_penjualan->t_insert($dt);
				echo "Data Sukses diSimpan";
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function kode_gudang($kode_gudang)
	{
		$parent = $this->model_item->getKd_item($kode_gudang);
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
			$id['id_penjualan']	= $this->input->get('cari');
			if($this->model_penjualan->ada($id)) {
				$dt = $this->model_penjualan->get($id);
				$d['id_penjualan']	= $dt->id_penjualan;
				$d['id_pesanan_penjualan']	= $dt->id_pesanan_penjualan;
				$d['kode_gudang'] = $dt->kode_gudang;
				$d['kode_item'] = $this->kode_gudang($dt->kode_gudang);
				$d['kode_item_val'] = $dt->kode_item;
				$d['jumlah']	= $dt->qty;
				$data = $this->db_kpp->from('item')->where('kode_item',$dt->kode_item)->get();
				foreach($data->result() as $dta)
				{
					$d['nama_item'] = $dta->nama_item;
					$d['ongkos_kirim'] = $dta->ongkos_kirim;
					$d['harga_tebus_dpp'] = $dta->harga_tebus_dpp;
				}
				$d['harga_jual'] = $dt->harga_jual;
				$d['sub_total']	= $dt->harga_jual*$dt->qty;
				$d['diskon']	= $dt->diskon;
				$d['disk_rp']	= (($dt->harga_jual*$dt->qty)*$dt->diskon)/100;
				$stok= $this->db_kpp->query("SELECT stok FROM stok_item WHERE kode_item='$dt->kode_item' AND kode_gudang='$dt->kode_gudang'");
				foreach($stok->result() as $s)
				{
					$d['stok']=$s->stok+$dt->qty;
				}
				echo json_encode($d);

			} else {
				$d['id_penjualan']	= '';
				$d['id_pesanan_penjualan']	= '';
				$d['kode_gudang'] = '';
				$d['kode_item'] = '';
				$d['nama_item'] = '';
				$d['harga_jual'] = '';
				$d['jumlah']	= '';
				$d['sub_total']	= '';
				$d['diskon']	= '';
				$d['disk_rp'] = '';
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
			$id['id_t_penjualan']	= $this->input->get('cari');
			if($this->model_penjualan->t_ada($id)) {
				$dt = $this->model_penjualan->t_get($id);
				$d['id_penjualan']	= $dt->id_t_penjualan;
				$d['id_pesanan_penjualan']	= $dt->id_pesanan_penjualan;
				$d['kode_gudang'] = $dt->kode_gudang;
				$d['kode_item'] = $this->kode_gudang($dt->kode_gudang);
				$d['kode_item_val'] = $dt->kode_item;
				$d['jumlah']	= $dt->qty;
				$data = $this->db_kpp->from('item')->where('kode_item',$dt->kode_item)->get();
				$harga_tebus_dpp = 0;
				foreach($data->result() as $dta)
				{
					$d['nama_item'] = $dta->nama_item;
					$d['ongkos_kirim'] = $dta->ongkos_kirim;
					$d['harga_tebus_dpp'] = $dta->harga_tebus_dpp;
				}
				$d['harga_jual']	= $dt->harga_jual;
				$d['sub_total']	= $dt->harga_jual*$dt->qty;
				$d['diskon']	= $dt->diskon;
				$d['disk_rp']	= (($dt->harga_jual*$dt->qty)*$dt->diskon)/100;
				$stok= $this->db_kpp->query("SELECT stok FROM stok_item WHERE kode_item='$dt->kode_item' AND kode_gudang='$dt->kode_gudang'");
				foreach($stok->result() as $s)
				{
					$d['stok']=$s->stok+$dt->qty;
				}

				echo json_encode($d);

			} else {
				$d['id_penjualan']	= '';
				$d['id_pesanan_penjualan']	= '';
				$d['kode_gudang'] = '';
				$d['kode_item'] = '';
				$d['nama_item'] = '';
				$d['harga_jual'] = '';
				$d['jumlah']	= '';
				$d['sub_total']	= '';
				$d['diskon']	= '';
				$d['disk_rp'] = '';
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
			$id['id_penjualan']	= $this->input->post('id_h');

			if($this->model_penjualan->ada($id))
			{
				$this->model_penjualan->delete($id);
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
			$id['id_t_penjualan']	= $this->input->post('id_h');

			if($this->model_penjualan->t_ada($id))
			{
				$this->model_penjualan->t_delete($id);
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
