<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_ticketing_laporan extends CI_Model
{
	//Ambil data laporan berdasarkan tahun bulan
	public function get_laporan($tahun, $bulan)
	{
		$q = $this->db_helpdesk->query("SELECT db_helpdesk.tabel_pengaduan.id_pengaduan,kmg.karyawan.nik,nama_karyawan,nama_brand,lokasi,
		type_pengaduan,jenis_masalah,keterangan,priority,status_pengaduan,nik_eksekutor,nama_eksekutor,status_solving,tanggal_pengaduan,
		tanggal_selesai,tanggal_mulai,estimasi FROM (((db_helpdesk.tabel_pengaduan INNER JOIN kmg.perusahaan on 
		kmg.perusahaan.id_perusahaan=db_helpdesk.tabel_pengaduan.id_perusahaan) INNER JOIN kmg.brand on kmg.brand.id_brand= kmg.perusahaan.id_brand) 
		INNER JOIN kmg.karyawan on kmg.karyawan.nik=db_helpdesk.tabel_pengaduan.nik) LEFT JOIN db_helpdesk.tabel_solving ON 
		db_helpdesk.tabel_solving.id_pengaduan=db_helpdesk.tabel_pengaduan.id_pengaduan AND tanggal_selesai = tanggal_solving AND 
		status_pengaduan = status_solving WHERE MONTH(tanggal_pengaduan) = '$bulan' AND YEAR(tanggal_pengaduan) = '$tahun' GROUP BY 
		db_helpdesk.tabel_pengaduan.id_pengaduan ORDER BY db_helpdesk.tabel_pengaduan.id_pengaduan ASC
							   ");			   
		return $q;
	}

	//Grafik Status Pengaduan
	public function pengaduan_total_bulan($tahun, $bulan)
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) as id FROM tabel_pengaduan WHERE YEAR(tanggal_pengaduan) = 
		'$tahun' AND MONTH(tanggal_pengaduan) = '$bulan'");
		foreach ($q->result() as $dt) {
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}
	public function pengaduan_open_bulan($tahun, $bulan)
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) as id FROM tabel_pengaduan WHERE YEAR(tanggal_pengaduan) = 
		'$tahun' AND MONTH(tanggal_pengaduan) = '$bulan' AND status_pengaduan = 'O'");
		foreach ($q->result() as $dt) {
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}
	public function pengaduan_working_bulan($tahun, $bulan)
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) as id FROM tabel_pengaduan WHERE YEAR(tanggal_pengaduan) = 
		'$tahun' AND MONTH(tanggal_pengaduan) = '$bulan' AND status_pengaduan = 'W'");
		foreach ($q->result() as $dt) {
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}
	public function pengaduan_pending_bulan($tahun, $bulan)
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) as id FROM tabel_pengaduan WHERE YEAR(tanggal_pengaduan) = 
		'$tahun' AND MONTH(tanggal_pengaduan) = '$bulan' AND status_pengaduan = 'P'");
		foreach ($q->result() as $dt) {
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}
	public function pengaduan_solved_bulan($tahun, $bulan)
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) as id FROM tabel_pengaduan WHERE YEAR(tanggal_pengaduan) = 
		'$tahun' AND MONTH(tanggal_pengaduan) = '$bulan' AND status_pengaduan = 'S'");
		foreach ($q->result() as $dt) {
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}
	public function pengaduan_cancel_bulan($tahun, $bulan)
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) as id FROM tabel_pengaduan WHERE YEAR(tanggal_pengaduan) = 
		'$tahun' AND MONTH(tanggal_pengaduan) = '$bulan' AND status_pengaduan = 'C'");
		foreach ($q->result() as $dt) {
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}

	//Grafik Status Type
	public function pengaduan_type()
	{
		$q = $this->db_helpdesk->query("SELECT nama_type FROM tabel_type_pengaduan ORDER BY id_type ASC");
		foreach ($q->result_array() as $row)
		{
			$hasil[]= $row['nama_type'];
		}
		return $hasil;
	}
	public function pengaduan_open_type($tahun, $bulan)
	{
		$q = $this->db_helpdesk->query("SELECT id_type, count(id_pengaduan) as id FROM tabel_type_pengaduan LEFT JOIN tabel_pengaduan ON 
		id_type = type_pengaduan AND status_pengaduan = 'O' AND YEAR(tanggal_pengaduan) = '$tahun' AND MONTH(tanggal_pengaduan) = 
		'$bulan' GROUP BY id_type ORDER BY id_type ASC");
		foreach ($q->result_array() as $row)
		{
			$hasil[]= (int) $row['id'];
		}
		return $hasil;
	}
	public function pengaduan_working_type($tahun, $bulan)
	{
		$q = $this->db_helpdesk->query("SELECT id_type, count(id_pengaduan) as id FROM tabel_type_pengaduan LEFT JOIN tabel_pengaduan ON 
		id_type = type_pengaduan AND status_pengaduan = 'W' AND YEAR(tanggal_pengaduan) = '$tahun' AND MONTH(tanggal_pengaduan) = 
		'$bulan' GROUP BY id_type ORDER BY id_type ASC");
		foreach ($q->result_array() as $row)
		{
			$hasil[]= (int) $row['id'];
		}
		return $hasil;
	}
	public function pengaduan_pending_type($tahun, $bulan)
	{
		$q = $this->db_helpdesk->query("SELECT id_type, count(id_pengaduan) as id FROM tabel_type_pengaduan LEFT JOIN tabel_pengaduan ON 
		id_type = type_pengaduan AND status_pengaduan = 'P' AND YEAR(tanggal_pengaduan) = '$tahun' AND MONTH(tanggal_pengaduan) = 
		'$bulan' GROUP BY id_type ORDER BY id_type ASC");
		foreach ($q->result_array() as $row)
		{
			$hasil[]= (int) $row['id'];
		}
		return $hasil;
	}
	public function pengaduan_solved_type($tahun, $bulan)
	{
		$q = $this->db_helpdesk->query("SELECT id_type, count(id_pengaduan) as id FROM tabel_type_pengaduan LEFT JOIN tabel_pengaduan ON 
		id_type = type_pengaduan AND status_pengaduan = 'S' AND YEAR(tanggal_pengaduan) = '$tahun' AND MONTH(tanggal_pengaduan) = 
		'$bulan' GROUP BY id_type ORDER BY id_type ASC");
		foreach ($q->result_array() as $row)
		{
			$hasil[]= (int) $row['id'];
		}
		return $hasil;
	}
	public function pengaduan_cancel_type($tahun, $bulan)
	{
		$q = $this->db_helpdesk->query("SELECT id_type, count(id_pengaduan) as id FROM tabel_type_pengaduan LEFT JOIN tabel_pengaduan ON 
		id_type = type_pengaduan AND status_pengaduan = 'C' AND YEAR(tanggal_pengaduan) = '$tahun' AND MONTH(tanggal_pengaduan) = 
		'$bulan' GROUP BY id_type ORDER BY id_type ASC");
		foreach ($q->result_array() as $row)
		{
			$hasil[]= (int) $row['id'];
		}
		return $hasil;
	}

	//Grafik Status dan Brand
	public function pengaduan_brand()
	{
		$q = $this->db->query("SELECT nama_brand FROM brand ORDER BY id_brand ASC");
		foreach ($q->result_array() as $row)
		{
			$hasil[]= $row['nama_brand'];
		}
		return $hasil;
	}
	public function pengaduan_open_brand($tahun, $bulan)
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) AS id FROM (kmg.brand LEFT JOIN kmg.perusahaan ON kmg.brand.id_brand = 
		kmg.perusahaan.id_brand) LEFT JOIN db_helpdesk.tabel_pengaduan ON kmg.perusahaan.id_perusahaan = db_helpdesk.tabel_pengaduan.id_perusahaan 
		AND db_helpdesk.tabel_pengaduan.status_pengaduan = 'O' AND YEAR(tanggal_pengaduan) = '$tahun' AND MONTH(tanggal_pengaduan) = 
		'$bulan' GROUP BY kmg.brand.id_brand ORDER BY kmg.brand.id_brand ASC");
		foreach ($q->result_array() as $row)
		{
			$hasil[]= (int) $row['id'];
		}
		return $hasil;
	}
	public function pengaduan_working_brand($tahun, $bulan)
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) AS id FROM (kmg.brand LEFT JOIN kmg.perusahaan ON kmg.brand.id_brand = 
		kmg.perusahaan.id_brand) LEFT JOIN db_helpdesk.tabel_pengaduan ON kmg.perusahaan.id_perusahaan = db_helpdesk.tabel_pengaduan.id_perusahaan 
		AND db_helpdesk.tabel_pengaduan.status_pengaduan = 'W' AND YEAR(tanggal_pengaduan) = '$tahun' AND MONTH(tanggal_pengaduan) = 
		'$bulan' GROUP BY kmg.brand.id_brand ORDER BY kmg.brand.id_brand ASC");
		foreach ($q->result_array() as $row)
		{
			$hasil[]= (int) $row['id'];
		}
		return $hasil;
	}
	public function pengaduan_pending_brand($tahun, $bulan)
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) AS id FROM (kmg.brand LEFT JOIN kmg.perusahaan ON kmg.brand.id_brand = 
		kmg.perusahaan.id_brand) LEFT JOIN db_helpdesk.tabel_pengaduan ON kmg.perusahaan.id_perusahaan = db_helpdesk.tabel_pengaduan.id_perusahaan 
		AND db_helpdesk.tabel_pengaduan.status_pengaduan = 'P' AND YEAR(tanggal_pengaduan) = '$tahun' AND MONTH(tanggal_pengaduan) = 
		'$bulan' GROUP BY kmg.brand.id_brand ORDER BY kmg.brand.id_brand ASC");
		foreach ($q->result_array() as $row)
		{
			$hasil[]= (int) $row['id'];
		}
		return $hasil;
	}
	public function pengaduan_solved_brand($tahun, $bulan)
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) AS id FROM (kmg.brand LEFT JOIN kmg.perusahaan ON kmg.brand.id_brand = 
		kmg.perusahaan.id_brand) LEFT JOIN db_helpdesk.tabel_pengaduan ON kmg.perusahaan.id_perusahaan = db_helpdesk.tabel_pengaduan.id_perusahaan 
		AND db_helpdesk.tabel_pengaduan.status_pengaduan = 'S' AND YEAR(tanggal_pengaduan) = '$tahun' AND MONTH(tanggal_pengaduan) = 
		'$bulan' GROUP BY kmg.brand.id_brand ORDER BY kmg.brand.id_brand ASC");
		foreach ($q->result_array() as $row)
		{
			$hasil[]= (int) $row['id'];
		}
		return $hasil;
	}
	public function pengaduan_cancel_brand($tahun, $bulan)
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) AS id FROM (kmg.brand LEFT JOIN kmg.perusahaan ON kmg.brand.id_brand = 
		kmg.perusahaan.id_brand) LEFT JOIN db_helpdesk.tabel_pengaduan ON kmg.perusahaan.id_perusahaan = db_helpdesk.tabel_pengaduan.id_perusahaan 
		AND db_helpdesk.tabel_pengaduan.status_pengaduan = 'C' AND YEAR(tanggal_pengaduan) = '$tahun' AND MONTH(tanggal_pengaduan) = 
		'$bulan' GROUP BY kmg.brand.id_brand ORDER BY kmg.brand.id_brand ASC");
		foreach ($q->result_array() as $row)
		{
			$hasil[]= (int) $row['id'];
		}
		return $hasil;
	}

	//Grafik status jenis masalah
	public function pengaduan_jenis_masalah($tahun, $bulan, $jenis)
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) as id FROM tabel_pengaduan WHERE YEAR(tanggal_pengaduan) = '$tahun'
		AND MONTH(tanggal_pengaduan) = $bulan AND jenis_masalah = '$jenis'");
		foreach ($q->result() as $dt) {
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */