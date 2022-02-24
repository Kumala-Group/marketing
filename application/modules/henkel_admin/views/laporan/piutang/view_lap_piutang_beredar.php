
<table  class="table fpTable lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Tanggal Transaksi</th>
            <th class="center">No. Transaksi</th>
            <th class="center">Kode Pelanggan</th>
            <th class="center">Jumlah Item</th>
            <th class="center">Total Akhir</th>
            <th class="center">Terbayar</th>
            <th class="center">Sisa</th>
        </tr>
    </thead>
    <tbody>
<?php
		$i=1;
    $total_akhir_f=0;
		    foreach($data->result() as $dt){
          $terbayar = $dt->total_akhir - $dt->sisa_o;
          $total_akhir_f += $dt->sisa_o;
		?>
        <tr>
        	<td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo tgl_sql($dt->tgl);?></td>
            <td class="center"><a href="<?php echo site_url();?>henkel_adm_pesanan_penjualan/edit/<?php echo $dt->id_pesanan_penjualan;?>"><?php echo $dt->no_transaksi;?></a></td>
            <td class="center"><?php echo $dt->kode_pelanggan;?></td>
            <td class="center"><?php echo $dt->total_item;?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($dt->total_akhir);?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($terbayar);?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($dt->sisa_o);?></td>
        </tr>
		<?php } ?>
    </tbody>
</table>
<div class="span4">
      <div class="control-group">
          <label class="control-label" for="form-field-1">Total Akhir</label>
          <div class="controls total_harga">
            <input type="text" style="text-align: left;" name="total_akhir_f" id="total_akhir_f" value="Rp. <?php echo separator_harga2($total_akhir_f); ?>" placeholder="0"  readonly="readonly"/>
          </div>
     </div>
</div>
