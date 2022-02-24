<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_program_penjualan extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_program_penjualan');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Data Program Penjualan";
			$d['class'] = "pustaka";
			$d['data'] = $this->model_program_penjualan->all();
			$d['content'] = 'program_penjualan/view';
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
			$id['id_program_penjualan']= $this->input->post('id_program_penjualan');
			$dt['kode_program_penjualan'] = $this->input->post('kode_program_penjualan');
			$dt['nama_program'] 			= $this->input->post('nama_program');

			if($this->model_program_penjualan->ada($id)){
				$this->model_program_penjualan->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_program_penjualan'] 	= $this->model_program_penjualan->cari_max_program_penjualan();
				$id_t = $this->model_program_penjualan->cari_max_program_penjualan();
				$this->model_program_penjualan->insert($dt);
				$this->db_kpp->query("INSERT INTO program_penjualan_detail (id_program_penjualan, kode_item, kode_gudang, jumlah_bonus)
															SELECT id_program_penjualan, kode_item, kode_gudang, jumlah_bonus
															FROM t_program_penjualan
															WHERE id_program_penjualan='$id_t'");
				$this->db_kpp->query("DELETE FROM t_program_penjualan WHERE id_program_penjualan='$id_t'");
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
			$id['id_t_program_penjualan']= $this->input->post('id_t_program_penjualan');
			$dt['id_program_penjualan']= $this->model_program_penjualan->cari_max_program_penjualan();
			$dt['kode_item'] 			= $this->input->post('kode_item');
      $dt['kode_gudang'] 			= $this->input->post('kode_gudang');
			$dt['jumlah_bonus'] 			= $this->input->post('jumlah_bonus');

			if($this->model_program_penjualan->t_ada($id)){
				$this->model_program_penjualan->t_update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_t_program_penjualan'] 	= $this->model_program_penjualan->cari_t_max_program_penjualan();
				$this->model_program_penjualan->t_insert($dt);
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
			$id['id_program_penjualan_detail']= $this->input->post('id_program_penjualan_detail');
			$dt['id_program_penjualan']= $this->input->post('id_program_penjualan');
			$dt['kode_item'] 			= $this->input->post('kode_item');
      $dt['kode_gudang'] 			= $this->input->post('kode_gudang');
			$dt['jumlah_bonus'] 			= $this->input->post('jumlah_bonus');

			if($this->model_program_penjualan->ada_detail($id)){
				$this->model_program_penjualan->update_detail($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_program_penjualan_detail'] 	= $this->model_program_penjualan->cari_max_program_penjualan_detail();
				$this->model_program_penjualan->insert_detail($dt);
				echo "Data Sukses diSimpan";
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function simpan_pp()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_program_penjualan']= $this->input->post('id');
			$dt['kode_program_penjualan'] 			= $this->input->post('kode_program_penjualan');
			$dt['nama_program'] 			= $this->input->post('nama_program');

			if($this->model_program_penjualan->ada($id)){
				$this->model_program_penjualan->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_program_penjualan'] 	= $this->model_program_penjualan->cari_max_program_penjualan();
				$this->model_program_penjualan->insert($dt);
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
			$id['id_program_penjualan']	= $this->input->get('cari');

			if($this->model_program_penjualan->ada($id)) {
				$dt = $this->model_program_penjualan->get($id);
				//$dt = $this->model_prodi->get2($id);

				$d['id_program_penjualan']	= $dt->id_program_penjualan;
				$d['nama_profil']	= $dt->nama_profil;
				$d['margin_harga_item']	= $dt->margin_harga_item;

				echo json_encode($d);
			} else {
				$d['id_program_penjualan']		= '';
				$d['nama_profil']		= '';
				$d['margin_harga_item']		= '';

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
			$last_kd = $this->model_program_penjualan->last_kode();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = 'PRGPEN-'.sprintf("%03s", $no_akhir);
			}else{
				$kd = 'PRGPEN-'.'001';
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
			$id_program_penjualan = $this->model_program_penjualan->cari_max_program_penjualan();
			$id = $this->model_program_penjualan->cari_max_program_penjualan();
			$d = array('judul' 			=> 'Tambah Program Penjualan',
						'class' 		=> 'pustaka',
						'id_program_penjualan'=> $id_program_penjualan,
						'nama_program'	=> '',
						'kode_program_penjualan'	=> $this->create_kd(),
						'content' 		=> 'program_penjualan/add',
						'data'		=>  $this->db_kpp->query("SELECT *
																								FROM t_program_penjualan tpp
																								JOIN item o ON tpp.kode_item=o.kode_item
																								JOIN gudang g ON tpp.kode_gudang=g.kode_gudang
																								WHERE tpp.id_program_penjualan='$id'")
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

			$id_program_penjualan 		= $this->uri->segment(3);
			$dt 	= $this->model_program_penjualan->get_detail($id_program_penjualan);
			$kode_program_penjualan	= $dt->kode_program_penjualan;
			$nama_program  = $dt->nama_program;
			$d = array('judul' 			=> 'Edit Program Penjualan ',
						'class' 		=> 'pustaka',
						'id_program_penjualan'	=> $id_program_penjualan,
						'kode_program_penjualan' 			=> $kode_program_penjualan,
						'nama_program'	=> $nama_program,
						'content'	=> 'program_penjualan/edit',
						'data' => $this->db_kpp->query("SELECT *
																						FROM program_penjualan_detail ppd
																						JOIN item ON ppd.kode_item=item.kode_item
																						JOIN gudang ON ppd.kode_gudang=gudang.kode_gudang
																						WHERE ppd.id_program_penjualan='$id_program_penjualan'")
						);
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function cek_table(){
		$id['id_program_penjualan']=$this->input->post('id_cek');
		$q 	 = $this->db_kpp->get_where("t_program_penjualan",$id);
		$row = $q->num_rows();
		echo $row;
	}

	public function cek_table_pp(){
		$id['id_program_penjualan']=$this->input->post('id_cek');
		$q 	 = $this->db_kpp->get_where("program_penjualan_detail",$id);
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
			$id['id_t_program_penjualan']	= $this->input->get('cari');
			if($this->model_program_penjualan->t_ada($id)) {
				$dt = $this->model_program_penjualan->t_get($id);
				$d['id_t_program_penjualan']	= $dt->id_t_program_penjualan;
				$d['id_program_penjualan']	= $dt->id_program_penjualan;
				$d['kode_item'] = $dt->kode_item;
				$data_item = $this->db_kpp->from('item')->where('kode_item',$dt->kode_item)->get();
				foreach($data_item->result() as $dt)
				{
					$d['nama_item'] = $dt->nama_item;
				}
				$d['kode_gudang'] = $dt->kode_gudang;
				$data_gudang = $this->db_kpp->from('gudang')->where('kode_gudang',$dt->kode_gudang)->get();
				foreach($data_gudang->result() as $dt_gudang)
				{
					$d['nama_gudang'] = $dt_gudang->nama_gudang;
				}
				$d['jumlah_bonus']	= $dt->jumlah_bonus;
				echo json_encode($d);

			} else {
				$d['id_t_program_penjualan']	= '';
				$d['id_program_penjualan']	= '';
				$d['kode_item'] = '';
				$d['nama_item'] = '';
				$d['kode_gudang'] = '';
				$d['nama_gudang']	= '';
				$d['jumlah_bonus']	= '';
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
			$id['id_program_penjualan_detail']	= $this->input->get('cari');
			if($this->model_program_penjualan->ada_detail($id)) {
				$dt = $this->model_program_penjualan->get_detail_ppd($id);
				$d['id_program_penjualan_detail']	= $dt->id_program_penjualan_detail;
				$d['id_program_penjualan']	= $dt->id_program_penjualan;
				$d['kode_item'] = $dt->kode_item;
				$data_item = $this->db_kpp->from('item')->where('kode_item',$dt->kode_item)->get();
				foreach($data_item->result() as $dt)
				{
					$d['nama_item'] = $dt->nama_item;
				}
				$d['kode_gudang'] = $dt->kode_gudang;
				$data_gudang = $this->db_kpp->from('gudang')->where('kode_gudang',$dt->kode_gudang)->get();
				foreach($data_gudang->result() as $dt_gudang)
				{
					$d['nama_gudang'] = $dt_gudang->nama_gudang;
				}
				$d['jumlah_bonus']	= $dt->jumlah_bonus;
				echo json_encode($d);

			} else {
				$d['id_t_program_penjualan']	= '';
				$d['id_program_penjualan']	= '';
				$d['kode_item'] = '';
				$d['nama_item'] = '';
				$d['kode_gudang'] = '';
				$d['nama_gudang']	= '';
				$d['jumlah_bonus']	= '';
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
			$id['id_t_program_penjualan']	= $this->uri->segment(3);

			if($this->model_program_penjualan->t_ada($id))
			{
				$this->model_program_penjualan->t_delete($id);
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
			$id['id_program_penjualan_detail']	= $this->uri->segment(3);
			$getId = $this->uri->segment(3);
			if($this->model_program_penjualan->ada_detail($id))
			{
				$this->model_program_penjualan->delete_detail($id);
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
