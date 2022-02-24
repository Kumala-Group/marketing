<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_ticketing extends CI_Model
{


	public function all()
	{
		$q = $this->db_helpdesk->query("SELECT id_tiket,kmg.karyawan.nik,nama_karyawan,nama_brand,lokasi,tgl_tiket,
      wkt_tiket,masalah,priority,status_tiket FROM ((db_helpdesk.tiket INNER JOIN kmg.perusahaan on
        kmg.perusahaan.id_perusahaan=db_helpdesk.tiket.id_perusahaan) INNER JOIN kmg.brand on kmg.brand.id_brand=kmg.perusahaan.id_brand )
        INNER JOIN kmg.karyawan on kmg.karyawan.nik=db_helpdesk.tiket.nik WHERE status_tiket != 'Solved' ORDER BY priority ASC,tgl_tiket DESC,wkt_tiket DESC
                               ");
		return $q;
	}
	public function alldone()
	{
		$q = $this->db_helpdesk->query("SELECT id_tiket,kmg.karyawan.nik,nama_karyawan,nama_brand,lokasi,tgl_tiket,
      wkt_tiket,masalah,priority,status_tiket FROM ((db_helpdesk.tiket INNER JOIN kmg.perusahaan on
        kmg.perusahaan.id_perusahaan=db_helpdesk.tiket.id_perusahaan) INNER JOIN kmg.brand on kmg.brand.id_brand=kmg.perusahaan.id_brand )
        INNER JOIN kmg.karyawan on kmg.karyawan.nik=db_helpdesk.tiket.nik WHERE status_tiket = 'Solved' ORDER BY priority ASC,tgl_tiket DESC,wkt_tiket DESC
                               ");
		return $q;
	}
	public function dataTiket($per)
	{
		$query = $this->db_helpdesk->query("SELECT id_tiket,kmg.karyawan.nik,nama_karyawan,nama_brand,lokasi,tgl_tiket,
      wkt_tiket,masalah,priority,status_tiket FROM ((db_helpdesk.tiket INNER JOIN kmg.perusahaan on
        kmg.perusahaan.id_perusahaan=db_helpdesk.tiket.id_perusahaan) INNER JOIN kmg.brand on kmg.brand.id_brand=kmg.perusahaan.id_brand )
        INNER JOIN kmg.karyawan on kmg.karyawan.nik=db_helpdesk.tiket.nik WHERE id_tiket='$per'");
		return $query;
	}

	public function allbykaryawan($per)
	{
		$query = $this->db_helpdesk->query("SELECT * FROM (((db_helpdesk.tiket INNER JOIN kmg.perusahaan on kmg.perusahaan.id_perusahaan=db_helpdesk.tiket.id_perusahaan) INNER JOIN kmg.brand on kmg.brand.id_brand=kmg.perusahaan.id_brand )
INNER JOIN kmg.karyawan on kmg.karyawan.nik=db_helpdesk.tiket.nik )INNER JOIN db_helpdesk.t_solving on db_helpdesk.t_solving.id_tiket=db_helpdesk.tiket.id_tiket WHERE nik_exe='$per' ORDER BY priority ASC,tgl_tiket DESC,wkt_tiket DESC");
		return $query;
	}

	public function get($id)
	{
		$q 	 = $this->db_helpdesk->get_where("tiket", $id);
		$rows = $q->num_rows();

		if ($rows > 0) {
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
	}

	public function last_kode()
	{
		$q = $this->db_helpdesk->query("SELECT MAX(right(no_inv_pengiriman,3)) as kode FROM ticketing ");
		$row = $q->num_rows();

		if ($row > 0) {
			$rows = $q->result();
			$hasil = (int) $rows[0]->kode;
		} else {
			$hasil = 0;
		}
		return $hasil;
	}

	public function ada_id_pesanan($id)
	{
		$q 	 = $this->db_helpdesk->get_where("pengiriman", $id);
		$row = $q->num_rows();
		return $row > 0;
	}

	public function t_ada_id_pesanan($id)
	{
		$q 	 = $this->db_helpdesk->get_where("t_pengiriman", $id);
		$row = $q->num_rows();
		return $row > 0;
	}

	public function ada($id)
	{
		$q 	 = $this->db_helpdesk->get_where("tiket", $id);
		$row = $q->num_rows();

		return $row > 0;
	}
	public function adatsolv($id)
	{
		$q 	 = $this->db_helpdesk->get_where("t_solving", $id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function cari_max_ticketing()
	{
		$q = $this->db_helpdesk->query("SELECT MAX(id_tiket) as no FROM tiket");
		foreach ($q->result() as $dt) {
			$no = (int) $dt->no + 1;
		}
		return $no;
	}
	public function cari_max_solv()
	{
		$q = $this->db_helpdesk->query("SELECT MAX(id_solv) as no FROM solving");
		foreach ($q->result() as $dt) {
			$no = (int) $dt->no + 1;
		}
		return $no;
	}

	public function insert($dt)
	{
		$this->db_helpdesk->insert("tiket", $dt);
	}
	public function insert_t_solv($dt)
	{
		$this->db_helpdesk->insert("t_solving", $dt);
	}
	public function insertsolv($dt)
	{
		$this->db_helpdesk->insert("solving", $dt);
	}
	public function update($id, $dts)
	{
		$this->db_helpdesk->update("tiket", $dts, $id);
	}
	public function updatetsolv($id, $dts)
	{
		$this->db_helpdesk->update("t_solving", $dts, $id);
	}

	public function delete($id)
	{
		$this->db_helpdesk->delete("ticketing", $id);
	}
	public function delete_tsolv($id)
	{
		$this->db_helpdesk->delete("t_solving", $id);
	}
}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */