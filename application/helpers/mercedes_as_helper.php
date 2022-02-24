<?php
// error_reporting(0);

/* Load semua data inbound by kode item */
function mercedes_sp_all_inbound($kode_item)
{
    $ci = &get_instance();
    $data = $ci->db_mercedes_sp->query("SELECT item_masuk.no_po, item_masuk_detail.kode_item, item_masuk_detail.total_item_item_masuk, item_masuk.tanggal_item_masuk, pesanan_pembelian.tanggal AS tanggal_po, gudang.nama_gudang, lokasi.lokasi, rak.rak, kolom.kolom, baris.baris, binbox.nomor_binbox, pesanan_pembelian.id_pesanan_pembelian, item_masuk_detail.admin FROM item_masuk LEFT JOIN item_masuk_detail ON item_masuk.id_item_masuk = item_masuk_detail.id_item_masuk LEFT JOIN pesanan_pembelian ON item_masuk.no_po = pesanan_pembelian.no_po LEFT JOIN gudang ON item_masuk_detail.kode_gudang = gudang.kode_gudang LEFT JOIN gudang_detail AS lokasi ON item_masuk_detail.lokasi = lokasi.id_gudang_detail LEFT JOIN gudang_detail AS rak ON item_masuk_detail.rak = rak.id_gudang_detail LEFT JOIN gudang_detail AS kolom ON item_masuk_detail.kolom = kolom.id_gudang_detail LEFT JOIN gudang_detail AS baris ON item_masuk_detail.baris = baris.id_gudang_detail LEFT JOIN gudang_detail AS binbox ON item_masuk_detail.nomor_binbox = binbox.id_gudang_detail WHERE item_masuk_detail.kode_item = '" . $kode_item . "' ");
    return $data->result();
}

/* Load penjualan part wo by kode item */
function mercedes_sp_penjualan_part_wo($kode_item)
{
    $ci = &get_instance();
    $data = $ci->db_mercedes_sp->query("SELECT db_mercedes_as.work_order.no_wo, db_mercedes_as.work_order.tgl_service, db_mercedes_as.work_order.user, db_mercedes_as.wo_detail_part.qty, db_mercedes_as.wo_detail_part.kode_item, db_mercedes_sp.stok_item.kode_item, db_mercedes_sp.gudang.nama_gudang, lokasi.lokasi, binbox.nomor_binbox, baris.baris, kolom.kolom, rak.rak FROM db_mercedes_as.work_order LEFT JOIN db_mercedes_as.wo_detail_part ON db_mercedes_as.work_order.no_wo = db_mercedes_as.wo_detail_part.no_wo LEFT JOIN db_mercedes_sp.stok_item ON db_mercedes_as.wo_detail_part.id_stock = db_mercedes_sp.stok_item.id_stock AND db_mercedes_as.wo_detail_part.kode_item = db_mercedes_sp.stok_item.kode_item LEFT JOIN db_mercedes_sp.gudang ON db_mercedes_sp.stok_item.kode_gudang = db_mercedes_sp.gudang.kode_gudang LEFT JOIN db_mercedes_sp.gudang_detail AS lokasi ON db_mercedes_sp.stok_item.lokasi = lokasi.id_gudang_detail LEFT JOIN db_mercedes_sp.gudang_detail AS binbox ON db_mercedes_sp.stok_item.nomor_binbox = binbox.id_gudang_detail LEFT JOIN db_mercedes_sp.gudang_detail AS baris ON db_mercedes_sp.stok_item.baris = baris.id_gudang_detail LEFT JOIN db_mercedes_sp.gudang_detail AS kolom ON db_mercedes_sp.stok_item.kolom = kolom.id_gudang_detail LEFT JOIN db_mercedes_sp.gudang_detail AS rak ON db_mercedes_sp.stok_item.rak = rak.id_gudang_detail WHERE db_mercedes_as.wo_detail_part.s_request = '2' AND db_mercedes_as.wo_detail_part.del = '0' AND db_mercedes_sp.stok_item.kode_item = '" . $kode_item . "' ");
    return $data->result();
}

/* Load penjualan part counter by kode item  */
function mercedes_sp_penjualan_part_counter($Kode_item)
{
    $ci = &get_instance();
    $data = $ci->db_mercedes_sp->query("SELECT db_mercedes_sp.pesanan_penjualan.no_transaksi, db_mercedes_sp.pesanan_penjualan.admin, db_mercedes_sp.penjualan.kode_item, db_mercedes_sp.penjualan.qty, db_mercedes_as.invoice_after_sales.no_invoice, db_mercedes_sp.pesanan_penjualan.tgl AS tanggal_ro, db_mercedes_sp.gudang.nama_gudang, lokasi.lokasi, binbox.nomor_binbox, baris.baris, kolom.kolom, rak.rak FROM db_mercedes_sp.pesanan_penjualan LEFT JOIN db_mercedes_sp.penjualan ON db_mercedes_sp.pesanan_penjualan.id_pesanan_penjualan = db_mercedes_sp.penjualan.id_pesanan_penjualan LEFT JOIN db_mercedes_as.invoice_after_sales ON db_mercedes_sp.pesanan_penjualan.no_transaksi = db_mercedes_as.invoice_after_sales.no_ref LEFT JOIN db_mercedes_sp.gudang ON db_mercedes_sp.penjualan.kode_gudang = db_mercedes_sp.gudang.kode_gudang LEFT JOIN db_mercedes_sp.gudang_detail AS lokasi ON db_mercedes_sp.penjualan.lokasi = lokasi.id_gudang_detail LEFT JOIN db_mercedes_sp.gudang_detail AS binbox ON db_mercedes_sp.penjualan.nomor_binbox = binbox.id_gudang_detail LEFT JOIN db_mercedes_sp.gudang_detail AS baris ON db_mercedes_sp.penjualan.baris = baris.id_gudang_detail LEFT JOIN db_mercedes_sp.gudang_detail AS kolom ON db_mercedes_sp.penjualan.kolom = kolom.id_gudang_detail LEFT JOIN db_mercedes_sp.gudang_detail AS rak ON db_mercedes_sp.penjualan.rak = rak.id_gudang_detail WHERE db_mercedes_sp.penjualan.kode_item = '" . $Kode_item . "' ");
    return $data->result();
}

/* Load semua data inbound by lokasi dan kode item */
function mercedes_sp_all_inbound_by_lokasi($kode_item, $kode_gudang, $lokasi, $rak, $kolom, $baris, $nomor_binbox)
{
    $ci = &get_instance();
    $data = $ci->db_mercedes_sp->query("SELECT item_masuk.no_po, item_masuk_detail.kode_item, item_masuk_detail.total_item_item_masuk, item_masuk.tanggal_item_masuk, pesanan_pembelian.tanggal AS tanggal_po, gudang.nama_gudang, lokasi.lokasi, rak.rak, kolom.kolom, baris.baris, binbox.nomor_binbox, pesanan_pembelian.id_pesanan_pembelian, item_masuk_detail.admin, item_masuk.total_price_variance FROM item_masuk LEFT JOIN item_masuk_detail ON item_masuk.id_item_masuk = item_masuk_detail.id_item_masuk LEFT JOIN pesanan_pembelian ON item_masuk.no_po = pesanan_pembelian.no_po LEFT JOIN gudang ON item_masuk_detail.kode_gudang = gudang.kode_gudang LEFT JOIN gudang_detail AS lokasi ON item_masuk_detail.lokasi = lokasi.id_gudang_detail LEFT JOIN gudang_detail AS rak ON item_masuk_detail.rak = rak.id_gudang_detail LEFT JOIN gudang_detail AS kolom ON item_masuk_detail.kolom = kolom.id_gudang_detail LEFT JOIN gudang_detail AS baris ON item_masuk_detail.baris = baris.id_gudang_detail LEFT JOIN gudang_detail AS binbox ON item_masuk_detail.nomor_binbox = binbox.id_gudang_detail WHERE item_masuk_detail.kode_item = '" . $kode_item . "' AND item_masuk_detail.kode_gudang = '" . $kode_gudang . "' AND item_masuk_detail.lokasi = '" . $lokasi . "' AND item_masuk_detail.rak = '" . $rak . "' AND item_masuk_detail.kolom = '" . $kolom . "' AND item_masuk_detail.baris = '" . $baris . "' AND item_masuk_detail.nomor_binbox = '" . $nomor_binbox . "'");
    return $data->result();
}

/* Load penjualan part wo by kode item dan lokasi */
function mercedes_sp_penjualan_part_wo_by_lokasi($kode_item, $kode_gudang, $lokasi, $rak, $kolom, $baris, $nomor_binbox)
{
    $ci = &get_instance();
    $data = $ci->db_mercedes_sp->query("SELECT db_mercedes_as.work_order.no_wo, db_mercedes_as.wo_detail_part.qty, db_mercedes_as.wo_detail_part.kode_item, db_mercedes_sp.stok_item.kode_item, db_mercedes_sp.gudang.nama_gudang, lokasi.lokasi, binbox.nomor_binbox, baris.baris, kolom.kolom, rak.rak FROM db_mercedes_as.work_order LEFT JOIN db_mercedes_as.wo_detail_part ON db_mercedes_as.work_order.no_wo = db_mercedes_as.wo_detail_part.no_wo LEFT JOIN db_mercedes_sp.stok_item ON db_mercedes_as.wo_detail_part.id_stock = db_mercedes_sp.stok_item.id_stock AND db_mercedes_as.wo_detail_part.kode_item = db_mercedes_sp.stok_item.kode_item LEFT JOIN db_mercedes_sp.gudang ON db_mercedes_sp.stok_item.kode_gudang = db_mercedes_sp.gudang.kode_gudang LEFT JOIN db_mercedes_sp.gudang_detail AS lokasi ON db_mercedes_sp.stok_item.lokasi = lokasi.id_gudang_detail LEFT JOIN db_mercedes_sp.gudang_detail AS binbox ON db_mercedes_sp.stok_item.nomor_binbox = binbox.id_gudang_detail LEFT JOIN db_mercedes_sp.gudang_detail AS baris ON db_mercedes_sp.stok_item.baris = baris.id_gudang_detail LEFT JOIN db_mercedes_sp.gudang_detail AS kolom ON db_mercedes_sp.stok_item.kolom = kolom.id_gudang_detail LEFT JOIN db_mercedes_sp.gudang_detail AS rak ON db_mercedes_sp.stok_item.rak = rak.id_gudang_detail WHERE db_mercedes_as.wo_detail_part.s_request = '2' AND db_mercedes_as.wo_detail_part.del = '0' AND db_mercedes_sp.stok_item.kode_item = '" . $kode_item . "' AND db_mercedes_sp.stok_item.kode_gudang = '" . $kode_gudang . "' AND db_mercedes_sp.stok_item.lokasi = '" . $lokasi . "' AND db_mercedes_sp.stok_item.rak = '" . $rak . "' AND db_mercedes_sp.stok_item.kolom = '" . $kolom . "' AND db_mercedes_sp.stok_item.baris = '" . $baris . "' AND db_mercedes_sp.stok_item.nomor_binbox = '" . $nomor_binbox . "' ");
    return $data->result();
}

/* load penjualan part counter by kode item dan lokasi */
function mercedes_sp_penjualan_part_counter_by_lokasi($kode_item, $kode_gudang, $lokasi, $rak, $kolom, $baris, $nomor_binbox)
{
    $ci = &get_instance();
    $data = $ci->db_mercedes_sp->query("SELECT db_mercedes_sp.pesanan_penjualan.no_transaksi, db_mercedes_sp.pesanan_penjualan.admin, db_mercedes_sp.penjualan.kode_item, db_mercedes_sp.penjualan.qty, db_mercedes_as.invoice_after_sales.no_invoice, db_mercedes_sp.pesanan_penjualan.tgl AS tanggal_ro FROM db_mercedes_sp.pesanan_penjualan LEFT JOIN db_mercedes_sp.penjualan ON db_mercedes_sp.pesanan_penjualan.id_pesanan_penjualan = db_mercedes_sp.penjualan.id_pesanan_penjualan LEFT JOIN db_mercedes_as.invoice_after_sales ON db_mercedes_sp.pesanan_penjualan.no_transaksi = db_mercedes_as.invoice_after_sales.no_ref WHERE db_mercedes_sp.penjualan.kode_item = '" . $kode_item . "' AND db_mercedes_sp.penjualan.kode_gudang = '" . $kode_gudang . "' AND db_mercedes_sp.penjualan.lokasi = '" . $lokasi . "' AND db_mercedes_sp.penjualan.rak = '" . $rak . "' AND db_mercedes_sp.penjualan.kolom = '" . $kolom . "' AND db_mercedes_sp.penjualan.baris = '" . $baris . "' AND db_mercedes_sp.penjualan.nomor_binbox = '" . $nomor_binbox . "' ");
    return $data->result();
}

/* Load data qty saat ini */
function mercedes_sp_qty_stock($kode_item)
{
    $inbound[] = 0;
    foreach (mercedes_sp_all_inbound($kode_item) as $row) {
        $inbound[] = $row->total_item_item_masuk;
    }
    $penjualan_part_wo[] = 0;
    foreach (mercedes_sp_penjualan_part_wo($kode_item) as $row) {
        $penjualan_part_wo[] = $row->qty;
    }
    $penjualan_part_counter[] = 0;
    foreach (mercedes_sp_penjualan_part_counter($kode_item) as $row) {
        $penjualan_part_counter[] = $row->qty;
    }
    $count_qty_inbound = array_sum($inbound);
    $count_qty_part_wo = array_sum($penjualan_part_wo);
    $count_qty_part_counter = array_sum($penjualan_part_counter);
    $total_stock = $count_qty_inbound - ($count_qty_part_counter + $count_qty_part_wo);
    return $total_stock;
}

/* Report Penjualan part counter */


/* --------------------------- Open |  Service Operasional -------------------------- */









//     return $data->result();
// }











/* ---------------------- Closed | Service Operasional ---------------------- */
