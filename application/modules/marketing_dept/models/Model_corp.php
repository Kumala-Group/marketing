<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_corp extends CI_Model {

	/*** jumlah data ***/
	public function jml_data($table){
		$q = $this->db->get($table);
		return $q->num_rows();
	}

	public function jml_all_karyawan(){
		$this->db->where('status_aktif','Aktif');
		$q = $this->db->get('karyawan');
		return $q->num_rows();
	}

	/*** data table ***/
	public function data($table){
		$q = $this->db->get($table);
		return $q->result();
	}

	public function create_category_karyawan($id_perusahaan){

		$where = "WHERE tgl_mulai_kerja<=now()";
		if(!empty($id_perusahaan)){
			$where .=" AND id_perusahaan='$id_perusahaan'";
		}
		$q = $this->db->query("SELECT YEAR(tgl_mulai_kerja) as tahun FROM karyawan  $where GROUP BY YEAR(tgl_mulai_kerja) order by tgl_mulai_kerja DESC LIMIT 10");

		foreach($q->result() as $dt){
			$hasil[] = $dt->tahun;
		}
		return $hasil;
	}
    
    public function create_category_karyawan_bulan($id_perusahaan){

		$where = "WHERE YEAR(tgl_mulai_kerja)=YEAR(CURDATE())";
		if(!empty($id_perusahaan)){
			$where .=" AND id_perusahaan='$id_perusahaan'";
		}
		$q = $this->db->query("SELECT MONTH(tgl_mulai_kerja) as bulan FROM karyawan  $where GROUP BY MONTH(tgl_mulai_kerja) order by tgl_mulai_kerja DESC LIMIT 12");

		foreach($q->result() as $dt){
			$hasil[] = $dt->bulan;
		}
		return $hasil;
	}
    
    public function data_chart_karyawan($id_perusahaan){

		$where = "WHERE tgl_mulai_kerja<=now()";
		if(!empty($id_perusahaan)){
			$where .=" AND id_perusahaan='$id_perusahaan'";
		}

		$q = $this->db->query("SELECT COUNT(YEAR(tgl_mulai_kerja)) as jml_karyawan FROM karyawan $where GROUP BY YEAR(tgl_mulai_kerja) order by tgl_mulai_kerja DESC LIMIT 10");

		foreach($q->result() as $dt){
			$hasil[] = (int)$dt->jml_karyawan;
		}
		return $hasil;
	}

	public function data_chart_karyawan_bulan($id_perusahaan){

		$where = "WHERE YEAR(tgl_mulai_kerja)=YEAR(CURDATE())";
		if(!empty($id_perusahaan)){
			$where .=" AND id_perusahaan='$id_perusahaan'";
		}

		$q = $this->db->query("SELECT COUNT(MONTH(tgl_mulai_kerja)) as jml_karyawan FROM karyawan $where GROUP BY MONTH(tgl_mulai_kerja) order by tgl_mulai_kerja DESC LIMIT 12");

		foreach($q->result() as $dt){
			$hasil[] = (int)$dt->jml_karyawan;
		}
		return $hasil;
	}

	public function create_category_cuti(){

		$q = $this->db->query("SELECT YEAR(tgl_mulai_cuti) as tahun FROM cuti WHERE tgl_mulai_cuti<=now() GROUP BY YEAR(tgl_mulai_cuti) order by tgl_mulai_cuti");

		foreach($q->result() as $dt){
			$hasil[] = $dt->tahun;
		}
		return $hasil;
	}

	public function data_chart_cuti($id_perusahaan){

		$where = "WHERE tgl_mulai_cuti<=now()";
		if(!empty($id_perusahaan)){
			$where .=" AND id_perusahaan='$id_perusahaan'";
		}

		$q = $this->db->query("SELECT COUNT(YEAR(tgl_mulai_cuti)) as jml_karyawan FROM cuti c JOIN karyawan k ON c.nik=k.nik $where GROUP BY YEAR(tgl_mulai_cuti) order by tgl_mulai_cuti");

		foreach($q->result() as $dt){
			$hasil[] = (int)$dt->jml_karyawan;
		}
		return $hasil;
	}

	public function create_category_resign(){

		$q = $this->db->query("SELECT YEAR(tgl) as tahun FROM resign WHERE tgl<=now() GROUP BY YEAR(tgl) order by tgl");

		foreach($q->result() as $dt){
			$hasil[] = $dt->tahun;
		}
		return $hasil;
	}

	public function data_chart_resign($id_perusahaan){

		$where = "WHERE tgl<=now()";
		if(!empty($id_perusahaan)){
			$where .=" AND id_perusahaan='$id_perusahaan'";
		}

		$q = $this->db->query("SELECT COUNT(YEAR(tgl)) as jml_karyawan FROM resign r JOIN karyawan k ON r.nik=k.nik $where GROUP BY YEAR(tgl) order by tgl");

		foreach($q->result() as $dt){
			$hasil[] = (int)$dt->jml_karyawan;
		}
		return $hasil;
	}

	public function data_chart_status($param){
        $tgl="";
        if($param=='Resign'){
            $tgl=" AND YEAR(tgl_resign)=YEAR(CURDATE())";
        }

	 	$q = $this->db->query("SELECT COUNT(id_karyawan) as jml_karyawan FROM karyawan WHERE status_aktif='$param' $tgl");

		foreach($q->result() as $dt){
			$hasil = (int)$dt->jml_karyawan;
		}
		return $hasil;
	}
}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
