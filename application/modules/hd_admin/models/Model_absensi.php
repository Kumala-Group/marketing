<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_absensi extends CI_Model {

  	public function all(){
		$q = $this->db_helpdesk->get('absensi');
		return $q;
	}

	public function get($id){
 		$q 	 = $this->db_helpdesk->get_where("absensi",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function allabsen(){
 		$q = $this->db->query(" SELECT * FROM (db_helpdesk.absensi INNER JOIN kmg.perusahaan on kmg.perusahaan.id_perusahaan=db_helpdesk.absensi.id_perusahaan) INNER JOIN kmg.brand on kmg.brand.id_brand=kmg.perusahaan.id_brand");
    return $q;
	}

  public function statusOK(){
  		$q = $this->db_helpdesk->query("SELECT COUNT(id_perusahaan) as id FROM absensi WHERE status = 'OK'");
  		foreach($q->result() as $dt){
  			$hasil = (int)$dt->id;
  		}
  		return $hasil;
  }
  public function statusTROUBLE(){
  		$q = $this->db_helpdesk->query("SELECT COUNT(id_perusahaan) as id FROM absensi WHERE status = 'TROUBLE'");
  		foreach($q->result() as $dt){
  			$hasil = (int)$dt->id;
  		}
  		return $hasil;
  }
  public function statusNO(){
  		$q = $this->db_helpdesk->query("SELECT COUNT(id_perusahaan) as id FROM absensi WHERE status = 'NO DATA'");
  		foreach($q->result() as $dt){
  			$hasil = (int)$dt->id;
  		}
  		return $hasil;
  }


	public function ada($id)
	{
		$q 	 = $this->db_helpdesk->get_where("absensi",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function delete($id){
 		$this->db_helpdesk->delete("absensi",$id);
 	}

 	public function cari_max_absensi(){
		$q = $this->db_helpdesk->query("SELECT MAX(id_absensi) as no FROM absensi");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

	public function insert($dt){
 		$this->db_helpdesk->insert("absensi",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_helpdesk->update("absensi",$dt,$id);
 	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
