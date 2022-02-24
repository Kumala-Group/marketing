<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_adm_team_supervisor extends CI_Model {


 	public function ada($id){
 		$q 	 = $this->db_wuling->get_where("adm_team_supervisor",$id);
		$row = $q->num_rows();

		return $row > 0;
 	}

 	public function get($id){
 		$q 	 = $this->db_wuling->get_where("adm_team_supervisor",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

 	public function cari_max_adm_team_supervisor(){
		$q = $this->db_wuling->query("SELECT MAX(id_team_supervisor) as no FROM adm_team_supervisor");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}


	public function all(){
    $q = $this->db_wuling->select('*');
		$q = $this->db_wuling->order_by('nama_team');
		$q = $this->db_wuling->get('adm_team_supervisor');
		return $q;
	}

 	public function insert($dt){
 		$this->db_wuling->insert("adm_team_supervisor",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_wuling->update("adm_team_supervisor",$dt,$id);
 	}

 	public function delete($id){
 		$this->db_wuling->delete("adm_team_supervisor",$id);
 	}




}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
