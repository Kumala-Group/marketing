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

        $("#simpan_item").click(function(){
            var nama_target = $("#nama_target").val();
            var jumlah_target = $("#jumlah_target").val();

            var string = $("#my-form").serialize();

            if(nama_target.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Nama Target tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#nama_target").focus();
                return false();
            }

            if(jumlah_target.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Jumlah Target tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#jumlah_target").focus();
                return false();
            }

            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_target_penjualan/simpan_detail",
                data    : string,
                cache   : false,
                start   : $("#simpan_item").html('...Sedang diproses...'),
                success : function(data){
                    $("#simpan_item").html('<i class="icon-save"></i> Simpan');
                    alert(data);
                    location.reload();
                }
            });
        });

        $("#simpan_target_penjualan").click(function(){
            var id=$("#id").val();
            var target_keseluruhan = $("#target_keseluruhan").val();

            var string = $("#form_target_penjualan").serialize();

            if(target_keseluruhan.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Target Keseluruhan tidak boleh kosong',
                    class_name: 'gritter-error'
                });
                $("#target_keseluruhan").focus();
                return false();
            }

            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_target_penjualan/cek_table",
                data    : "id="+id,
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
                        url     : "<?php echo site_url(); ?>henkel_adm_target_penjualan/simpan",
                        data    : string,
                        cache   : false,
                        start   : $("#simpan_target_penjualan").html('Sedang diproses...'),
                        success : function(data){
                          $("#simpan_target_penjualan").html('<i class="icon-save"></i> Simpan');
                          var id= $("#id").val();
                          alert(data);
                          location.replace("<?php echo site_url(); ?>henkel_adm_target_penjualan")
                        }
                    });
                  }
                }
            });
        });

        $("#tambah").click(function(){
          $("#id_target_penjualan").val('<?php echo $id_target_penjualan ?>');
          $("#nama_target").val('');
          $("#jumlah_target").val('');
        });

        $(window).on('beforeunload', function(){
          localStorage.setItem('target_keseluruhan', $('#target_keseluruhan').val());
        });
});

/*window.onload = function() {
  var id=$("#id").val();
  $.ajax({
      type    : 'POST',
      url     : "<?php echo site_url(); ?>henkel_adm_target_penjualan/cek_table",
      data    : "id="+id,
      success : function(data){
        if(data==0){
          $("#target_keseluruhan").val('');
        }else{
          var target_keseluruhan = localStorage.getItem('target_keseluruhan');
          $('#target_keseluruhan').val(target_keseluruhan);
        }
    }
    });
}*/

function editData(ID){
    var cari  = ID;
    console.log(cari);
  $.ajax({
    type  : "GET",
    url   : "<?php echo site_url(); ?>henkel_adm_target_penjualan/cari_detail",
    data  : "cari="+cari,
    dataType: "json",
    success : function(data){
      $('#id_target_penjualan_detail').val(data.id_target_penjualan_detail);
      $('#nama_target').val(data.nama_target);
      $('#jumlah_target').val(data.jumlah_target);
    }
  });
}

function hapusData(id){
  var r = confirm("Anda yakin ingin menghapus data ini?");
  if (r == true) {
  $.ajax({
    		type	: "POST",
    		url		: "<?php echo site_url(); ?>henkel_adm_target_penjualan/hapus_detail/"+id,
    		data	: "id_h="+id,
    		dataType: "json",
    		success	: function(){
          location.reload();
    		}
      });
    }
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

    function separator_harga2(ID){
      var bilangan  = ID;
      var reverse = bilangan.toString().split('').reverse().join(''),
      ribuan  = reverse.match(/\d{1,3}/g);
      ribuan  = ribuan.join('.').split('').reverse().join('');
      return ribuan;
    }
</script>
<form class="form-horizontal" name="form_target_penjualan" id="form_target_penjualan" method="post">
<div class="row-fluid">
<div class="table-header">
    <?php echo "Target Penjualan";?>
    <input type="hidden" value="<?php echo $id_target_penjualan;?>" name="id" id="id">
</div>
<br />
<?php
error_reporting(E_ALL ^ E_NOTICE);
?>
   <div class="row-fluid">
        <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Target Keseluruhan</label>
                    <div class="controls">
                      <?php
                        $target_keseluruhan=0;
                        foreach($data->result() as $dt){
                          $target_keseluruhan = $dt->target_keseluruhan;
                        }
                      ?>
                        <input type="text" name="target_keseluruhan" class="number" id="target_keseluruhan" value="<?php echo separator_harga2($target_keseluruhan) ;?>" placeholder="Target Keseluruhan" onkeydown="return justAngka(event)"/>
                    </div>
               </div>
         </div>
    </div>

<div class="table-header">
 Tabel Target Penjualan
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
            <th class="center">Nama Target</th>
            <th class="center">Jumlah Target</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=1;
        foreach($data_detail->result() as $dt_detail){ ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt_detail->nama_target;?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($dt_detail->jumlah_target);?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt_detail->id_target_penjualan_detail;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a class="red" href="#" onclick="javascript:hapusData('<?php echo $dt_detail->id_target_penjualan_detail;?>')">
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
          <a href="<?php echo base_url();?>henkel_adm_target_penjualan" class="btn btn-small btn-danger">
             <i class="icon-remove"></i>
             Cancel
          </a>
          <button type="button" name="simpan_target_penjualan" id="simpan_target_penjualan" class="btn btn-small btn-success">
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
            <input type="hidden" name="id_target_penjualan" id="id_target_penjualan">
            <input type="hidden" name="id_target_penjualan_detail" id="id_target_penjualan_detail">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Target</label>

                    <div class="controls">
                        <input type="text" name="nama_target" id="nama_target" placeholder="Nama Target" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Jumlah Target</label>

                    <div class="controls">
                        <input type="text" name="jumlah_target" class="number" id="jumlah_target" placeholder="Jumlah Target" onkeydown="return justAngka(event)"/>
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
        <button type="button" name="simpan_item" id="simpan_item" class="btn btn-small btn-success pull-left">
            <i class="icon-save"></i>
            Simpan
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
