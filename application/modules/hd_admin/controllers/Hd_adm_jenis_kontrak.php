<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hd_adm_jenis_kontrak extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_jenis_kontrak');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$d['judul']=" Data Jenis Kontrak";
			$d['class'] = "pustaka";
			$d['data'] = $this->model_jenis_kontrak->all();
			$d['content'] = 'jenis_kontrak/view';
			$this->load->view('hd_adm_home',$d);
		}else{
			redirect('login','refresh');
		}
	}

	public function simpan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_jenis_kontrak']= $this->input->post('id_jenis_kontrak');
			$dt['nama'] 			= $this->input->post('nama');

			if($this->model_jenis_kontrak->ada($id)){
				$this->model_jenis_kontrak->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_jenis_kontrak'] 	= $this->model_jenis_kontrak->cari_max_jenis_kontrak();
				$this->model_jenis_kontrak->insert($dt);
				echo "Data Sukses diSimpan";
			}
		}else{
			redirect('login','refresh');
		}

	}

	public function cari()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$id['id_jenis_kontrak']	= $this->input->get('cari');

			if($this->model_jenis_kontrak->ada($id)) {
				$dt = $this->model_jenis_kontrak->get($id);
				//$dt = $this->model_prodi->get2($id);

				$d['id_jenis_kontrak']	= $dt->id_jenis_kontrak;
				$d['nama']	= $dt->nama;

				echo json_encode($d);
			} else {
				$d['id_jenis_kontrak']		= '';
				$d['nama']		= '';

				echo json_encode($d);
			}
		}
		else {
			redirect('login','refresh');
		}
	}

	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$id['id_jenis_kontrak']	= $this->uri->segment(3);

			if($this->model_jenis_kontrak->ada($id))
			{
				$this->model_jenis_kontrak->delete($id);
			}
			redirect('hd_adm_jenis_kontrak','refresh');
		}
		else
		{
			redirect('login','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
