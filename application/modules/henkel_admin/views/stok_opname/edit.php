<script type="text/javascript">
$(document).ready(function(){
        $("body").on("click", ".delete", function (e) {
            $(this).parent("div").remove();
        });

        $("#form_kembali").hide();

        $("#kode_gudang").autocomplete({
                // serviceUrl berisi URL ke controller/fungsi yang menangani request kita
                serviceUrl: '<?php echo site_url();?>henkel_adm_stok_opname/search_kd_gudang',
                // fungsi ini akan dijalankan ketika user memilih salah satu hasil request
                onSelect: function (suggestion) {
                    $('#nama_gudang').val(''+suggestion.nama_gudang);
                }

        });


        $("#new").click(function(){
          var id= $("#id").val();
          $.ajax({
              type    : 'POST',
              url     : "<?php echo site_url(); ?>henkel_adm_pembayaran_piutang/baru",
              data    : "id_new="+id,
              success : function(data){
                location.replace("<?php echo site_url(); ?>henkel_adm_pembayaran_piutang/tambah");
              }
          });
      	});

        $("#cek").click(function(){
          var gudang= $("#kode_gudang").val();
          $.ajax({
              type    : 'POST',
              url     : "<?php echo site_url(); ?>henkel_adm_stok_opname/cek",
              data    : "kode_gudang="+gudang,
              success : function(data){
                  if (data == 0 ){
                    alert('Gudang Kosong');
                  } else
                  {
                    location.replace("<?php echo site_url(); ?>henkel_adm_stok_opname/tambah");
                  }


              }
          });

      	});

        $("#stok_nyata").keyup(function(){
          var stok_item = $("#stok_item").val();
          var stok_nyata = $("#stok_nyata").val();
          $('#selisih').val(stok_nyata - stok_item);
        });

        $("#simpan").click(function(){
            var stok_nyata = $("#stok_nyata").val();

            var string = $("#my-form").serialize();

            if(stok_nyata<1){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Stok Nyata tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#stok_nyata").focus();
                return false();
            }

            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_stok_opname/t_simpan",
                data    : string,
                cache   : false,
                success : function(data){
                    alert(data);
                    location.reload();
                }
            });
        });

        $("#simpan_stok_opname").click(function(){
            var id=$("#id").val();
            var kode_gudang = $("#kode_gudang").val();

            var string = $("#form_stok_opname").serialize();

            if(kode_gudang.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Kode Gudang tidak boleh kosong',
                    class_name: 'gritter-error'
                });
                $("#kode_gudang").focus();
                return false();
            }

            var r = confirm("Anda sudah yakin? Data yang sudah disimpan tidak dapat diubah lagi");
            if (r == true) {
              $.ajax({
                  type    : 'POST',
                  url     : "<?php echo site_url(); ?>henkel_adm_stok_opname/simpan",
                  data    : string,
                  cache   : false,
                  success : function(data){
                    var id= $("#id").val();
                    alert(data);
                    location.replace("<?php echo site_url(); ?>henkel_adm_stok_opname");
                  }
              });
            }else {
              return false();
            }
        });

        $(window).on('beforeunload', function(){
            localStorage.setItem('kode_gudang', $('#kode_gudang').val());
        });

});

window.onload = function() {
  var id=$("#id").val();
  $.ajax({
      type    : 'POST',
      url     : "<?php echo site_url(); ?>henkel_adm_stok_opname/cek_table",
      data    : "id_cek="+id,
      success : function(data){
        if(data==0){
          $("#kode_gudang").html('');
        }else{
          var kode_gudang = localStorage.getItem('kode_gudang');
          $('#kode_gudang').val(kode_gudang);
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

function editData(ID){
	  var cari	= ID;
    console.log(cari);
	$.ajax({
		type	: "GET",
		url		: "<?php echo site_url(); ?>henkel_adm_stok_opname/t_cari",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
			$('#id_stok_opname').val('<?php echo $id_stok_opname;?>');
      $('#id_stok_opname_detail').val('<?php echo $id_stok_opname_detail;?>');
      $('#kode_item').val(data.kode_item);
      $('#stok_item').val(data.stok_item);
      $('#stok_nyata').val('');
      $('#selisih').val('');
		}
	});
}
</script>

<form class="form-horizontal" name="form_stok_opname" id="form_stok_opname" action="<?php echo base_url();?>henkel_adm_pembayaran_piutang/cetak" method="post">
<div class="row-fluid">
<div class="table-header">
    <?php echo 'Kode Stok Opname : '.$kode_stok_opname;?><input type="hidden" name="kode_stok_opname" id="kode_stok_opname" value="<?php echo $kode_stok_opname?>">
    <!--<div class="pull-right" style="padding-right:15px;"><?php echo 'Tanggal : '.tgl_indo($tanggal);?></div><input type="hidden" name="tanggal" id="tanggal" value="<?php echo $tanggal?>">-->
    <input type="hidden" value="<?php echo $id_stok_opname;?>" name="id" id="id">
</div>
<div class="space"></div>
   <div class="row-fluid">
        <div class="span12">
          <div class="control-group">
            <div class="space"></div>
              <table>
                <tr>
                  <td><span style="font-size: 12px;"><b><?php echo $nama_gudang;?></b></span></td>
                </tr>
                <tr>
                  <td><span style="font-size: 12px;"><b><?php echo $tanggal_awal;?></b> <b>s/d</b> <b><?php echo $tanggal_akhir;?></b> </span></td>
                </tr>
              </table>
            </div>
         </div>
    </div>
<div class="space"></div>
<div class="table-header">
 Tabel Stok Opname
</div>
<table class="table lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Kode Item</th>
            <th class="center">Nama Item</th>
            <th class="center">Stok Nyata</th>
            <th class="center">Selisih</th>
            <!--<th class="center">Aksi</th>-->
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
            <td class="center"><?php echo $dt->stok_nyata;?></td>
            <td class="center"><?php echo $dt->selisih;?></td>
            <!--<td class="td-actions"><center>
                <div class="text-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_stok_opname_detail;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>
                </div>

                <div class="text-desktop visible-phone">
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
            </td>-->
        </tr>
        <?php } ?>
    </tbody>
</table>
 <br>
 <div class="row-fluid">

 </div>
 <br>

</form>
</br>
<!--<div class="row-fluid">
     <div class="span12" align="center">
         <button type="button" name="simpan_stok_opname" id="simpan_stok_opname" class="btn btn-small btn-success">
             <i class="icon-save"></i>
             Simpan
         </button>
      </div>
</div>-->

</div>

<div id="modal-table" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Stok Opname Detail
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
            <input type="hidden" name="id_stok_opname" id="id_stok_opname">
            <input type="hidden" name="id_stok_opname_detail" id="id_stok_opname_detail">
            <input type="hidden" name="kode_item" id="kode_item">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Stok Item</label>

                    <div class="controls">
                        <input type="text" name="stok_item" id="stok_item" placeholder="0" readonly="readonly"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Stok Nyata</label>

                    <div class="controls">
                        <input type="text" onkeydown="return justAngka(event)" min="0" name="stok_nyata" id="stok_nyata" placeholder="Stok Nyata" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Selisih</label>

                    <div class="controls">
                        <input type="text" value="0" min="0" name="selisih" id="selisih" placeholder="Selisih" readonly="readonly" />
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
