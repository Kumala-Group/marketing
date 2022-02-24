<?php
function separator_harga($harga)
{
	$format_number = number_format($harga, 0, ',', '.');
	return $format_number;
}

function separator_harga2($harga)
{
	$format_number = number_format($harga, 2, ',', '.');
	return $format_number;
}

/* Jika return 0 ganti mengganti - */
function separator_harga3($harga)
{
	$format_number = number_format($harga, 0, ',', '.');
	if ($format_number == 0) {
		return "-";
	} else {
		return $format_number;
	}
}

function remove_separator($harga)
{
	return str_replace('.', '', $harga);
}

function remove_separator2($harga)
{
	$exp = explode(',', $harga);
	if (count($exp) == 2) {
		$str1 = str_replace(".", "", $exp[0]);
		$format = $str1 . '.' . $exp[1];
	}
	return floatval($format);
}

function remove_separator3($harga)
{
	$exp = explode(',', $harga);
	if (count($exp) == 2) {
		$str1 = str_replace(".", "", $exp[0]);
		$format = $str1 . '.00';
	}
	return floatval($format);
}

function penyebut($nilai)
{
	$nilai = abs($nilai);
	$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
	$temp = "";
	if ($nilai < 12) {
		$temp = " " . $huruf[$nilai];
	} else if ($nilai < 20) {
		$temp = penyebut($nilai - 10) . " Belas";
	} else if ($nilai < 100) {
		$temp = penyebut($nilai / 10) . " Puluh" . penyebut($nilai % 10);
	} else if ($nilai < 200) {
		$temp = " Seratus" . penyebut($nilai - 100);
	} else if ($nilai < 1000) {
		$temp = penyebut($nilai / 100) . " Ratus" . penyebut($nilai % 100);
	} else if ($nilai < 2000) {
		$temp = " Seribu" . penyebut($nilai - 1000);
	} else if ($nilai < 1000000) {
		$temp = penyebut($nilai / 1000) . " Ribu" . penyebut($nilai % 1000);
	} else if ($nilai < 1000000000) {
		$temp = penyebut($nilai / 1000000) . " Juta" . penyebut($nilai % 1000000);
	} else if ($nilai < 1000000000000) {
		$temp = penyebut($nilai / 1000000000) . " Milyar" . penyebut(fmod($nilai, 1000000000));
	} else if ($nilai < 1000000000000000) {
		$temp = penyebut($nilai / 1000000000000) . " Trilyun" . penyebut(fmod($nilai, 1000000000000));
	}
	return $temp;
}


function Penyebut_1($nilai)
{
	$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
	if ($nilai == 0) {
		return "";
	} elseif ($nilai < 12 & $nilai != 0) {
		return "" . $huruf[$nilai];
	} elseif ($nilai < 20) {
		return Penyebut_1($nilai - 10) . " Belas ";
	} elseif ($nilai < 100) {
		return Penyebut_1($nilai / 10) . " Puluh " . Penyebut_1($nilai % 10);
	} elseif ($nilai < 200) {
		return " Seratus " . Penyebut_1($nilai - 100);
	} elseif ($nilai < 1000) {
		return Penyebut_1($nilai / 100) . " Ratus " . Penyebut_1($nilai % 100);
	} elseif ($nilai < 2000) {
		return " Seribu " . Penyebut_1($nilai - 1000);
	} elseif ($nilai < 1000000) {
		return Penyebut_1($nilai / 1000) . " Ribu " . Penyebut_1($nilai % 1000);
	} elseif ($nilai < 1000000000) {
		return Penyebut_1($nilai / 1000000) . " Juta " . Penyebut_1($nilai % 1000000);
	} elseif ($nilai < 1000000000000) {
		return Penyebut_1($nilai / 1000000000) . " Milyar " . Penyebut_1($nilai % 1000000000);
	} elseif ($nilai < 100000000000000) {
		return Penyebut_1($nilai / 1000000000000) . " Trilyun " . Penyebut_1($nilai % 1000000000000);
	}
}

function terbilang($nilai)
{
	if ($nilai < 0) {
		$hasil = "Minus " . trim(penyebut($nilai)) . " Rupiah";
	} else {
		$hasil = trim(penyebut($nilai)) . " Rupiah";
	}
	return $hasil;
}
