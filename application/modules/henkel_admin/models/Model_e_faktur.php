<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_e_faktur extends CI_Model {

  public function all(){
		   $q = $this->db_kpp->get('e_faktur');
       return $q;
  }

	public function get($id){
 		$q 	 = $this->db_kpp->get_where("e_faktur",$id);
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
		$q 	 = $this->db_kpp->get_where("e_faktur",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function delete($id){
 		$this->db_kpp->delete("e_faktur",$id);
 	}

 	public function cari_max_e_faktur(){
		$q = $this->db_kpp->query("SELECT MAX(id_e_faktur) as no FROM e_faktur");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

	public function insert($id){
 		$this->db_kpp->insert("e_faktur",$id);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("e_faktur",$dt,$id);
 	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
