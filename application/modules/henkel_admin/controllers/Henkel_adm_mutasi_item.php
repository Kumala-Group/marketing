<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_mutasi_item extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_mutasi_item');
			//$this->load->model('model_pesanan_pembelian');
	}

	public function index() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Data Mutasi Item";
			$d['class'] = "persediaan";
			$d['data'] = $this->db_kpp->query("SELECT mo.*, ol.nama_item, gd_asal.nama_gudang
																				 AS gd_asal, gd_tujuan.nama_gudang
																				 AS gd_tujuan
																				 FROM mutasi_item mo
																				 INNER JOIN gudang gd_asal
																				 ON mo.gudang_asal = gd_asal.kode_gudang
																				 INNER JOIN gudang gd_tujuan
																				 ON mo.gudang_tujuan = gd_tujuan.kode_gudang
																				 INNER JOIN item ol
																				 ON mo.kode_item = ol.kode_item");
			$d['content'] = 'mutasi_item/view';
			$this->load->view('henkel_adm_home',$d);
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
			$id['id_mutasi_item']= $this->input->post('id_mutasi_item');
			$dt['gudang_asal']= $this->input->post('gudang_asal');
			$dt['gudang_tujuan'] 			= $this->input->post('gudang_tujuan');
			$dt['kode_item'] 			= $this->input->post('kode_item');
			$dt['jumlah'] 			= $this->input->post('jumlah');
			$dt['tanggal_mutasi'] 			= tgl_sql($this->input->post('tanggal_mutasi'));
			$dt['keterangan'] = $this->input->post('keterangan');
			$dt['admin'] = $this->session->userdata('nama_lengkap');
			if($this->model_mutasi_item->ada($id)){
				$dt['w_update'] = date('Y-m-d H:i:s');
				$this->model_mutasi_item->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_mutasi_item'] 	= $this->model_mutasi_item->cari_max_mutasi_item();
				$dt['w_insert'] = date('Y-m-d H:i:s');
				$this->model_mutasi_item->insert($dt);
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
			$id['id_mutasi_item']	= $this->input->get('cari');

			if($this->model_mutasi_item->ada($id)) {
				$dt = $this->model_mutasi_item->get($id);
				//$dt = $this->model_prodi->get2($id);

				$d['id_mutasi_item']	= $dt->id_mutasi_item;
				$d['gudang_asal'] 	= $dt->gudang_asal;
				$d['gudang_tujuan'] 	= $dt->gudang_tujuan;
				$data_item = $this->db_kpp->from('item')->where('kode_item',$dt->kode_item)->get();
				foreach($data_item->result() as $dt){
					$d['nama_item'] = $dt->nama_item;
				}
				$d['jumlah']=$dt->jumlah;
				$d['tanggal_mutasi'] = tgl_sql($dt->tanggal_mutasi);
				$d['keterangan']=$dt->keterangan;
				echo json_encode($d);
			} else {
				$d['id_mutasi_item']		= '';
				$d['gudang_asal']  	= '';
				$d['gudang_tujuan']  	= '';
				$d['kode_item']  	= '';
				$d['nama_item'] = '';
				$d['jumlah'] = '';
				$d['keterangan'] = '';
				$d['tanggal_mutasi'] = '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function search_kd_item() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id	= $this->input->post('kode_gudang');
			$kode_item=$this->model_mutasi_item->getKd_item($id);
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
					$output.='<option value="'.$dt->kode_item.'">'.$dt->kode_item.'<b>('.$dt->nama_item.'-'.$dt->tipe.')</b></option>';
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
			$id['kode_item']	= $this->input->post('kode_item');
			$q = $this->db_kpp->get_where('item',$id);
			$row = $q->num_rows();
			if($row>0){
				foreach($q->result() as $dt){
					$d['nama_item'] = $dt->nama_item;
				}
				echo json_encode($d);
			}else{
					$d['nama_item'] = '';
				echo json_encode($d);
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function search_stok_item(){
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$kode_item	= $this->input->post('kode_item');
			$kode_gudang	= $this->input->post('kode_gudang');
			$q = $this->db_kpp->get_where('stok_item', array('kode_item' => $kode_item, 'kode_gudang' => $kode_gudang));
			$row = $q->num_rows();
			if($row>0){
				foreach($q->result() as $dt){
					$d['stok'] = $dt->stok;
				}
				echo json_encode($d);
			}else{
					$d['stok'] = '';
				echo json_encode($d);
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_mutasi_item']	= $this->uri->segment(3);

			if($this->model_mutasi_item->ada($id))
			{
				$this->model_mutasi_item->delete($id);
			}
			redirect('henkel_adm_mutasi_item','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
