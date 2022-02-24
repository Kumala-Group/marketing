<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_stok_awal_item extends CI_Model {

  	public function all(){
		$q = $this->db_kpp->query('SELECT sao.*, g.nama_gudang, o.nama_item, o.tipe
                               FROM stok_awal_item sao
                               INNER JOIN gudang g
                               ON sao.kode_gudang=g.kode_gudang
                               INNER JOIN item o
                               ON sao.kode_item=o.kode_item');
		return $q;
	}

	public function get($id){
 		$q 	 = $this->db_kpp->get_where("stok_awal_item",$id);
		$rows = $q->num_rows();
		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  	public function last_kode(){
  		$q = $this->db_kpp->query("SELECT MAX(right(kode_stok_awal_item,3)) as kode FROM stok_awal_item ");
  		$row = $q->num_rows();

  		if($row > 0){
              $rows = $q->result();
              $hasil = (int)$rows[0]->kode;
          }else{
              $hasil = 0;
          }
  		return $hasil;
	 }

   public function getKd_gudang($id){
  		 $q 	 = $this->db_kpp->get_where('gudang',array('kode_gudang' => $id));
 		   return $q->result();
  }

  public function getId_sao($id){
    $q = $this->db_kpp->query("SELECT id_stok_awal_item FROM stok_awal_item WHERE id_stok_awal_item='$id'");;
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_stok_awal_item'];
		return  $result;
 	}

  public function data_laporan_stok_awal_item($tgl_awal, $tgl_akhir){
		$where = "WHERE (tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir') ";
		$q = $this->db_kpp->query("SELECT * FROM stok_awal_item $where ORDER BY tanggal DESC");
		return $q;
	}

  public function export_excel($tgl_awal, $tgl_akhir){
        $query = $this->db_kpp->query("SELECT * FROM stok_awal_item WHERE (tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir') ORDER BY tanggal DESC");

        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
  }

  public function nama_gudang($id){
		$this->_item->where('kode_gudang',$id);
		$q=$this->db_kpp->get('gudang');
		 if($q->num_rows()>0){
            foreach($q->result() as $dt){
                $hasil = $dt->nama_gudang;
            }
        }else{
            $hasil = '';
        }
		return $hasil;
	}

  public function nama_item($id){
		$this->_item->where('kode_item',$id);
		$q=$this->db_kpp->get('item');
		 if($q->num_rows()>0){
            foreach($q->result() as $dt){
                $hasil = $dt->nama_item;
            }
        }else{
            $hasil = '';
        }
		return $hasil;
	}

  public function tipe($id){
		$this->_item->where('kode_item',$id);
		$q=$this->db_kpp->get('item');
		 if($q->num_rows()>0){
            foreach($q->result() as $dt){
                $hasil = $dt->tipe;
            }
        }else{
            $hasil = '';
        }
		return $hasil;
	}

	public function ada($id)
	{
		$q 	 = $this->db_kpp->get_where("stok_awal_item",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

	public function delete($id){
 		$this->db_kpp->delete("stok_awal_item",$id);
 	}

 	public function cari_max_stok_awal_item(){
		$q = $this->db_kpp->query("SELECT MAX(id_stok_awal_item) as no FROM stok_awal_item");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

	public function insert($dt){
 		$this->db_kpp->insert("stok_awal_item",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("stok_awal_item",$dt,$id);
 	}

}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
