<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_isi extends CI_Model
{

	public function n_stok_kritis()
	{
		$q = $this->db_ban->query("SELECT COUNT(id) as id FROM n_stok_kritis");
		foreach ($q->result() as $dt) {
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}
	public function statusOK()
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_perusahaan) as id FROM absensi WHERE status = 'OK'");
		foreach ($q->result() as $dt) {
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}
	public function n_tiket($nik)
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_t_solv) as id FROM t_solving WHERE nik_exe = '$nik'");
		foreach ($q->result() as $dt) {
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}
	public function n_baru()
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_n_baru) as id FROM n_baru");
		foreach ($q->result() as $dt) {
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}
	public function statusTROUBLE()
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_perusahaan) as id FROM absensi WHERE status = 'TROUBLE'");
		foreach ($q->result() as $dt) {
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}
	public function statusNO()
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_perusahaan) as id FROM absensi WHERE status = 'NO DATA'");
		foreach ($q->result() as $dt) {
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}

	public function n_jt()
	{
		$q = $this->db_ban->query("SELECT COUNT(id) as id FROM n_jt");
		foreach ($q->result() as $dt) {
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}

	public function data_n_stok_kritis()
	{
		$this->db_ban->select('nsk.*,o.nama_ban,o.stock_kritis,g.nama_gudang')
			->from('n_stok_kritis nsk')
			->join('ban o', 'nsk.kode_ban = o.kode_ban')
			->join('gudang g', 'nsk.kode_gudang = g.kode_gudang');
		$q = $this->db_ban->get();
		return $q;
	}

	public function data_n_jt()
	{
		$this->db_ban->select('njt.*,p.nama_pelanggan')
			->from('n_jt njt')
			->join('pelanggan p', 'njt.kode_pelanggan = p.kode_pelanggan');
		$q = $this->db_ban->get();
		return $q;
	}

	public function jml_data($table)
	{
		$q = $this->db_ban->get($table);
		return $q->num_rows();
	}

	//Ambil jumlah pengaduan client
	public function pengaduan_total($nik)
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) as id FROM tabel_pengaduan WHERE nik = '$nik'");
		foreach ($q->result() as $dt) {
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}
	public function pengaduan_open($nik)
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) as id FROM tabel_pengaduan WHERE nik = '$nik' AND status_pengaduan= 'O'");
		foreach ($q->result() as $dt) {
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}
	public function pengaduan_working($nik)
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) as id FROM tabel_pengaduan WHERE nik = '$nik' AND status_pengaduan= 'W'");
		foreach ($q->result() as $dt) {
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}
	public function pengaduan_pending($nik)
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) as id FROM tabel_pengaduan WHERE nik = '$nik' AND status_pengaduan= 'P'");
		foreach ($q->result() as $dt) {
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}
	public function pengaduan_solved($nik)
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) as id FROM tabel_pengaduan WHERE nik = '$nik' AND status_pengaduan= 'S'");
		foreach ($q->result() as $dt) {
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}

	//Isi Dashboard Pengaduan Per Bulan
	public function pengaduan_total_bulan()
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) as id FROM tabel_pengaduan WHERE YEAR(tanggal_pengaduan) = 
		YEAR(CURRENT_DATE) AND MONTH(tanggal_pengaduan) = MONTH(CURRENT_DATE)");
		foreach ($q->result() as $dt) {
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}
	public function pengaduan_open_bulan()
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) as id FROM tabel_pengaduan WHERE YEAR(tanggal_pengaduan) = 
		YEAR(CURRENT_DATE) AND MONTH(tanggal_pengaduan) = MONTH(CURRENT_DATE) AND status_pengaduan = 'O'");
		foreach ($q->result() as $dt) {
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}
	public function pengaduan_working_bulan()
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) as id FROM tabel_pengaduan WHERE YEAR(tanggal_pengaduan) = 
		YEAR(CURRENT_DATE) AND MONTH(tanggal_pengaduan) = MONTH(CURRENT_DATE) AND status_pengaduan = 'W'");
		foreach ($q->result() as $dt) {
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}
	public function pengaduan_pending_bulan()
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) as id FROM tabel_pengaduan WHERE YEAR(tanggal_pengaduan) = 
		YEAR(CURRENT_DATE) AND MONTH(tanggal_pengaduan) = MONTH(CURRENT_DATE) AND status_pengaduan = 'P'");
		foreach ($q->result() as $dt) {
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}
	public function pengaduan_solved_bulan()
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) as id FROM tabel_pengaduan WHERE YEAR(tanggal_pengaduan) = 
		YEAR(CURRENT_DATE) AND MONTH(tanggal_pengaduan) = MONTH(CURRENT_DATE) AND status_pengaduan = 'S'");
		foreach ($q->result() as $dt) {
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}
	public function pengaduan_cancel_bulan()
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) as id FROM tabel_pengaduan WHERE YEAR(tanggal_pengaduan) = 
		YEAR(CURRENT_DATE) AND MONTH(tanggal_pengaduan) = MONTH(CURRENT_DATE) AND status_pengaduan = 'C'");
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
	public function pengaduan_open_type()
	{
		$q = $this->db_helpdesk->query("SELECT id_type, count(id_pengaduan) as id FROM tabel_type_pengaduan LEFT JOIN tabel_pengaduan ON 
		id_type = type_pengaduan AND status_pengaduan = 'O' AND YEAR(tanggal_pengaduan) = YEAR(CURRENT_DATE) AND MONTH(tanggal_pengaduan) = 
		MONTH(CURRENT_DATE) GROUP BY id_type ORDER BY id_type ASC");
		foreach ($q->result_array() as $row)
		{
			$hasil[]= (int) $row['id'];
		}
		return $hasil;
	}
	public function pengaduan_working_type()
	{
		$q = $this->db_helpdesk->query("SELECT id_type, count(id_pengaduan) as id FROM tabel_type_pengaduan LEFT JOIN tabel_pengaduan ON 
		id_type = type_pengaduan AND status_pengaduan = 'W' AND YEAR(tanggal_pengaduan) = YEAR(CURRENT_DATE) AND MONTH(tanggal_pengaduan) = 
		MONTH(CURRENT_DATE) GROUP BY id_type ORDER BY id_type ASC");
		foreach ($q->result_array() as $row)
		{
			$hasil[]= (int) $row['id'];
		}
		return $hasil;
	}
	public function pengaduan_pending_type()
	{
		$q = $this->db_helpdesk->query("SELECT id_type, count(id_pengaduan) as id FROM tabel_type_pengaduan LEFT JOIN tabel_pengaduan ON 
		id_type = type_pengaduan AND status_pengaduan = 'P' AND YEAR(tanggal_pengaduan) = YEAR(CURRENT_DATE) AND MONTH(tanggal_pengaduan) = 
		MONTH(CURRENT_DATE) GROUP BY id_type ORDER BY id_type ASC");
		foreach ($q->result_array() as $row)
		{
			$hasil[]= (int) $row['id'];
		}
		return $hasil;
	}
	public function pengaduan_solved_type()
	{
		$q = $this->db_helpdesk->query("SELECT id_type, count(id_pengaduan) as id FROM tabel_type_pengaduan LEFT JOIN tabel_pengaduan ON 
		id_type = type_pengaduan AND status_pengaduan = 'S' AND YEAR(tanggal_pengaduan) = YEAR(CURRENT_DATE) AND MONTH(tanggal_pengaduan) = 
		MONTH(CURRENT_DATE) GROUP BY id_type ORDER BY id_type ASC");
		foreach ($q->result_array() as $row)
		{
			$hasil[]= (int) $row['id'];
		}
		return $hasil;
	}
	public function pengaduan_cancel_type()
	{
		$q = $this->db_helpdesk->query("SELECT id_type, count(id_pengaduan) as id FROM tabel_type_pengaduan LEFT JOIN tabel_pengaduan ON 
		id_type = type_pengaduan AND status_pengaduan = 'C' AND YEAR(tanggal_pengaduan) = YEAR(CURRENT_DATE) AND MONTH(tanggal_pengaduan) = 
		MONTH(CURRENT_DATE) GROUP BY id_type ORDER BY id_type ASC");
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
	public function pengaduan_open_brand()
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) AS id FROM (kmg.brand LEFT JOIN kmg.perusahaan ON kmg.brand.id_brand = 
		kmg.perusahaan.id_brand) LEFT JOIN db_helpdesk.tabel_pengaduan ON kmg.perusahaan.id_perusahaan = db_helpdesk.tabel_pengaduan.id_perusahaan 
		AND db_helpdesk.tabel_pengaduan.status_pengaduan = 'O' AND YEAR(tanggal_pengaduan) = YEAR(CURRENT_DATE) AND MONTH(tanggal_pengaduan) = 
		MONTH(CURRENT_DATE)GROUP BY kmg.brand.id_brand ORDER BY kmg.brand.id_brand ASC");
		foreach ($q->result_array() as $row)
		{
			$hasil[]= (int) $row['id'];
		}
		return $hasil;
	}
	public function pengaduan_working_brand()
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) AS id FROM (kmg.brand LEFT JOIN kmg.perusahaan ON kmg.brand.id_brand = 
		kmg.perusahaan.id_brand) LEFT JOIN db_helpdesk.tabel_pengaduan ON kmg.perusahaan.id_perusahaan = db_helpdesk.tabel_pengaduan.id_perusahaan 
		AND db_helpdesk.tabel_pengaduan.status_pengaduan = 'W' AND YEAR(tanggal_pengaduan) = YEAR(CURRENT_DATE) AND MONTH(tanggal_pengaduan) = 
		MONTH(CURRENT_DATE)GROUP BY kmg.brand.id_brand ORDER BY kmg.brand.id_brand ASC");
		foreach ($q->result_array() as $row)
		{
			$hasil[]= (int) $row['id'];
		}
		return $hasil;
	}
	public function pengaduan_pending_brand()
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) AS id FROM (kmg.brand LEFT JOIN kmg.perusahaan ON kmg.brand.id_brand = 
		kmg.perusahaan.id_brand) LEFT JOIN db_helpdesk.tabel_pengaduan ON kmg.perusahaan.id_perusahaan = db_helpdesk.tabel_pengaduan.id_perusahaan 
		AND db_helpdesk.tabel_pengaduan.status_pengaduan = 'P' AND YEAR(tanggal_pengaduan) = YEAR(CURRENT_DATE) AND MONTH(tanggal_pengaduan) = 
		MONTH(CURRENT_DATE)GROUP BY kmg.brand.id_brand ORDER BY kmg.brand.id_brand ASC");
		foreach ($q->result_array() as $row)
		{
			$hasil[]= (int) $row['id'];
		}
		return $hasil;
	}
	public function pengaduan_solved_brand()
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) AS id FROM (kmg.brand LEFT JOIN kmg.perusahaan ON kmg.brand.id_brand = 
		kmg.perusahaan.id_brand) LEFT JOIN db_helpdesk.tabel_pengaduan ON kmg.perusahaan.id_perusahaan = db_helpdesk.tabel_pengaduan.id_perusahaan 
		AND db_helpdesk.tabel_pengaduan.status_pengaduan = 'S' AND YEAR(tanggal_pengaduan) = YEAR(CURRENT_DATE) AND MONTH(tanggal_pengaduan) = 
		MONTH(CURRENT_DATE)GROUP BY kmg.brand.id_brand ORDER BY kmg.brand.id_brand ASC");
		foreach ($q->result_array() as $row)
		{
			$hasil[]= (int) $row['id'];
		}
		return $hasil;
	}
	public function pengaduan_cancel_brand()
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) AS id FROM (kmg.brand LEFT JOIN kmg.perusahaan ON kmg.brand.id_brand = 
		kmg.perusahaan.id_brand) LEFT JOIN db_helpdesk.tabel_pengaduan ON kmg.perusahaan.id_perusahaan = db_helpdesk.tabel_pengaduan.id_perusahaan 
		AND db_helpdesk.tabel_pengaduan.status_pengaduan = 'C' AND YEAR(tanggal_pengaduan) = YEAR(CURRENT_DATE) AND MONTH(tanggal_pengaduan) = 
		MONTH(CURRENT_DATE)GROUP BY kmg.brand.id_brand ORDER BY kmg.brand.id_brand ASC");
		foreach ($q->result_array() as $row)
		{
			$hasil[]= (int) $row['id'];
		}
		return $hasil;
	}

	//Grafik status jenis masalah
	public function pengaduan_jenis_masalah($jenis)
	{
		$q = $this->db_helpdesk->query("SELECT COUNT(id_pengaduan) as id FROM tabel_pengaduan WHERE YEAR(tanggal_pengaduan) = YEAR(CURRENT_DATE)
		AND MONTH(tanggal_pengaduan) = MONTH(CURRENT_DATE) AND jenis_masalah = '$jenis'");
		foreach ($q->result() as $dt) {
			$hasil = (int)$dt->id;
		}
		return $hasil;
	}
}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
