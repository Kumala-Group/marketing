<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_sales extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('model_sales');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id_perusahaan=$this->session->userdata('id_perusahaan');
			$id_brand=$this->session->userdata('id_brand');
			$d['judul']=" Data Sales";
			$d['class'] = "master";
			$d['data'] =  $this->db->query("SELECT k.nik,k.nama_karyawan,k.id_jabatan,k.alamat,k.email FROM karyawan k INNER JOIN p_divisi pd ON k.id_divisi=pd.id_divisi WHERE k.id_perusahaan='20' AND pd.divisi='SALES' OR k.id_perusahaan='28' AND pd.divisi='SALES'");
			$d['data_sales'] =  $this->db_kpp->query("SELECT id_sales, kode_sales, nama_sales, alamat, email, jabatan FROM sales");
			$d['kode_sales'] = $this->create_kd();
			$d['content'] = 'sales/view';
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

			$last_kd = $this->model_sales->last_kode();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = "SAL".sprintf("%03s", $no_akhir);
			}else{
				$kd = 'SAL001';
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
			$id['id_sales']= $this->input->post('id_sales');

			$dt['kode_sales'] 			= $this->input->post('kode_sales');
			$dt['nama_sales'] 		= $this->input->post('nama_sales');
			$dt['alamat'] 			= $this->input->post('alamat');
			$dt['email'] 			= $this->input->post('email');
			$dt['jabatan'] 			= $this->input->post('jabatan');
			
			$dt['admin'] 		= $this->session->userdata('nama_lengkap');


			if($this->model_sales->ada($id)){
				$dt['w_update'] = date('Y-m-d H:i:s');
				$this->model_sales->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_sales'] 	= $this->model_sales->cari_max_sales();
				$dt['w_insert'] = date('Y-m-d H:i:s');
				$this->model_sales->insert($dt);
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
			$id['id_sales']	= $this->input->get('cari');

			if($this->model_sales->ada($id)) {
				$dt = $this->model_sales->get($id);
				//$dt = $this->model_prodi->get2($id);

				$d['id_sales']	= $dt->id_sales;
				$d['nama_sales'] 	= $dt->nama_sales;
				$d['kode_sales'] 	= $dt->kode_sales;
				$d['alamat']	= $dt->alamat;
				$d['email']	= $dt->email;
				$d['jabatan'] 	= $dt->jabatan;
				echo json_encode($d);
			} else {
				$d['id_sales']		= '';
				$d['nama_sales']  	= '';
				$d['kode_sales'] 	= '';
				$d['alamat']	= '';	
				$d['email']	= '';
				$d['jabatan'] 	= '';
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
			$id['id_sales']	= $this->uri->segment(3);

			if($this->model_sales->ada($id))
			{
				$this->model_sales->delete($id);
			}
			redirect('henkel_adm_sales','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
