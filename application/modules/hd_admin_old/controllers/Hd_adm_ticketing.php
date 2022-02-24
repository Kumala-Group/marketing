<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hd_adm_ticketing extends CI_Controller {

	public function __construct() {
	    parent::__construct();
		$this->load->model('model_ticketing');
	$this->load->model('model_perusahaan');
	}

	public function index() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$d['judul']=" Data Pengaduan";
			$d['class'] = "ticketing";
			$d['data'] = $this->model_ticketing->all();
			$d['content'] = 'ticketing/view_tiket';
			$this->load->view('hd_adm_home',$d);
		}else{
			redirect('login','refresh');
		}
	}


	public function tambah() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$d = array('judul' 			=> 'Tambah Tiket',
						'class' 		=> 'ticketing',
						'tanggal'=> date("Y-m-d"),

						'perusahaan' => $this->model_perusahaan->data_perusahaan_brand()->result(),
						'content' 		=> 'ticketing/add'
						);
			$this->load->view('hd_adm_home',$d);
		}else{
			redirect('login','refresh');
		}
	}

	public function create_kd() {
		$tanggal = date("y-m");
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){

			$last_kd = $this->model_ticketing->last_kode();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = $tanggal.'/PBL/'.sprintf("%03s", $no_akhir);
				//echo json_encode($d);
			}else{
				$kd = $tanggal.'/PBL/'.'001';
				//echo json_encode($d);
			}
			return $kd;
		}else{
			redirect('login','refresh');
		}
	}

	public function last_kode(){
		$q = $this->db_hd->query("SELECT MAX(right(no_po,3)) as kode FROM ticketing ");
		$row = $q->num_rows();

		if($row > 0){
            $rows = $q->result();
            $hasil = (int)$rows[0]->kode;
        }else{
            $hasil = 0;
        }
		return $hasil;
	}

	public function baru(){
		$id['id_ticketing']=$this->input->post('id_new');
		if($this->model_ticketing->t_ada_id_pesanan($id)) {
			$this->db_hd->delete("t_pengiriman",$id);
		}
	}

	public function cek_table(){
		$id['id_ticketing']=$this->input->post('id_cek');
		$q 	 = $this->db_hd->get_where("t_pengiriman",$id);
		$row = $q->num_rows();
		echo $row;
	}

	public function simpan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
      $id['id_tiket']= $this->input->post('id_tiket');
			date_default_timezone_set('Asia/Makassar');
			$dt['id_tiket']= $this->input->post('id_tiket');
			$dt['id_perusahaan'] 	= $this->input->post('id_perusahaan');
			$dt['nik'] 	= $this->input->post('nik_tiket');
			$dt['tgl_tiket'] 			= tgl_sql($this->input->post('tgl_tiket'));
			$dt['wkt_tiket'] 	= $this->input->post('wkt_tiket');
			$dt['masalah'] 	= $this->input->post('masalah');
			$dt['priority'] 	= $this->input->post('priority');
			$dt['status_tiket'] 	= 'Open';

			if($this->model_ticketing->ada($id)){
				$dt['id_tiket'] 	= $this->input->post('id_tiket');
				$this->model_ticketing->update($id, $dt);
				echo "Tiket Sukses diUpdate";
			}else{
				$dt['id_tiket'] 	= $this->model_ticketing->cari_max_ticketing();
				$this->model_ticketing->insert($dt);
				echo "Tiket Sukses diSimpan";
			}
		}else{
			redirect('login','refresh');
		}

	}

public function t_simpan() {
	$cek = $this->session->userdata('logged_in');
	$level = $this->session->userdata('level');
	if(!empty($cek) && $level=='karyawan'){
		date_default_timezone_set('Asia/Makassar');
		$id['id_ticketing']= $this->input->post('id');
		$dt['no_inv_pengiriman'] = $this->input->post('no_inv_pengiriman');
		$dt['tanggal_pengiriman'] = tgl_sql($this->input->post('tanggal_pengiriman'));
		$dt['biaya_pengiriman'] = remove_separator($this->input->post('biaya_pengiriman'));
			if($this->model_ticketing->ada($id)){
				$this->model_ticketing->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_ticketing'] = $this->input->post('id');
				$id_t=$this->input->post('id');
				$this->db_hd->query("INSERT INTO pengiriman (id_ticketing, id_pesanan_pembelian, no_inv_supplier)
															SELECT id_ticketing, id_pesanan_pembelian, no_inv_supplier
															FROM t_pengiriman
															WHERE id_ticketing='$id_t'");
				$this->db_hd->query("DELETE FROM t_pengiriman WHERE id_ticketing='$id_t'");
				$this->model_ticketing->insert($dt);
				echo "Data Sukses diSimpan";
			}
	}else{
		redirect('login','refresh');
	}
}
public function t_solv_simpan() {
	$cek = $this->session->userdata('logged_in');
	$level = $this->session->userdata('level');
	if(!empty($cek) && $level=='karyawan'){
		date_default_timezone_set('Asia/Makassar');
		$status_tiket = $this->input->post('status_tiket');
		$id_tiket=$this->input->post('id_tiket');
		$dt['id_t_solv'] = $this->input->post('id_t_solv');
		$id_t_solv = $this->input->post('id_t_solv');
		$dt['id_tiket'] = $this->input->post('id_tiket');
		$dt['nik_exe'] = $this->input->post('nik_exe');
		$nik_exe = $this->input->post('nik_exe');
		$this->model_ticketing->insert_t_solv($dt);
		$this->db_helpdesk->query("UPDATE tiket SET status_tiket='$status_tiket' WHERE id_tiket='$id_tiket'");
		echo "Data Sukses diSimpan";

	}else{
		redirect('login','refresh');
	}
}
	public function cari()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='karyawan'){
			$id['id_tiket']	= $this->input->get('cari');
			if($this->model_ticketing->ada($id)) {
				$dt = $this->model_ticketing->get($id);
				$d['id_tiket']	= $dt->id_tiket;
				$d['nik']	= $dt->nik;
				$d['tgl_tiket']	= $dt->tgl_tiket;
				$d['wkt_tiket']	= $dt->wkt_tiket;
				$d['masalah']	= $dt->masalah;
				$d['priority']	= $dt->priority;
				$d['status_tiket']	= $dt->status_tiket;
				$data = $this->db->from('karyawan')->where('nik',$dt->nik)->get();
				foreach($data->result() as $dt_kar)
				{
					$d['nama_karyawan'] = $dt_kar->nama_karyawan;
					$dataa = $this->db->from('perusahaan')->where('id_perusahaan',$dt_kar->id_perusahaan)->get();
					foreach($dataa->result() as $dt_per)
					{

						$d['lokasi'] = $dt_per->lokasi;
						$dataa = $this->db->from('brand')->where('id_brand',$dt_per->id_brand)->get();
						foreach($dataa->result() as $dt_sup)
						{
							$d['nama_brand'] = $dt_sup->nama_brand;
						}
					}
				}
				echo json_encode($d);

			} else {
				$d['id_tiket']		= '';
			$d['nik']	= '';
			$d['nama_karyawan']	= '';
			$d['nama_brand']	= '';
			$d['lokasi']	= '';
			$d['tgl_tiket']	= '';
			$d['wkt_tiket']	= '';
			$d['masalah']	= '';
			$d['priority']	= '';
			$d['status_tiket']	= '';
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
			$id['id_ticketing']	= $this->uri->segment(3);

			if($this->model_ticketing->ada($id))
			{
				$this->model_ticketing->delete($id);
			}
			redirect('hd_adm_ticketing','refresh');
		}
		else
		{
			redirect('login','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
