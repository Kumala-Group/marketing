<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_pelanggan extends CI_Model {

  	public function all(){
		$q = $this->db_kpp->query('SELECT p.*,gp.nama_group
                               FROM pelanggan p
                               LEFT JOIN group_pelanggan gp
                               ON p.kode_group_pelanggan=gp.kode_group_pelanggan');
		return $q;
	}

	public function get($id){
 		$q 	 = $this->db_kpp->get_where("pelanggan",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

 	public function last_kode_henkel(){
		$q = $this->db_kpp->query("SELECT MAX(right(kode_pelanggan,3)) as kode FROM pelanggan WHERE left(kode_pelanggan,6)='PLHNKL'");
		$row = $q->num_rows();

		if($row > 0){
            $rows = $q->result();
            $hasil = (int)$rows[0]->kode;
        }else{
            $hasil = 0;
        }
		return $hasil;
	}

	public function last_kode_oli(){
		$q = $this->db_kpp->query("SELECT MAX(right(kode_pelanggan,3)) as kode FROM pelanggan WHERE left(kode_pelanggan,5)='PLOLI'");
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
		$q 	 = $this->db_kpp->get_where("pelanggan",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

  public function getKd_group_pelanggan($id){
 		$q = $this->db_kpp->get_where('group_pelanggan',array('kode_group_pelanggan' => $id));
		return $q->result();
 	}

	public function delete($id){
 		$this->db_kpp->delete("pelanggan",$id);
 	}

 	public function cari_max_pelanggan(){
		$q = $this->db_kpp->query("SELECT MAX(id_pelanggan) as no FROM pelanggan");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

	public function insert($dt){
 		$this->db_kpp->insert("pelanggan",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("pelanggan",$dt,$id);
 	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
