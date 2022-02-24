<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_search extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_item');
	}

	public function search_kd_pelanggan()
	{
		$keyword = $this->uri->segment(3);
		$data = $this->db_kpp->from('pelanggan')->like('kode_pelanggan',$keyword)->get();
		// format keluaran di dalam array
		foreach($data->result() as $dt)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$dt->kode_pelanggan,
				'nama_pelanggan'	=>$dt->nama_pelanggan,
				'alamat'	=>$dt->alamat
			);
		}
		echo json_encode($arr);
	}

	public function search_kd_supplier()
	{
		$keyword = $this->uri->segment(3);
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

	public function search_kd_item() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id	= $this->input->post('kode_gudang');
			$kode_item=$this->modeldb_kpp->getKd_item($id);
			if (count($kode_item)<=0) {
				$output='';
				$output.='<option value="">--Maaf Tidak Ada Data--</option>';
				foreach ($kode_item as $dt) {
					$output.='<option value="">--Maaf Tidak Ada Data--</option>';
				}
				echo json_encode($output);
			}
			elseif(count($kode_item)>0){
				$output='';
				$output.='<option value="">--Pilih Kode Item--</option>';
				foreach ($kode_item as $dt) {
					$output.='<option value="'.$dt->kode_item.'">'.$dt->kode_item.'</option>';
				}
				echo json_encode($output);
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function search_nm_item(){
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$kode_item	= $this->input->post('kode_item');
			$kode_gudang	= $this->input->post('kode_gudang');
			$q = $this->db_kpp->query("SELECT so.*,o.harga_item,o.nama_item FROM stok_item so INNER JOIN item o ON so.kode_item=o.kode_item WHERE so.kode_item='$kode_item' AND so.kode_gudang='$kode_gudang'");
			$row = $q->num_rows();
			if($row>0){
				foreach($q->result() as $dt){
					$d['nama_item'] = $dt->nama_item;
					$d['harga_satuan'] = separator_harga2($dt->harga_item);
					$d['stok'] = $dt->stok;
				}
				echo json_encode($d);
			}else{
					$d['nama_item'] = '';
					$d['harga_satuan'] = '';
					$d['stok'] = '';
				echo json_encode($d);
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function search_nonseparated_item(){
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$kode_item	= $this->input->post('kode_item');
			$kode_gudang	= $this->input->post('kode_gudang');
			$q = $this->db_kpp->query("SELECT so.*,o.nama_item,o.harga_tebus_dpp,o.harga_pricelist,o.ongkos_kirim
																 FROM stok_item so
																 INNER JOIN item o ON so.kode_item=o.kode_item
																 WHERE so.kode_item='$kode_item' AND so.kode_gudang='$kode_gudang'");
			$row = $q->num_rows();
			if($row>0){
				foreach($q->result() as $dt){
					$d['nama_item'] = $dt->nama_item;
					$d['harga_tebus_dpp'] = $dt->harga_tebus_dpp;
					$d['harga_pricelist'] = $dt->harga_pricelist;
					$d['ongkos_kirim'] = $dt->ongkos_kirim;
					$d['stok'] = $dt->stok;
				}
				echo json_encode($d);
			}else{
					$d['nama_item'] = '';
					$d['harga_tebus_dpp'] = '';
					$d['harga_pricelist'] = '';
					$d['ongkos_kirim'] = '';
					$d['stok'] = '';
				echo json_encode($d);
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function search_nm_pelanggan()
	{
		// tangkap variabel keyword dari URL
		$keyword = $this->uri->segment(3);

		// cari di database
		$data = $this->db_kpp->from('pelanggan')->like('nama_pelanggan',$keyword)->get();

		// format keluaran di dalam array
		foreach($data->result() as $dt)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$dt->nama_pelanggan,
				'kode_pelanggan'	=>$dt->kode_pelanggan,
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

	public function search_kd_sales()
	{
		$keyword = $this->uri->segment(3);
		$id_perusahaan=$this->session->userdata('id_perusahaan');
		$id_brand=$this->session->userdata('id_brand');

		$data = $this->db->query("
			SELECT k.nik,k.nama_karyawan FROM karyawan k INNER JOIN p_divisi pd ON k.id_divisi=pd.id_divisi WHERE k.nik LIKE '%$keyword%' AND k.id_perusahaan='20' AND pd.divisi='SALES' OR k.id_perusahaan='28' AND pd.divisi='SALES'
			UNION 
						        	SELECT db_kpp.sales.kode_sales AS nik, db_kpp.sales.nama_sales AS nama_karyawan FROM db_kpp.sales WHERE db_kpp.sales.kode_sales LIKE '%$keyword%'");

		foreach($data->result() as $dt)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$dt->nik,
				'nama_karyawan'	=>$dt->nama_karyawan

			);
		}
		echo json_encode($arr);
	}

	public function search_nm_sales()
	{
		$keyword = $this->uri->segment(3);
		$id_perusahaan=$this->session->userdata('id_perusahaan');
		$id_brand=$this->session->userdata('id_brand');

		$data = $this->db->query("SELECT k.nik,k.nama_karyawan FROM karyawan k INNER JOIN p_divisi pd ON k.id_divisi=pd.id_divisi WHERE k.nama_karyawan LIKE '%$keyword%' AND k.id_perusahaan='20' AND pd.divisi='SALES' OR k.id_perusahaan='28' AND pd.divisi='SALES'
			UNION 
						        	SELECT db_kpp.sales.kode_sales AS nik, db_kpp.sales.nama_sales AS nama_karyawan FROM db_kpp.sales WHERE db_kpp.sales.nama_sales LIKE '%$keyword%'");
		foreach($data->result() as $dt)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$dt->nama_karyawan,
				'nik'	=>$dt->nik

			);
		}
		echo json_encode($arr);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
