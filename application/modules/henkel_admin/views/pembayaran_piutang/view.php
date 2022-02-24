<script type="text/javascript">
$(document).ready(function(){
    $("body").on("click", ".delete", function (e) {
        $(this).parent("div").remove();
    });

    $("#new").click(function(){
      var id= $("#id_pes").val();
      $.ajax({
          type    : 'POST',
          url     : "<?php echo site_url(); ?>henkel_adm_pembayaran_piutang/baru",
          data    : "id_new="+id,
          success : function(data){
            location.replace("<?php echo site_url(); ?>henkel_adm_pembayaran_piutang/tambah");
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
      <input type="hidden" value="<?php echo $id_piutang;?>" name="id_pes" id="id_pes">
    </div>
</div>

<table class="table fpTable lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">No Transaksi</th>
            <th class="center">Tanggal</th>
            <th class="center">No Invoice</th>
            <th class="center">Kode Pelanggan</th>
            <th class="center">Pelanggan</th>
            <th class="center">Total Piutang</th>
            <th class="center">Terbayar</th>
            <th class="center">Sisa</th>
            <th class="center">Keterangan</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $i=1;
        foreach($data->result() as $dt){
          $q= $this->db_kpp->query("SELECT SUM(bayar) as total_bayar FROM piutang WHERE id_pembayaran_piutang='$dt->id_pembayaran_piutang'");
          foreach($q->result() as $dt_b){
            $total_bayar=(int)$dt_b->total_bayar;
          }
       ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->no_piutang;?></td>
            <td class="center"><?php echo tgl_sql($dt->tanggal);?></td>
            <td class="center"><?php echo $dt->no_transaksi;?></td>
            <td class="center"><?php echo $dt->kode_pelanggan;?></td>
            <td class="center"><?php echo $dt->nama_pelanggan;?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($dt->sisa);?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($dt->bayar);?></td>
            <?php if($dt->total_sisa==0) { ?>
            <td class="center"><span class='label label-success'>Lunas</span></td>
            <?php } else { ?>
            <td class="center"><?php echo 'Rp. '.separator_harga2($dt->total_sisa);?></td>
            <?php } ?>
            <td class="center"><?php echo $dt->keterangan;?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="<?php echo site_url();?>henkel_adm_pembayaran_piutang/edit/<?php echo $dt->id_pembayaran_piutang;?>">
                        <i class="icon-eye-open"></i>
                    </a>

                    <!--<a class="red" href="<?php echo site_url();?>henkel_adm_pembayaran_piutang/hapus/<?php echo $dt->id_pembayaran_piutang;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
                        <i class="icon-trash bigger-130"></i>
                    </a>-->
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
