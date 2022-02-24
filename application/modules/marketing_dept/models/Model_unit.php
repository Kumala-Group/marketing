<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_unit extends CI_Model {

  	public function all(){
		$q = $this->db_wuling->get('unit');
		return $q;
	}

  public function last_kode(){
		$q = $this->db_wuling->query("SELECT MAX(right(kode_unit,3)) as kode FROM unit ");
		$row = $q->num_rows();

		if($row > 0){
            $rows = $q->result();
            $hasil = (int)$rows[0]->kode;
        }else{
            $hasil = 0;
        }
		return $hasil;
	}

  public function TypeToUnit($id){
		$this->db_wuling->where('id_type',$id);
		$q=$this->db_wuling->get('p_type');
		 if($q->num_rows()>0){
            foreach($q->result() as $dt){
                $hasil = $dt->type;
            }
        }else{
            $hasil = '';
        }
		return $hasil;
	}

  public function UnitToUnit($id){
		$q=$this->db_wuling->query("SELECT varian,warna FROM unit INNER JOIN p_warna ON unit.id_warna=p_warna.id_warna WHERE unit.kode_unit='$id'");
		 if($q->num_rows()>0){
            foreach($q->result() as $dt){
                $hasil = $dt->varian.' - '.$dt->warna;
            }
        }else{
            $hasil = ' - ';
        }
		return $hasil;
	}

  public function ConfigurationToUnit($id){
		$this->db_wuling->where('id_configuration',$id);
		$q=$this->db_wuling->get('p_configuration');
		 if($q->num_rows()>0){
            foreach($q->result() as $dt){
                $hasil = $dt->configuration;
            }
        }else{
            $hasil = '';
        }
		return $hasil;
	}

  public function WarnaToUnit($id){
		$this->db_wuling->where('id_warna',$id);
		$q=$this->db_wuling->get('p_warna');
		 if($q->num_rows()>0){
            foreach($q->result() as $dt){
                $hasil = $dt->warna;
            }
        }else{
            $hasil = '';
        }
		return $hasil;
	}

  public function ExpedisiToUnit($id){
		$this->db_wuling->where('id_expedisi',$id);
		$q=$this->db_wuling->get('expedisi');
		 if($q->num_rows()>0){
            foreach($q->result() as $dt){
                $hasil = $dt->expedisi;
            }
        }else{
            $hasil = '';
        }
		return $hasil;
	}

	public function get($id){
 		$q 	 = $this->db_wuling->get_where("unit",$id);
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
		$q 	 = $this->db_wuling->get_where("unit",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

  public function delete($id){
 		$this->db_wuling->delete("unit",$id);
 	}

 	public function cari_max_unit(){
		$q = $this->db_wuling->query("SELECT MAX(id_unit) as no FROM unit");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

	public function insert($dt){
 		$this->db_wuling->insert("unit",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_wuling->update("unit",$dt,$id);
 	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
