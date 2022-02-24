<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_stok_opname extends CI_Model {


 	public function all(){
		$q = $this->db_kpp->query('SELECT so.*,g.nama_gudang
                               FROM stok_opname so
                               JOIN gudang g
                               ON so.kode_gudang=g.kode_gudang');
		return $q;
	}

	public function get($id){
 		$q 	 = $this->db_kpp->get_where("stok_opname",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function t_get($id){
 		$q 	 = $this->db_kpp->get_where("t_stok_opname",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function export_excel($id){
        $query = $this->db_kpp->query("SELECT * FROM stok_opname_detail WHERE id_stok_opname='$id' ");

        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
  }

  public function get_kd_item($id){
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

  public function get_kd_gudang($id){
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

  public function t_get_inserted($id){
 		$q 	 = $this->db_kpp->get_where("stok_opname_detail",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function t_get_add($id){
    $q 	 = $this->db_kpp->get_where("t_stok_opname",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0]->id_stok_opname_detail;
		} else {
			return null;
		}
 	}

	public function last_kode(){
    $q = $this->db_kpp->query("SELECT MAX(right(kode_stok_opname,3)) as kode FROM stok_opname ");
    $row = $q->num_rows();

    if($row > 0){
            $rows = $q->result();
            $hasil = (int)$rows[0]->kode;
        }else{
            $hasil = 0;
        }
    return $hasil;
  }

  public function getByIdStokOpname($id_stok_opname){
		$id['id_stok_opname'] = $id_stok_opname;
		$q = $this->db_kpp->get_where("stok_opname",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
	}

  public function getTelephonePel($id){
    $this->db_kpp->select('telepon');
		$this->_item->where('kode_pelanggan', $id);
		$q = $this->db_kpp->get('pelanggan');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['telepon'];
		return  $result;
		}

  public function ada_id_pesanan($id){
    $q 	 = $this->db_kpp->get_where("penjualan",$id);
		$row = $q->num_rows();
		return $row > 0;
	}

  public function ada_hutang($id){
    $q 	 = $this->db_kpp->query("SELECT * FROM stok_item WHERE kode_gudang='$id'");
		$row = $q->num_rows();
		return $row > 0;
	}

	public function ada($id){
		$q 	 = $this->db_kpp->get_where("stok_opname",$id);
		$row = $q->num_rows();
		return $row > 0;
	}

  public function ada_stok_opname_detail($id){
		$q 	 = $this->db_kpp->get_where("stok_opname_detail",$id);
		$row = $q->num_rows();
		return $row > 0;
	}

  public function t_ada($id){
		$q 	 = $this->db_kpp->get_where("t_stok_opname",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

  public function t_ada_inserted($id){
		$q 	 = $this->db_kpp->get_where("stok_opname_detail",$id);
		$row = $q->num_rows();

		return $row > 0;
	}

  public function t_ada_add($id){
    $q = $this->db_kpp->query("SELECT id_stok_opname_detail FROM t_stok_opname WHERE id_stok_opname_detail='$id'");
    $row = $q->num_rows();
		return $row > 0;

	}

  public function cekidpesanan($id){
		$q 	 = $this->db_kpp->query("SELECT id_pembayaran_piutang FROM penjualan WHERE id_pembayaran_piutang='$id'");
		$row = $q->num_rows();
		return $row > 0;
	}

  public function delpes($id){
 		$this->db_kpp->query("DELETE FROM penjualan WHERE id_pembayaran_piutang='$id'");
 	}

	public function cari_max_stok_opname(){
		$q = $this->db_kpp->query("SELECT MAX(id_stok_opname) as no FROM stok_opname");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

  public function cari_max_stok_opname_detail(){
		$q = $this->db_kpp->query("SELECT MAX(id_stok_opname_detail) as no FROM stok_opname_detail");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

 	public function insert($dt){
 		$this->db_kpp->insert("stok_opname",$dt);
 	}

  public function insert_stok_opname_detail($dt){
 		$this->db_kpp->insert("stok_opname_detail",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("stok_opname",$dt,$id);
 	}

  public function update_stok_opname_detail($id, $dt){
 		$this->db_kpp->update("stok_opname_detail",$dt,$id);
 	}

 	public function delete($id){
 		$this->db_kpp->delete("pembayaran_piutang",$id);
    $this->db_kpp->delete("piutang",$id);
 	}

  public function cetak_pp($id){
		$q = $this->db_kpp->query("SELECT *	FROM penjualan JOIN item ON penjualan.kode_item=item.kode_item WHERE penjualan.id_pembayaran_piutang='$id'");
		return $q;
	}




}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
