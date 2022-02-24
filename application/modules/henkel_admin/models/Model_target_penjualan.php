<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_target_penjualan extends CI_Model {

   /*

        Fungsi - Fungsi  Target Penjualan

   */

    public function all(){
      $q = $this->db_kpp->query('SELECT *
                                 FROM target_penjualan
                                ');
      return $q;
    }

    public function ada($id){
  		$q 	 = $this->db_kpp->get_where("target_penjualan",$id);
  		$row = $q->num_rows();

  		return $row > 0;
  	}

    public function insert($dt){
   		$this->db_kpp->insert("target_penjualan",$dt);
   	}

    public function update($id, $dt){
   		$this->db_kpp->update("target_penjualan",$dt,$id);
   	}

    public function delete($id){
      $this->db_kpp->delete("target_penjualan",$id);
    }

    public function cari_max_target_penjualan(){
  		$q = $this->db_kpp->query("SELECT MAX(id_target_penjualan) as no FROM target_penjualan");
  		foreach($q->result() as $dt){
  			$no = (int) $dt->no+0;
  		}
  		return $no;
  	}

    /*

         Fungsi - Fungsi  Target Penjualan Detail

    */
    public function all_detail(){
      $q = $this->db_kpp->query('SELECT *
                                 FROM target_penjualan_detail
                                ');
      return $q;
    }

    public function ada_detail($id){
  		$q 	 = $this->db_kpp->get_where("target_penjualan_detail",$id);
  		$row = $q->num_rows();

  		return $row > 0;
  	}

    public function insert_detail($dt){
   		$this->db_kpp->insert("target_penjualan_detail",$dt);
   	}

    public function update_detail($id, $dt){
   		$this->db_kpp->update("target_penjualan_detail",$dt,$id);
   	}

    public function delete_detail($id){
      $this->db_kpp->delete("target_penjualan_detail",$id);
    }

    public function get_detail($id){
   		$q 	 = $this->db_kpp->get_where("target_penjualan_detail",$id);
  		$rows = $q->num_rows();

  		if ($rows > 0){
  			$results = $q->result();
  			return $results[0];
  		} else {
  			return null;
  		}
   	}

    public function cari_max_target_penjualan_detail(){
  		$q = $this->db_kpp->query("SELECT MAX(id_target_penjualan_detail) as no FROM target_penjualan_detail");
  		foreach($q->result() as $dt){
  			$no = (int) $dt->no+1;
  		}
  		return $no;
  	}
}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
