<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_lap_komisi extends CI_Model {

  /* Fungsi - Fungsi Komisi Sales */

  public function all_sales() {
    $q = $this->db_kpp->get('penerima_komisi_sales');
    return $q;
  }

  public function ada_sales($id) {
		$q 	 = $this->db_kpp->get_where("penerima_komisi_sales",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

  public function get_sales($id){
 		$q 	 = $this->db_kpp->get_where("penerima_komisi_sales",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  /* Fungsi - Fungsi Komisi Kolektor */

  public function all_kolektor() {
    $q = $this->db_kpp->get('penerima_komisi_kolektor');
    return $q;
  }

  public function ada_kolektor($id) {
		$q 	 = $this->db_kpp->get_where("penerima_komisi_kolektor",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

  public function get_kolektor($id){
 		$q 	 = $this->db_kpp->get_where("penerima_komisi_kolektor",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  /* Fungsi - Fungsi Komisi Admin */

  public function all_admin() {
    $q = $this->db_kpp->get('penerima_komisi_admin');
    return $q;
  }

  public function ada_admin($id) {
		$q 	 = $this->db_kpp->get_where("penerima_komisi_admin",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

  public function get_admin($id){
 		$q 	 = $this->db_kpp->get_where("penerima_komisi_admin",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}
}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
