<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_ticketing_client extends CI_Model
{

	//ambil data semua pengaduan
	public function all($id)
	{
		$q = $this->db_helpdesk->query("SELECT id_pengaduan,kmg.karyawan.nik,nama_karyawan,nama_brand,lokasi,tanggal_pengaduan,tanggal_selesai,type_pengaduan,
		jenis_masalah,keterangan,priority,status_pengaduan FROM ((db_helpdesk.tabel_pengaduan INNER JOIN kmg.perusahaan on 
		kmg.perusahaan.id_perusahaan=db_helpdesk.tabel_pengaduan.id_perusahaan) INNER JOIN kmg.brand on kmg.brand.id_brand=kmg.perusahaan.id_brand ) 
		INNER JOIN kmg.karyawan on kmg.karyawan.nik=db_helpdesk.tabel_pengaduan.nik WHERE tabel_pengaduan.nik = '$id' ORDER BY 
		tabel_pengaduan.tanggal_pengaduan DESC
                               ");
		return $q;
	}
	/*
	public function all_pengaduan_karyawan($id)
	{
		$q = $this->db_helpdesk->query("SELECT id_pengaduan,kmg.karyawan.nik,nama_karyawan,nama_brand,lokasi,
		tanggal_pengaduan,keterangan,priority,status_pengaduan FROM 
		((db_helpdesk.tabel_pengaduan INNER JOIN kmg.perusahaan on kmg.perusahaan.id_perusahaan=db_helpdesk.tabel_pengaduan.id_perusahaan) 
		INNER JOIN kmg.brand on kmg.brand.id_brand=kmg.perusahaan.id_brand ) INNER JOIN kmg.karyawan on kmg.karyawan.nik=db_helpdesk.tabel_pengaduan.nik WHERE 
		status_pengaduan != 'S' AND tabel_pengaduan.nik='$id' ORDER BY `tabel_pengaduan`.`tanggal_pengaduan` ASC
                               ");
		return $q;
	}
	*/

	//Simpan Pengaduan
	public function insert_pengaduan($dt)
	{
		$this->db_helpdesk->insert("tabel_pengaduan", $dt);
	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */