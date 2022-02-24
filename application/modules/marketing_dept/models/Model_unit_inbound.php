<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_unit_inbound extends CI_Model {

	public function get($id){
 		$q 	 = $this->db_wuling->get_where("detail_unit_masuk",$id);
		$rows = $q->num_rows();
		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

	public function get_edit($id){
 		$q 	 =  $this->db_wuling->select('su.*,dum.id_expedisi,dum.kode_unit')
				 ->from('stok_unit su')
				 ->join('detail_unit_masuk dum', 'su.no_rangka = dum.no_rangka')
				 ->where("su.no_rangka='$id'")->get();
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
