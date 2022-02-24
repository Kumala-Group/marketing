<?php defined('BASEPATH') or exit('No direct script access allowed');

$route['kumalagroup'] = 'kumalagroup/kumalagroup';
$route['kumalagroup/cek_login'] = 'kumalagroup/kumalagroup/cek_login';

//Home
$route['kumalagroup_home'] = 'kumalagroup/kumalagroup_home';

//Konfigurasi User
$route['kumalagroup_konfigurasi_user'] = 'kumalagroup/kumalagroup_konfigurasi_user';
$route['kumalagroup_konfigurasi_user/simpan'] = 'kumalagroup/kumalagroup_konfigurasi_user/simpan';
$route['kumalagroup_konfigurasi_user/data_user'] = 'kumalagroup/kumalagroup_konfigurasi_user/data_user';
$route['kumalagroup_konfigurasi_user/update_status'] = 'kumalagroup/kumalagroup_konfigurasi_user/update_status';

$route['kumalagroup_home/update_id_brand_view'] = 'kumalagroup/kumalagroup_home/update_id_brand_view';

//User Profil
$route['kumalagroup_user_profil'] = 'kumalagroup/kumalagroup_user_profil';
$route['kumalagroup_user_profil/simpan'] = 'kumalagroup/kumalagroup_user_profil/simpan';
$route['kumalagroup_user_profil/edit'] = 'kumalagroup/kumalagroup_user_profil/edit';

// Audit Hino
// ----------BANK PENERIMAAN----------
// Penerimaan Unit Hino
$route['audit/kumalagroup_bank_penerimaan/unit'] = 'kumalagroup/audit/kumalagroup_bank_penerimaan/unit';
$route['audit/kumalagroup_bank_penerimaan/get_penerimaan_unit'] = 'kumalagroup/audit/kumalagroup_bank_penerimaan/get_penerimaan_unit';
$route['audit/kumalagroup_bank_penerimaan/set_status_cek_penerimaan_unit_for_audit'] = 'kumalagroup/audit/kumalagroup_bank_penerimaan/set_status_cek_penerimaan_unit_for_audit';

// Penerimaan After Sales Hino
$route['audit/kumalagroup_bank_penerimaan/after_sales'] = 'kumalagroup/audit/kumalagroup_bank_penerimaan/after_sales';
$route['audit/kumalagroup_bank_penerimaan/get_penerimaan_after_sales'] = 'kumalagroup/audit/kumalagroup_bank_penerimaan/get_penerimaan_after_sales';
$route['audit/kumalagroup_bank_penerimaan/set_status_cek_penerimaan_after_sales_for_audit'] = 'kumalagroup/audit/kumalagroup_bank_penerimaan/set_status_cek_penerimaan_after_sales_for_audit';

// Penerimaan Operasional Hino
$route['audit/kumalagroup_bank_penerimaan/operasional'] = 'kumalagroup/audit/kumalagroup_bank_penerimaan/operasional';
$route['audit/kumalagroup_bank_penerimaan/get_penerimaan_operasional'] = 'kumalagroup/audit/kumalagroup_bank_penerimaan/get_penerimaan_operasional';
$route['audit/kumalagroup_bank_penerimaan/set_status_cek_penerimaan_operasional_for_audit'] = 'kumalagroup/audit/kumalagroup_bank_penerimaan/set_status_cek_penerimaan_operasional_for_audit';

// ----------BANK PENGELUARAN----------
// Pengeluaran Unit Hino
$route['audit/kumalagroup_bank_pengeluaran/unit'] = 'kumalagroup/audit/kumalagroup_bank_pengeluaran/unit';
$route['audit/kumalagroup_bank_pengeluaran/get_pengeluaran_unit'] = 'kumalagroup/audit/kumalagroup_bank_pengeluaran/get_pengeluaran_unit';
$route['audit/kumalagroup_bank_pengeluaran/set_status_cek_pengeluaran_unit_for_audit'] = 'kumalagroup/audit/kumalagroup_bank_pengeluaran/set_status_cek_pengeluaran_unit_for_audit';

// Pengeluaran After Sales Hino
$route['audit/kumalagroup_bank_pengeluaran/after_sales'] = 'kumalagroup/audit/kumalagroup_bank_pengeluaran/after_sales';
$route['audit/kumalagroup_bank_pengeluaran/get_pengeluaran_after_sales'] = 'kumalagroup/audit/kumalagroup_bank_pengeluaran/get_pengeluaran_after_sales';
$route['audit/kumalagroup_bank_pengeluaran/set_status_cek_pengeluaran_after_sales_for_audit'] = 'kumalagroup/audit/kumalagroup_bank_pengeluaran/set_status_cek_pengeluaran_after_sales_for_audit';

// Pengeluaran Operasional Hino
$route['audit/kumalagroup_bank_pengeluaran/operasional'] = 'kumalagroup/audit/kumalagroup_bank_pengeluaran/operasional';
$route['audit/kumalagroup_bank_pengeluaran/get_pengeluaran_operasional'] = 'kumalagroup/audit/kumalagroup_bank_pengeluaran/get_pengeluaran_operasional';
$route['audit/kumalagroup_bank_pengeluaran/set_status_cek_pengeluaran_operasional_for_audit'] = 'kumalagroup/audit/kumalagroup_bank_pengeluaran/set_status_cek_pengeluaran_operasional_for_audit';


// ----------KAS PENERIMAAN----------
// Kas Penerimaan Unit Hino
$route['audit/kumalagroup_kas_penerimaan/unit'] = 'kumalagroup/audit/kumalagroup_kas_penerimaan/unit';
$route['audit/kumalagroup_kas_penerimaan/get_penerimaan_unit'] = 'kumalagroup/audit/kumalagroup_kas_penerimaan/get_penerimaan_unit';
$route['audit/kumalagroup_kas_penerimaan/set_status_cek_penerimaan_unit_for_audit'] = 'kumalagroup/audit/kumalagroup_kas_penerimaan/set_status_cek_penerimaan_unit_for_audit';

// Kas Penerimaan After Sales Hino
$route['audit/kumalagroup_kas_penerimaan/after_sales'] = 'kumalagroup/audit/kumalagroup_kas_penerimaan/after_sales';
$route['audit/kumalagroup_kas_penerimaan/get_penerimaan_after_sales'] = 'kumalagroup/audit/kumalagroup_kas_penerimaan/get_penerimaan_after_sales';
$route['audit/kumalagroup_kas_penerimaan/set_status_cek_penerimaan_after_sales_for_audit'] = 'kumalagroup/audit/kumalagroup_kas_penerimaan/set_status_cek_penerimaan_after_sales_for_audit';

// ----------KAS PENGELUARAN----------
// Kas Pengeluaran Unit Hino
$route['audit/kumalagroup_kas_pengeluaran/unit'] = 'kumalagroup/audit/kumalagroup_kas_pengeluaran/unit';
$route['audit/kumalagroup_kas_pengeluaran/get_pengeluaran_unit'] = 'kumalagroup/audit/kumalagroup_kas_pengeluaran/get_pengeluaran_unit';
$route['audit/kumalagroup_kas_pengeluaran/set_status_cek_pengeluaran_unit_for_audit'] = 'kumalagroup/audit/kumalagroup_kas_pengeluaran/set_status_cek_pengeluaran_unit_for_audit';

// Kas pengeluaran After Sales Hino
$route['audit/kumalagroup_kas_pengeluaran/after_sales'] = 'kumalagroup/audit/kumalagroup_kas_pengeluaran/after_sales';
$route['audit/kumalagroup_kas_pengeluaran/get_pengeluaran_after_sales'] = 'kumalagroup/audit/kumalagroup_kas_pengeluaran/get_pengeluaran_after_sales';
$route['audit/kumalagroup_kas_pengeluaran/set_status_cek_pengeluaran_after_sales_for_audit'] = 'kumalagroup/audit/kumalagroup_kas_pengeluaran/set_status_cek_pengeluaran_after_sales_for_audit';

// ----------DATA SPK----------
$route['audit/kumalagroup_data_spk/data_spk'] = 'kumalagroup/audit/kumalagroup_data_spk/data_spk';
$route['audit/kumalagroup_data_spk/get_data_spk'] = 'kumalagroup/audit/kumalagroup_data_spk/get_data_spk';

// ----------DATA DO----------
$route['audit/kumalagroup_data_do/data_do'] = 'kumalagroup/audit/kumalagroup_data_do/data_do';
$route['audit/kumalagroup_data_do/get_data_do'] = 'kumalagroup/audit/kumalagroup_data_do/get_data_do';

// ----------KARTU PIUTAN & AGING----------
// Detail Pembayaran SPK
$route['audit/kumalagroup_kartu_piutang_n_aging/detail_pembayaran_spk'] = 'kumalagroup/audit/kumalagroup_kartu_piutang_n_aging/detail_pembayaran_spk';
$route['audit/kumalagroup_kartu_piutang_n_aging/get_detail_pembayaran_spk'] = 'kumalagroup/audit/kumalagroup_kartu_piutang_n_aging/get_detail_pembayaran_spk';
$route['audit/kumalagroup_kartu_piutang_n_aging/detail_penerimaan_unit'] = 'kumalagroup/audit/kumalagroup_kartu_piutang_n_aging/detail_penerimaan_unit';
$route['audit/kumalagroup_kartu_piutang_n_aging/penerimaan_buku_besar'] = 'kumalagroup/audit/kumalagroup_kartu_piutang_n_aging/penerimaan_buku_besar';

//Kartu Piutang Invoice
$route['audit/kumalagroup_kartu_piutang_n_aging/kartu_piutang_invoice'] = 'kumalagroup/audit/kumalagroup_kartu_piutang_n_aging/kartu_piutang_invoice';
$route['audit/kumalagroup_kartu_piutang_n_aging/piutang_invoice'] = 'kumalagroup/audit/kumalagroup_kartu_piutang_n_aging/piutang_invoice';
$route['audit/kumalagroup_kartu_piutang_n_aging/detail_piutang_invoice'] = 'kumalagroup/audit/kumalagroup_kartu_piutang_n_aging/detail_piutang_invoice';


//Aging Schedule Invoice
$route['audit/kumalagroup_kartu_piutang_n_aging/aging_schedule'] = 'kumalagroup/audit/kumalagroup_kartu_piutang_n_aging/aging_schedule';
$route['audit/kumalagroup_kartu_piutang_n_aging/get_aging_schedule'] = 'kumalagroup/audit/kumalagroup_kartu_piutang_n_aging/get_aging_schedule';

//Probid
$route['probid/kumalagroup_probid/master_biaya'] = 'kumalagroup/probid/kumalagroup_probid/master_biaya';
$route['probid/kumalagroup_probid/simpan_master_biaya'] = 'kumalagroup/probid/kumalagroup_probid/simpan_master_biaya';
$route['probid/kumalagroup_probid/get_data_jenis_biaya'] = 'kumalagroup/probid/kumalagroup_probid/get_data_jenis_biaya';
$route['probid/kumalagroup_probid/simpan_detail_biaya'] = 'kumalagroup/probid/kumalagroup_probid/simpan_detail_biaya';

//Biaya Daftar Biaya
$route['probid/kumalagroup_daftar_biaya'] = 'kumalagroup/probid/kumalagroup_daftar_biaya';
$route['probid/kumalagroup_daftar_biaya/get_detail_biaya'] = 'kumalagroup/probid/kumalagroup_daftar_biaya/get_detail_biaya';
$route['probid/kumalagroup_daftar_biaya/simpan'] = 'kumalagroup/probid/kumalagroup_daftar_biaya/simpan';
$route['probid/kumalagroup_daftar_biaya/get_list_detail_biaya'] = 'kumalagroup/probid/kumalagroup_daftar_biaya/get_list_detail_biaya';

//Laporan Biaya
$route['probid/kumalagroup_laporan_biaya'] = 'kumalagroup/probid/kumalagroup_laporan_biaya';
$route['probid/kumalagroup_laporan_biaya/get_laporan_biaya'] = 'kumalagroup/probid/kumalagroup_laporan_biaya/get_laporan_biaya';
$route['probid/kumalagroup_laporan_biaya/export_excel'] = 'kumalagroup/probid/kumalagroup_laporan_biaya/export_excel';

//Dashboard Biaya
$route['probid/kumalagroup_dashboard_biaya'] = 'kumalagroup/probid/kumalagroup_dashboard_biaya';
$route['probid/kumalagroup_dashboard_biaya/json_chart_get_data'] = 'kumalagroup/probid/kumalagroup_dashboard_biaya/json_chart_get_data';
$route['probid/kumalagroup_dashboard_biaya/detail_biaya'] = 'kumalagroup/probid/kumalagroup_dashboard_biaya/detail_biaya';

// $route['probid/kumalagroup_probid/master_biaya_external'] = 'kumalagroup/probid/kumalagroup_probid/master_biaya_external';
// $route['probid/kumalagroup_probid/master_biaya_internal'] = 'kumalagroup/probid/kumalagroup_probid/master_biaya_internal';
// $route['probid/kumalagroup_probid/detail_pembayaran_external'] = 'kumalagroup/probid/kumalagroup_probid/detail_pembayaran_external';
// $route['probid/kumalagroup_probid/detail_pembayaran_internal'] = 'kumalagroup/probid/kumalagroup_probid/detail_pembayaran_internal';
// $route['probid/kumalagroup_probid/biaya_detail'] = 'kumalagroup/probid/kumalagroup_probid/biaya_detail';
// $route['probid/kumalagroup_probid/biaya_detail_add'] = 'kumalagroup/probid/kumalagroup_probid/biaya_detail_add';
