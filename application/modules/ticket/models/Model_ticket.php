<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_ticket extends CI_Model
{

	public function getAllBrand()
	{
		$q = $this->db->query("SELECT * FROM brand");
		foreach ($q->result('array') as $dt) {
			$hasil[] = $dt;
		}
		return $hasil;
	}

    public function getAllDepartement()
	{
		$q = $this->db->query("SELECT * FROM p_divisi");
		foreach ($q->result('array') as $dt) {
			$hasil[] = $dt;
		}
		return $hasil;
	}

	public function arrayAddslashes($array){
		foreach($array as $key => $value){
			$hasil[$key] = addslashes($value); 
		}
		return $hasil;
	}

	public function create_ticket_number()
    {
		$r = rand(0,9999);
		$id = date('yd') . "-TCT". date('H') .$r;
        return $id;
    }

    public function saveNewTicket($dat){ 
		$data = $this->arrayAddslashes($dat);
        $this->db_helpdesk->query("INSERT INTO ticketing (`no_ticket`, `nik`, `nama`, `cabang`, `tanggal_masuk`, `id_brand`, `id_divisi`, `type_job`, `detail_problem`, `gambar`, `dokumen`) VALUES ('$data[no_ticket]', '$data[nik]','$data[nama]','$data[cabang]','$data[tanggal_masuk]','$data[brand]','$data[dep]','$data[type_job]','$data[detail_problem]','$data[gambar_name]','$data[dokumen_name]')");
    }

	public function saveUpdateTicket($data, $id){
        $tanggal_masuk = date("Y-m-d", strtotime($data['tanggal_masuk']));  
		$this->db_helpdesk->query("UPDATE `ticketing` SET `nik`='$data[nik]', `nama`='$data[nama]', `cabang`='$data[cabang]', `tanggal_masuk`='$tanggal_masuk', `id_brand`='$data[brand]', `id_divisi`='$data[dep]', `detail_problem`='$data[detail_problem]' WHERE `id`='$id'");
    }

	public function saveUpdateGambar($name, $id){
		$q = $this->db_helpdesk->query("SELECT * FROM ticketing WHERE `id`='$id'");
		foreach($q->result('array') as $dt){
			$gambar = $dt['gambar'];
		}
		unlink('assets/ticketing_gambar/'.$gambar);
		$this->db_helpdesk->query("UPDATE `ticketing` SET `gambar`='$name' WHERE `id`='$id'");
	}

	public function saveUpdateDokumen($name, $id){
		$q = $this->db_helpdesk->query("SELECT * FROM ticketing WHERE `id`='$id'");
		foreach($q->result('array') as $dt){
			$dokumen = $dt['dokumen'];
		}
		unlink('assets/ticketing_dokumen/'.$dokumen);
		$this->db_helpdesk->query("UPDATE `ticketing` SET `dokumen`='$name' WHERE `id`='$id'");
	}
	
	public function deleteTicket($id){
		$q = $this->db_helpdesk->query("SELECT * FROM ticketing WHERE `id`='$id'");
		foreach($q->result('array') as $dt){
			$gambar = $dt['gambar'];
			$dokumen = $dt['dokumen'];
		}
		unlink('assets/ticketing_gambar/'.$gambar);
		unlink('assets/ticketing_dokumen/'.$dokumen);
        $this->db_helpdesk->query("DELETE FROM ticketing WHERE `id`='$id'");
    }	

	public function getCabang($id){
		$q = $this->db->query("SELECT * FROM `perusahaan` WHERE `id_perusahaan`='$id'");
		foreach ($q->result('array') as $dt) {
			$hasil[] = $dt;
		}
		return $hasil;
	}

	public function getOneItem($id)
    {
        $q = $this->db_helpdesk->query("SELECT * FROM `ticketing` WHERE id='$id'");
		foreach ($q->result('array') as $dt) {
			$hasil[] = $dt;
		}
		return $hasil;
    }

    public function getAllItems($id)
    {
        $q = $this->db_helpdesk->query("SELECT * FROM ticketing WHERE nik='$id' ORDER BY id DESC");
		foreach ($q->result('array') as $dt) {
			$hasil[] = $dt;
		}
		return $hasil;
    }

}

/* End of file model_ticket.php */
/* Location: ./application/modules/ticket/models/Model_ticket.php */
