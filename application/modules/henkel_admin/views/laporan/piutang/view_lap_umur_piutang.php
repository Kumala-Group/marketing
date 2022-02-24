<table class="table fpTable lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Tanggal Transaksi</th>
            <th class="center">No. Transaksi</th>
            <th class="center">Kode Pelnggan</th>
            <th class="center">Jatuh Tempo</th>
            <th class="center">Umur Piutang</th>
            <th class="center">1-15 Hari</th>
            <th class="center">16-30 Hari</th>
            <th class="center">31-45 Hari</th>
            <th class="center">46-60 Hari</th>
            <th class="center">61-90 Hari</th>
            <th class="center">> 90 Hari</th>
        </tr>
    </thead>
    <tbody>
<?php
		$i=1;
    $total_akhir_f=0;
    $_15=0;
    $_30=0;
    $_45=0;
    $_60=0;
    $_90=0;
    $__90=0;
		    foreach($data->result() as $dt){
          $terbayar = $dt->total_akhir - $dt->sisa_o;
          $total_akhir_f += $dt->sisa_o;
          $total_akhir_o = $dt->sisa_o;
          $jt=$dt->jt;
          $tgl_jt = strtotime($dt->tgl);
    			$date = date('Y-m-d', strtotime('+'.$jt.' day', $tgl_jt));

          $datetime1 = new DateTime($date);
          $datetime2 = new DateTime(date('Y-m-d'));
          $interval = $datetime1->diff($datetime2);
          $umur_piutang_total = $interval->format('%a Hari');
          $hitung_umur = $interval->format('%a');
		?>
        <tr>
        	<td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo tgl_sql($dt->tgl);?></td>
            <td class="center"><a href="<?php echo site_url();?>henkel_adm_pesanan_penjualan/edit/<?php echo $dt->id_pesanan_penjualan;?>"><?php echo $dt->no_transaksi;?></a></td>
            <td class="center"><?php echo $dt->kode_pelanggan;?></td>
            <td class="center"><?php echo tgl_sql($date);?></td>
            <td class="center"><?php echo $umur_piutang_total;?></td>
            <?php  if ($hitung_umur<=15) { $_15+=$total_akhir_o; ?> <td class="center"><?php echo 'Rp. '.separator_harga2($dt->sisa_o);?></td>
            <?php   } else { ?> <td class="center"><?php echo 'Rp. 0';?></td> <?php } ?>
            <?php  if ($hitung_umur>15 && $hitung_umur<=30) { $_30+=$total_akhir_o; ?> <td class="center"><?php echo 'Rp. '.separator_harga2($dt->sisa_o);?></td>
            <?php   } else { ?> <td class="center"><?php echo 'Rp. 0';?></td> <?php } ?>
            <?php  if ($hitung_umur>31 && $hitung_umur<=45) { $_45+=$total_akhir_o; ?> <td class="center"><?php echo 'Rp. '.separator_harga2($dt->sisa_o);?></td>
            <?php   } else { ?> <td class="center"><?php echo 'Rp. 0';?></td> <?php } ?>
            <?php  if ($hitung_umur>46 && $hitung_umur<=60) { $_60+=$total_akhir_o; ?> <td class="center"><?php echo 'Rp. '.separator_harga2($dt->sisa_o);?></td>
            <?php   } else { ?> <td class="center"><?php echo 'Rp. 0';?></td> <?php } ?>
            <?php  if ($hitung_umur>61 && $hitung_umur<=90) { $_90+=$total_akhir_o; ?> <td class="center"><?php echo 'Rp. '.separator_harga2($dt->sisa_o);?></td>
            <?php   } else { ?> <td class="center"><?php echo 'Rp. 0';?></td> <?php } ?>
            <?php  if ($hitung_umur>90) { $__90+=$total_akhir_o; ?> <td class="center"><?php echo 'Rp. '.separator_harga2($dt->sisa_o);?></td>
            <?php   } else { ?> <td class="center"><?php echo 'Rp. 0';?></td> <?php } ?>
        </tr>
		<?php } ?>
    </tbody>
</table>
<table class="table fpTable lcnp table-striped table-bordered table-hover">
  <tr>
    <td class="center">Total Umur Piutang 1-15 hari</td>
    <td class="center"><?php echo 'Rp. '.separator_harga2($_15); ?></td>
  </tr>
  <tr>
    <td class="center">Total Umur Piutang 16-30 hari</td>
    <td class="center"><?php echo 'Rp. '.separator_harga2($_30); ?></td>
  </tr>
  <tr>
    <td class="center">Total Umur Piutang 31-45 hari</td>
    <td class="center"><?php echo 'Rp. '.separator_harga2($_45); ?></td>
  </tr>
  <tr>
    <td class="center">Total Umur Piutang 46-60 hari</td>
    <td class="center"><?php echo 'Rp. '.separator_harga2($_60); ?></td>
  </tr>
  <tr>
    <td class="center">Total Umur Piutang 61-90 hari</td>
    <td class="center"><?php echo 'Rp. '.separator_harga2($_90); ?></td>
  </tr>
  <tr>
    <td class="center">Total Umur Piutang > 90 hari</td>
    <td class="center"><?php echo 'Rp. '.separator_harga2($__90); ?></td>
  </tr>
  <tr>
    <td class="center">Total Akhir</td>
    <td class="center"><?php echo 'Rp. '.separator_harga2($total_akhir_f); ?></td>
  </tr>
</table>
