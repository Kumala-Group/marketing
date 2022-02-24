<script type="text/javascript">
    function separator_harga2(ID){
      var bilangan  = ID;
      var reverse = bilangan.toString().split('').reverse().join(''),
      ribuan  = reverse.match(/\d{1,3}/g);
      ribuan  = ribuan.join('.').split('').reverse().join('');
      return ribuan;
    }
</script>
<div class="row-fluid">
<div class="table-header">
    <?php echo $judul;?>
</div>
<table class="table fpTable lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">No PO</th>
            <th class="center">Tanggal</th>
            <th class="center">Nama Supplier</th>
            <th class="center">Keterangan</th>
            <th class="center">Status Order</th>
            <th class="center">Total Akhir</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $i=1;
        foreach($data->result() as $dt){ ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->no_po;?></td>
            <td class="center"><?php echo tgl_sql($dt->tanggal);?></td>
            <td class="center"><?php echo $dt->nama_supplier;?></td>
            <td class="center"><?php echo $dt->keterangan;?></td>
            <?php if ($dt->total_item==0) { ?>
            <td class="center"><?php echo 'Selesai';?></td>
            <?php } else { ?>
            <td class="center"><?php echo '-'.$dt->total_item;?></td>
            <?php } ?>
            <td class="center"><?php echo 'Rp. '.separator_harga2($dt->total_akhir);?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="<?php echo site_url();?>henkel_adm_pesanan_pembelian/edit/<?php echo $dt->id_pesanan_pembelian;?>">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a class="red" href="<?php echo site_url();?>henkel_adm_pesanan_pembelian/hapus/<?php echo $dt->id_pesanan_pembelian;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
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
