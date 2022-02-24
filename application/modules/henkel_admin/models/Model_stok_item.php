<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_stok_item extends CI_Model {


 	public function all(){
		$q = $this->db_kpp->get('stok_opname');
		return $q;
	}

	public function get($id){
 		$q 	 = $this->db_kpp->get_where("stok_item",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

 	public function ada($id){
		$q 	 = $this->db_kpp->get_where("stok_item",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

  public function nama_item($id){
    $this->db_kpp->where('kode_item',$id);
    $q=$this->db_kpp->get('item');
     if($q->num_rows()>0){
            foreach($q->result() as $dt){
                $hasil = $dt->nama_item;
            }
        }else{
            $hasil = '';
        }
    return $hasil;
  }

	public function cari_max_stok_item(){
		$q = $this->db_kpp->query("SELECT MAX(id_stock) as no FROM stok_item");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

 	public function insert($dt){
 		$this->db_kpp->insert("stok_opname",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("stok_opname",$dt,$id);
 	}

 	public function delete($id){
 		$this->db_kpp->delete("stok-opname",$id);
 	}

  public function data_stok_awal($kode_item){
		$q = $this->db_kpp->query("
			SELECT tambah_stok AS qty, tanggal
			FROM stok_awal_item
      WHERE kode_item='$kode_item'
      ");
		return $q;
	}

  public function data_stok_masuk($kode_item, $tgl_awal, $tgl_akhir){
		$q = $this->db_kpp->query("
			SELECT im.no_invoice AS no_transaksi, im.tanggal_item_masuk AS tanggal, imd.total_item_item_masuk AS qty
			FROM item_masuk_detail imd
            JOIN item_masuk im ON im.id_item_masuk=imd.id_item_masuk
            WHERE (im.tanggal_item_masuk BETWEEN '$tgl_awal' AND '$tgl_akhir')
            AND imd.kode_item='$kode_item'
            UNION
            SELECT imn.kode_item_masuk_non AS no_transaksi, imn.tanggal_item_masuk_non AS tanggal, imn.jumlah AS qty
            FROM item_masuk_non imn
            WHERE (imn.tanggal_item_masuk_non BETWEEN '$tgl_awal' AND '$tgl_akhir')
            AND imn.kode_item='$kode_item'
            UNION
			SELECT ret_pen.no_transaksi AS no_transaksi, ret_pen.tgl AS tanggal, r_pen.qty_retur AS qty
			FROM r_penjualan r_pen
            JOIN retur_penjualan ret_pen ON ret_pen.id_retur_penjualan = r_pen.id_retur_penjualan
            WHERE (ret_pen.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir')
            AND r_pen.kode_item='$kode_item'
        ");
		return $q;
	}

	public function data_stok_keluar($kode_item, $tgl_awal, $tgl_akhir){
		$q = $this->db_kpp->query("
			SELECT pes_pen.no_transaksi AS no_transaksi, pes_pen.tgl AS tanggal, pen.qty AS qty
			FROM penjualan pen
            JOIN pesanan_penjualan pes_pen ON pes_pen.id_pesanan_penjualan=pen.id_pesanan_penjualan
            WHERE (pes_pen.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir')
            AND pen.kode_item='$kode_item'
            UNION
            SELECT ik.kode_item_keluar AS no_transaksi, ik.tanggal_item_keluar AS tanggal, ik.jumlah AS qty
            FROM item_keluar ik
            WHERE (ik.tanggal_item_keluar BETWEEN '$tgl_awal' AND '$tgl_akhir')
            AND ik.kode_item='$kode_item'
            UNION
			SELECT ret_pem.no_retur AS no_transaksi, ret_pem.tanggal AS tanggal, r_pem.qty_retur AS qty
			FROM r_pembelian r_pem
            JOIN retur_pembelian ret_pem ON ret_pem.id_retur_pembelian = r_pem.id_retur_pembelian
            WHERE (ret_pem.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir')
            AND r_pem.kode_item='$kode_item'
        ");
		return $q;
	}
}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
