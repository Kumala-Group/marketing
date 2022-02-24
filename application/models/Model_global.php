<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_global extends CI_Model
{


	public function ambilTgl($tgl)
	{
		$exp = explode('-', $tgl);
		$tgl = $exp[2];
		return $tgl;
	}

	public function ambilBln($tgl)
	{
		$exp = explode('-', $tgl);
		$tgl = $exp[1];
		$bln = $this->model_global->getBulan($tgl);
		$hasil = substr($bln, 0, 3);
		return $hasil;
	}

	public function tgl_indo($tgl)
	{
		$jam = substr($tgl, 11, 10);
		$tgl = substr($tgl, 0, 10);
		$tanggal = substr($tgl, 8, 2);
		$bulan = $this->model_global->getBulan(substr($tgl, 5, 2));
		$tahun = substr($tgl, 0, 4);
		return $tanggal . ' ' . $bulan . ' ' . $tahun . ' ' . $jam;
	}

	public function getBulan($bln)
	{
		switch ($bln) {
			case 1:
				return "Januari";
				break;
			case 2:
				return "Februari";
				break;
			case 3:
				return "Maret";
				break;
			case 4:
				return "April";
				break;
			case 5:
				return "Mei";
				break;
			case 6:
				return "Juni";
				break;
			case 7:
				return "Juli";
				break;
			case 8:
				return "Agustus";
				break;
			case 9:
				return "September";
				break;
			case 10:
				return "Oktober";
				break;
			case 11:
				return "November";
				break;
			case 12:
				return "Desember";
				break;
		}
	}

	public function hari_ini($hari)
	{
		date_default_timezone_set('Asia/Makassar'); // PHP 6 mengharuskan penyebutan timezone.
		$seminggu = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
		//$hari = date("w");
		$hari_ini = $seminggu[$hari];
		return $hari_ini;
	}
}
	
/* End of file app_model.php */
/* Location: ./application/models/app_model.php */