<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_program_penjualan extends CI_Model {

  	public function all(){
		$q = $this->db_kpp->query('SELECT *
                               FROM program_penjualan
                              ');
		return $q;
	}

	public function get($id){
 		$q 	 = $this->db_kpp->get_where("program_penjualan",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function get_detail($id_program_penjualan){
		$id['id_program_penjualan'] = $id_program_penjualan;
		$q = $this->db_kpp->get_where("program_penjualan",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
	}

  public function get_detail_ppd($id){
    $q 	 = $this->db_kpp->get_where("program_penjualan_detail",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
	}

  public function t_get($id){
 		$q 	 = $this->db_kpp->get_where("t_program_penjualan",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function t_ada_program_penjualan($id){
    $q 	 = $this->db_kpp->get_where("t_program_penjualan",$id);
		$row = $q->num_rows();
		return $row > 0;
	}

 	public function last_kode(){
		$q = $this->db_kpp->query("SELECT MAX(right(kode_program_penjualan,3)) as kode FROM program_penjualan");
		$row = $q->num_rows();

		if($row > 0){
            $rows = $q->result();
            $hasil = (int)$rows[0]->kode;
        }else{
            $hasil = 0;
        }
		return $hasil;
	}

	public function ada($id)
	{
		$q 	 = $this->db_kpp->get_where("program_penjualan",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

  public function ada_detail($id)
	{
		$q 	 = $this->db_kpp->get_where("program_penjualan_detail",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

  public function t_ada($id)
	{
		$q 	 = $this->db_kpp->get_where("t_program_penjualan",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function delete($id){
 		$this->db_kpp->delete("gudang",$id);
 	}

  public function delete_detail($id){
 		$this->db_kpp->delete("program_penjualan_detail",$id);
 	}

  public function t_delete($id){
 		$this->db_kpp->delete("t_program_penjualan",$id);
 	}

 	public function cari_max_program_penjualan(){
		$q = $this->db_kpp->query("SELECT MAX(id_program_penjualan) as no FROM program_penjualan");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

  public function cari_max_program_penjualan_detail(){
		$q = $this->db_kpp->query("SELECT MAX(id_program_penjualan_detail) as no FROM program_penjualan_detail");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

  public function cari_t_max_program_penjualan(){
		$q = $this->db_kpp->query("SELECT MAX(id_t_program_penjualan) as no FROM t_program_penjualan");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

	public function insert($dt){
 		$this->db_kpp->insert("program_penjualan",$dt);
 	}

  public function insert_detail($dt){
 		$this->db_kpp->insert("program_penjualan_detail",$dt);
 	}

  public function t_insert($dt){
 		$this->db_kpp->insert("t_program_penjualan",$dt);
 	}

  public function update($id, $dt){
 		$this->db_kpp->update("program_penjualan",$dt,$id);
 	}

 	public function t_update($id, $dt){
 		$this->db_kpp->update("t_program_penjualan",$dt,$id);
 	}

  public function update_detail($id, $dt){
 		$this->db_kpp->update("program_penjualan_detail",$dt,$id);
 	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
