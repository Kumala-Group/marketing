<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hd_adm_ticketing extends CI_Controller {

	public function __construct() {
	    parent::__construct();
		$this->load->model('model_ticketing');
		$this->load->model('model_perusahaan');
	}

	public function index() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$d['judul']=" Data Pengaduan";
			$d['class'] = "ticketing";
			$d['data'] = array(
				'items' => $this->model_ticketing->getAllTicket(),
				'list_dep' => $this->model_ticketing->getAllDepartement(),
				'list_brand' => $this->model_ticketing->getAllBrand(),
				'executing' => $this->model_ticketing->getAllTicketExecuting($this->session->userdata('username')),
				'ticket_process' => $this->model_ticketing->ticket_process()
			);
			$d['content'] = 'ticketing/view_tiket';//buka tampilan seluruh pengaduan
			$this->load->view('hd_adm_home',$d);
		}else{
			redirect('login','refresh');
		}
	}

	public function update(){
		$post = $this->input->post();
		if(isset($post['pickup'])){
			$this->model_ticketing->update2Pickup($post);
			redirect('hd_adm_ticketing', 'refresh');
		}else if(isset($post['done'])){
			$this->model_ticketing->update2Done($post);
			redirect('hd_adm_ticketing', 'refresh');
		}else if(isset($post['cancel'])){
			$this->model_ticketing->update2Cancel($post);
			redirect('hd_adm_ticketing', 'refresh');
		}
	}

	public function tambah() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$d = array('judul' 			=> 'Tambah Tiket',
						'class' 		=> 'ticketing',
						'tanggal'=> date("Y-m-d"),

						'perusahaan' => $this->model_perusahaan->data_perusahaan_brand()->result(),
						'content' 		=> 'ticketing/view_tambah_pengaduan'//buka tampilan  
						);
			$this->load->view('hd_adm_home',$d);
		}else{
			redirect('login','refresh');
		}
	}
	

	public function create_kd() {
		$tanggal = date("y-m");
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){

			$last_kd = $this->model_ticketing->last_kode();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = $tanggal.'/PBL/'.sprintf("%03s", $no_akhir);
				//echo json_encode($d);
			}else{
				$kd = $tanggal.'/PBL/'.'001';
				//echo json_encode($d);
			}
			return $kd;
		}else{
			redirect('login','refresh');
		}
	}

	public function last_kode(){
		$q = $this->db_hd->query("SELECT MAX(right(no_po,3)) as kode FROM ticketing ");
		$row = $q->num_rows();

		if($row > 0){
            $rows = $q->result();
            $hasil = (int)$rows[0]->kode;
        }else{
            $hasil = 0;
        }
		return $hasil;
	}

	public function baru(){
		$id['id_ticketing']=$this->input->post('id_new');
		if($this->model_ticketing->t_ada_id_pesanan($id)) {
			$this->db_hd->delete("t_pengiriman",$id);
		}
	}

	public function cek_table(){
		$id['id_ticketing']=$this->input->post('id_cek');
		$q 	 = $this->db_hd->get_where("t_pengiriman",$id);
		$row = $q->num_rows();
		echo $row;
	}

	public function simpan_lama()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
		$id['id_tiket']= $this->input->post('id_tiket');
			date_default_timezone_set('Asia/Makassar');
			$dt['id_tiket']= $this->input->post('id_tiket');
			$dt['id_perusahaan'] 	= $this->input->post('id_perusahaan');
			$dt['nik'] 	= $this->input->post('nik_tiket');
			$dt['tgl_tiket'] 			= tgl_sql($this->input->post('tgl_tiket'));
			$dt['wkt_tiket'] 	= $this->input->post('wkt_tiket');
			$dt['masalah'] 	= $this->input->post('masalah');
			$dt['priority'] 	= $this->input->post('priority');
			$dt['status_tiket'] 	= 'Open';

			if($this->model_ticketing->ada($id)){
				$dt['id_tiket'] 	= $this->input->post('id_tiket');
				$this->model_ticketing->update($id, $dt);
				echo "Tiket Sukses diUpdate";
			}else{
				$dt['id_tiket'] 	= $this->model_ticketing->cari_max_ticketing();
				$this->model_ticketing->insert($dt);
				echo "Tiket Sukses diSimpan";
			}
		}else{
			redirect('login','refresh');
		}
	}

	//Menyimpan data tambah pengaduan
	public function simpan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$id['id_pengaduan']= $this->input->post('id_pengaduan');
			date_default_timezone_set('Asia/Makassar');
			$dt['id_pengaduan']		= $this->input->post('id_pengaduan');
			$dt['type_pengaduan'] 	= $this->input->post('type_pengaduan');
			if($dt['type_pengaduan']=='S'){
				$dt['jenis_masalah'] = $this->input->post('jenis_support');
			}
			else if($dt['type_pengaduan']=='D'){
				$dt['jenis_masalah'] = $this->input->post('jenis_developer');
			}
			else if($dt['type_pengaduan']=='A'){
				$dt['jenis_masalah'] = $this->input->post('jenis_android');
			}
			else{
				$dt['jenis_masalah'] ='';
			}
			
			$dt['priority'] 		= $this->input->post('priority');
			$dt['keterangan'] 		= $this->input->post('keterangan');
			$dt['nik'] 				= $this->input->post('nik');
			$dt['id_perusahaan'] 	= $this->input->post('id_perusahaan');
			$dt['tanggal_pengaduan'] = date('Y/m/d h:i:s');
			
			$this->model_ticketing->insert_pengaduan($dt);
			echo 'Pengaduan Berhasil';
            redirect('hd_adm_ticketing','refresh');

		}else{
			redirect('login','refresh');
		}
	}
	
		
public function t_simpan() {
	$cek = $this->session->userdata('logged_in');
	$level = $this->session->userdata('level');
	if(!empty($cek) && $level=='karyawan'){
		date_default_timezone_set('Asia/Makassar');
		$id['id_ticketing']= $this->input->post('id');
		$dt['no_inv_pengiriman'] = $this->input->post('no_inv_pengiriman');
		$dt['tanggal_pengiriman'] = tgl_sql($this->input->post('tanggal_pengiriman'));
		$dt['biaya_pengiriman'] = remove_separator($this->input->post('biaya_pengiriman'));
			if($this->model_ticketing->ada($id)){
				$this->model_ticketing->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_ticketing'] = $this->input->post('id');
				$id_t=$this->input->post('id');
				$this->db_hd->query("INSERT INTO pengiriman (id_ticketing, id_pesanan_pembelian, no_inv_supplier)
															SELECT id_ticketing, id_pesanan_pembelian, no_inv_supplier
															FROM t_pengiriman
															WHERE id_ticketing='$id_t'");
				$this->db_hd->query("DELETE FROM t_pengiriman WHERE id_ticketing='$id_t'");
				$this->model_ticketing->insert($dt);
				echo "Data Sukses diSimpan";
			}
	}else{
		redirect('login','refresh');
	}
}
public function t_solv_simpan_lama() {
	$cek = $this->session->userdata('logged_in');
	$level = $this->session->userdata('level');
	if(!empty($cek) && $level=='karyawan'){
		date_default_timezone_set('Asia/Makassar');
		$status_tiket = $this->input->post('status_tiket');
		$id_tiket=$this->input->post('id_tiket');
		$dt['id_t_solv'] = $this->input->post('id_t_solv');
		$id_t_solv = $this->input->post('id_t_solv');
		$dt['id_tiket'] = $this->input->post('id_tiket');
		$dt['nik_exe'] = $this->input->post('nik_exe');
		$nik_exe = $this->input->post('nik_exe');
		$this->model_ticketing->insert_t_solv($dt);
		$this->db_helpdesk->query("UPDATE tiket SET status_tiket='$status_tiket' WHERE id_tiket='$id_tiket'");
		echo "Data Sukses diSimpan";

	}else{
		redirect('login','refresh');
	}
}

//Update atau Edit Pengaduan
public function t_solv_simpan() {
	$cek = $this->session->userdata('logged_in');
	$level = $this->session->userdata('level');
	if(!empty($cek) && $level=='karyawan'){
		date_default_timezone_set('Asia/Makassar');
		$status_pengaduan = $this->input->post('status_pengaduan');
		$id_pengaduan=$this->input->post('id_pengaduan');
		$dt['id_solv_pengaduan'] = $this->input->post('id_solv_pengaduan');
		$id_solv_pengaduan = $this->input->post('id_solv_pengaduan');
		$tanggal_selesai 	= date('Y/m/d h:i:s');
		$dt['id_pengaduan'] = $this->input->post('id_pengaduan');
		$dt['nik_eksekutor'] = $this->input->post('nik_eksekutor');
		$nik_eksekutor = $this->input->post('nik_eksekutor');
		$estimasi = $this->input->post('estimasi');
		$dt['nama_eksekutor'] = $this->input->post('nama_eksekutor');
		$dt['status_solving'] = $this->input->post('status_pengaduan');
		$dt['tanggal_solving']  = $tanggal_selesai;
		$tanggal_mulai = $this->input->post('tanggal_mulai');

		if($tanggal_mulai == 0){
			$tanggal_mulai = $tanggal_selesai;
		}
		
		if((!empty($dt['nik_eksekutor'])&&!empty($dt['nama_eksekutor']))||$status_pengaduan=='C'){
			$this->model_ticketing->insert_tabel_solving($dt);
			$this->db_helpdesk->query("UPDATE tabel_pengaduan SET status_pengaduan='$status_pengaduan', tanggal_selesai='$tanggal_selesai', estimasi='$estimasi', 
			tanggal_mulai='$tanggal_mulai' WHERE id_pengaduan='$id_pengaduan'");
			echo 'Data Berhasil Disimpan';
        	redirect('hd_adm_ticketing','refresh');
		}
		else
			echo 'Data Gagal Disimpan';
			redirect('hd_adm_ticketing','refresh');
	}else{
		redirect('login','refresh');
	}
}

	public function cari_lama()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$id['id_tiket']	= $this->input->get('cari');
			if($this->model_ticketing->ada($id)) {
				$dt = $this->model_ticketing->get($id);
				$d['id_tiket']	= $dt->id_tiket;
				$d['nik']		= $dt->nik;
				$d['tgl_tiket']	= $dt->tgl_tiket;
				$d['wkt_tiket']	= $dt->wkt_tiket;
				$d['masalah']	= $dt->masalah;
				$d['priority']	= $dt->priority;
				$d['status_tiket']	= $dt->status_tiket;
				$data = $this->db->from('karyawan')->where('nik',$dt->nik)->get();
				foreach($data->result() as $dt_kar)
				{
					$d['nama_karyawan'] = $dt_kar->nama_karyawan;
					$dataa = $this->db->from('perusahaan')->where('id_perusahaan',$dt_kar->id_perusahaan)->get();
					foreach($dataa->result() as $dt_per)
					{

						$d['lokasi'] = $dt_per->lokasi;
						$dataa = $this->db->from('brand')->where('id_brand',$dt_per->id_brand)->get();
						foreach($dataa->result() as $dt_sup)
						{
							$d['nama_brand'] = $dt_sup->nama_brand;
						}
					}
				}
				echo json_encode($d);

			} else {
				$d['id_tiket']		= '';
			$d['nik']	= '';
			$d['nama_karyawan']	= '';
			$d['nama_brand']	= '';
			$d['lokasi']	= '';
			$d['tgl_tiket']	= '';
			$d['wkt_tiket']	= '';
			$d['masalah']	= '';
			$d['priority']	= '';
			$d['status_tiket']	= '';
				echo json_encode($d);
			}
		}
		else {
			redirect('login','refresh');
		}
	}

	//Mencari data pengaduan
	public function cari()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$id['id_pengaduan']			= $this->input->get('cari');
			if($this->model_ticketing->ada_baru($id)) {
				$dt = $this->model_ticketing->get($id);
				$d['id_pengaduan']		= $dt->id_pengaduan;
				$d['nik']				= $dt->nik;
				$d['estimasi']			= $dt->estimasi;
				$d['tanggal_pengaduan']	= $dt->tanggal_pengaduan;
				$d['tanggal_mulai']		= $dt->tanggal_mulai;
				$d['keterangan']		= $dt->keterangan;
				$d['priority']			= $dt->priority;
				$d['status_pengaduan']	= $dt->status_pengaduan;
				$data = $this->db->from('karyawan')->where('nik',$dt->nik)->get();
				foreach($data->result() as $dt_kar)
				{
					$d['nama_karyawan'] = $dt_kar->nama_karyawan;
					$dataa = $this->db->from('perusahaan')->where('id_perusahaan',$dt_kar->id_perusahaan)->get();
					foreach($dataa->result() as $dt_per)
					{

						$d['lokasi'] = $dt_per->lokasi;
						$dataa = $this->db->from('brand')->where('id_brand',$dt_per->id_brand)->get();
						foreach($dataa->result() as $dt_sup)
						{
							$d['nama_brand'] = $dt_sup->nama_brand;
						}
					}
				}
				echo json_encode($d);

			} else {
			$d['id_pengaduan']		= '';
			$d['nik']	= '';
			$d['nama_karyawan']	= '';
			$d['nama_brand']	= '';
			$d['lokasi']	= '';
			$d['tanggal_pengaduan']	= '';
			$d['keterangan']	= '';
			$d['priority']	= '';
			$d['status_pengaduan']	= '';
				echo json_encode($d);
			}
		}
		else {
			redirect('login','refresh');
		}
	}
	public function hapus_lama()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$id['id_ticketing']	= $this->uri->segment(3);

			if($this->model_ticketing->ada($id))
			{
				$this->model_ticketing->delete($id);
			}
			redirect('hd_adm_ticketing','refresh');
		}
		else
		{
			redirect('login','refresh');
		}

	}

	//Menghapus data Pengaduan
	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$id['id_pengaduan']	= $this->uri->segment(3);

			if($this->model_ticketing->ada_baru($id))
			{
				$this->model_ticketing->delete_tabel_pengaduan($id);
			}
			redirect('hd_adm_ticketing','refresh');
		}
		else
		{
			redirect('login','refresh');
		}
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
