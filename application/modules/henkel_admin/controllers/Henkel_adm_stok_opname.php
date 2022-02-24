<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_stok_opname extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_stok_opname');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Data Stok Opname";
			$d['class'] = "persediaan";
			$d['data'] = $this->db_kpp->query("SELECT so.*,g.nama_gudang
					                               FROM stok_opname so
					                               JOIN gudang g
					                               ON so.kode_gudang=g.kode_gudang");
			$d['content'] = 'stok_opname/view';
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function tambah()
	{
		$number_of_status = $this->db_kpp->query("SELECT COUNT(1) AS status
																							FROM stok_opname
																							WHERE status='2'")->row();
    $status_recorded = $number_of_status->status;
		if ($status_recorded>0) {
			echo "<script type='text/javascript'>";
			echo "alert('Maaf, Masih Ada Transaksi Tertunda');";
			echo "</script>";
			redirect('henkel_adm_stok_opname', 'refresh');
		} else {
			$cek = $this->session->userdata('logged_in');
			$level = $this->session->userdata('level');
			if(!empty($cek) && $level=='henkel_admin'){
				$id_stok_opname = $this->model_stok_opname->cari_max_stok_opname();
				$id_stok_opname_detail = $this->model_stok_opname->cari_max_stok_opname_detail();
				$d = array('judul' 			=> 'Tambah Stok Opname',
							'class' 		=> 'persediaan',
							'id_stok_opname'=> $id_stok_opname,
							'id_stok_opname_detail'=> $id_stok_opname_detail,
							'kode_stok_opname'=> $this->create_kd(),
							'kode_gudang'	=> '',
							'content' 		=> 'stok_opname/add',
							'data'		=>  $this->db_kpp->query("SELECT tso.*,o.nama_item
																									FROM t_stok_opname tso
																									JOIN item o
																									ON tso.kode_item=o.kode_item")
							);
				$this->load->view('henkel_adm_home',$d);

			}else{
				redirect('henkel','refresh');
			}
		}
		}

		public function edit_tunda()
		{
		  $cek = $this->session->userdata('logged_in');
		  $level = $this->session->userdata('level');
		  if(!empty($cek) && $level=='henkel_admin'){
		    $id_stok_opname 		= $this->uri->segment(3);
		    $id_t_stok_opname = $this->db_kpp->query("SELECT MAX(id_t_stok_opname) FROM t_stok_opname");
		    $dt 	= $this->model_stok_opname->getByIdStokOpname($id_stok_opname);
		    $kode_stok_opname	= $dt->kode_stok_opname;
		    $tanggal_awal = $dt->tanggal_awal;
		    $tanggal_akhir = $dt->tanggal_akhir;
		    $data_sod = $this->db_kpp->query("SELECT stok_nyata, selisih
		                                      FROM stok_opname_detail
		                                      WHERE id_stok_opname='$id_stok_opname'");
		    foreach($data_sod->result() as $dt_sod)
		    {
		      $stok_nyata 		= $dt_sod->stok_nyata;
		      $selisih 		= $dt_sod->selisih;
		    }
		    $kode_gudang  = $dt->kode_gudang;
		    $data_gd = $this->db_kpp->query("SELECT nama_gudang
		                                     FROM gudang
		                                     WHERE kode_gudang='$kode_gudang'");
		    foreach($data_gd->result() as $dt_gd)
		    {
		      $nama_gudang = $dt_gd->nama_gudang;
		    }
				$data_tso = $this->db_kpp->query("SELECT kode_item, id_stok_opname_detail
		                                      FROM t_stok_opname
		                                      WHERE id_stok_opname = '$id_stok_opname'");
			  foreach($data_tso->result() as $dt_tso)
			  {
					$kode_item = $dt_tso->kode_item;
				 	$id_stok_opname_detail = $dt_tso->id_stok_opname_detail;
				}
		    $admin  = $dt->admin;
		    $d = array('judul' 			=> 'Edit Stok Opname',
		          'class' 		=> 'persediaan',
		          'id_stok_opname'	=> $id_stok_opname,
							'id_stok_opname_detail'	=> $id_stok_opname_detail,
		          'kode_stok_opname' 			=> $kode_stok_opname,
		          'kode_gudang'	=> $kode_gudang,
		          'nama_gudang'	=> $nama_gudang,
		          'tanggal_awal'	=> tgl_sql($tanggal_awal),
		          'tanggal_akhir'	=> tgl_sql($tanggal_akhir),
		          'admin'	=> $admin,
		          'content'	=> 'stok_opname/edit_tunda',
		          'data' => $this->db_kpp->query("SELECT tso.*,o.nama_item
		                                          FROM t_stok_opname tso
		                                          JOIN item o
		                                          ON tso.kode_item=o.kode_item")
		                                         );
		    $this->load->view('henkel_adm_home',$d);
		  }else{
		    redirect('henkel','refresh');
		  }
		}


	public function create_kd()
	{
		$tanggal = date("y-m");
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){

			$last_kd = $this->model_stok_opname->last_kode();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = $tanggal.'/SO/'.sprintf("%03s", $no_akhir);
				//echo json_encode($kd);
			}else{
				$kd = $tanggal.'/SO/'.'001';
				//echo json_encode($kd);
			}
			return $kd;
		}else{
			redirect('henkel','refresh');
		}

	}

	public function edit()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){

			$id_stok_opname 		= $this->uri->segment(3);
			$dt 	= $this->model_stok_opname->getByIdStokOpname($id_stok_opname);
			$kode_stok_opname	= $dt->kode_stok_opname;
			$tanggal_awal = $dt->tanggal_awal;
			$tanggal_akhir = $dt->tanggal_akhir;
			$data_sod = $this->db_kpp->query("SELECT stok_nyata, selisih
																			  FROM stok_opname_detail
																			  WHERE id_stok_opname='$id_stok_opname'");
		  foreach($data_sod->result() as $dt_sod)
			{
				$stok_nyata 		= $dt_sod->stok_nyata;
				$selisih 		= $dt_sod->selisih;
			}
			$kode_gudang  = $dt->kode_gudang;
			$data_gd = $this->db_kpp->query("SELECT nama_gudang
																			 FROM gudang
																			 WHERE kode_gudang='$kode_gudang'");
			foreach($data_gd->result() as $dt_gd)
			{
				$nama_gudang = $dt_gd->nama_gudang;
			}
			$admin  = $dt->admin;
			$d = array('judul' 			=> 'Edit Stok Opname',
						'class' 		=> 'persediaan',
						'id_stok_opname'	=> $id_stok_opname,
						'kode_stok_opname' 			=> $kode_stok_opname,
						'kode_gudang'	=> $kode_gudang,
						'nama_gudang'	=> $nama_gudang,
						'tanggal_awal'	=> tgl_sql($tanggal_awal),
						'tanggal_akhir'	=> tgl_sql($tanggal_akhir),
						'admin'	=> $admin,
						'content'	=> 'stok_opname/edit',
						'data' => $this->db_kpp->query("SELECT sod.*,o.nama_item
																						FROM stok_opname_detail sod
																						JOIN item o
																						ON sod.kode_item=o.kode_item
																						WHERE sod.id_stok_opname='$id_stok_opname'")
																					 );
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function cek_table(){
		$id['id_stok_opname']=$this->input->post('id_cek');
		$q 	 = $this->db_kpp->get("t_stok_opname");
		$row = $q->num_rows();
		echo $row;
	}

	public function cek_bayar(){
		$id['id_pembayaran_piutang']=$this->input->post('id_cek');
		$q 	 = $this->db_kpp->query("SELECT SUM(bayar) as total_bayar FROM t_piutang");
		foreach ($q->result() as $dt) {
			$cek=(int)$dt->total_bayar;
		}
		echo $cek;
	}

	public function baru(){
		$id['id_pembayaran_piutang']=$this->input->post('id_new');
		$this->db_kpp->empty_table("t_piutang");
	}

	public function search_kd_gudang()
	{
		$keyword = $this->uri->segment(3);
		$data = $this->db_kpp->from('gudang')->like('kode_gudang',$keyword)->get();
		// format keluaran di dalam array
		foreach($data->result() as $dt)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$dt->kode_gudang,
				'nama_gudang'	=>$dt->nama_gudang
			);
		}
		echo json_encode($arr);
	}

	public function cek(){
		$id=$this->input->post('kode_gudang');
		if($this->model_stok_opname->ada_hutang($id))
		{
			$this->db_kpp->empty_table('t_stok_opname');
			$id_stok_opname = $this->model_stok_opname->cari_max_stok_opname();
			$id_t=$this->input->post('kode_gudang');
			$this->db_kpp->query("INSERT INTO t_stok_opname (kode_gudang,kode_item,stok_item)
														SELECT kode_gudang,kode_item,stok
														FROM stok_item
														WHERE kode_gudang='$id_t'");
			$this->db_kpp->query("UPDATE t_stok_opname
														SET id_stok_opname = '$id_stok_opname', status = '0'
													  WHERE kode_gudang='$id_t'");
			echo "1";
		}else {
			$this->db_kpp->empty_table('t_stok_opname');
			echo "0";
		}
	}

	public function simpan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		$number_of_status = $this->db_kpp->query("SELECT COUNT(1) AS status
																							FROM t_stok_opname
																							WHERE status='0'")->row();
    $status_recorded = $number_of_status->status;
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_stok_opname']= $this->input->post('id');
			$dt['kode_stok_opname'] = $this->input->post('kode_stok_opname');
			$dt['tanggal_awal'] = tgl_sql($this->input->post('tanggal_awal'));
			$dt['tanggal_akhir'] = tgl_sql($this->input->post('tanggal_akhir'));
			$dt['kode_gudang'] = $this->input->post('kode_gudang');
			$dt['status'] = '1';
			$dt['admin'] = $this->session->userdata('nama_lengkap');
			if ($status_recorded>0) {
					echo "Maaf, Data Belum Lengkap";
			}
			else if($this->model_stok_opname->ada($id)){
				  $dt['w_update'] = date('Y-m-d H:i:s');
					$this->model_stok_opname->update($id, $dt);
					$this->db_kpp->empty_table('t_stok_opname');
					echo "Data Sukses diUpdate";
			}else{
					$dt['id_stok_opname'] = $this->input->post('id_stok_opname');
					$dt['w_insert'] = date('Y-m-d H:i:s');
					$this->model_stok_opname->insert($dt);
					$this->db_kpp->empty_table('t_stok_opname');
					echo "Data Sukses diSimpan";
				}
		}else{
			redirect('henkel','refresh');
		}

	}

	public function tunda()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_stok_opname']= $this->input->post('id');
			$dt['kode_stok_opname'] = $this->input->post('kode_stok_opname');
			$dt['tanggal_awal'] = tgl_sql($this->input->post('tanggal_awal'));
			$dt['tanggal_akhir'] = tgl_sql($this->input->post('tanggal_akhir'));
			$dt['kode_gudang'] = $this->input->post('kode_gudang');
			$dt['status'] = '2';
			$dt['admin'] = $this->session->userdata('nama_lengkap');
			if($this->model_stok_opname->ada($id)){
					$this->model_stok_opname->update($id, $dt);
					echo "Data Tunda Sukses diUpdated";
			}else{
					$dt['id_stok_opname'] = $this->input->post('id_stok_opname');
					$this->model_stok_opname->insert($dt);
					echo "Data Sukses diTunda";
				}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function t_simpan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		$kode_item = $this->input->post('kode_item');
		$id_stok_opname_detail = $this->input->post('id_stok_opname_detail');
		$stok_nyata = $this->input->post('stok_nyata');
		$selisih = $this->input->post('selisih');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_stok_opname_detail']= $this->input->post('id_stok_opname_detail');
			$dt['id_stok_opname']= $this->input->post('id_stok_opname');
			$dt['kode_item'] = $this->input->post('kode_item');
			$dt['stok_item'] = $this->input->post('stok_item');
			$dt['stok_nyata'] = $this->input->post('stok_nyata');
			$dt['selisih'] = $this->input->post('selisih');
			//$dt['admin'] = $this->session->userdata('nama_lengkap');
				if($this->model_stok_opname->ada_stok_opname_detail($id)){
					$this->model_stok_opname->update_stok_opname_detail($id, $dt);
					$this->db_kpp->query("UPDATE t_stok_opname
																SET id_stok_opname_detail='$id_stok_opname_detail', stok_nyata='$stok_nyata', selisih='$selisih'
															  WHERE id_stok_opname_detail='$id_stok_opname_detail'");
					echo "Data Sukses diUpdate";
				} else if($this->model_stok_opname->t_ada_add($id_stok_opname_detail)) {
					$this->model_stok_opname->update_stok_opname_detail($id, $dt);
					$this->db_kpp->query("UPDATE t_stok_opname
																SET id_stok_opname_detail='$id_stok_opname_detail', stok_nyata='$stok_nyata', selisih='$selisih'
															  WHERE id_stok_opname_detail='$id_stok_opname_detail'");
					echo "Data Sukses diUpdate";
				} else{
					$dt['id_stok_opname_detail'] = $this->input->post('id_stok_opname_detail');
					$id_t=$this->input->post('id');
					$this->model_stok_opname->insert_stok_opname_detail($dt);
					$this->db_kpp->query("UPDATE t_stok_opname
																SET id_stok_opname_detail='$id_stok_opname_detail', status = '1', stok_nyata='$stok_nyata', selisih='$selisih'
															  WHERE kode_item='$kode_item'");
					//$this->db_kpp->empty_table('t_stok_opname');
					echo "Data Sukses diSimpan";
				}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function t_simpan_tunda()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		$kode_item = $this->input->post('kode_item');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_stok_opname_detail']= $this->input->post('id_stok_opname_detail');
			$dt['id_stok_opname']= $this->input->post('id_stok_opname');
			$dt['kode_item'] = $this->input->post('kode_item');
			$dt['stok_item'] = $this->input->post('stok_item');
			$dt['stok_nyata'] = $this->input->post('stok_nyata');
			$dt['selisih'] = $this->input->post('selisih');
			//$dt['admin'] = $this->session->userdata('nama_lengkap');
				if($this->model_stok_opname->ada_stok_opname_detail($id)){
					$this->model_stok_opname->update_stok_opname_detail($id, $dt);
					echo "Data Sukses diUpdate";
				}else{
					$dt['id_stok_opname_detail'] = $this->input->post('id_stok_opname_detail');
					$id_t=$this->input->post('id');
					$this->db_kpp->query("UPDATE t_stok_opname
																SET status = '1'
															  WHERE kode_item='$kode_item'");
					$this->model_stok_opname->insert_stok_opname_detail($dt);
					//$this->db_kpp->empty_table('t_stok_opname');
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
			$id['id_t_stok_opname']	= $this->input->get('cari');
			//$id2	= $this->input->get('cari');
			if($this->model_stok_opname->t_ada($id)) {
				$dt = $this->model_stok_opname->t_get($id);
				$d['id_t_stok_opname'] = $dt->id_t_stok_opname;
				$d['kode_item']	= $dt->kode_item;
				$d['stok_item']	= $dt->stok_item;
				$d['stok_nyata']	= $dt->stok_nyata;
				echo json_encode($d);
			} else {
				$d['id_t_stok_opname']	= '';
				$d['kode_item']	= '';
				$d['stok_item']	= '';
				$d['stok_nyata']	= '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function t_cari_inserted()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_t_stok_opname']	= $this->input->get('cari');
			//$id2	= $this->input->get('cari');
			if($this->model_stok_opname->t_ada($id)) {
				$dt = $this->model_stok_opname->t_get($id);
				$d['id_t_stok_opname'] = $dt->id_t_stok_opname;
				$d['id_stok_opname_detail'] = $this->model_stok_opname->cari_max_stok_opname_detail();
				$d['kode_item']	= $dt->kode_item;
				$d['stok_item']	= $dt->stok_item;
				$d['stok_nyata']	= $dt->stok_nyata;
				$d['selisih']	= $dt->selisih;
				echo json_encode($d);
			} else {
				$d['id_t_stok_opname']	= '';
				$d['id_stok_opname_detail']	= '';
				$d['kode_item']	= '';
				$d['stok_item']	= '';
				$d['stok_nyata']	= '';
				$d['selisih']	= '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function t_cari_add()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_t_stok_opname']	= $this->input->get('cari');
			//$id2	= $this->input->get('cari');
			if($this->model_stok_opname->t_ada($id)) {
				$dt = $this->model_stok_opname->t_get($id);
				$d['id_t_stok_opname'] = $dt->id_t_stok_opname;
				$d['id_stok_opname_detail'] = $dt->id_stok_opname_detail;
				$d['kode_item']	= $dt->kode_item;
				$d['stok_item']	= $dt->stok_item;
				$d['stok_nyata']	= $dt->stok_nyata;
				$d['selisih']	= $dt->selisih;
				echo json_encode($d);
			} else {
				$d['id_t_stok_opname']	= '';
				$d['id_stok_opname_detail']	= '';
				$d['kode_item']	= '';
				$d['stok_item']	= '';
				$d['stok_nyata']	= '';
				$d['selisih']	= '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function cari_pdf(){
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_stok_opname']	= $this->input->get('cari');

			if($this->model_stok_opname->ada($id)) {
				$dt = $this->model_stok_opname->get($id);

				$d['id_stok_opname']	= $dt->id_stok_opname;
				$d['kode_stok_opname']	= $dt->kode_stok_opname;
				$d['kode_gudang']	= $dt->kode_gudang;
				$data_gudang = $this->db_kpp->from('gudang')->where('kode_gudang',$dt->kode_gudang)->get();
				foreach($data_gudang->result() as $dt_gudang)
				{
					$d['nama_gudang'] = $dt_gudang->nama_gudang;
				}
				$d['tanggal_awal'] = $dt->tanggal_awal;
				$d['tanggal_akhir'] = $dt->tanggal_akhir;
				echo json_encode($d);
			} else {
				$d['id_stok_opname']		= '';
				$d['kode_stok_opname']  	= '';
				$d['kode_gudang']  	= '';
				$d['nama_gudang']  	= '';
				$d['tanggal_awal'] = '';
				$d['tanggal_akhir'] = '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function cari_excel(){
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_stok_opname']	= $this->input->get('cari');

			if($this->model_stok_opname->ada($id)) {
				$dt = $this->model_stok_opname->get($id);

				$d['id_stok_opname']	= $dt->id_stok_opname;
				$d['kode_stok_opname']	= $dt->kode_stok_opname;
				$d['kode_gudang']	= $dt->kode_gudang;
				$data_gudang = $this->db_kpp->from('gudang')->where('kode_gudang',$dt->kode_gudang)->get();
				foreach($data_gudang->result() as $dt_gudang)
				{
					$d['nama_gudang'] = $dt_gudang->nama_gudang;
				}
				$d['tanggal_awal'] = $dt->tanggal_awal;
				$d['tanggal_akhir'] = $dt->tanggal_akhir;
				echo json_encode($d);
			} else {
				$d['id_stok_opname']		= '';
				$d['kode_stok_opname']  	= '';
				$d['kode_gudang']  	= '';
				$d['nama_gudang']  	= '';
				$d['tanggal_awal'] = '';
				$d['tanggal_akhir'] = '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function cetak_pdf()
	{
		require_once(APPPATH.'plugins/fpdf.php');
		define('FPDF_FONTPATH',$this->config->item('fonts_path'));
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){

			$id_c = $this->input->get('cari');
			$admin = $this->session->userdata('nama_lengkap');
			$kode_stok_opname = $this->input->get('kode_stok_opname');
			$tanggal_awal = $this->input->get('tanggal_awal');
			$tanggal_akhir = $this->input->get('tanggal_akhir');
			$kode_gudang = $this->input->get('kode_gudang');
			$q = $this->db_kpp->query("SELECT *
																 FROM stok_opname
																 WHERE id_stok_opname='$id_c'");
			$r = $q->num_rows();

			if($r>0){
				define('FPDF_FONTPATH', $this->config->item('fonts_path'));
				require(APPPATH.'plugins/fpdf.php');
				$pdf=new FPDF();
			  $pdf->AddPage("P","A4");
				//foreach($data->result() as $t){
					$A4[0]=210;
					$A4[1]=297;
					$Q[0]=216;
					$Q[1]=279;
					$pdf->SetTitle('CETAK STOK OPNAME');
					$pdf->SetCreator('IT Kumala');

					$h = 7;
					$pdf->SetFont('Times','B', 14);
					$pdf->Image('assets/img/kumala.png',10,6,20);
					$w = array(50,25,3,50,10,3,10);
					//Cop
					$pdf->SetY(5);
					$pdf->SetX(33);
					$pdf->SetFont('Times','B',8);
					$pdf->Cell($w[0],$h,'CETAK STOK OPNAME',0,0,'L');
					$pdf->Cell($w[1],$h,'Kode Stok Opname',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($w[3],$h,$kode_stok_opname,0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'L');
					$pdf->Cell($w[6],$h,'',0,0,'L');
					$pdf->Ln(5);
					$pdf->SetX(33);
					$pdf->Cell($w[0],$h,'PT.KUMALA MOTOR SEJAHTERA',0,0,'L');
					$pdf->Cell($w[1],$h,'Tanggal Awal',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($w[3],$h,tgl_sql_gm($tanggal_awal),0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'L');
					$pdf->Cell($w[6],$h,'',0,0,'L');
					$pdf->Ln(5);
					$pdf->SetX(33);
					$pdf->Cell($w[0],$h,'Jl. A. Mappanyukki No.2',0,0,'L');
					$pdf->Cell($w[1],$h,'Gudang',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($w[3],$h,$kode_gudang,0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'L');
					$pdf->Cell($w[6],$h,'',0,0,'L');
					$pdf->Ln(5);
					$pdf->SetX(33);
					$pdf->Cell($w[0],$h,'0411 - 871408',0,0,'L');
					$pdf->Cell($w[1],$h,'Alamat ',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($pdf->GetStringWidth($w[3]),$h,$alamat,0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'L');
					$pdf->Cell($w[6],$h,'',0,0,'L');
					$pdf->Ln(5);
					$pdf->SetX(33);
					$pdf->Cell($w[0],$h,'0411 - 856555',0,0,'L');
					$pdf->Cell($w[1],$h,'Admin',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($w[2],$h,$admin,0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'L');
					$pdf->Cell($w[6],$h,'',0,0,'L');

					$pdf->Line(10, 33, 210-10, 33);

					$pdf->Ln(10);

					//Column widths
					$w = array(8,25,20);

					//Header
					$pdf->SetFont('Times','B',8);
					$pdf->Cell($w[0],$h,'No',1,0,'C');
					$pdf->Cell($w[1],$h,'Kode Stok Opname',1,0,'C');
					$pdf->Cell($w[2],$h,'Kode Gudang',1,0,'C');

					//data
					$pdf->SetFillColor(224,235,255);
					$pdf->SetFont('Times','',8);
					$pdf->SetFillColor(204,204,204);
    			$pdf->SetTextColor(0);
					$total_kredit=0;
					$total_bayar=0;
					$total_sisa=0;
					$no=1;
					foreach($q->result() as $row)
					{
						$pdf->Cell($w[0],$h,$no++,'LR',0,'C');
						$pdf->Cell($w[1],$h,$kode_stok_opname,'LR',0,'C');
						$pdf->Cell($w[2],$h,$kode_gudang,'LR',0,'C');
						$pdf->Ln();
						$no++;
					}
					// Closing line
					$pdf->Cell(array_sum($w),0,'','T');
					$pdf->Ln(1);
					$pdf->SetX(10);
					$pdf->Cell(100,$h,'Keterangan :','C');
					$pdf->SetX(30);
					$pdf->Cell(100,$h,'Keterangan','C');
					$pdf->Ln(10);
					$h = 5;
					$pdf->SetFont('Times','B',8);
					$pdf->SetX(10);
					$pdf->Cell(42,$h,'Hormat Kami',0,0,'L');
					$pdf->Cell(20,$h,'Penerima',0,0,'L');
					$pdf->SetX(20);
					$pdf->Ln(10);
					$pdf->Cell(40,$h,'(......................)',0,0,'L');
					$pdf->Cell(30,$h,'(......................)',0,0,'L');
					$w = array(20,3,20,18,3,38);
					$pdf->Ln(-15);
					$pdf->SetX(100);
					$pdf->Cell($w[0],$h,'',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'',0,0,'L');
					$pdf->Cell($w[3],$h,'',0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'R');
					$pdf->Ln(5);
					$pdf->SetX(100);
					$pdf->Cell($w[0],$h,'',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'',0,0,'L');
					$pdf->Cell($w[3],$h,'',0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'R');
					$pdf->Ln(5);
					$pdf->SetX(100);
					$pdf->Cell($w[0],$h,'',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'',0,0,'L');
					$pdf->Cell($w[3],$h,'',0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'R');

					$pdf->Output('Stok Opname - '.$kode_stok_opname.date('d-m-Y').'.pdf','I');
			}else{
				redirect($_SERVER['HTTP_REFERER']);
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function cetak_excel(){
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
				$id_stok_opname = $this->input->get('id_stok_opname');
				$kode_stok_opname = $this->input->get('kode_stok_opname');
				$tanggal_awal  = tgl_sql($this->input->get('tanggal_awal'));
				$tanggal_akhir = tgl_sql($this->input->get('tanggal_akhir'));
				$kode_gudang = $this->input->get('kode_gudang');
        $ambildata = $this->model_stok_opname->export_excel($id_stok_opname);

        if(count($ambildata)>0){
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()
                  			->setCreator("IT Kumala Motor Group") //creator
                    		->setTitle("Export Excel Data Stok Opname");  //file title

            $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
            $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object

            $objget->setTitle('Sample Sheet'); //sheet title
            //Warna header tabel
            /*$objget->getStyle("A1:Y1")->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLD,
                        'color' => array('rgb' => '92d050')
                    ),
                    'font' => array(
                        'color' => array('rgb' => '000000')
                    )
                )
            );*/

            //table header
            $cols = array("A","B","C","D","E","F","G","H","I","J");

            $val = array("NO","Kode Stok Opname","Kode Gudang","Nama Gudang","Tanggal Awal","Tanggal Akhir","Kode Item","Nama Item","Stok Nyata","Selisih");

            for ($a=0;$a<10; $a++)
            {
                $objset->setCellValue($cols[$a].'1', $val[$a]);

                //Setting lebar cell
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
								$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
								$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
								$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
								$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
								$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
								$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
								$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);

                $style = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
                $objPHPExcel->getActiveSheet()->getStyle($cols[$a].'1')->applyFromArray($style);
            }

            $baris=2;
						$i=1;
            foreach ($ambildata as $dt){
							  $nama_item=$this->model_stok_opname->get_kd_item($dt->kode_item);
								$nama_gudang=$this->model_stok_opname->get_kd_gudang($kode_gudang);

								//$objset->setCellValue("A".$baris, $kode_stok_opname);
								$objset->setCellValue("A".$baris, $i++);
								$objset->setCellValue("B".$baris, $kode_stok_opname);
								$objset->setCellValue("C".$baris, $kode_gudang);
								$objset->setCellValue("D".$baris, $nama_gudang);
								$objset->setCellValue("E".$baris, $tanggal_awal);
								$objset->setCellValue("F".$baris, $tanggal_akhir);
                $objset->setCellValue("G".$baris, $dt->kode_item);
                $objset->setCellValue("H".$baris, $nama_item);
								$objset->setCellValue("I".$baris, $dt->stok_nyata);
								$objset->setCellValue("J".$baris, $dt->selisih);

                //Set number value
                $objPHPExcel->getActiveSheet()->getStyle('C1:C'.$baris)->getNumberFormat()->setFormatCode('0');

                $baris++;
            }

            $objPHPExcel->getActiveSheet()->setTitle('Data Export');

            $objPHPExcel->setActiveSheetIndex(0);
            $filename = urlencode("Data".$kode_stok_opname.date("Y-m-d H:i:s").".xls");

              header('Content-Type: application/vnd.ms-excel'); //mime type
              header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
              header('Cache-Control: max-age=0'); //no cache

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }else{
            redirect('henkel_adm_stok_opname', 'refresh');
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
			$id['id_pembayaran_piutang']	= $this->uri->segment(3);

			if($this->model_pembayaran_piutang->ada($id))
			{
				$this->model_pembayaran_piutang->delete($id);
			}
			redirect('henkel_adm_pembayaran_piutang','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
