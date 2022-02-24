<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_hardware extends CI_Model {

 	public function ada($id){
 		$q 	 = $this->db_helpdesk->get_where("hardware",$id);
		$row = $q->num_rows();

		return $row > 0;
 	}
  	public function allhardware(){
 		$q = $this->db->query("SELECT db_helpdesk.hardware.id_hardware,db_helpdesk.hardware.id_perusahaan,kmg.perusahaan.singkat,kmg.brand.nama_brand,kmg.perusahaan.lokasi,kmg.karyawan.nama_karyawan,kmg.karyawan.handphone,kmg.karyawan.email,db_helpdesk.hardware.jenis_hardware,db_helpdesk.hardware.noaset_hardware,db_helpdesk.hardware.merk_hardware,db_helpdesk.hardware.type_hardware,db_helpdesk.hardware.sn_hardware,db_helpdesk.hardware.harga_hardware,db_helpdesk.hardware.kondisi_hardware,db_helpdesk.hardware.tgl_hardware,db_helpdesk.hardware.status_hardware FROM kmg.karyawan,db_helpdesk.hardware,kmg.perusahaan,kmg.brand WHERE kmg.karyawan.nik = db_helpdesk.hardware.nik AND db_helpdesk.hardware.id_perusahaan AND kmg.brand.id_brand =kmg.perusahaan.id_brand =kmg.perusahaan.id_perusahaan");
    return $q;
	}
  	public function get($id){
 		$q 	 = $this->db_helpdesk->get_where("hardware",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}
  public function last_kode($var){
		$q = $this->db_helpdesk->query("SELECT MAX(right(noaset_hardware,3)) as kode FROM hardware WHERE id_perusahaan='$var'");
		$row = $q->num_rows();

		if($row > 0){
            $rows = $q->result();
            $hasil = (int)$rows[0]->kode;
        }else{
            $hasil = 0;
        }
		return $hasil;
	}


	public function all(){
		$q = $this->db_helpdesk->order_by('tgl_hardware');
		$q = $this->db_helpdesk->get('hardware');
		return $q;
	}
  	public function dataByPerusahaan($per){
		$query = $this->db_helpdesk->query("SELECT db_helpdesk.hardware.id_hardware,db_helpdesk.hardware.id_perusahaan,kmg.perusahaan.singkat,kmg.brand.nama_brand,kmg.perusahaan.lokasi,kmg.karyawan.nama_karyawan,kmg.karyawan.handphone,kmg.karyawan.email,db_helpdesk.hardware.jenis_hardware,db_helpdesk.hardware.noaset_hardware,db_helpdesk.hardware.merk_hardware,db_helpdesk.hardware.type_hardware,db_helpdesk.hardware.sn_hardware,db_helpdesk.hardware.harga_hardware,db_helpdesk.hardware.kondisi_hardware,db_helpdesk.hardware.tgl_hardware,db_helpdesk.hardware.status_hardware FROM kmg.karyawan,db_helpdesk.hardware,kmg.perusahaan,kmg.brand WHERE kmg.karyawan.nik = db_helpdesk.hardware.nik AND db_helpdesk.hardware.id_perusahaan AND kmg.brand.id_brand =kmg.perusahaan.id_brand =kmg.perusahaan.id_perusahaan AND db_helpdesk.hardware.id_perusahaan='$per'");
		return $query;
	}

 	public function insert($dt){
 		$this->db_helpdesk->insert("hardware",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_helpdesk->update("hardware",$dt,$id);
 	}

 	public function delete($id){
 		$this->db_helpdesk->delete("hardware",$id);
 	}


	public function cari_max_hardware(){
		$q = $this->db_helpdesk->query("SELECT MAX(id_hardware) as no FROM hardware");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}


}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
