<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_p_tahap_plan extends CI_Model {

  	public function all(){
		$q = $this->db_wuling->get('p_tahap_plan');
		return $q;
	}

	public function get($id){
 		$q 	 = $this->db_wuling->get_where("p_tahap_plan",$id);
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
		$q 	 = $this->db_wuling->get_where("p_tahap_plan",$id);
		$row = $q->num_rows();

		return $row > 0;
	}
public function last_kode($jenis){
		$q = $this->db_wuling->query("SELECT MAX(right(kode_tahap,2)) as id FROM p_tahap_plan WHERE jenis='$jenis' ");
		$row = $q->num_rows();

		if($row > 0){
            $rows = $q->result();
            $hasil = (int)$rows[0]->id;
        }else{
            $hasil = 0;
        }
		return $hasil;
	}
  public function delete($id){
 		$this->db_wuling->delete("p_tahap_plan",$id);
 	}

 	public function cari_max_tahap_plan(){
		$q = $this->db_wuling->query("SELECT MAX(id_tahap_plan) as no FROM p_tahap_plan");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

	public function insert($dt){
 		$this->db_wuling->insert("p_tahap_plan",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_wuling->update("p_tahap_plan",$dt,$id);
 	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
