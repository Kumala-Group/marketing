<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_pengiriman extends CI_Model {


 	public function all(){
		$q = $this->db_kpp->get('pengiriman');
		return $q;
	}

	public function get($id){
 		$q 	 = $this->db_kpp->get_where("pengiriman",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function t_get($id){
 		$q 	 = $this->db_kpp->get_where("t_pengiriman",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

 	public function ada($id){
		$q 	 = $this->db_kpp->get_where("pengiriman",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

  public function t_ada($id){
		$q 	 = $this->db_kpp->get_where("t_pengiriman",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function cari_max_pengiriman(){
		$q = $this->db_kpp->query("SELECT MAX(id_pengiriman) as no FROM pengiriman");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

  public function t_cari_max_pengiriman(){
		$q = $this->db_kpp->query("SELECT MAX(id_t_pengiriman) as no FROM t_pengiriman");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

	public function cari_max_pesanan_pengiriman(){
		$q = $this->db_kpp->query("SELECT MAX(id_pesanan_pengiriman) as no FROM pesanan_pengiriman");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

 	public function insert($dt){
 		$this->db_kpp->insert("pengiriman",$dt);
 	}

  public function t_insert($dt){
 		$this->db_kpp->insert("t_pengiriman",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("pengiriman",$dt,$id);
 	}

  public function t_update($id, $dt){
 		$this->db_kpp->update("t_pengiriman",$dt,$id);
 	}

 	public function delete($id){
 		$this->db_kpp->delete("pengiriman",$id);
 	}

  public function t_delete($id){
 		$this->db_kpp->delete("t_pengiriman",$id);
 	}




}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
