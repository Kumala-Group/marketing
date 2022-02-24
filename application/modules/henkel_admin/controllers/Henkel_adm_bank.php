<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_bank extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_bank');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Data Bank";
			$d['class'] = "master";
			$d['data'] = $this->model_bank->all();
			$d['kode_bank'] = $this->create_kd();
			$d['content'] = 'bank/view';
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

			$last_kd = $this->model_bank->last_kode();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = "BANK".sprintf("%03s", $no_akhir);
				//echo json_encode($d);
			}else{
				$kd = 'BANK001';
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
			$id['id_bank']= $this->input->post('id_bank');
			$dt['kode_bank'] = $this->input->post('kode_bank');
			$dt['bank'] = $this->input->post('bank');
			$dt['no_rekening'] 	= $this->input->post('no_rekening');

			if($this->model_bank->ada($id)){
				$this->model_bank->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_bank'] 	= $this->model_bank->cari_max_bank();
				$this->model_bank->insert($dt);
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
			$id['id_bank']	= $this->input->get('cari');

			if($this->model_bank->ada($id)) {
				$dt = $this->model_bank->get($id);
				//$dt = $this->model_prodi->get2($id);

				$d['id_bank']	= $dt->id_bank;
				$d['kode_bank']	= $dt->kode_bank;
				$d['bank']	= $dt->bank;
				$d['no_rekening']	= $dt->no_rekening;

				echo json_encode($d);
			} else {
				$d['id_bank']		= '';
				$d['kode_bank']		= '';
				$d['bank']		= '';
				$d['no_rekening']		= '';

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
			$id['id_bank']	= $this->uri->segment(3);

			if($this->model_bank->ada($id))
			{
				$this->model_bank->delete($id);
			}
			redirect('henkel_adm_bank','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
