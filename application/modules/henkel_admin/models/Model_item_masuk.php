<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_item_masuk extends CI_Model {

  public function all(){
		$q = $this->db_kpp->get('item_masuk');
		return $q;
	}

	public function get($id_item_masuk){
    $id['id_item_masuk'] = $id_item_masuk;
 		$q 	 = $this->db_kpp->get_where("item_masuk",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function t_get($id){
 		$q 	 = $this->db_kpp->get_where("t_item_masuk",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function get_omd($id){
 		$q 	 = $this->db_kpp->get_where("item_masuk_detail",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function ada_omd($id){
    $q 	 = $this->db_kpp->get_where("item_masuk_detail",$id);
		$row = $q->num_rows();
		return $row > 0;
	}

  public function t_ada($id){
		$q 	 = $this->db_kpp->get_where("t_item_masuk",$id);
		$row = $q->num_rows();

		return $row > 0;
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

  public function getKd_gudang($id){
 		$q = $this->db_kpp->get_where('gudang',array('kode_gudang' => $id));
		return $q->result();
 	}

  public function t_ada_id_item_masuk($id){
    $q 	 = $this->db_kpp->query("SELECT * FROM t_item_masuk WHERE id_pesanan_pembelian='$id'");
		$row = $q->num_rows();
		return $row > 0;
  }

  public function ada_item_masuk($id){
    $q 	 = $this->db_kpp->query("SELECT * FROM pembelian WHERE id_pesanan_pembelian='$id'");
		$row = $q->num_rows();
		return $row > 0;
	}

  public function get_kode_supplier($no_po){
    $q 	 = $this->db_kpp->query("SELECT kode_supplier FROM pesanan_pembelian WHERE no_po='$no_po'");
		$row = $q->num_rows();

    if($row > 0){
        $rows = $q->result();
        $hasil = $rows[0]->kode_supplier;
    }else{
        $hasil = 0;
    }
		return $hasil;
	}

  public function cari_no_po($id_pes){
    $q = $this->db_kpp->query("SELECT no_po FROM pesanan_pembelian WHERE id_pesanan_pembelian='$id_pes'");
		$row = $q->num_rows();

		if($row > 0){
        $rows = $q->result();
        $hasil = $rows[0]->no_po;
    }else{
        $hasil = 0;
    }
		return $hasil;
	}

  public function cari_tgl_po($no_po){
    $q = $this->db_kpp->query("SELECT tanggal FROM pesanan_pembelian WHERE no_po='$no_po'");
		$row = $q->num_rows();

		if($row > 0){
        $rows = $q->result();
        $hasil = $rows[0]->tanggal;
    }else{
        $hasil = 0;
    }
		return $hasil;
	}

  public function t_update($id, $dt){
 		$this->db_kpp->update("t_item_masuk",$dt,$id);
 	}

  public function update($id, $dt){
 		$this->db_kpp->update("item_masuk_detail",$dt,$id);
 	}

  public function update_om($id, $dt){
 		$this->db_kpp->update("item_masuk",$dt,$id);
 	}

	public function ada($id)
	{
		$q 	 = $this->db_kpp->get_where("item_masuk_detail",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

  public function ada_om($id)
	{
		$q 	 = $this->db_kpp->get_where("item_masuk",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function delete($id){
 		$this->db_kpp->delete("item_masuk_detail",$id);
 	}

  public function t_delete($id){
 		$this->db_kpp->delete("t_item_masuk",$id);
 	}

  public function cari_max_item_masuk(){
		$q = $this->db_kpp->query("SELECT MAX(id_item_masuk) as no FROM item_masuk");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

  public function cari_max_item_masuk_detail(){
		$q = $this->db_kpp->query("SELECT MAX(id_item_masuk_detail) as no FROM item_masuk_detail");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

 	public function t_cari_max_item_masuk(){
		$q = $this->db_kpp->query("SELECT MAX(id_t_item_masuk) as no FROM t_item_masuk");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

  public function t_cari_max_hapus(){
		$q = $this->db_kpp->query("SELECT MAX(hapus) as no FROM t_item_masuk");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

	public function insert($dt){
 		$this->db_kpp->insert("item_masuk_detail",$dt);
 	}

  public function insert_om($dt){
 		$this->db_kpp->insert("item_masuk_detail",$dt);
 	}

  public function t_insert($dt){
 		$this->db_kpp->insert("t_item_masuk",$dt);
 	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
