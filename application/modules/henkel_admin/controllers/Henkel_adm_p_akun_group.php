<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_p_akun_group extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('model_p_akun_group');
	}

	public function index()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']		= "Jenis Akun";
			$d['class'] 	= "akuntansi";
			$d['content'] 	= 'pustaka/view_p_akun_group';
			$d['data'] = $this->model_p_akun_group->all();
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function cari()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_akun_group']	= $this->input->get('cari');

			if($this->model_p_akun_group->ada($id)) {
				$dt = $this->model_p_akun_group->get($id);
				$d['id_akun_group'] 	= $dt->id_akun_group;
				$d['nama_group_akun'] 	= $dt->nama_group_akun;
				$d['kode_akun_group'] 	= $dt->kode_akun_group;
				$d['deskripsi'] 		= $dt->deskripsi;

				echo json_encode($d);
			} else {
				$d['id_akun_group'] 	= '';
				$d['nama_group_akun'] 	= '';
				$d['kode_akun_group'] 	= '';
				$d['deskripsi'] 		= '';
				/*$d['cari_perusahaan']	= '';*/
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function simpan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_akun_group']= $this->input->post('id_akun_group');

			$dt['nama_group_akun'] 	= $this->input->post('nama_akun_group');
			$dt['kode_akun_group'] 	= $this->input->post('kode_akun_group');
			$dt['deskripsi']	= $this->input->post('deskripsi');

			if($this->model_p_akun_group->ada($id)){
				$dt['id_akun_group'] 	= $this->input->post('id_akun_group');
				$this->model_p_akun_group->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{

				$dt['id_akun_group'] 	= $this->model_p_akun_group->cari_max_akun_group();
				$this->model_p_akun_group->insert($dt);
				echo "Data Sukses diSimpan";
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
			$id['id_akun_group']	= $this->uri->segment(3);
			$id2 = $this->uri->segment(3);

			if($this->model_p_akun_group->ada($id))
			{
				$this->model_p_akun_group->delete($id2);
			}
			redirect('henkel_adm_p_akun_group','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
