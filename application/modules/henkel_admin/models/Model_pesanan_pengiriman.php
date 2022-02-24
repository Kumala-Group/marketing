<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_pesanan_pengiriman extends CI_Model {


 	public function all(){
		$q = $this->db_kpp->query('SELECT *
                               FROM pesanan_pengiriman

                               ');
		return $q;
	}

	public function get($id_pesanan_pengiriman){
		$id['id_pesanan_pengiriman'] = $id_pesanan_pengiriman;
		$q = $this->db_kpp->get_where("pesanan_pengiriman",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
	}

 	public function last_kode(){
		$q = $this->db_kpp->query("SELECT MAX(right(no_inv_pengiriman,3)) as kode FROM pesanan_pengiriman ");
		$row = $q->num_rows();

		if($row > 0){
            $rows = $q->result();
            $hasil = (int)$rows[0]->kode;
        }else{
            $hasil = 0;
        }
		return $hasil;
	}

	public function ada_id_pesanan($id){
    $q 	 = $this->db_kpp->get_where("pengiriman",$id);
		$row = $q->num_rows();
		return $row > 0;
	}

  public function t_ada_id_pesanan($id){
    $q 	 = $this->db_kpp->get_where("t_pengiriman",$id);
		$row = $q->num_rows();
		return $row > 0;
	}

	public function ada($id){
		$q 	 = $this->db_kpp->get_where("pesanan_pengiriman",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function cari_max_pesanan_pengiriman(){
		$q = $this->db_kpp->query("SELECT MAX(id_pesanan_pengiriman) as no FROM pesanan_pengiriman");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

 	public function insert($dt){
 		$this->db_kpp->insert("pesanan_pengiriman",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("pesanan_pengiriman",$dt,$id);
 	}

 	public function delete($id){
 		$this->db_kpp->delete("pesanan_pengiriman",$id);
 		$this->db_kpp->delete("pengiriman",$id);
 	}




}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
