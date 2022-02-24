<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_group_pelanggan extends CI_Model {

  	public function all(){
		$q = $this->db_kpp->get('group_pelanggan');
		return $q;
	}

	public function get($id){
 		$q 	 = $this->db_kpp->get_where("group_pelanggan",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

 	public function last_kode(){
		$q = $this->db_kpp->query("SELECT MAX(right(kode_group_pelanggan,3)) as kode FROM group_pelanggan ");
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
		$q 	 = $this->db_kpp->get_where("group_pelanggan",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function delete($id){
 		$this->db_kpp->delete("group_pelanggan",$id);
 	}

 	public function cari_max_group_pelanggan(){
		$q = $this->db_kpp->query("SELECT MAX(id_group_pelanggan) as no FROM group_pelanggan");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

	public function insert($dt){
 		$this->db_kpp->insert("group_pelanggan",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("group_pelanggan",$dt,$id);
 	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
