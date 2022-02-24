<div class="row-fluid">
<div class="table-header">
    <?php echo $judul;?>
    <div class="widget-toolbar no-border pull-right">
    <a href="<?php echo site_url();?>henkel_adm_n_stok_kritis" class="btn btn-small btn-info"  >
        <i class="icon-refresh"></i>
        Refresh
    </a>
    </div>
</div>

<table  class="table fpTable lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Kode Item</th>
            <th class="center">Nama Item</th>
            <th class="center">Kode Gudang</th>
            <th class="center">Nama Gudang</th>
            <th class="center">Stok Kritis</th>
            <th class="center">Sisa Stok</th>
            <th class="center">Tanggal</th>
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
            <td class="center"><?php echo $dt->kode_item;?></td>
            <td ><?php echo $dt->nama_item;?></td>
            <td class="center"><?php echo $dt->kode_gudang;?></td>
            <td ><?php echo $dt->nama_gudang;?></td>
            <td class="center"><?php echo $dt->stock_kritis;?></td>
            <td class="center"><?php echo $dt->stok;?></td>
            <td class="center"><?php echo tgl_sql($dt->tgl);?></td>
            <td class="td-actions"><center>
            	<div class="hidden-phone visible-desktop action-buttons">

                    <a class="red" href="<?php echo site_url();?>henkel_adm_n_stok_kritis/hapus/<?php echo $dt->id;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
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
