<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_lap_piutang extends CI_Model {


  public function data_laporan_piutang($tgl_awal, $tgl_akhir){

    $where = "WHERE (pp.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND pp.status='Kredit') ";

		$q = $this->db_kpp->query("SELECT pp.*
                               FROM pesanan_penjualan pp
                               $where
                               GROUP BY no_transaksi");
		return $q;
	}

  public function data_laporan_umur_piutang($tgl_awal, $tgl_akhir){

    $where = "WHERE (pp.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND pp.status='Kredit') ";

		$q = $this->db_kpp->query("SELECT pp.*
                               FROM pesanan_penjualan pp
                               $where
                               GROUP BY no_transaksi");
		return $q;
	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
