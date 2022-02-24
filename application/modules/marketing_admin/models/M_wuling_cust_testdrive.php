<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_wuling_cust_testdrive extends CI_Model {

	public function select2_cabang() {
		$data 	= array();		
		$query 		= $this->db->query
			("SELECT id_perusahaan,singkat,lokasi FROM perusahaan WHERE id_brand='5' ORDER BY lokasi");
		foreach ($query->result() as $q) {			
			$data[] = array(
				'id'        => $q->id_perusahaan,
				'text'      => $q->lokasi,
			);
		}
		$hasil = $data;
		return $hasil;
	}

	public function select2_tahun()
	{
		$data_tahun = array();
		$thn_skrng = date('Y');
		for ($thn = $thn_skrng; $thn >= 2015; $thn--) {
			$data_tahun[] = array(
				'id'        => $thn,
				'text'      => $thn,
				'selected'	=> ($thn == $thn_skrng ? true : false),
			);
		}
		$hasil = $data_tahun;
		return $hasil;
	}

	public function select2_bulan()
	{
		$data_bulan = array();
		$nama_bulan = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
		$bulan_now = date('m');
		for ($bulan = 1; $bulan <= 12; $bulan++) {
			$data_bulan[] = array(
				'id'        => $bulan,
				'text'      => $nama_bulan[$bulan],
				'selected'	=> ($bulan == $bulan_now ? true : false),
			);
		}
		$hasil = $data_bulan;
		return $hasil;
	}

	public function get_data_test_drive($id_perusahaan,$tahun,$bulan) {  
		$select = ['c.id_prospek','c.nama','c.telepone','c.sales',
					'k.nama_karyawan','pm.model','pv.varian','p.lokasi',
					'td.id_test_drive','td.id_prospek','td.id_model','td.id_varian','td.tgl_jam','td.tempat','td.tahapan','td.status'];
        $table  = 'db_wuling.s_customer c';
        $join   = [
			'db_wuling.adm_sales as' 	=> 'as.id_sales = c.sales',
	 		'db_wuling.s_suspect ss' 	=> 'ss.id_prospek = c.id_prospek',
			'kmg.karyawan k' 			=> 'c.sales = k.id_karyawan',
			'kmg.perusahaan p'			=> 'p.id_perusahaan = as.id_perusahaan',
	 		'db_wuling.s_test_drive td'	=> 'td.id_prospek = c.id_prospek',
	 		'db_wuling.p_model pm' 		=> 'pm.id_model = td.id_model',
			'db_wuling.p_varian pv' 	=> 'pv.id_varian = td.id_varian',			           
        ];    
        if(!empty($id_perusahaan)){        
			$where 	= "YEAR(DATE_FORMAT(td.tgl_jam, '%Y-%m-%d'))='$tahun' AND MONTH(DATE_FORMAT(td.tgl_jam, '%Y-%m-%d'))='$bulan' AND as.id_perusahaan='$id_perusahaan'";
			//$where 	= "td.status='1' AND YEAR(DATE_FORMAT(td.tgl_jam, '%Y-%m-%d'))='$tahun' AND MONTH(DATE_FORMAT(td.tgl_jam, '%Y-%m-%d'))='$bulan' AND as.id_perusahaan='$id_perusahaan'";
		} else {
			//$id_perusahaan = q_data("GROUP_CONCAT(id_perusahaan)", 'kmg.perusahaan', ['id_brand' => 5])->result();
			$id_perusahaan = $this->db->query("SELECT GROUP_CONCAT(id_perusahaan) as id FROM perusahaan WHERE id_brand='5'")->row('id');
			$where 	= "YEAR(DATE_FORMAT(td.tgl_jam, '%Y-%m-%d'))='$tahun' AND MONTH(DATE_FORMAT(td.tgl_jam, '%Y-%m-%d'))='$bulan' AND as.id_perusahaan IN($id_perusahaan)";
			//$where 	= "td.status='1' AND YEAR(DATE_FORMAT(td.tgl_jam, '%Y-%m-%d'))='$tahun' AND MONTH(DATE_FORMAT(td.tgl_jam, '%Y-%m-%d'))='$bulan' AND as.id_perusahaan IN($id_perusahaan)";
		}     		
        $query_testdrive = q_data_datatable($select, $table, $join, $where, null, null, true );               
        
        foreach ($query_testdrive as $testdrive) {
			$id_team_supervisor = $this->db_wuling->query("SELECT id_leader FROM adm_sales WHERE id_sales='$testdrive->sales'")->row("id_leader");
        	$nama_spv = $this->db_wuling->query("SELECT nama_team FROM adm_team_supervisor WHERE id_team_supervisor = '$id_team_supervisor'")->row("nama_team");
			$v_tempat = '';
			switch($testdrive->tempat){
				case 'd': $v_tempat = 'Dealer';break;
				case 'r': $v_tempat = 'Rumah Customer';break;
				case 'k': $v_tempat = 'Kantor';break;
				case 'p': $v_tempat = 'Area Publik';break;
				case 'l': $v_tempat = 'Lain-lain';break;
			}
			$v_jam = date("H:i",strtotime($testdrive->tgl_jam));
			$v_tgl = tgl_sql(date("Y-m-d",strtotime($testdrive->tgl_jam)));
            $data_testdrive[] = array(    
				'cabang'		=> $testdrive->lokasi,
 				'id_test_drive'	=> $testdrive->id_test_drive,
 				'id_prospek'	=> $testdrive->id_prospek,
 				'sales' 		=> $testdrive->nama_karyawan,
 				'spv'			=> $nama_spv,
 				'customer' 		=> $testdrive->nama,
 				'telepone' 		=> $testdrive->telepone,
 				'model' 		=> $testdrive->varian,
 				'waktu' 		=> $v_tgl . ' Pukul '.$v_jam,
 				'tempat' 		=> $v_tempat,		
 				'status' 		=> $testdrive->status,
 				'tahapan'		=> ucfirst($testdrive->tahapan),
            );      	                   
        }
        return q_result_datatable($select, $table, $join, $where, empty($data_testdrive) ? [] : $data_testdrive, null, true);
	}
	
	public function get_data_test_drive_export($id_perusahaan, $tahun, $bulan) {
		if($id_perusahaan=='') {
			//$coverage = explode(',',$this->session->userdata('coverage'));
			$coverage = $this->db->query("SELECT GROUP_CONCAT(id_perusahaan) as id FROM perusahaan WHERE id_brand='5'")->row('id');
			$this->db->where_in('as.id_perusahaan',explode(',',$coverage));
		} else {
			$this->db->where('as.id_perusahaan',$id_perusahaan);
		}
		$query = $this->db
			->select('c.id_prospek,c.nama,c.telepone,c.sales,k.nama_karyawan,v.varian,td.tgl_jam,td.tempat,td.tahapan,td.id_test_drive,td.status,p.lokasi')
			->from('db_wuling.s_customer c')
			->join('db_wuling.adm_sales as', 'as.id_sales = c.sales')
			->join('db_wuling.s_suspect ss', 'ss.id_prospek = c.id_prospek')
			->join('kmg.karyawan k', 'c.sales = k.id_karyawan')
			->join('kmg.perusahaan p', 'p.id_perusahaan=k.id_perusahaan')
			->join('db_wuling.s_test_drive td', 'td.id_prospek = c.id_prospek')
			->join('db_wuling.p_model pm', 'pm.id_model = td.id_model')			
			->join('db_wuling.p_varian v', 'v.id_varian = td.id_varian')			
			->where("YEAR(DATE_FORMAT(td.tgl_jam, '%Y-%m-%d'))='$tahun'") 
			->where("MONTH(DATE_FORMAT(td.tgl_jam, '%Y-%m-%d'))='$bulan'")
			//->where("td.status='1'")
			->order_by('c.id_prospek')
			->order_by('p.lokasi')
			->get();

		$array_test_drive = array();
		if ($query->num_rows() > 0) {			
			foreach ($query->result() as $dt) {
				$id_team_supervisor = $this->db_wuling->query("SELECT id_leader FROM adm_sales WHERE id_sales='$dt->sales'")->row("id_leader");
            	$nama_spv = $this->db_wuling->query("SELECT nama_team FROM adm_team_supervisor WHERE id_team_supervisor = '$id_team_supervisor'")->row("nama_team");
				$v_tempat = '';
				switch($dt->tempat){
					case 'd': $v_tempat = 'Dealer';break;
					case 'r': $v_tempat = 'Rumah Customer';break;
					case 'k': $v_tempat = 'Kantor';break;
					case 'p': $v_tempat = 'Area Publik';break;
					case 'l': $v_tempat = 'Lain-lain';break;
				}
				$v_jam = date("H:i",strtotime($dt->tgl_jam));
				$v_tgl = tgl_sql(date("Y-m-d",strtotime($dt->tgl_jam)));
				//$v_tgl_jam = str_replace(" "," Pukul ",$tgl_jam);											
				$array_test_drive[] = array(					
					//'DT_RowId'	=> $dt->id_test_drive,
					'id_prospek'=> $dt->id_prospek,
					'cabang'	=> $dt->lokasi,
					//'id_test_drive'	=> $dt->id_test_drive,
					'sales' 	=> $dt->nama_karyawan,
					'spv'		=> $nama_spv,
					'customer' 	=> $dt->nama,
					'telepone' 	=> $dt->telepone,
					'model' 	=> $dt->varian,
					'waktu' 	=> $v_tgl . ' Pukul '.$v_jam,
					'tempat' 	=> $v_tempat,		
					'status' 	=> $dt->status,
					'tahapan'	=> ucfirst($dt->tahapan),
				);
			}
		} 
		$hasil = $array_test_drive;
		return $hasil;		
	}

}

/* End of file M_wuling_cust_testdrive.php */
/* Location: ./marketing_admin/models/M_wuling_cust_testdrive.php */