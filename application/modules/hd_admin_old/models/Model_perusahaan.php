<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_perusahaan extends CI_Model {

 	public function ada($id){
 		$q 	 = $this->db->get_where("perusahaan",$id);
		$row = $q->num_rows();

		return $row > 0;
 	}

 	public function get($id){
 		$q 	 = $this->db->get_where("perusahaan",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

 	public function get2($id){
 		$id2 = $id['id_perusahaan'];
 		$q = $this->db->query("SELECT * FROM perusahaan WHERE id_perusahaan='$id2'");
 		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}


	public function all(){
		$q = $this->db->order_by('singkat');
		$q = $this->db->get('perusahaan');
		return $q;
	}
  public function allabsen(){
 		$q = $this->db->query("SELECT db_helpdesk.absensi.id_perusahaan AS id_perusahaan,kmg.perusahaan.singkat,kmg.brand.nama_brand,kmg.perusahaan.lokasi,db_helpdesk.absensi.status,db_helpdesk.absensi.last_update FROM kmg.perusahaan,db_helpdesk.absensi,kmg.brand WHERE db_helpdesk.absensi.id_perusahaan =kmg.perusahaan.id_perusahaan AND kmg.brand.id_brand =kmg.perusahaan.id_brand ORDER BY db_helpdesk.absensi.status ASC");
    return $q;
	}

 	public function insert($dt){
 		$this->db->insert("perusahaan",$dt);
 	}

 	public function update($id, $dt){
 		$this->db->update("perusahaan",$dt,$id);
 	}
  public function updatestatus($id, $dt){
 		$this->db_helpdesk->update("absensi",$dt,$id);
 	}

 	public function delete($id){
 		$this->db->delete("perusahaan",$id);
 	}

 	public function singkatPerusahaan($id){
		$q = $this->db->query("SELECT * FROM perusahaan WHERE id_perusahaan='$id'");
        if($q->num_rows()>0){
            foreach($q->result() as $dt){
                $hasil = $dt->nama_perusahaan;
            }
        }else{
            $hasil ='';
        }
		return $hasil;
	}

	public function cari_max_perusahaan(){
		$q = $this->db->query("SELECT MAX(id_perusahaan) as no FROM perusahaan");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

	public function dataMk($jur){
		$id['kd_prodi'] = $jur;
		$q = $this->db->order_by('kd_mk');
		$q = $this->db->get_where('mata_kuliah',$id);
		return $q;
	}

	public function namaPerusahaan($id){
		$q = $this->db->query("SELECT * FROM perusahaan WHERE id_perusahaan='$id'");
        if($q->num_rows()>0){
            foreach($q->result() as $dt){
                $hasil = $dt->nama_perusahaan.' - '. $dt->lokasi;
            }
        }else{
            $hasil = '';
        }
		return $hasil;
	}

	public function data_perusahaan(){
		$q = $this->db->order_by('id_perusahaan');
		$q = $this->db->get('perusahaan');
		return $q;
	}

  	public function data_perusahaan_brand(){
  		$q = $this->db->order_by('id_perusahaan');
  		$q = $this->db->select('*')->from('perusahaan p')->join('brand b','p.id_brand=b.id_brand')->get();
  		return $q;
  	}

	public function jml_data_jadwal($th,$smt,$prodi){
		$key['th_akademik']= $th;
		$key['semester'] = $smt;
		$key['kd_prodi'] = $prodi;
		$q = $this->db->get_where("jadwal",$key);
		$row = $q->num_rows();
		return $row;
	}

	public function smt(){
		$q = array('1','2','3','4','5','6','7','8');
		return $q;
	}
}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
