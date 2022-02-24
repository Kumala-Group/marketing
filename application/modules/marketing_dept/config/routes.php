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

/*--- OLI ROUTE --- */

/* Home */
$route['marketing_dept_home'] = "marketing_dept/marketing_dept_home";

/* Corp */

$route['marketing_dept_corp_bio'] = "marketing_dept/marketing_dept_corp_bio";


/* Report */
$route['marketing_dept_lap_summary'] = "marketing_dept/marketing_dept_lap_summary";
$route['marketing_dept_lap_summary/summary_per_perusahaan'] = "marketing_dept/marketing_dept_lap_summary/summary_per_perusahaan";

// Original version would have to have yourmodule at the start of the route for the routes.php to be read
/* Home */
$route['oli_home/oli_home'] = "oli_home";
