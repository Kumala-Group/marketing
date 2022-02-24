<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_lap_penjualan extends CI_Model {


  public function data_laporan_penjualan($tgl_awal, $tgl_akhir, $kode_pelanggan){
    $where='';
    if ($tgl_awal!='' && $tgl_akhir!='' && $kode_pelanggan!='') {
      $where = "WHERE (pp.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND kode_pelanggan='$kode_pelanggan') ";
    } elseif ($tgl_awal!='' && $tgl_akhir!='') {
    $where = "WHERE (pp.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir') ";
    } elseif ($tgl_awal=='' && $tgl_akhir=='' && $kode_pelanggan!=''){
      $where = "WHERE kode_pelanggan='$kode_pelanggan' ";
    }

		$q = $this->db_kpp->query("SELECT pp.*
                               FROM pesanan_penjualan pp
                               $where");
		return $q;
	}

  public function data_disp_laporan_penjualan_detail($tgl_awal, $tgl_akhir, $kode_pelanggan){

    $where='';
    if ($tgl_awal!='' && $tgl_akhir!='' && $kode_pelanggan!='') {
      $where = "WHERE (pp.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND kode_pelanggan='$kode_pelanggan') ";
    } elseif ($tgl_awal!='' && $tgl_akhir!='') {
    $where = "WHERE (pp.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir') ";
    } elseif ($tgl_awal=='' && $tgl_akhir=='' && $kode_pelanggan!=''){
      $where = "WHERE kode_pelanggan='$kode_pelanggan' ";
    }

		$q = $this->db_kpp->query("SELECT pp.*,p.kode_item,p.qty,o.harga_tebus_dpp
                               FROM pesanan_penjualan pp
                               JOIN penjualan p ON pp.id_pesanan_penjualan=p.id_pesanan_penjualan
                               JOIN item o ON p.kode_item=o.kode_item
                               $where
                               GROUP BY no_transaksi");
		return $q;
	}

  public function data_laporan_penjualan_detail($tgl_awal, $tgl_akhir, $kode_pelanggan){

    $where='';
    if ($tgl_awal!='' && $tgl_akhir!='' && $kode_pelanggan!='') {
      $where = "WHERE (pp.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND kode_pelanggan='$kode_pelanggan') ";
    } elseif ($tgl_awal!='' && $tgl_akhir!='') {
    $where = "WHERE (pp.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir') ";
    } elseif ($tgl_awal=='' && $tgl_akhir=='' && $kode_pelanggan!=''){
      $where = "WHERE kode_pelanggan='$kode_pelanggan' ";
    }

		$q = $this->db_kpp->query("SELECT pp.*,p.kode_item
                               FROM pesanan_penjualan pp
                               JOIN penjualan p ON pp.id_pesanan_penjualan=p.id_pesanan_penjualan
                               $where
                               GROUP BY no_transaksi");
		return $q;
	}

  public function kode_item($id_item_masuk){
    $q = $this->db_kpp->query("SELECT kode_item FROM item_masuk_detail WHERE id_item_masuk='$id_item_masuk'");
    $rows = $q->num_rows();

    if ($rows > 0){
      $results = $q->result();
      return $results[0];
    } else {
      return null;
    }
	}

  public function data_laporan_penjualan_item($tgl_awal, $tgl_akhir){
    $where = "WHERE (pp.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir') ";

		$q = $this->db_kpp->query("SELECT pp.*,p.kode_item,SUM(p.qty) AS total_item_item_masuk,o.nama_item,o.tipe,o.harga_tebus_dpp
                               FROM pesanan_penjualan pp
                               JOIN penjualan p ON pp.id_pesanan_penjualan=p.id_pesanan_penjualan
                               JOIN item o ON p.kode_item=o.kode_item
                               $where
                               GROUP BY p.kode_item");
		return $q;
	}

  public function data_laporan_penjualan_pelanggan($tgl_awal, $tgl_akhir){
    $where = "WHERE (pp.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir') ";

		$q = $this->db_kpp->query("SELECT pp.*,p.kode_item,SUM(p.qty) AS total_item_item_masuk,o.nama_item,o.tipe,o.harga_tebus_dpp
                               FROM pesanan_penjualan pp
                               JOIN penjualan p ON pp.id_pesanan_penjualan=p.id_pesanan_penjualan
                               JOIN item o ON p.kode_item=o.kode_item
                               $where
                               GROUP BY pp.kode_pelanggan, p.kode_item ");
		return $q;
	}

  public function data_cetak_laporan_penjualan_pelanggan($tgl_awal, $tgl_akhir){
    $where = "WHERE (pp.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir') ";

		$q = $this->db_kpp->query("SELECT pp.kode_pelanggan,p.kode_item,SUM(p.qty) AS total_item_item_masuk,o.nama_item,o.tipe,o.harga_tebus_dpp
                               FROM pesanan_penjualan pp
                               JOIN penjualan p ON pp.id_pesanan_penjualan=p.id_pesanan_penjualan
                               JOIN item o ON p.kode_item=o.kode_item
                               $where
                               GROUP BY pp.kode_pelanggan, p.kode_item");
		return $q;
	}

  public function data_laporan_penjualan_sales($tgl_awal, $tgl_akhir){
    $where = "WHERE (pp.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir') ";

		$q = $this->db_kpp->query("SELECT pp.*,p.kode_item,SUM(p.qty) AS total_item_item_masuk,o.nama_item,o.tipe,o.harga_tebus_dpp
                               FROM pesanan_penjualan pp
                               JOIN penjualan p ON pp.id_pesanan_penjualan=p.id_pesanan_penjualan
                               JOIN item o ON p.kode_item=o.kode_item
                               $where
                               GROUP BY pp.kode_pelanggan, p.kode_item ");
		return $q;
	}

  public function get_karyawan(){
    $this->db->select('nik,nama_karyawan');
    $this->db->from('kmg.karyawan k')
             ->where("k.id_perusahaan=20");
    $q = $this->db->get();
   return $q;
  }

  public function get_karyawan_kosong(){
    $this->db_kpp->select('*');
    $this->db_kpp->from('t_karyawan_komisi k');
    $q = $this->db_kpp->get();
   return $q;
  }

  public function get_nama_pelanggan($kode_pelanggan){
		$this->db_kpp->where('kode_pelanggan',$kode_pelanggan);
		$q=$this->db_kpp->get('pelanggan');
		 if($q->num_rows()>0){
            foreach($q->result() as $dt){
                $hasil = $dt->nama_pelanggan;
            }
        }else{
            $hasil = '';
        }
		return $hasil;
	}
}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
