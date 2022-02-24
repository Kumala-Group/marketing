<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_penjualan extends CI_Model {


 	public function all(){
		$q = $this->db_kpp->get('penjualan');
		return $q;
	}

  public function t_get($id){
 		$q 	 = $this->db_kpp->get_where("t_penjualan",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

	public function t_ada($id){
		$q 	 = $this->db_kpp->get_where("t_penjualan",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function t_cari_max_penjualan(){
		$q = $this->db_kpp->query("SELECT MAX(id_t_penjualan) as no FROM t_penjualan");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

 	public function t_insert($dt){
 		$this->db_kpp->insert("t_penjualan",$dt);
 	}

 	public function t_update($id, $dt){
 		$this->db_kpp->update("t_penjualan",$dt,$id);
 	}

 	public function t_delete($id){
 		$this->db_kpp->delete("t_penjualan",$id);
 	}

	public function get($id){
 		$q 	 = $this->db_kpp->get_where("penjualan",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

	public function ada($id){
		$q 	 = $this->db_kpp->get_where("penjualan",$id);
		$row = $q->num_rows();
		return $row > 0;
	}

	public function cari_max_penjualan(){
		$q = $this->db_kpp->query("SELECT MAX(id_penjualan) as no FROM penjualan");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

 	public function insert($dt){
 		$this->db_kpp->insert("penjualan",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("penjualan",$dt,$id);
 	}

 	public function delete($id){
 		$this->db_kpp->delete("penjualan",$id);
 	}
}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
