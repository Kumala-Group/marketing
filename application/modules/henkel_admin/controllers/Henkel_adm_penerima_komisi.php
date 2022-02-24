<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_penerima_komisi extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_penerima_komisi');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		$s='';
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Data Penerima Komisi";
			$d['class'] = "penjualan";
			$d['content'] = 'komisi_penjualan/penerima_komisi/add';
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function t_simpan_status_komisi()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_t_penerima_komisi_detail']= $this->input->post('id_t_penerima_komisi_detail');
			$dt['status_komisi'] 			= $this->input->post('status_komisi');
			$dt['status_target_penjualan'] 			= $this->input->post('status_target_penjualan');

			if($this->model_penerima_komisi->t_ada($id)){
				$this->model_penerima_komisi->t_update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_t_penerima_komisi'] 	= $this->model_penerima_komisi->cari_t_max_penerima_komisi();
				$this->model_penerima_komisi->t_insert($dt);
				echo "Data Sukses diSimpan";
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function simpan_penerima_komisi_sales_detail() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
				date_default_timezone_set('Asia/Makassar');
				$id= $this->input->post('id_penerima_komisi_sales');
				$this->db_kpp->query("INSERT INTO penerima_komisi_sales_detail (id_penerima_komisi_sales, nik, nama_karyawan, status_komisi, status_target_penjualan)
															SELECT id_penerima_komisi_sales, nik, nama_karyawan, status_komisi, status_target_penjualan
															FROM t_penerima_komisi_sales_detail
															WHERE id_penerima_komisi_sales='$id' AND status_komisi!=0 OR status_target_penjualan!=0");
				$this->db_kpp->query("DELETE FROM t_penerima_komisi_sales_detail WHERE id_penerima_komisi_sales='$id'");
				echo "Perhitungan Selesai";
		} else {
				redirect('henkel','refresh');
		}
	}

	public function simpan_penerima_komisi_kolektor_detail() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
				date_default_timezone_set('Asia/Makassar');
				$id= $this->input->post('id_penerima_komisi_kolektor');
				$this->db_kpp->query("INSERT INTO penerima_komisi_kolektor_detail (id_penerima_komisi_kolektor, nik, nama_karyawan, status_komisi)
															SELECT id_penerima_komisi_kolektor, nik, nama_karyawan, status_komisi
															FROM t_penerima_komisi_kolektor_detail
															WHERE id_penerima_komisi_kolektor='$id'");
				$this->db_kpp->query("DELETE FROM t_penerima_komisi_kolektor_detail WHERE id_penerima_komisi_kolektor='$id'");
				echo "Perhitungan Selesai";
		} else {
				redirect('henkel','refresh');
		}
	}

	public function simpan_penerima_komisi_admin_detail() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
				date_default_timezone_set('Asia/Makassar');
				$id= $this->input->post('id_penerima_komisi_admin');
				$this->db_kpp->query("INSERT INTO penerima_komisi_admin_detail (id_penerima_komisi_admin, nik, nama_karyawan, status_komisi, persentase1, persentase2)
															SELECT id_penerima_komisi_admin, nik, nama_karyawan, status_komisi, persentase1, persentase2
															FROM t_penerima_komisi_admin_detail
															WHERE id_penerima_komisi_admin='$id' AND status_komisi!=0 AND persentase1!=0 OR persentase2!=0");
				$this->db_kpp->query("DELETE FROM t_penerima_komisi_admin_detail WHERE id_penerima_komisi_admin='$id'");

				echo "Perhitungan Selesai";
		} else {
				redirect('henkel','refresh');
		}
	}

	public function hitung_insentif_sales()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){

			$id_penerima_komisi_sales = $this->uri->segment(3);
			$dt = $this->model_penerima_komisi->get_pks($id_penerima_komisi_sales);
			$d = array('judul' 			=> 'Tabel Penerima Komisi (Sales/Supervisor/Operational Manager) ',
						'class' 		=> 'penjualan',
						'id_penerima_komisi_sales'	=> $id_penerima_komisi_sales,
						'tgl_awal'	=> $dt->tgl_awal,
						'tgl_akhir'	=> $dt->tgl_akhir,
						'data' => $this->db_kpp->query("SELECT pksd.*
				                                    FROM penerima_komisi_sales_detail pksd
				                                 		JOIN penerima_komisi_sales pks ON pks.id_penerima_komisi_sales=pksd.id_penerima_komisi_sales
																						JOIN komisi_sales ks ON ks.id_komisi=pksd.status_komisi
				                                 		JOIN target_penjualan_detail tpd ON tpd.id_target_penjualan_detail=pksd.status_target_penjualan
				                                 		WHERE pksd.id_penerima_komisi_sales='$id_penerima_komisi_sales'
																						GROUP BY pksd.nama_karyawan"),
						'content'	=> 'komisi_penjualan/penerima_komisi/count_sales',
						);
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function hitung_insentif_kolektor()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){

			$id_penerima_komisi_kolektor = $this->uri->segment(3);
			$dt = $this->model_penerima_komisi->get_pkk($id_penerima_komisi_kolektor);
			$d = array('judul' 			=> 'Tabel Penerima Komisi (Kolektor) ',
						'class' 		=> 'penjualan',
						'id_penerima_komisi_kolektor'	=> $id_penerima_komisi_kolektor,
						'tgl_awal'	=> $dt->tgl_awal,
						'tgl_akhir'	=> $dt->tgl_akhir,
						'data' => $this->db_kpp->query("SELECT pkkd.*
				                                    FROM penerima_komisi_kolektor_detail pkkd
				                                 		JOIN penerima_komisi_kolektor pkk ON pkk.id_penerima_komisi_kolektor=pkkd.id_penerima_komisi_kolektor
				                                 		WHERE pkkd.id_penerima_komisi_kolektor='$id_penerima_komisi_kolektor'
																						GROUP BY pkkd.nama_karyawan"),
						'content'	=> 'komisi_penjualan/penerima_komisi/count_kolektor',
						);
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function hitung_insentif_admin()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){

			$id_penerima_komisi_admin = $this->uri->segment(3);
			$dt = $this->model_penerima_komisi->get_pka($id_penerima_komisi_admin);
			$tgl_awal = $dt->tgl_awal;
			$tgl_akhir = $dt->tgl_akhir;
			$d = array('judul' => 'Tabel Penerima Komisi (Admin/Gudang)',
						'class' => 'penjualan',
						'id_penerima_komisi_admin'	=> $id_penerima_komisi_admin,
						'tgl_awal'	=> $dt->tgl_awal,
						'tgl_akhir'	=> $dt->tgl_akhir,
						'data' => $this->db_kpp->query("SELECT pkad.*
				                                    FROM penerima_komisi_admin_detail pkad
				                                 		JOIN penerima_komisi_admin pka ON pka.id_penerima_komisi_admin=pkad.id_penerima_komisi_admin
																						JOIN komisi_admin ka ON ka.id_komisi=pkad.status_komisi
				                                 		WHERE pkad.id_penerima_komisi_admin='$id_penerima_komisi_admin'
																						GROUP BY pkad.nama_karyawan"),
						'content'	=> 'komisi_penjualan/penerima_komisi/count_admin',
						);
			$this->load->view('henkel_adm_home',$d);
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

	public function t_cari_penerima_komisi_admin_detail() {
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_t_penerima_komisi_admin_detail']	= $this->input->get('cari');
			if($this->model_penerima_komisi->t_ada_pkad($id)) {
				$dt = $this->model_penerima_komisi->t_get_pkad($id);
				$d['id_t_penerima_komisi_admin_detail']	= $dt->id_t_penerima_komisi_admin_detail;
				$d['status_komisi']	= $dt->status_komisi;
				$d['persentase1'] = $dt->persentase1;
				$d['persentase2'] = $dt->persentase2;
				echo json_encode($d);

			} else {
				$d['id_t_penerima_komisi_detail']	= '';
				$d['status_komisi']	= '';
				$d['persentase1'] = '';
				$d['persentase2'] = '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function t_cari_penerima_komisi_sales_detail() {
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_t_penerima_komisi_sales_detail']	= $this->input->get('cari');
			if($this->model_penerima_komisi->t_ada_pksd($id)) {
				$dt = $this->model_penerima_komisi->t_get_pksd($id);
				$d['id_t_penerima_komisi_sales_detail']	= $dt->id_t_penerima_komisi_sales_detail;
				$d['status_komisi']	= $dt->status_komisi;
				$d['status_target_penjualan'] = $dt->status_target_penjualan;
				echo json_encode($d);

			} else {
				$d['id_t_penerima_komisi_sales_detail']	= '';
				$d['status_komisi']	= '';
				$d['status_target_penjualan'] = '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function t_simpan_penerima_komisi_kolektor_detail()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_t_penerima_komisi_kolektor_detail']= $this->input->post('id_t_penerima_komisi_kolektor_detail');
			$dt['status_komisi'] 			= $this->input->post('status_komisi');

			if($this->model_penerima_komisi->t_ada_pkkd($id)){
				$this->model_penerima_komisi->t_update_pkkd($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_t_penerima_komisi_kolektor_detail'] 	= $this->model_penerima_komisi->cari_t_max_pkkd();
				$this->model_penerima_komisi->t_insert_pkkd($dt);
				echo "Data Sukses diSimpan";
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function t_simpan_penerima_komisi_admin_detail()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_t_penerima_komisi_admin_detail']= $this->input->post('id_t_penerima_komisi_admin_detail');
			$dt['status_komisi'] 			= $this->input->post('status_komisi');
			$dt['persentase1'] 			= $this->input->post('persentase1');
			$dt['persentase2'] 			= $this->input->post('persentase2');

			if($this->model_penerima_komisi->t_ada_pkad($id)){
				$this->model_penerima_komisi->t_update_pkad($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_t_penerima_komisi_admin_detail'] 	= $this->model_penerima_komisi->cari_t_max_pkad();
				$this->model_penerima_komisi->t_insert_pkad($dt);
				echo "Data Sukses diSimpan";
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function t_simpan_penerima_komisi_sales_detail()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_t_penerima_komisi_sales_detail']= $this->input->post('id_t_penerima_komisi_sales_detail');
			$dt['status_komisi'] 			= $this->input->post('status_komisi');
			$dt['status_target_penjualan'] 			= $this->input->post('status_target_penjualan');

			if($this->model_penerima_komisi->t_ada_pksd($id)){
				$this->model_penerima_komisi->t_update_pksd($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_t_penerima_komisi_sales_detail'] 	= $this->model_penerima_komisi->cari_t_max_pksd();
				$this->model_penerima_komisi->t_insert_pksd($dt);
				echo "Data Sukses diSimpan";
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function komisi_sales() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		$get_max_penerima_komisi_sales=$this->model_penerima_komisi->cari_max_penerima_komisi_sales();
		$id_penerima_komisi_sales=$get_max_penerima_komisi_sales-1;
		if(!empty($cek) && $level=='henkel_admin'){
			$d = array('judul' 			=> 'Tambah Penerima Komisi',
						'class' 		=> 'penjualan',
						'content' 		=> 'komisi_penjualan/penerima_komisi/add_sales',
						'id_penerima_komisi_sales' 		=> $id_penerima_komisi_sales,
						'data'		=>  $this->model_penerima_komisi->all_sales(),
						);
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function komisi_kolektor() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		$get_max_penerima_komisi_kolektor=$this->model_penerima_komisi->cari_max_penerima_komisi_kolektor();
		$id_penerima_komisi_kolektor=$get_max_penerima_komisi_kolektor-1;
		if(!empty($cek) && $level=='henkel_admin'){
			$d = array('judul' 			=> 'Tambah Penerima Komisi',
						'class' 		=> 'penjualan',
						'content' 		=> 'komisi_penjualan/penerima_komisi/add_kolektor',
						'id_penerima_komisi_kolektor' 		=> $id_penerima_komisi_kolektor,
						'data_kolektor'		=>  $this->model_penerima_komisi->all_kolektor(),
						'data_piutang_exception'		=>  $this->model_penerima_komisi->all_piutang_exception(),
						);
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function komisi_admin() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		$get_max_penerima_komisi_admin=$this->model_penerima_komisi->cari_max_penerima_komisi_admin();
		$id_penerima_komisi_admin=$get_max_penerima_komisi_admin-1;
		if(!empty($cek) && $level=='henkel_admin'){
			$d = array('judul' 			=> 'Tambah Penerima Komisi',
						'class' 		=> 'penjualan',
						'content' 		=> 'komisi_penjualan/penerima_komisi/add_admin',
						'id_penerima_komisi_admin' 		=> $id_penerima_komisi_admin,
						'data'		=>  $this->model_penerima_komisi->all_admin(),
						);
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function proses_sales(){
		$tanggal_awal=$this->input->post('tanggal_awal');
		$tanggal_akhir=$this->input->post('tanggal_akhir');
		$tgl_awaldb = $this->db_kpp->query("SELECT tgl_awal
																        FROM penerima_komisi_sales
																				ORDER BY tgl_awal ASC
																				LIMIT 1")->row();
		$tgl_akhirdb = $this->db_kpp->query("SELECT tgl_akhir
																				 FROM penerima_komisi_sales
																				 ORDER BY tgl_akhir DESC
																				 LIMIT 1")->row();
		if (strtotime($tanggal_awal)>=strtotime($tgl_awaldb->tgl_awal) && strtotime($tanggal_akhir)<=strtotime($tgl_akhirdb->tgl_akhir)) {
			echo "1";
		} else {
		$id_perusahaan=$this->input->post('id_perusahaan');
		$id_penerima_komisi_sales=$this->model_penerima_komisi->cari_max_penerima_komisi_sales();
		$this->db_kpp->empty_table('t_penerima_komisi_sales_detail');
		$this->db_kpp->query("INSERT INTO t_penerima_komisi_sales_detail (nik, nama_karyawan)
 												 	SELECT jk.nik, jk.nama_karyawan
 												 	FROM jabatan_karyawan jk
 												 	WHERE jk.jabatan_karyawan='1'");
		$this->db_kpp->query("UPDATE t_penerima_komisi_sales_detail
													SET id_penerima_komisi_sales = '$id_penerima_komisi_sales'
												 ");
    $this->db_kpp->query("INSERT INTO penerima_komisi_sales (tgl_awal, tgl_akhir)
		                      VALUES ('$tanggal_awal','$tanggal_akhir')");
		 echo "2";
	  }
	}

	public function proses_kolektor(){
		$tanggal_awal=$this->input->post('tanggal_awal');
		$tanggal_akhir=$this->input->post('tanggal_akhir');
		$tgl_awaldb = $this->db_kpp->query("SELECT tgl_awal
																        FROM penerima_komisi_kolektor
																				ORDER BY tgl_awal ASC
																				LIMIT 1")->row();
		$tgl_akhirdb = $this->db_kpp->query("SELECT tgl_akhir
																				 FROM penerima_komisi_kolektor
																				 ORDER BY tgl_akhir DESC
																				 LIMIT 1")->row();
		if (strtotime($tanggal_awal)>=strtotime($tgl_awaldb->tgl_awal) && strtotime($tanggal_akhir)<=strtotime($tgl_akhirdb->tgl_akhir)) {
			echo "1";
		} else {
			$id_penerima_komisi_kolektor=$this->model_penerima_komisi->cari_max_penerima_komisi_kolektor();
			$this->db_kpp->empty_table('t_penerima_komisi_kolektor_detail');
			$this->db_kpp->query("INSERT INTO t_penerima_komisi_kolektor_detail (nik, nama_karyawan)
	 												 	SELECT jk.nik, jk.nama_karyawan
	 												 	FROM jabatan_karyawan jk
	 												 	WHERE jk.jabatan_karyawan='3'");
		  $this->db_kpp->query("INSERT INTO piutang_exception (id_piutang_exception,no_transaksi,tgl,total_akhir,sisa_o)
														SELECT id_pesanan_penjualan, no_transaksi, tgl, total_akhir, sisa_o
														FROM pesanan_penjualan
														ON DUPLICATE KEY UPDATE id_piutang_exception=pesanan_penjualan.id_pesanan_penjualan");
			$this->db_kpp->query("UPDATE t_penerima_komisi_kolektor_detail
														SET id_penerima_komisi_kolektor = '$id_penerima_komisi_kolektor'
													 ");
	    $this->db_kpp->query("INSERT INTO penerima_komisi_kolektor (tgl_awal, tgl_akhir)
			                      VALUES ('$tanggal_awal','$tanggal_akhir')");
		  echo "2";
	  }
	}

	public function proses_admin(){
		$id_perusahaan=$this->input->post('id_perusahaan');
		$tanggal_awal=$this->input->post('tanggal_awal');
		$tanggal_akhir=$this->input->post('tanggal_akhir');
		$tgl_awaldb = $this->db_kpp->query("SELECT tgl_awal
																        FROM penerima_komisi_admin
																				ORDER BY tgl_awal ASC
																				LIMIT 1")->row();
		$tgl_akhirdb = $this->db_kpp->query("SELECT tgl_akhir
																				 FROM penerima_komisi_admin
																				 ORDER BY tgl_akhir DESC
																				 LIMIT 1")->row();
	  if (strtotime($tanggal_awal)>=strtotime($tgl_awaldb->tgl_awal) && strtotime($tanggal_akhir)<=strtotime($tgl_akhirdb->tgl_akhir)) {
		echo "1";
		} else {
		$id_penerima_komisi_admin=$this->model_penerima_komisi->cari_max_penerima_komisi_admin();
		$this->db_kpp->empty_table('t_penerima_komisi_admin_detail');
		$this->db_kpp->query("INSERT INTO t_penerima_komisi_admin_detail (nik, nama_karyawan)
 												 	SELECT jk.nik, jk.nama_karyawan
 												 	FROM jabatan_karyawan jk
													WHERE jk.jabatan_karyawan='2'");
		$this->db_kpp->query("UPDATE t_penerima_komisi_admin_detail
													SET id_penerima_komisi_admin = '$id_penerima_komisi_admin'
													");
    $this->db_kpp->query("INSERT INTO penerima_komisi_admin (tgl_awal, tgl_akhir)
		                      VALUES ('$tanggal_awal','$tanggal_akhir')");
		echo "2";
	}
}

	public function cek_table(){
		$id['id_komisi']=$this->input->post('id_cek');
		$q 	 = $this->db_kpp->get_where("t_komisi",$id);
		$row = $q->num_rows();
		echo $row;
	}

	public function cek_table_k(){
		$id['id_komisi']=$this->input->post('id_cek');
		$q 	 = $this->db_kpp->get_where("komisi_detail",$id);
		$row = $q->num_rows();
		echo $row;
	}

	public function cari_info_piutang_exception() {
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_piutang_exception']	= $this->input->get('cari');
			if($this->model_penerima_komisi->ada_pe($id)) {
				$dt = $this->model_penerima_komisi->get_pe($id);
				$d['id_piutang_exception']	= $dt->id_piutang_exception;
				$d['tgl_bayar']	= $dt->tgl_bayar;
				$d['bayar']	= $dt->bayar;
				$d['keterangan'] = $dt->keterangan;
				echo json_encode($d);

			} else {
				$d['id_piutang_exception']	= '';
				$d['tgl_bayar'] = '';
				$d['bayar']	= '';
				$d['keterangan'] = '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function simpan_info_piutang_exception()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_piutang_exception']= $this->input->post('id_piutang_exception');
			$dt['bayar'] 			= $this->input->post('bayar');
			$dt['keterangan'] 			= $this->input->post('keterangan');
			$dt['tgl_bayar'] 			= tgl_sql($this->input->post('tanggal_bayar'));

			if($this->model_penerima_komisi->ada_pe($id)){
				$this->model_penerima_komisi->update_pe($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_piutang_exception'] 	= $this->model_penerima_komisi->cari_max_piutang_exception();
				$this->model_penerima_komisi->insert_pe($dt);
				echo "Data Sukses diSimpan";
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
			$id['id_program_penjualan']	= $this->uri->segment(3);

			if($this->model_program_penjualan->ada($id))
			{
				$this->model_program_penjualan->delete($id);
			}
			redirect('henkel_adm_program_penjualan','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
