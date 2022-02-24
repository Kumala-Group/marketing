<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_komisi extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_komisi');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Data Komisi";
			$d['class'] = "pustaka";
			$d['data'] = $this->model_komisi->all();
			$d['content'] = 'komisi/view';
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
			$id['id_komisi_detail']= $this->input->post('id_komisi_detail');
			$dt['id_komisi'] = $this->input->post('id_komisi');
			$dt['aktor'] 	= $this->input->post('penerima_komisi');
      $dt['target'] = $this->input->post('target_komisi');
			$dt['range_hari_awal'] 	= $this->input->post('range_hari_awal');
      $dt['range_hari_akhir'] = $this->input->post('range_hari_akhir');

			if($this->model_komisi->ada($id)){
				$this->model_komisi->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_komisi_detail'] 	= $this->model_komisi->cari_max_komisi_detail();
				$this->model_komisi->insert($dt);
				echo "Data Sukses diSimpan";
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function simpan_detail()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_komisi_detail']= $this->input->post('id_komisi_detail');
			$dt['id_komisi']= $this->input->post('id_komisi');
			$dt['aktor'] 			= $this->input->post('penerima_komisi');
      $dt['target'] 			= $this->input->post('target_komisi');
			$dt['range_hari_awal'] 			= $this->input->post('range_hari_awal');
      $dt['range_hari_akhir'] 			= $this->input->post('range_hari_akhir');

			if($this->model_komisi->ada_detail($id)){
				$this->model_komisi->update_detail($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_komisi_detail'] 	= $this->model_komisi->cari_max_komisi_detail();
				$this->model_komisi->insert_detail($dt);
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
			$id['id_t_komisi']= $this->input->post('id_t_komisi');
			$dt['id_komisi']= $this->model_komisi->cari_max_komisi();
			$dt['aktor'] 			= $this->input->post('penerima_komisi');
      $dt['target'] 			= $this->input->post('target_komisi');
			$dt['range_hari_awal'] 			= $this->input->post('range_hari_awal');
      $dt['range_hari_akhir'] 			= $this->input->post('range_hari_akhir');

			if($this->model_komisi->t_ada($id)){
				$this->model_komisi->t_update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_t_komisi'] 	= $this->model_komisi->cari_t_max_komisi();
				$this->model_komisi->t_insert($dt);
				echo "Data Sukses diSimpan";
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function simpan_k()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_komisi']= $this->input->post('id');
			$dt['kode_komisi'] 			= $this->input->post('kode_komisi');
			$dt['nama_komisi'] 			= $this->input->post('nama_skema');

			if($this->model_komisi->ada($id)){
				$this->model_komisi->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_komisi'] 	= $this->model_komisi->cari_max_komisi();
				$this->model_komisi->insert($dt);
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
			$last_kd = $this->model_komisi->last_kode();
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
			$id_komisi = $this->model_komisi->cari_max_komisi();
			$id = $this->model_komisi->cari_max_komisi();
			$d = array('judul' 			=> 'Tambah Komisi',
						'class' 		=> 'pustaka',
						'id_komisi'=> $id_komisi,
						'kode_komisi'	=> $this->create_kd(),
						'content' 		=> 'komisi/add',
						'data'		=>  $this->db_kpp->query("SELECT tk.*
																								FROM t_komisi tk
																								WHERE tk.id_komisi='$id'")
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
			$dt 	= $this->model_komisi->get_detail($id_komisi);
			$kode_komisi	= $dt->kode_komisi;
			$nama_skema  = $dt->nama_komisi;
			$d = array('judul' 			=> 'Edit Program Penjualan ',
						'class' 		=> 'pustaka',
						'id_komisi'	=> $id_komisi,
						'kode_komisi' 			=> $kode_komisi,
						'nama_skema'	=> $nama_skema,
						'content'	=> 'komisi/edit',
						'data' => $this->db_kpp->query("SELECT k.*, kd.*
																						FROM komisi k
																						JOIN komisi_detail kd ON k.id_komisi=kd.id_komisi
																						WHERE kd.id_komisi='$id_komisi'")
						);
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
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

	public function t_cari()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_t_komisi']	= $this->input->get('cari');
			if($this->model_komisi->t_ada($id)) {
				$dt = $this->model_komisi->t_get($id);
				$d['id_t_komisi']	= $dt->id_t_komisi;
				$d['id_komisi']	= $dt->id_komisi;
				$d['range_hari_awal'] = $dt->range_hari_awal;
				$d['range_hari_akhir'] = $dt->range_hari_akhir;
				$d['aktor']	= $dt->aktor;
				$d['target'] = $dt->target;
				echo json_encode($d);

			} else {
				$d['id_t_komisi']	= '';
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

	public function cari_detail()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_komisi_detail']	= $this->input->get('cari');
			if($this->model_komisi->ada_detail($id)) {
				$dt = $this->model_komisi->get_detail_komisi($id);
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

	public function t_hapus()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_t_komisi']	= $this->uri->segment(3);

			if($this->model_komisi->t_ada($id))
			{
				$this->model_komisi->t_delete($id);
			}
			redirect('henkel_adm_program_penjualan/tambah','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}
	}

	public function hapus_detail()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_komisi_detail']	= $this->uri->segment(3);
			$getId = $this->uri->segment(3);
			if($this->model_komisi->ada_detail($id))
			{
				$this->model_komisi->delete_detail($id);
			}
			//redirect('henkel_adm_program_penjualan/edit','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
