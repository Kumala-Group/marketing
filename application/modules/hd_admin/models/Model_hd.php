<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_ban extends CI_Model {

  	public function all(){
		$q = $this->db_ban->get('ban');
		return $q;
	}

	public function get($id){
 		$q 	 = $this->db_ban->get_where("ban",$id);
		$rows = $q->num_rows();
		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function getKd_ban($id){
 		$q = $this->db_ban->get_where('stok_ban',array('kode_gudang' => $id));
		return $q->result();
 	}

  public function getKd_satuan($id){
    $q = $this->db_ban->get_where('satuan',array('kode_satuan' => $id));
    return $q->result();
  }

  	public function last_kode(){
		$q = $this->db_ban->query("SELECT MAX(right(kode_ban,3)) as kode FROM ban ");
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
		$q 	 = $this->db_ban->get_where("ban",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function delete($id){
 		$this->db_ban->delete("ban",$id);
 	}

 	public function cari_max_ban(){
		$q = $this->db_ban->query("SELECT MAX(id_ban) as no FROM ban");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

	public function insert($dt){
 		$this->db_ban->insert("ban",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_ban->update("ban",$dt,$id);
 	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
