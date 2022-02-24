<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Biodata extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_infobiodata');
	}

	// fungsi default
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$d['judul']   = " Biodata";
			$d['class']   = "pustaka";
			$d['data']    = $this->model_infobiodata->all();
			$d['content'] = 'biodata/view';
			$this->load->view('hd_adm_home',$d);
		}else{
			redirect('login','refresh');
		}
	}

	// fungsi untuk simpan data
	public function simpan()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level == 'karyawan'){

			date_default_timezone_set('Asia/Makassar');

			$input = $this->input->post(NULL, TRUE);

			$id = [
				'' => $input['id_karyawan'],
				'' => $input['inp_nik'],
				'' => $input['inp_nama'],
				'' => $input['inp_jenkel'],
				'' => $input['inp_agama'],
				'' => $input['inp_alamat']
			];

			// die(var_dump($id));

			// $id['id_jenis_hardware']= $this->input->post('id_jenis_hardware');
			// $dt['nama'] 			= $this->input->post('nama');
			// $dt['lokasi']           = $this->input->post('lokasi');
			// $dt['nik']				= $this->input->post('nik');
			// $dt['jabatan']			= $this->input->post('jabatan');

			// if ($this->model_infobiodata->ada($id)) {
			// 	$this->model_infobiodata->update($id, $dt);
			// 	echo "Data Sukses di Update";
			// } else {
			// 	$dt['id_jenis_hardware'] = $this->model_jenis_hardware->cari_max_jenis_hardware();
			// 	$dt['nama'] = $this->model_infobiodata->
			// 	cari_max_jenis_hardware();
			// 	$this->model_jenis_hardware->insert($dt);
			// 	echo "Data Sukses di Simpan";
			// }
		} else {
			redirect('login','refresh');
		}

	}

	// fungsi untuk cari data
	public function cari()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$id['id_jenis_hardware']	= $this->input->get('cari');

			if($this->model_jenis_hardware->ada($id)) {
				$dt = $this->model_jenis_hardware->get($id);
				//$dt = $this->model_prodi->get2($id);

				$d['id_jenis_hardware']	= $dt->id_jenis_hardware;
				$d['nama']	= $dt->nama;

				echo json_encode($d);
			} else {
				$d['id_jenis_hardware']		= '';
				$d['nama']		= '';

				echo json_encode($d);
			}
		}
		else {
			redirect('login','refresh');
		}
	}

	// untuk untuk menghapus data
	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$id['id_jenis_hardware']	= $this->uri->segment(3);

			if($this->model_jenis_hardware->ada($id))
			{
				$this->model_jenis_hardware->delete($id);
			}
			redirect('hd_adm_jenis_hardware','refresh');
		}
		else
		{
			redirect('login','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
