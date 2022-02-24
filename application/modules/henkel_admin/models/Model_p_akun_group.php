<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_p_akun_group extends CI_Model {

  	public function all(){
		$q = $this->db_kpp->get('p_akun_group');
		return $q;
	}

	public function get($id){
 		$q 	 = $this->db_kpp->get_where("p_akun_group",$id);
		$rows = $q->num_rows();
		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

	public function ada($id)
	{
		$q 	 = $this->db_kpp->get_where("p_akun_group",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function delete($id){
    $this->_item->where('id_akun_group',$id);
		$q=$this->db_kpp->get('p_akun_group');
		 if($q->num_rows()>0){
            foreach($q->result() as $dt){
                $kode = $dt->kode_akun_group;
            }
        }else{
            $kode = '';
        }
    $this->db_kpp->query("DELETE FROM akun WHERE kode_akun_group='$kode'");
    $this->db_kpp->query("DELETE FROM p_akun_group WHERE id_akun_group='$id'");
 	}

 	public function cari_max_akun_group(){
		$q = $this->db_kpp->query("SELECT MAX(id_akun_group) as no FROM p_akun_group");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

	public function insert($dt){
 		$this->db_kpp->insert("p_akun_group",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("p_akun_group",$dt,$id);
 	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
