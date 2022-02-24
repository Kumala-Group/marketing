<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_request_ar extends CI_Model {

  public function no_spk($id_prospek){
		$q = $this->db_wuling->query("SELECT no_spk FROM s_spk WHERE id_prospek='$id_prospek'");
		foreach($q->result() as $dt){
			$hasil = $dt->no_spk;
		}
		return $hasil;
	}

  public function tdp($id_prospek){
		$q = $this->db_wuling->query("SELECT tdp FROM s_hot_prospek WHERE id_prospek='$id_prospek'");
		foreach($q->result() as $dt){
			$hasil = $dt->tdp;
		}
		return $hasil;
	}
}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
