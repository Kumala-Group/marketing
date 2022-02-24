<script type="text/javascript">
$(document).ready(function(){
    $("body").on("click", ".delete", function (e) {
        $(this).parent("div").remove();
    });

    $("#new").click(function(){
      var id=$("#id_ret").val();
      $.ajax({
          type    : 'POST',
          url     : "<?php echo site_url(); ?>henkel_adm_retur_pembelian/baru",
          data    : "id_new="+id,
          success : function(data){
            location.replace("<?php echo site_url(); ?>henkel_adm_retur_pembelian/tambah");
          }
      });

    });
});


</script>
<div class="row-fluid">
<div class="table-header">
    <?php echo $judul;?>
    <div class="widget-toolbar no-border pull-right">
      <button type="button" name="new" id="new" class="btn btn-small btn-success">
          <i class="icon-check"></i>
          Tambah Data
      </button>
      <input type="hidden" value="<?php echo $id_pes;?>" name="id_pes" id="id_pes">
    </div>
</div>

<table class="table fpTable lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">No Retur</th>
            <th class="center">Tanggal</th>
            <th class="center">Kode Supplier</th>
            <th class="center">Nama Supplier</th>
            <th class="center">Total</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $i=1;
        foreach($data->result() as $dt){
       ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->no_retur;?></td>
            <td class="center"><?php echo tgl_sql($dt->tanggal);?></td>
            <td class="center"><?php echo $dt->kode_supplier;?></td>
            <td class="center"><?php echo $dt->nama_supplier;?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($dt->total_retur);?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="<?php echo site_url();?>henkel_adm_retur_pembelian/edit/<?php echo $dt->id_retur_pembelian;?>">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a class="red" href="<?php echo site_url();?>henkel_adm_retur_pembelian/hapus/<?php echo $dt->id_retur_pembelian;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
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
