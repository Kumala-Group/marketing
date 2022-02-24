<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = "marketing_admin/marketing_home";
$route['404_override'] = 'kmg404';
$modules_path = APPPATH.'modules/';
$modules = scandir($modules_path);
foreach($modules as $module)
{
	if($module === '.'||$module==='..') continue;
	if(is_dir($modules_path).'/'.$module)
	{
		$routes_path = $modules_path.$module.'/config/routes.php';
		if(file_exists($routes_path))
		{
			require($routes_path);
		}else{
			continue;
		}		
	}
}
$route['translate_uri_dashes'] = FALSE;
