<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_hitungan_komisi extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_hitungan_komisi');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Data Hitungan Komisi";
			$d['class'] = "penjualan";
			$d['data'] = $this->model_hitungan_komisi->all();
			$d['content'] = 'komisi_penjualan/hitungan_komisi/view';
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
			$id['id_komisi']= $this->input->post('id');
			$dt['kode_komisi'] 			= $this->input->post('kode_komisi');
			$dt['nama_komisi'] 			= $this->input->post('nama_komisi');

			if($this->model_hitungan_komisi->ada($id)){
				$this->model_hitungan_komisi->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_komisi'] 	= $this->model_hitungan_komisi->cari_max_komisi();
				$id_komisi = $this->model_hitungan_komisi->cari_max_komisi();
				$cek_table_admin = $this->model_hitungan_komisi->cek_table_t_admin();
				$cek_table_spv = $this->model_hitungan_komisi->cek_table_t_spv();
				$cek_table_sales = $this->model_hitungan_komisi->cek_table_t_sales();
				if ($cek_table_sales>0) {
					$this->db_kpp->query("INSERT INTO komisi_sales (id_komisi, target_capai, target_tidakcapai, range_hari_awal, range_hari_akhir)
																SELECT id_komisi, target_capai, target_tidakcapai, range_hari_awal, range_hari_akhir
																FROM t_komisi_sales
																WHERE id_komisi='$id_komisi'");
					$this->db_kpp->query("DELETE FROM t_komisi_sales WHERE id_komisi='$id_komisi'");
					$this->model_hitungan_komisi->insert($dt);
					echo "Data Sukses diSimpan";
				} elseif ($cek_table_spv>0) {
					$this->db_kpp->query("INSERT INTO komisi_spv (id_komisi, range_hari_awal, range_hari_akhir, retail, toko)
																SELECT id_komisi, range_hari_awal, range_hari_akhir, retail, toko
																FROM t_komisi_spv
																WHERE id_komisi='$id_komisi'");
					$this->db_kpp->query("DELETE FROM t_komisi_spv WHERE id_komisi='$id_komisi'");
					$this->model_hitungan_komisi->insert($dt);
					echo "Data Sukses diSimpan";
				} elseif ($cek_table_admin>0) {
					$this->db_kpp->query("INSERT INTO komisi_admin (id_komisi, id_satuan, insentif_pcs)
																SELECT id_komisi, id_satuan, insentif_pcs
																FROM t_komisi_admin
																WHERE id_komisi='$id_komisi'");
					$this->db_kpp->query("DELETE FROM t_komisi_admin WHERE id_komisi='$id_komisi'");
					$this->model_hitungan_komisi->insert($dt);
					echo "Data Sukses diSimpan";
				}
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function simpan_edit()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_komisi']= $this->input->post('id');
			$dt['kode_komisi'] 	= $this->input->post('kode_komisi');
			$dt['nama_komisi'] 	= $this->input->post('nama_komisi');

			if($this->model_hitungan_komisi->ada($id)){
				$this->model_hitungan_komisi->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_komisi'] 	= $this->model_hitungan_komisi->cari_max_komisi();
				$this->model_hitungan_komisi->insert($dt);
				echo "Data Sukses diSimpan";
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function t_simpan_sales()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_t_komisi_sales']= $this->input->post('id_form_sales_t_komisi');
			$dt['id_komisi']= $this->model_hitungan_komisi->cari_max_komisi();
      $dt['target_capai'] 			= $this->input->post('target_capai');
			$dt['target_tidakcapai'] 			= $this->input->post('target_tidakcapai');
			$dt['range_hari_awal'] 			= $this->input->post('range_hari_awal');
      $dt['range_hari_akhir'] 			= $this->input->post('range_hari_akhir');

			if($this->model_hitungan_komisi->t_ada_sales($id)){
				$this->model_hitungan_komisi->t_update_sales($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_t_komisi_sales'] 	= $this->model_hitungan_komisi->cari_t_max_komisi_sales();
				$this->model_hitungan_komisi->t_insert_sales($dt);
				echo "Data Sukses diSimpan";
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function t_simpan_spv()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_t_komisi_spv']= $this->input->post('id_form_spv_t_komisi');
			$dt['id_komisi']= $this->model_hitungan_komisi->cari_max_komisi();
			$dt['range_hari_awal'] 			= $this->input->post('range_hari_awal_spv');
      $dt['range_hari_akhir'] 			= $this->input->post('range_hari_akhir_spv');
			$dt['retail'] 			= $this->input->post('retail_persen');
			$dt['toko'] 			= $this->input->post('toko_persen');

			if($this->model_hitungan_komisi->t_ada_spv($id)){
				$this->model_hitungan_komisi->t_update_spv($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_t_komisi_spv'] 	= $this->model_hitungan_komisi->cari_t_max_komisi_spv();
				$this->model_hitungan_komisi->t_insert_spv($dt);
				echo "Data Sukses diSimpan";
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function t_simpan_admin()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_t_komisi_admin']= $this->input->post('id_form_admin_t_komisi');
			$dt['id_komisi']= $this->model_hitungan_komisi->cari_max_komisi();
			$dt['id_satuan'] 			= $this->input->post('satuan');
      $dt['insentif_pcs'] 			= $this->input->post('insentif_pcs');

			if($this->model_hitungan_komisi->t_ada_admin($id)){
				$this->model_hitungan_komisi->t_update_admin($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_t_komisi_admin'] 	= $this->model_hitungan_komisi->cari_t_max_komisi_admin();
				$this->model_hitungan_komisi->t_insert_admin($dt);
				echo "Data Sukses diSimpan";
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function baru(){
		$id['id_t_program_penjualan']=$this->input->post('id_new');
		if($this->model_program_penjualan->t_ada_program_penjualan($id))
		{
			$this->db_kpp->delete("t_program_penjualan",$id);
		}
	}

	public function cari()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_komisi_detail']	= $this->input->get('cari');
			if($this->model_komisi->ada($id)) {
				$dt = $this->model_komisi->get($id);
				$d['id_komisi_detail']	= $dt->id_komisi_detail;
				$d['id_komisi']	= $dt->id_komisi;
				$d['range_hari_awal'] = $dt->range_hari_awal;
				$d['range_hari_akhir'] = $dt->range_hari_akhir;
				$d['aktor']	= $dt->aktor;
				$d['target'] = $dt->target;
				echo json_encode($d);

			} else {
				$d['id_komisi_detail']	= '';
				$d['id_komisi']	= '';
				$d['range_hari_awal'] = '';
				$d['range_hari_akhir'] = '';
				$d['aktor'] = '';
				$d['target']	= '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function create_kd()
	{
		$tanggal = date("y-m");
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$last_kd = $this->model_hitungan_komisi->last_kode();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = 'KOM-'.sprintf("%03s", $no_akhir);
			}else{
				$kd = 'KOM-'.'001';
			}
			return $kd;
		}else{
			redirect('henkel','refresh');
		}

	}

	public function tambah() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id_komisi = $this->model_hitungan_komisi->cari_max_komisi();
			$id_komisi_sales = $this->model_hitungan_komisi->cari_max_komisi_sales();
			$id_komisi_spv = $this->model_hitungan_komisi->cari_max_komisi_spv();
			$id_komisi_admin = $this->model_hitungan_komisi->cari_max_komisi_admin();
			$d = array('judul' 			=> 'Tambah Hitungan Komisi',
						'class' 		=> 'penjualan',
						'id_komisi'=> $id_komisi,
						'id_komisi_sales'=> $id_komisi_sales,
						'id_komisi_spv'=> $id_komisi_spv,
						'id_komisi_admin'=> $id_komisi_admin,
						'kode_komisi'	=> $this->create_kd(),
						'content' 		=> 'komisi_penjualan/hitungan_komisi/add',
						'data_sales' => $this->model_hitungan_komisi->all_sales(),
						'data_spv' => $this->model_hitungan_komisi->all_spv(),
            'data_admin' => $this->model_hitungan_komisi->all_admin(),
						);
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function edit()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){

			$id_komisi 		= $this->uri->segment(3);
			$dt 	= $this->model_hitungan_komisi->komisi_detail($id_komisi);
			$id_komisi_sales = $this->model_hitungan_komisi->cari_max_komisi_sales();
			$id_komisi_admin = $this->model_hitungan_komisi->cari_max_komisi_admin();
			$kode_komisi	= $dt->kode_komisi;
			$nama_komisi  = $dt->nama_komisi;
			$d = array('judul' 			=> 'Edit Hitungan Komisi',
						'class' 		=> 'penjualan',
						'id_komisi'	=> $id_komisi,
						'kode_komisi' 			=> $kode_komisi,
						'nama_komisi'	=> $nama_komisi,
						'id_komisi_sales'	=> $id_komisi_sales,
						'id_komisi_admin'	=> $id_komisi_admin,
						'content'	=> 'komisi_penjualan/hitungan_komisi/edit',
						'data_sales' => $this->db_kpp->query("SELECT k.*,ks.*
																						FROM komisi k
																						JOIN komisi_sales ks ON k.id_komisi=ks.id_komisi
																						WHERE k.id_komisi='$id_komisi'"),
						'data_spv' => $this->db_kpp->query("SELECT k.*,ks.*
						  	 																	FROM komisi k
							 																		JOIN komisi_spv ks ON k.id_komisi=ks.id_komisi
																									WHERE k.id_komisi='$id_komisi'"),
						'data_admin' => $this->db_kpp->query("SELECT k.*,ka.*
																						FROM komisi k
																						JOIN komisi_admin ka ON k.id_komisi=ka.id_komisi
																						WHERE k.id_komisi='$id_komisi'"),
						);
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function cek_table(){
		$id['id_komisi']=$this->input->post('id');
		$q_sales 	 = $this->db_kpp->get_where("t_komisi_sales",$id);
		$q_spv 	 = $this->db_kpp->get_where("t_komisi_spv",$id);
		$q_admin 	 = $this->db_kpp->get_where("t_komisi_admin",$id);
		$row_sales = $q_sales->num_rows();
		$row_spv = $q_spv->num_rows();
		$row_admin = $q_admin->num_rows();
		echo $row_sales+$row_admin+$row_spv;
	}

	public function cek_table_edit(){
		$id['id_komisi']=$this->input->post('id');
		$q_sales 	 = $this->db_kpp->get_where("komisi_sales",$id);
		$q_admin 	 = $this->db_kpp->get_where("komisi_admin",$id);
		$row_sales = $q_sales->num_rows();
		$row_admin = $q_admin->num_rows();
		echo $row_sales+$row_admin;
	}

	public function cari_sales()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_komisi_sales']	= $this->input->get('cari');
			if($this->model_hitungan_komisi->ada_sales($id)) {
				$dt = $this->model_hitungan_komisi->get_sales($id);
				$d['id_komisi']	= $dt->id_komisi;
				$d['id_komisi_sales']	= $dt->id_komisi_sales;
				$d['range_hari_awal'] = $dt->range_hari_awal;
				$d['range_hari_akhir'] = $dt->range_hari_akhir;
				$d['target_capai'] = $dt->target_capai;
				$d['target_tidakcapai'] = $dt->target_tidakcapai;
				echo json_encode($d);

			} else {
				$d['id_komisi']	= '';
				$d['id_komisi_sales']	= '';
				$d['id_t_komisi_sales']	= '';
				$d['range_hari_awal'] = '';
				$d['range_hari_akhir'] = '';
				$d['target_capai']	= '';
				$d['target_tidakcapai']	= '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function t_cari_sales()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_t_komisi_sales']	= $this->input->get('cari');
			if($this->model_hitungan_komisi->t_ada_sales($id)) {
				$dt = $this->model_hitungan_komisi->t_get_sales($id);
				$d['id_komisi']	= $dt->id_komisi;
				$d['id_komisi_sales']	= $dt->id_komisi_sales;
				$d['id_t_komisi_sales']	= $dt->id_t_komisi_sales;
				$d['range_hari_awal'] = $dt->range_hari_awal;
				$d['range_hari_akhir'] = $dt->range_hari_akhir;
				$d['target_capai'] = $dt->target_capai;
				$d['target_tidakcapai'] = $dt->target_tidakcapai;
				echo json_encode($d);

			} else {
				$d['id_komisi']	= '';
				$d['id_komisi_sales']	= '';
				$d['id_t_komisi_sales']	= '';
				$d['range_hari_awal'] = '';
				$d['range_hari_akhir'] = '';
				$d['target_capai']	= '';
				$d['target_tidakcapai']	= '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function cari_spv()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_komisi_spv']	= $this->input->get('cari');
			if($this->model_hitungan_komisi->ada_spv($id)) {
				$dt = $this->model_hitungan_komisi->get_spv($id);
				$d['id_komisi']	= $dt->id_komisi;
				$d['id_komisi_spv']	= $dt->id_komisi_spv;
				$d['range_hari_awal'] = $dt->range_hari_awal;
				$d['range_hari_akhir'] = $dt->range_hari_akhir;
				$d['retail'] = $dt->retail;
				$d['toko'] = $dt->toko;
				echo json_encode($d);

			} else {
				$d['id_komisi']	= '';
				$d['id_komisi_spv']	= '';
				$d['id_t_komisi_spv']	= '';
				$d['range_hari_awal'] = '';
				$d['range_hari_akhir'] = '';
				$d['retail'] = '';
				$d['toko'] = '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function cari_admin()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_komisi_admin']	= $this->input->get('cari');
			if($this->model_hitungan_komisi->ada_admin($id)) {
				$dt = $this->model_hitungan_komisi->get_admin($id);
				$d['id_komisi']	= $dt->id_komisi;
				$d['id_komisi_admin']	= $dt->id_komisi_admin;
				$id_satuan=$this->model_hitungan_komisi->getKd_satuan($dt->id_satuan);
				$data_satuan = $this->db_kpp->from('satuan')->get();
				if(count($id_satuan)>0){
					foreach ($id_satuan as $row) {
						$d['satuan'] ='<option value="'.$row->id_satuan.'">'.$row->satuan.'</option>';
						$d['satuan'] .='<option value="">--Pilih Nama Gudang--</option>';
						  foreach ($data_satuan->result() as $dt_satuan) {
								$d['satuan'] .='<option value="'.$dt_satuan->id_satuan.'">'.$dt_satuan->satuan.'</option>';
							}
					}
				}
				$d['insentif_pcs'] = $dt->insentif_pcs;
				echo json_encode($d);

			} else {
				$d['id_komisi']	= '';
				$d['id_komisi_admin']	= '';
				$d['id_t_komisi_admin']	= '';
				$d['satuan'] = '';
				$d['insentif_pcs'] = '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function t_cari_admin()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_t_komisi_admin']	= $this->input->get('cari');
			if($this->model_hitungan_komisi->t_ada_admin($id)) {
				$dt = $this->model_hitungan_komisi->t_get_admin($id);
				$d['id_komisi']	= $dt->id_komisi;
				$d['id_komisi_admin']	= $dt->id_komisi_admin;
				$d['id_t_komisi_admin']	= $dt->id_t_komisi_admin;
				$id_satuan=$this->model_hitungan_komisi->getKd_satuan($dt->id_satuan);
				$data_satuan = $this->db_kpp->from('satuan')->get();
				if(count($id_satuan)>0){
					foreach ($id_satuan as $row) {
						$d['satuan'] ='<option value="'.$row->id_satuan.'">'.$row->satuan.'</option>';
						$d['satuan'] .='<option value="">--Pilih Nama Gudang--</option>';
						  foreach ($data_satuan->result() as $dt_satuan) {
								$d['satuan'] .='<option value="'.$dt_satuan->id_satuan.'">'.$dt_satuan->satuan.'</option>';
							}
					}
				}
				$d['insentif_pcs'] = $dt->insentif_pcs;
				echo json_encode($d);

			} else {
				$d['id_komisi']	= '';
				$d['id_komisi_admin']	= '';
				$d['id_t_komisi_admin']	= '';
				$d['satuan'] = '';
				$d['insentif_pcs'] = '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function hapus_sales()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_komisi_sales']	= $this->uri->segment(3);
			$id_komisi_sales = $this->uri->segment(3);

			if($this->model_hitungan_komisi->ada_sales($id))
			{
				$this->model_hitungan_komisi->delete_sales($id);
			}
		}
		else
		{
			redirect('henkel','refresh');
		}
	}

	public function hapus_spv()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='item_spv'){
			$id['id_komisi_spv']	= $this->uri->segment(3);
			$id_komisi_spv = $this->uri->segment(3);

			if($this->model_hitungan_komisi->ada_spv($id))
			{
				$this->model_hitungan_komisi->delete_spv($id);
			}
		}
		else
		{
			redirect('henkel','refresh');
		}
	}

	public function hapus_admin()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_komisi_admin']	= $this->uri->segment(3);
			$id_komisi_admin = $this->uri->segment(3);

			if($this->model_hitungan_komisi->ada_admin($id))
			{
				$this->model_hitungan_komisi->delete_admin($id);
			}
		}
		else
		{
			redirect('henkel','refresh');
		}
	}

	public function t_hapus_sales()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_t_komisi_sales']	= $this->uri->segment(3);

			if($this->model_hitungan_komisi->t_ada_sales($id))
			{
				$this->model_hitungan_komisi->t_delete_sales($id);
			}
			redirect('henkel_adm_hitungan_komisi/tambah','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}
	}

	public function t_hapus_spv()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_t_komisi_spv']	= $this->uri->segment(3);

			if($this->model_hitungan_komisi->t_ada_spv($id))
			{
				$this->model_hitungan_komisi->t_delete_spv($id);
			}
			redirect('henkel_adm_hitungan_komisi/tambah','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}
	}

	public function t_hapus_admin()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_t_komisi_admin']	= $this->uri->segment(3);

			if($this->model_hitungan_komisi->t_ada_admin($id))
			{
				$this->model_hitungan_komisi->t_delete_admin($id);
			}
			redirect('henkel_adm_hitungan_komisi/tambah','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}
	}




}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
