<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_r_pembelian extends CI_Model {


 	public function all(){
		$q = $this->db_kpp->get('r_pembelian');
		return $q;
	}

  public function t_get($id){
 		$q 	 = $this->db_kpp->get_where("t_r_pembelian",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

	public function t_ada($id){
		$q 	 = $this->db_kpp->get_where("t_r_pembelian",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function t_cari_max_r_pembelian(){
		$q = $this->db_kpp->query("SELECT MAX(id_t_r_pembelian) as no FROM t_r_pembelian");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

 	public function t_insert($dt){
 		$this->db_kpp->insert("t_r_pembelian",$dt);
 	}

 	public function t_update($id, $dt){
 		$this->db_kpp->update("t_r_pembelian",$dt,$id);
 	}

 	public function t_delete($id){
 		$this->db_kpp->delete("t_r_pembelian",$id);
 	}

	public function get($id){
 		$q 	 = $this->db_kpp->get_where("r_pembelian",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

	public function ada($id){
		$q 	 = $this->db_kpp->get_where("r_pembelian",$id);
		$row = $q->num_rows();
		return $row > 0;
	}

	public function cari_max_r_pembelian(){
		$q = $this->db_kpp->query("SELECT MAX(id_r_pembelian) as no FROM r_pembelian");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

 	public function insert($dt){
 		$this->db_kpp->insert("r_pembelian",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("r_pembelian",$dt,$id);
 	}

 	public function delete($id){
 		$this->db_kpp->delete("r_pembelian",$id);
 	}
}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
