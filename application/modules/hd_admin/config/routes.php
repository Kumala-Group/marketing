<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Remove the default route set by the module extensions
|--------------------------------------------------------------------------
|
| Normally by default this route is accepted:
|
| module/controller/method
|
| If you do not want to allow access via that route you should add:
|
| $route['module'] = "";
| $route['module/(:any)'] = "";
|
*/

//$route['report/(:any)'] = "";
/*
|--------------------------------------------------------------------------
| Routes to accept
|--------------------------------------------------------------------------
|
| Map all of your valid module routes here such as:
|
| $route['your/custom/route'] = "controller/method";
|
*/

/*--- OLI ROUTE --- */

/* Home */
$route['hd_adm_home'] = "hd_admin/hd_adm_home";
$route['hd_landing_page'] = "hd_admin/hd_landing_page";

$route['hd_adm_home_client'] = "hd_admin/hd_adm_home_client";

/* DataTables*/
$route['hd_adm_datatable'] = "hd_admin/hd_adm_datatable";
$route['hd_adm_datatable/no_penjualan'] = "hd_admin/hd_adm_datatable/no_penjualan";
$route['hd_adm_datatable/no_po'] = "hd_admin/hd_adm_datatable/no_po";
$route['hd_adm_datatable/kode_supplier'] = "hd_admin/hd_adm_datatable/kode_supplier";
$route['hd_adm_datatable/nik_karyawan'] = "hd_admin/hd_adm_datatable/nik_karyawan";
$route['hd_adm_datatable/nik_karyawan_it'] = "hd_admin/hd_adm_datatable/nik_karyawan_it";
$route['hd_adm_datatable/karyawan/(:num)'] = "hd_admin/hd_adm_datatable/karyawan/(:num)";
$route['hd_adm_datatable/kode_hd'] = "hd_admin/hd_adm_datatable/kode_hd";
$route['hd_adm_datatable/search_hd'] = "hd_admin/hd_adm_datatable/search_hd";
$route['hd_adm_datatable/search_gudang'] = "hd_admin/hd_adm_datatable/search_gudang";
$route['hd_adm_datatable/search_pelanggan'] = "hd_admin/hd_adm_datatable/search_pelanggan";
$route['hd_adm_datatable/pes_penj_per_hr'] = "hd_admin/hd_adm_datatable/pes_penj_per_hr";
$route['hd_adm_datatable/no_faktur'] = "hd_admin/hd_adm_datatable/no_faktur";

/* Master - Hardware */
$route['hd_adm_hardware'] = "hd_admin/hd_adm_hardware";
$route['hd_adm_hardware/create_kd'] = "hd_admin/hd_adm_hardware/create_kd";
$route['hd_adm_hardware/cari'] = "hd_admin/hd_adm_hardware/cari";
$route['hd_adm_hardware/simpan'] = "hd_admin/hd_adm_hardware/simpan";
$route['hd_adm_hardware/hapus/(:num)'] = "hd_admin/hd_adm_hardware/hapus";
$route['hd_adm_hardware/view_data'] = "hd_admin/hd_adm_hardware/view_data";

// Master - Finger
$route['hd_adm_fingerscan'] = "hd_admin/hd_adm_fingerscan";
$route['hd_adm_fingerscan/create_kd'] = "hd_admin/hd_adm_fingerscan/create_kd";
$route['hd_adm_fingerscan/cari'] = "hd_admin/hd_adm_fingerscan/cari";
$route['hd_adm_fingerscan/simpan'] = "hd_admin/hd_adm_fingerscansimpan";
$route['hd_adm_fingerscan/hapus/(:num)'] = "hd_admin/hd_adm_fingerscan/hapus";
$route['hd_adm_fingerscan/view_data'] = "hd_admin/hd_adm_fingerscan/view_data";

/* Profil */
$route['hd_adm_profil'] = "hd_admin/hd_adm_profil";
$route['hd_adm_profil/simpan_profil'] = "hd_admin/hd_adm_profil/simpan_profil";
$route['hd_adm_profil/simpan_foto'] = "hd_admin/hd_adm_profil/simpan_foto";
$route['hd_adm_profil/simpan_pwd'] = "hd_admin/hd_adm_profil/simpan_pwd";
$route['hd_adm_profil/simpan_open_username'] = "hd_admin/hd_adm_profil/simpan_open_username";

/* Master - Supplier */
$route['hd_adm_absensi'] = "hd_admin/hd_adm_absensi";
$route['hd_adm_absensi/cari'] = "hd_admin/hd_adm_absensi/cari";
$route['hd_adm_absensi/simpan'] = "hd_admin/hd_adm_absensi/simpan";
$route['hd_adm_absensi/hapus/(:num)'] = "hd_admin/hd_adm_absensi/hapus";

/* Master - Pelanggan */
$route['hd_adm_pelanggan'] = "hd_admin/hd_adm_pelanggan";
$route['hd_adm_pelanggan/cari'] = "hd_admin/hd_adm_pelanggan/cari";
$route['hd_adm_pelanggan/simpan'] = "hd_admin/hd_adm_pelanggan/simpan";
$route['hd_adm_pelanggan/hapus/(:num)'] = "hd_admin/hd_adm_pelanggan/hapus";

/* Master - Sales */
$route['hd_adm_sales'] = "hd_admin/hd_adm_sales";
$route['hd_adm_sales/cari'] = "hd_admin/hd_adm_sales/cari";
$route['hd_adm_sales/simpan'] = "hd_admin/hd_adm_sales/simpan";
$route['hd_adm_sales/hapus/(:num)'] = "hd_admin/hd_adm_sales/hapus";

/* Master - Satuan */
$route['hd_adm_satuan'] = "hd_admin/hd_adm_satuan";
$route['hd_adm_satuan/cari'] = "hd_admin/hd_adm_satuan/cari";
$route['hd_adm_satuan/simpan'] = "hd_admin/hd_adm_satuan/simpan";
$route['hd_adm_satuan/hapus/(:num)'] = "hd_admin/hd_adm_satuan/hapus";

/* Master - Satuan */
$route['hd_adm_jenis_pembayaran'] = "hd_admin/hd_adm_jenis_pembayaran";
$route['hd_adm_jenis_pembayaran/cari'] = "hd_admin/hd_adm_jenis_pembayaran/cari";
$route['hd_adm_jenis_pembayaran/simpan'] = "hd_admin/hd_adm_jenis_pembayaran/simpan";
$route['hd_adm_jenis_pembayaran/hapus/(:num)'] = "hd_admin/hd_adm_jenis_pembayaran/hapus";

/* Master - Bank */
$route['hd_adm_hdk'] = "hd_admin/hd_adm_hdk";
$route['hd_adm_hdk/cari'] = "hd_admin/hd_adm_hdk/cari";
$route['hd_adm_hdk/simpan'] = "hd_admin/hd_adm_hdk/simpan";
$route['hd_adm_hdk/hapus/(:num)'] = "hd_admin/hd_adm_hdk/hapus";

/* Master - Gudang */
$route['hd_adm_gudang'] = "hd_admin/hd_adm_gudang";
$route['hd_adm_gudang/cari'] = "hd_admin/hd_adm_gudang/cari";
$route['hd_adm_gudang/simpan'] = "hd_admin/hd_adm_gudang/simpan";
$route['hd_adm_gudang/hapus/(:num)'] = "hd_admin/hd_adm_gudang/hapus";

/* Master - E-Faktur*/
$route['hd_adm_e_faktur'] = "hd_admin/hd_adm_e_faktur";
$route['hd_adm_e_faktur/simpan'] = "hd_admin/hd_adm_e_faktur/simpan";
$route['hd_adm_e_faktur/cari'] = "hd_admin/hd_adm_e_faktur/cari";
$route['hd_adm_e_faktur/fetchdata'] = "hd_admin/hd_adm_e_faktur/fetchdata";
$route['hd_adm_e_faktur/hapus/(:num)'] = "hd_admin/hd_adm_e_faktur/hapus";


/* For Search Ban */
$route['hd_adm_search/search_kd_hd'] = "hd_admin/hd_adm_search/search_kd_hd";
$route['hd_adm_search/search_nm_hd'] = "hd_admin/hd_adm_search/search_nm_hd";
$route['hd_adm_search/search_nonseparated_hd'] = "hd_admin/hd_adm_search/search_nonseparated_hd";
$route['hd_adm_search/search_kd_pelanggan/(:any)'] = "hd_admin/hd_adm_search/search_kd_pelanggan";
$route['hd_adm_search/search_nm_pelanggan/(:any)'] = "hd_admin/hd_adm_search/search_nm_pelanggan";
$route['hd_adm_search/search_kd_sales/(:any)'] = "hd_admin/hd_adm_search/search_kd_sales";
$route['hd_adm_search/search_nm_sales/(:any)'] = "hd_admin/hd_adm_search/search_nm_sales";
$route['hd_adm_search/search_kd_supplier/(:any)'] = "hd_admin/hd_adm_search/search_kd_supplier";
$route['hd_adm_search/search_nm_supplier/(:any)'] = "hd_admin/hd_adm_search/search_nm_supplier";

/* Pembelian - Pesanan Pembelian */
$route['hd_adm_pesanan_pembelian'] = "hd_admin/hd_adm_pesanan_pembelian";
$route['hd_adm_pesanan_pembelian/edit/(:num)'] = "hd_admin/hd_adm_pesanan_pembelian/edit";
$route['hd_adm_pesanan_pembelian/simpan'] = "hd_admin/hd_adm_pesanan_pembelian/simpan";
$route['hd_adm_pesanan_pembelian/baru'] = "hd_admin/hd_adm_pesanan_pembelian/baru";
$route['hd_adm_pesanan_pembelian/t_simpan'] = "hd_admin/hd_adm_pesanan_pembelian/t_simpan";
$route['hd_adm_pesanan_pembelian/hapus/(:num)'] = "hd_admin/hd_adm_pesanan_pembelian/hapus";
$route['hd_adm_pesanan_pembelian/tambah'] = "hd_admin/hd_adm_pesanan_pembelian/tambah";
$route['hd_adm_pesanan_pembelian/cetak'] = "hd_admin/hd_adm_pesanan_pembelian/cetak";
$route['hd_adm_pesanan_pembelian/cek_table'] = "hd_admin/hd_adm_pesanan_pembelian/cek_table";

/* Ticketing */ /* Ticketing */
$route['hd_adm_control_honda'] = "hd_admin/hd_adm_control_honda";

/* Ticketing */ /* Ticketing */
$route['hd_adm_solving'] = "hd_admin/hd_adm_solving";
$route['hd_adm_ticketing'] = "hd_admin/hd_adm_ticketing";
$route['hd_adm_ticketing/cari'] = "hd_admin/hd_adm_ticketing/cari";
$route['hd_adm_ticketing/edit/(:num)'] = "hd_admin/hd_adm_ticketing/edit";
$route['hd_adm_ticketing/tambah_solving/(:num)'] = "hd_admin/hd_adm_ticketing/tambah_solving";
$route['hd_adm_ticketing/simpan'] = "hd_admin/hd_adm_ticketing/simpan";
$route['hd_adm_ticketing/baru'] = "hd_admin/hd_adm_ticketing/baru";
$route['hd_adm_ticketing/t_simpan'] = "hd_admin/hd_adm_ticketing/t_simpan";
$route['hd_adm_ticketing/t_solv_simpan'] = "hd_admin/hd_adm_ticketing/t_solv_simpan";
$route['hd_adm_ticketing/hapus/(:num)'] = "hd_admin/hd_adm_ticketing/hapus";
$route['hd_adm_ticketing/tambah'] = "hd_admin/hd_adm_ticketing/tambah";
$route['hd_adm_ticketing/cetak'] = "hd_admin/hd_adm_ticketing/cetak";
$route['hd_adm_ticketing/cek_table'] = "hd_admin/hd_adm_ticketing/cek_table";

$route['hd_adm_ticketing/update'] = "hd_admin/hd_adm_ticketing/update";
$route['hd_adm_solving/sortir'] = "hd_admin/hd_adm_solving/sortir";
$route['hd_adm_solving/cetak_excel'] = "hd_admin/hd_adm_solving/cetak_excel";
$route['hd_adm_solving/edit/(:num)'] = "hd_admin/hd_adm_solving/edit/$1";
$route['hd_adm_solving/simpan_edited'] = "hd_admin/hd_adm_solving/simpan_edited";

$route['hd_adm_ticketing_dashboard'] = "hd_admin/hd_adm_ticketing_dashboard";
$route['hd_adm_ticketing_dashboard/sortir'] = "hd_admin/hd_adm_ticketing_dashboard/sortir";

$route['hd_adm_n_tiket'] = "hd_admin/hd_adm_n_tiket";
$route['hd_adm_n_tiket/done'] = "hd_admin/hd_adm_n_tiket/done";

$route['hd_adm_ticketing_client'] = "hd_admin/hd_adm_ticketing_client";
$route['hd_adm_ticketing_client/cari'] = "hd_admin/hd_adm_ticketing_client/cari";
$route['hd_adm_ticketing_client/edit/(:num)'] = "hd_admin/hd_adm_ticketing_client/edit";
$route['hd_adm_ticketing_client/tambah_solving/(:num)'] = "hd_admin/hd_adm_ticketing_client/tambah_solving";
$route['hd_adm_ticketing_client/simpan'] = "hd_admin/hd_adm_ticketing_client/simpan";
$route['hd_adm_ticketing_client/baru'] = "hd_admin/hd_adm_ticketing_client/baru";
$route['hd_adm_ticketing_client/t_simpan'] = "hd_admin/hd_adm_ticketing_client/t_simpan";
$route['hd_adm_ticketing_client/t_solv_simpan'] = "hd_admin/hd_adm_ticketing_client/t_solv_simpan";
$route['hd_adm_ticketing_client/hapus/(:num)'] = "hd_admin/hd_adm_ticketing_client/hapus";
$route['hd_adm_ticketing_client/tambah'] = "hd_admin/hd_adm_ticketing_client/tambah";
$route['hd_adm_ticketing_client/cetak'] = "hd_admin/hd_adm_ticketing_client/cetak";
$route['hd_adm_ticketing_client/cek_table'] = "hd_admin/hd_adm_ticketing_client/cek_table";

$route['hd_adm_ticketing_laporan'] = "hd_admin/hd_adm_ticketing_laporan";
$route['hd_adm_ticketing_laporan/laporan'] = "hd_admin/hd_adm_ticketing_laporan/laporan";

/* Pustaka - Jenis Hardware */
$route['hd_adm_jenis_hardware'] = "hd_admin/hd_adm_jenis_hardware";
$route['hd_adm_jenis_hardware/simpan'] = "hd_admin/hd_adm_jenis_hardware/simpan";
$route['hd_adm_jenis_hardware/cari'] = "hd_admin/hd_adm_jenis_hardware/cari";
$route['hd_adm_jenis_hardware/hapus/(:num)'] = "hd_admin/hd_adm_jenis_hardware/hapus";


$route['hd_adm_n_baru'] = "hd_admin/hd_adm_n_baru";
$route['hd_adm_n_baru/hapus/(:num)'] = "hd_admin/hd_adm_n_baru/hapus";


/* Pustaka - Jenis Kontrak */
$route['hd_adm_jenis_kontrak'] = "hd_admin/hd_adm_jenis_kontrak";
$route['hd_adm_jenis_kontrak/simpan'] = "hd_admin/hd_adm_jenis_kontrak/simpan";
$route['hd_adm_jenis_kontrak/cari'] = "hd_admin/hd_adm_jenis_kontrak/cari";
$route['hd_adm_jenis_kontrak/hapus/(:num)'] = "hd_admin/hd_adm_jenis_kontrak/hapus";

/* Pustaka - Kontrak */
$route['hd_adm_kontrak'] = "hd_admin/hd_adm_kontrak";
$route['hd_adm_kontrak/simpan'] = "hd_admin/hd_adm_kontrak/simpan";
$route['hd_adm_kontrak/cari'] = "hd_admin/hd_adm_kontrak/cari";
$route['hd_adm_kontrak/hapus/(:num)'] = "hd_admin/hd_adm_kontrak/hapus";

/* Pustaka - Program Penjualan */
$route['hd_adm_program_penjualan'] = "hd_admin/hd_adm_program_penjualan";
$route['hd_adm_program_penjualan/simpan'] = "hd_admin/hd_adm_program_penjualan/simpan";
$route['hd_adm_program_penjualan/simpan_detail'] = "hd_admin/hd_adm_program_penjualan/simpan_detail";
$route['hd_adm_program_penjualan/simpan_pp'] = "hd_admin/hd_adm_program_penjualan/simpan_pp";
$route['hd_adm_program_penjualan/t_simpan'] = "hd_admin/hd_adm_program_penjualan/t_simpan";
$route['hd_adm_program_penjualan/t_cari'] = "hd_admin/hd_adm_program_penjualan/t_cari";
$route['hd_adm_program_penjualan/cari_detail'] = "hd_admin/hd_adm_program_penjualan/cari_detail";
$route['hd_adm_program_penjualan/tambah'] = "hd_admin/hd_adm_program_penjualan/tambah";
$route['hd_adm_program_penjualan/edit/(:num)'] = "hd_admin/hd_adm_program_penjualan/edit";
$route['hd_adm_program_penjualan/baru'] = "hd_admin/hd_adm_program_penjualan/baru";
$route['hd_adm_program_penjualan/cek_table'] = "hd_admin/hd_adm_program_penjualan/cek_table";
$route['hd_adm_program_penjualan/cek_table_pp'] = "hd_admin/hd_adm_program_penjualan/cek_table_pp";
$route['hd_adm_program_penjualan/hapus/(:num)'] = "hd_admin/hd_adm_program_penjualan/hapus";
$route['hd_adm_program_penjualan/hapus_detail/(:num)'] = "hd_admin/hd_adm_program_penjualan/hapus_detail";
$route['hd_adm_program_penjualan/t_hapus/(:num)'] = "hd_admin/hd_adm_program_penjualan/t_hapus";

/* Pemberitahuan Pengaduan */
$route['hd_adm_n_tiket'] = "hd_admin/hd_adm_n_tiket";
$route['hd_adm_n_tiket/pending'] = "hd_admin/hd_adm_n_tiket/pending";
$route['hd_adm_n_tiket/hapus/(:num)'] = "hd_admin/hd_adm_n_tiket/hapus";

/* Pemberitahuan Jatuh Tempo */
$route['hd_adm_n_jt'] = "hd_admin/hd_adm_n_jt";
$route['hd_adm_n_jt/hapus/(:num)'] = "hd_admin/hd_adm_n_jt/hapus";

// Original version would have to have yourmodule at the start of the route for the routes.php to be read
/* Home */
$route['hd_home/hd_home'] = "hd_admin/hd_home";

/* Biodata*/
$route['biodata'] = "hd_admin/biodata";

// UPDATE VERSION WULING
$route['hd_adm_update_wuling'] = "hd_admin/hd_adm_update_wuling";
$route['hd_adm_update_wuling/simpan'] = "hd_admin/hd_adm_update_wuling/simpan";
$route['hd_adm_update_wuling/hapus_data'] = "hd_admin/hd_adm_update_wuling/hapus_data";
$route['hd_adm_update_wuling/delete_update'] = "hd_admin/hd_adm_update_wuling/delete_update";
$route['hd_adm_update_wuling/cari_data'] = "hd_admin/hd_adm_update_wuling/cari_data";
$route['hd_adm_update_wuling/simpan_detail_update'] = "hd_admin/hd_adm_update_wuling/simpan_detail_update";

// UPDATE VERSION HONDA
$route['hd_adm_update_honda'] = "hd_admin/hd_adm_update_honda";
$route['hd_adm_update_honda/simpan'] = "hd_admin/hd_adm_update_honda/simpan";
$route['hd_adm_update_honda/hapus_data'] = "hd_admin/hd_adm_update_honda/hapus_data";
$route['hd_adm_update_honda/delete_update'] = "hd_admin/hd_adm_update_honda/delete_update";
$route['hd_adm_update_honda/cari_data'] = "hd_admin/hd_adm_update_honda/cari_data";
$route['hd_adm_update_honda/simpan_detail_update'] = "hd_admin/hd_adm_update_honda/simpan_detail_update";

// UPDATE VERSION HINO
$route['hd_adm_update_hino'] = "hd_admin/hd_adm_update_hino";
$route['hd_adm_update_hino/simpan'] = "hd_admin/hd_adm_update_hino/simpan";
$route['hd_adm_update_hino/hapus_data'] = "hd_admin/hd_adm_update_hino/hapus_data";
$route['hd_adm_update_hino/delete_update'] = "hd_admin/hd_adm_update_hino/delete_update";
$route['hd_adm_update_hino/cari_data'] = "hd_admin/hd_adm_update_hino/cari_data";
$route['hd_adm_update_hino/simpan_detail_update'] = "hd_admin/hd_adm_update_hino/simpan_detail_update";

// UPDATE VERSION KMG
$route['hd_adm_update_kmg'] = "hd_admin/hd_adm_update_kmg";
$route['hd_adm_update_kmg/simpan'] = "hd_admin/hd_adm_update_kmg/simpan";
$route['hd_adm_update_kmg/hapus_data'] = "hd_admin/hd_adm_update_kmg/hapus_data";
$route['hd_adm_update_kmg/delete_update'] = "hd_admin/hd_adm_update_kmg/delete_update";
$route['hd_adm_update_kmg/cari_data'] = "hd_admin/hd_adm_update_kmg/cari_data";
$route['hd_adm_update_kmg/simpan_detail_update'] = "hd_admin/hd_adm_update_kmg/simpan_detail_update";

// UPDATE VERSION KBC
$route['hd_adm_update_kbc'] = "hd_admin/hd_adm_update_kbc";
$route['hd_adm_update_kbc/simpan'] = "hd_admin/hd_adm_update_kbc/simpan";
$route['hd_adm_update_kbc/hapus_data'] = "hd_admin/hd_adm_update_kbc/hapus_data";
$route['hd_adm_update_kbc/delete_update'] = "hd_admin/hd_adm_update_kbc/delete_update";
$route['hd_adm_update_kbc/cari_data'] = "hd_admin/hd_adm_update_kbc/cari_data";
$route['hd_adm_update_kbc/simpan_detail_update'] = "hd_admin/hd_adm_update_kbc/simpan_detail_update";

// UPDATE VERSION KSS
$route['hd_adm_update_kss'] = "hd_admin/hd_adm_update_kss";
$route['hd_adm_update_kss/simpan'] = "hd_admin/hd_adm_update_kss/simpan";
$route['hd_adm_update_kss/hapus_data'] = "hd_admin/hd_adm_update_kss/hapus_data";
$route['hd_adm_update_kss/delete_update'] = "hd_admin/hd_adm_update_kss/delete_update";
$route['hd_adm_update_kss/cari_data'] = "hd_admin/hd_adm_update_kss/cari_data";
$route['hd_adm_update_kss/simpan_detail_update'] = "hd_admin/hd_adm_update_kss/simpan_detail_update";

// UPDATE VERSION BAN
$route['hd_adm_update_ban'] = "hd_admin/hd_adm_update_ban";
$route['hd_adm_update_ban/simpan'] = "hd_admin/hd_adm_update_ban/simpan";
$route['hd_adm_update_ban/hapus_data'] = "hd_admin/hd_adm_update_ban/hapus_data";
$route['hd_adm_update_ban/delete_update'] = "hd_admin/hd_adm_update_ban/delete_update";
$route['hd_adm_update_ban/cari_data'] = "hd_admin/hd_adm_update_ban/cari_data";
$route['hd_adm_update_ban/simpan_detail_update'] = "hd_admin/hd_adm_update_ban/simpan_detail_update";

// UPDATE VERSION OLI
$route['hd_adm_update_oli'] = "hd_admin/hd_adm_update_oli";
$route['hd_adm_update_oli/simpan'] = "hd_admin/hd_adm_update_oli/simpan";
$route['hd_adm_update_oli/hapus_data'] = "hd_admin/hd_adm_update_oli/hapus_data";
$route['hd_adm_update_oli/delete_update'] = "hd_admin/hd_adm_update_oli/delete_update";
$route['hd_adm_update_oli/cari_data'] = "hd_admin/hd_adm_update_oli/cari_data";
$route['hd_adm_update_oli/simpan_detail_update'] = "hd_admin/hd_adm_update_oli/simpan_detail_update";

// UPDATE VERSION MAZDA
$route['hd_adm_update_mazda'] = "hd_admin/hd_adm_update_mazda";
$route['hd_adm_update_mazda/simpan'] = "hd_admin/hd_adm_update_mazda/simpan";
$route['hd_adm_update_mazda/hapus_data'] = "hd_admin/hd_adm_update_mazda/hapus_data";
$route['hd_adm_update_mazda/delete_update'] = "hd_admin/hd_adm_update_mazda/delete_update";
$route['hd_adm_update_mazda/cari_data'] = "hd_admin/hd_adm_update_mazda/cari_data";
$route['hd_adm_update_mazda/simpan_detail_update'] = "hd_admin/hd_adm_update_mazda/simpan_detail_update";

// UPDATE VERSION MERCEDES
$route['hd_adm_update_mercedes'] = "hd_admin/hd_adm_update_mercedes";
$route['hd_adm_update_mercedes/simpan'] = "hd_admin/hd_adm_update_mercedes/simpan";
$route['hd_adm_update_mercedes/hapus_data'] = "hd_admin/hd_adm_update_mercedes/hapus_data";
$route['hd_adm_update_mercedes/delete_update'] = "hd_admin/hd_adm_update_mercedes/delete_update";
$route['hd_adm_update_mercedes/cari_data'] = "hd_admin/hd_adm_update_mercedes/cari_data";
$route['hd_adm_update_mercedes/simpan_detail_update'] = "hd_admin/hd_adm_update_mercedes/simpan_detail_update";

// UPDATE VERSION TANAH MERAH
$route['hd_adm_update_tanamera'] = "hd_admin/hd_adm_update_tanamera";
$route['hd_adm_update_tanamera/simpan'] = "hd_admin/hd_adm_update_tanamera/simpan";
$route['hd_adm_update_tanamera/hapus_data'] = "hd_admin/hd_adm_update_tanamera/hapus_data";
$route['hd_adm_update_tanamera/delete_update'] = "hd_admin/hd_adm_update_tanamera/delete_update";
$route['hd_adm_update_tanamera/cari_data'] = "hd_admin/hd_adm_update_tanamera/cari_data";
$route['hd_adm_update_tanamera/simpan_detail_update'] = "hd_admin/hd_adm_update_tanamera/simpan_detail_update";

// UPDATE VERSION TANAH MERAH
$route['hd_adm_update_hrd'] = "hd_admin/hd_adm_update_hrd";
$route['hd_adm_update_hrd/simpan'] = "hd_admin/hd_adm_update_hrd/simpan";
$route['hd_adm_update_hrd/hapus_data'] = "hd_admin/hd_adm_update_hrd/hapus_data";
$route['hd_adm_update_hrd/delete_update'] = "hd_admin/hd_adm_update_hrd/delete_update";
$route['hd_adm_update_hrd/cari_data'] = "hd_admin/hd_adm_update_hrd/cari_data";
$route['hd_adm_update_hrd/simpan_detail_update'] = "hd_admin/hd_adm_update_hrd/simpan_detail_update";

// UPDATE VERSION KUMALA MINING
$route['hd_adm_update_kumala_mining'] = "hd_admin/hd_adm_update_kumala_mining";
$route['hd_adm_update_kumala_mining/simpan'] = "hd_admin/hd_adm_update_kumala_mining/simpan";
$route['hd_adm_update_kumala_mining/hapus_data'] = "hd_admin/hd_adm_update_kumala_mining/hapus_data";
$route['hd_adm_update_kumala_mining/delete_update'] = "hd_admin/hd_adm_update_kumala_mining/delete_update";
$route['hd_adm_update_kumala_mining/cari_data'] = "hd_admin/hd_adm_update_kumala_mining/cari_data";
$route['hd_adm_update_kumala_mining/simpan_detail_update'] = "hd_admin/hd_adm_update_kumala_mining/simpan_detail_update";

// UPDATE VERSION KCE
$route['hd_adm_update_kce'] = "hd_admin/hd_adm_update_kce";
$route['hd_adm_update_kce/simpan'] = "hd_admin/hd_adm_update_kce/simpan";
$route['hd_adm_update_kce/hapus_data'] = "hd_admin/hd_adm_update_kce/hapus_data";
$route['hd_adm_update_kce/delete_update'] = "hd_admin/hd_adm_update_kce/delete_update";
$route['hd_adm_update_kce/cari_data'] = "hd_admin/hd_adm_update_kce/cari_data";
$route['hd_adm_update_kce/simpan_detail_update'] = "hd_admin/hd_adm_update_kce/simpan_detail_update";

// UPDATE VERSION CPS
$route['hd_adm_update_cps'] = "hd_admin/hd_adm_update_cps";
$route['hd_adm_update_cps/simpan'] = "hd_admin/hd_adm_update_cps/simpan";
$route['hd_adm_update_cps/hapus_data'] = "hd_admin/hd_adm_update_cps/hapus_data";
$route['hd_adm_update_cps/delete_update'] = "hd_admin/hd_adm_update_cps/delete_update";
$route['hd_adm_update_cps/cari_data'] = "hd_admin/hd_adm_update_cps/cari_data";
$route['hd_adm_update_cps/simpan_detail_update'] = "hd_admin/hd_adm_update_cps/simpan_detail_update";

// UPDATE VERSION KPP
$route['hd_adm_update_kpp'] = "hd_admin/hd_adm_update_kpp";
$route['hd_adm_update_kpp/simpan'] = "hd_admin/hd_adm_update_kpp/simpan";
$route['hd_adm_update_kpp/hapus_data'] = "hd_admin/hd_adm_update_kpp/hapus_data";
$route['hd_adm_update_kpp/delete_update'] = "hd_admin/hd_adm_update_kpp/delete_update";
$route['hd_adm_update_kpp/cari_data'] = "hd_admin/hd_adm_update_kpp/cari_data";
$route['hd_adm_update_kpp/simpan_detail_update'] = "hd_admin/hd_adm_update_kpp/simpan_detail_update";

// UPDATE VERSION KPM
$route['hd_adm_update_kpm'] = "hd_admin/hd_adm_update_kpm";
$route['hd_adm_update_kpm/simpan'] = "hd_admin/hd_adm_update_kpm/simpan";
$route['hd_adm_update_kpm/hapus_data'] = "hd_admin/hd_adm_update_kpm/hapus_data";
$route['hd_adm_update_kpm/delete_update'] = "hd_admin/hd_adm_update_kpm/delete_update";
$route['hd_adm_update_kpm/cari_data'] = "hd_admin/hd_adm_update_kpm/cari_data";
$route['hd_adm_update_kpm/simpan_detail_update'] = "hd_admin/hd_adm_update_kpm/simpan_detail_update";

// UPDATE VERSION AUDIT
$route['hd_adm_update_audit'] = "hd_admin/hd_adm_update_audit";
$route['hd_adm_update_audit/simpan'] = "hd_admin/hd_adm_update_audit/simpan";
$route['hd_adm_update_audit/hapus_data'] = "hd_admin/hd_adm_update_audit/hapus_data";
$route['hd_adm_update_audit/delete_update'] = "hd_admin/hd_adm_update_audit/delete_update";
$route['hd_adm_update_audit/cari_data'] = "hd_admin/hd_adm_update_audit/cari_data";
$route['hd_adm_update_audit/simpan_detail_update'] = "hd_admin/hd_adm_update_audit/simpan_detail_update";

// UPDATE VERSION IT
$route['hd_adm_update_it'] = "hd_admin/hd_adm_update_it";
$route['hd_adm_update_it/simpan'] = "hd_admin/hd_adm_update_it/simpan";
$route['hd_adm_update_it/hapus_data'] = "hd_admin/hd_adm_update_it/hapus_data";
$route['hd_adm_update_it/delete_update'] = "hd_admin/hd_adm_update_it/delete_update";
$route['hd_adm_update_it/cari_data'] = "hd_admin/hd_adm_update_it/cari_data";
$route['hd_adm_update_it/simpan_detail_update'] = "hd_admin/hd_adm_update_it/simpan_detail_update";

// UPDATE VERSION MARKETING
$route['hd_adm_update_marketing'] = "hd_admin/hd_adm_update_marketing";
$route['hd_adm_update_marketing/simpan'] = "hd_admin/hd_adm_update_marketing/simpan";
$route['hd_adm_update_marketing/hapus_data'] = "hd_admin/hd_adm_update_marketing/hapus_data";
$route['hd_adm_update_marketing/delete_update'] = "hd_admin/hd_adm_update_marketing/delete_update";
$route['hd_adm_update_marketing/cari_data'] = "hd_admin/hd_adm_update_marketing/cari_data";
$route['hd_adm_update_marketing/simpan_detail_update'] = "hd_admin/hd_adm_update_marketing/simpan_detail_update";

/* End Biodata*/
