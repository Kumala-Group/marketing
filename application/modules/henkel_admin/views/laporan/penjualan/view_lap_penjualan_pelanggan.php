<table  class="table fpTable lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Kode Pelanggan</th>
            <th class="center">Kode Item</th>
            <th class="center">Nama Item</th>
            <th class="center">Tipe</th>
            <th class="center">Jumlah</th>
            <th class="center">Harga</th>
            <!--<th class="center">Detail</th>-->
        </tr>
    </thead>
    <tbody>
<?php
		$i=1;
    $total_akhir_f=0;
		    foreach($data->result() as $dt){
          $harga = $dt->total_item_item_masuk*$dt->harga_tebus_dpp;
          $total_akhir_f+=$harga;
		    ?>
        <tr>
        	<td class="center span1"><?php echo $i++?></td>
          <td class="center"><?php echo $dt->kode_pelanggan;?></td>
          <td class="center"><?php echo $dt->kode_item;?></td>
          <td class="center"><?php echo $dt->nama_item;?></td>
          <td class="center"><?php echo $dt->tipe;?></td>
          <td class="center"><?php echo $dt->total_item_item_masuk;?></td>
          <td class="center"><?php echo 'Rp. '.separator_harga2($harga);?></td>
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
