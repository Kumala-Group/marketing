<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_data extends CI_Model
{
	public function getlokasiperusahaan($id)
	{
		$data = $this->db->get_where('perusahaan', ['id_perusahaan' => $id])->row('lokasi');
		return $data;
	}

	public function nama_perusahaan_singkat($id)
	{
		$this->db->where('id_perusahaan', $id);
		$q = $this->db->get('perusahaan');
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $dt) {
				$hasil = $dt->singkat . ' - ' . $dt->lokasi;
			}
		} else {
			$hasil = '';
		}
		return $hasil;
	}

	public function nama_perusahaan_singkat2($id)
	{
		$this->db->where('id_perusahaan', $id);
		$q = $this->db->get('perusahaan');
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $dt) {
				$hasil = $dt->singkat . '/' . $dt->lokasi;
			}
		} else {
			$hasil = '';
		}
		return $hasil;
	}


	public function BrandToKaryawan($id)
	{
		$this->db->where('id_brand', $id);
		$q = $this->db->get('brand');
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $dt) {
				$hasil = $dt->nama_brand;
			}
		} else {
			$hasil = '';
		}
		return $hasil;
	}

	public function JabatanToKaryawan($id)
	{
		$this->db->where('id_jabatan', $id);
		$q = $this->db->get('jabatan');
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $dt) {
				$hasil = $dt->nama_jabatan;
			}
		} else {
			$hasil = '';
		}
		return $hasil;
	}

	public function nama_perusahaan($id)
	{
		$q = $this->db->query("SELECT * FROM perusahaan WHERE id_perusahaan='$id'");
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $dt) {
				$hasil = $dt->nama_perusahaan;
			}
		} else {
			$hasil = '';
		}
		return $hasil;
	}

	public function detail_perusahaan($id)
	{
		$hasil = array();
		$query = $this->db->query("SELECT * FROM perusahaan WHERE id_perusahaan='$id'");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $dt) {
				$hasil = array(
					'nama'		=> $dt->nama_perusahaan,
					'alamat'	=> $dt->alamat,
					'telepon'	=> $dt->telepon,
					'fax'		=> $dt->fax,
				);
			}
		}
		return $hasil;
	}

	/*** cari_data **/
	public function cari_id_username($u)
	{
		$q = $this->db->query("SELECT id_user FROM admins WHERE username='$u'");
		foreach ($q->result() as $dt) {
			$hasil = $dt->id_user;
		}
		return $hasil;
	}

	/*** get_data Nama Karyawan **/
	public function get_nama_karyawan($id_karyawan)
	{
		$data = $this->db->get_where('karyawan', ['id_karyawan' => $id_karyawan]);
		return ($data->num_rows() > 0 ? $data->row("nama_karyawan") : "");
	}

	/*** get_data Nama Perusahaan / Lokasi **/
	public function get_nama_perusahaan($id_perusahaan)
	{
		$this->db->select("lokasi");
		$this->db->from("perusahaan");
		$this->db->where("id_perusahaan", $id_perusahaan);
		$data = $this->db->get();
		return ($data->num_rows() > 0 ? $data->row("lokasi") : "");
	}

	/*** jumlah data ***/
	public function jml_data($table)
	{
		$q = $this->db->get($table);
		return $q->num_rows();
	}

	/* Query : DMS Versi Update */
	public function get_versi_dms($nama_brand)
	{
		$data = $this->db_helpdesk->select('MAX(versi_update) as versi_update')->where('brand', strtoupper($nama_brand))->get('update_versi');
		return ($data->num_rows() > 0 ? $data->row("versi_update") : "");
	}
}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
