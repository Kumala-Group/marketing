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

/* Home */
$route['ticket'] = "ticket/ticket_home";
$route['ticket/simpan'] = "ticket/ticket_home/simpan";
$route['ticket/hapus'] = "ticket/ticket_home/hapus";
$route['ticket/hapus/(:num)'] = "ticket/ticket_home/hapus/$1";
$route['ticket/simpan_gambar'] = "ticket/ticket_home/simpan_gambar";

$route['ticket_list'] = "ticket/ticket_list";
$route['ticket_list/edit/(:num)'] = "ticket/ticket_list/edit/$1";
$route['ticket_list/simpan_update/(:num)'] = "ticket/ticket_list/simpan_update/$1";


// Original version would have to have yourmodule at the start of the route for the routes.php to be read
/* Home */
