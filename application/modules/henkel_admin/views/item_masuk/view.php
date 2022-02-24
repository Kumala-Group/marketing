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
                        table = $('#show_transaksi').DataTable({
                        "bProcessing": true,
                        "bDestroy": true,
                        "sAjaxSource": '<?php echo site_url();?>henkel_adm_datatable/no_po',
                        "bSort": true,
                        "bAutoWidth": true,
                        "iDisplayLength": 10, "aLengthMenu": [10,20,40,80], // can be removed for basic 10 items per page
                        "sPaginationType": "full_numbers",
                        "aoColumnDefs": [{"bSortable": false,
                                         "aTargets": [ -1 , 0]}], //Feature control DataTables' server-side processing mode.
                        "aoColumns": [
                          {"mData" : "no"},
                          {"mData" : "id_pesanan_pembelian", "visible":false},
                          {"mData" : "no_po"},
                          {"mData" : "tanggal"},
                          {"mData" : "kode_supplier"},
                          {"mData" : "total_item"},
                          {"mData" : "total_akhir"},
                          {"mData" : "keterangan"}
                        ]
                    });
                    $('#modal-search').modal('show');
              }
          	});
        	});
          $('#show_transaksi tbody').on( 'click', 'tr', function () {
              var id_pes=$(this).find('td').eq(0).text();
              var no_po=$(this).find('td').eq(1).text();
              var tanggal_po=$(this).find('td').eq(2).text();
              $("#id_pesanan_pembelian").val(id_pes);
              $("#no_po").val(no_po);
              $("#tanggal_po").val(tanggal_po);
              $('#modal-search').modal('hide');
          });

          //datatables
          $("#cari_kode_item").click(function(){
              var id_pes= $("#id_pesanan_pembelian").val();
              $.ajax({
            		type	: "GET",
            		url		: "<?php echo site_url();?>henkel_adm_item_masuk/search_kd_item",
            		data	: "id_pes="+id_pes,
            		dataType: "json",
            		success	: function(data){
                          table = $('#show_item').DataTable({
                          "bProcessing": true,
                          "bDestroy": true,
                          "sAjaxSource": '<?php echo site_url();?>henkel_adm_item_masuk/search_kd_item?id_pes='+id_pes,
                          "bSort": true,
                           "bAutoWidth": true,
                          "iDisplayLength": 10, "aLengthMenu": [10,20,40,80], // can be removed for basic 10 items per page
                          "sPaginationType": "full_numbers",
                          "aoColumnDefs": [{"bSortable": false,
                                           "aTargets": [ -1 , 0]}], //Feature control DataTables' server-side processing mode.
                          "aoColumns": [
                            {"mData" : "no"},
                            {"mData" : "kode_item"},
                            {"mData" : "nama_item"},
                            {"mData" : "tipe"},
                            {"mData" : "jumlah"}
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
                var data_kode=$(this).find('td').eq(1).text();
                var data_nama=$(this).find('td').eq(2).text();
                var data_tipe=$(this).find('td').eq(3).text();
                var data_jumlah=$(this).find('td').eq(4).text();
                $("#kode_item").val(data_kode);
                $("#nama_item").val(data_nama);
                $("#tipe").val(data_tipe);
                $("#jumlah").val(data_jumlah);
                $('#modal-item').modal('hide');
            });


        $("#kode_gudang").change(function(){
           search_nm_gudang();
        });

        $("#simpan").click(function(){
            var no_po = $("#no_po").val();
            var kode_item = $("#kode_item").val();
            var kode_gudang = $("#kode_gudang").val();
            var tambah_stok = $("#tambah_stok").val();
            var total_item = parseInt($("#total_item").val());
            var jumlah = parseInt($("#jumlah").val());

            var string = $("#my-form").serialize();

            if(no_po.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'No PO tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#no_po").focus();
                return false();
            }

            if(kode_item.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Kode Item tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#kode_item").focus();
                return false();
            }

            if(kode_gudang.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Kode Gudang tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#kode_gudang").focus();
                return false();
            }

            if(total_item<1){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Tambah Stok tidak boleh 0',
                    class_name: 'gritter-error'
                });

                $("#total_item").focus();
                return false();
            }

            if(total_item>jumlah){
              $.gritter.add({
                  title: 'Peringatan..!!',
                  text: 'Maaf Stok Input Melebihi Batas',
                  class_name: 'gritter-error'
              });
              $("#total_item").focus();
              return false();
            }
            var r = confirm("Anda Sudah Yakin?");
            if (r == true) {
              $.ajax({
                  type    : 'POST',
                  url     : "<?php echo site_url(); ?>henkel_adm_item_masuk/simpan",
                  data    : string,
                  cache   : false,
                  success : function(data){
                      alert(data);
                      location.reload();
                  }
              });
            } else {
            }
        });


        $("#tambah").click(function(){
          var today = new Date();
          var yyyy = today.getFullYear();
          var mm = today.getMonth()+1;
          if(mm<10) {
            mm = '0'+mm
          }
          var dd = today.getDate();
          if(dd<10) {
            dd = '0'+dd
          }
          $("#id_item_masuk").val('');
          $("#id_stock").val('');
          $("#tanggal_input").val(yyyy+'-'+mm+'-'+dd);
          $("#no_po").val('');
          $("#tanggal_po").val('');
          $("#no_invoice").val('');
          $("#tanggal_invoice").val('');
          $("#total_item_pesanan_pembelian").val('');
          $("#id_pesanan_pembelian").val('');
          $("#kode_item").val('');
          $("#nama_item").val('');
          $("#tipe").val('');
          $("#kode_gudang").val('');
          $("#kode_gudang2").val('');
          $('#kode_gudang').show();
          $('#kode_gudang2').hide();
          $("#nama_gudang").val('');
          $("#total_item").val('1');
        });

});

function editData(ID){
    var cari  = ID;
    console.log(cari);
  $.ajax({
    type  : "GET",
    url   : "<?php echo site_url(); ?>henkel_adm_item_masuk/cari",
    data  : "cari="+cari,
    dataType: "json",
    success : function(data){
      $('#id_item_masuk').val(data.id_item_masuk);
      $('#no_po').val(data.no_po);
      $('#tanggal_po').val(data.tanggal);
      $('#no_invoice').val(data.no_invoice);
      $('#tanggal_invoice').val(data.tanggal_invoice);
      $('#total_item_pesanan_pembelian').val(data.total_item_pesanan_pembelian);
      $('#kode_item').val(data.kode_item2);
      $('#nama_item').val(data.nama_item);
      $('#tipe').val(data.tipe);
      $('#kode_gudang2').val(data.kode_gudang);
      $('#kode_gudang').val(data.kode_gudang);
      $('#kode_gudang').hide();
      $('#kode_gudang2').show();
      $('#nama_gudang').val(data.nama_gudang);
      $('#total_item').val(data.total_item);
    }
  });
}

function hapusData(id){
  var r = confirm("Anda yakin ingin menghapus data ini?");
  if (r == true) {
  $.ajax({
    		type	: "POST",
    		url		: "<?php echo site_url(); ?>henkel_adm_item_masuk/hapus/"+id,
    		data	: "id_h="+id,
    		dataType: "json",
    		success	: function(){
          location.reload();
    		}
      });
    }
}

function search_nm_gudang(){
  var kode_gudang = $("#kode_gudang").val();

  $.ajax({
    type	: "POST",
    url		: "<?php echo site_url(); ?>henkel_adm_item_masuk/search_nm_gudang",
    data	: "kode_gudang="+kode_gudang,
    dataType: "json",
    success	: function(data){
      $('#nama_gudang').val(data.nama_gudang);
    }
  });
}

</script>
<form class="form-horizontal" name="form_pembelian" id="form_pembelian">
<div class="row-fluid">
</br>
<?php
error_reporting(E_ALL ^ E_NOTICE);
?>

<div class="table-header">
 Tabel Item Masuk
 <div class="widget-toolbar no-border pull-right">
   <a href="<?php echo site_url(); ?>henkel_adm_item_masuk/tambah" data-toggle="modal" name="tambah" id="tambah" class="btn btn-small btn-success">
       <i class="icon-plus"></i>
       Tambah Item
   </a>
 </div>
</div>
<table class="table fpTable lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">No PO</th>
            <th class="center">Tanggal PO</th>
            <th class="center">No Invoice</th>
            <th class="center">Tanggal Invoice</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=1;
        $total_transaksi=0;
        $jml = 0;
        foreach($data->result() as $dt){ ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><a href="<?php echo site_url();?>henkel_adm_pesanan_pembelian/edit/<?php echo $dt->id_pesanan_pembelian;?>"><?php echo $dt->no_po;?></a></td>
            <td class="center"><?php echo tgl_sql($dt->tanggal);?></td>
            <td class="center"><?php echo $dt->no_invoice;?></td>
            <td class="center"><?php echo tgl_sql($dt->tanggal_invoice);?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                  <a class="green" href="<?php echo site_url();?>henkel_adm_item_masuk/edit/<?php echo $dt->id_item_masuk;?>">
                      <i class="icon-pencil bigger-130"></i>
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
</br>
</form>

</div>

<div id="modal-table" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Tambah Item
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
            <input type="hidden" name="id_item_masuk" id="id_item_masuk">
            <input type="hidden" name="tanggal_input" id="tanggal_input">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">No Po</label>

                    <div class="controls">
                        <input type="text" name="no_po" id="no_po" placeholder="No Po" class="autocomplete" value="<?php echo $no_po;?>"/>
                        <button type="button" id="show" name="show" class="btn btn-info btn-small" data-toggle="modal">...</button>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Tanggal PO</label>
                    <div class="controls">
                        <input type="text" name="tanggal_po" id="tanggal_po" placeholder="Tanggal PO" readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">No Invoice</label>

                    <div class="controls">
                        <input type="text" name="no_invoice" id="no_invoice" placeholder="No Invoice" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Tanggal Invoice</label>
                    <div class="controls">
                        <input type="text" name="tanggal_invoice" id="tanggal_invoice" placeholder="Tanggal Invoice" class="date-picker"  data-date-format="dd-mm-yyyy"/>
                    </div>
                </div>

                <input type="hidden" id="total_item_pesanan_pembelian" name="total_item_pesanan_pembelian" class="autocomplete">
                <input type="hidden" id="id_pesanan_pembelian" name="id_pesanan_pembelian" class="autocomplete">

                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kode Item</label>
                    <div class="controls">
                          <input type="text" name="kode_item" id="kode_item" placeholder="Kode Item" readonly="readonly" />
                          <button type="button" name="cari_kode_item" id="cari_kode_item" class="btn btn-small btn-info">
                              ...
                          </button>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Item</label>
                    <div class="controls">
                        <input type="text" name="nama_item" id="nama_item" placeholder="Nama Item" readonly="readonly"/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-field-1">Tipe</label>

                    <div class="controls">
                        <input type="text" name="tipe" id="tipe" placeholder="Tipe" readonly="readonly"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Jumlah</label>

                    <div class="controls">
                        <input type="text" name="jumlah" id="jumlah" placeholder="0" readonly="readonly"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kode Gudang</label>
                    <div class="controls">
                      <?php ?>
                      <select name="kode_gudang" id="kode_gudang">
                        <option value="" selected="selected">--Pilih Kode Gudang--</option>
                        <?php
                          $data = $this->db_kpp->get('gudang');
                          foreach($data->result() as $dt){
                        ?>
                         <option value="<?php echo $dt->kode_gudang;?>"><?php echo $dt->kode_gudang;?></option>
                        <?php
                          }
                        ?>
                       </select>
                       <input type="text" name="kode_gudang2" id="kode_gudang2" placeholder="Kode Gudang" readonly="readonly"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Gudang</label>

                    <div class="controls">
                        <input type="text" name="nama_gudang" id="nama_gudang" placeholder="Nama Gudang" readonly/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Tambah Stok</label>

                    <div class="controls">
                        <input type="text" value="0" onkeydown="return justAngka(event)" min="0" name="total_item" id="total_item" placeholder="Tambah Stok" />
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

<div id="modal-search" class="modal hide fade" style="width:80%;max-height:80%;left:30%;" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Cari No. Po
        </div>
    </div>

    <div class="no-padding">
        <div class="row-fluid">
          <table class="table lcnp table-striped table-bordered table-hover" style="width: 100%;" id="show_transaksi">
              <thead>
                  <tr>
                      <th class="center">No</th>
                      <th class="center">Id Pes</th>
                      <th class="center">No PO</th>
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

<div id="modal-item" class="modal hide fade" style="" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Cari Kode Item
        </div>
    </div>

    <div class="no-padding">
        <div class="row-fluid">
          <table class="table lcnp table-striped table-bordered table-hover" style='min-width:100%;' id="show_item">
              <thead>
                  <tr>
                      <th class="center">No</th>
                      <th class="center">Kode Item</th>
                      <th class="center">Nama Item</th>
                      <th class="center">Tipe Item</th>
                      <th class="center">Jumlah</th>
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
