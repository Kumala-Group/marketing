<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_jenis_pembayaran extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_jenis_pembayaran');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Data Jenis Pembayaran";
			$d['class'] = "master";
			$d['data'] = $this->model_jenis_pembayaran->all();
			$d['content'] = 'jenis_pembayaran/view';
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
			$id['id_jenis_pembayaran']= $this->input->post('id_jenis_pembayaran');

			$dt['jenis_pembayaran'] 			= $this->input->post('jenis_pembayaran');

			if($this->model_jenis_pembayaran->ada($id)){
				$this->model_jenis_pembayaran->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_jenis_pembayaran'] 	= $this->model_jenis_pembayaran->cari_max_jenis_pembayaran();
				$this->model_jenis_pembayaran->insert($dt);
				echo "Data Sukses diSimpan";
			}
		}else{
			redirect('henkel','refresh');
		}

	}

	public function cari()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_jenis_pembayaran']	= $this->input->get('cari');

			if($this->model_jenis_pembayaran->ada($id)) {
				$dt = $this->model_jenis_pembayaran->get($id);
				//$dt = $this->model_prodi->get2($id);

				$d['id_jenis_pembayaran']	= $dt->id_jenis_pembayaran;
				$d['jenis_pembayaran'] 	= $dt->jenis_pembayaran;

				echo json_encode($d);
			} else {
				$d['id_jenis_pembayaran']		= '';
				$d['jenis_pembayaran']  	= '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_jenis_pembayaran']	= $this->uri->segment(3);

			if($this->model_jenis_pembayaran->ada($id))
			{
				$this->model_jenis_pembayaran->delete($id);
			}
			redirect('henkel_adm_jenis_pembayaran','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
