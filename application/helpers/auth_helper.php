<?php
defined('BASEPATH') or exit('No direct script access allowed');

// untuk mengecek session user
if (!function_exists('checking_session')) {
    function checking_session($user_data, $user_level, array $level, $brand)
    {
        $search = in_array($user_level, $level);
        if (empty($user_data) || $search == 0) {
            redirect($brand);
        } else {
            return $user_level;
        }
    }
}

// untuk mengambil data user, data level, data url
if (!function_exists('get_users_detail')) {
    function get_users_detail($db, $tabel, $id)
    {
        if ($id) {
            $ci     = get_instance();
            $result = $ci->$db->query("SELECT * FROM $tabel WHERE id_user = '$id'")->row();
            return $result;
        }
    }
}

// untuk breadcumb sub judul
if (!function_exists('sub_judul')) {
    function sub_judul(array $sub_judul)
	{
		$html = '';

		$html .= '<small>';
		foreach ($sub_judul as $key => $value) {
			$html .= '&nbsp;<i class="icon-double-angle-right"></i>&nbsp;';
			$html .= $value;
		}
		$html .= '</small>';

		return $html;
	}
}

// untuk remove titik dan spasi
if (!function_exists('remove_point_space')) {
    function remove_point_space($no_invoice)
	{
		return preg_replace('/\.|\s/', '', $no_invoice);
	}
}
