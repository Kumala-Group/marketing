<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_retur_penjualan extends CI_Model {


 	public function all(){
		$q = $this->db_kpp->query('SELECT * FROM retur_penjualan ORDER BY id_retur_penjualan DESC');
		return $q;
	}

	public function get($id){
 		$q 	 = $this->db_kpp->get_where("retur_penjualan",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

  public function ada_transaksi($id){
    $q 	 = $this->db_kpp->query("SELECT no_transaksi FROM pesanan_penjualan WHERE no_transaksi='$id'");
		$row = $q->num_rows();
		return $row > 0;
	}

  public function ada_npwp($kode_pelanggan){
    $q 	 = $this->db_kpp->query("SELECT npwp FROM pelanggan WHERE kode_pelanggan='$kode_pelanggan'");
		$row = $q->num_rows();
		return $row > 0;
	}

  function getIdPesananPenjualan($id)
	{
		$this->db_kpp->select('id_pesanan_penjualan');
		$this->db_kpp->where('no_transaksi', $id);
		$q = $this->db_kpp->get('pesanan_penjualan');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_pesanan_penjualan'];
		return  $result;
	}

  function get_data_penjualan($id)
	{
    $this->db_kpp->select('total_akhir,diskon,bayar,status,sisa_o,pajak');
		$this->db_kpp->where('no_transaksi', $id);
		$q = $this->db_kpp->get('pesanan_penjualan');
    $rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
	}

  public function last_kode(){
    $q = $this->db_kpp->query("SELECT MAX(right(no_retur,3)) as kode FROM retur_penjualan ");
    $row = $q->num_rows();

    if($row > 0){
            $rows = $q->result();
            $hasil = (int)$rows[0]->kode;
        }else{
            $hasil = 0;
        }
    return $hasil;
  }

  public function getByIdRPenjualan($id_retur_penjualan){
		$id['id_retur_penjualan'] = $id_retur_penjualan;
		$q = $this->db_kpp->get_where("retur_penjualan",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
	}

  public function ada_id_pesanan($id){
    $q 	 = $this->db_kpp->get_where("r_penjualan",$id);
		$row = $q->num_rows();
		return $row > 0;
	}

  public function t_ada_id_pesanan($id){
    $q 	 = $this->db_kpp->get_where("t_r_penjualan",$id);
		$row = $q->num_rows();
		return $row > 0;
	}

	public function ada($id){
		$q 	 = $this->db_kpp->get_where("retur_penjualan",$id);
		$row = $q->num_rows();
		return $row > 0;
	}

  public function cekidpesanan($id){
		$q 	 = $this->db_kpp->query("SELECT id_retur_penjualan FROM r_penjualan WHERE id_retur_penjualan='$id'");
		$row = $q->num_rows();
		return $row > 0;
	}

  public function delpes($id){
 		$this->db_kpp->query("DELETE FROM r_penjualan WHERE id_retur_penjualan='$id'");
 	}

	public function cari_max_retur_penjualan(){
		$q = $this->db_kpp->query("SELECT MAX(id_retur_penjualan) as no FROM retur_penjualan");
		foreach($q->result() as $dt){
			$no = (int) $dt->no+1;
		}
		return $no;
	}

 	public function insert($dt){
 		$this->db_kpp->insert("retur_penjualan",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_kpp->update("retur_penjualan",$dt,$id);
 	}

 	public function delete($id){
 		$this->db_kpp->delete("retur_penjualan",$id);
    $this->db_kpp->delete("r_penjualan",$id);
 	}

  public function cetak_pp($id){
		$q = $this->db_kpp->query("SELECT *	FROM r_penjualan JOIN item ON r_penjualan.kode_item=item.kode_item WHERE r_penjualan.id_retur_penjualan='$id'");
		return $q;
	}

  public function data_laporan_piutang($tgl_awal, $tgl_akhir, $kode_pelanggan){

		$where = "WHERE (pp.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir') ";
		if(!empty($kode_pelanggan)){
			$where .=" AND pp.kode_pelanggan='$kode_pelanggan'";
		}
		$q = $this->db_kpp->query("SELECT pp.tgl,pp.no_transaksi,pp.kode_pelanggan,pp.sisa_o,pp.status,pp.keterangan,p.nama_pelanggan  FROM retur_penjualan pp JOIN pelanggan p ON pp.kode_pelanggan=p.kode_pelanggan $where ORDER BY tgl DESC");
		return $q;
	}




}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
