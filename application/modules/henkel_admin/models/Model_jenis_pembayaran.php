<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_jenis_pembayaran extends CI_Model {

  	public function all(){
		$q = $this->db_kpp->get('jenis_pembayaran');
		return $q;
	}

	public function get($id){
 		$q 	 = $this->db_kpp->get_where("jenis_pembayaran",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

	public function ada($id)
	{
		$q 	 = $this->db_kpp->get_where("jenis_pembayaran",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function delete($id){
 		$this->db_kpp->delete("jenis_pembayaran",$id);
 	}

 	public function cari_max_jenis_pembayaran(){
		$q = $this->db_kpp->query("SELECT MAX(id_jenis_pembayaran) as no FROM jenis_pembayaran");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

	public function insert($dt){ 
 		$this->db_kpp->insert("jenis_pembayaran",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("jenis_pembayaran",$dt,$id);
 	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
