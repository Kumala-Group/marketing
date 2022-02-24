<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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

/*--- HNKL ROUTE --- */

/* Home */
$route['henkel'] = "henkel_admin/henkel";
$route['henkel/logout'] = "henkel_admin/henkel/logout";
$route['henkel_adm_home'] = "henkel_admin/henkel_adm_home";

/* DataTables*/
$route['henkel_adm_datatable'] = "henkel_admin/henkel_adm_datatable";
$route['henkel_adm_datatable/no_penjualan'] = "henkel_admin/henkel_adm_datatable/no_penjualan";
$route['henkel_adm_datatable/no_po'] = "henkel_admin/henkel_adm_datatable/no_po";
$route['henkel_adm_datatable/no_po_angkut'] = "henkel_admin/henkel_adm_datatable/no_po_angkut";
$route['henkel_adm_datatable/kode_supplier'] = "henkel_admin/henkel_adm_datatable/kode_supplier";
$route['henkel_adm_datatable/kode_item'] = "henkel_admin/henkel_adm_datatable/kode_item";
$route['henkel_adm_datatable/search_item'] = "henkel_admin/henkel_adm_datatable/search_item";
$route['henkel_adm_datatable/search_gudang'] = "henkel_admin/henkel_adm_datatable/search_gudang";
$route['henkel_adm_datatable/search_supplier'] = "henkel_admin/henkel_adm_datatable/search_supplier";
$route['henkel_adm_datatable/search_sales'] = "henkel_admin/henkel_adm_datatable/search_sales";
$route['henkel_adm_datatable/search_pelanggan'] = "henkel_admin/henkel_adm_datatable/search_pelanggan";
$route['henkel_adm_datatable/search_laporan_pelanggan'] = "henkel_admin/henkel_adm_datatable/search_laporan_pelanggan";
$route['henkel_adm_datatable/search_no_invoice'] = "henkel_admin/henkel_adm_datatable/search_no_invoice";
$route['henkel_adm_datatable/search_data_transaksi'] = "henkel_admin/henkel_adm_datatable/search_data_transaksi";
$route['henkel_adm_datatable/jenis_item'] = "henkel_admin/henkel_adm_datatable/jenis_item";
$route['henkel_adm_datatable/item_master'] = "henkel_admin/henkel_adm_datatable/item_master";
$route['henkel_adm_datatable/pes_penj_per_hr'] = "henkel_admin/henkel_adm_datatable/pes_penj_per_hr";
$route['henkel_adm_datatable/no_faktur'] = "henkel_admin/henkel_adm_datatable/no_faktur";

/* Master - Item */
$route['henkel_adm'] = "henkel_admin/henkel_adm";
$route['henkel_adm/create_kd'] = "henkel_admin/henkel_adm/create_kd";
$route['henkel_adm/cari'] = "henkel_admin/henkel_adm/cari";
$route['henkel_adm/simpan'] = "henkel_admin/henkel_adm/simpan";
$route['henkel_adm/hapus/(:num)'] = "henkel_admin/henkel_adm/hapus";

/* Profil */
$route['henkel_adm_profil'] = "henkel_admin/henkel_adm_profil";
$route['henkel_adm_profil/simpan_profil'] = "henkel_admin/henkel_adm_profil/simpan_profil";
$route['henkel_adm_profil/simpan_foto'] = "henkel_admin/henkel_adm_profil/simpan_foto";
$route['henkel_adm_profil/simpan_pwd'] = "henkel_admin/henkel_adm_profil/simpan_pwd";
$route['henkel_adm_profil/simpan_open_username'] = "henkel_admin/henkel_adm_profil/simpan_open_username";

/* Master - Supplier */
$route['henkel_adm_supplier'] = "henkel_admin/henkel_adm_supplier";
$route['henkel_adm_supplier/cari'] = "henkel_admin/henkel_adm_supplier/cari";
$route['henkel_adm_supplier/simpan'] = "henkel_admin/henkel_adm_supplier/simpan";
$route['henkel_adm_supplier/hapus/(:num)'] = "henkel_admin/henkel_adm_supplier/hapus";

/* Master - Pelanggan */
$route['henkel_adm_pelanggan'] = "henkel_admin/henkel_adm_pelanggan";
$route['henkel_adm_pelanggan/cari'] = "henkel_admin/henkel_adm_pelanggan/cari";
$route['henkel_adm_pelanggan/simpan'] = "henkel_admin/henkel_adm_pelanggan/simpan";
$route['henkel_adm_pelanggan/hapus/(:num)'] = "henkel_admin/henkel_adm_pelanggan/hapus";

/* Master - Sales */
$route['henkel_adm_sales'] = "henkel_admin/henkel_adm_sales";
$route['henkel_adm_sales/cari'] = "henkel_admin/henkel_adm_sales/cari";
$route['henkel_adm_sales/simpan'] = "henkel_admin/henkel_adm_sales/simpan";
$route['henkel_adm_sales/hapus/(:num)'] = "henkel_admin/henkel_adm_sales/hapus";

/* Master - Satuan */
$route['henkel_adm_satuan'] = "henkel_admin/henkel_adm_satuan";
$route['henkel_adm_satuan/cari'] = "henkel_admin/henkel_adm_satuan/cari";
$route['henkel_adm_satuan/simpan'] = "henkel_admin/henkel_adm_satuan/simpan";
$route['henkel_adm_satuan/hapus/(:num)'] = "henkel_admin/henkel_adm_satuan/hapus";

/* Master - Satuan */
$route['henkel_adm_jenis_pembayaran'] = "henkel_admin/henkel_adm_jenis_pembayaran";
$route['henkel_adm_jenis_pembayaran/cari'] = "henkel_admin/henkel_adm_jenis_pembayaran/cari";
$route['henkel_adm_jenis_pembayaran/simpan'] = "henkel_admin/henkel_adm_jenis_pembayaran/simpan";
$route['henkel_adm_jenis_pembayaran/hapus/(:num)'] = "henkel_admin/henkel_adm_jenis_pembayaran/hapus";

/* Master - Bank */
$route['henkel_adm_bank'] = "henkel_admin/henkel_adm_bank";
$route['henkel_adm_bank/cari'] = "henkel_admin/henkel_adm_bank/cari";
$route['henkel_adm_bank/simpan'] = "henkel_admin/henkel_adm_bank/simpan";
$route['henkel_adm_bank/hapus/(:num)'] = "henkel_admin/henkel_adm_bank/hapus";

/* Master - Gudang */
$route['henkel_adm_gudang'] = "henkel_admin/henkel_adm_gudang";
$route['henkel_adm_gudang/cari'] = "henkel_admin/henkel_adm_gudang/cari";
$route['henkel_adm_gudang/simpan'] = "henkel_admin/henkel_adm_gudang/simpan";
$route['henkel_adm_gudang/hapus/(:num)'] = "henkel_admin/henkel_adm_gudang/hapus";

/* Master - E-Faktur*/
$route['henkel_adm_e_faktur'] = "henkel_admin/henkel_adm_e_faktur";
$route['henkel_adm_e_faktur/simpan'] = "henkel_admin/henkel_adm_e_faktur/simpan";
$route['henkel_adm_e_faktur/cari'] = "henkel_admin/henkel_adm_e_faktur/cari";
$route['henkel_adm_e_faktur/fetchdata'] = "henkel_admin/henkel_adm_e_faktur/fetchdata";
$route['henkel_adm_e_faktur/hapus/(:num)'] = "henkel_admin/henkel_adm_e_faktur/hapus";

/* For Search Item */
$route['henkel_adm_search/search_kd_item'] = "henkel_admin/henkel_adm_search/search_kd_item";
$route['henkel_adm_search/search_nm_item'] = "henkel_admin/henkel_adm_search/search_nm_item";
$route['henkel_adm_search/search_nonseparated_item'] = "henkel_admin/henkel_adm_search/search_nonseparated_item";
$route['henkel_adm_search/search_kd_pelanggan/(:any)'] = "henkel_admin/henkel_adm_search/search_kd_pelanggan";
$route['henkel_adm_search/search_nm_pelanggan/(:any)'] = "henkel_admin/henkel_adm_search/search_nm_pelanggan";
$route['henkel_adm_search/search_kd_sales/(:any)'] = "henkel_admin/henkel_adm_search/search_kd_sales";
$route['henkel_adm_search/search_nm_sales/(:any)'] = "henkel_admin/henkel_adm_search/search_nm_sales";
$route['henkel_adm_search/search_kd_supplier/(:any)'] = "henkel_admin/henkel_adm_search/search_kd_supplier";
$route['henkel_adm_search/search_nm_supplier/(:any)'] = "henkel_admin/henkel_adm_search/search_nm_supplier";
/* Pembelian - Biaya Angkut */
$route['henkel_adm_biaya_angkut'] = "henkel_admin/henkel_adm_biaya_angkut";
$route['henkel_adm_biaya_angkut/edit/(:num)'] = "henkel_admin/henkel_adm_biaya_angkut/edit";
$route['henkel_adm_biaya_angkut/simpan'] = "henkel_admin/henkel_adm_biaya_angkut/simpan";
$route['henkel_adm_biaya_angkut/baru'] = "henkel_admin/henkel_adm_biaya_angkut/baru";
$route['henkel_adm_biaya_angkut/t_simpan'] = "henkel_admin/henkel_adm_biaya_angkut/t_simpan";
$route['henkel_adm_biaya_angkut/hapus/(:num)'] = "henkel_admin/henkel_adm_biaya_angkut/hapus";
$route['henkel_adm_biaya_angkut/tambah'] = "henkel_admin/henkel_adm_biaya_angkut/tambah";
$route['henkel_adm_biaya_angkut/cetak'] = "henkel_admin/henkel_adm_biaya_angkut/cetak";
$route['henkel_adm_biaya_angkut/cek_table'] = "henkel_admin/henkel_adm_biaya_angkut/cek_table";

/* Pembelian - Pesanan Pembelian */
$route['henkel_adm_pesanan_pembelian'] = "henkel_admin/henkel_adm_pesanan_pembelian";
$route['henkel_adm_pesanan_pembelian/edit/(:num)'] = "henkel_admin/henkel_adm_pesanan_pembelian/edit";
$route['henkel_adm_pesanan_pembelian/simpan'] = "henkel_admin/henkel_adm_pesanan_pembelian/simpan";
$route['henkel_adm_pesanan_pembelian/baru'] = "henkel_admin/henkel_adm_pesanan_pembelian/baru";
$route['henkel_adm_pesanan_pembelian/t_simpan'] = "henkel_admin/henkel_adm_pesanan_pembelian/t_simpan";
$route['henkel_adm_pesanan_pembelian/hapus/(:num)'] = "henkel_admin/henkel_adm_pesanan_pembelian/hapus";
$route['henkel_adm_pesanan_pembelian/tambah'] = "henkel_admin/henkel_adm_pesanan_pembelian/tambah";
$route['henkel_adm_pesanan_pembelian/cetak'] = "henkel_admin/henkel_adm_pesanan_pembelian/cetak";
$route['henkel_adm_pesanan_pembelian/cek_table'] = "henkel_admin/henkel_adm_pesanan_pembelian/cek_table";
/* Pembelian - Invoice Supplier */
$route['henkel_adm_invoice_supplier'] = "henkel_admin/henkel_adm_invoice_supplier";
$route['henkel_adm_invoice_supplier/simpan_noinvoice'] = "henkel_admin/henkel_adm_invoice_supplier/simpan_noinvoice";
$route['henkel_adm_invoice_supplier/edit/(:any)'] = "henkel_admin/henkel_adm_invoice_supplier/edit";
/* Pembelian - Pesanan Pengiriman */
$route['henkel_adm_pesanan_pengiriman'] = "henkel_admin/henkel_adm_pesanan_pengiriman";
$route['henkel_adm_pesanan_pengiriman/edit/(:num)'] = "henkel_admin/henkel_adm_pesanan_pengiriman/edit";
$route['henkel_adm_pesanan_pengiriman/simpan'] = "henkel_admin/henkel_adm_pesanan_pengiriman/simpan";
$route['henkel_adm_pesanan_pengiriman/baru'] = "henkel_admin/henkel_adm_pesanan_pengiriman/baru";
$route['henkel_adm_pesanan_pengiriman/t_simpan'] = "henkel_admin/henkel_adm_pesanan_pengiriman/t_simpan";
$route['henkel_adm_pesanan_pengiriman/hapus/(:num)'] = "henkel_admin/henkel_adm_pesanan_pengiriman/hapus";
$route['henkel_adm_pesanan_pengiriman/tambah'] = "henkel_admin/henkel_adm_pesanan_pengiriman/tambah";
$route['henkel_adm_pesanan_pengiriman/cetak'] = "henkel_admin/henkel_adm_pesanan_pengiriman/cetak";
$route['henkel_adm_pesanan_pengiriman/cek_table'] = "henkel_admin/henkel_adm_pesanan_pengiriman/cek_table";
/* Pembelian - Pembelian */
$route['henkel_adm_pembelian'] = "henkel_admin/henkel_adm_pembelian";
$route['henkel_adm_pembelian/cari'] = "henkel_admin/henkel_adm_pembelian/cari";
$route['henkel_adm_pembelian/t_cari'] = "henkel_admin/henkel_adm_pembelian/t_cari";
$route['henkel_adm_pembelian/search_kd_supplier/(:any)'] = "henkel_admin/henkel_adm_pembelian/search_kd_supplier";
$route['henkel_adm_pembelian/search_nm_supplier/(:any)'] = "henkel_admin/henkel_adm_pembelian/search_nm_supplier";
$route['henkel_adm_pembelian/search_kd_item/(:any)'] = "henkel_admin/henkel_adm_pembelian/search_kd_item";
$route['henkel_adm_pembelian/simpan'] = "henkel_admin/henkel_adm_pembelian/simpan";
$route['henkel_adm_pembelian/hapus/(:num)'] = "henkel_admin/henkel_adm_pembelian/hapus";
$route['henkel_adm_pembelian/t_hapus/(:num)'] = "henkel_admin/henkel_adm_pembelian/t_hapus";
$route['henkel_adm_pembelian/t_simpan'] = "henkel_admin/henkel_adm_pembelian/t_simpan";
/* Pembelian - Pengiriman */
$route['henkel_adm_pengiriman'] = "henkel_admin/henkel_adm_pengiriman";
$route['henkel_adm_pengiriman/cari'] = "henkel_admin/henkel_adm_pengiriman/cari";
$route['henkel_adm_pengiriman/t_cari'] = "henkel_admin/henkel_adm_pengiriman/t_cari";
$route['henkel_adm_pengiriman/search_kd_supplier/(:any)'] = "henkel_admin/henkel_adm_pengiriman/search_kd_supplier";
$route['henkel_adm_pengiriman/search_nm_supplier/(:any)'] = "henkel_admin/henkel_adm_pengiriman/search_nm_supplier";
$route['henkel_adm_pengiriman/search_kd_item/(:any)'] = "henkel_admin/henkel_adm_pengiriman/search_kd_item";
$route['henkel_adm_pengiriman/simpan'] = "henkel_admin/henkel_adm_pengiriman/simpan";
$route['henkel_adm_pengiriman/hapus/(:num)'] = "henkel_admin/henkel_adm_pengiriman/hapus";
$route['henkel_adm_pengiriman/t_hapus/(:num)'] = "henkel_admin/henkel_adm_pengiriman/t_hapus";
$route['henkel_adm_pengiriman/t_simpan'] = "henkel_admin/henkel_adm_pengiriman/t_simpan";
/* Pembelian - Pembayaran Hutang */
$route['henkel_adm_pembayaran_hutang'] = "henkel_admin/henkel_adm_pembayaran_hutang";
$route['henkel_adm_pembayaran_hutang/tambah'] = "henkel_admin/henkel_adm_pembayaran_hutang/tambah";
$route['henkel_adm_pembayaran_hutang/baru'] = "henkel_admin/henkel_adm_pembayaran_hutang/baru";
$route['henkel_adm_pembayaran_hutang/cek'] = "henkel_admin/henkel_adm_pembayaran_hutang/cek";
$route['henkel_adm_pembayaran_hutang/cek_table'] = "henkel_admin/henkel_adm_pembayaran_hutang/cek_table";
$route['henkel_adm_pembayaran_hutang/t_simpan'] = "henkel_admin/henkel_adm_pembayaran_hutang/t_simpan";
$route['henkel_adm_pembayaran_hutang/edit/(:num)'] = "henkel_admin/henkel_adm_pembayaran_hutang/edit";
$route['henkel_adm_pembayaran_hutang/simpan'] = "henkel_admin/henkel_adm_pembayaran_hutang/simpan";
$route['henkel_adm_pembayaran_hutang/hapus/(:num)'] = "henkel_admin/henkel_adm_pembayaran_hutang/hapus";
$route['henkel_adm_pembayaran_hutang/cetak'] = "henkel_admin/henkel_adm_pembayaran_hutang/cetak";
$route['henkel_adm_pembayaran_hutang/cetak_permintaan_pembayaran'] = "henkel_admin/henkel_adm_pembayaran_hutang/cetak_permintaan_pembayaran";
/* Pembelian - Hutang */
$route['henkel_adm_hutang'] = "henkel_admin/henkel_adm_hutang";
$route['henkel_adm_hutang/cari'] = "henkel_admin/henkel_adm_hutang/cari";
$route['henkel_adm_hutang/t_cari'] = "henkel_admin/henkel_adm_hutang/t_cari";
$route['henkel_adm_hutang/simpan'] = "henkel_admin/henkel_adm_hutang/simpan";
$route['henkel_adm_hutang/hapus/(:num)'] = "henkel_admin/henkel_adm_hutang/hapus";
$route['henkel_adm_hutang/t_simpan'] = "henkel_admin/henkel_adm_hutang/t_simpan";
$route['henkel_adm_hutang/t_hapus/(:num)'] = "henkel_admin/henkel_adm_hutang/t_hapus";

$route['henkel_adm_r_pembelian'] = "henkel_admin/henkel_adm_r_pembelian";
$route['henkel_adm_r_pembelian/cari'] = "henkel_admin/henkel_adm_r_pembelian/cari";
$route['henkel_adm_r_pembelian/t_cari'] = "henkel_admin/henkel_adm_r_pembelian/t_cari";
$route['henkel_adm_r_pembelian/simpan'] = "henkel_admin/henkel_adm_r_pembelian/simpan";
$route['henkel_adm_r_pembelian/hapus/(:num)'] = "henkel_admin/henkel_adm_r_pembelian/hapus";
$route['henkel_adm_r_pembelian/t_simpan'] = "henkel_admin/henkel_adm_r_pembelian/t_simpan";
$route['henkel_adm_r_pembelian/t_hapus/(:num)'] = "henkel_admin/henkel_adm_r_pembelian/t_hapus";

/* Pembelian - Retur Pembelian */
$route['henkel_adm_retur_pembelian'] = "henkel_admin/henkel_adm_retur_pembelian";
$route['henkel_adm_retur_pembelian/tambah'] = "henkel_admin/henkel_adm_retur_pembelian/tambah";
$route['henkel_adm_retur_pembelian/cek'] = "henkel_admin/henkel_adm_retur_pembelian/cek";
$route['henkel_adm_retur_pembelian/get_total_transaksi'] = "henkel_admin/henkel_adm_retur_pembelian/get_total_transaksi";
$route['henkel_adm_retur_pembelian/cek_table'] = "henkel_admin/henkel_adm_retur_pembelian/cek_table";
$route['henkel_adm_retur_pembelian/baru'] = "henkel_admin/henkel_adm_retur_pembelian/baru";
$route['henkel_adm_retur_pembelian/show'] = "henkel_admin/henkel_adm_retur_pembelian/show";
$route['henkel_adm_retur_pembelian/edit/(:num)'] = "henkel_admin/henkel_adm_retur_pembelian/edit";
$route['henkel_adm_retur_pembelian/simpan'] = "henkel_admin/henkel_adm_retur_pembelian/simpan";
$route['henkel_adm_retur_pembelian/t_simpan'] = "henkel_admin/henkel_adm_retur_pembelian/t_simpan";
$route['henkel_adm_retur_pembelian/hapus/(:num)'] = "henkel_admin/henkel_adm_retur_pembelian/hapus";
$route['henkel_adm_retur_pembelian/cetak'] = "henkel_admin/henkel_adm_retur_pembelian/cetak";
$route['henkel_adm_retur_pembelian/cetak_sj'] = "henkel_admin/henkel_adm_retur_pembelian/cetak_sj";

/* Penjualan - Penjualan */
$route['henkel_adm_penjualan'] = "henkel_admin/henkel_adm_penjualan";
$route['henkel_adm_penjualan/cari'] = "henkel_admin/henkel_adm_penjualan/cari";
$route['henkel_adm_penjualan/t_cari'] = "henkel_admin/henkel_adm_penjualan/t_cari";
$route['henkel_adm_penjualan/simpan'] = "henkel_admin/henkel_adm_penjualan/simpan";
$route['henkel_adm_penjualan/hapus/(:num)'] = "henkel_admin/henkel_adm_penjualan/hapus";
$route['henkel_adm_penjualan/t_simpan'] = "henkel_admin/henkel_adm_penjualan/t_simpan";
$route['henkel_adm_penjualan/t_hapus/(:num)'] = "henkel_admin/henkel_adm_penjualan/t_hapus";

/* Penjualan - Pesanan Penjualan */
$route['henkel_adm_pesanan_penjualan'] = "henkel_admin/henkel_adm_pesanan_penjualan";
$route['henkel_adm_pesanan_penjualan/tambah'] = "henkel_admin/henkel_adm_pesanan_penjualan/tambah";
$route['henkel_adm_pesanan_penjualan/cek_table'] = "henkel_admin/henkel_adm_pesanan_penjualan/cek_table";
$route['henkel_adm_pesanan_penjualan/baru'] = "henkel_admin/henkel_adm_pesanan_penjualan/baru";
$route['henkel_adm_pesanan_penjualan/edit/(:num)'] = "henkel_admin/henkel_adm_pesanan_penjualan/edit";
$route['henkel_adm_pesanan_penjualan/simpan'] = "henkel_admin/henkel_adm_pesanan_penjualan/simpan";
$route['henkel_adm_pesanan_penjualan/t_simpan'] = "henkel_admin/henkel_adm_pesanan_penjualan/t_simpan";
$route['henkel_adm_pesanan_penjualan/hapus/(:num)'] = "henkel_admin/henkel_adm_pesanan_penjualan/hapus";
$route['henkel_adm_pesanan_penjualan/cetak'] = "henkel_admin/henkel_adm_pesanan_penjualan/cetak";
$route['henkel_adm_pesanan_penjualan/cetak_sj'] = "henkel_admin/henkel_adm_pesanan_penjualan/cetak_sj";
$route['henkel_adm_pesanan_penjualan/reset'] = "henkel_admin/henkel_adm_pesanan_penjualan/reset";

/* Penjualan - Pembayaran Piutang */
$route['henkel_adm_pembayaran_piutang'] = "henkel_admin/henkel_adm_pembayaran_piutang";
$route['henkel_adm_pembayaran_piutang/tambah'] = "henkel_admin/henkel_adm_pembayaran_piutang/tambah";
$route['henkel_adm_pembayaran_piutang/cek_table'] = "henkel_admin/henkel_adm_pembayaran_piutang/cek_table";
$route['henkel_adm_pembayaran_piutang/cek_bayar'] = "henkel_admin/henkel_adm_pembayaran_piutang/cek_bayar";
$route['henkel_adm_pembayaran_piutang/baru'] = "henkel_admin/henkel_adm_pembayaran_piutang/baru";
$route['henkel_adm_pembayaran_piutang/cek'] = "henkel_admin/henkel_adm_pembayaran_piutang/cek";
$route['henkel_adm_pembayaran_piutang/edit/(:num)'] = "henkel_admin/henkel_adm_pembayaran_piutang/edit";
$route['henkel_adm_pembayaran_piutang/simpan'] = "henkel_admin/henkel_adm_pembayaran_piutang/simpan";
$route['henkel_adm_pembayaran_piutang/t_simpan'] = "henkel_admin/henkel_adm_pembayaran_piutang/t_simpan";
$route['henkel_adm_pembayaran_piutang/hapus/(:num)'] = "henkel_admin/henkel_adm_pembayaran_piutang/hapus";
$route['henkel_adm_pembayaran_piutang/cetak'] = "henkel_admin/henkel_adm_pembayaran_piutang/cetak";
$route['henkel_adm_pembayaran_piutang/cetak_sj'] = "henkel_admin/henkel_adm_pembayaran_piutang/cetak_sj";

/* Penjualan - Piutang */
$route['henkel_adm_piutang'] = "henkel_admin/henkel_adm_piutang";
$route['henkel_adm_piutang/cari'] = "henkel_admin/henkel_adm_piutang/cari";
$route['henkel_adm_piutang/cari_exception'] = "henkel_admin/henkel_adm_piutang/cari_exception";
$route['henkel_adm_piutang/t_cari'] = "henkel_admin/henkel_adm_piutang/t_cari";
$route['henkel_adm_piutang/t_cari_exception'] = "henkel_admin/henkel_adm_piutang/t_cari_exception";
$route['henkel_adm_piutang/simpan'] = "henkel_admin/henkel_adm_piutang/simpan";
$route['henkel_adm_piutang/simpan_exception'] = "henkel_admin/henkel_adm_piutang/simpan_exception";
$route['henkel_adm_piutang/hapus/(:num)'] = "henkel_admin/henkel_adm_piutang/hapus";
$route['henkel_adm_piutang/t_simpan'] = "henkel_admin/henkel_adm_piutang/t_simpan";
$route['henkel_adm_piutang/t_hapus/(:num)'] = "henkel_admin/henkel_adm_piutang/t_hapus";

$route['henkel_adm_konfirmasi_cekbg'] = "henkel_admin/henkel_adm_konfirmasi_cekbg";

$route['henkel_adm_r_penjualan'] = "henkel_admin/henkel_adm_r_penjualan";
$route['henkel_adm_r_penjualan/cari'] = "henkel_admin/henkel_adm_r_penjualan/cari";
$route['henkel_adm_r_penjualan/t_cari'] = "henkel_admin/henkel_adm_r_penjualan/t_cari";
$route['henkel_adm_r_penjualan/simpan'] = "henkel_admin/henkel_adm_r_penjualan/simpan";
$route['henkel_adm_r_penjualan/hapus/(:num)'] = "henkel_admin/henkel_adm_r_penjualan/hapus";
$route['henkel_adm_r_penjualan/t_simpan'] = "henkel_admin/henkel_adm_r_penjualan/t_simpan";
$route['henkel_adm_r_penjualan/t_hapus/(:num)'] = "henkel_admin/henkel_adm_r_penjualan/t_hapus";

/* Penjualan - Pesanan Penjualan */
$route['henkel_adm_retur_penjualan'] = "henkel_admin/henkel_adm_retur_penjualan";
$route['henkel_adm_retur_penjualan/tambah'] = "henkel_admin/henkel_adm_retur_penjualan/tambah";
$route['henkel_adm_retur_penjualan/cek'] = "henkel_admin/henkel_adm_retur_penjualan/cek";
$route['henkel_adm_retur_penjualan/get_total_transaksi'] = "henkel_admin/henkel_adm_retur_penjualan/get_total_transaksi";
$route['henkel_adm_retur_penjualan/cek_table'] = "henkel_admin/henkel_adm_retur_penjualan/cek_table";
$route['henkel_adm_retur_penjualan/baru'] = "henkel_admin/henkel_adm_retur_penjualan/baru";
$route['henkel_adm_retur_penjualan/show'] = "henkel_admin/henkel_adm_retur_penjualan/show";
$route['henkel_adm_retur_penjualan/edit/(:num)'] = "henkel_admin/henkel_adm_retur_penjualan/edit";
$route['henkel_adm_retur_penjualan/simpan'] = "henkel_admin/henkel_adm_retur_penjualan/simpan";
$route['henkel_adm_retur_penjualan/t_simpan'] = "henkel_admin/henkel_adm_retur_penjualan/t_simpan";
$route['henkel_adm_retur_penjualan/hapus/(:num)'] = "henkel_admin/henkel_adm_retur_penjualan/hapus";
$route['henkel_adm_retur_penjualan/cetak'] = "henkel_admin/henkel_adm_retur_penjualan/cetak";
$route['henkel_adm_retur_penjualan/cetak_sj'] = "henkel_admin/henkel_adm_retur_penjualan/cetak_sj";

/* Penjualan - Target Penjualan*/
$route['henkel_adm_target_penjualan'] = "henkel_admin/henkel_adm_target_penjualan";
$route['henkel_adm_target_penjualan/simpan'] = "henkel_admin/henkel_adm_target_penjualan/simpan";
$route['henkel_adm_target_penjualan/cek_table'] = "henkel_admin/henkel_adm_target_penjualan/cek_table";
$route['henkel_adm_target_penjualan/simpan_detail'] = "henkel_admin/henkel_adm_target_penjualan/simpan_detail";
$route['henkel_adm_target_penjualan/hapus_detail/(:num)'] = "henkel_admin/henkel_adm_target_penjualan/hapus_detail";
$route['henkel_adm_target_penjualan/cari_detail'] = "henkel_admin/henkel_adm_target_penjualan/cari_detail";

/* Penjualan - Hitungan Komisi*/
$route['henkel_adm_hitungan_komisi'] = "henkel_admin/henkel_adm_hitungan_komisi";
$route['henkel_adm_hitungan_komisi/cari'] = "henkel_admin/henkel_adm_hitungan_komisi/cari";
$route['henkel_adm_hitungan_komisi/simpan'] = "henkel_admin/henkel_adm_hitungan_komisi/simpan";
$route['henkel_adm_hitungan_komisi/simpan_edit'] = "henkel_admin/henkel_adm_hitungan_komisi/simpan_edit";
$route['henkel_adm_hitungan_komisi/edit/(:num)'] = "henkel_admin/henkel_adm_hitungan_komisi/edit";
$route['henkel_adm_hitungan_komisi/cari_data'] = "henkel_admin/henkel_adm_hitungan_komisi/cari_data";
$route['henkel_adm_hitungan_komisi/cek_table'] = "henkel_admin/henkel_adm_hitungan_komisi/cek_table";
$route['henkel_adm_hitungan_komisi/cek_table_edit'] = "henkel_admin/henkel_adm_hitungan_komisi/cek_table_edit";
$route['henkel_adm_hitungan_komisi/cetak_pdf_penjualan'] = "henkel_admin/henkel_adm_hitungan_komisi/cetak_pdf_penjualan";
$route['henkel_adm_hitungan_komisi/tambah'] = "henkel_admin/henkel_adm_hitungan_komisi/tambah";
$route['henkel_adm_hitungan_komisi/hapus_admin/(:num)'] = "henkel_admin/henkel_adm_hitungan_komisi/hapus_admin";
$route['henkel_adm_hitungan_komisi/cari_sales'] = "henkel_admin/henkel_adm_hitungan_komisi/cari_sales";
$route['henkel_adm_hitungan_komisi/hapus_sales/(:num)'] = "henkel_admin/henkel_adm_hitungan_komisi/hapus_sales";
$route['henkel_adm_hitungan_komisi/t_simpan_sales'] = "henkel_admin/henkel_adm_hitungan_komisi/t_simpan_sales";
$route['henkel_adm_hitungan_komisi/t_cari_sales'] = "henkel_admin/henkel_adm_hitungan_komisi/t_cari_sales";
$route['henkel_adm_hitungan_komisi/t_hapus_sales/(:num)'] = "henkel_admin/henkel_adm_hitungan_komisi/t_hapus_sales";
$route['henkel_adm_hitungan_komisi/t_simpan_admin'] = "henkel_admin/henkel_adm_hitungan_komisi/t_simpan_admin";
$route['henkel_adm_hitungan_komisi/t_cari_admin'] = "henkel_admin/henkel_adm_hitungan_komisi/t_cari_admin";
$route['henkel_adm_hitungan_komisi/t_hapus_admin/(:num)'] = "henkel_admin/henkel_adm_hitungan_komisi/t_hapus_admin";
$route['henkel_adm_hitungan_komisi/t_simpan_spv'] = "henkel_admin/henkel_adm_hitungan_komisi/t_simpan_spv";
$route['henkel_adm_hitungan_komisi/t_cari_spv'] = "henkel_admin/henkel_adm_hitungan_komisi/t_cari_spv";
$route['henkel_adm_hitungan_komisi/t_hapus_spv/(:num)'] = "henkel_admin/henkel_adm_hitungan_komisi/t_hapus_spv";
$route['henkel_adm_hitungan_komisi/cetak_excel_penjualan'] = "henkel_admin/henkel_adm_hitungan_komisi/cetak_excel_penjualan";

/* Penjualan - Penerima Komisi*/
$route['henkel_adm_penerima_komisi'] = "henkel_admin/henkel_adm_penerima_komisi";
$route['henkel_adm_penerima_komisi/cari'] = "henkel_admin/henkel_adm_penerima_komisi/cari";
$route['henkel_adm_penerima_komisi/cari_info_piutang_exception'] = "henkel_admin/henkel_adm_penerima_komisi/cari_info_piutang_exception";
$route['henkel_adm_penerima_komisi/proses_sales'] = "henkel_admin/henkel_adm_penerima_komisi/proses_sales";
$route['henkel_adm_penerima_komisi/proses_admin'] = "henkel_admin/henkel_adm_penerima_komisi/proses_admin";
$route['henkel_adm_penerima_komisi/proses_kolektor'] = "henkel_admin/henkel_adm_penerima_komisi/proses_kolektor";
$route['henkel_adm_penerima_komisi/cari_data'] = "henkel_admin/henkel_adm_penerima_komisi/cari_data";
$route['henkel_adm_penerima_komisi/cetak_pdf_penjualan'] = "henkel_admin/henkel_adm_penerima_komisi/cetak_pdf_penjualan";
$route['henkel_adm_penerima_komisi/tambah'] = "henkel_admin/henkel_adm_penerima_komisi/tambah";
$route['henkel_adm_penerima_komisi/komisi_sales'] = "henkel_admin/henkel_adm_penerima_komisi/komisi_sales";
$route['henkel_adm_penerima_komisi/komisi_admin'] = "henkel_admin/henkel_adm_penerima_komisi/komisi_admin";
$route['henkel_adm_penerima_komisi/komisi_kolektor'] = "henkel_admin/henkel_adm_penerima_komisi/komisi_kolektor";
$route['henkel_adm_penerima_komisi/t_simpan_status_komisi'] = "henkel_admin/henkel_adm_penerima_komisi/t_simpan_status_komisi";
$route['henkel_adm_penerima_komisi/t_simpan_penerima_komisi_sales_detail'] = "henkel_admin/henkel_adm_penerima_komisi/t_simpan_penerima_komisi_sales_detail";
$route['henkel_adm_penerima_komisi/t_simpan_penerima_komisi_admin_detail'] = "henkel_admin/henkel_adm_penerima_komisi/t_simpan_penerima_komisi_admin_detail";
$route['henkel_adm_penerima_komisi/t_simpan_penerima_komisi_kolektor_detail'] = "henkel_admin/henkel_adm_penerima_komisi/t_simpan_penerima_komisi_kolektor_detail";
$route['henkel_adm_penerima_komisi/t_simpan_komisi_sales'] = "henkel_admin/henkel_adm_penerima_komisi/t_simpan_komisi_sales";
$route['henkel_adm_penerima_komisi/t_cari_status_komisi'] = "henkel_admin/henkel_adm_penerima_komisi/t_cari_status_komisi";
$route['henkel_adm_penerima_komisi/t_cari_penerima_komisi_sales_detail'] = "henkel_admin/henkel_adm_penerima_komisi/t_cari_penerima_komisi_sales_detail";
$route['henkel_adm_penerima_komisi/t_cari_penerima_komisi_admin_detail'] = "henkel_admin/henkel_adm_penerima_komisi/t_cari_penerima_komisi_admin_detail";
$route['henkel_adm_penerima_komisi/t_cari_penerima_komisi_kolektor_detail'] = "henkel_admin/henkel_adm_penerima_komisi/t_cari_penerima_komisi_kolektor_detail";
$route['henkel_adm_penerima_komisi/simpan_penerima_komisi'] = "henkel_admin/henkel_adm_penerima_komisi/simpan_penerima_komisi";
$route['henkel_adm_penerima_komisi/simpan_penerima_komisi_sales_detail'] = "henkel_admin/henkel_adm_penerima_komisi/simpan_penerima_komisi_sales_detail";
$route['henkel_adm_penerima_komisi/simpan_penerima_komisi_admin_detail'] = "henkel_admin/henkel_adm_penerima_komisi/simpan_penerima_komisi_admin_detail";
$route['henkel_adm_penerima_komisi/simpan_penerima_komisi_kolektor_detail'] = "henkel_admin/henkel_adm_penerima_komisi/simpan_penerima_komisi_kolektor_detail";
$route['henkel_adm_penerima_komisi/simpan_info_piutang_exception'] = "henkel_admin/henkel_adm_penerima_komisi/simpan_info_piutang_exception";
$route['henkel_adm_penerima_komisi/hitung_insentif_sales/(:num)'] = "henkel_admin/henkel_adm_penerima_komisi/hitung_insentif_sales";
$route['henkel_adm_penerima_komisi/hitung_insentif_admin/(:num)'] = "henkel_admin/henkel_adm_penerima_komisi/hitung_insentif_admin";
$route['henkel_adm_penerima_komisi/hitung_insentif_kolektor/(:num)'] = "henkel_admin/henkel_adm_penerima_komisi/hitung_insentif_kolektor";
$route['henkel_adm_penerima_komisi/cetak_excel_penjualan'] = "henkel_admin/henkel_adm_penerima_komisi/cetak_excel_penjualan";

/* Persediaan - Item Masuk */
$route['henkel_adm_item_masuk'] = "henkel_admin/henkel_adm_item_masuk";
$route['henkel_adm_item_masuk/search_no_po/(:any)'] = "henkel_admin/henkel_adm_item_masuk/search_no_po";
$route['henkel_adm_item_masuk/baru'] = "henkel_admin/henkel_adm_item_masuk/baru";
$route['henkel_adm_item_masuk/search_nm_gudang'] = "henkel_admin/henkel_adm_item_masuk/search_nm_gudang";
$route['henkel_adm_item_masuk/search_nm_item'] = "henkel_admin/henkel_adm_item_masuk/search_nm_item";
$route['henkel_adm_item_masuk/search_kd_item'] = "henkel_admin/henkel_adm_item_masuk/search_kd_item";
$route['henkel_adm_item_masuk/view_no_po'] = "henkel_admin/henkel_adm_item_masuk/view_no_po";
$route['henkel_adm_item_masuk/simpan'] = "henkel_admin/henkel_adm_item_masuk/simpan";
$route['henkel_adm_item_masuk/simpan_edit'] = "henkel_admin/henkel_adm_item_masuk/simpan_edit";
$route['henkel_adm_item_masuk/t_simpan'] = "henkel_admin/henkel_adm_item_masuk/t_simpan";
$route['henkel_adm_item_masuk/tambah'] = "henkel_admin/henkel_adm_item_masuk/tambah";
$route['henkel_adm_item_masuk/tambah_invoice/(:any)'] = "henkel_admin/henkel_adm_item_masuk/tambah_invoice";
$route['henkel_adm_item_masuk/edit/(:num)'] = "henkel_admin/henkel_adm_item_masuk/edit";
$route['henkel_adm_item_masuk/cari'] = "henkel_admin/henkel_adm_item_masuk/cari";
$route['henkel_adm_item_masuk/t_cari'] = "henkel_admin/henkel_adm_item_masuk/t_cari";
$route['henkel_adm_item_masuk/cek'] = "henkel_admin/henkel_adm_item_masuk/cek";
$route['henkel_adm_item_masuk/cek_table'] = "henkel_admin/henkel_adm_item_masuk/cek_table";
$route['henkel_adm_item_masuk/hapus/(:num)'] = "henkel_admin/henkel_adm_item_masuk/hapus";
$route['henkel_adm_item_masuk/t_hapus/(:num)'] = "henkel_admin/henkel_adm_item_masuk/t_hapus";

/* Persediaan - Item Keluar */
$route['henkel_adm_item_keluar'] = "henkel_admin/henkel_adm_item_keluar";
$route['henkel_adm_item_keluar/simpan'] = "henkel_admin/henkel_adm_item_keluar/simpan";
$route['henkel_adm_item_keluar/hapus/(:num)'] = "henkel_admin/henkel_adm_item_keluar/hapus";
$route['henkel_adm_item_keluar/berita_acara'] = "henkel_admin/henkel_adm_item_keluar/berita_acara";
$route['henkel_adm_item_keluar/cari'] = "henkel_admin/henkel_adm_item_keluar/cari";
$route['henkel_adm_item_keluar/cari_berita_acara'] = "henkel_admin/henkel_adm_item_keluar/cari_berita_acara";
$route['henkel_adm_item_keluar/search_stok_item'] = "henkel_admin/henkel_adm_item_keluar/search_stok_item";

/* Persediaan - Item Masuk Non*/
$route['henkel_adm_item_masuk_non'] = "henkel_admin/henkel_adm_item_masuk_non";
$route['henkel_adm_item_masuk_non/simpan'] = "henkel_admin/henkel_adm_item_masuk_non/simpan";
$route['henkel_adm_item_masuk_non/hapus/(:num)'] = "henkel_admin/henkel_adm_item_masuk_non/hapus";
$route['henkel_adm_item_masuk_non/berita_acara'] = "henkel_admin/henkel_adm_item_masuk_non/berita_acara";
$route['henkel_adm_item_masuk_non/cari'] = "henkel_admin/henkel_adm_item_masuk_non/cari";
$route['henkel_adm_item_masuk_non/cari_berita_acara'] = "henkel_admin/henkel_adm_item_masuk_non/cari_berita_acara";
$route['henkel_adm_item_masuk_non/search_stok_item'] = "henkel_admin/henkel_adm_item_masuk_non/search_stok_item";

/* Persediaan - Stok Awal Item */
$route['henkel_adm_stok_awal_item'] = "henkel_admin/henkel_adm_stok_awal_item";
$route['henkel_adm_stok_awal_item/simpan'] = "henkel_admin/henkel_adm_stok_awal_item/simpan";
$route['henkel_adm_stok_awal_item/cetak'] = "henkel_admin/henkel_adm_stok_awal_item/cetak";
$route['henkel_adm_stok_awal_item/cari'] = "henkel_admin/henkel_adm_stok_awal_item/cari";
$route['henkel_adm_stok_awal_item/cari_data'] = "henkel_admin/henkel_adm_stok_awal_item/cari_data";
$route['henkel_adm_stok_awal_item/hapus/(:num)'] = "henkel_admin/henkel_adm_stok_awal_item/hapus";
$route['henkel_adm_stok_awal_item/search_kd_item/(:any)'] = "henkel_admin/henkel_adm_stok_awal_item/search_kd_item";
$route['henkel_adm_stok_awal_item/cetak_pdf'] = "henkel_admin/henkel_adm_stok_awal_item/cetak_pdf";
$route['henkel_adm_stok_awal_item/cetak_excel'] = "henkel_admin/henkel_adm_stok_awal_item/cetak_excel";

/* Persediaan - Stok Item */
$route['henkel_adm_stok_item'] = "henkel_admin/henkel_adm_stok_item";
$route['henkel_adm_stok_item/cetak_kartu_stok'] = "henkel_admin/henkel_adm_stok_item/cetak_kartu_stok";
$route['henkel_adm_stok_item/cetak_kartu_stok_index'] = "henkel_admin/henkel_adm_stok_item/cetak_kartu_stok_index";
$route['henkel_adm_stok_item/cetak_data_stok'] = "henkel_admin/henkel_adm_stok_item/cetak_data_stok";
$route['henkel_adm_stok_item/cari_data'] = "henkel_admin/henkel_adm_stok_item/cari_data";
$route['henkel_adm_stok_item/cetak_pdf'] = "henkel_admin/henkel_adm_stok_item/cetak_pdf";

/* Persediaan - Mutasi Item */
$route['henkel_adm_mutasi_item'] = "henkel_admin/henkel_adm_mutasi_item";
$route['henkel_adm_mutasi_item/search_kd_item'] = "henkel_admin/henkel_adm_mutasi_item/search_kd_item";
$route['henkel_adm_mutasi_item/search_nm_item'] = "henkel_admin/henkel_adm_mutasi_item/search_nm_item";
$route['henkel_adm_mutasi_item/search_stok_item'] = "henkel_admin/henkel_adm_mutasi_item/search_stok_item";
$route['henkel_adm_mutasi_item/simpan'] = "henkel_admin/henkel_adm_mutasi_item/simpan";
$route['henkel_adm_mutasi_item/cari'] = "henkel_admin/henkel_adm_mutasi_item/cari";
$route['henkel_adm_mutasi_item/hapus/(:num)'] = "henkel_admin/henkel_adm_mutasi_item/hapus";

/* Persediaan - Stock Opname */
$route['henkel_adm_stok_opname'] = "henkel_admin/henkel_adm_stok_opname";
$route['henkel_adm_stok_opname/simpan'] = "henkel_admin/henkel_adm_stok_opname/simpan";
$route['henkel_adm_stok_opname/tambah'] = "henkel_admin/henkel_adm_stok_opname/tambah";
$route['henkel_adm_stok_opname/cari'] = "henkel_admin/henkel_adm_stok_opname/cari";
$route['henkel_adm_stok_opname/cari_stok_opname_detail'] = "henkel_admin/henkel_adm_stok_opname/cari_stok_opname_detail";
$route['henkel_adm_stok_opname/lihat_data'] = "henkel_admin/henkel_adm_stok_opname/lihat_data";
$route['henkel_adm_stok_opname/simpan'] = "henkel_admin/henkel_adm_stok_opname/simpan";
$route['henkel_adm_stok_opname/tunda'] = "henkel_admin/henkel_adm_stok_opname/tunda";
$route['henkel_adm_stok_opname/edit_tunda/(:num)'] = "henkel_admin/henkel_adm_stok_opname/edit_tunda";
$route['henkel_adm_stok_opname/cek_table'] = "henkel_admin/henkel_adm_stok_opname/cek_table";
$route['henkel_adm_stok_opname/t_simpan'] = "henkel_admin/henkel_adm_stok_opname/t_simpan";
$route['henkel_adm_stok_opname/t_cari'] = "henkel_admin/henkel_adm_stok_opname/t_cari";
$route['henkel_adm_stok_opname/t_cari_add'] = "henkel_admin/henkel_adm_stok_opname/t_cari_add";
$route['henkel_adm_stok_opname/t_cari_inserted'] = "henkel_admin/henkel_adm_stok_opname/t_cari_inserted";
$route['henkel_adm_stok_opname/cek'] = "henkel_admin/henkel_adm_stok_opname/cek";
$route['henkel_adm_stok_opname/cari_pdf'] = "henkel_admin/henkel_adm_stok_opname/cari_pdf";
$route['henkel_adm_stok_opname/cetak_pdf'] = "henkel_admin/henkel_adm_stok_opname/cetak_pdf";
$route['henkel_adm_stok_opname/cari_excel'] = "henkel_admin/henkel_adm_stok_opname/cari_excel";
$route['henkel_adm_stok_opname/cetak_excel'] = "henkel_admin/henkel_adm_stok_opname/cetak_excel";
$route['henkel_adm_stok_opname/edit/(:num)'] = "henkel_admin/henkel_adm_stok_opname/edit";

/* Akuntansi - Master Akun */
$route['henkel_adm_master_akun'] = "henkel_admin/henkel_adm_master_akun";
$route['henkel_adm_master_akun/search_parent'] = "henkel_admin/henkel_adm_master_akun/search_parent";
$route['henkel_adm_master_akun/max_kode_akun'] = "henkel_admin/henkel_adm_master_akun/max_kode_akun";
$route['henkel_adm_master_akun/max_kode_akun_parent'] = "henkel_admin/henkel_adm_master_akun/max_kode_akun_parent";
$route['henkel_adm_master_akun/simpan'] = "henkel_admin/henkel_adm_master_akun/simpan";
$route['henkel_adm_master_akun/cari'] = "henkel_admin/henkel_adm_master_akun/cari";
$route['henkel_adm_master_akun/hapus/(:num)'] = "henkel_admin/henkel_adm_master_akun/hapus";

/* Akuntansi - Setting Akun - Data Item */
$route['henkel_adm_setakun_dataitem'] = "henkel_admin/henkel_adm_setakun_dataitem";

/* Akuntansi - Setting Akun - Pembelian */
$route['henkel_adm_setakun_pembelian'] = "henkel_admin/henkel_adm_setakun_pembelian";

/* Akuntansi - Setting Akun - Penjualan */
$route['henkel_adm_setakun_penjualan'] = "henkel_admin/henkel_adm_setakun_penjualan";

/* Akuntansi - Setting Akun - Hutang Piutang */
$route['henkel_adm_setakun_hutangpiutang'] = "henkel_admin/henkel_adm_setakun_hutangpiutang";

/* Akuntansi - Saldo Awa; */
$route['henkel_adm_saldo_awal_hutang'] = "henkel_admin/henkel_adm_saldo_awal_hutang";
$route['henkel_adm_saldo_awal_hutang/edit/(:num)'] = "henkel_admin/henkel_adm_saldo_awal_hutang/edit";
$route['henkel_adm_saldo_awal_hutang/simpan'] = "henkel_admin/henkel_adm_saldo_awal_hutang/simpan";
$route['henkel_adm_saldo_awal_hutang/t_simpan'] = "henkel_admin/henkel_adm_saldo_awal_hutang/t_simpan";
$route['henkel_adm_saldo_awal_hutang/baru'] = "henkel_admin/henkel_adm_saldo_awal_hutang/baru";
$route['henkel_adm_saldo_awal_hutang/t_simpan_detail'] = "henkel_admin/henkel_adm_saldo_awal_hutang/t_simpan_detail";
$route['henkel_adm_saldo_awal_hutang/t_cari'] = "henkel_admin/henkel_adm_saldo_awal_hutang/t_cari";
$route['henkel_adm_saldo_awal_hutang/t_detail'] = "henkel_admin/henkel_adm_saldo_awal_hutang/t_detail";
$route['henkel_adm_saldo_awal_hutang/t_hapus/(:num)'] = "henkel_admin/henkel_adm_saldo_awal_hutang/t_hapus";
$route['henkel_adm_saldo_awal_hutang/tambah'] = "henkel_admin/henkel_adm_saldo_awal_hutang/tambah";
$route['henkel_adm_saldo_awal_hutang/cetak'] = "henkel_admin/henkel_adm_saldo_awal_hutang/cetak";
$route['henkel_adm_saldo_awal_hutang/cek_table'] = "henkel_admin/henkel_adm_saldo_awal_hutang/cek_table";

/* Akuntansi - Saldo Awal Perkiraan */
$route['henkel_adm_saldo_awal_perkiraan'] = "henkel_admin/henkel_adm_saldo_awal_perkiraan";
$route['henkel_adm_saldo_awal_perkiraan/simpan'] = "henkel_admin/henkel_adm_saldo_awal_perkiraan/simpan";
$route['henkel_adm_saldo_awal_perkiraan/cari'] = "henkel_admin/henkel_adm_saldo_awal_perkiraan/cari";
$route['henkel_adm_saldo_awal_perkiraan/hapus/(:num)'] = "henkel_admin/henkel_adm_saldo_awal_perkiraan/hapus";

/* Akuntansi - Jenis Akun */
$route['henkel_adm_p_akun_group'] = "henkel_admin/henkel_adm_p_akun_group";
$route['henkel_adm_p_akun_group/simpan'] = "henkel_admin/henkel_adm_p_akun_group/simpan";
$route['henkel_adm_p_akun_group/cari'] = "henkel_admin/henkel_adm_p_akun_group/cari";
$route['henkel_adm_p_akun_group/fetchdata'] = "henkel_admin/henkel_adm_p_akun_group/fetchdata";
$route['henkel_adm_p_akun_group/hapus/(:num)'] = "henkel_admin/henkel_adm_p_akun_group/hapus";

/* Laporan - Penjualan - Penjualan */
$route['henkel_adm_lap_penjualan'] = "henkel_admin/henkel_adm_lap_penjualan";
$route['henkel_adm_lap_penjualan/cari'] = "henkel_admin/henkel_adm_lap_penjualan/cari";
$route['henkel_adm_lap_penjualan/data_kosong'] = "henkel_admin/henkel_adm_lap_penjualan/data_kosong";
$route['henkel_adm_lap_penjualan/cari_data'] = "henkel_admin/henkel_adm_lap_penjualan/cari_data";
$route['henkel_adm_lap_penjualan/cetak_pdf_penjualan'] = "henkel_admin/henkel_adm_lap_penjualan/cetak_pdf_penjualan";
$route['henkel_adm_lap_penjualan/cetak_excel_penjualan'] = "henkel_admin/henkel_adm_lap_penjualan/cetak_excel_penjualan";

/* Laporan - Penjualan - Penjualan Detail*/
$route['henkel_adm_lap_penjualan_detail'] = "henkel_admin/henkel_adm_lap_penjualan_detail";
$route['henkel_adm_lap_penjualan_detail/cari'] = "henkel_admin/henkel_adm_lap_penjualan_detail/cari";
$route['henkel_adm_lap_penjualan_detail/data_kosong'] = "henkel_admin/henkel_adm_lap_penjualan_detail/data_kosong";
$route['henkel_adm_lap_penjualan_detail/cari_data'] = "henkel_admin/henkel_adm_lap_penjualan_detail/cari_data";
$route['henkel_adm_lap_penjualan_detail/cetak_pdf_penjualan'] = "henkel_admin/henkel_adm_lap_penjualan_detail/cetak_pdf_penjualan";
$route['henkel_adm_lap_penjualan_detail/cetak_excel_penjualan'] = "henkel_admin/henkel_adm_lap_penjualan_detail/cetak_excel_penjualan";

/* Laporan - Penjualan - Penjualan Item*/
$route['henkel_adm_lap_penjualan_item'] = "henkel_admin/henkel_adm_lap_penjualan_item";
$route['henkel_adm_lap_penjualan_item/cari'] = "henkel_admin/henkel_adm_lap_penjualan_item/cari";
$route['henkel_adm_lap_penjualan_item/data_kosong'] = "henkel_admin/henkel_adm_lap_penjualan_item/data_kosong";
$route['henkel_adm_lap_penjualan_item/cari_data'] = "henkel_admin/henkel_adm_lap_penjualan_item/cari_data";
$route['henkel_adm_lap_penjualan_item/cetak_pdf_penjualan'] = "henkel_admin/henkel_adm_lap_penjualan_item/cetak_pdf_penjualan";
$route['henkel_adm_lap_penjualan_item/cetak_excel_penjualan'] = "henkel_admin/henkel_adm_lap_penjualan_item/cetak_excel_penjualan";

/* Laporan - Penjualan - Penjualan Pelanggan*/
$route['henkel_adm_lap_penjualan_pelanggan'] = "henkel_admin/henkel_adm_lap_penjualan_pelanggan";
$route['henkel_adm_lap_penjualan_pelanggan/cari'] = "henkel_admin/henkel_adm_lap_penjualan_pelanggan/cari";
$route['henkel_adm_lap_penjualan_pelanggan/data_kosong'] = "henkel_admin/henkel_adm_lap_penjualan_pelanggan/data_kosong";
$route['henkel_adm_lap_penjualan_pelanggan/cari_data'] = "henkel_admin/henkel_adm_lap_penjualan_pelanggan/cari_data";
$route['henkel_adm_lap_penjualan_pelanggan/cetak_pdf_penjualan'] = "henkel_admin/henkel_adm_lap_penjualan_pelanggan/cetak_pdf_penjualan";
$route['henkel_adm_lap_penjualan_pelanggan/cetak_excel_penjualan'] = "henkel_admin/henkel_adm_lap_penjualan_pelanggan/cetak_excel_penjualan";

/* Laporan - Penjualan - Penjualan Sales*/
$route['henkel_adm_lap_penjualan_sales'] = "henkel_admin/henkel_adm_lap_penjualan_sales";
$route['henkel_adm_lap_penjualan_sales/cari'] = "henkel_admin/henkel_adm_lap_penjualan_sales/cari";
$route['henkel_adm_lap_penjualan_sales/data_kosong'] = "henkel_admin/henkel_adm_lap_penjualan_sales/data_kosong";
$route['henkel_adm_lap_penjualan_sales/cari_data'] = "henkel_admin/henkel_adm_lap_penjualan_sales/cari_data";
$route['henkel_adm_lap_penjualan_sales/cetak_pdf_penjualan'] = "henkel_admin/henkel_adm_lap_penjualan_sales/cetak_pdf_penjualan";
$route['henkel_adm_lap_penjualan_sales/cetak_excel_penjualan'] = "henkel_admin/henkel_adm_lap_penjualan_sales/cetak_excel_penjualan";

/* Laporan - Penjualan - Komisi Penjualan*/
$route['henkel_adm_lap_komisi_penjualan'] = "henkel_admin/henkel_adm_lap_komisi_penjualan";
$route['henkel_adm_lap_komisi_penjualan/cari'] = "henkel_admin/henkel_adm_lap_komisi_penjualan/cari";
$route['henkel_adm_lap_komisi_penjualan/data_kosong'] = "henkel_admin/henkel_adm_lap_komisi_penjualan/data_kosong";
$route['henkel_adm_lap_komisi_penjualan/cari_data'] = "henkel_admin/henkel_adm_lap_komisi_penjualan/cari_data";
$route['henkel_adm_lap_komisi_penjualan/cetak_pdf_penjualan'] = "henkel_admin/henkel_adm_lap_komisi_penjualan/cetak_pdf_penjualan";
$route['henkel_adm_lap_komisi_penjualan/cetak_excel_penjualan'] = "henkel_admin/henkel_adm_lap_komisi_penjualan/cetak_excel_penjualan";

/* Laporan - Pembelian - Pembelian */
$route['henkel_adm_lap_pembelian'] = "henkel_admin/henkel_adm_lap_pembelian";
$route['henkel_adm_lap_pembelian/cari'] = "henkel_admin/henkel_adm_lap_pembelian/cari";
$route['henkel_adm_lap_pembelian/data_kosong'] = "henkel_admin/henkel_adm_lap_pembelian/data_kosong";
$route['henkel_adm_lap_pembelian/cari_data'] = "henkel_admin/henkel_adm_lap_pembelian/cari_data";
$route['henkel_adm_lap_pembelian/cetak_pdf_pembelian'] = "henkel_admin/henkel_adm_lap_pembelian/cetak_pdf_pembelian";
$route['henkel_adm_lap_pembelian/cetak_excel_pembelian'] = "henkel_admin/henkel_adm_lap_pembelian/cetak_excel_pembelian";

/* Laporan - Pembelian - Pembelian Detail*/
$route['henkel_adm_lap_pembelian_detail'] = "henkel_admin/henkel_adm_lap_pembelian_detail";
$route['henkel_adm_lap_pembelian_detail/cari'] = "henkel_admin/henkel_adm_lap_pembelian_detail/cari";
$route['henkel_adm_lap_pembelian_detail/data_kosong'] = "henkel_admin/henkel_adm_lap_pembelian_detail/data_kosong";
$route['henkel_adm_lap_pembelian_detail/cari_data'] = "henkel_admin/henkel_adm_lap_pembelian_detail/cari_data";
$route['henkel_adm_lap_pembelian_detail/cetak_pdf_pembelian'] = "henkel_admin/henkel_adm_lap_pembelian_detail/cetak_pdf_pembelian";
$route['henkel_adm_lap_pembelian_detail/cetak_excel_pembelian'] = "henkel_admin/henkel_adm_lap_pembelian_detail/cetak_excel_pembelian";

/* Laporan - Pembelian - Pembelian Item*/
$route['henkel_adm_lap_pembelian_item'] = "henkel_admin/henkel_adm_lap_pembelian_item";
$route['henkel_adm_lap_pembelian_item/cari'] = "henkel_admin/henkel_adm_lap_pembelian_item/cari";
$route['henkel_adm_lap_pembelian_item/data_kosong'] = "henkel_admin/henkel_adm_lap_pembelian_item/data_kosong";
$route['henkel_adm_lap_pembelian_item/cari_data'] = "henkel_admin/henkel_adm_lap_pembelian_item/cari_data";
$route['henkel_adm_lap_pembelian_item/cetak_pdf_pembelian'] = "henkel_admin/henkel_adm_lap_pembelian_item/cetak_pdf_pembelian";
$route['henkel_adm_lap_pembelian_item/cetak_excel_pembelian'] = "henkel_admin/henkel_adm_lap_pembelian_item/cetak_excel_pembelian";

/* Laporan - Pembelian - Pembelian Supplier*/
$route['henkel_adm_lap_pembelian_supplier'] = "henkel_admin/henkel_adm_lap_pembelian_supplier";
$route['henkel_adm_lap_pembelian_supplier/cari'] = "henkel_admin/henkel_adm_lap_pembelian_supplier/cari";
$route['henkel_adm_lap_pembelian_supplier/data_kosong'] = "henkel_admin/henkel_adm_lap_pembelian_supplier/data_kosong";
$route['henkel_adm_lap_pembelian_supplier/cari_data'] = "henkel_admin/henkel_adm_lap_pembelian_supplier/cari_data";
$route['henkel_adm_lap_pembelian_supplier/cetak_pdf_pembelian'] = "henkel_admin/henkel_adm_lap_pembelian_supplier/cetak_pdf_pembelian";
$route['henkel_adm_lap_pembelian_supplier/cetak_excel_pembelian'] = "henkel_admin/henkel_adm_lap_pembelian_supplier/cetak_excel_pembelian";

/* Laporan - Hutang - Hutang Beredar */
$route['henkel_adm_lap_hutang'] = "henkel_admin/henkel_adm_lap_hutang";
$route['henkel_adm_lap_hutang/cari'] = "henkel_admin/henkel_adm_lap_hutang/cari";
$route['henkel_adm_lap_hutang/data_kosong'] = "henkel_admin/henkel_adm_lap_hutang/data_kosong";
$route['henkel_adm_lap_hutang/cari_data'] = "henkel_admin/henkel_adm_lap_hutang/cari_data";
$route['henkel_adm_lap_hutang/cetak_pdf_hutang'] = "henkel_admin/henkel_adm_lap_hutang/cetak_pdf_hutang";
$route['henkel_adm_lap_hutang/cetak_excel_hutang'] = "henkel_admin/henkel_adm_lap_hutang/cetak_excel_hutang";

/* Laporan - Hutang - Umur Hutang */
$route['henkel_adm_lap_umur_hutang'] = "henkel_admin/henkel_adm_lap_umur_hutang";
$route['henkel_adm_lap_umur_hutang/cari'] = "henkel_admin/henkel_adm_lap_umur_hutang/cari";
$route['henkel_adm_lap_umur_hutang/data_kosong'] = "henkel_admin/henkel_adm_lap_umur_hutang/data_kosong";
$route['henkel_adm_lap_umur_hutang/cari_data'] = "henkel_admin/henkel_adm_lap_umur_hutang/cari_data";
$route['henkel_adm_lap_umur_hutang/cetak_pdf_hutang'] = "henkel_admin/henkel_adm_lap_umur_hutang/cetak_pdf_hutang";
$route['henkel_adm_lap_umur_hutang/cetak_excel_hutang'] = "henkel_admin/henkel_adm_lap_umur_hutang/cetak_excel_hutang";

/* Laporan - Piutang - Piutang Beredar*/
$route['henkel_adm_lap_piutang'] = "henkel_admin/henkel_adm_lap_piutang";
$route['henkel_adm_lap_piutang/cari'] = "henkel_admin/henkel_adm_lap_piutang/cari";
$route['henkel_adm_lap_piutang/data_kosong'] = "henkel_admin/henkel_adm_lap_piutang/data_kosong";
$route['henkel_adm_lap_piutang/cari_data'] = "henkel_admin/henkel_adm_lap_piutang/cari_data";
$route['henkel_adm_lap_piutang/cetak_pdf_piutang'] = "henkel_admin/henkel_adm_lap_piutang/cetak_pdf_piutang";
$route['henkel_adm_lap_piutang/cetak_excel_piutang'] = "henkel_admin/henkel_adm_lap_piutang/cetak_excel_piutang";

/* Laporan - Hutang - Umur Hutang */
$route['henkel_adm_lap_umur_piutang'] = "henkel_admin/henkel_adm_lap_umur_piutang";
$route['henkel_adm_lap_umur_piutang/cari'] = "henkel_admin/henkel_adm_lap_umur_piutang/cari";
$route['henkel_adm_lap_umur_piutang/data_kosong'] = "henkel_admin/henkel_adm_lap_umur_piutang/data_kosong";
$route['henkel_adm_lap_umur_piutang/cari_data'] = "henkel_admin/henkel_adm_lap_umur_piutang/cari_data";
$route['henkel_adm_lap_umur_piutang/cetak_pdf_piutang'] = "henkel_admin/henkel_adm_lap_umur_piutang/cetak_pdf_piutang";
$route['henkel_adm_lap_umur_piutang/cetak_excel_piutang'] = "henkel_admin/henkel_adm_lap_umur_piutang/cetak_excel_piutang";

/* Laporan - Komisi - Komisi Sales */
$route['henkel_adm_lap_penerima_komisi_sales'] = "henkel_admin/henkel_adm_lap_penerima_komisi_sales";
$route['henkel_adm_lap_penerima_komisi_sales/cari_komisi_sales'] = "henkel_admin/henkel_adm_lap_penerima_komisi_sales/cari_komisi_sales";
$route['henkel_adm_lap_penerima_komisi_sales/cetak_pdf_komisi_sales'] = "henkel_admin/henkel_adm_lap_penerima_komisi_sales/cetak_pdf_komisi_sales";
$route['henkel_adm_lap_penerima_komisi_sales/cetak_excel_komisi_sales'] = "henkel_admin/henkel_adm_lap_penerima_komisi_sales/cetak_excel_komisi_sales";

/* Laporan - Komisi - Komisi Admin */
$route['henkel_adm_lap_penerima_komisi_kolektor'] = "henkel_admin/henkel_adm_lap_penerima_komisi_kolektor";
$route['henkel_adm_lap_penerima_komisi_kolektor/cari_komisi_kolektor'] = "henkel_admin/henkel_adm_lap_penerima_komisi_kolektor/cari_komisi_kolektor";
$route['henkel_adm_lap_penerima_komisi_kolektor/cetak_pdf_komisi_kolektor'] = "henkel_admin/henkel_adm_lap_penerima_komisi_kolektor/cetak_pdf_komisi_kolektor";
$route['henkel_adm_lap_penerima_komisi_kolektor/cetak_excel_komisi_kolektor'] = "henkel_admin/henkel_adm_lap_penerima_komisi_kolektor/cetak_excel_komisi_kolektor";

/* Laporan - Komisi - Komisi Admin */
$route['henkel_adm_lap_penerima_komisi_admin'] = "henkel_admin/henkel_adm_lap_penerima_komisi_admin";
$route['henkel_adm_lap_penerima_komisi_admin/cari_komisi_admin'] = "henkel_admin/henkel_adm_lap_penerima_komisi_admin/cari_komisi_admin";
$route['henkel_adm_lap_penerima_komisi_admin/cetak_pdf_komisi_admin'] = "henkel_admin/henkel_adm_lap_penerima_komisi_admin/cetak_pdf_komisi_admin";
$route['henkel_adm_lap_penerima_komisi_admin/cetak_excel_komisi_admin'] = "henkel_admin/henkel_adm_lap_penerima_komisi_admin/cetak_excel_komisi_admin";

/* Pustaka - Profil Pelanggan */
$route['henkel_adm_group_pelanggan'] = "henkel_admin/henkel_adm_group_pelanggan";
$route['henkel_adm_group_pelanggan/simpan'] = "henkel_admin/henkel_adm_group_pelanggan/simpan";
$route['henkel_adm_group_pelanggan/cari'] = "henkel_admin/henkel_adm_group_pelanggan/cari";
$route['henkel_adm_group_pelanggan/hapus/(:num)'] = "henkel_admin/henkel_adm_group_pelanggan/hapus";

/* Pustaka - Program Penjualan */
$route['henkel_adm_program_penjualan'] = "henkel_admin/henkel_adm_program_penjualan";
$route['henkel_adm_program_penjualan/simpan'] = "henkel_admin/henkel_adm_program_penjualan/simpan";
$route['henkel_adm_program_penjualan/simpan_detail'] = "henkel_admin/henkel_adm_program_penjualan/simpan_detail";
$route['henkel_adm_program_penjualan/simpan_pp'] = "henkel_admin/henkel_adm_program_penjualan/simpan_pp";
$route['henkel_adm_program_penjualan/t_simpan'] = "henkel_admin/henkel_adm_program_penjualan/t_simpan";
$route['henkel_adm_program_penjualan/t_cari'] = "henkel_admin/henkel_adm_program_penjualan/t_cari";
$route['henkel_adm_program_penjualan/cari_detail'] = "henkel_admin/henkel_adm_program_penjualan/cari_detail";
$route['henkel_adm_program_penjualan/tambah'] = "henkel_admin/henkel_adm_program_penjualan/tambah";
$route['henkel_adm_program_penjualan/edit/(:num)'] = "henkel_admin/henkel_adm_program_penjualan/edit";
$route['henkel_adm_program_penjualan/baru'] = "henkel_admin/henkel_adm_program_penjualan/baru";
$route['henkel_adm_program_penjualan/cek_table'] = "henkel_admin/henkel_adm_program_penjualan/cek_table";
$route['henkel_adm_program_penjualan/cek_table_pp'] = "henkel_admin/henkel_adm_program_penjualan/cek_table_pp";
$route['henkel_adm_program_penjualan/hapus/(:num)'] = "henkel_admin/henkel_adm_program_penjualan/hapus";
$route['henkel_adm_program_penjualan/hapus_detail/(:num)'] = "henkel_admin/henkel_adm_program_penjualan/hapus_detail";
$route['henkel_adm_program_penjualan/t_hapus/(:num)'] = "henkel_admin/henkel_adm_program_penjualan/t_hapus";

/* Pustaka - Komisi */
$route['henkel_adm_komisi'] = "henkel_admin/henkel_adm_komisi";
$route['henkel_adm_komisi/simpan'] = "henkel_admin/henkel_adm_komisi/simpan";
$route['henkel_adm_komisi/simpan_detail'] = "henkel_admin/henkel_adm_komisi/simpan_detail";
$route['henkel_adm_komisi/simpan_k'] = "henkel_admin/henkel_adm_komisi/simpan_k";
$route['henkel_adm_komisi/t_simpan'] = "henkel_admin/henkel_adm_komisi/t_simpan";
$route['henkel_adm_komisi/t_cari'] = "henkel_admin/henkel_adm_komisi/t_cari";
$route['henkel_adm_komisi/cari'] = "henkel_admin/henkel_adm_komisi/cari";
$route['henkel_adm_komisi/cari_detail'] = "henkel_admin/henkel_adm_komisi/cari_detail";
$route['henkel_adm_komisi/tambah'] = "henkel_admin/henkel_adm_komisi/tambah";
$route['henkel_adm_komisi/edit/(:num)'] = "henkel_admin/henkel_adm_komisi/edit";
$route['henkel_adm_komisi/baru'] = "henkel_admin/henkel_adm_komisi/baru";
$route['henkel_adm_komisi/cek_table'] = "henkel_admin/henkel_adm_komisi/cek_table";
$route['henkel_adm_komisi/cek_table_k'] = "henkel_admin/henkel_adm_komisi/cek_table_k";
$route['henkel_adm_komisi/hapus/(:num)'] = "henkel_admin/henkel_adm_komisi/hapus";
$route['henkel_adm_komisi/hapus_detail/(:num)'] = "henkel_admin/henkel_adm_komisi/hapus_detail";
$route['henkel_adm_komisi/t_hapus/(:num)'] = "henkel_admin/henkel_adm_komisi/t_hapus";

/* Pustaka - Jabatan Karyawan */
$route['henkel_adm_jabatan_karyawan'] = "henkel_admin/henkel_adm_jabatan_karyawan";
$route['henkel_adm_jabatan_karyawan/simpan'] = "henkel_admin/henkel_adm_jabatan_karyawan/simpan";
$route['henkel_adm_jabatan_karyawan/cari'] = "henkel_admin/henkel_adm_jabatan_karyawan/cari";
$route['henkel_adm_jabatan_karyawan/hapus/(:num)'] = "henkel_admin/henkel_adm_jabatan_karyawan/hapus";

/* Pemberitahuan Stok Kritis */
$route['henkel_adm_n_stok_kritis'] = "henkel_admin/henkel_adm_n_stok_kritis";
$route['henkel_adm_n_stok_kritis/hapus/(:num)'] = "henkel_admin/henkel_adm_n_stok_kritis/hapus";

/* Pemberitahuan Jatuh Tempo */
$route['henkel_adm_n_jt'] = "henkel_admin/henkel_adm_n_jt";
$route['henkel_adm_n_jt/hapus/(:num)'] = "henkel_admin/henkel_adm_n_jt/hapus";

/* Pemberitahuan Jatuh Tempo Invoice Supplier*/
$route['henkel_adm_n_jt_inv_supp'] = "henkel_admin/henkel_adm_n_jt_inv_supp";
$route['henkel_adm_n_jt_inv_supp/hapus/(:num)'] = "henkel_admin/henkel_adm_n_jt_inv_supp/hapus";

// Original version would have to have yourmodule at the start of the route for the routes.php to be read
/* Home */
$route['henkel_home/henkel_home'] = "henkel_admin/henkel_home";
