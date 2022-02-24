<script type="text/javascript">
$(document).ready(function(){
        $("body").on("click", ".delete", function (e) {
            $(this).parent("div").remove();
        });

        $('.date-picker').datepicker();

        //datatables
        $("#show").click(function(){
            var no_po = $("#no_po").val();
            $.ajax({
          		type	: "GET",
          		url		: "<?php echo site_url();?>henkel_adm_datatable/no_po",
          		//data	: "no_po="+no_po,
          		dataType: "json",
          		success	: function(data){
                if (data==0) {
                  alert('Maaf Data Kosong');
                } else {
                        var table = $('#show_transaksi').DataTable({
                        "bProcessing": true,
                        "bDestroy": true,
                        "sAjaxSource": '<?php echo site_url();?>henkel_adm_datatable/no_po',
                        "bSort": false,
                        "bAutoWidth": true,
                        "iDisplayLength": 10, "aLengthMenu": [10,20,40,80], // can be removed for basic 10 items per page
                        "sPaginationType": "full_numbers",
                        "aoColumnDefs": [{"bSortable": false,
                                         "aTargets": [ -1 , 0]}], //Feature control DataTables' server-side processing mode.
                        "aoColumns": [
                          {"mData" : "no"},
                          {"mData" : "no_po"},
                          {"mData" : "id_pesanan_pembelian"},
                          {"mData" : "tanggal"},
                          {"mData" : "kode_supplier"},
                          {"mData" : "total_item"},
                          {"mData" : "total_akhir"},
                          {"mData" : "keterangan"}
                        ]
                    });
                    $('#modal-search').modal('show');
                  }
              }
          	});
        	});

          $("#nama_gudang").change(function(){
             search_nm_gudang();
          });

          $('#show_transaksi tbody').on( 'click', 'tr', function () {
              var no_po=$(this).find('td').eq(1).text();
              var id_pesanan_pembelian=$(this).find('td').eq(2).text();
              var tanggal_po=$(this).find('td').eq(3).text();
              $("#no_po").val(no_po);
              $("#id_pesanan_pembelian").val(id_pesanan_pembelian);
              $("#tanggal_po").val(tanggal_po);
              $('#modal-search').modal('hide');
          });


        $("#new").click(function(){
          var id= $("#id").val();
          $.ajax({
              type    : 'POST',
              url     : "<?php echo site_url(); ?>henkel_adm_item_masuk/baru",
              data    : "id_new="+id,
              success : function(data){
                location.replace("<?php echo site_url(); ?>henkel_adm_item_masuk/tambah");
              }
          });
      	});

        $("#cek").click(function(){
          var id_pes= $("#id_pesanan_pembelian").val();
          var no_po= $("#no_po").val();
          $.ajax({
              type    : 'POST',
              url     : "<?php echo site_url(); ?>henkel_adm_item_masuk/cek",
              data    : "id_pes="+id_pes,
              success : function(data){
                if(data==0){
                  alert('Tidak ada Data Pada No PO : '+no_po+' ');
                  location.reload();
                }else {
                  location.replace("<?php echo site_url(); ?>henkel_adm_item_masuk/tambah_invoice/"+btoa(id_pes));
                }
              }
          });
      	});

        $(window).on('beforeunload', function(){
          localStorage.setItem('no_po', $('#no_po').val());
          localStorage.setItem('id_pesanan_pembelian', $('#id_pesanan_pembelian').val());
        });
});

window.onload = function() {
  var id=$("#id").val();
  $.ajax({
      type    : 'POST',
      url     : "<?php echo site_url(); ?>henkel_adm_item_masuk/cek_table",
      data    : "id_cek="+id,
      success : function(data){
        if(data==0){
          $("#no_po").val('');
          $("#id_pesanan_pembelian").val('');
        }else{
          var no_po = localStorage.getItem('no_po');
          var id_pesanan_pembelian = localStorage.getItem('id_pesanan_pembelian');
          $('#no_po').val(no_po);
          $('#id_pesanan_pembelian').val(id_pesanan_pembelian);
        }
    }
    });
}

function autoseparator(Num) { //function to add commas to textboxes
        Num += '';
        Num = Num.replace('.', ''); Num = Num.replace('.', ''); Num = Num.replace('.', '');
        Num = Num.replace('.', ''); Num = Num.replace('.', ''); Num = Num.replace('.', '');
        x = Num.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        return x1 + x2;
    }
</script>
<form class="form-horizontal" name="form_item_masuk" id="form_item_masuk" method="post">
<div class="row-fluid">
<div class="table-header">
    <!--<?php echo 'Tanggal : '.tgl_indo($tanggal);?><input type="hidden" name="tanggal" id="tanggal" value="<?php echo tgl_indo($tanggal)?>">-->
</div>
</br>
<?php
error_reporting(E_ALL ^ E_NOTICE);
?>
   <div class="row-fluid">
        <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="form-field-1">No PO</label>
                    <div class="controls">
                        <input type="text" name="no_po" id="no_po" placeholder="No PO" />
                        <input type="hidden" name="id_pesanan_pembelian" id="id_pesanan_pembelian" placeholder="Id Pesanan Pembelian" />
                        <button type="button" name="show" id="show" class="btn btn-small btn-info">
                            <i class="icon-search"></i>
                            Cari
                        </button>
                    </div>
                    <div class="space"></div>
                    <div class="control-group">
                       <div class="controls">
                          <button type="button" name="cek" id="cek" class="btn btn-small btn-success">
                              Proses
                          </button>
                        </div>
                    </div>
               </div>
         </div>
    </div>
</br>
</form>
</div>

<div id="modal-search" class="modal hide fade" style="width:80%;max-height:80%;left:30%;" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Cari No. Po
        </div>
    </div>

    <div class="no-padding">
        <div class="row-fluid">
          <table class="table lcnp table-striped table-bordered table-hover" style='min-width:100%;' id="show_transaksi">
              <thead>
                  <tr>
                      <th class="center">No</th>
                      <th class="center">No PO</th>
                      <th class="center">Id Pesanan Pembelian</th>
                      <th class="center">Tanggal PO</th>
                      <th class="center">Kode Supplier</th>
                      <th class="center">Total Item</th>
                      <th class="center">Total Akhir</th>
                      <th class="center">Keterangan</th>
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
<script type="text/javascript">
function justAngka(e){
       // Allow: backspace, delete, tab, escape, enter and .
       if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A, Command+A
           (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: home, end, left, right, down, up
           (e.keyCode >= 35 && e.keyCode <= 40)) {
                // let it happen, don't do anything
                return;
       }
       // Ensure that it is a number and stop the keypress
       if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
           e.preventDefault();
       }
};
</script>
