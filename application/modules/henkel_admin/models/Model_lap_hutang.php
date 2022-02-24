<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_lap_hutang extends CI_Model {


  public function data_laporan_hutang($tgl_awal, $tgl_akhir){

    $where = "WHERE (om.tanggal_invoice BETWEEN '$tgl_awal' AND '$tgl_akhir' AND om.status_bayar='kredit') ";

		$q = $this->db_kpp->query("SELECT om.*, SUM(omd.total_item_item_masuk) AS jumlah_item
                               FROM item_masuk om
                               JOIN item_masuk_detail omd ON om.id_item_masuk=omd.id_item_masuk
                               $where
                               GROUP BY no_invoice");
		return $q;
	}

  public function data_laporan_umur_hutang($tgl_awal, $tgl_akhir){

    $where = "WHERE (om.tanggal_invoice BETWEEN '$tgl_awal' AND '$tgl_akhir' AND om.status_bayar='kredit') ";

		$q = $this->db_kpp->query("SELECT om.*, SUM(omd.total_item_item_masuk) AS jumlah_item
                               FROM item_masuk om
                               JOIN item_masuk_detail omd ON om.id_item_masuk=omd.id_item_masuk
                               $where
                               GROUP BY no_invoice");
		return $q;
	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
