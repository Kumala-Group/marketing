<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hd_adm_kontrak extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_kontrak');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$d['judul']=" Data Kontrak";
			$d['class'] = "master";
			$d['data'] = $this->model_kontrak->all();
			$d['content'] = 'kontrak/view';
			$this->load->view('hd_adm_home',$d);
		}else{
			redirect('login','refresh');
		}
	}

	public function simpan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_kontrak']= $this->input->post('id_kontrak');
			$dt['id_kontrak'] 			= $this->input->post('id_kontrak');
			$dt['id_perusahaan'] 			= $this->input->post('cabang');
			$dt['pic'] 			= $this->input->post('pic');
			$dt['jenis_kontrak'] 			= $this->input->post('jenis_kontrak');
			$dt['nama_kontrak'] 			= $this->input->post('nama_kontrak');
			$dt['tarif'] 			= remove_separator($this->input->post('tarif'));
			$dt['awal'] 			= tgl_sql($this->input->post('awal'));
			$dt['akhir'] 			= tgl_sql($this->input->post('akhir'));
			$dt['keterangan'] 			= $this->input->post('keterangan');

			if($this->model_kontrak->ada($id)){
				$this->model_kontrak->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_kontrak'] 	= $this->model_kontrak->cari_max_kontrak();
				$this->model_kontrak->insert($dt);
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
		if(!empty($cek) && $level=='karyawan'){
			$id['id_kontrak']	= $this->input->get('cari');

			if($this->model_kontrak->ada($id)) {
				$dt = $this->model_kontrak->get($id);
				//$dt = $this->model_prodi->get2($id);

				$d['id_kontrak']	= $dt->id_kontrak;
				$d['id_perusahaan']	= $dt->id_perusahaan;
				$d['pic']	= $dt->pic;
				$d['jenis_kontrak']	= $dt->jenis_kontrak;
				$d['nama_kontrak']	= $dt->nama_kontrak;
				$d['tarif']	= separator_harga($dt->tarif);
				$d['awal']	= tgl_sql($dt->awal);
				$d['akhir']	= tgl_sql($dt->akhir);
				$d['keterangan']	= $dt->keterangan;

				echo json_encode($d);
			} else {
				$d['id_kontrak']	= '';
				$d['id_perusahaan']	= '';
				$d['pic']	= '';
				$d['jenis_kontrak']	= '';
				$d['nama_kontrak']	= '';
				$d['tarif']	= '';
				$d['awal']	= '';
				$d['akhir']	= '';
				$d['keterangan']	= '';

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
		if(!empty($cek) && $level=='karyawan'){
			$id['id_kontrak']	= $this->uri->segment(3);

			if($this->model_kontrak->ada($id))
			{
				$this->model_kontrak->delete($id);
			}
			redirect('hd_adm_kontrak','refresh');
		}
		else
		{
			redirect('login','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
