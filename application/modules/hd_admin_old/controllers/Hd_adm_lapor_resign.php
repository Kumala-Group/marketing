<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wuling_adm_sales_supervisor extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_adm_team_supervisor');
      $this->load->model('model_adm_sales');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='wuling_admin_sales'){
			$d['judul']="Data Team Supervisor";
			$d['class'] = "master";
			$d['data'] = $this->model_adm_team_supervisor->all();
			$d['content'] = 'adm_supervisor/view';
			$this->load->view('wuling_adm_sales_home',$d);
		}else{
			redirect('login','refresh');
		}
	}

  public function tambah_team()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='wuling_admin_sales'){
			$d['judul']="Tambah Team";
			$d['class'] = "master";
      $id_perusahaan=$this->input->get('id_perusahaan');
      $nama=$this->input->get('nama');
      $id_leader=$this->input->get('id_leader');
      $d['nama'] =$nama;
      $d['id_leader'] =$id_leader;
			$d['data'] = $this->model_adm_sales->sales_per_cabang($id_perusahaan);
			$d['content'] = 'adm_supervisor/add';
			$this->load->view('wuling_adm_sales_home',$d);
		}else{
			redirect('login','refresh');
		}
	}

	public function detail_team()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='wuling_admin_sales'){
			$d['judul']="Team";
			$d['class'] = "master";
      $nama=$this->uri->segment(4);
      $id_leader=$this->uri->segment(3);
      $d['nama'] =$nama;
			$d['data'] = $this->model_adm_sales->sales_per_team_supervisor($id_leader);
			$d['content'] = 'adm_supervisor/detail';
			$this->load->view('wuling_adm_sales_home',$d);
		}else{
			redirect('login','refresh');
		}
	}

	public function simpan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='wuling_admin_sales'){
			$id['id_team_supervisor']= $this->input->post('id_team_supervisor');
			$dt['id_perusahaan'] 			= $this->input->post('cabang');
			$dt['nama_team'] 			= $this->input->post('nama_team');
			$supervisor=$this->input->post('id_supervisor');
			$dt['id_supervisor'] 			= $supervisor;

			$ids['id_sales'] 			= $supervisor;
			$dts['status_leader'] 			= 's';

			if($this->model_adm_team_supervisor->ada($id)){
				$this->model_adm_team_supervisor->update($id, $dt);
				$this->db_wuling->update("adm_sales",$dts,$ids);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_team_supervisor'] 	= $this->model_adm_team_supervisor->cari_max_adm_team_supervisor();
				$this->model_adm_team_supervisor->insert($dt);
				$this->db_wuling->update("adm_sales",$dts,$ids);
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
		if(!empty($cek) && $level=='wuling_admin_sales'){
			$id['id_team_supervisor']	= $this->input->get('cari');

			if($this->model_adm_team_supervisor->ada($id)) {
				$dt = $this->model_adm_team_supervisor->get($id);
				$d['id_team_supervisor']	= $dt->id_team_supervisor;
				$d['nama_team']	= $dt->nama_team;
				$d['cabang']	= $dt->id_perusahaan;
				$d['id_supervisor']	= $dt->id_supervisor;
				$d['supervisor']	= $this->model_data->get_nama_karyawan($dt->id_supervisor);
				echo json_encode($d);
			} else {
				$d['id_team_supervisor']		= '';
				$d['nama_team']		= '';
				$d['cabang'] = '';
				$d['id_supervisor'] = '';
				$d['supervisor'] = '';

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
		if(!empty($cek) && $level=='wuling_admin_sales'){
			$id['id_team_supervisor']	= $this->uri->segment(3);

			if($this->model_adm_team_supervisor->ada($id))
			{
				$this->model_adm_team_supervisor->delete($id);
		    $dt['id_leader'] 			= '0';
		    $ids['id_leader'] = $this->uri->segment(3);
		    $this->db_wuling->update("adm_sales",$dt,$ids);
			}
			redirect('wuling_adm_sales_supervisor','refresh');
		}
		else
		{
			redirect('login','refresh');
		}

	}

  public function simpan_team()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='wuling_admin_sales'){
    $id=$this->input->get('id');
    $id_leader=$this->input->get('id_leader');
    foreach ($id as $dt) {
      $this->db_wuling->query("UPDATE adm_sales SET id_leader='$id_leader' WHERE id_sales='$dt'");
    }
    echo "Data Sukse Di Tambahkan";

		}else{
			redirect('login','refresh');
		}
	}

	public function mutasi()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='wuling_admin_sales'){
			$id['id_sales']= $this->input->post('id_sales');
			$dt['id_leader'] = $this->input->post('ke');
			$this->db_wuling->update("adm_sales",$dt,$id);
			echo "Data Sukses diUpdate";
		}else{
			redirect('login','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
