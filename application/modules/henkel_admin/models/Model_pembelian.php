<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_pembelian extends CI_Model {


 	public function all(){
		$q = $this->db_kpp->get('pembelian');
		return $q;
	}

	public function get($id){
 		$q 	 = $this->db_kpp->get_where("pembelian",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function t_get($id){
 		$q 	 = $this->db_kpp->get_where("t_pembelian",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

 	public function ada($id){
		$q 	 = $this->db_kpp->get_where("pembelian",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

  public function t_ada($id){
		$q 	 = $this->db_kpp->get_where("t_pembelian",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function cari_max_pembelian(){
		$q = $this->db_kpp->query("SELECT MAX(id_pembelian) as no FROM pembelian");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

  public function t_cari_max_pembelian(){
		$q = $this->db_kpp->query("SELECT MAX(id_t_pembelian) as no FROM t_pembelian");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

	public function cari_max_pesanan_pembelian(){
		$q = $this->db_kpp->query("SELECT MAX(id_pesanan_pembelian) as no FROM pesanan_pembelian");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

 	public function insert($dt){
 		$this->db_kpp->insert("pembelian",$dt);
 	}

  public function t_insert($dt){
 		$this->db_kpp->insert("t_pembelian",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("pembelian",$dt,$id);
 	}

  public function t_update($id, $dt){
 		$this->db_kpp->update("t_pembelian",$dt,$id);
 	}

 	public function delete($id){
 		$this->db_kpp->delete("pembelian",$id);
 	}

  public function t_delete($id){
 		$this->db_kpp->delete("t_pembelian",$id);
 	}




}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
