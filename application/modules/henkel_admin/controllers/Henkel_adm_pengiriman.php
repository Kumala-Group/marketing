<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_pengiriman extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_pengiriman');
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
			$id['id_pengiriman']= $this->input->post('id_pengiriman');
			$dt['id_pesanan_pengiriman'] 		= $this->input->post('id_pesanan_pengiriman');
			$dt['id_pesanan_pembelian'] 			= $this->input->post('id_pesanan_pembelian');
			$dt['no_inv_supplier'] 			= $this->input->post('no_inv_supplier');

			if($this->model_pengiriman->ada($id)){
				$this->model_pengiriman->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_pengiriman'] 	= $this->model_pengiriman->cari_max_pengiriman();
				$this->model_pengiriman->insert($dt);
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
			$id['id_t_pengiriman']= $this->input->post('id_t_pengiriman');
			$dt['id_pesanan_pengiriman'] 		= $this->input->post('id_pesanan_pengiriman');
			$dt['id_pesanan_pembelian'] 			= $this->input->post('id_pesanan_pembelian');
			$dt['no_inv_supplier'] 			= $this->input->post('no_inv_supplier');

			if($this->model_pengiriman->t_ada($id)){
				$this->model_pengiriman->t_update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_t_pengiriman'] 	= $this->model_pengiriman->t_cari_max_pengiriman();
				$this->model_pengiriman->t_insert($dt);
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
			$id['id_pengiriman']	= $this->input->get('cari');
			if($this->model_pengiriman->ada($id)) {
				$dt = $this->model_pengiriman->get($id);
				$d['id_pengiriman']	= $dt->id_pengiriman;
				$d['id_pesanan_pengiriman']	= $dt->id_pesanan_pengiriman;
				$d['id_pesanan_pembelian'] = $dt->id_pesanan_pembelian;
				$d['no_inv_supplier']	= $dt->no_inv_supplier;
				$data = $this->db_kpp->from('pesanan_pembelian')->where('id_pesanan_pembelian',$dt->id_pesanan_pembelian)->get();
				foreach($data->result() as $dt_pp)
				{
					$d['no_po'] = $dt_pp->no_po;
					$d['tanggal'] = $dt_pp->tanggal;
					$d['keterangan'] = $dt_pp->keterangan;
					$d['kode_supplier'] = $dt_pp->kode_supplier;
					$dataa = $this->db_kpp->from('supplier')->where('kode_supplier',$dt_pp->kode_supplier)->get();
					foreach($dataa->result() as $dt_sup)
					{
						$d['nama_supplier'] = $dt_sup->nama_supplier;
					}
				}
				echo json_encode($d);

			} else {
				$d['id_pengiriman']	= '';
				$d['id_pesanan_pengiriman']	= '';
				$d['id_pesanan_pembelian'] = '';
				$d['no_inv_supplier']	= '';
				$d['no_po'] = '';
				$d['tanggal'] = '';
				$d['keterangan'] = '';
				$d['kode_supplier'] = '';
				$d['nama_supplier'] = '';
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
			$id['id_t_pengiriman']	= $this->input->get('cari');
			if($this->model_pengiriman->t_ada($id)) {
				$dt = $this->model_pengiriman->t_get($id);
				$d['id_t_pengiriman']	= $dt->id_t_pengiriman;
				$d['id_pesanan_pengiriman']	= $dt->id_pesanan_pengiriman;
				$d['id_pesanan_pembelian'] = $dt->id_pesanan_pembelian;
				$d['no_inv_supplier']	= $dt->no_inv_supplier;
				$data = $this->db_kpp->from('pesanan_pembelian')->where('id_pesanan_pembelian',$dt->id_pesanan_pembelian)->get();
				foreach($data->result() as $dt_pp)
				{
					$d['no_po'] = $dt_pp->no_po;
					$d['tanggal'] = $dt_pp->tanggal;
					$d['keterangan'] = $dt_pp->keterangan;
					$d['kode_supplier'] = $dt_pp->kode_supplier;
					$dataa = $this->db_kpp->from('supplier')->where('kode_supplier',$dt_pp->kode_supplier)->get();
					foreach($dataa->result() as $dt_sup)
					{
						$d['nama_supplier'] = $dt_sup->nama_supplier;
					}
				}
				echo json_encode($d);

			} else {
				$d['id_t_pengiriman']	= '';
				$d['id_pesanan_pengiriman']	= '';
				$d['id_pesanan_pembelian'] = '';
				$d['no_inv_supplier']	= '';
				$d['no_po'] = '';
				$d['tanggal'] = '';
				$d['keterangan'] = '';
				$d['kode_supplier'] = '';
				$d['nama_supplier'] = '';
				echo json_encode($d);
			}}
		else {
			redirect('henkel','refresh');
		}
	}

	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_pengiriman']	= $this->uri->segment(3);

			if($this->model_pengiriman->ada($id))
			{
				$this->model_pengiriman->delete($id);
			}
			redirect('henkel_adm_pengiriman','refresh');
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
			$id['id_t_pengiriman']	= $this->input->post('id_h');

			if($this->model_pengiriman->t_ada($id))
			{
				$this->model_pengiriman->t_delete($id);
			}
		}
		else {
			redirect('henkel','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
