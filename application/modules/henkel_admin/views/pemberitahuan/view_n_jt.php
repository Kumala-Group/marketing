<div class="row-fluid">
<div class="table-header">
    <?php echo $judul;?>
    <div class="widget-toolbar no-border pull-right">
    </div>
</div>

<table  class="table fpTable lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">No. Transaksi</th>
            <th class="center">Kode Pelanggan</th>
            <th class="center">Nama Pelanggan</th>
            <th class="center">Tanggal</th>
            <th class="center">Tanggal Jatuh Tempo</th>
            <th class="center">Sisa (Hari)</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>
    <tbody>
    	<?php
		//$data = $this->model_data->data_mk();
		$i=1;
		foreach($data->result() as $dt){
		?>
        <tr>
        	<td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->no_transaksi;?></td>
            <td class="center"><?php echo $dt->kode_pelanggan;?></td>
            <td class="center"><?php echo $dt->nama_pelanggan;?></td>
            <td class="center"><?php echo tgl_sql($dt->tgl);?></td>
            <td class="center"><?php echo tgl_sql($dt->tgl_jt);?></td>
            <?php
              if (date("Y-m-d") >= $dt->tgl_jt) {
                echo "<td class='center'><span class='label label-danger'>Kadaluarsa</span></td>";
              } else {
                echo "<td class='center'>$dt->sisa</td>";
              }
            ?>
            <td class="td-actions"><center>
            	<div class="hidden-phone visible-desktop action-buttons">

                    <a class="red" href="<?php echo site_url();?>henkel_adm_n_jt/hapus/<?php echo $dt->id;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
                        <i class="icon-trash bigger-130"></i>
                    </a>
                </div>

                <div class="hidden-desktop visible-phone">
                    <div class="inline position-relative">
                        <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-caret-down icon-only bigger-120"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-icon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
                            <li>
                                <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
                                    <span class="green">
                                        <i class="icon-edit bigger-120"></i>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                                    <span class="red">
                                        <i class="icon-trash bigger-120"></i>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                </center>
            </td>
        </tr>
		<?php } ?>
    </tbody>
</table>
</div>
