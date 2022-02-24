<script type="text/javascript">
$(document).ready(function(){
  $('.date-picker').datepicker().next().on(ace.click_event, function(){
    $(this).prev().focus();
  });
    $("body").on("click", ".delete", function (e) {
        $(this).parent("div").remove();
    });

    //datatables
    $("#show_per_hari").click(function(){
        var hari= $("#hari").val();
        $.ajax({
          type	: "GET",
          url		: "<?php echo site_url();?>henkel_adm_datatable/pes_penj_per_hr",
          data	: "hari="+hari,
          start   : $("#show_per_hari").html('...Sedang diproses...'),
          dataType: "json",
          success	: function(data){
                    $("#show_per_hari").html('<i class="icon-check"></i> Lihat');
                    table = $('#show_daftar').DataTable({
                    "bProcessing": true,
                    "bDestroy": true,
                    "sAjaxSource": '<?php echo site_url();?>henkel_adm_datatable/pes_penj_per_hr?hari='+hari,
                    "bSort": true,
                     "bAutoWidth": true,
                    "iDisplayLength": 10, "aLengthMenu": [10,20,40,80], // can be removed for basic 10 items per page
                    "sPaginationType": "full_numbers",
                    "aoColumnDefs": [{"bSortable": false,
                                     "aTargets": [ -1 , 0]}], //Feature control DataTables' server-side processing mode.
                    "aoColumns": [
                      {"mData" : "no"},
                      {"mData" : "no_transaksi"},
                      {"mData" : "tgl"},
                      {"mData" : "kode_pelanggan"},
                      {"mData" : "nama_pelanggan"},
                      {"mData" : "kode_sales"},
                      {"mData" : "jt"},
                      {"mData" : "aksi"}
                    ]
                });
          }
        });
      });

    $("#new").click(function(){
      var id= $("#id_pes").val();
      $.ajax({
          type    : 'POST',
          url     : "<?php echo site_url(); ?>henkel_adm_pesanan_penjualan/baru",
          data    : "id_new="+id,
          success : function(data){
            location.replace("<?php echo site_url(); ?>henkel_adm_pesanan_penjualan/tambah");
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
<div class="space"></div>
<div class="control-group">
    <div class="controls">
      <select name="hari" id="hari" style="float:left;">
        <option value="" selected="selected">--All--</option>
        <option value="3"> 3 Hari </option>
        <option value="7"> 7 Hari </option>
        <option value="30"> 30 Hari </option>
        <option value="60"> 60 Hari </option>
      </select>&nbsp;
       <button type="button" name="show_per_hari" id="show_per_hari" class="btn btn-small btn-info">
           <i class="icon-check"></i>
           Lihat
       </button>
    </div>
</div>
<br />
<table class="table fpTable lcnp table-striped table-bordered table-hover" id="show_daftar">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">No Transaksi</th>
            <th class="center">Tanggal</th>
            <th class="center">Kode Pelanggan</th>
            <th class="center">Nama Pelanggan</th>
            <th class="center">Kode Sales</th>
            <th class="center">Jt</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $i=1;
        foreach($data->result() as $dt){
          $jt = $dt->jt;
    			$tgl_jt = strtotime($dt->tgl);
    			$date = date('Y-m-j', strtotime('+'.$jt.' day', $tgl_jt));
          /*$sisa=$dt->sisa_a;*/
       ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->no_transaksi;?></td>
            <td class="center"><?php echo tgl_sql($dt->tgl);?></td>
            <td class="center"><?php echo $dt->kode_pelanggan;?></td>
            <td class="center"><?php echo $dt->nama_pelanggan;?></td>
            <td class="center"><?php echo $dt->kode_sales;?></td>
            <td class="center"><?php echo tgl_sql($date);?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="<?php echo site_url();?>henkel_adm_pesanan_penjualan/edit/<?php echo $dt->id_pesanan_penjualan;?>">
                      <i class="icon-eye-open"></i>
                        <!--<i class="icon-pencil bigger-130"></i>-->
                    </a>

                    <!--<a class="red" href="<?php echo site_url();?>henkel_adm_pesanan_penjualan/hapus/<?php echo $dt->id_pesanan_penjualan;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
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
