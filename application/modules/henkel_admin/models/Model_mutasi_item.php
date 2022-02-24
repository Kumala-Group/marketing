<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_mutasi_item extends CI_Model {

  public function all(){
		$q = $this->db_kpp->get('mutasi_item');
		return $q;
	}

	public function get($id){
 		$q 	 = $this->db_kpp->get_where("mutasi_item",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function last_kode(){
		$q = $this->db_kpp->query("SELECT MAX(right(kode_ubah,3)) as kode FROM item_masuk ");
		$row = $q->num_rows();

		if($row > 0){
            $rows = $q->result();
            $hasil = (int)$rows[0]->kode;
        }else{
            $hasil = 0;
        }
		return $hasil;
	}

  public function getKd_item($id){
 		$q = $this->db_kpp->select('s.kode_item,i.nama_item,i.tipe')->join('item i','i.kode_item=s.kode_item')->get_where('stok_item s',array('kode_gudang' => $id));
		return $q->result();
 	}

  public function getKd_item_item($id){
 		$q = $this->db_kpp->query("SELECT kode_item FROM stok_item WHERE kode_gudang='$id'");
		return $q->row();
 	}

  public function getId_pesanan($id){
    $q = $this->db_kpp->query("SELECT kode_item FROM item_masuk WHERE kode_gudang='$id'");;
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['kode_item'];
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

	public function ada($id)
	{
		$q 	 = $this->db_kpp->get_where("mutasi_item",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function delete($id){
 		$this->db_kpp->delete("mutasi_item",$id);
 	}

 	public function cari_max_mutasi_item(){
		$q = $this->db_kpp->query("SELECT MAX(id_mutasi_item) as no FROM mutasi_item");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

	public function insert($dt){
 		$this->db_kpp->insert("mutasi_item",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("mutasi_item",$dt,$id);
 	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
