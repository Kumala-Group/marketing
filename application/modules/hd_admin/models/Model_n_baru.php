<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_n_baru extends CI_Model {

  /*public function all(){
		$q = $this->db->query("SELECT hb.id_n_baru,hb.nik_baru, kb.nama_brand, kp.lokasi, kk.nama_karyawan,kk.handphone, kk.tgl_mulai_kerja, kj.nama_jabatan
      FROM kmg.karyawan kk ,db_helpdesk.n_baru hb,kmg.perusahaan kp, kmg.brand kb, kmg.jabatan kj
      WHERE kk.nik = hb.nik_baru
      AND kk.id_perusahaan = kp.id_perusahaan
      AND kb.id_brand = kp.id_brand
      AND kj.id_jabatan =kk.id_jabatan
      ORDER BY kk.tgl_mulai_kerja ASC");
		return $q;
	}*/

  public function all(){
		$q = $this->db_helpdesk->query("SELECT nb.id_n_baru, nb.nik_baru AS nik, k.nama_karyawan, p.nama_perusahaan, p.lokasi, j.nama_jabatan, k.tgl_mulai_kerja FROM n_baru nb
      LEFT JOIN kmg.karyawan k ON k.nik = nb.nik_baru
      LEFT JOIN kmg.perusahaan p ON p.id_perusahaan = k.id_perusahaan
      LEFT JOIN kmg.jabatan j ON j.id_jabatan = k.id_jabatan
      ORDER BY nb.id_n_baru ASC");
		return $q;
	}

	public function delete($id){
 		$this->db_helpdesk->delete("n_baru",$id);
 	}

	public function ada($id)
	{
		$q 	 = $this->db_helpdesk->get_where("n_baru",$id);
		$row = $q->num_rows();

		return $row > 0;
	}


}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
