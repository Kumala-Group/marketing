<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_kontrak extends CI_Model {

  	public function all(){
		$q = $this->db_helpdesk->get('kontrak');
		return $q;
	}

	public function get($id){
 		$q 	 = $this->db_helpdesk->get_where("kontrak",$id);
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
		$q 	 = $this->db_helpdesk->get_where("kontrak",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function delete($id){
 		$this->db_helpdesk->delete("kontrak",$id);
 	}

 	public function cari_max_kontrak(){
		$q = $this->db_helpdesk->query("SELECT MAX(id_kontrak) as no FROM kontrak");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

	public function insert($dt){
 		$this->db_helpdesk->insert("kontrak",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_helpdesk->update("kontrak",$dt,$id);
 	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
