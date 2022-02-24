<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_biaya_angkut extends CI_Model {


 	public function all(){
		$q = $this->db_kpp->query('SELECT pp.*, s.nama_supplier
                               FROM biaya_angkut pp
                               JOIN supplier s on pp.kode_supplier=s.kode_supplier
                               ');
		return $q;
	}

	public function get($id_biaya_angkut){
		$id['id_biaya_angkut'] = $id_biaya_angkut;
		$q = $this->db_kpp->get_where("biaya_angkut",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
	}

 	public function last_kode(){
		$q = $this->db_kpp->query("SELECT MAX(right(no_inv_supplier,3)) as kode FROM biaya_angkut ");
		$row = $q->num_rows();

		if($row > 0){
            $rows = $q->result();
            $hasil = (int)$rows[0]->kode;
        }else{
            $hasil = 0;
        }
		return $hasil;
	}

	public function ada_id_pesanan($id){
    $q 	 = $this->db_kpp->get_where("biaya_angkut",$id);
		$row = $q->num_rows();
		return $row > 0;
	}

  public function t_ada_id_pesanan($id){
    $q 	 = $this->db_kpp->get_where("t_biaya_angkut",$id);
		$row = $q->num_rows();
		return $row > 0;
	}

	public function ada($id){
		$q 	 = $this->db_kpp->get_where("t_biaya_angkut",$id);
		$row = $q->num_rows();

		return $row > 0;
	}
  public function adaa($id){
		$q 	 = $this->db_kpp->get_where("biaya_angkut",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function cari_max_pesanan_pembelian(){
		$q = $this->db_kpp->query("SELECT MAX(id_pesanan_pembelian) as no FROM t_biaya_angkut");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

 	public function insert($dt){
 		$this->db_kpp->insert("t_biaya_angkut",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("t_biaya_angkut",$dt,$id);
 	}

 	public function delete($id){
 		$this->db_kpp->delete("biaya_angkut",$id);
 		$this->db_kpp->delete("biaya_angkut",$id);
 	}




}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
