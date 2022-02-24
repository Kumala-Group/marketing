<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_jenis_hardware extends CI_Model
{

	public function all()
	{
		$q = $this->db_helpdesk->get('jenis_hardware');
		return $q;
	}

	public function get($id)
	{
		$q 	 = $this->db_helpdesk->get_where("jenis_hardware", $id);
		$rows = $q->num_rows();

		if ($rows > 0) {
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
	}


	public function ada($id)
	{
		$q 	 = $this->db_helpdesk->get_where("jenis_hardware", $id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function delete($id)
	{
		$this->db_helpdesk->delete("jenis_hardware", $id);
	}

	public function cari_max_jenis_hardware()
	{
		$q = $this->db_helpdesk->query("SELECT MAX(id_jenis_hardware) as no FROM jenis_hardware");
		foreach ($q->result() as $dt) {
			$no = (int)$dt->no + 1;
		}
		return $no;
	}

	public function insert($dt)
	{
		$this->db_helpdesk->insert("jenis_hardware", $dt);
	}

	public function update($id, $dt)
	{
		$this->db_helpdesk->update("jenis_hardware", $dt, $id);
	}
}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
