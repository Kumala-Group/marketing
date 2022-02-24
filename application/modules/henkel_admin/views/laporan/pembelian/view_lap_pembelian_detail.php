<table  class="table fpTable lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Tanggal Invoice</th>
            <th class="center">No. Invoice</th>
            <th class="center">Kode Supplier</th>
        </tr>
    </thead>
    <tbody>
  <?php
		$i=1;
		    foreach($data->result() as $dt){
        $no_invoice = $dt->no_invoice;
        $get_id_item_masuk = $this->db_kpp->query("SELECT id_item_masuk FROM item_masuk WHERE no_invoice='$no_invoice'")->row();
        $id_item_masuk = $get_id_item_masuk->id_item_masuk;
		?>
        <tr>
        	<td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo tgl_sql($dt->tanggal_invoice);?></td>
            <td class="center"><a href="<?php echo site_url();?>henkel_adm_item_masuk/edit/<?php echo $id_item_masuk;?>"><?php echo $dt->no_invoice;?></a></td>
            <td class="center"><?php echo $dt->kode_supplier;?></td>
        </tr>
		<?php } ?>
    </tbody>
</table>
