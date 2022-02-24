<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_item_masuk_non extends CI_Model {

  public function all(){
		$q = $this->db_kpp->get('item_masuk_non');
		return $q;
	}

	public function get($id){
 		$q 	 = $this->db_kpp->get_where("item_masuk_non",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function getKd_item($id){
 		$q 	 = $this->db_kpp->get_where('pembelian',array('id_pesanan_pembelian' => $id));
		return $q->result();
 	}

  public function getId_pesanan($id){
    $q = $this->db_kpp->query("SELECT id_pesanan_pembelian FROM pesanan_pembelian WHERE no_po='$id'");
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_pesanan_pembelian'];
		return  $result;
 	}

  public function view_no_po(){
    $q = $this->db_kpp->query("SELECT no_po FROM pesanan_pembelian");
		 if($q->num_rows()>0){
            foreach($q->result() as $dt){
                $hasil = $dt->no_po;
            }
        }else{
            $hasil = '';
        }
		return $hasil;
  }

  public function last_kode(){
		$q = $this->db_kpp->query("SELECT MAX(right(kode_item_masuk_non,3)) as kode FROM item_masuk_non ");
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
		$q 	 = $this->db_kpp->get_where("item_masuk_non",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function delete($id){
 		$this->db_kpp->delete("item_masuk_non",$id);
 	}

 	public function cari_max_item_masuk_non(){
		$q = $this->db_kpp->query("SELECT MAX(id_item_masuk_non) as no FROM item_masuk_non");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

	public function insert($dt){
 		$this->db_kpp->insert("item_masuk_non",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("item_masuk_non",$dt,$id);
 	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
