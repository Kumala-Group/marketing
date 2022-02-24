<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_hitungan_komisi extends CI_Model {

   /*

        Fungsi - Fungsi  Komisi

   */
    public function all(){
      $q = $this->db_kpp->query('SELECT *
                                 FROM komisi
                                ');
      return $q;
    }

    public function ada($id){
  		$q 	 = $this->db_kpp->get_where("komisi",$id);
  		$row = $q->num_rows();

  		return $row > 0;
  	}

    public function update($id, $dt){
   		$this->db_kpp->update("komisi",$dt,$id);
   	}

    public function insert($dt){
   		$this->db_kpp->insert("komisi",$dt);
   	}

    public function cari_max_komisi(){
  		$q = $this->db_kpp->query("SELECT MAX(id_komisi) as no FROM komisi");
  		foreach($q->result() as $dt){
  			$no = (int) $dt->no+1;
  		}
  		return $no;
  	}

    public function komisi_detail($id_komisi){
  		$id['id_komisi'] = $id_komisi;
  		$q = $this->db_kpp->get_where("komisi",$id);
  		$rows = $q->num_rows();

  		if ($rows > 0){
  			$results = $q->result();
  			return $results[0];
  		} else {
  			return null;
  		}
  	}

    public function last_kode(){
  		$q = $this->db_kpp->query("SELECT MAX(right(kode_komisi,3)) as kode FROM komisi ");
  		$row = $q->num_rows();

  		if($row > 0){
              $rows = $q->result();
              $hasil = (int)$rows[0]->kode;
          }else{
              $hasil = 0;
          }
  		return $hasil;
  	}

    /*

        Fungsi - Fungsi Komisi Sales

    */

    public function ada_sales($id){
  		$q 	 = $this->db_kpp->get_where("komisi_sales",$id);
  		$row = $q->num_rows();

  		return $row > 0;
  	}

    public function delete_sales($id){
   		$this->db_kpp->delete("komisi_sales",$id);
   	}

    public function get_sales($id){
   		$q 	 = $this->db_kpp->get_where("komisi_sales",$id);
  		$rows = $q->num_rows();

  		if ($rows > 0){
  			$results = $q->result();
  			return $results[0];
  		} else {
  			return null;
  		}
   	}


    /*

        Fungsi - Fungsi Komisi t_Sales

    */

  	public function all_sales(){
  		$q = $this->db_kpp->query('SELECT *
                                 FROM t_komisi_sales
                                ');
  		return $q;
	  }

    public function cari_max_komisi_sales(){
  		$q = $this->db_kpp->query("SELECT MAX(id_komisi_sales) as no FROM komisi_sales");
  		foreach($q->result() as $dt){
  			$no = (int) $dt->no+1;
  		}
  		return $no;
  	}

    public function cari_t_max_komisi_sales(){
  		$q = $this->db_kpp->query("SELECT MAX(id_t_komisi_sales) as no FROM t_komisi_sales");
  		foreach($q->result() as $dt){
  			$no = (int) $dt->no+1;
  		}
  		return $no;
  	}

    public function cek_table_t_sales() {
      $q 	 = $this->db_kpp->query("SELECT * FROM t_komisi_sales");
      $row = $q->num_rows();

      return $row > 0;
    }

    public function t_ada_sales($id){
  		$q 	 = $this->db_kpp->get_where("t_komisi_sales",$id);
  		$row = $q->num_rows();

  		return $row > 0;
  	}

    public function t_update_sales($id, $dt){
   		$this->db_kpp->update("t_komisi_sales",$dt,$id);
   	}

    public function t_insert_sales($dt){
   		$this->db_kpp->insert("t_komisi_sales",$dt);
   	}

    public function t_delete_sales($id){
   		$this->db_kpp->delete("t_komisi_sales",$id);
   	}

    public function t_get_sales($id){
   		$q 	 = $this->db_kpp->get_where("t_komisi_sales",$id);
  		$rows = $q->num_rows();

  		if ($rows > 0){
  			$results = $q->result();
  			return $results[0];
  		} else {
  			return null;
  		}
   	}

    /*

        Fungsi - Fungsi Komisi Spv

    */

    public function ada_spv($id){
  		$q 	 = $this->db_kpp->get_where("komisi_spv",$id);
  		$row = $q->num_rows();

  		return $row > 0;
  	}

    public function delete_spv($id){
   		$this->db_kpp->delete("komisi_spv",$id);
   	}

    public function get_spv($id){
   		$q 	 = $this->db_kpp->get_where("komisi_spv",$id);
  		$rows = $q->num_rows();

  		if ($rows > 0){
  			$results = $q->result();
  			return $results[0];
  		} else {
  			return null;
  		}
   	}

    /*

        Fungsi - Fungsi Komisi t_Spv

    */

  	public function all_spv(){
  		$q = $this->db_kpp->query('SELECT *
                                 FROM t_komisi_spv
                                ');
  		return $q;
	  }

    public function cari_max_komisi_spv(){
  		$q = $this->db_kpp->query("SELECT MAX(id_komisi_spv) as no FROM komisi_spv");
  		foreach($q->result() as $dt){
  			$no = (int) $dt->no+1;
  		}
  		return $no;
  	}

    public function cari_t_max_komisi_spv(){
  		$q = $this->db_kpp->query("SELECT MAX(id_t_komisi_spv) as no FROM t_komisi_spv");
  		foreach($q->result() as $dt){
  			$no = (int) $dt->no+1;
  		}
  		return $no;
  	}

    public function cek_table_t_spv() {
      $q 	 = $this->db_kpp->query("SELECT * FROM t_komisi_spv");
      $row = $q->num_rows();

      return $row > 0;
    }

    public function t_ada_spv($id){
  		$q 	 = $this->db_kpp->get_where("t_komisi_spv",$id);
  		$row = $q->num_rows();

  		return $row > 0;
  	}

    public function t_update_spv($id, $dt){
   		$this->db_kpp->update("t_komisi_spv",$dt,$id);
   	}

    public function t_insert_spv($dt){
   		$this->db_kpp->insert("t_komisi_spv",$dt);
   	}

    public function t_delete_spv($id){
   		$this->db_kpp->delete("t_komisi_spv",$id);
   	}

    public function t_get_spv($id){
   		$q 	 = $this->db_kpp->get_where("t_komisi_spv",$id);
  		$rows = $q->num_rows();

  		if ($rows > 0){
  			$results = $q->result();
  			return $results[0];
  		} else {
  			return null;
  		}
   	}

    /*

        Fungsi - Fungsi Komisi Admin

    */

    public function ada_admin($id){
  		$q 	 = $this->db_kpp->get_where("komisi_admin",$id);
  		$row = $q->num_rows();

  		return $row > 0;
  	}

    public function delete_admin($id){
   		$this->db_kpp->delete("komisi_admin",$id);
   	}

    public function get_admin($id){
   		$q 	 = $this->db_kpp->get_where("komisi_admin",$id);
  		$rows = $q->num_rows();

  		if ($rows > 0){
  			$results = $q->result();
  			return $results[0];
  		} else {
  			return null;
  		}
   	}

    /*

        Fungsi - Fungsi Komisi t_Admin

    */

    public function all_admin(){
      $q = $this->db_kpp->query('SELECT *
                                 FROM t_komisi_admin
                                ');
      return $q;
    }

    public function cari_t_max_komisi_admin(){
  		$q = $this->db_kpp->query("SELECT MAX(id_t_komisi_admin) as no FROM t_komisi_admin");
  		foreach($q->result() as $dt){
  			$no = (int) $dt->no+1;
  		}
  		return $no;
  	}

    public function cari_max_komisi_admin(){
  		$q = $this->db_kpp->query("SELECT MAX(id_komisi_admin) as no FROM komisi_admin");
  		foreach($q->result() as $dt){
  			$no = (int) $dt->no+1;
  		}
  		return $no;
  	}

    public function t_ada_admin($id){
  		$q 	 = $this->db_kpp->get_where("t_komisi_admin",$id);
  		$row = $q->num_rows();

  		return $row > 0;
  	}

    public function t_update_admin($id, $dt){
   		$this->db_kpp->update("t_komisi_admin",$dt,$id);
   	}

    public function t_insert_admin($dt){
   		$this->db_kpp->insert("t_komisi_admin",$dt);
   	}

    public function t_delete_admin($id){
   		$this->db_kpp->delete("t_komisi_admin",$id);
   	}

    public function t_get_admin($id){
   		$q 	 = $this->db_kpp->get_where("t_komisi_admin",$id);
  		$rows = $q->num_rows();

  		if ($rows > 0){
  			$results = $q->result();
  			return $results[0];
  		} else {
  			return null;
  		}
   	}

    public function cek_table_t_admin() {
      $q 	 = $this->db_kpp->query("SELECT * FROM t_komisi_admin");
      $row = $q->num_rows();

      return $row > 0;
    }

    /* kode satuan */

    public function getKd_satuan($id){
   		$q = $this->db_kpp->get_where('satuan',array('id_satuan' => $id));
  		return $q->result();
   	}
}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
