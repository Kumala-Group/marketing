<?php
defined('BASEPATH') or exit('No direct script access allowed');
/*Login*/
$route['group'] = 'group';
$route['group/cek_login'] = 'group/group/cek_login';
$route['group/logout'] = 'group/group/logout';
/*End Login*/

$route['g_home'] = 'group/g_home';

/*Data Profil*/
$route['g_profil'] = 'group/g_profil';
$route['g_profil/update_profil'] = 'group/g_profil/update_profil';
$route['g_profil/update_akun'] = 'group/g_profil/update_akun';
$route['g_profil/update_image'] = 'group/g_profil/update_image';
/*End Data Profil*/


/*Wuling*/
$route['g_wuling'] = 'group/g_wuling';
$route['g_wuling_financial_report'] = 'group/g_wuling_financial_report';
$route['g_wuling_financial_report/data'] = 'group/g_wuling_financial_report/data';
$route['g_wuling_sales_report'] = 'group/g_wuling_sales_report';
$route['g_wuling_sales_report/data'] = 'group/g_wuling_sales_report/data';
$route['g_wuling_login_history_report'] = 'group/g_wuling_login_history_report';
$route['g_wuling_login_history_report/data'] = 'group/g_wuling_login_history_report/data';
$route['g_wuling_after_sales_report'] = 'group/g_wuling_after_sales_report';
$route['g_wuling_after_sales_report/data'] = 'group/g_wuling_after_sales_report/data';
/*End Wuling*/

/*Honda*/
$route['g_honda'] = 'group/g_honda';
$route['g_honda/data'] = 'group/g_honda/data';
$route['g_honda_financial_report'] = 'group/g_honda_financial_report';
$route['g_honda_after_sales'] = 'group/g_honda_after_sales';
$route['g_honda_after_sales/data'] = 'group/g_honda_after_sales/data';
/*End Honda*/

/*mercedes*/
$route['g_mercedes'] = 'group/g_mercedes';
$route['g_mercedes/data'] = 'group/g_mercedes/data';
/*End mercedes*/

/*Hino*/
$route['g_hino'] = 'group/g_hino';
$route['g_hino/data'] = 'group/g_hino/data';
/*End Hino*/

/*Admin*/
$route['a_admin'] = 'group/a_admin';
$route['a_admin/get_data_admin'] = 'group/a_admin/get_data_admin';
$route['a_admin/simpan'] = 'group/a_admin/simpan';
$route['a_admin/simpan_account'] = 'group/a_admin/simpan_account';
$route['a_admin/cari_admin'] = 'group/a_admin/cari_admin';
$route['a_admin/cari_account'] = 'group/a_admin/cari_account';
$route['a_admin/hapus'] = 'group/a_admin/hapus';
/*End Admin*/
