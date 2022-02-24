<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_komisi extends CI_Model {

  	public function all(){
		$q = $this->db_kpp->query('SELECT *
                               FROM komisi
                              ');
		return $q;
	}

	public function get($id){
 		$q 	 = $this->db_kpp->get_where("komisi",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function get_detail($id_komisi){
		$id['id_komisi'] = $id_komisi;
		$q = $this->db_kpp->get_where("komisi",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
	}

  public function get_detail_komisi($id){
    $q 	 = $this->db_kpp->get_where("komisi_detail",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
	}

  public function t_get($id){
 		$q 	 = $this->db_kpp->get_where("t_komisi",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function t_ada_komisi($id){
    $q 	 = $this->db_kpp->get_where("t_komisi",$id);
		$row = $q->num_rows();
		return $row > 0;
	}

 	public function last_kode(){
		$q = $this->db_kpp->query("SELECT MAX(right(kode_komisi,3)) as kode FROM komisi");
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
		$q 	 = $this->db_kpp->get_where("komisi",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

  public function ada_detail($id)
	{
		$q 	 = $this->db_kpp->get_where("komisi_detail",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

  public function t_ada($id)
	{
		$q 	 = $this->db_kpp->get_where("t_komisi",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

  public function delete_detail($id){
 		$this->db_kpp->delete("komisi_detail",$id);
 	}

  public function t_delete($id){
 		$this->db_kpp->delete("t_komisi",$id);
 	}

 	public function cari_max_komisi(){
		$q = $this->db_kpp->query("SELECT MAX(id_komisi) as no FROM komisi");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

  public function cari_max_komisi_detail(){
		$q = $this->db_kpp->query("SELECT MAX(id_komisi_detail) as no FROM komisi_detail");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

  public function cari_t_max_komisi(){
		$q = $this->db_kpp->query("SELECT MAX(id_t_komisi) as no FROM t_komisi");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

	public function insert($dt){
 		$this->db_kpp->insert("komisi",$dt);
 	}

  public function insert_detail($dt){
 		$this->db_kpp->insert("komisi_detail",$dt);
 	}

  public function t_insert($dt){
 		$this->db_kpp->insert("t_komisi",$dt);
 	}

  public function update($id, $dt){
 		$this->db_kpp->update("komisi",$dt,$id);
 	}

 	public function t_update($id, $dt){
 		$this->db_kpp->update("t_komisi",$dt,$id);
 	}

  public function update_detail($id, $dt){
 		$this->db_kpp->update("komisi_detail",$dt,$id);
 	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
