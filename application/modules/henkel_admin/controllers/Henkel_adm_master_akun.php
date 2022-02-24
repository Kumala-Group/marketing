<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_master_akun extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_master_akun');
			$this->load->model('model_p_akun_group');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Master Akun";
			$d['class'] = "akuntansi";
			$d['data'] = $this->model_master_akun->all();
			$d['content'] = 'master_akun/view';
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function parent($id,$id2)
	{
		$id	= $id;
		$id2	= $id2;
		$parent=$this->model_master_akun->getParent($id,$id2);
		if(count($parent)>0){
			$output='';
			$output.='<option value="">-- Pilih Parent --</option>';
			foreach ($parent as $dt) {
				$output.='<option value="'.$dt->kode_akun.'">'.$dt->nama_akun.'</option>';
			}
		}else {
			$output='';
			$output.='<option value="">-- Pilih Parent --</option>';
		}
		return $output;
	}

	public function search_parent()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
		$id	= $this->input->post('level');
		$id2	= $this->input->post('akun_group');
		$parent=$this->parent($id,$id2);
		echo json_encode($parent);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function max_kode_akun()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id	= $this->input->post('akun_group');
			$cek=$this->model_master_akun->cek_group_akun($id);
			if(count($cek)>0){
				$kode_akun=$this->model_master_akun->max_kode_akun($id);
				$d['kode_akun']=$kode_akun;
				echo json_encode($d);
			}else {
				$d['kode_akun']=$id;
				echo json_encode($d);
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function max_kode_akun_parent()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id	= $this->input->post('level');
			$id2	= $this->input->post('parent');
			$kode_akun=$this->model_master_akun->max_kode_akun_parent($id,$id2);
			$d['kode_akun']=$kode_akun;
			echo json_encode($d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function cari()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_akun']	= $this->input->get('cari');
			if($this->model_master_akun->ada($id)) {
				$dt = $this->model_master_akun->get($id);
				$level = $dt->level;
				$kode_akun_group= $dt->kode_akun_group;
				$d['id_akun']	= $dt->id_akun;
				$d['akun_group'] 	= $kode_akun_group;
				$d['level'] 	= $level;
				$d['parent']=$this->parent($level,$kode_akun_group);
				$d['parent2']=$this->model_master_akun->editParent($dt->kode_akun);
				$d['kode_akun'] 	= $dt->kode_akun;
				$d['nama_akun'] 	= $dt->nama_akun;
				echo json_encode($d);
			} else {
				$d['id_akun']	= '';
				$d['akun_group'] 	= '';
				$d['level'] 	= '';
				$d['parent'] 	= '';
				$d['parent2'] 	= '';
				$d['kode_akun'] 	= '';
				$d['nama_akun'] 	= '';
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
			$id['id_akun'] = $this->input->post('id_akun');
			$dt['id_akun'] = $this->input->post('id_akun');
			$dt['kode_akun_group'] = $this->input->post('akun_group');
			$dt['level'] = $this->input->post('level');
			$dt['kode_akun'] = $this->input->post('kode_akun');
			$dt['nama_akun'] = $this->input->post('nama_akun');

			$q = $this->db_kpp->get_where("akun",$id);
			$row = $q->num_rows();
			if($row>0){
				$this->model_master_akun->update($id,$dt);
				echo "Data Sukses di Update";
			}else{
				$this->model_master_akun->insert($dt);
				echo "Data Sukses di Simpan";
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
			$id['id_akun']	= $this->uri->segment(3);
			$id2	= $this->uri->segment(3);

			if($this->model_master_akun->ada($id))
			{
				$this->model_master_akun->delete($id2);
			}
			redirect('henkel_adm_master_akun','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
