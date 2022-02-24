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
}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
