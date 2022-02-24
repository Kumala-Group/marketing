<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_piutang extends CI_Model {


 	public function all(){
		$q = $this->db_kpp->get('t_piutang');
		return $q;
	}

    public function t_get($id){
 		$q 	 = $this->db_kpp->query("SELECT tp.*,pp.sisa_o FROM t_piutang tp INNER JOIN pesanan_penjualan pp ON tp.no_transaksi = pp.no_transaksi WHERE id_t_piutang='$id' ");
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

 	public function t_get_exception($id){
 		$q 	 = $this->db_kpp->query("SELECT tp.*,pp.sisa_o FROM t_piutang_exception_pembayaran tp INNER JOIN pesanan_penjualan pp ON tp.no_transaksi = pp.no_transaksi WHERE id_t_piutang_exception_pembayaran='$id' ");
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

	public function t_ada($id){
		$q 	 = $this->db_kpp->get_where("t_piutang",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function t_ada_exception($id){
		$q 	 = $this->db_kpp->get_where("t_piutang_exception_pembayaran",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function t_cari_max_t_piutang(){
		$q = $this->db_kpp->query("SELECT MAX(id_t_piutang) as no FROM t_piutang");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

 	public function t_insert($dt){
 		$this->db_kpp->insert("t_piutang",$dt);
 	}

 	public function t_insert_exception($dt){
 		$this->db_kpp->insert("t_piutang_exception_pembayaran",$dt);
 	}

 	public function t_update($id, $dt){
 		$this->db_kpp->update("t_piutang",$dt,$id);
 	}

 	public function t_update_exception($id, $dt){
 		$this->db_kpp->update("t_piutang_exception_pembayaran",$dt,$id);
 	}

 	public function t_delete($id){
 		$this->db_kpp->delete("t_piutang",$id);
 	}

	public function get($id){
    $q 	 = $this->db_kpp->query("SELECT tp.*,pp.sisa_o FROM piutang tp INNER JOIN pesanan_penjualan pp ON tp.no_transaksi = pp.no_transaksi WHERE id_piutang='$id' ");
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

 	public function get_exception($id){
    $q 	 = $this->db_kpp->query("SELECT pep.*,pp.sisa_o FROM piutang_exception_pembayaran pep INNER JOIN pesanan_penjualan pp ON pep.no_transaksi = pp.no_transaksi WHERE id_piutang_exception_pembayaran='$id' ");
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

	public function ada($id){
		$q 	 = $this->db_kpp->get_where("piutang",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function ada_exception($id){
		$q 	 = $this->db_kpp->get_where("piutang_exception_pembayaran",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function cari_max_t_piutang(){
		$q = $this->db_kpp->query("SELECT MAX(id_t_piutang) as no FROM t_piutang");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

 	public function insert($dt){
 		$this->db_kpp->insert("t_piutang",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("piutang",$dt,$id);
 	}

 	public function update_exception($id, $dt){
 		$this->db_kpp->update("piutang_exception_pembayaran",$dt,$id);
 	}

 	public function delete($id){
 		$this->db_kpp->delete("t_piutang",$id);
 	}
}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
