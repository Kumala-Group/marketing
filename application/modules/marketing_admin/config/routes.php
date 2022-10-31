<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/* Home */
// $route['marketing']                                                      = "marketing_admin/marketing_home";
$route['']                                              				= "marketing_admin/marketing_home";
$route['marketing/beranda']                                            	= "marketing_admin/marketing_home/beranda";
$route['marketing/logout']                                             	= "marketing_admin/marketing_home/logout";

$route['notifikasi']                                                   	= "marketing_admin/notifikasi";
$route['notifikasi/read_all']                                           = "marketing_admin/notifikasi/read_all";

$route['konfigurasi_user']                                             	= "marketing_admin/konfigurasi_user";
$route['konfigurasi_user/set_status']                                   = "marketing_admin/konfigurasi_user/set_status";
$route['konfigurasi_user/get_users']                                    = "marketing_admin/konfigurasi_user/get_users";
$route['konfigurasi_user/reset_password']                               = "marketing_admin/konfigurasi_user/reset_password";
// $route['konfigurasi_user/get_user_aktif']                               = "marketing_admin/konfigurasi_user/get_user_aktif";
// $route['konfigurasi_user/get_user_non_aktif']                           = "marketing_admin/konfigurasi_user/get_user_non_aktif";

$route['user_profil']                                                   = "marketing_admin/user_profil";
$route['aplikasi/slider']                                               = "marketing_admin/master_app/slider";
$route['aplikasi/heading']                                              = "marketing_admin/master_app/heading";
$route['aplikasi/brand']                                                = "marketing_admin/master_app/brand";
$route['aplikasi/dealer']                                               = "marketing_admin/master_app/dealer";
$route['aplikasi/berita']                                               = "marketing_admin/master_app/berita";
$route['aplikasi/acara']                                                = "marketing_admin/master_app/acara";
$route['aplikasi/voucher']                                              = "marketing_admin/master_app/voucher";
$route['aplikasi/karir']                                                = "marketing_admin/master_app/karir";
$route['aplikasi/sparepart']                                            = "marketing_admin/master_app/sparepart";
$route['aplikasi/partner']                                              = "marketing_admin/master_app/partner";
$route['aplikasi/property']                                             = "marketing_admin/master_app/property";
$route['aplikasi/model']                                                = "marketing_admin/master_app/model";
$route['aplikasi/tipe']                                                 = "marketing_admin/master_app/tipe";
$route['aplikasi/warna']                                                = "marketing_admin/master_app/warna";
$route['aplikasi/otomotif']                                             = "marketing_admin/master_app/otomotif";

$route['dashboard/wuling_ctrl_survey_do']                               = "marketing_admin/dashboard/wuling_ctrl_survey_do";
$route['dashboard/wuling_ctrl_survey_do/data_customer']                 = "marketing_admin/dashboard/wuling_ctrl_survey_do/data_customer";
$route['dashboard/wuling_ctrl_survey_do/jumlah_survei']                 = "marketing_admin/dashboard/wuling_ctrl_survey_do/jumlah_survei";
$route['dashboard/wuling_ctrl_survey_do/get_dealer']                  	= "marketing_admin/dashboard/wuling_ctrl_survey_do/get_dealer";
$route['dashboard/wuling_ctrl_survey_do/get_thn_bln_do']               	= "marketing_admin/dashboard/wuling_ctrl_survey_do/get_thn_bln_do";
$route['dashboard/wuling_ctrl_survey_do/data_survei_dealer']           	= "marketing_admin/dashboard/wuling_ctrl_survey_do/data_survei_dealer";

//virtual fair
$route['virtual_fair/list_user']                                       	= "marketing_admin/virtual_fair/list_user";
$route['virtual_fair/list_transaksi']                                  	= "marketing_admin/virtual_fair/list_transaksi";
$route['virtual_fair/main_stage']                                      	= "marketing_admin/virtual_fair/main_stage";
$route['virtual_fair/detail_unit']                                      = "marketing_admin/virtual_fair/detail_unit";
$route['virtual_fair/pengaturan']                                       = "marketing_admin/virtual_fair/pengaturan";
$route['virtual_fair/dashboard']                                        = "marketing_admin/virtual_fair/dashboard";

$route['virtual_fair/pengaturan/ubah_bg_login']                         = "marketing_admin/virtual_fair/pengaturan/ubah_bg_login";
$route['virtual_fair/pengaturan/ubah_main_stage']                       = "marketing_admin/virtual_fair/pengaturan/ubah_main_stage";

//admin
$route['admin/test_drive']                                             	= "marketing_admin/admin/layanan";
$route['admin/penawaran']                                              	= "marketing_admin/admin/layanan";
$route['admin/layanan/ubah_status']                                    	= "marketing_admin/admin/layanan/ubah_status";
$route['api/(:any)/layanan']                                           	= "marketing_admin/admin/layanan/simpan";

$route['admin/booking_service']                                      	= "marketing_admin/admin/booking_service";
$route['admin/booking_service/ubah_status']                          	= "marketing_admin/admin/booking_service/ubah_status";
$route['api/(:any)/m_booking_service']                               	= "marketing_admin/admin/booking_service/simpan";

$route['admin/home_service']                                         	= "marketing_admin/admin/home_service";
$route['admin/home_service/ubah_status']                             	= "marketing_admin/admin/home_service/ubah_status";
$route['api/(:any)/m_home_service']                                  	= "marketing_admin/admin/home_service/simpan";

$route['admin/bantuan']                                              	= "marketing_admin/admin/bantuan";
$route['admin/bantuan/ubah_status']                                  	= "marketing_admin/admin/bantuan/ubah_status";
$route['api/(:any)/bantuan']                                         	= "marketing_admin/admin/bantuan/simpan";

$route['admin/pelamar']                                              	= "marketing_admin/admin/pelamar";
$route['admin/pelamar/get']                                             = "marketing_admin/admin/pelamar/get";
$route['api/(:any)/pelamar']                                         	= "marketing_admin/admin/pelamar/simpan";

$route['admin/tiket']                                                	= "marketing_admin/admin/tiket";
$route['admin/tiket/ubah_status']                                    	= "marketing_admin/admin/tiket/ubah_status";
$route['api/(:any)/m_tiket']                                         	= "marketing_admin/admin/tiket/simpan";

$route['admin/saran']                                                	= "marketing_admin/admin/saran";
$route['admin/saran/ubah_status']                                    	= "marketing_admin/admin/saran/ubah_status";
$route['api/(:any)/m_saran']                                         	= "marketing_admin/admin/saran/simpan";


//get gateway
$route['api/(:any)/slider']                                           	= "marketing_admin/api_website/slider";
$route['api/(:any)/slider/(:any)']                                    	= "marketing_admin/api_website/slider";
$route['api/(:any)/berita']                                           	= "marketing_admin/api_website/berita";
$route['api/(:any)/berita/(:num)']                                    	= "marketing_admin/api_website/berita";
$route['api/(:any)/partner']                                          	= "marketing_admin/api_website/partner";
$route['api/(:any)/tentang']                                          	= "marketing_admin/api_website/tentang";
$route['api/(:any)/otomotif']                                         	= "marketing_admin/api_website/otomotif";
$route['api/(:any)/otomotif/(:any)/(:num)']                           	= "marketing_admin/api_website/otomotif";
$route['api/(:any)/otomotif/(:any)']                                  	= "marketing_admin/api_website/otomotif";
$route['api/(:any)/dealer/(:any)/(:any)']                             	= "marketing_admin/api_website/dealer";
$route['api/(:any)/model/(:num)']                                     	= "marketing_admin/api_website/model";
$route['api/(:any)/property/(:any)']                                  	= "marketing_admin/api_website/property";
$route['api/(:any)/property/(:any)/(:any)']                           	= "marketing_admin/api_website/property";
$route['api/(:any)/mining']                                           	= "marketing_admin/api_website/mining";
$route['api/(:any)/mining/(:num)']                                    	= "marketing_admin/api_website/mining";
$route['api/(:any)/karir']                                            	= "marketing_admin/api_website/karir";

$route['api/(:any)/tipe/(:num)/(:num)/(:any)']                			= "marketing_admin/api_website/tipe";

//mobile get gateway
$route['api/(:any)/m_berita']                            				= "marketing_admin/api_apps_get/m_berita";
$route['api/(:any)/m_promo']                                          	= "marketing_admin/api_apps_get/m_berita";
$route['api/(:any)/m_tips']                                           	= "marketing_admin/api_apps_get/m_berita";
$route['api/(:any)/m_brand']                                          	= "marketing_admin/api_apps_get/m_brand";
$route['api/(:any)/m_dealer']                                         	= "marketing_admin/api_apps_get/m_dealer";
$route['api/(:any)/m_dealer/(:any)']                                  	= "marketing_admin/api_apps_get/m_dealer";
$route['api/(:any)/m_dealer/(:num)/(:any)']                           	= "marketing_admin/api_apps_get/m_dealer";
$route['api/(:any)/m_acara']                                          	= "marketing_admin/api_apps_get/m_acara";
$route['api/(:any)/m_acara/(:num)']                                   	= "marketing_admin/api_apps_get/m_acara";
$route['api/(:any)/m_voucher']                                        	= "marketing_admin/api_apps_get/m_voucher";
$route['api/(:any)/data_daerah']                                      	= "marketing_admin/api_apps_get/data_daerah";
$route['api/(:any)/data_daerah/(:num)']                               	= "marketing_admin/api_apps_get/data_daerah";
$route['api/(:any)/data_daerah/(:num)/(:num)']                        	= "marketing_admin/api_apps_get/data_daerah";
$route['api/(:any)/m_produk/(:num)']                                  	= "marketing_admin/api_apps_get/m_produk";
$route['api/(:any)/m_produk/(:num)/(:num)']                           	= "marketing_admin/api_apps_get/m_produk";
$route['api/(:any)/m_warna/(:num)']                                   	= "marketing_admin/api_apps_get/m_warna";
$route['api/(:any)/m_sparepart/(:num)']                               	= "marketing_admin/api_apps_get/m_sparepart";
$route['api/(:any)/m_sparepart/(:num)/(:num)']                       	= "marketing_admin/api_apps_get/m_sparepart";
$route['api/(:any)/m_customer/(:num)']                               	= "marketing_admin/api_apps_get/m_customer";
$route['api/(:any)/m_provinsi/(:num)']                               	= "marketing_admin/api_apps_get/m_provinsi";
$route['api/(:any)/m_pricelist/(:num)/(:any)']                       	= "marketing_admin/api_apps_get/m_pricelist";
$route['api/(:any)/tipe_unit/(:num)']                                	= "marketing_admin/api_apps_get/tipe_unit";

$route['api/(:any)/checkout']                                         	= "marketing_admin/api_apps_post/checkout";
$route['api/(:any)/register_cust']                                    	= "marketing_admin/api_apps_post/register_cust";
$route['api/(:any)/login_cust']                                       	= "marketing_admin/api_apps_post/login_cust";
$route['api/(:any)/profil_cust']                                      	= "marketing_admin/api_apps_post/profil_cust";
$route['api/(:any)/password_cust']                                    	= "marketing_admin/api_apps_post/password_cust";

//api honda
$route['api/(:any)/s_honda']                                         	= "marketing_admin/api_website/slider_honda";
$route['api/(:any)/get_area']                                         	= "marketing_admin/api_website/get_area";
$route['api/(:any)/area_dealers']                                         	= "marketing_admin/api_website/area_dealers";
$route['api/(:any)/p_honda']                                         	= "marketing_admin/api_website/produk_honda";
$route['api/(:any)/p_honda/(:any)']                                  	= "marketing_admin/api_website/produk_honda";
$route['api/(:any)/b_honda']                                         	= "marketing_admin/api_website/berita_honda";
$route['api/(:any)/b_honda/(:any)']                                  	= "marketing_admin/api_website/berita_honda";
$route['api/(:any)/pm_honda']                                        	= "marketing_admin/api_website/promo_honda";
$route['api/(:any)/pm_honda/(:any)']                                 	= "marketing_admin/api_website/promo_honda";

//api digifest
$route['api/(:any)/digifest_login']                                   	= "marketing_admin/api_digifest/login";
$route['api/(:any)/digifest_register']                                	= "marketing_admin/api_digifest/register";

$route['api/(:any)/digifest_main']                                    	= "marketing_admin/api_digifest/main_stage";
$route['api/(:any)/digifest_rundown/(:any)']                          	= "marketing_admin/api_digifest/rundown";
$route['api/(:any)/digifest_lineUp/(:any)/(:any)/(:any)']             	= "marketing_admin/api_digifest/lineUp";
$route['api/(:any)/digifest_lineUp/(:any)/(:any)']                    	= "marketing_admin/api_digifest/lineUp";
$route['api/(:any)/digifest_lineUp/(:any)']                           	= "marketing_admin/api_digifest/lineUp";
$route['api/(:any)/digifest_profil/(:any)']                           	= "marketing_admin/api_digifest/profil";
$route['api/(:any)/digifest_profil']                                  	= "marketing_admin/api_digifest/profil";
$route['api/(:any)/digifest_cart/(:any)']                             	= "marketing_admin/api_digifest/cart";
$route['api/(:any)/digifest_cart']                                    	= "marketing_admin/api_digifest/cart";
$route['api/(:any)/digifest_provinsi']                                	= "marketing_admin/api_digifest/provinsi";
$route['api/(:any)/digifest_checkout']                                	= "marketing_admin/api_digifest/checkout";
$route['api/(:any)/digifest_confirm']                                 	= "marketing_admin/api_digifest/confirm";
$route['api/(:any)/digifest_riwayat/(:any)/(:any)']                   	= "marketing_admin/api_digifest/riwayat";
$route['api/(:any)/digifest_riwayat/(:any)']                          	= "marketing_admin/api_digifest/riwayat";
$route['api/(:any)/digifest_cabang/(:any)']                           	= "marketing_admin/api_digifest/cabang";
$route['api/(:any)/bg_login']                                         	= "marketing_admin/api_digifest/bgLogin";
$route['api/(:any)/bg_main_stage']                                    	= "marketing_admin/api_digifest/bgMainStage";
$route['api/(:any)/degifest_counter']                                 	= "marketing_admin/api_digifest/visitorCounter";
