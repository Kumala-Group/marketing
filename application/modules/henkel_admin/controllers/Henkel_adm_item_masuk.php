<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_item_masuk extends CI_Controller {


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
			$d['judul']=" Data Item Masuk";
			$d['class'] = "pembelian";
			$d['data'] = $this->db_kpp->query("SELECT om.*, p.id_pesanan_pembelian, p.no_po, p.tanggal
																				 FROM item_masuk om
																				 INNER JOIN pesanan_pembelian p
																				 ON om.no_po = p.no_po");
			$d['content'] = 'item_masuk/view';
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function cek(){
		$id=$this->input->post('id_pes');
			if($this->model_item_masuk->ada_item_masuk($id)){
				$this->db_kpp->empty_table('t_item_masuk');
				$id_t=$this->input->post('id_pes');
				$this->db_kpp->query("INSERT INTO t_item_masuk (id_pesanan_pembelian, kode_item, jumlah_o, diskon, status_om)
															SELECT id_pesanan_pembelian, kode_item, jumlah_o, diskon, status_om
															FROM pembelian
															WHERE id_pesanan_pembelian='$id_t' AND status_om='0'");
				echo "1";
			}else {
				$this->db_kpp->empty_table('t_item_masuk');
				echo "0";
			}
		}

	public function simpan(){
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_item_masuk_detail'] = $this->input->post('id_item_masuk_detail');
			$dt['id_pesanan_pembelian'] = $this->input->post('id_pes_pem');
			$dt['kode_item'] = $this->input->post('kode_item');
			$dt['kode_gudang'] 	= $this->input->post('nama_gudang');
			$dt['keterangan'] = $this->input->post('keterangan');
			$dt['total_item_item_masuk'] = $this->input->post('tambah_stok');
			$dt['w_insert'] = $this->input->post('tanggal_input');
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

	public function simpan_edit(){
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_item_masuk'] = $this->input->post('id');
			$dt['admin'] = $this->session->userdata('nama_lengkap');
			if($this->model_item_masuk->ada_om($id)){
			  $dt['w_update'] = date('Y-m-d H:i:s');
				$this->model_item_masuk->update_om($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_item_masuk'] = $this->model_item_masuk->cari_max_item_masuk();
				$dt['w_insert'] = date('Y-m-d H:i:s');
				$this->model_item_masuk->insert_om($dt);
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
			$id['id_t_item_masuk'] 		= $this->input->post('id_t_item_masuk');
			$dt['id_item_masuk'] 		= $this->input->post('id_item_masuk');
			$dt['id_pesanan_pembelian'] 			= $this->input->post('id_pes_pem');
			$dt['kode_item'] 			= $this->input->post('kode_item');
			$dt['jumlah_o'] 			= $this->input->post('jumlah_order');
			$jumlah_order = $this->input->post('jumlah_order');
			$dt['kode_gudang'] 			= $this->input->post('nama_gudang');
			$dt['keterangan'] 			= $this->input->post('keterangan');
			$dt['total_item_item_masuk'] 			= $this->input->post('tambah_stok');
			$total_item_item_masuk 			= $this->input->post('tambah_stok');
			$dt['admin'] = $this->session->userdata('nama_lengkap');
			if($this->model_item_masuk->t_ada($id)){
				$id_pes_pem 		= $this->input->post('id_pes_pem');
				$kode_item 			= $this->input->post('kode_item');
				$this->model_item_masuk->t_update($id, $dt);
				$jumlah_o = $jumlah_order - $total_item_item_masuk;
				if ($jumlah_o==0) {
					  /*$this->db_kpp->query("UPDATE pembelian
																  SET status_om = '1', jumlah_o='$jumlah_o'
																  WHERE id_pesanan_pembelian='$id_pes_pem' AND kode_item='$kode_item'");*/
		        $this->db_kpp->query("UPDATE t_item_masuk
																	SET status_om = '1', jumlah_o='$jumlah_o'
																	WHERE id_pesanan_pembelian='$id_pes_pem' AND kode_item='$kode_item'");
				} else {
					/*$this->db_kpp->query("UPDATE pembelian
																SET jumlah_o='$jumlah_o'
																WHERE id_pesanan_pembelian='$id_pes_pem' AND kode_item='$kode_item'");*/
					$this->db_kpp->query("UPDATE t_item_masuk
																SET status_om = '0', jumlah_o='$jumlah_o'
																WHERE id_pesanan_pembelian='$id_pes_pem' AND kode_item='$kode_item'");
				}

				echo "Data Sukses diUpdate";
			} else {


				$id_item_masuk	= $this->input->post('id');
				$id_pes_pembelian 		= $this->input->post('id_hapus');
				$no_po = $this->input->post('no_po');
				$kode_supplier = $this->model_item_masuk->get_kode_supplier($no_po);
				$no_invoice = $this->input->post('no_invoice');
				$tanggal_invoice	= tgl_sql($this->input->post('tanggal_invoice'));
				$tanggal_item_masuk	= tgl_sql($this->input->post('tanggal_item_masuk'));
				$jt= $this->input->post('jt');
				$total_akhir = $this->input->post('total_akhir');
				$ppn = ($total_akhir * 10)/100;
				$total_akhir_ppn = $total_akhir+$ppn;
				$status_bayar = 'kredit';
				$w_insert =  date('Y-m-d H:i:s');
				$this->db_kpp->query("INSERT INTO item_masuk (tanggal_item_masuk, no_po, kode_supplier, no_invoice, tanggal_invoice, jt, total_akhir, total_akhir_o, status_bayar, w_insert)
														 	VALUES ('$tanggal_item_masuk', '$no_po', '$kode_supplier', '$no_invoice', '$tanggal_invoice', '$jt', '$total_akhir_ppn', '$total_akhir_ppn', '$status_bayar', '$w_insert')");
				$this->db_kpp->query("INSERT INTO item_masuk_detail (id_item_masuk, id_pesanan_pembelian, kode_item, diskon, kode_gudang, jumlah_order, admin, keterangan, total_item_item_masuk, w_insert)
															SELECT id_item_masuk, id_pesanan_pembelian, kode_item, diskon, kode_gudang, jumlah_o, admin, keterangan, total_item_item_masuk, w_insert
															FROM t_item_masuk
															WHERE id_item_masuk='$id_item_masuk'");
				$this->db_kpp->query("UPDATE pembelian p
									JOIN t_item_masuk tim ON
									p.kode_item = tim.kode_item
									SET p.status_om=tim.status_om, p.jumlah_o=tim.jumlah_o
									WHERE p.id_pesanan_pembelian='$id_pes_pembelian'");

				$this->db_kpp->query("DELETE FROM t_item_masuk");


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
				$d['kode_item'] = $dt->kode_item;
				$d['jumlah_order']	= $dt->jumlah_o;
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
			$dt 	= $this->model_item_masuk->get($id_item_masuk);
			$no_po	= $dt->no_po;
			$tanggal_po	= $this->model_item_masuk->cari_tgl_po($no_po);;
			$no_invoice	= $dt->no_invoice;
			$tanggal_invoice	= $dt->tanggal_invoice;
			$jt = $dt->jt;
			$tgl_jt = strtotime($tanggal_invoice);
			$date = date('Y-m-j', strtotime('+'.$jt.' day', $tgl_jt));
			$d = array('judul' 			=> 'Edit Item Masuk',
						'class' 		=> 'pembelian',
						'id_item_masuk'	=> $id_item_masuk,
						'no_po' 			=> $no_po,
						'tanggal_po' 			=> tgl_sql($tanggal_po),
						'no_invoice' 			=> $no_invoice,
						'tanggal_invoice' 			=> tgl_sql($tanggal_invoice),
						'jt' 			=> tgl_sql($date),
						'tanggal'		=> date("Y-m-d"),
						'content'	=> 'item_masuk/edit',
						'data' => $this->db_kpp->query("SELECT * FROM item_masuk_detail
																						JOIN item_masuk ON item_masuk_detail.id_item_masuk=item_masuk.id_item_masuk
																						JOIN item ON item_masuk_detail.kode_item=item.kode_item
																						JOIN gudang ON item_masuk_detail.kode_gudang=gudang.kode_gudang
																						WHERE item_masuk_detail.id_item_masuk='$id_item_masuk'")
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
			$id['id_item_masuk_detail']	= $this->input->get('cari');
			if($this->model_item_masuk->ada_omd($id)) {
				$dt = $this->model_item_masuk->get_omd($id);

				$d['id_item_masuk']	= $dt->id_item_masuk;
				$d['id_item_masuk_detail']	= $dt->id_item_masuk_detail;
				$d['id_pesanan_pembelian']	= $dt->id_pesanan_pembelian;
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
				$d['id_pesanan_pembelian']  	= '';
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
						'class' 		=> 'pembelian',
						'id_item_masuk_detail' => $id_item_masuk_detail,
						'tanggal'=> date("Y-m-d"),
						'content' 		=> 'item_masuk/add'
						);
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function tambah_invoice() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id_pes = base64_decode($this->uri->segment(3));
			$id_item_masuk = $this->model_item_masuk->cari_max_item_masuk();
			$no_po = $this->model_item_masuk->cari_no_po($id_pes);
			$d = array('judul' 			=> 'Tambah Item Masuk',
						'class' 		=> 'pembelian',
						'id_item_masuk' => $id_item_masuk,
						'id_pes_pem' => $id_pes,
						'no_po' => $no_po,
						'tanggal'=> date("Y-m-d"),
						'content' 		=> 'item_masuk/add_invoice',
						'data'		=>  $this->db_kpp->query("SELECT tom.*, o.nama_item, o.tipe, o.harga_tebus_dpp, g.nama_gudang
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
		$id=$this->input->post('id_new');
		if($this->model_item_masuk->t_ada_id_item_masuk($id)) {
			$this->db_kpp->query("DELETE FROM t_item_masuk
								  WHERE id_pesanan_pembelian='$id'");
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

	public function cek_table(){
		$id=$this->input->post('id_cek');
		$q 	 = $this->db_kpp->query("SELECT * FROM t_item_masuk WHERE id_item_masuk='$id'");
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

	public function t_hapus()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_t_item_masuk']	= $this->uri->segment(3);

			if($this->model_item_masuk->t_ada($id))
			{
				$this->model_item_masuk->t_delete($id);
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
