<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_sa_hutang extends CI_Model {

	public function get($id){
 		$q 	 = $this->db_kpp->get_where("t_detail_sah",$id);
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
