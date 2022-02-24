<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_sales extends CI_Model {

  	public function all(){
		$q = $this->db_kpp->get('sales');
		return $q;
	}

	public function get($id){
 		$q 	 = $this->db_kpp->get_where("sales",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

 	public function last_kode(){
		$q = $this->db_kpp->query("SELECT MAX(right(kode_sales,3)) as kode FROM sales ");
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
		$q 	 = $this->db_kpp->get_where("sales",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function delete($id){
 		$this->db_kpp->delete("sales",$id);
 	}

 	public function cari_max_sales(){
		$q = $this->db_kpp->query("SELECT MAX(id_sales) as no FROM sales");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

	public function insert($dt){ 
 		$this->db_kpp->insert("sales",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("sales",$dt,$id);
 	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
