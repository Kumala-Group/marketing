<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Model_karyawan extends CI_Model {

	public function all()
	{
		$q = $this->db_helpdesk->query("SELECT nik, nama_karyawan, tgl_mulai_kerja FROM kmg.karyawan");
		return $q;
	}

}