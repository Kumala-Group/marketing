<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_master_akun extends CI_Model {

  	public function all(){
    $q = $this->db_kpp->order_by('kode_akun');
		$q = $this->db_kpp->get('akun');
		return $q;
	}

	public function get($id){
 		$q 	 = $this->db_kpp->get_where("akun",$id);
		$rows = $q->num_rows();
		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function getParent($id,$id2){
 		$q=$this->_item->where('level', $id);
    $q=$this->_item->where('kode_akun_group',$id2);
    $q=$this->db_kpp->get('akun');
		return $q->result();
 	}

  public function getGroup($kode_akun){
    $q=$this->db_kpp->query("SELECT nama_group_akun FROM p_akun_group WHERE kode_akun_group ='$kode_akun'");
    foreach($q->result() as $dt){
      $hasil = $dt->nama_group_akun;
    }
    return $hasil;
  }

  public function editParent($kode_akun){
    $exp = explode('.',$kode_akun);
  	if(count($exp) == 2) {
  		$kode = $exp[0];
  	}elseif (count($exp) == 3) {
  	  $kode = $exp[0].'.'.$exp[1];
  	}else {
  	  $kode=$kode_akun;
  	}
 		$q=$this->db_kpp->query("SELECT nama_akun,kode_akun,kode_akun_group FROM akun WHERE kode_akun ='$kode'");
    foreach($q->result() as $dt){
			$hasil = $dt->kode_akun;
		}
		return $hasil;
 	}

  public function cek_group_akun($id){
 		$q 	 = $this->db_kpp->get_where('akun',array('kode_akun_group' => $id));
		return $q->result();
 	}

  	public function last_kode(){
		$q = $this->db_kpp->query("SELECT MAX(right(kode_akun_group,3)) as kode FROM akun ");
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
		$q 	 = $this->db_kpp->get_where("akun",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function delete($id){
    $this->_item->where('id_akun',$id);
		$q=$this->db_kpp->get('akun');
		 if($q->num_rows()>0){
            foreach($q->result() as $dt){
                $kode = $dt->kode_akun;
            }
        }else{
            $kode = '';
        }
    $this->db_kpp->query("DELETE FROM akun WHERE kode_akun LIKE '$kode%'");
    $this->db_kpp->query("DELETE FROM akun WHERE id_akun='$id'");
 	}

 	public function max_kode_akun($id){
		$q = $this->db_kpp->query("SELECT MAX(kode_akun) as no FROM akun WHERE kode_akun_group='$id'");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

  public function max_kode_akun_parent($id,$id2){
		$q = $this->db_kpp->query("SELECT MAX(RIGHT(kode_akun,1)) as no FROM akun WHERE level='$id' AND kode_akun LIKE '$id2%'");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

	public function insert($dt){
 		$this->db_kpp->insert("akun",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("akun",$dt,$id);
 	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
