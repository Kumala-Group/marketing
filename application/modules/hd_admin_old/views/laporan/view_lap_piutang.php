<table  class="table fpTable lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Tanggal</th>
            <th class="center">No. Transaksi</th>
            <th class="center">Kode Pelanggan</th>
            <th class="center">Nama Pelanggan</th>
            <th class="center">Sisa</th>
            <th class="center">Status</th>
            <th class="center">Keterangan</th>
        </tr>
    </thead>
    <tbody>
    	<?php
		$i=1;
		foreach($data->result() as $dt){
		?>
        <tr>
        	<td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo tgl_sql($dt->tgl);?></td>
            <td class="center"><?php echo $dt->no_transaksi;?></td>
            <td class="center"><?php echo $dt->kode_pelanggan;?></td>
            <td class="center"><?php echo $dt->nama_pelanggan;?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga($dt->sisa_o);?></td>
            <td class="center"><?php echo $dt->status; ?></td>
            <td ><?php echo $dt->keterangan;?></td>
        </tr>
		<?php } ?>
    </tbody>
</table>
