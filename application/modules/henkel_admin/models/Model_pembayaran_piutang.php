<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_pembayaran_piutang extends CI_Model {


 	public function all(){
		$q = $this->db_kpp->query('SELECT p.*,pp.no_piutang,pp.tanggal,pp.keterangan,pel.kode_pelanggan,pel.nama_pelanggan
                               FROM piutang p
                               JOIN pembayaran_piutang pp ON p.id_pembayaran_piutang=pp.id_pembayaran_piutang
                               JOIN pelanggan pel ON pp.kode_pelanggan=pel.kode_pelanggan
                               ORDER BY id_pembayaran_piutang ASC');
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
    $q = $this->db_kpp->query("SELECT MAX(right(no_piutang,3)) as kode FROM pembayaran_piutang ");
    $row = $q->num_rows();

    if($row > 0){
            $rows = $q->result();
            $hasil = (int)$rows[0]->kode;
        }else{
            $hasil = 0;
        }
    return $hasil;
  }

  public function getByIdPPiutang($id_pembayaran_piutang){
		$id['id_pembayaran_piutang'] = $id_pembayaran_piutang;
		$q = $this->db_kpp->get_where("pembayaran_piutang",$id);
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
    $q 	 = $this->db_kpp->query("SELECT * FROM pesanan_penjualan WHERE kode_pelanggan='$id' AND status='Kredit'");
		$row = $q->num_rows();
		return $row > 0;
	}

	public function ada($id){
		$q 	 = $this->db_kpp->get_where("pembayaran_piutang",$id);
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

	public function cari_max_pembayaran_piutang(){
		$q = $this->db_kpp->query("SELECT MAX(id_pembayaran_piutang) as no FROM pembayaran_piutang");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

 	public function insert($dt){
 		$this->db_kpp->insert("pembayaran_piutang",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("pembayaran_piutang",$dt,$id);
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
