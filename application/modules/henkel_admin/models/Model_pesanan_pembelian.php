<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_pesanan_pembelian extends CI_Model {


 	public function all(){
		$q = $this->db_kpp->query('SELECT pp.*, s.nama_supplier
                               FROM pesanan_pembelian pp
                               JOIN supplier s on pp.kode_supplier=s.kode_supplier
                               ');
		return $q;
	}

	public function get($id_pesanan_pembelian){
		$id['id_pesanan_pembelian'] = $id_pesanan_pembelian;
		$q = $this->db_kpp->get_where("pesanan_pembelian",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
	}

 	public function last_kode(){
		$q = $this->db_kpp->query("SELECT MAX(right(no_po,3)) as kode FROM pesanan_pembelian ");
		$row = $q->num_rows();

		if($row > 0){
            $rows = $q->result();
            $hasil = (int)$rows[0]->kode;
        }else{
            $hasil = 0;
        }
		return $hasil;
	}

	public function ada_id_pesanan($id){
    $q 	 = $this->db_kpp->get_where("pembelian",$id);
		$row = $q->num_rows();
		return $row > 0;
	}

  public function t_ada_id_pesanan($id){
    $q 	 = $this->db_kpp->get_where("t_pembelian",$id);
		$row = $q->num_rows();
		return $row > 0;
	}

	public function ada($id){
		$q 	 = $this->db_kpp->get_where("pesanan_pembelian",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function cari_max_pesanan_pembelian(){
		$q = $this->db_kpp->query("SELECT MAX(id_pesanan_pembelian) as no FROM pesanan_pembelian");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

 	public function insert($dt){
 		$this->db_kpp->insert("pesanan_pembelian",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("pesanan_pembelian",$dt,$id);
 	}

 	public function delete($id){
 		$this->db_kpp->delete("pesanan_pembelian",$id);
 		$this->db_kpp->delete("pembelian",$id);
 	}

  public function data_laporan_pembelian($tgl_awal, $tgl_akhir){

    $where = "WHERE (om.tanggal_invoice BETWEEN '$tgl_awal' AND '$tgl_akhir') ";

		$q = $this->db_kpp->query("SELECT om.*,SUM(omd.total_item_item_masuk) AS jumlah_item
                               FROM item_masuk om
                               JOIN item_masuk_detail omd ON om.id_item_masuk=omd.id_item_masuk
                               $where
                               GROUP BY no_invoice");
		return $q;
	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
