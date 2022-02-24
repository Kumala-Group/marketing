<table  class="table fpTable lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Tanggal Transaksi</th>
            <th class="center">No. Transaksi</th>
            <th class="center">Kode Pelanggan</th>
        </tr>
    </thead>
    <tbody>
<?php
		$i=1;
		    foreach($data->result() as $dt){
        $no_transaksi = $dt->no_transaksi;
        $get_id_pesanan_penjualan = $this->db_kpp->query("SELECT id_pesanan_penjualan FROM pesanan_penjualan WHERE no_transaksi='$no_transaksi'")->row();
        $id_pesanan_penjualan = $get_id_pesanan_penjualan->id_pesanan_penjualan;
		?>
        <tr>
        	<td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo tgl_sql($dt->tgl);?></td>
            <td class="center"><a href="<?php echo site_url();?>henkel_adm_pesanan_penjualan/edit/<?php echo $id_pesanan_penjualan;?>"><?php echo $dt->no_transaksi;?></a></td>
            <td class="center"><?php echo $dt->kode_pelanggan;?></td>
        </tr>
		<?php } ?>
    </tbody>
</table>
