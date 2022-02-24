<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_penerima_komisi extends CI_Model {

  /* Fungsi - Fungsi Penerima Komisi - Sales*/

  public function get_pks($id){
    $q 	 = $this->db_kpp->query("SELECT tgl_awal,tgl_akhir
                                 FROM penerima_komisi_sales
                                 WHERE id_penerima_komisi_sales='$id'");
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function cari_max_penerima_komisi_sales(){
		$q = $this->db_kpp->query("SELECT MAX(id_penerima_komisi_sales) as no FROM penerima_komisi_sales");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

  /*

          Fungsi - Fungsi Penerima Komisi - t_Sales
          pksd = penerima_komisi_sales_detail
  */

  public function all_sales(){
		$q = $this->db_kpp->query('SELECT *
                               FROM t_penerima_komisi_sales_detail
                              ');
		return $q;
	}

  public function t_ada_pksd($id) {
		$q 	 = $this->db_kpp->get_where("t_penerima_komisi_sales_detail",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

  public function t_get_pksd($id){
 		$q 	 = $this->db_kpp->get_where("t_penerima_komisi_sales_detail",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function t_insert_pksd($dt){
 		$this->db_kpp->insert("t_penerima_komisi_sales_detail",$dt);
 	}

  public function t_update_pksd($id, $dt){
 		$this->db_kpp->update("t_penerima_komisi_sales_detail",$dt,$id);
 	}

  public function cari_t_max_pksd(){
		$q = $this->db_kpp->query("SELECT MAX(id_t_penerima_komisi_sales_detail) as no FROM t_penerima_komisi_sales_detail");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

  /* Fungsi - Fungsi Penerima Komisi - Kolektor*/

  public function get_pkk($id){
    $q 	 = $this->db_kpp->query("SELECT tgl_awal,tgl_akhir
                                 FROM penerima_komisi_kolektor
                                 WHERE id_penerima_komisi_kolektor='$id'");
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function cari_max_penerima_komisi_kolektor(){
		$q = $this->db_kpp->query("SELECT MAX(id_penerima_komisi_kolektor) as no FROM penerima_komisi_kolektor");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

  /*
          Fungsi - Fungsi Penerima Komisi - t_Kolektor
          pkkd = penerima_komisi_kolektor_detail
  */

  public function all_kolektor(){
		$q = $this->db_kpp->query('SELECT *
                               FROM t_penerima_komisi_kolektor_detail
                              ');
		return $q;
	}

  public function t_ada_pkkd($id) {
		$q 	 = $this->db_kpp->get_where("t_penerima_komisi_kolektor_detail",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

  public function t_get_pkkd($id){
 		$q 	 = $this->db_kpp->get_where("t_penerima_komisi_kolektor_detail",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function t_insert_pkkd($dt){
 		$this->db_kpp->insert("t_penerima_komisi_kolektor_detail",$dt);
 	}

  public function t_update_pkkd($id, $dt){
 		$this->db_kpp->update("t_penerima_komisi_kolektor_detail",$dt,$id);
 	}

  public function cari_t_max_pkkd(){
		$q = $this->db_kpp->query("SELECT MAX(id_t_penerima_komisi_kolektor_detail) as no FROM t_penerima_komisi_kolektor_detail");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

  /*
          Fungsi - Fungsi Piutang Exception
          pe = piutang_exeption
  */

  public function all_piutang_exception(){
		$q = $this->db_kpp->query('SELECT *
                               FROM piutang_exception
                              ');
		return $q;
	}

  public function ada_pe($id) {
		$q 	 = $this->db_kpp->get_where("piutang_exception",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

  public function cari_max_piutang_exception(){
		$q = $this->db_kpp->query("SELECT MAX(id_piutang_exception) as no FROM piutang_exception");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

  public function update_pe($id, $dt){
 		$this->db_kpp->update("piutang_exception",$dt,$id);
 	}

  public function insert_pe($dt){
 		$this->db_kpp->insert("piutang_exception",$dt);
 	}

  public function get_pe($id){
 		$q 	 = $this->db_kpp->get_where("piutang_exception",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  /*
          Fungsi - Fungsi Penerima Komisi - Admin
          pka = penerima_komisi_admin
  */

  public function get_pka($id){
    $q 	 = $this->db_kpp->query("SELECT tgl_awal,tgl_akhir
                                 FROM penerima_komisi_admin
                                 WHERE id_penerima_komisi_admin='$id'");
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function cari_max_penerima_komisi_admin(){
		$q = $this->db_kpp->query("SELECT MAX(id_penerima_komisi_admin) as no FROM penerima_komisi_admin");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

  /*
          Fungsi - Fungsi Penerima Komisi - t_Admin
          pkad = penerima_komisi_admin_detail
  */

  public function all_admin(){
		$q = $this->db_kpp->query('SELECT *
                               FROM t_penerima_komisi_admin_detail
                              ');
		return $q;
	}

  public function t_ada_pkad($id) {
		$q 	 = $this->db_kpp->get_where("t_penerima_komisi_admin_detail",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

  public function t_get_pkad($id){
 		$q 	 = $this->db_kpp->get_where("t_penerima_komisi_admin_detail",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function t_insert_pkad($dt){
 		$this->db_kpp->insert("t_penerima_komisi_admin_detail",$dt);
 	}

  public function t_update_pkad($id, $dt){
 		$this->db_kpp->update("t_penerima_komisi_admin_detail",$dt,$id);
 	}

  public function cari_t_max_pkad(){
		$q = $this->db_kpp->query("SELECT MAX(id_t_penerima_komisi_admin_detail) as no FROM t_penerima_komisi_admin_detail");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

  /* ---------------uncredited--------------- */
  public function ada_karyawan($id){
    $q 	 = $this->db_kpp->query("SELECT * FROM t_penerima_komisi_sales WHERE id_perusahaan='$id'");
		$row = $q->num_rows();
		return $row > 0;
	}

  public function no_transaksi(){
    $q = $this->db_kpp->query('SELECT no_transaksi
                               FROM penerima_komisi
                              ');
    return $q;
  }

  public function get_detail($id_komisi){
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

  public function get_detail_komisi($id){
    $q 	 = $this->db_kpp->get_where("komisi_detail",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
	}

  public function t_ada_komisi($id){
    $q 	 = $this->db_kpp->get_where("t_komisi",$id);
		$row = $q->num_rows();
		return $row > 0;
	}

 	public function last_kode(){
		$q = $this->db_kpp->query("SELECT MAX(right(kode_komisi,3)) as kode FROM komisi");
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
		$q 	 = $this->db_kpp->get_where("komisi",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

  public function ada_detail($id)
	{
		$q 	 = $this->db_kpp->get_where("komisi_detail",$id);
		$row = $q->num_rows();

		return $row > 0;
	}


  public function delete_detail($id){
 		$this->db_kpp->delete("komisi_detail",$id);
 	}

  public function t_delete($id){
 		$this->db_kpp->delete("t_komisi",$id);
 	}

 	public function cari_max_komisi(){
		$q = $this->db_kpp->query("SELECT MAX(id_komisi) as no FROM komisi");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

  public function cari_max_komisi_detail(){
		$q = $this->db_kpp->query("SELECT MAX(id_komisi_detail) as no FROM komisi_detail");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

  public function cari_max_penerima_komisi(){
		$q = $this->db_kpp->query("SELECT MAX(id_penerima_komisi) as no FROM penerima_komisi");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}


  public function ada_t_penerima_komisi($id){
    $q 	 = $this->db_kpp->query("SELECT * FROM t_penerima_komisi_sales WHERE id_perusahaan='$id'");
		$row = $q->num_rows();
		return $row > 0;
	}

  public function getKd_target_penjualan_detail($id){
    $nama_target='';
    $q = $this->db_kpp->get_where('target_penjualan_detail',array('id_target_penjualan_detail' => $id));
    foreach($q->result_array() AS $row) {
      $nama_target=$row['nama_target'];
    }
    return $nama_target;
  }

  public function getKd_status_komisi($id){
    $nama_komisi='';
    $q = $this->db_kpp->get_where('komisi',array('id_komisi' => $id));
    foreach($q->result_array() AS $row) {
      $nama_komisi=$row['nama_komisi'];
    }
    return $nama_komisi;
  }

	public function insert($dt){
 		$this->db_kpp->insert("komisi",$dt);
 	}

  public function insert_detail($dt){
 		$this->db_kpp->insert("komisi_detail",$dt);
 	}

  public function update($id, $dt){
 		$this->db_kpp->update("komisi",$dt,$id);
 	}


  public function update_detail($id, $dt){
 		$this->db_kpp->update("komisi_detail",$dt,$id);
 	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
