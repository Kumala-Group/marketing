<?php

//Konversi tanggal
function datetime_show($date)
{
	if (empty($date)) {
		$output = ' - ';
	} else {
		$datetime = date_create($date);
		$output = date_format($datetime, 'd-m-Y H:i:s');
	}
	return $output;
}

function tgl_sql($date)
{
	$exp = explode('-', $date);
	if (count($exp) == 3) {
		$date = $exp[2] . '-' . $exp[1] . '-' . $exp[0];
	}
	return $date;
}
function tgl_sql_text($date)
{
	$exp = explode('-', $date);
	if (count($exp) == 3) {
		$bln_text = array("01" => "Jan", "02" => "Feb", "03" => "Mar", "04" => "Apr", "05" => "Mei", "06" => "Jun", "07" => "Jul", "08" => "Agst", "09" => "Sep", "10" => "Okt", "11" => "Nov", "12" => "Des");
		$date = $exp[0] . ' - ' . $bln_text[$exp[1]] . ' - ' . $exp[2];
	}
	return $date;
}

function tgl_excel($date)
{
	$exp = explode('/', $date);
	if (count($exp) == 3) {
		$date = $exp[2] . '-' . $exp[0] . '-' . $exp[1];
	}
	return $date;
}

function time_sql($date)
{
	$replace = str_replace(' ', '-', $date);
	$exp = explode('-', $replace);
	if (count($exp) == 4) {
		$tgl = '<b>' . $exp[2] . '-' . $exp[1] . '-' . $exp[0] . '</b> ' . $exp[3];
	}
	return $tgl;
}

function tgl_sql_gm($date)
{
	$exp = explode('-', $date);
	if (count($exp) == 3) {
		$date = $exp[2] . '/' . $exp[1] . '/' . $exp[0];
	}
	return $date;
}

function tgl_str($date)
{
	$exp = explode('-', $date);
	if (count($exp) == 3) {
		$date = $exp[2] . '-' . $exp[1] . '-' . $exp[0];
	}
	return $date;
}

function ambilTgl($tgl)
{
	$exp = explode('-', $tgl);
	$tgl = $exp[2];
	return $tgl;
}

function ambilBln($tgl)
{
	$exp = explode('-', $tgl);
	$tgl = $exp[1];
	$bln = getBulan($tgl);
	$hasil = substr($bln, 0, 3);
	return $hasil;
}

function tgl_indo($tgl)
{
	$jam = substr($tgl, 11, 10);
	$tgl = substr($tgl, 0, 10);
	$tanggal = substr($tgl, 8, 2);
	$bulan = getBulan(substr($tgl, 5, 2));
	$tahun = substr($tgl, 0, 4);
	return $tanggal . ' ' . $bulan . ' ' . $tahun . ' ' . $jam;
}

function tgl_sql_text_bulan($date)
{
	$exp = explode('-', $date);
	if (count($exp) == 3) {
		$bln_text = array("01" => "Januari", "02" => "Februari", "03" => "Maret", "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli", "08" => "Agustus", "09" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember");
		$date = $exp[2] . ' ' . $bln_text[$exp[1]] . ' ' . $exp[0];
	}
	return $date;
}

function getBulan($bln)
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

function hari_ini($hari)
{
	date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
	$seminggu = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
	//$hari = date("w");
	$hari_ini = $seminggu[$hari];
	return $hari_ini;
}

function hari_kuliah()
{
	$q = array('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu');
	return $q;
}
// JUMLAH MINGGU DALAM 1 BULAN
function weeks_in_month($month, $year)
{
	// Start of month
	$start = mktime(0, 0, 0, $month, 1, $year);
	// End of month
	$end = mktime(0, 0, 0, $month, date('t', $start), $year);
	// Start week
	$start_week = date('W', $start);
	$end_week = date('W', $end);
	if ($end_week < $start_week) { // Month wraps
		return ((52 + $end_week) - $start_week);
	}
	return ($end_week - $start_week);
}

// Ambil tanggal dan waktu sekarang (waktu Makassar)
function ambil_datetime_makassar_sekarang()
{
	$date = new \DateTime(date('Y-m-d H:i:s'));
	$date->setTimezone(new \DateTimeZone('Asia/Makassar'));
	return $date->format('Y-m-d H:i:s');
}

// Open Closing Tanggal Kasir
function get_close_tanggal($db, $id_perusahaan)
{
	$ci     = get_instance();
	$result = $ci->$db->get_where('setting_closing_backdate', ['status_closing' => '2', 'id_perusahaan' => $id_perusahaan])->row('tanggal_closing');
	return $result;
}
    // Close Closing Tanggal Kasir
