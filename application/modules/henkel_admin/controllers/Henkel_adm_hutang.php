<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_hutang extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_hutang');
			$this->load->model('model_item');
	}

	public function simpan()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_hutang']= $this->input->post('id_hutang');
			$dt['id_pembayaran_hutang'] = $this->input->post('id_pembayaran_hutang');
			$dt['tanggal_bayar'] = tgl_sql($this->input->post('tanggal_bayar'));
			$dt['no_invoice'] = $this->input->post('no_pembelian');
			$dt['diskon'] = $this->input->post('diskon');
			$total_sisa = $this->input->post('kembali');
			$bayar=remove_separator2($this->input->post('bayar'));
			$total=remove_separator2($this->input->post('total'));
			$dt['bayar'] = $bayar;
			if($bayar>=$total){
			  $dt['total_sisa']=0;
			}else {
				$dt['total_sisa'] = remove_separator2($total_sisa);
			}
			$this->model_hutang->update($id, $dt);
			echo "Data Sukses diUpdate";
		}else{
			redirect('henkel','refresh');
		}
	}

	public function t_simpan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_t_hutang']= $this->input->post('id_hutang');
			$dt['id_pembayaran_hutang'] = $this->input->post('id_pembayaran_hutang');
			$dt['tanggal_bayar'] = tgl_sql($this->input->post('tanggal_bayar'));
			$dt['no_invoice'] = $this->input->post('no_invoice');
			$dt['diskon'] = $this->input->post('diskon');
			$total_sisa = $this->input->post('kembali');
			$bayar=remove_separator2($this->input->post('bayar'));
			$total=remove_separator2($this->input->post('total'));
			$dt['bayar'] = $bayar;
			if($bayar>$total){
			  $dt['total_sisa']=0;
			}else {
				$dt['total_sisa'] = remove_separator2($total_sisa);
			}
			$this->model_hutang->t_update($id, $dt);
			echo "Data Sukses diUpdate";
		}else{
			redirect('henkel','refresh');
		}

	}

	public function cari()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_hutang']	= $this->input->get('cari');
			$id2	= $this->input->get('cari');
			if($this->model_hutang->ada($id)) {
				$dt = $this->model_hutang->get($id2);
				$d['id_hutang'] = $dt->id_hutang;
				$d['id_pembayaran_hutang'] = $dt->id_pembayaran_hutang;
				$d['tanggal_bayar'] = $dt->tanggal_bayar;
				$d['no_pembelian'] = $dt->no_invoice;
				$d['bayar'] = separator_harga2($dt->bayar);
				$d['kredit'] = separator_harga2($dt->sisa);
				$d['sisa'] = separator_harga2(($dt->sisa)-($dt->bayar));
				$d['diskon']	= $dt->diskon;
				echo json_encode($d);
			} else {
				$d['id_hutang']	= '';
				$d['id_pembayaran_hutang']	= '';
				$d['tanggal_bayar']	= '';
				$d['no_pembelian']	= '';
				$d['kredit']	= '';
				$d['bayar']	= '';
				$d['sisa'] = '';
				$d['diskon']	= '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function t_cari()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_t_hutang']	= $this->input->get('cari');
			$id2	= $this->input->get('cari');
			if($this->model_hutang->t_ada($id)) {
				$dt = $this->model_hutang->t_get($id2);
				$d['id_t_hutang'] = $dt->id_t_hutang;
				$d['id_pembayaran_hutang'] = $dt->id_pembayaran_hutang;
				$d['tanggal_bayar'] = $dt->tanggal_bayar;
				$d['no_invoice'] = $dt->no_invoice;
				$d['bayar'] = separator_harga2($dt->bayar);
				$d['kredit'] = separator_harga2($dt->sisa);
				$d['sisa'] = separator_harga2(($dt->sisa)-($dt->bayar));
				$d['diskon']	= $dt->diskon;
				echo json_encode($d);
			} else {
				$d['id_t_hutang']	= '';
				$d['id_pembayaran_hutang']	= '';
				$d['tanggal_bayar']	= '';
				$d['no_penjualan']	= '';
				$d['kredit']	= '';
				$d['bayar']	= '';
				$d['sisa'] = '';
				$d['diskon']	= '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
