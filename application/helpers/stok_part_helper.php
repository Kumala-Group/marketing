<?php

/**
 * created by AL
 * IMPORTANT DON'T REMOVE AND UPDATE!
 * helper ini berfungsi untuk meminimalisir perulangan fungsi yang digunakan pada module honda_admin_sp
 * - lokasi part
 * - menambah part
 * - mengurangi part
 */


// untuk mengambil lokasi part
if (!function_exists('part_location')) {
    function part_location($kode_gudang, $lokasi, $rak, $kolom, $baris, $nomor_binbox)
    {
        $ci = get_instance();

        $get_gudang = $ci->db_honda_sp->query("SELECT nama_gudang FROM gudang_new WHERE kode_gudang = '$kode_gudang'")->row('nama_gudang');

        // gudang baru
        $get_lokasi    = $ci->db_honda_sp->query("SELECT lokasi FROM gudang_detail_lokasi_new WHERE id_gudang_detail_lokasi = '$lokasi'")->row('lokasi');
        $get_rak       = $ci->db_honda_sp->query("SELECT rak FROM gudang_detail_lokasi_new WHERE id_gudang_detail_lokasi = '$rak'")->row('rak');
        $get_kolom     = $ci->db_honda_sp->query("SELECT kolom FROM gudang_detail_lokasi_new WHERE id_gudang_detail_lokasi = '$kolom'")->row('kolom');
        $get_baris     = $ci->db_honda_sp->query("SELECT baris FROM gudang_detail_lokasi_new WHERE id_gudang_detail_lokasi = '$baris'")->row('baris');
        $get_no_binbox = $ci->db_honda_sp->query("SELECT no_binbox FROM gudang_detail_lokasi_new WHERE id_gudang_detail_lokasi = '$nomor_binbox'")->row('no_binbox');

        $lokasi_part = "{$get_gudang} {$get_lokasi}{$get_rak}-{$get_baris}-{$get_kolom}-{$get_no_binbox}";

        return $lokasi_part;
    }
}

// untuk mengambil lokasi part dalam array terpisah
if (!function_exists('part_location_array')) {
    function part_location_array($kode_gudang, $lokasi, $rak, $kolom, $baris, $nomor_binbox)
    {
        $ci = get_instance();
        $lokasi_part['gudang'] = $ci->db_honda_sp->query("SELECT nama_gudang FROM gudang_new WHERE kode_gudang = '$kode_gudang'")->row('nama_gudang');

        // gudang baru
        $lokasi_part['lokasi']    = $ci->db_honda_sp->query("SELECT lokasi FROM gudang_detail_lokasi_new WHERE id_gudang_detail_lokasi = '$lokasi'")->row('lokasi');
        $lokasi_part['rak']       = $ci->db_honda_sp->query("SELECT rak FROM gudang_detail_lokasi_new WHERE id_gudang_detail_lokasi = '$rak'")->row('rak');
        $lokasi_part['kolom']     = $ci->db_honda_sp->query("SELECT kolom FROM gudang_detail_lokasi_new WHERE id_gudang_detail_lokasi = '$kolom'")->row('kolom');
        $lokasi_part['baris']     = $ci->db_honda_sp->query("SELECT baris FROM gudang_detail_lokasi_new WHERE id_gudang_detail_lokasi = '$baris'")->row('baris');
        $lokasi_part['no_binbox'] = $ci->db_honda_sp->query("SELECT no_binbox FROM gudang_detail_lokasi_new WHERE id_gudang_detail_lokasi = '$nomor_binbox'")->row('no_binbox');

        return $lokasi_part;
    }
}

// untuk mengubah stok pada tabel stok item (+)
if (!function_exists('update_part_stok_added')) {
    function update_part_stok_added($id_perusahaan, $kode_item, $stok)
    {
        $ci = get_instance();

        // untuk mengecek data pada item stock
        $where = ['id_perusahaan' => $id_perusahaan, 'kode_item' => $kode_item];
        $query = $ci->db_honda_sp->select('*')->where($where)->get('stok_item');
        $count = $query->num_rows();
        $value = $query->row();

        if ($count > 0) {
            // untuk update stok item
            $item_stock = [
                'stok' => ($value->stok + $stok),
            ];
            // untuk proses update stok item
            $ci->db_honda_sp->where($where)->update('stok_item', $item_stock);
        }
    }
}

// untuk mengubah stok pada tabel stok item (-)
if (!function_exists('update_part_stok_reduced')) {
    function update_part_stok_reduced($id_perusahaan, $kode_item, $stok)
    {
        $ci = get_instance();

        // untuk mengecek data pada item stock
        $where = ['id_perusahaan' => $id_perusahaan, 'kode_item' => $kode_item];
        $query = $ci->db_honda_sp->select('*')->where($where)->get('stok_item');
        $count = $query->num_rows();
        $value = $query->row();

        if ($count > 0) {
            // untuk update stok item
            $item_stock = [
                'stok' => ($value->stok - $stok),
            ];
            // untuk proses update stok item
            $ci->db_honda_sp->where($where)->update('stok_item', $item_stock);
        }
    }
}
