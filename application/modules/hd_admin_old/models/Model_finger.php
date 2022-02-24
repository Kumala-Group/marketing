<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_finger extends CI_Model {

  	public function all(){
		$q = $this->db_helpdesk->get('mesin_absen');
		return $q;
	}

	public function get($id){
 		$q 	 = $this->db_helpdesk->get_where("mesin_absen",$id);
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
		$q 	 = $this->db_helpdesk->get_where("mesin_absen",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function delete($id){
 		$this->db_helpdesk->delete("mesin_absen",$id);
 	}

 	public function cari_max_(){
		$q = $this->db_helpdesk->query("SELECT MAX(id_mesin no FROM nama_perangkat");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

	public function insert($dt){
 		$this->db_helpdesk->insert("mesin_absen",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_helpdesk->update("mesin_absen",$dt,$id);
 	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
