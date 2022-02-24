<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_piutang extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_piutang');
			$this->load->model('model_item');
	}

	public function simpan()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_piutang']= $this->input->post('id_piutang');
			$dt['id_pembayaran_piutang'] = $this->input->post('id_pembayaran_piutang');
			$dt['tanggal_bayar'] = tgl_sql($this->input->post('tanggal_bayar'));
			$dt['no_transaksi'] = $this->input->post('no_penjualan');
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
			$this->model_piutang->update($id, $dt);
			echo "Data Sukses diUpdate";
		}else{
			redirect('henkel','refresh');
		}
	}

	public function simpan_exception()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_piutang_exception_pembayaran']= $this->input->post('id_piutang_exception_pembayaran');
			$dt['tanggal_cair'] = tgl_sql($this->input->post('tanggal_cair'));
			$dt['status'] = $this->input->post('status');
			$bayar = $this->input->post('bayar');
			$no_transaksi = $this->input->post('no_transaksi');
			$this->model_piutang->update_exception($id, $dt);
			$getkodepelanggan = $this->db_kpp->query("SELECT kode_pelanggan FROM pesanan_penjualan WHERE no_transaksi='$no_transaksi'")->row();
			$kode_pelanggan = $getkodepelanggan->kode_pelanggan;
			$this->db_kpp->query("UPDATE pelanggan
			                      	  SET limit_beli=limit_beli+'$bayar'
			                      	  WHERE kode_pelanggan='$kode_pelanggan'");
			$this->db_kpp->query("UPDATE pesanan_penjualan
			                      	  SET sisa_o=sisa_o-'$bayar'
			                      	  WHERE no_transaksi='$no_transaksi'");
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
			date_default_timezone_set('Asia/Makassar');
			$dt['id_pembayaran_piutang'] = $this->input->post('id_pembayaran_piutang');
			$dt['tanggal_bayar'] = tgl_sql($this->input->post('tanggal_bayar'));
			$dt['no_transaksi'] = $this->input->post('no_penjualan');
			$dt['diskon'] = $this->input->post('diskon');
			$jenis_pembayaran = $this->input->post('jenis_pembayaran');
			$dt['keterangan_bayar'] = $this->input->post('keterangan_bayar');
			$total_sisa = $this->input->post('kembali');
			$bayar=remove_separator2($this->input->post('bayar'));
			$total=remove_separator2($this->input->post('total'));
			$no_transaksi = $this->input->post('no_penjualan');
			$dt['bayar'] = $bayar;
			$check_bgcek  = strtolower($jenis_pembayaran);


			if (strpos($check_bgcek, 'cek') !== false || strpos($check_bgcek, 'bg') !== false) {
				$dt['id_t_piutang_exception_pembayaran']= $this->input->post('id_piutang');
				$dt['jenis_pembayaran'] = $this->input->post('jenis_pembayaran');
				$id = $this->input->post('id_piutang');
				$dt['sisa']=$total;
				$dt['total_sisa'] = $total;
				$this->db_kpp->query("DELETE FROM t_piutang
										  WHERE id_t_piutang='$id'");
				$this->model_piutang->t_insert_exception($dt);

				echo "Data Sukses diSimpan";
			} else {
				if($bayar>$total){
			  		$dt['total_sisa']=0;
				}else {
					$dt['total_sisa'] = remove_separator2($total_sisa);
				}
				$id['id_t_piutang']= $this->input->post('id_piutang');
				$getkodepelanggan = $this->db_kpp->query("SELECT kode_pelanggan FROM pesanan_penjualan WHERE no_transaksi='$no_transaksi'")->row();
				$kode_pelanggan = $getkodepelanggan->kode_pelanggan;
				$this->db_kpp->query("UPDATE pelanggan
			                      SET limit_beli=limit_beli+'$bayar'
			                      WHERE kode_pelanggan='$kode_pelanggan'");
				$this->model_piutang->t_update($id, $dt);
			}

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
			$id['id_piutang']	= $this->input->get('cari');
			$id2	= $this->input->get('cari');
			if($this->model_piutang->ada($id)) {
				$dt = $this->model_piutang->get($id2);
				$d['id_piutang'] = $dt->id_piutang;
				$d['id_pembayaran_piutang'] = $dt->id_pembayaran_piutang;
				$d['tanggal_bayar'] = $dt->tanggal_bayar;
				$d['no_penjualan'] = $dt->no_transaksi;
				$d['bayar'] = separator_harga2($dt->bayar);
				$d['kredit'] = separator_harga2($dt->sisa);
				$d['sisa'] = separator_harga2(($dt->sisa)-($dt->bayar));
				$d['diskon']	= $dt->diskon;
				echo json_encode($d);
			} else {
				$d['id_piutang']	= '';
				$d['id_pembayaran_piutang']	= '';
				$d['no_penjualan']	= '';
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

	public function cari_exception()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_piutang_exception_pembayaran']	= $this->input->get('cari');
			$id2	= $this->input->get('cari');
			if($this->model_piutang->ada_exception($id)) {
				$dt = $this->model_piutang->get_exception($id2);
				$d['id_piutang_exception_pembayaran'] = $dt->id_piutang_exception_pembayaran;
				$d['no_transaksi'] = $dt->no_transaksi;
				$d['tanggal_bayar'] = $dt->tanggal_bayar;
				$d['janji_bayar'] = $dt->bayar;
				$d['tanggal_cair'] = $dt->tanggal_cair;
				$d['status'] = $dt->status;
				echo json_encode($d);
			} else {
				$d['id_piutang']	= '';
				$d['id_pembayaran_piutang']	= '';
				$d['janji_bayar']	= '';
				$d['no_penjualan']	= '';
				$d['status']	= '';
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
			$id['id_t_piutang']	= $this->input->get('cari');
			$id2	= $this->input->get('cari');
			if($this->model_piutang->t_ada($id)) {
				$dt = $this->model_piutang->t_get($id2);
				$d['id_t_piutang'] = $dt->id_t_piutang;
				$d['id_pembayaran_piutang'] = $dt->id_pembayaran_piutang;
				$d['tanggal_bayar'] = $dt->tanggal_bayar;
				$d['no_penjualan'] = $dt->no_transaksi;
				$d['bayar'] = separator_harga2($dt->bayar);
				$d['kredit'] = separator_harga2($dt->sisa);
				$d['sisa'] = separator_harga2(($dt->sisa)-($dt->bayar));
				$d['diskon']	= $dt->diskon;
				echo json_encode($d);
			} else {
				$d['id_t_piutang']	= '';
				$d['id_pembayaran_piutang']	= '';
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

	public function t_cari_exception()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_t_piutang_exception_pembayaran']	= $this->input->get('cari');
			$id2	= $this->input->get('cari');
			if($this->model_piutang->t_ada_exception($id)) {
				$dt = $this->model_piutang->t_get_exception($id2);
				$d['id_t_piutang_exception_pembayaran'] = $dt->id_t_piutang_exception_pembayaran;
				$d['id_pembayaran_piutang'] = $dt->id_pembayaran_piutang;
				$d['tanggal_bayar'] = $dt->tanggal_bayar;
				$d['no_penjualan'] = $dt->no_transaksi;
				$d['bayar'] = separator_harga2($dt->bayar);
				$d['kredit'] = separator_harga2($dt->sisa);
				$d['sisa'] = separator_harga2(($dt->sisa)-($dt->bayar));
				$d['diskon']	= $dt->diskon;
				$d['jenis_pembayaran']	= $dt->jenis_pembayaran;
				$d['keterangan_bayar']	= $dt->keterangan_bayar;
				echo json_encode($d);
			} else {
				$d['id_t_piutang_exception_pembayaran']	= '';
				$d['id_pembayaran_piutang']	= '';
				$d['tanggal_bayar']	= '';
				$d['no_penjualan']	= '';
				$d['kredit']	= '';
				$d['bayar']	= '';
				$d['sisa'] = '';
				$d['diskon']	= '';
				$d['jenis_pembayaran']= '';
				$d['keterangan_bayar']= '';
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
