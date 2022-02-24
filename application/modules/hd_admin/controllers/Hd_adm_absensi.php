<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hd_adm_absensi extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_absensi');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$d['judul']=" Data Status Absensi";
			$d['class'] = "absensi";
			$d['data'] = $this->model_absensi->allabsen();
			$d['content'] = 'absensi/view';
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
			$id['id_perusahaan']= $this->input->post('id_perusahaan');
			$dt['id_perusahaan'] 			= $this->input->post('id_perusahaan');
			$dt['status'] 			= $this->input->post('status');
			$dt['ket_status'] 			= $this->input->post('ket_status');
			$dt['last_update'] 			= date('Y-m-d H:i:s');

			if($this->model_absensi->ada($id)){
				$this->model_absensi->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_perusahaan'] 	= $this->model_absensi->cari_max_absensi();
				$this->model_absensi->insert($dt);
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
			$id['id_perusahaan']	= $this->input->get('cari');

			if($this->model_absensi->ada($id)) {
				$dt = $this->model_absensi->get($id);
				//$dt = $this->model_prodi->get2($id);

				$d['id_perusahaan']	= $dt->id_perusahaan;
				$d['status']	= $dt->status;
				$d['last_update']	= $dt->last_update;
				$d['ket_status']	= $dt->ket_status;

				echo json_encode($d);
			} else {
				$d['id_perusahaan']		= '';
				$d['status']		= '';
				$d['last_update']		= '';
				$d['ket_status']		= '';

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
			$id['id_perusahaan']	= $this->uri->segment(3);

			if($this->model_absensi->ada($id))
			{
				$this->model_absensi->delete($id);
			}
			redirect('hd_adm_absensi','refresh');
		}
		else
		{
			redirect('login','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
