<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_supplier extends CI_Model {

  	public function all(){
		$q = $this->db_kpp->get('supplier');
		return $q;
	}

	public function get($id){
 		$q 	 = $this->db_kpp->get_where("supplier",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

 	public function last_kode_henkel(){
		$q = $this->db_kpp->query("SELECT MAX(right(kode_supplier,3)) as kode FROM supplier WHERE left(kode_supplier,6)='SPHNKL'");
		$row = $q->num_rows();

		if($row > 0){
            $rows = $q->result();
            $hasil = (int)$rows[0]->kode;
        }else{
            $hasil = 0;
        }
		return $hasil;
	}

	public function last_kode_oli(){
		$q = $this->db_kpp->query("SELECT MAX(right(kode_supplier,3)) as kode FROM supplier WHERE left(kode_supplier,5)='SPOLI'");
		$row = $q->num_rows();

		if($row > 0){
            $rows = $q->result();
            $hasil = (int)$rows[0]->kode;
        }else{
            $hasil = 0;
        }
		return $hasil;
	}

	public function ada($id)
	{
		$q 	 = $this->db_kpp->get_where("supplier",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function delete($id){
 		$this->db_kpp->delete("supplier",$id);
 	}

 	public function cari_max_supplier(){
		$q = $this->db_kpp->query("SELECT MAX(id_supplier) as no FROM supplier");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

	public function insert($dt){
 		$this->db_kpp->insert("supplier",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("supplier",$dt,$id);
 	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
