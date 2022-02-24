<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_target_penjualan extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_target_penjualan');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
      $d['judul']=" Data Target Penjualan";
			$d['class'] = "penjualan";
      $d['data'] = $this->model_target_penjualan->all();
			$d['data_detail'] = $this->model_target_penjualan->all_detail();
      $d['id_target_penjualan'] = '1';
			$d['content'] = 'komisi_penjualan/target_penjualan/half_add';
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

  public function cari_detail()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_target_penjualan_detail']	= $this->input->get('cari');
			if($this->model_target_penjualan->ada_detail($id)) {
				$dt = $this->model_target_penjualan->get_detail($id);
				$d['id_target_penjualan_detail']	= $dt->id_target_penjualan_detail;
				$d['nama_target']	= $dt->nama_target;
				$d['jumlah_target'] = $dt->jumlah_target;
				echo json_encode($d);

			} else {
				$d['id_target_penjualan_detail']	= '';
				$d['nama_target']	= '';
				$d['jumlah_target']	= '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function simpan_detail()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
      $id['id_target_penjualan_detail']= $this->input->post('id_target_penjualan_detail');
			$dt['id_target_penjualan']= $this->input->post('id_target_penjualan');
			$dt['nama_target'] 	= $this->input->post('nama_target');
			$dt['jumlah_target'] 	= remove_separator2($this->input->post('jumlah_target'));
			if($this->model_target_penjualan->ada_detail($id)){
				$this->model_target_penjualan->update_detail($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_target_penjualan_detail'] = $this->model_target_penjualan->cari_max_target_penjualan_detail();
				$this->model_target_penjualan->insert_detail($dt);
				echo "Data Sukses diSimpan";
			}
		}else{
			redirect('henkel','refresh');
		}
	}


	public function baru(){
		$id['id_t_program_penjualan']=$this->input->post('id_new');
		if($this->model_program_penjualan->t_ada_program_penjualan($id))
		{
			$this->db_kpp->delete("t_program_penjualan",$id);
		}
	}

  public function simpan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_target_penjualan']= $this->input->post('id');
			$dt['target_keseluruhan'] 	= remove_separator2($this->input->post('target_keseluruhan'));
			$id_target_penjualan = $this->input->post('id');
			$target_keseluruhan = remove_separator2($this->input->post('target_keseluruhan'));
			if($this->model_target_penjualan->ada($id)){
				 $this->db_kpp->query("UPDATE target_penjualan
											  			 SET target_keseluruhan='$target_keseluruhan'
															 WHERE id_target_penjualan='$id_target_penjualan'");
				 echo "Data Sukses diUpdate";
			}else{
				$dt['id_target_penjualan'] 	= $this->model_target_penjualan->cari_max_target_penjualan();
				$this->model_target_penjualan->insert($dt);
				echo "Data Sukses diSimpan";
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function cek_table(){
		$id['id_target_penjualan']=$this->input->post('id');
		$q 	 = $this->db_kpp->get_where("target_penjualan_detail",$id);
		$row = $q->num_rows();
		echo $row;
	}

  public function hapus_detail()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_target_penjualan_detail']	= $this->uri->segment(3);

			if($this->model_target_penjualan->ada_detail($id))
			{
				$this->model_target_penjualan->delete_detail($id);
			}
		}
		else
		{
			redirect('henkel','refresh');
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
