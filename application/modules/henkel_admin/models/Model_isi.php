<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_isi extends CI_Model {

  public function n_stok_kritis(){
		$q = $this->db_kpp->query("SELECT COUNT(id) as id FROM n_stok_kritis");
		foreach($q->result() as $dt){
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}

  public function n_jt(){
		$q = $this->db_kpp->query("SELECT COUNT(id) as id FROM n_jt");
		foreach($q->result() as $dt){
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}

  public function n_jt_inv_supp(){
		$q = $this->db_kpp->query("SELECT COUNT(id) as id FROM n_jt_inv_supp");
		foreach($q->result() as $dt){
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}

  public function data_n_stok_kritis(){
		$this->db_kpp->select('nsk.*,o.nama_item,o.stock_kritis,g.nama_gudang')
         ->from('n_stok_kritis nsk')
         ->join('item o', 'nsk.kode_item = o.kode_item')
         ->join('gudang g', 'nsk.kode_gudang = g.kode_gudang');
		$q = $this->db_kpp->get();
		return $q;
	}

  public function data_n_jt(){
		$this->db_kpp->select('njt.*,p.nama_pelanggan')
         ->from('n_jt njt')
         ->join('pelanggan p', 'njt.kode_pelanggan = p.kode_pelanggan');
		$q = $this->db_kpp->get();
		return $q;
	}

  public function data_n_jt_inv_supp(){
		$this->db_kpp->select('njt.*,s.nama_supplier')
         ->from('n_jt_inv_supp njt')
         ->join('supplier s', 'njt.kode_supplier = s.kode_supplier');
		$q = $this->db_kpp->get();
		return $q;
	}

  public function data_jabatan_karyawan(){
		$this->db_kpp->select('id_jabatan_karyawan, nik, nama_karyawan, jabatan_karyawan')
         ->from('jabatan_karyawan');
		$q = $this->db_kpp->get();
		return $q;
	}

  public function jml_data($table){
    $q = $this->db_kpp->get($table);
    return $q->num_rows();
  }

  public function create_category_penjualan(){

		$where = "WHERE tgl<=now()";
		/*if(!empty($id_perusahaan)){
			$where .=" AND id_perusahaan='$id_perusahaan'";
		}*/
		$q = $this->db_kpp->query("SELECT MONTH(tgl) as bln FROM pesanan_penjualan  $where GROUP BY MONTH(tgl) order by tgl DESC LIMIT 12");
    $nama_bln = array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		foreach($q->result() as $dt){
			$hasil[] = $nama_bln[$dt->bln];
		}
		return $hasil;
	}

  public function data_chart_tot_penjualan(){

		$where = "WHERE tgl<=now()";
		$q = $this->db_kpp->query("SELECT SUM(total_akhir) as tot_penjualan FROM pesanan_penjualan $where GROUP BY MONTH(tgl) order by tgl DESC LIMIT 12");

		foreach($q->result() as $dt){
			$hasil[] = (int)$dt->tot_penjualan;
		}
		return $hasil;
	}

  public function create_category_ar(){

		$where = "WHERE tanggal_bayar<=now()";
		/*if(!empty($id_perusahaan)){
			$where .=" AND id_perusahaan='$id_perusahaan'";
		}*/
		$q = $this->db_kpp->query("SELECT MONTH(tanggal_bayar) as bln FROM piutang  $where GROUP BY MONTH(tanggal_bayar) order by tanggal_bayar DESC LIMIT 12");
    $nama_bln = array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		foreach($q->result() as $dt){
			$hasil[] = $nama_bln[$dt->bln];
		}
		return $hasil;
	}

  public function data_chart_tot_ar(){

		$where = "WHERE tanggal_bayar<=now()";
		$q = $this->db_kpp->query("SELECT SUM(bayar) as tot_ar FROM piutang $where GROUP BY MONTH(tanggal_bayar) order by tanggal_bayar DESC LIMIT 12");

		foreach($q->result() as $dt){
			$hasil[] = (int)$dt->tot_ar;
		}
		return $hasil;
	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
