<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);

class Henkel_adm_jabatan_karyawan extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_isi');
      $this->load->model('model_jabatan_karyawan');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']="Jabatan Karyawan";
			$d['class'] = "pustaka";
			$d['data'] = $this->model_isi->data_jabatan_karyawan();
			$d['content']= 'pustaka/view_p_jabatan_karyawan';
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

  public function simpan() {
    $cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_jabatan_karyawan']= $this->input->post('id_jabatan_karyawan');
			$dt['nik'] = $this->input->post('nik');
			$dt['nama_karyawan'] = $this->input->post('nama_karyawan');
			$dt['jabatan_karyawan'] = $this->input->post('jabatan_karyawan');

			if($this->model_jabatan_karyawan->ada($id)){
				$this->model_jabatan_karyawan->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_jabatan_karyawan'] 	= $this->model_jabatan_karyawan->cari_max_jabatan_karyawan();
				$this->model_jabatan_karyawan->insert($dt);
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
			$id['id_jabatan_karyawan']	= $this->input->get('cari');
			if($this->model_jabatan_karyawan->ada($id)) {
				$dt = $this->model_jabatan_karyawan->get($id);
				$d['id_jabatan_karyawan']	= $dt->id_jabatan_karyawan;
				$d['nik']	= $dt->nik;
				$d['nama_karyawan'] = $dt->nama_karyawan;
				$d['jabatan_karyawan']	= $dt->jabatan_karyawan;
				echo json_encode($d);

			} else {
				$d['id_jabatan_karyawan']	= '';
				$d['nik']	= '';
				$d['nama_karyawan'] = '';
				$d['jabatan_karyawan'] = '';
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
			$id['id_jabatan_karyawan']	= $this->uri->segment(3);

			$q = $this->db_kpp->get_where("jabatan_karyawan",$id);
			$row = $q->num_rows();
			if($row>0){
				$this->db_kpp->delete("jabatan_karyawan",$id);
			}
			redirect('henkel_adm_jabatan_karyawan','refresh');
		}else{
			redirect('henkel','refresh');
		}

	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
