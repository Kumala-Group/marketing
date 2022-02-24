<script type="text/javascript">
$(document).ready(function(){
    $("#tambah").click(function(){
          $("#modal-table").modal('show');
    });

    $("#cetak_data_stok").click(function(){

            var stok_item = $("#stok_item").val();
            var string = $("#my-form").serialize();
            
            window.open("<?php echo site_url(); ?>henkel_adm_stok_item/cetak_data_stok?stok_item="+stok_item);
        });
});


</script>
<div class="row-fluid">
<div class="table-header">
    <?php echo $judul;?>
    <div class="widget-toolbar no-border pull-right">
    <a data-toggle="modal" name="tambah" id="tambah" class="btn btn-small btn-success">
       <i class="icon-print"></i>
       Cetak Data Stok
   </a>
        <!--<a href="<?php echo site_url();?>henkel_adm_stok_item/cetak_data_stok" class="btn btn-small btn-success"  role="button" data-toggle="modal" name="cetak" id="cetak">
          <i class="icon-print"></i>
          Cetak Data Stok
        </a>-->
      <a href="<?php echo site_url();?>henkel_adm_stok_item/cetak_kartu_stok" class="btn btn-small btn-success"  role="button" data-toggle="modal" name="cetak" id="cetak">
          <i class="icon-print"></i>
          Cetak Kartu Stok
      </a>
    </div>
</div>

<table class="table fpTable lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Kode Item</th>
            <th class="center">Nama Item</th>
            <th class="center">Tipe</th>
            <th class="center">Kode Gudang</th>
            <th class="center">Nama Gudang</th>
            <th class="center">Stok</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $i=1;
        foreach($data->result() as $dt){
        ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->kode_item;?></td>
            <td class="center"><?php echo $dt->nama_item;?></td>
            <td class="center"><?php echo $dt->tipe;?></td>
            <td class="center"><?php echo $dt->kode_gudang;?></td>
            <td class="center"><?php echo $dt->nama_gudang;?></td>
            <td class="center"><?php echo $dt->stok;?></td>
        </tr>
        <?php
            }
        ?>
    </tbody>

</table>

<div id="modal-table" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Cetak Stok Item
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Stok Item</label>
                    <div class="controls">
                      <?php ?>
                      <select name="stok_item" id="stok_item">
                        <option value="" selected="selected">--Pilih Stok Item--</option>
                        <option value="HNKL">Henkel</option>
                        <option value="OLI">Oli</option>
                       </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-footer">
        <div class="pagination pull-right no-margin">
        <button type="button" class="btn btn-small btn-danger pull-left" data-dismiss="modal">
            <i class="icon-remove"></i>
            Batal
        </button>
        <button type="button" name="cetak_data_stok" id="cetak_data_stok" class="btn btn-small btn-success pull-left">
            <i class="icon-save"></i>
            Cetak
        </button>
        </div>
    </div>
</div>
</div>
