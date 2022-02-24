<script type="text/javascript">
$(document).ready(function(){
        $("body").on("click", ".delete", function (e) {
            $(this).parent("div").remove();
        });

        $("#new").click(function(){
          var id= $("#id").val();
          $.ajax({
              type    : 'POST',
              url     : "<?php echo site_url(); ?>henkel_adm_program_penjualan/baru",
              data    : "id_new="+id,
              success : function(data){
                location.replace("<?php echo site_url(); ?>henkel_adm_program_penjualan/tambah");
              }
          });
      	});

        $("#simpan").click(function(){
            var kode_item = $("#kode_item").val();
            var kode_gudang = $("#kode_gudang").val();

            var string = $("#my-form").serialize();

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

            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_program_penjualan/simpan_detail",
                data    : string,
                cache   : false,
                start   : $("#simpan").html('Sedang diproses...'),
                success : function(data){
                    $("#simpan").html('<i class="icon-save"></i> Simpan');
                    alert(data);
                    location.reload();
                }
            });
        });

        $("#simpan_program_penjualan").click(function(){
            var id=$("#id").val();
            var nama_program = $("#nama_program").val();

            var string = $("#form_program_penjualan").serialize();

            if(nama_program.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Nama Program tidak boleh kosong',
                    class_name: 'gritter-error'
                });
                $("#nama_program").focus();
                return false();
            }

            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_program_penjualan/cek_table_pp",
                data    : "id_cek="+id,
                success : function(data){
                  if(data==0){
                    $.gritter.add({
                        title: 'Peringatan..!!',
                        text: 'Tabel Item Tidak Boleh Kosong',
                        class_name: 'gritter-error'
                    });
                    return false();
                  }else{
                    $.ajax({
                        type    : 'POST',
                        url     : "<?php echo site_url(); ?>henkel_adm_program_penjualan/simpan_pp",
                        data    : string,
                        cache   : false,
                        start   : $("#simpan_program_penjualan").html('Sedang diproses...'),
                        success : function(data){
                          $("#simpan_program_penjualan").html('<i class="icon-save"></i> Simpan');
                          var id= $("#id").val();
                          alert(data);
                          location.replace("<?php echo site_url(); ?>henkel_adm_program_penjualan")
                        }
                    });
                  }
                }
            });
        });

        //datatables
        $("#cari_kode_item").click(function(){
            var kode_gudang= $("#kode_gudang").val();
            $.ajax({
              type	: "GET",
              url		: "<?php echo site_url();?>henkel_adm_datatable/search_item",
              dataType: "json",
              success	: function(data){
                        table = $('#show_item').DataTable({
                        "bProcessing": true,
                        "bDestroy": true,
                        "sAjaxSource": '<?php echo site_url();?>henkel_adm_datatable/search_item',
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
                          {"mData" : "harga_item"}
                        ]
                    });
                    $('#modal-item').modal('show');
              },
              error : function(data){
                alert('Data Item Kosong');
              }
            });
          });

          $("#cari_kode_gudang").click(function(){
              $.ajax({
                type	: "GET",
                url		: "<?php echo site_url();?>henkel_adm_datatable/search_gudang",
                dataType: "json",
                success	: function(data){
                          table = $('#show_gudang').DataTable({
                          "bProcessing": true,
                          "bDestroy": true,
                          "sAjaxSource": '<?php echo site_url();?>henkel_adm_datatable/search_gudang',
                          "bSort": true,
                           "bAutoWidth": true,
                          "iDisplayLength": 10, "aLengthMenu": [10,20,40,80], // can be removed for basic 10 items per page
                          "sPaginationType": "full_numbers",
                          "aoColumnDefs": [{"bSortable": false,
                                           "aTargets": [ -1 , 0]}], //Feature control DataTables' server-side processing mode.
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

          $('#show_item tbody').on( 'click', 'tr', function () {
              var kode_item=$(this).find('td').eq(1).text();
              var nama_item=$(this).find('td').eq(2).text();
              $("#kode_item").val(kode_item);
              $("#nama_item").val(nama_item);
              $('#modal-item').modal('hide');
          });

          $('#show_gudang tbody').on( 'click', 'tr', function () {
              var kode_gudang=$(this).find('td').eq(1).text();
              var nama_gudang=$(this).find('td').eq(2).text();
              $("#kode_gudang").val(kode_gudang);
              $("#nama_gudang").val(nama_gudang);
              $('#modal-gudang').modal('hide');
          });

        $("#tambah").click(function(){
          $("#kode_item").val('');
          $("#nama_item").val('');
          $("#kode_gudang").val('');
          $("#nama_gudang").val('');
          $("#jumlah_bonus").val('');
        });
});


function editData(ID){
    var cari  = ID;
    console.log(cari);
  $.ajax({
    type  : "GET",
    url   : "<?php echo site_url(); ?>henkel_adm_program_penjualan/cari_detail",
    data  : "cari="+cari,
    dataType: "json",
    success : function(data){
      $('#id_program_penjualan_detail').val(data.id_program_penjualan_detail);
      $('#id_program_penjualan').val(data.id_program_penjualan);
      $('#kode_item').val(data.kode_item);
      $('#nama_item').val(data.nama_item);
      $('#kode_gudang').val(data.kode_gudang);
      $('#nama_gudang').val(data.nama_gudang);
      $('#jumlah_bonus').val(data.jumlah_bonus);
    }
  });
}

function hapusData(id){
  var r = confirm("Anda yakin ingin menghapus data ini?");
  if (r == true) {
  $.ajax({
    		type	: "POST",
    		url		: "<?php echo site_url(); ?>henkel_adm_program_penjualan/hapus_detail/"+id,
    		data	: "id_h="+id,
    		dataType: "json",
    		success	: function(){
          location.reload();
    		}
      });
    }
}
</script>
<form class="form-horizontal" name="form_program_penjualan" id="form_program_penjualan" method="post">
<div class="row-fluid">
<div class="table-header">
    <?php echo 'Kode Program Penjualan: '.$kode_program_penjualan;?><input type="hidden" name="kode_program_penjualan" id="kode_program_penjualan" value="<?php echo $kode_program_penjualan?>">
    <input type="hidden" value="<?php echo $id_program_penjualan;?>" name="id" id="id">
</div>
</br>
<?php
error_reporting(E_ALL ^ E_NOTICE);
?>
   <div class="row-fluid">
        <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Program</label>
                    <div class="controls">
                        <input type="text" class="autocomplete" name="nama_program" id="nama_program" value="<?php echo $nama_program;?>" placeholder="Nama Program" />
                    </div>
               </div>
         </div>
    </div>

<div class="table-header">
 Tabel Item Program Penjualan
 <div class="widget-toolbar no-border pull-right">
   <a href="#modal-table" data-toggle="modal" name="tambah" id="tambah" class="btn btn-small btn-success">
       <i class="icon-plus"></i>
       Tambah Item
   </a>
 </div>
</div>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Kode Item</th>
            <th class="center">Nama Item</th>
            <th class="center">Kode Gudang</th>
            <th class="center">Nama Gudang</th>
            <th class="center">Jumlah Bonus</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=1;
        foreach($data->result() as $dt){ ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->kode_item;?></td>
            <td class="center"><?php echo $dt->nama_item;?></td>
            <td class="center"><?php echo $dt->kode_gudang;?></td>
            <td class="center"><?php echo $dt->nama_gudang;?></td>
            <td class="center"><?php echo $dt->jumlah_bonus;?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_program_penjualan_detail;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a class="red" href="#" onclick="javascript:hapusData('<?php echo $dt->id_program_penjualan_detail;?>')">
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
</br>
</form>

<div class="row-fluid">
     <div class="span12" align="center">
          <a href="<?php echo base_url();?>henkel_adm_program_penjualan" class="btn btn-small btn-danger">
             <i class="icon-remove"></i>
             Cancel
          </a>
          <button type="button" name="simpan_program_penjualan" id="simpan_program_penjualan" class="btn btn-small btn-success">
              <i class="icon-save"></i>
              Simpan
          </button>
      </div>
</div>

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
            <input type="hidden" name="id_program_penjualan" id="id_program_penjualan" value="<? echo $id_program_penjualan; ?>">
            <input type="hidden" name="id_program_penjualan_detail" id="id_program_penjualan_detail">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kode Item</label>

                    <div class="controls">
                        <input type="text" name="kode_item" id="kode_item" placeholder="Kode Item" readonly/>
                        <button type="button" name="cari_kode_item" id="cari_kode_item" class="btn btn-small btn-info">
                          <i class="icon-search"></i>
                          Cari
                        </button>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Item</label>

                    <div class="controls">
                        <input type="text" name="nama_item" id="nama_item" placeholder="Nama Item" readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kode Gudang</label>

                    <div class="controls">
                        <input type="text" name="kode_gudang" id="kode_gudang" placeholder="Kode Gudang" readonly="readonly" />
                        <button type="button" name="cari_kode_gudang" id="cari_kode_gudang" class="btn btn-small btn-info">
                          <i class="icon-search"></i>
                          Cari
                        </button>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Gudang</label>

                    <div class="controls">
                        <input type="text" name="nama_gudang" id="nama_gudang" placeholder="Nama Gudang" readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Jumlah Bonus</label>

                    <div class="controls">
                        <input type="text" name="jumlah_bonus" id="jumlah_bonus" placeholder="Jumlah Bonus" onkeydown="return justAngka(event)"/>
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
<div id="modal-item" class="modal hide fade" style="width:80%;max-height:80%;left:30%;" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Cari Item
        </div>
    </div>

    <div class="no-padding">
        <div class="row-fluid">
          <table class="table lcnp table-striped table-bordered table-hover" style="width: 1500px;" id="show_item">
              <thead>
                  <tr>
                      <th class="center">No</th>
                      <th class="center">Kode Item</th>
                      <th class="center">Nama Item</th>
                      <th class="center">Harga Item</th>
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
<div id="modal-gudang" class="modal hide fade" style="width:80%;max-height:80%;left:30%;" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Cari Gudang
        </div>
    </div>

    <div class="no-padding">
        <div class="row-fluid">
          <table class="table lcnp table-striped table-bordered table-hover" style="width: 1500px;" id="show_gudang">
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
