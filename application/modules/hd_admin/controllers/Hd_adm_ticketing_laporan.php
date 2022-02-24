<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hd_adm_ticketing_laporan extends CI_Controller {

	public function __construct() {
	    parent::__construct();
		$this->load->model('Model_ticketing_laporan');
	}

	public function index() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$d['judul']=" Data Pengaduan";
			$d['class'] = "ticketing";
			$d['content'] = 'ticketing/view_pengaduan_laporan';//buka tampilan seluruh pengaduan
			$this->load->view('hd_adm_home',$d);
		}else{
			redirect('login','refresh');
		}
	}
	public function laporan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$tahun_bulan= $this->input->post('laporan');
			$tahun = substr($tahun_bulan,0,4);
			$bulan = substr($tahun_bulan,5,2);
			$d['judul']=" Data Laporan ".$tahun_bulan;
			$d['class'] = "ticketing";
			$d['tahun'] = $tahun;
			$d['bulan'] = $bulan;
			$d['tahun_bulan'] = $this->input->post('laporan');
			$d['data'] = $this->Model_ticketing_laporan->get_laporan($tahun,$bulan);//ambil data seluruh pengaduan
			$d['content'] = 'ticketing/view_pengaduan_laporan_bulan';//buka tampilan seluruh pengaduan
			$this->load->view('hd_adm_home',$d);
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
	public function get_laporan($bulan)
	{
		$year = substr($bulan,0,4);
		$month = substr($bulan,5,2);

		$list = $this->db->query("SELECT db_helpdesk.tabel_pengaduan.id_pengaduan,kmg.karyawan.nik,nama_karyawan,nama_brand,lokasi,
		type_pengaduan,jenis_masalah,keterangan,priority,status_pengaduan,nik_eksekutor,nama_eksekutor,status_solving,tanggal_pengaduan,
		tanggal_selesai,tanggal_mulai,estimasi FROM (((db_helpdesk.tabel_pengaduan INNER JOIN kmg.perusahaan on 
		kmg.perusahaan.id_perusahaan=db_helpdesk.tabel_pengaduan.id_perusahaan) INNER JOIN kmg.brand on kmg.brand.id_brand= kmg.perusahaan.id_brand) 
		INNER JOIN kmg.karyawan on kmg.karyawan.nik=db_helpdesk.tabel_pengaduan.nik) LEFT JOIN db_helpdesk.tabel_solving ON 
		db_helpdesk.tabel_solving.id_pengaduan=db_helpdesk.tabel_pengaduan.id_pengaduan AND tanggal_selesai = tanggal_solving AND 
		status_pengaduan = status_solving WHERE MONTH(tanggal_pengaduan) = '$month' AND YEAR(tanggal_pengaduan) = '$year' GROUP BY 
		db_helpdesk.tabel_pengaduan.id_pengaduan ORDER BY db_helpdesk.tabel_pengaduan.id_pengaduan ASC");
		$row = array();
		$no = 1;
		foreach ($list->result() as $dt) {
			$row[] = array(
							'no'=>'<center>'.$no++.'</center>',
							'id_pengaduan'=>'<center>'.$dt->id_pengaduan.'</center>',
							'nik'=>'<center>'.$dt->nik.'</center>',
							'nama_karyawan'=>'<center>'.$dt->nama_karyawan.'</center>',
							'nama_brand'=>'<center>'.$dt->nama_brand.'</center>',
							'lokasi'=>'<center>'.$dt->lokasi.'</center>',
							'type_pengaduan'=>'<center>'.$dt->type_pengaduan.'</center>',
							'jenis_masalah'=>'<center>'.$dt->jenis_masalah.'</center>',
							'keterangan'=>'<center>'.$dt->keterangan.'</center>',
							'priority'=>'<center>'.$dt->priority.'</center>',
							'status_pengaduan'=>'<center>'.$dt->status_pengaduan.'</center>',
							'nik_eksekutor'=>'<center>'.$dt->nik_eksekutor.'</center>',
							'nama_eksekutor'=>'<center>'.$dt->nama_eksekutor.'</center>',
							'status_solving'=>'<center>'.$dt->status_solving.'</center>',
							'tanggal_pengaduan'=>'<center>'.$dt->tanggal_pengaduan.'</center>',
							'tanggal_selesai'=>'<center>'.$dt->tanggal_selesai.'</center>',
							'tanggal_mulai'=>'<center>'.$dt->tanggal_mulai.'</center>',
							'estimasi'=>'<center>'.$dt->estimasi.'</center>'

						);
			$data= array('aaData'=>$row);
		}

		echo json_encode($data);
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
