<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_item extends CI_Model {

  	public function all(){
		$q = $this->db_kpp->get('item');
		return $q;
	}

	public function get($id){
 		$q 	 = $this->db_kpp->get_where("item",$id);
		$rows = $q->num_rows();
		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function getKd_item($id){
 		$q = $this->db_kpp->get_where('stok_item',array('kode_gudang' => $id));
		return $q->result();
 	}

  public function getKd_satuan($id){
    $q = $this->db_kpp->get_where('satuan',array('kode_satuan' => $id));
    return $q->result();
  }

  	public function last_kode_henkel(){
		$q = $this->db_kpp->query("SELECT MAX(right(kode_item,3)) as kode FROM item WHERE left(kode_item,4)='HNKL'");
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
		$q = $this->db_kpp->query("SELECT MAX(right(kode_item,3)) as kode FROM item WHERE left(kode_item,3)='OLI'");
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
		$q 	 = $this->db_kpp->get_where("item",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function delete($id){
 		$this->db_kpp->delete("item",$id);
 	}

 	public function cari_max_item(){
		$q = $this->db_kpp->query("SELECT MAX(id_item) as no FROM item");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

	public function insert($dt){
 		$this->db_kpp->insert("item",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("item",$dt,$id);
 	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
