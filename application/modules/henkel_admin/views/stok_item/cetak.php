<script type="text/javascript">
$(document).ready(function(){
  $('.date-picker').datepicker({
    format: 'yyyy-mm-dd'
  });

  $("#cari_kode_item").click(function(){
      $("#nama_item").attr("readonly", true);
      var kode_gudang= $("#kode_gudang").val();
      $.ajax({
        type  : "GET",
        url   : "<?php echo site_url();?>henkel_adm_datatable/search_item",
        dataType: "json",
        success : function(data){
                  table = $('#show_item').DataTable({
                  "bProcessing": true,
                  "bDestroy": true,
                  "sAjaxSource": '<?php echo site_url();?>henkel_adm_datatable/search_item',
                  "bSort": false,
                  "bAutoWidth": true,
                  "iDisplayLength": 10, "aLengthMenu": [10,20,40,80], // can be removed for basic 10 items per page
                  "sPaginationType": "full_numbers",
                  "aoColumnDefs": [{"bSortable": false,
                                    "aTargets": [ -1, 0]}], //Feature control DataTables' server-side processing mode.
                  "aoColumns": [
                    {"mData" : "no"},
                    {"mData" : "kode_item"},
                    {"mData" : "nama_item"}
                  ]

              });
              $('#modal-item').modal('show');
        },
        error : function(data){
          alert('Data Item Kosong');
        }
      });
    });

    $('#show_item tbody').on( 'click', 'tr', function () {
        var kode_item=$(this).find('td').eq(1).text();
        var nama_item=$(this).find('td').eq(2).text();
        $("#kode_item").val(kode_item);
        $("#nama_item").val(nama_item);
        $('#modal-item').modal('hide');
    });

    $("#cari_kode_gudang").click(function(){
        $("#nama_gudang").attr("readonly", true);
        var kode_gudang= $("#kode_gudang").val();
        $.ajax({
          type  : "GET",
          url   : "<?php echo site_url();?>henkel_adm_datatable/search_gudang",
          dataType: "json",
          success : function(data){
                    table = $('#show_gudang').DataTable({
                    "bProcessing": true,
                    "bDestroy": true,
                    "sAjaxSource": '<?php echo site_url();?>henkel_adm_datatable/search_gudang',
                    "bSort": false,
                    "bAutoWidth": true,
                    "iDisplayLength": 10, "aLengthMenu": [10,20,40,80], // can be removed for basic 10 items per page
                    "sPaginationType": "full_numbers",
                    "aoColumnDefs": [{"bSortable": false,
                                      "aTargets": [ -1, 0]}], //Feature control DataTables' server-side processing mode.
                    "aoColumns": [
                      {"mData" : "no"},
                      {"mData" : "kode_gudang"},
                      {"mData" : "nama_gudang"}
                    ]

                });
                $('#modal-gudang').modal('show');
          },
          error : function(data){
            alert('Data Item Kosong');
          }
        });
      });

      $('#show_gudang tbody').on( 'click', 'tr', function () {
          var kode_gudang=$(this).find('td').eq(1).text();
          var nama_gudang=$(this).find('td').eq(2).text();
          $("#kode_gudang").val(kode_gudang);
          $("#nama_gudang").val(nama_gudang);
          $('#modal-gudang').modal('hide');
      });

  $("#cetak_pdf").click(function(){
    var tgl_awal = $("#tgl_awal").val();
    var tgl_akhir = $("#tgl_akhir").val();

    if(tgl_awal.length==0){
        $.gritter.add({
            title: 'Peringatan..!!',
            text: 'Tanggal Awal tidak boleh kosong',
            class_name: 'gritter-error'
        });

        $("#tgl_awal").focus();
        return false();
    }
    if(tgl_akhir.length==0){
        $.gritter.add({
            title: 'Peringatan..!!',
            text: 'Tanggal Akhir tidak boleh kosong',
            class_name: 'gritter-error'
        });

        $("#tgl_akhir").focus();
        return false();
    }

    cari_data();
  });

  $("#cetak_excel").click(function(){
    var tgl_awal = $("#tgl_awal").val();
    var tgl_akhir = $("#tgl_akhir").val();
    var id = $("#cetak_pdf").val();

    if(tgl_awal.length==0){
        $.gritter.add({
            title: 'Peringatan..!!',
            text: 'Tanggal Awal tidak boleh kosong',
            class_name: 'gritter-error'
        });

        $("#tgl_awal").focus();
        return false();
    }
    if(tgl_akhir.length==0){
        $.gritter.add({
            title: 'Peringatan..!!',
            text: 'Tanggal Akhir tidak boleh kosong',
            class_name: 'gritter-error'
        });

        $("#tgl_akhir").focus();
        return false();
    }
  });

});

function cari_data(){
  var kode_item = $("#kode_item").val();
  var tgl_awal = $("#tgl_awal").val();
  var tgl_akhir = $("#tgl_akhir").val();
  $.ajax({
    type  : 'POST',
    url   : "<?php echo site_url(); ?>henkel_adm_stok_item/cari_data",
    data  : "kode_item="+kode_item+"&tgl_awal="+tgl_awal+"&tgl_akhir="+tgl_akhir,
    cache : false,
    success : function(data){
      $("#view_detail").html(data);
    }
  });
}

function cetak_data(data){
    var form = document.getElementById('my-form');
    form.action = data;
    form.submit();
}
</script>

<div class="widget-box ">
    <div class="widget-header">
        <h4 class="lighter smaller">
            <i class="icon-book blue"></i>
            <?php echo $judul;?>
        </h4>
    </div>

    <div class="widget-body">
      <div class="widget-main">
            <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form" method="post">
              <div class="row-fluid">
                   <div class="span6">
                           <div class="control-group">
                               <label class="control-label" for="form-field-1">Kode Item</label>
                               <div class="controls">
                                   <input type="text" class="autocomplete" name="kode_item" id="kode_item" readonly/>
                                   <button type="button" name="cari_kode_item" id="cari_kode_item" class="btn btn-small btn-info">
                                     <i class="icon-search"></i>
                                     Cari
                                   </button>
                               </div>
                          </div>
                          <div class="control-group">
                              <label class="control-label" for="form-field-1">Nama Item</label>
                              <div class="controls">
                                  <input type="text" name="nama_item" id="nama_item" readonly/>
                              </div>
                          </div>
                          <!--<div class="control-group">
                              <label class="control-label" for="form-field-1">Kode Gudang</label>
                              <div class="controls">
                                  <input type="text" class="autocomplete" name="kode_gudang" id="kode_gudang" readonly/>
                                  <button type="button" name="cari_kode_gudang" id="cari_kode_gudang" class="btn btn-small btn-info">
                                    <i class="icon-search"></i>
                                    Cari
                                  </button>
                              </div>
                         </div>
                         <div class="control-group">
                             <label class="control-label" for="form-field-1">Nama Gudang</label>
                             <div class="controls">
                                 <input type="text" name="nama_gudang" id="nama_gudang" readonly/>
                             </div>
                         </div>-->
                    </div>
                    <div class="span6">
                      <div class="control-group">
                          <label class="control-label" for="form-field-1">Dari Tanggal</label>
                          <div class="controls">
                              <input type="text" name="tgl_awal" id="tgl_awal" class="date-picker"  data-date-format="dd-mm-yyyy" required />
                          </div>
                      </div>
                      <div class="control-group">
                          <label class="control-label" for="form-field-1">s/d Tanggal</label>
                          <div class="controls">
                              <input type="text" name="tgl_akhir" id="tgl_akhir" class="date-picker"  data-date-format="dd-mm-yyyy" required />
                          </div>
                      </div>
                    </div>
               </div>
              <div class="space"></div>
            <div class="alert alert-success">
            <center>
              <button type="button" name="cetak_pdf" id="cetak_pdf" class="btn btn-mini btn-danger" onclick="cetak_data('<?php echo site_url();?>henkel_adm_stok_item/cetak_kartu_stok')">
                  <i class="fa fa-file-pdf-o"></i> Cetak PDF
              </button>
              <!--<button type="button" name="cetak_excel" id="cetak_excel" class="btn btn-mini btn-success" onclick="cetak_data('<?php echo site_url();?>ban_adm_stok_awal_item/cetak_excel')">
                  <i class="fa fa-file-excel-o"></i> Cetak Excel
              </button>-->
           </center>
           </div>
           </form>
           </div>
           <?php
        echo  $this->session->flashdata('result_info');
       ?>
        </div> <!-- wg body -->
    </div> <!--wg-main-->
</div>
<div id="view_detail"></div>
<div id="modal-item" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Cari Item
        </div>
    </div>

    <div class="no-padding">
        <div class="row-fluid">
          <table class="table lcnp table-striped table-bordered table-hover" style='min-width:100%;'  id="show_item">
              <thead>
                  <tr>
                      <th class="center">No</th>
                      <th class="center">Kode Item</th>
                      <th class="center">Nama Item</th>
                  </tr>
              </thead>
              <tbody>
              </tbody>
          </table>
        </div>
    </div>

    <div class="modal-footer">
        <div class="pagination pull-right no-margin">
        <button type="button" class="btn btn-small btn-danger pull-left" data-dismiss="modal">
            <i class="icon-remove"></i>
            Close
        </button>
        </div>
    </div>
</div>

<div id="modal-gudang" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Cari Item
        </div>
    </div>

    <div class="no-padding">
        <div class="row-fluid">
          <table class="table lcnp table-striped table-bordered table-hover" style='min-width:100%;'  id="show_gudang">
              <thead>
                  <tr>
                      <th class="center">No</th>
                      <th class="center">Kode Gudang</th>
                      <th class="center">Nama Gudang</th>
                  </tr>
              </thead>
              <tbody>
              </tbody>
          </table>
        </div>
    </div>

    <div class="modal-footer">
        <div class="pagination pull-right no-margin">
        <button type="button" class="btn btn-small btn-danger pull-left" data-dismiss="modal">
            <i class="icon-remove"></i>
            Close
        </button>
        </div>
    </div>
</div>
