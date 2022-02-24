<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_hino_laporan_survei_do extends CI_Model
{

	public function select2_cabang($cabang)
	{
		$v_cabang = explode(",", $cabang);		
		$data = array();
		$query = $this->db
			->select("id_perusahaan,lokasi")->from("kmg.perusahaan")
			->where("id_brand", "3")->where_in("id_perusahaan", $v_cabang)
			//->where_not_in("id_perusahaan", '54')
			->order_by("lokasi")->get();
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

	function get_survei_do($id_sales,$tahun,$bulan) {  
		$data_survei  = array(); 	
		if(!empty($id_sales)){	
			$query_survei = $this->db
				->select("sv.*,
					tpr.id_prospek,tpr.status,tpr.cara_bayar,tpr.status_c,tpr.status_survei, tpr.sales,
					st.id_sumber_prospek,
					spk.kode_unit, spk.id_perusahaan,spk.id_leasing,
					d.tgl_do,
					tc.nama as nama_t_customer,
					c.nama as nama_customer,c.alamat,c.tgl_lahir,c.jenis_kelamin,c.telepone,c.alamat,c.id_kabupaten,  
					u.varian")
				->from('db_hino.s_survei_do sv')
				->join('db_hino.tahapan_prospek tpr', 'tpr.id_prospek=sv.id_prospek')
				->join('db_hino.s_touch st', 'st.id_prospek=tpr.id_prospek', 'left')
				->join('db_hino.customer c', 'c.id_customer = tpr.id_customer', 'left')
				->join('db_hino.t_customer tc', 'tc.id_customer = tpr.id_customer', 'left')
				->join('db_hino.s_do d', 'd.id_prospek = tpr.id_prospek')
				->join('db_hino.adm_sales ads', 'ads.id_sales = c.sales')
				->join('db_hino.s_spk spk', 'spk.id_prospek = tpr.id_prospek','left')
				->join('db_hino.unit u', 'u.kode_unit = spk.kode_unit','left')				
				->where_in('ads.id_sales',$id_sales)
				->where('tpr.status_survei','1')
				->where('MONTH(d.tgl_do)',$bulan)
				->where('YEAR(d.tgl_do)',$tahun)
				//->where("ads.status_aktif='A')
				->order_by('d.tgl_do', 'DESC')
				->group_by('spk.id_prospek')
				->get();
				// ->select('c.id_prospek,c.nama,c.jenis_kelamin,c.tgl_lahir,c.telepone,c.email,c.alamat,c.id_kabupaten,c.id_sumber_prospek,c.cara_bayar,c.sales,
				// 		sp.jml_keluarga,sp.id_media,sp.kode_unit,
				// 		spk.id_leasing,spk.id_perusahaan,
				// 		sdo.tgl_do,
				// 		sv.status_nikah,sv.alamat_domisili,sv.pekerjaan,sv.pekerjaan_lain,sv.bidang_usaha,sv.pengeluaran,sv.pendapatan,sv.hobi,sv.hobi_lain,sv.tempat_favorit,
				// 		sv.tempat_favorit_lain,sv.tahu_kumala,sv.alasan_beli,sv.alasan_beli_lain,sv.dp,sv.atas_permintaan,sv.status_mobil_saat_ini,sv.detail_mobil_sebelumnya,sv.rating,
				// 		sv.tgl_survei')
				// ->from('db_hino.s_spk spk')
				// ->join('db_hino.s_customer c', 'c.id_prospek = spk.id_prospek')
				// ->join('db_hino.s_prospek sp', 'sp.id_prospek = c.id_prospek')
				// ->join('db_hino.s_do sdo', 'sdo.id_prospek = c.id_prospek')
				// ->join('db_hino.s_survei sv', 'sv.id_prospek = c.id_prospek')
				// ->join('db_hino.adm_sales as', 'as.id_sales = c.sales')
				// ->join('kmg.karyawan k', 'c.sales = k.id_karyawan')
				// ->where('db')
				// ->get();	
					
			foreach($query_survei->result() as $survei) {                
				$nama_kota 				= $this->db_hino->select('nama')->from('kabupaten')->where('id_kabupaten',$survei->id_kabupaten)->get()->row('nama');
				//$nama_kota = $survei->id_prospek;
				$sumber_prospek         = $this->db_hino->select('sumber_prospek')->from('p_sumber_prospek')->where('id_sumber_prospek',$survei->id_sumber_prospek)->get()->row('sumber_prospek');
				$media_motivator        = $this->db_hino->select('media')->from('p_media')->where('id_media',$survei->media_motivator)->get()->row('media');
				//$media_motivator 		= $survei->id_media;
				$tipe_unit              = $this->db_hino->select('varian')->from('unit')->where('kode_unit', $survei->kode_unit)->get()->row('varian');
				if($survei->cara_bayar=='k') {
					$leasing            = $this->db_hino->select('leasing')->from('leasing')->where('id_leasing',$survei->id_leasing)->get()->row('leasing');
					$angsuran           = $this->db_hino->select('cicilan')->from('s_contract')->where('id_prospek', $survei->id_prospek)->get()->row('cicilan');
					$tenor              = $this->db_hino->select('tenor')->from('s_contract')->where('id_prospek', $survei->id_prospek)->get()->row('tenor');
				} else {
					$leasing            = 'Pembelian Cash';
					$angsuran           = 0;
					$tenor              = 0;
				}
				$lokasi_dealer          = $this->db->select('lokasi')->from('perusahaan')->where('id_perusahaan',$survei->id_perusahaan)->get()->row('lokasi');
				$nama_sales             = $this->db->select('nama_karyawan')->from('karyawan')->where('id_karyawan',$survei->sales)->get()->row('nama_karyawan');
				$total_unit 			= $this->db_hino->where('id_prospek',$survei->id_prospek)->count_all_results('s_spk');
				//data_survei
				if($survei->status_nikah=='l') {
					$status_nikah 		= 'Lajang'; 
				} else {
					$status_nikah 		= 'Menikah'; 
				};				
				
				$data_survei[] = array(    			
					'id_prospek' 		=> $survei->id_prospek,	
					'nama_customer'    	=> strtoupper($survei->nama_customer),
					'tgl_lahir'         => tgl_sql($survei->tgl_lahir),
					'usia'				=> $this->_hitung_usia(tgl_sql($survei->tgl_lahir)),
					'jenis_kelamin'     => strtoupper($survei->jenis_kelamin),				
					'alamat'            => $survei->alamat,
					'kota'              => $nama_kota,
					'alamat_domisili'   => $survei->alamat_domisili,
					//'status_nikah'      => $this->_get_status_nikah($survei->status_nikah),
					//'jml_keluarga'      => $survei->jml_keluarga,
					'telepone'          => $survei->telepone,
					//'email'          	=> $survei->email,
					'pekerjaan' 		=> $this->_get_pekerjaan($survei->pekerjaan),
					'pekerjaan_lain' 	=> $survei->pekerjaan_lain,
					//'bidang_usaha'		=> $survei->bidang_usaha,
					//'pengeluaran'       => $this->_get_pendapatan($survei->pengeluaran),
					//'pendapatan'        => $this->_get_pendapatan($survei->pendapatan),
					'hobi'              => $this->_get_hobi($survei->hobi),
					'hobi_lain'         => $survei->hobi_lain,
					'tempat_favorit'    => $this->_get_tempat_favorit($survei->tempat_favorit),                    
					'tempat_favorit_lain'=> $survei->tempat_favorit_lain,                    
					'sumber_prospek' 	=> $sumber_prospek,
					'media_motivator' 	=> $media_motivator,
					'tipe_unit'         => $tipe_unit,
					'total_unit' 		=> $total_unit,
					'tahu_kumala' 		=> ($survei->tahu_kumala=='y')?'Ya':'Tidak',					
					'alasan_beli'       => $this->_get_alasan_beli($survei->alasan_beli),
					'alasan_beli_lain' 	=> $survei->alasan_beli_lain,
					'cara_bayar'        => (strtolower($survei->cara_bayar)=='k')?'Kredit':'Cash',
					'dp'                => $this->_get_dp($survei->dp),
					'leasing'           => $leasing,
					'angsuran'          => 'Rp'.separator_harga($angsuran),
					'tenor'             => $tenor.' bulan',
					'atas_permintaan'   => $this->_get_atas_permintaan($survei->atas_permintaan),
					'status_mobil_saat_ini' => $this->_get_status_mobil($survei->status_mobil_saat_ini),
					'detail_mobil_sebelumnya' => $survei->detail_mobil_sebelumnya,
					'dealer'            => 'Hino Kumala '.ucfirst(strtolower($lokasi_dealer)),
					'rating'			=> $survei->rating,
					'tgl_do'            => tgl_sql($survei->tgl_do),
					'nama_sales'        => strtoupper($nama_sales),
					'tgl_survei' 		=> tgl_sql($survei->tgl_survei),
				);      				        
			}     
		}
        return $data_survei;                    
	}
	
	public function get_nama_perusahaan($id_perusahaan)
	{
		$hasil = '';
		if (!empty($id_perusahaan)) {
			$hasil = $this->db->select('lokasi')->from('kmg.perusahaan')->where("id_perusahaan", $id_perusahaan)->get()->row()->lokasi;
		}
		return $hasil;
	}


	//**** static pustaka functions ****/
	private function _hitung_usia($tgl_lahir)
	{
		$tahun = '';
		if (!empty($tgl_lahir)) {
			$today = date('Y-m-d');
			$now = time($today);
			$selisih = $now - strtotime($tgl_lahir);
			$tahun = floor($selisih / (60 * 60 * 24 * 365)) . ' Tahun';
		}
		return $tahun;
	}

	private function _get_status_nikah($status)
	{
		$status_nikah = '';
		if (!empty($status)) {
			switch ($status) {
				case 'l':
					$status_nikah = 'Lajang';
					break;
				case 'm':
					$status_nikah = 'Menikah';
					break;
				default:
					$status_nikah = '';
					break;
			}
		}
		return $status_nikah;
	}

	private function  _get_pekerjaan($id)
	{
		$pk = '';
		if (!empty($id)) {
			switch ($id) {
				case 'pk01':
					$pk = 'PNS';
					break;
				case 'pk02':
					$pk = 'Pegawai BUMN';
					break;
				case 'pk03':
					$pk = 'TNI/Polri';
					break;
				case 'pk04':
					$pk = 'Dokter/Tenaga Medis';
					break;
				case 'pk05':
					$pk = 'Wiraswasta';
					break;
				case 'pk06':
					$pk = 'Kontraktor';
					break;
				case 'pk07':
					$pk = 'Pegawai Swasta';
					break;
				case 'pk08':
					$pk = 'Pedagang';
					break;
				case 'pk09':
					$pk = 'Petani/Pekebun';
					break;
				case 'pk00':
					$pk = 'Yang Lain';
					break;
			}
		}
		return $pk;
	}

	private function  _get_pendapatan($id)
	{
		$p = '';
		if (!empty($id)) {
			switch ($id) {
				case 'rp01':
					$p = '< Rp2.500.000';
					break;
				case 'rp02':
					$p = 'Rp2.500.001 - Rp5.000.000';
					break;
				case 'rp03':
					$p = 'Rp5.000.001 - Rp7.500.000';
					break;
				case 'rp04':
					$p = 'Rp7.500.001 - Rp10.000.000';
					break;
				case 'rp05':
					$p = 'Rp10.000.001 - Rp12.500.000';
					break;
				case 'rp06':
					$p = 'Rp12.500.001 - Rp15.000.000';
					break;
				case 'rp07':
					$p = '> Rp15.000.000';
					break;
			}
		}
		return $p;
	}

	private function  _get_hobi($id)
	{
		$hobi = '';
		if (!empty($id)) {
			switch ($id) {
				case 'hb01':
					$hobi = 'Bulu Tangkis';
					break;
				case 'hb02':
					$hobi = 'Tenis Meja';
					break;
				case 'hb03':
					$hobi = 'Fitness';
					break;
				case 'hb04':
					$hobi = 'Basket';
					break;
				case 'hb05':
					$hobi = 'Musik';
					break;
				case 'hb06':
					$hobi = 'Memasak';
					break;
				case 'hb07':
					$hobi = 'Menonton Film';
					break;
				case 'hb08':
					$hobi = 'Party';
					break;
				case 'hb00':
					$hobi = 'Hobi Lain';
					break;
			}
		}
		return $hobi;
	}

	private function  _get_tempat_favorit($id)
	{
		$tfav = '';
		if (!empty($id)) {
			switch ($id) {
				case 'fav01':
					$tfav = 'Cafe/Restoran';
					break;
				case 'fav02':
					$tfav = 'Mall';
					break;
				case 'fav03':
					$tfav = 'Pantai';
					break;
				case 'fav04':
					$tfav = 'Tempat Olahraga';
					break;
				case 'fav05':
					$tfav = 'Jogging Track';
					break;
				case 'fav06':
					$tfav = 'Car Free Day';
					break;
				case 'fav00':
					$tfav = 'Tempat yang lain';
					break;
			}
		}
		return $tfav;
	}

	private function  _get_alasan_beli($id)
	{
		$ab = '';
		if (!empty($id)) {
			switch ($id) {
				case 'ab01':
					$ab = 'Harga';
					break;
				case 'ab02':
					$ab = 'Fitur';
					break;
				case 'ab03':
					$ab = 'Desain';
					break;
				case 'ab04':
					$ab = 'Kenyamanan';
					break;
				case 'ab05':
					$ab = 'Hemat Bahan Bakar';
					break;
				case 'ab00':
					$ab = 'Alasan Lain';
					break;
			}
		}
		return $ab;
	}

	private function  _get_dp($id)
	{
		$dp = '';
		if (!empty($id)) {
			switch ($id) {
				case 'dp00':
					$dp = 'Pembelian Cash (Tanpa DP)';
					break;
				case 'dp01':
					$dp = '5%';
					break;
				case 'dp02':
					$dp = '15%';
					break;
				case 'dp03':
					$dp = '20%';
					break;
				case 'dp04':
					$dp = '25%';
					break;
				case 'dp05':
					$dp = '30%';
					break;
				case 'dp06':
					$dp = '35%';
					break;
				case 'dp07':
					$dp = '40%';
					break;
				case 'dp08':
					$dp = '45%';
					break;
				case 'dp09':
					$dp = 'Lebih dari 45%';
					break;
			}
		}
		return $dp;
	}

	private function  _get_atas_permintaan($id)
	{
		$pm = '';
		if (!empty($id)) {
			switch ($id) {
				case 'pm01':
					$pm = 'Sendiri';
					break;
				case 'pm02':
					$pm = 'Suami';
					break;
				case 'pm03':
					$pm = 'Istri';
					break;
				case 'pm04':
					$pm = 'Anak';
					break;
				case 'pm05':
					$pm = 'Orang Tua';
					break;
				case 'pm06':
					$pm = 'Kerabat';
					break;
			}
		}
		return $pm;
	}

	private function  _get_status_mobil($id)
	{
		$sm = '';
		if (!empty($id)) {
			switch ($id) {
				case 'sm01':
					$sm = 'Pembelian Mobil Pertama';
					break;
				case 'sm02':
					$sm = 'Mengganti Mobil Sebelumnya';
					break;
				case 'sm03':
					$sm = 'Penambahan Mobil';
					break;
			}
		}
		return $sm;
	}
	//** **//


}
