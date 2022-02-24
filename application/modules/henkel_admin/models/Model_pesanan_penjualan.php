<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_pesanan_penjualan extends CI_Model {


 	public function all(){
		$q = $this->db_kpp->query('SELECT pp.id_pesanan_penjualan,pp.no_transaksi,pp.tgl,pp.kode_pelanggan,p.nama_pelanggan,pp.kode_sales,pp.jt FROM pesanan_penjualan pp INNER JOIN pelanggan p ON pp.kode_pelanggan=p.kode_pelanggan ORDER BY id_pesanan_penjualan ASC');
		return $q;
	}

	public function get($id){
 		$q 	 = $this->db_kpp->get_where("pesanan_penjualan",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function get_detail_penjualan($id_pesanan_penjualan){
    //$id_pes['id_pesanan_penjualan'] = $id_pesanan_penjualan;
 		$q 	 = $this->db_kpp->query("SELECT id_pesanan_penjualan, kode_item, qty FROM penjualan WHERE id_pesanan_penjualan='$id_pesanan_penjualan'");
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function getId_program_penjualan($id){
 		$q = $this->db_kpp->get_where('program_penjualan',array('id_program_penjualan' => $id));
		return $q->result();
 	}

  public function last_kode(){
    $q = $this->db_kpp->query("SELECT MAX(right(no_transaksi,3)) as kode FROM pesanan_penjualan ");
    $row = $q->num_rows();

    if($row > 0){
            $rows = $q->result();
            $hasil = (int)$rows[0]->kode;
        }else{
            $hasil = 0;
        }
    return $hasil;
  }

  public function getByIdPPenjualan($id_pesanan_penjualan){
		$id['id_pesanan_penjualan'] = $id_pesanan_penjualan;
		$q = $this->db_kpp->get_where("pesanan_penjualan",$id);
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

  public function t_ada_id_pesanan($id){
    $q 	 = $this->db_kpp->get_where("t_penjualan",$id);
		$row = $q->num_rows();
		return $row > 0;
	}

	public function ada($id){
		$q 	 = $this->db_kpp->get_where("pesanan_penjualan",$id);
		$row = $q->num_rows();
		return $row > 0;
	}

  public function ada_detail_penjualan($id){
    $q 	 = $this->db_kpp->query("SELECT id_pesanan_penjualan FROM penjualan WHERE id_pesanan_penjualan='$id'");
		$row = $q->num_rows();
		return $row > 0;
	}

  public function cekidpesanan($id){
		$q 	 = $this->db_kpp->query("SELECT id_pesanan_penjualan FROM penjualan WHERE id_pesanan_penjualan='$id'");
		$row = $q->num_rows();
		return $row > 0;
	}

  public function delpes($id){
 		$this->db_kpp->query("DELETE FROM penjualan WHERE id_pesanan_penjualan='$id'");
 	}

	public function cari_max_pesanan_penjualan(){
		$q = $this->db_kpp->query("SELECT MAX(id_pesanan_penjualan) as no FROM pesanan_penjualan");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

 	public function insert($dt){
 		$this->db_kpp->insert("pesanan_penjualan",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("pesanan_penjualan",$dt,$id);
 	}

 	public function delete($id){
 		$this->db_kpp->delete("pesanan_penjualan",$id);
    $this->db_kpp->delete("penjualan",$id);
 	}

  public function cetak_pp($id){
		$q = $this->db_kpp->query("SELECT *	FROM penjualan JOIN item ON penjualan.kode_item=item.kode_item WHERE penjualan.id_pesanan_penjualan='$id'");
		return $q;
	}

  public function data_laporan_piutang($tgl_awal, $tgl_akhir, $kode_pelanggan){

		$where = "WHERE (pp.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir') ";
		if(!empty($kode_pelanggan)){
			$where .=" AND pp.kode_pelanggan='$kode_pelanggan'";
		}
		$q = $this->db_kpp->query("SELECT pp.tgl,pp.no_transaksi,pp.kode_pelanggan,pp.sisa_o,pp.status,pp.keterangan,p.nama_pelanggan  FROM pesanan_penjualan pp JOIN pelanggan p ON pp.kode_pelanggan=p.kode_pelanggan $where ORDER BY tgl DESC");
		return $q;
	}

  public function data_laporan_penjualan($tgl_awal, $tgl_akhir){

    $where = "WHERE (pp.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir') ";

		$q = $this->db_kpp->query("SELECT pp.id_pesanan_penjualan,pp.tgl,pp.no_transaksi
                               FROM pesanan_penjualan pp
                               $where");
		return $q;
	}


}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
