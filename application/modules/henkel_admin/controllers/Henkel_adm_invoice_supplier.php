<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_invoice_supplier extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_item_masuk');
			$this->load->model('model_pesanan_pembelian');
	}

	public function index() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Data Pembelian";
			$d['class'] = "pembelian";
			$d['data'] = $this->db_kpp->query("SELECT id_item_masuk, no_invoice, no_po, tanggal_invoice, total_akhir FROM item_masuk");
			$d['content'] = 'invoice_supplier/view';
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function simpan_noinvoice(){
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id_item_masuk = $this->input->post('id_item_masuk');
			$no_invoice = $this->input->post('no_invoice');
			$w_update = date('Y-m-d H:i:s');
			$this->db_kpp->query("UPDATE item_masuk
				SET no_invoice='$no_invoice', w_update='$w_update'
				WHERE id_item_masuk='$id_item_masuk'");
			echo "Data Sukses diUpdate";
		}else{
			redirect('henkel','refresh');
		}
	}

	public function simpan(){
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_item_masuk'] = $this->input->post('id_item_masuk');
			$dt['w_insert'] = $this->input->post('tanggal_input');
			$dt['no_po'] = $this->input->post('no_po');
			$dt['no_invoice'] = $this->input->post('no_invoice');
			$dt['tanggal_invoice'] = tgl_sql($this->input->post('tanggal_invoice'));
			$dt['kode_item'] = $this->input->post('kode_item');
			$dt['kode_gudang'] 	= $this->input->post('nama_gudang');
			$dt['keterangan'] = $this->input->post('keterangan');
			$dt['total_item_item_masuk'] = $this->input->post('tambah_stok');
			$dt['admin'] = $this->session->userdata('nama_lengkap');
			if($this->model_item_masuk->ada($id)){
			  $dt['w_update'] = date('Y-m-d H:i:s');
				$this->model_item_masuk->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_item_masuk'] = $this->model_item_masuk->cari_max_item_masuk();
				$dt['w_insert'] = date('Y-m-d H:i:s');
				$this->model_item_masuk->insert($dt);
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
			$id_item_masuk_detail = $this->model_item_masuk->cari_max_item_masuk_detail();
			$id['id_t_item_masuk']= $this->input->post('id_t_item_masuk');
			$dt['id_pesanan_pembelian'] 		= $this->input->post('id_pes_pem');
			$dt['id_item_masuk_detail'] 		= $id_item_masuk_detail;
			$dt['no_po'] 		= $this->input->post('no_po');
			$dt['no_invoice'] 			= $this->input->post('no_invoice');
			$dt['tanggal_invoice'] 			= tgl_sql($this->input->post('tanggal_invoice'));
			$dt['kode_item'] 			= $this->input->post('kode_item');
			$dt['jumlah_order'] 			= $this->input->post('jumlah_order');
			$dt['kode_gudang'] 			= $this->input->post('nama_gudang');
			$dt['keterangan'] 			= $this->input->post('keterangan');
			$dt['total_item_item_masuk'] 			= $this->input->post('tambah_stok');
			$dt['w_insert'] = date('Y-m-d H:i:s');
			$dt['admin'] = $this->session->userdata('nama_lengkap');
			if($this->model_item_masuk->t_ada($id)){
				$this->model_item_masuk->t_update($id, $dt);
				$id_pes_pem = $this->input->post('id_pes_pem');
				$get_no_po_am = $this->db_kpp->query("SELECT no_po
																							FROM pesanan_pembelian
																							WHERE id_pesanan_pembelian='$id_pes_pem'")->row();
				$no_po_am = $get_no_po_am->no_po;
				$this->db_kpp->query("UPDATE t_item_masuk
															SET no_po = '$no_po_am'
															WHERE id_pesanan_pembelian = '$id_pes_pem' ");
				echo "Data Sukses diUpdate";
			} else {
				$id = $this->input->post('no_po');

				$this->db_kpp->query("INSERT INTO item_masuk (id_item_masuk_detail, no_po, no_invoice, tanggal_invoice, kode_item, kode_gudang, jumlah_order, admin, keterangan, total_item_item_masuk, w_insert)
															SELECT id_item_masuk_detail, no_po, no_invoice, tanggal_invoice, kode_item, kode_gudang, jumlah_order, admin, keterangan, total_item_item_masuk, w_insert
															FROM t_item_masuk
															WHERE no_po='$id'");
				$this->db_kpp->query("INSERT INTO item_masuk_detail (no_po)
														 	VALUES ('$id')");
				$this->db_kpp->query("DELETE FROM t_item_masuk WHERE no_po='$id'");
				echo "Data Sukses diSimpan";
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function t_cari()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_t_item_masuk']	= $this->input->get('cari');
			if($this->model_item_masuk->t_ada($id)) {
				$dt = $this->model_item_masuk->t_get($id);
				$d['id_t_item_masuk']	= $dt->id_t_item_masuk;
				$d['id_pesanan_pembelian']	= $dt->id_pesanan_pembelian;
				$d['no_invoice']	= $dt->no_invoice;
				$d['tanggal_invoice']	= $dt->tanggal_invoice;
				$d['kode_item'] = $dt->kode_item;
				$d['jumlah_order']	= $dt->jumlah_order;
				$d['keterangan']	= $dt->keterangan;
				$d['kode_gudang'] = $dt->kode_gudang;
				$kode_gudang=$this->model_item_masuk->getKd_gudang($dt->kode_gudang);
				$data = $this->db_kpp->from('gudang')->get();
				if(count($kode_gudang)>0){
					foreach ($kode_gudang as $row) {
						$d['nama_gudang'] ='<option value="'.$row->kode_gudang.'">'.$row->nama_gudang.'</option>';
						$d['nama_gudang'] .='<option value="">--Pilih Nama Gudang--</option>';
						  foreach ($data->result() as $dt_gudang) {
								$d['nama_gudang'] .='<option value="'.$dt_gudang->kode_gudang.'">'.$dt_gudang->nama_gudang.'</option>';
							}
					}
				}
				$d['tambah_stok'] = $dt->total_item_item_masuk;
				$data = $this->db_kpp->from('item')->where('kode_item',$dt->kode_item)->get();
				$harga_item = 0;
				foreach($data->result() as $dt)
				{
					$d['nama_item'] = $dt->nama_item;
					$d['tipe'] = $dt->tipe;
				}
				echo json_encode($d);

			} else {
				$d['id_t_item_masuk']	= '';
				$d['id_pesanan_pembelian']	= '';
				$d['no_invoice']	= '';
				$d['tanggal_invoice']	= '';
				$d['kode_item'] = '';
				$d['nama_item'] = '';
				$d['harga_item'] = '';
				$d['jumlah_order']	= '';
				$d['keterangan']	= '';
				$d['kode_gudang']	= '';
				$d['tambah_stok']	= '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function edit() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id_item_masuk 		= $this->uri->segment(3);
			$getnoinvoice = $this->db_kpp->query("SELECT no_invoice FROM item_masuk WHERE id_item_masuk='$id_item_masuk'")->row();
			$no_invoice = $getnoinvoice->no_invoice;
			$d = array('judul' => 'Data Item Invoice Supplier',
						'class' 		=> 'pembelian',
						'id_item_masuk' => $id_item_masuk,
						'no_invoice' => $no_invoice,
						'tanggal'		=> date("Y-m-d"),
						'content'	=> 'invoice_supplier/edit',
						'data' => $this->db_kpp->query("SELECT omd.*, om.no_invoice, o.nama_item, o.harga_tebus_dpp, o.tipe, g.nama_gudang, p.diskon FROM item_masuk_detail omd
																						JOIN item o ON omd.kode_item=o.kode_item
																						JOIN gudang g ON omd.kode_gudang=g.kode_gudang
																						JOIN item_masuk om ON omd.id_item_masuk=om.id_item_masuk
																						JOIN pembelian p ON omd.id_pesanan_pembelian=p.id_pesanan_pembelian AND omd.kode_item=p.kode_item
																						WHERE omd.id_item_masuk='$id_item_masuk'")
						);
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function cari()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_item_masuk']	= $this->input->get('cari');
			if($this->model_item_masuk->ada_om($id)) {
				$dt = $this->model_item_masuk->get_om($id);

				$d['id_item_masuk']	= $dt->id_item_masuk;
				$d['no_po'] 	= $dt->no_po;
				$d['no_invoice'] 	= $dt->no_invoice;
				$d['tanggal_invoice']	= tgl_sql($dt->tanggal_invoice);
				$d['kode_item']=$dt->kode_item;
				$data = $this->db_kpp->from('item')->where('kode_item',$dt->kode_item)->get();
				foreach($data->result() as $dt)
				{
					$d['nama_item'] = $dt->nama_item;
					$d['tipe'] = $dt->tipe;
				}
				//$d['kode_gudang'] = $dt->kode_gudang;
				$kode_gudang=$this->model_item_masuk->getKd_gudang($dt->kode_gudang);
				$data = $this->db_kpp->from('gudang')->get();
				if(count($kode_gudang)>0){
					foreach ($kode_gudang as $row) {
						$d['nama_gudang'] ='<option value="'.$row->kode_gudang.'">'.$row->nama_gudang.'</option>';
						$d['nama_gudang'] .='<option value="">--Pilih Nama Gudang--</option>';
						  foreach ($data->result() as $dt_gudang) {
								$d['nama_gudang'] .='<option value="'.$dt_gudang->kode_gudang.'">'.$dt_gudang->nama_gudang.'</option>';
							}
					}
				}
				$d['keterangan'] = $dt->keterangan;
				$d['total_item_item_masuk'] = $dt->total_item_item_masuk;

				echo json_encode($d);
			} else {
				$d['id_item_masuk']		= '';
				$d['no_po']  	= '';
				$d['tanggal']  	= '';
				$d['kode_item']  	= '';
				$d['nama_item'] = '';
				$d['tipe'] = '';
				$d['kode_gudang'] = '';
				$d['nama_gudang'] = '';
				$d['keterangan'] 	= '';
				$d['total_item'] 	= '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function tambah() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id_item_masuk_detail = $this->model_item_masuk->cari_max_item_masuk_detail();
			$d = array('judul' 			=> 'Tambah Item Masuk',
						'class' 		=> 'persediaan',
						'id_item_masuk_detail' => $id_item_masuk_detail,
						'tanggal'=> date("Y-m-d"),
						'content' 		=> 'item_masuk/add',
						'data'		=>  $this->db_kpp->query("SELECT tom.*, o.nama_item, o.tipe, g.nama_gudang
																								FROM t_item_masuk tom
																								INNER JOIN item o
																								ON tom.kode_item=o.kode_item
																								LEFT JOIN gudang g
																								ON tom.kode_gudang=g.kode_gudang")
						);
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function search_kd_item()
	{
		$id=$this->input->get('id_pes');
		$list = $this->db_kpp->query("SELECT p.kode_item,o.nama_item,o.tipe,p.jumlah FROM pembelian p INNER JOIN item o ON p.kode_item=o.kode_item WHERE p.id_pesanan_pembelian='$id'");
		$row = array();
		$no = 1;
		foreach ($list->result() as $dt) {
				$row[] = array(
					'no'=>'<center>'.$no++.'</center>',
					'kode_item'=>$dt->kode_item,
					'nama_item'=>'<center>'.$dt->nama_item.'</center>',
					'tipe'=>'<center>'.$dt->tipe.'</center>',
					'jumlah'=>'<center>'.$dt->jumlah.'</center>'
				);

				$data= array('aaData'=>$row);
		}

		echo json_encode($data);
	}

	public function baru(){
		$id['id_t_item_masuk']=$this->input->post('id_new');
		if($this->model_item_masuk->t_ada_id_item_masuk($id)) {
			$this->db_kpp->delete("t_item_masuk",$id);
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
					$d['tipe'] = $dt->tipe;
				}
				echo json_encode($d);
			}else{
					$d['nama_item'] = '';
					$d['tipe'] = '';
				echo json_encode($d);
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function search_nm_gudang(){
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['kode_gudang']	= $this->input->post('kode_gudang');
			$q = $this->db_kpp->get_where('gudang',$id);
			$row = $q->num_rows();
			if($row>0){
				foreach($q->result() as $dt){
					$d['kode_gudang'] = $dt->kode_gudang;
				}
				echo json_encode($d);
			}else{
					$d['kode_gudang'] = '';
				echo json_encode($d);
			}
		}else{
			redirect('henkel','refresh');
		}
	}

public function cek(){
		$id=$this->input->post('id_pes');
		if($this->model_item_masuk->ada_item_masuk($id))
		{
			$this->db_kpp->empty_table('t_item_masuk');
			$id_t=$this->input->post('id_pes');
			$this->db_kpp->query("INSERT INTO t_item_masuk (id_pesanan_pembelian, kode_item, jumlah_order)
														SELECT id_pesanan_pembelian, kode_item, jumlah
														FROM pembelian
														WHERE id_pesanan_pembelian='$id_t'");
			echo "1";
		}else {
			$this->db_kpp->empty_table('t_item_masuk');
			echo "0";
		}
	}

	public function cek_table(){
		$id['id_pesanan_pembelian']=$this->input->post('id_cek');
		$q 	 = $this->db_kpp->get("t_item_masuk");
		$row = $q->num_rows();
		echo $row;
	}


	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_item_masuk']	= $this->uri->segment(3);

			if($this->model_item_masuk->ada($id))
			{
				$this->model_item_masuk->delete($id);
			}
			redirect('henkel_adm_item_masuk','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
