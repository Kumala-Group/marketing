<?php
defined('BASEPATH') or exit('No direct script access allowed');

/* Class Open Active Menu */
if (!function_exists('open_active_link')) {
	function open_activate_menu($controller1 = null, $controller2  = null, $controller3  = null, $controller4  = null, $controller5 = null, $controller6  = null, $controller7  = null, $controller8  = null, $controller9  = null, $controller10  = null, $controller11 = null, $controller12 = null, $controller13 = null, $controller14 = null, $controller15 = null)
	{
		$ci     = &get_instance();
		$class  = $ci->router->fetch_class();
		$action = $ci->router->fetch_method();
		if ($action == "index") {
			$class_ = $class;
		} else {
			$class_ = $class . "/" . $action;
		}
		return ($class_ == $controller1 || $class_ == $controller2 || $class_ == $controller3 || $class_ == $controller4 || $class_ == $controller5 || $class_ == $controller6 || $class_ == $controller7 || $class_ == $controller8 || $class_ == $controller9 || $class_ == $controller10 || $class_ == $controller11 || $class_ == $controller12 || $class_ == $controller13 || $class_ == $controller14 || $class_ == $controller15) ? 'open active' : '';
	}
}

/* Class Active Menu */
if (!function_exists('active_link')) {
	function activate_menu($controller1 = null, $controller2  = null, $controller3  = null, $controller4  = null, $controller5  = null)
	{
		$ci     = &get_instance();
		$class  = $ci->router->fetch_class();
		$action = $ci->router->fetch_method();
		if ($action == "index") {
			$class_ = $class;
		} else {
			$class_ = $class . "/" . $action;
		}
		return ($class_ == $controller1 || $class_ == $controller2 || $class_ == $controller3 || $class_ == $controller4 || $class_ == $controller5) ? 'active' : '';
	}
}
