<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_jabatan_karyawan extends CI_Model {

	public function get($id){
 		$q 	 = $this->db_kpp->get_where("jabatan_karyawan",$id);
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
		$q 	 = $this->db_kpp->get_where("jabatan_karyawan",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

  public function delete($id){
 		$this->db_kpp->delete("jabatan_karyawan",$id);
 	}
  public function cari_max_jabatan_karyawan(){
		$q = $this->db_kpp->query("SELECT MAX(id_jabatan_karyawan) as no FROM jabatan_karyawan");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

	public function insert($dt){
 		$this->db_kpp->insert("jabatan_karyawan",$dt);
 	}

  public function update($id, $dt){
 		$this->db_kpp->update("jabatan_karyawan",$dt,$id);
 	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
