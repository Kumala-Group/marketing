<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ban_adm extends CI_Controller{

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_ban');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='ban_admin'){
			$d['judul']=" Data Ban";
			$d['class'] = "master";
			$d['data'] = $this->model_ban->all();
			$d['kode_ban'] = $this->create_kd();
			$d['content'] = 'ban/view';
			$this->load->view('ban_adm_home',$d);
		}else{
			redirect('login','refresh');
		}
	}

	public function create_kd()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='ban_admin'){

			$last_kd = $this->model_ban->last_kode();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = "BAN".sprintf("%03s", $no_akhir);
				//echo json_encode($d);
			}else{
				$kd = 'BAN001';
				//echo json_encode($d);
			}
			return $kd;
		}else{
			redirect('login','refresh');
		}

	}

	public function simpan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='ban_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_ban']= $this->input->post('id_ban');
			$dt['kode_ban'] 			= $this->input->post('kode_ban');
			$dt['nama_ban'] 			= $this->input->post('nama_ban');
			$harga_ban = $this->input->post('harga_ban');
			$dt['harga_ban'] 			= remove_separator($harga_ban);
			$dt['kode_satuan'] 			= $this->input->post('satuan');
			$dt['tipe'] 			= $this->input->post('tipe');
			$dt['stock_kritis'] 			= $this->input->post('stock_kritis');

			if($this->model_ban->ada($id)){
				$this->model_ban->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_ban'] 	= $this->model_ban->cari_max_ban();
				$this->model_ban->insert($dt);
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
		if(!empty($cek) && $level=='ban_admin'){
			$id['id_ban']	= $this->input->get('cari');

			if($this->model_ban->ada($id)) {
				$dt = $this->model_ban->get($id);
				$d['id_ban']	= $dt->id_ban;
				$d['kode_ban'] 	= $dt->kode_ban;
				$d['nama_ban'] 	= $dt->nama_ban;
				$d['harga_ban']	= $dt->harga_ban;
				$d['tipe'] = $dt->tipe;
				$kode_satuan=$this->model_ban->getKd_satuan($dt->kode_satuan);
				$data = $this->db_ban->from('satuan')->get();
				if(count($kode_satuan)>0){
					foreach ($kode_satuan as $row) {
						$d['satuan'] ='<option value="'.$row->kode_satuan.'">'.$row->satuan.'</option>';
						$d['satuan'] .='<option value="">--Pilih Satuan--</option>';
							foreach ($data->result() as $dt_satuan) {
								$d['satuan'] .='<option value="'.$dt_satuan->kode_satuan.'">'.$dt_satuan->satuan.'</option>';
							}
					}
				} /*else if(count($id_program_penjualan)<=0){
					foreach ($data->result() as $row) {
								$output ='<option value="">--Pilih Program Penjualan--</option>';
								$output .='<option value="'.$row->id_program_penjualan.'">'.$row->nama_program.'</option>';
					}*/
				$d['stock_kritis']	= $dt->stock_kritis;

				echo json_encode($d);
			} else {
				$d['id_ban']		= '';
				$d['kode_ban']		= $this->create_kd();
				$d['nama_ban']  	= '';
				$d['harga_ban']		= '';
				$d['satuan']		= '';
				$d['tipe'] 			= '';
				$d['stock_kritis']	= '';
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
		if(!empty($cek) && $level=='ban_admin'){
			$id['id_ban']	= $this->uri->segment(3);

			if($this->model_ban->ada($id))
			{
				$this->model_ban->delete($id);
			}
			redirect('ban_adm','refresh');
		}
		else
		{
			redirect('login','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
