<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_pembayaran_hutang extends CI_Model {


 	public function all(){
		$q = $this->db_kpp->query('SELECT h.*,ph.no_hutang,ph.tanggal,ph.keterangan,s.kode_supplier,s.nama_supplier
                               FROM hutang h
                               JOIN pembayaran_hutang ph ON h.id_pembayaran_hutang=ph.id_pembayaran_hutang
                               JOIN supplier s ON ph.kode_supplier=s.kode_supplier
                               ORDER BY id_pembayaran_hutang ASC');
		return $q;
	}

	public function get($id){
 		$q 	 = $this->db_kpp->get_where("pembayaran_piutang",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function last_kode(){
    $q = $this->db_kpp->query("SELECT MAX(right(no_hutang,3)) as kode FROM pembayaran_hutang");
    $row = $q->num_rows();

    if($row > 0){
            $rows = $q->result();
            $hasil = (int)$rows[0]->kode;
        }else{
            $hasil = 0;
        }
    return $hasil;
  }

  public function getByIdHutang($id_pembayaran_hutang){
		$id['id_pembayaran_hutang'] = $id_pembayaran_hutang;
		$q = $this->db_kpp->get_where("pembayaran_hutang",$id);
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
    $q 	 = $this->db_kpp->query("SELECT * FROM item_masuk WHERE kode_supplier='$id' AND status_bayar='kredit'");
		$row = $q->num_rows();
		return $row > 0;
	}

	public function ada($id){
		$q 	 = $this->db_kpp->get_where("pembayaran_hutang",$id);
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

	public function cari_max_pembayaran_hutang(){
		$q = $this->db_kpp->query("SELECT MAX(id_pembayaran_hutang) as no FROM pembayaran_hutang");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

 	public function insert($dt){
 		$this->db_kpp->insert("pembayaran_hutang",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("pembayaran_hutang",$dt,$id);
 	}

 	public function delete($id){
 		$this->db_kpp->delete("pembayaran_hutang",$id);
    $this->db_kpp->delete("hutang",$id);
 	}

  public function cetak_pp($id){
		$q = $this->db_kpp->query("SELECT *	FROM pembelian JOIN item ON penjualan.kode_item=item.kode_item WHERE penjualan.id_pembayaran_piutang='$id'");
		return $q;
	}




}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
