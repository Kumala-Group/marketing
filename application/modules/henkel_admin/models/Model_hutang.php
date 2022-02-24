<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_hutang extends CI_Model {


 	public function all(){
		$q = $this->db_kpp->get('t_piutang');
		return $q;
	}

  public function t_get($id){
 		$q 	 = $this->db_kpp->query("SELECT th.*,om.total_akhir_o
                                 FROM t_hutang th
                                 INNER JOIN item_masuk om
                                 ON th.no_invoice = om.no_invoice
                                 WHERE id_t_hutang='$id' ");
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

	public function t_ada($id){
		$q 	 = $this->db_kpp->get_where("t_hutang",$id);
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

 	public function t_update($id, $dt){
 		$this->db_kpp->update("t_hutang",$dt,$id);
 	}

 	public function t_delete($id){
 		$this->db_kpp->delete("t_piutang",$id);
 	}

	public function get($id){
    $q 	 = $this->db_kpp->query("SELECT h.*,om.total_akhir_o
                                 FROM hutang h
                                 INNER JOIN item_masuk om
                                 ON h.no_invoice = om.no_invoice
                                 WHERE id_hutang='$id' ");
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

	public function ada($id){
		$q 	 = $this->db_kpp->get_where("hutang",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function cari_max_t_piutang(){
		$q = $this->db_kpp->query("SELECT MAX(id_t_hutang) as no FROM t_hutang");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

 	public function insert($dt){
 		$this->db_kpp->insert("t_piutang",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("hutang",$dt,$id);
 	}

 	public function delete($id){
 		$this->db_kpp->delete("t_piutang",$id);
 	}
}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
