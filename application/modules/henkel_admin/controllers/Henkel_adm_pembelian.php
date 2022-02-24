<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_pembelian extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_pembelian');
			$this->load->model('model_item');
	}

	public function search_kd_supplier()
	{
		// tangkap variabel keyword dari URL
		$keyword = $this->uri->segment(3);

		// cari di database
		$data = $this->db_kpp->from('supplier')->like('kode_supplier',$keyword)->get();

		// format keluaran di dalam array
		foreach($data->result() as $dt)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$dt->kode_supplier,
				'nama_supplier'	=>$dt->nama_supplier,
				'alamat'	=>$dt->alamat

			);
		}
		echo json_encode($arr);
	}

	public function search_nm_supplier()
	{
		// tangkap variabel keyword dari URL
		$keyword = $this->uri->segment(3);

		// cari di database
		$data = $this->db_kpp->from('supplier')->like('nama_supplier',$keyword)->get();

		// format keluaran di dalam array
		foreach($data->result() as $dt)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$dt->nama_supplier,
				'kode_supplier'	=>$dt->kode_supplier,
				'alamat'	=>$dt->alamat

			);
		}
		echo json_encode($arr);
	}

	public function search_kd_item()
	{
		// tangkap variabel keyword dari URL
		$keyword = $this->uri->segment(3);

		// cari di database
		$data = $this->db_kpp->from('item')->like('kode_item',$keyword)->get();

		// format keluaran di dalam array
		foreach($data->result() as $dt)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$dt->kode_item,
				'nama_item' =>$dt->nama_item,
				'harga_item'	=>$dt->harga_item

			);
		}
		echo json_encode($arr);
	}

	public function simpan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$kode_item = $this->input->post('kode_item');
			$status	= $this->input->post('status');
			$harga_tebus_dpp = $this->input->post('harga_tebus_o');
			$admin = $this->session->userdata('nama_lengkap');
			$max_kode_item = $this->input->post('kode_item_now');
			$nama_item = $this->input->post('nama_item');
			$kode_item_rest = substr($kode_item, -2);
			$max_kode_item_rest = substr($max_kode_item, -2);
			$current_timestamp = date('Y-m-d H:i:s');
			$id['id_pembelian']= $this->input->post('id_pembelian');
			$dt['id_pesanan_pembelian'] 		= $this->input->post('id_pesanan_pembelian');
			$dt['kode_item'] 			= $this->input->post('kode_item');
			$dt['harga_tebus_dpp'] 			= $this->input->post('harga_tebus_o');
			$dt['jumlah'] 			= $this->input->post('jumlah');
			$dt['jumlah_o'] 			= $this->input->post('jumlah');
			$dt['diskon'] 			= $this->input->post('diskon');

			if($this->model_pembelian->ada($id)){
						if (strcmp($status,'changed') == 0) {
							$this->model_pembelian->update($id, $dt);
							$this->db_kpp->query("UPDATE item SET harga_tebus_dpp='$harga_tebus_dpp', w_update='$current_timestamp' WHERE kode_item='$kode_item'");
						} else if (strcmp($status,'same') == 0) {
							$this->model_pembelian->update($id, $dt);
						} else {
							$this->model_pembelian->update($id, $dt);
						}
				echo "Data Sukses diUpdate";
				

			}else{
				$dt['id_pembelian'] 	= $this->model_pembelian->cari_max_pembelian();				
				if ($kode_item_rest>$max_kode_item_rest) {
					$this->model_pembelian->insert($dt);
					$this->db_kpp->query("INSERT INTO item (kode_item, nama_item, harga_tebus_dpp, w_insert, admin)
										  VALUES ('$kode_item', '$nama_item', '$harga_tebus_dpp', '$current_timestamp', '$admin')");
				} else {
						if (strcmp($status,'changed') == 0) {
							$this->model_pembelian->insert($dt);
							$this->db_kpp->query("UPDATE item SET harga_tebus_dpp='$harga_tebus_dpp', w_update='$current_timestamp' WHERE kode_item='$kode_item'");
						} else if (strcmp($status,'same') == 0) {
							$this->model_pembelian->insert($dt);
						} else {
							$this->model_pembelian->insert($dt);
						}
					}
				echo "Data Sukses diSimpan";
			}
		}else{
			redirect('henkel','refresh');
		}

	}

	public function t_simpan() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$kode_item = $this->input->post('kode_item');
			$status	= $this->input->post('status');
			$harga_tebus_dpp = $this->input->post('harga_tebus_o');
			$admin = $this->session->userdata('nama_lengkap');
			$max_kode_item = $this->input->post('kode_item_now');
			$nama_item = $this->input->post('nama_item');
			$kode_item_rest = substr($kode_item, -2);
			$max_kode_item_rest = substr($max_kode_item, -2);
			$current_timestamp = date('Y-m-d H:i:s');
			$id['id_t_pembelian']= $this->input->post('id_t_pembelian');
			$dt['id_pesanan_pembelian'] 		= $this->input->post('id_pesanan_pembelian');
			$dt['kode_item'] 			= $this->input->post('kode_item');
			$dt['harga_tebus_dpp'] 			= $this->input->post('harga_tebus_o');
			$dt['jumlah'] 			= $this->input->post('jumlah');
			$dt['jumlah_o'] 			= $this->input->post('jumlah');
			$dt['diskon'] 			= $this->input->post('diskon');
			$dt['status_om'] 			= "0";

			if($this->model_pembelian->t_ada($id)){
				if ($kode_item_rest>$max_kode_item_rest) {
					$this->model_pembelian->t_update($id, $dt);
					$this->db_kpp->query("INSERT INTO item (kode_item, nama_item, harga_tebus_dpp, w_insert, admin)
																VALUES ('$kode_item', '$nama_item', '$harga_tebus_dpp', '$current_timestamp', '$admin')");
					} else {
						if (strcmp($status,'changed') == 0) {
							$this->model_pembelian->t_update($id, $dt);
							$this->db_kpp->query("UPDATE item SET harga_tebus_dpp='$harga_tebus_dpp', w_update='$current_timestamp' WHERE kode_item='$kode_item'");
						} else if (strcmp($status,'same') == 0) {
							$this->model_pembelian->t_update($id, $dt);
						} else {
							$this->model_pembelian->t_update($id, $dt);
					}
				}
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_t_pembelian'] 	= $this->model_pembelian->t_cari_max_pembelian();				
				if ($kode_item_rest>$max_kode_item_rest) {
					$this->model_pembelian->t_insert($dt);
					$this->db_kpp->query("INSERT INTO item (kode_item, nama_item, harga_tebus_dpp, w_insert, admin)
																VALUES ('$kode_item', '$nama_item', '$harga_tebus_dpp', '$current_timestamp', '$admin')");
					} else {
						if (strcmp($status,'changed') == 0) {
							$this->model_pembelian->t_insert($dt);
							$this->db_kpp->query("UPDATE item SET harga_tebus_dpp='$harga_tebus_dpp', w_update='$current_timestamp' WHERE kode_item='$kode_item'");
						} else if (strcmp($status,'same') == 0) {
							$this->model_pembelian->t_insert($dt);
						} else {
							$this->model_pembelian->t_insert($dt);
					}
				}
				echo "Data Sukses diSimpan";
			}
		} else {
			redirect('henkel','refresh');
		}
	}

	public function cari()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_pembelian']	= $this->input->get('cari');
			if($this->model_pembelian->ada($id)) {
				$dt = $this->model_pembelian->get($id);
				$d['id_pembelian']	= $dt->id_pembelian;
				$d['id_pesanan_pembelian']	= $dt->id_pesanan_pembelian;
				$d['kode_item'] = $dt->kode_item;
				$d['jumlah']	= $dt->jumlah;
				$d['diskon']	= $dt->diskon;
				$d['harga_tebus']	= separator_harga2($dt->harga_tebus_dpp);
				$data_item = $this->db_kpp->from('item')->where('kode_item',$dt->kode_item)->get();
				foreach($data_item->result() as $dt_item)
				{
					$d['nama_item'] = $dt_item->nama_item;
					$d['harga_tebus_dpp'] = separator_harga2($dt_item->harga_tebus_dpp);
				}
				echo json_encode($d);

			} else {
				$d['id_pembelian']	= '';
				$d['id_pesanan_pembelian']	= '';
				$d['kode_item'] = '';
				$d['nama_item'] = '';
				$d['harga_item'] = '';
				$d['harga_tebus_dpp'] = '';
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
			$id['id_t_pembelian']	= $this->input->get('cari');
			if($this->model_pembelian->t_ada($id)) {
				$dt = $this->model_pembelian->t_get($id);
				$d['id_t_pembelian']	= $dt->id_t_pembelian;
				$d['id_pesanan_pembelian']	= $dt->id_pesanan_pembelian;
				$d['kode_item'] = $dt->kode_item;
				$d['jumlah']	= $dt->jumlah;
				$d['diskon']	= $dt->diskon;
				$d['harga_tebus_dpp']	= $dt->harga_tebus_dpp;
				$data = $this->db_kpp->from('item')->where('kode_item',$dt->kode_item)->get();
				$harga_tebus_master = 0;
				foreach($data->result() as $dtx)
				{
					$d['nama_item'] = $dtx->nama_item;
					$d['harga_tebus_master'] = $dtx->harga_tebus_dpp;
					$harga_tebus_master=$dtx->harga_tebus_dpp;
				}
				$d['disk_rp']	= separator_harga2((($harga_tebus_master*$dt->jumlah)*$dt->diskon)/100);
				echo json_encode($d);

			} else {
				$d['id_t_pembelian']	= '';
				$d['id_pesanan_pembelian']	= '';
				$d['kode_item'] = '';
				$d['nama_item'] = '';
				$d['harga_tebus_dpp'] = '';
				$d['jumlah']	= '';
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
			$id['id_pembelian']	= $this->uri->segment(3);

			if($this->model_pembelian->ada($id))
			{
				$this->model_pembelian->delete($id);
			}
			redirect('henkel_adm_pembelian','refresh');
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
			$id['id_t_pembelian']	= $this->input->post('id_h');

			if($this->model_pembelian->t_ada($id))
			{
				$this->model_pembelian->t_delete($id);
			}
		}
		else {
			redirect('henkel','refresh');
		}

	}

	public function kode_item()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){

			$last_kd = $this->model_item->last_kode();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = "HNKL".sprintf("%03s", $no_akhir);
				//echo json_encode($d);
			}else{
				$kd = 'HNKL001';
				//echo json_encode($d);
			}
			return $kd;
		}else{
			redirect('henkel','refresh');
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
