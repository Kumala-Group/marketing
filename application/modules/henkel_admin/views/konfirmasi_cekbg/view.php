<script type="text/javascript">
$(document).ready(function(){
  
  $('.date-picker').datepicker();

  $("body").on("click", ".delete", function (e) {
      $(this).parent("div").remove();
  });

   $("#simpan").click(function(){
            var tanggal_cair = $("#tanggal_cair").val();
            var status = $("#status").val();

            var string = $("#my-form").serialize();

            if(tanggal_cair.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Tanggal Cair tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#tanggal_cair").focus();
                return false();
            }

            if(status.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Status tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#status").focus();
                return false();
            }

            var r = confirm("Anda sudah yakin? Data yang sudah disimpan tidak dapat diubah lagi");
            if (r == true) {
              $.ajax({
                  type    : 'POST',
                  url     : "<?php echo site_url(); ?>henkel_adm_piutang/simpan_exception",
                  data    : string,
                  cache   : false,
                  success : function(data){
                      alert(data);
                      location.reload();
                  }
              });
            } else {
              return false();
            } 
        });

    //datatables
    /*$("#show_per_hari").click(function(){
        var hari= $("#hari").val();
        $.ajax({
          type  : "GET",
          url   : "<?php echo site_url();?>oli_adm_dev_datatable/pes_penj_per_hr",
          data  : "hari="+hari,
          start   : $("#show_per_hari").html('...Sedang diproses...'),
          dataType: "json",
          success : function(data){
                    $("#show_per_hari").html('<i class="icon-check"></i> Lihat');
                    table = $('#show_daftar').DataTable({
                    "bProcessing": true,
                    "bDestroy": true,
                    "sAjaxSource": '<?php echo site_url();?>oli_adm_dev_datatable/pes_penj_per_hr?hari='+hari,
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
      });*/

    $("#new").click(function(){
      var id= $("#id_pes").val();
      $.ajax({
          type    : 'POST',
          url     : "<?php echo site_url(); ?>oli_adm_dev_pesanan_penjualan/baru",
          data    : "id_new="+id,
          success : function(data){
            location.replace("<?php echo site_url(); ?>oli_adm_dev_pesanan_penjualan/tambah");
          }
      });

    });
});

function editData(ID){
    var cari    = ID;
    console.log(cari);
    $.ajax({
        type    : "GET",
        url     : "<?php echo site_url(); ?>henkel_adm_piutang/cari_exception",
        data    : "cari="+cari,
        dataType: "json",
        success : function(data){
            var tanggal_cair='';
            $("#simpan").html('<i class="icon-save"></i> Simpan');
            $('#id_piutang_exception_pembayaran').val(data.id_piutang_exception_pembayaran);
            $('#no_transaksi').val(data.no_transaksi);
            $('#tanggal_bayar').val(data.tanggal_bayar);
            $('#bayar').val(data.janji_bayar);
            if (data.tanggal_cair=='0000-00-00') {
              $('#tanggal_cair').val();
            } else {
              $('#tanggal_cair').val(data.tanggal_cair).prop('disabled', true);;
            }
            
            if (data.status=='0') {
              $('#status').val();
            } else {
              $('#status').val(data.status).prop('disabled', true);;  
            }
            
          }
    });
}
</script>
<div class="row-fluid">
<div class="table-header">
    <?php echo $judul;?>
    <div class="widget-toolbar no-border pull-right">
    </div>
</div>
<div class="space"></div>
<div class="control-group">
    <!--<div class="controls">
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
    </div>-->
</div>
<br />
<table class="table fpTable lcnp table-striped table-bordered table-hover" id="show_daftar">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">No Transaksi</th>
            <th class="center">Tanggal Bayar</th>
            <th class="center">Janji Bayar (Rp)</th>
            <th class="center">Tanggal Cair</th>
            <th class="center">Status</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $i=1;
        $tanggal_cair='';
        $status='';
        foreach($data->result() as $dt){
       ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->no_transaksi;?></td>
            <td class="center"><?php echo tgl_sql($dt->tanggal_bayar);?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($dt->bayar);?></td>
            <?if ($dt->tanggal_cair=='0000-00-00') {
              $tanggal_cair = "<span class='label label-danger'>Belum Di Konfirmasi</span>";
            } else {
              $tanggal_cair = $dt->tanggal_cair;
            }?>
            <td class="center"><?php echo $tanggal_cair;?></td>
            <?if ($dt->status==0) {
              $status = "<span class='label label-danger'>Belum Di Konfirmasi</span>";
            } else {
              $status = "<span class='label label-success'>Selesai</span>";
            }?>
            <td class="center"><?php echo $status;?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                  <?php if ($dt->status==0) { ?>
                    <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_piutang_exception_pembayaran;?>')" data-toggle="modal">
                      <i class="icon-pencil"></i>
                        <!--<i class="icon-pencil bigger-130"></i>-->
                    </a>
            <?php } else { ?>
                    <a class="red" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_piutang_exception_pembayaran;?>')" data-toggle="modal">
                      <i class="icon-check"></i>
                        <!--<i class="icon-pencil bigger-130"></i>-->
                    </a>
            <?php } ?>
                    <!--<a class="red" href="<?php echo site_url();?>oli_adm_dev_pesanan_penjualan/hapus/<?php echo $dt->id_pesanan_penjualan;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
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

 <div id="modal-table" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Item
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
              <input type="hidden" name="id_piutang_exception_pembayaran" id="id_piutang_exception_pembayaran" />
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">No Transaksi</label>

                    <div class="controls">
                        <input type="text" name="no_transaksi" id="no_transaksi"  readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Tanggal Bayar</label>

                    <div class="controls">
                        <input type="text" name="tanggal_bayar" id="tanggal_bayar"  readonly="readonly"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Janji Bayar (Rp)</label>

                    <div class="controls">
                        <input type="text" name="bayar" id="bayar"  readonly="readonly"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Tanggal Cair</label>

                    <div class="controls">
                        <input type="text" name="tanggal_cair" id="tanggal_cair" class="date-picker" data-date-format="dd-mm-yyyy"/><span class="required"> *</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Status</label>

                    <div class="controls">
                        <select id="status" name="status">
                          <option value="0"></option>
                          <option value="1">Konfirmasi</option>
                        </select>
                        <span class="required"> *</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-footer">
        <div class="pagination pull-right no-margin">
        <button type="button" class="btn btn-small btn-danger pull-left" data-dismiss="modal">
            <i class="icon-remove"></i>
            Close
        </button>
        <button type="button" name="simpan" id="simpan" class="btn btn-small btn-success pull-left">
            <i class="icon-save"></i>
            Simpan
        </button>
        </div>
    </div>
</div>
