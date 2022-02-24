<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hd_adm_ticketing_client extends CI_Controller {

	public function __construct() {
	    parent::__construct();
		$this->load->model('model_ticketing_client');
		$this->load->model('model_perusahaan');
	}
	//Tampilkan seluruh pengaduan client yang bersangkutan
	public function index() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$d['judul']="Data Pengaduan";
			$d['class'] = "tampil_pengaduan";
			$d['data'] = $this->model_ticketing_client->all($this->session->userdata('username'));
			$d['content'] = 'ticketing/view_pengaduan_client';
			$this->load->view('hd_adm_home',$d);
		}else{
			redirect('login','refresh');
		}
	}

	//Tampilkan form tambah pengaduan
	public function tambah() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$d['judul']="Tambah Tiket Client";
			$d['class'] = "ticketing";
			$d['tanggal'] = date("Y-m-d");
			$d['content'] = 'ticketing/view_tambah_pengaduan_client';
			$this->load->view('hd_adm_home',$d);
		}else{
			redirect('login','refresh');
		}
	}
	
	//Menyimpan data pengaduan
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
			
			$this->model_ticketing_client->insert_pengaduan($dt);
			echo 'Pengaduan Berhasil';
            redirect('hd_adm_ticketing_client','refresh');

		}else{
			redirect('login','refresh');
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
