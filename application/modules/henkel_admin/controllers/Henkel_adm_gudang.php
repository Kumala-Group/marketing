<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_gudang extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_gudang');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Data Gudang";
			$d['class'] = "master";
			$d['data'] = $this->model_gudang->all();
			$d['kode_gudang'] = $this->create_kd();
			$d['content'] = 'gudang/view';
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function create_kd()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){

			$last_kd = $this->model_gudang->last_kode();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = "GUD".sprintf("%03s", $no_akhir);
				//echo json_encode($d);
			}else{
				$kd = 'GUD001';
				//echo json_encode($d);
			}
			return $kd;
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
			$id['id_gudang']= $this->input->post('id_gudang');
			$dt['kode_gudang'] 			= $this->input->post('kode_gudang');
			$dt['nama_gudang'] 			= $this->input->post('nama_gudang');
			$dt['label_gudang'] 			= $this->input->post('label_gudang');
			$dt['alamat'] 			= $this->input->post('alamat');

			if($this->model_gudang->ada($id)){
				$this->model_gudang->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_gudang'] 	= $this->model_gudang->cari_max_gudang();
				$this->model_gudang->insert($dt);
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
			$id['id_gudang']	= $this->input->get('cari');

			if($this->model_gudang->ada($id)) {
				$dt = $this->model_gudang->get($id);
				$d['id_gudang']	= $dt->id_gudang;
				$d['kode_gudang']	= $dt->kode_gudang;
				$d['nama_gudang']	= $dt->nama_gudang;
				$d['label_gudang']	= $dt->label_gudang;
				$d['alamat']	= $dt->alamat;

				echo json_encode($d);
			} else {
				$d['id_gudang']		= '';
				$d['kode_gudang']		= '';
				$d['nama_gudang']		= '';
				$d['label_gudang'] = '';
				$d['alamat'] = '';

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
			$id['id_gudang']	= $this->uri->segment(3);

			if($this->model_gudang->ada($id))
			{
				$this->model_gudang->delete($id);
			}
			redirect('henkel_adm_gudang','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
