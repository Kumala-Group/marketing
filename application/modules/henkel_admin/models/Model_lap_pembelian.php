<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_lap_pembelian extends CI_Model {


  public function data_laporan_pembelian($tgl_awal,$tgl_akhir,$kode_supplier){
    $where='';
    if ($tgl_awal!='' && $tgl_akhir!='' && $kode_supplier!='') {
      $where = "WHERE (om.tanggal_invoice BETWEEN '$tgl_awal' AND '$tgl_akhir' AND kode_supplier='$kode_supplier') ";
    } elseif ($tgl_awal!='' && $tgl_akhir!='') {
    $where = "WHERE (om.tanggal_invoice BETWEEN '$tgl_awal' AND '$tgl_akhir') ";
    } elseif ($tgl_awal=='' && $tgl_akhir=='' && $kode_supplier!=''){
      $where = "WHERE kode_supplier='$kode_supplier' ";
    }
		$q = $this->db_kpp->query("SELECT om.*,SUM(omd.total_item_item_masuk) AS jumlah_item
                               FROM item_masuk om
                               JOIN item_masuk_detail omd ON om.id_item_masuk=omd.id_item_masuk
                               $where
                               GROUP BY no_invoice");
		return $q;
	}

  public function data_laporan_pembelian_detail($tgl_awal, $tgl_akhir, $kode_supplier){

    $where='';
    if ($tgl_awal!='' && $tgl_akhir!='' && $kode_supplier!='') {
      $where = "WHERE (om.tanggal_invoice BETWEEN '$tgl_awal' AND '$tgl_akhir' AND kode_supplier='$kode_supplier') ";
    } elseif ($tgl_awal!='' && $tgl_akhir!='') {
    $where = "WHERE (om.tanggal_invoice BETWEEN '$tgl_awal' AND '$tgl_akhir') ";
    } elseif ($tgl_awal=='' && $tgl_akhir=='' && $kode_supplier!=''){
      $where = "WHERE kode_supplier='$kode_supplier' ";
    }

		$q = $this->db_kpp->query("SELECT om.*,omd.kode_item
                               FROM item_masuk om
                               JOIN item_masuk_detail omd ON om.id_item_masuk=omd.id_item_masuk
                               $where
                               GROUP BY no_invoice");
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

  public function data_laporan_pembelian_item($tgl_awal, $tgl_akhir){

    $where = "WHERE (om.tanggal_invoice BETWEEN '$tgl_awal' AND '$tgl_akhir') AND (ir.w_insert<=pp.w_insert AND ir.w_update>=pp.w_insert)";

		$q = $this->db_kpp->query("SELECT om.*,omd.kode_item,SUM(omd.total_item_item_masuk) AS total_item_item_masuk,o.nama_item,o.harga_tebus_dpp
                               FROM item_masuk om
                               JOIN item_masuk_detail omd ON om.id_item_masuk=omd.id_item_masuk
                               JOIN item_record ir ON omd.kode_item=ir.kode_item
                               JOIN pesanan_pembelian pp ON om.no_po=pp.no_po
                               $where
                               GROUP BY omd.kode_item");
		return $q;
	}

  public function data_laporan_pembelian_supplier($tgl_awal, $tgl_akhir){

    $where = "WHERE (om.tanggal_invoice BETWEEN '$tgl_awal' AND '$tgl_akhir') AND (ir.w_insert<=pp.w_insert AND ir.w_update>=pp.w_insert)";

		$q = $this->db_kpp->query("SELECT om.kode_supplier,omd.kode_item,SUM(omd.total_item_item_masuk) AS total_item_item_masuk,o.nama_item,o.tipe,o.harga_tebus_dpp
                               FROM item_masuk om
                               JOIN item_masuk_detail omd ON om.id_item_masuk=omd.id_item_masuk
                               JOIN item_record ir ON omd.kode_item=ir.kode_item
                               $where
                               GROUP BY omd.kode_item,om.kode_supplier");
		return $q;
	}

  public function kode_supplier($tgl_awal, $tgl_akhir){

    $where = "WHERE (om.tanggal_invoice BETWEEN '$tgl_awal' AND '$tgl_akhir') ";

		$q = $this->db_kpp->query("SELECT DISTINCT om.kode_supplier
                               FROM item_masuk om
                               $where");
		return $q;
	}
}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
