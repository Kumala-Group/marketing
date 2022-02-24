<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hd_adm_fingerscan extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_finger');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$d['judul']=" Data Mesin Finger";
			$d['class'] = "fingerscan";
			$d['data'] = $this->model_finger->all();
			$d['content'] = 'finger/view';
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
			$id['id_mesin']= $this->input->post('id_mesin');
            $dt['nama_perangkat'] 			= $this->input->post('nama_perangkat');
            $dt['nama_produk'] 			= $this->input->post('nama_produk');
            $dt['no_serial'] 			= $this->input->post('no_serial');
            $dt['ip_address'] 			= $this->input->post('ip_address');
            $dt['port'] 			= $this->input->post('port');

			if($this->model_finger->ada($id)){
				$this->model_finger->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				// $dt['id_mesin'] 	= $this->model_finger->cari_max_fingerscan();
				$this->model_finger->insert($dt);
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
			$id['id_mesin']	= $this->input->get('cari');

			if($this->model_fingerscan->ada($id)) {
				$dt = $this->model_fingerscan->get($id);
				//$dt = $this->model_prodi->get2($id);

				$d['id_mesin']	= $dt->id_mesin;
				$d['nama']	= $dt->nama;

				echo json_encode($d);
			} else {
				$d['id_mesin']		= '';
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
			$id['id_mesin']	= $this->uri->segment(3);

			if($this->model_fingerscan->ada($id))
			{
				$this->model_fingerscan->delete($id);
			}
			redirect('hd_adm_fingerscan','refresh');
		}
		else
		{
			redirect('login','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
