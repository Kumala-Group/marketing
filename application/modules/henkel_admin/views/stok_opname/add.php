<script type="text/javascript">
$(document).ready(function(){
        $("body").on("click", ".delete", function (e) {
            $(this).parent("div").remove();
        });

        var date = new Date();
        date.setDate(date.getDate()-1);
        $('.date-picker').datepicker({
          startDate: date
        });



        $("#kode_gudang").autocomplete({
                // serviceUrl berisi URL ke controller/fungsi yang menangani request kita
                serviceUrl: '<?php echo site_url();?>henkel_adm_stok_opname/search_kd_gudang',
                // fungsi ini akan dijalankan ketika user memilih salah satu hasil request
                onSelect: function (suggestion) {
                    $('#nama_gudang').val(''+suggestion.nama_gudang);
                }

        });


        $("#submit_kd_gudang").click(function(){
          var tanggal_awal = $("#tanggal_awal").val();
          var tanggal_akhir = $("#tanggal_akhir").val();
          var gudang= $("#kode_gudang").val();

          if(tanggal_awal.length==0){
              $.gritter.add({
                  title: 'Peringatan..!!',
                  text: 'Tanggal Awal tidak boleh kosong',
                  class_name: 'gritter-error'
              });
              $("#tanggal_awal").focus();
              return false();
          }

          if(tanggal_akhir.length==0){
              $.gritter.add({
                  title: 'Peringatan..!!',
                  text: 'Tanggal Akhir tidak boleh kosong',
                  class_name: 'gritter-error'
              });
              $("#tanggal_akhir").focus();
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
              url     : "<?php echo site_url(); ?>henkel_adm_stok_opname/cek",
              data    : "kode_gudang="+gudang,
              success : function(data){
                  if (data==0 ){
                    alert('Gudang Kosong');
                  } else {
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
            var tanggal_awal = $("#tanggal_awal").val();
            var tanggal_akhir = $("#tanggal_akhir").val();

            var string = $("#form_stok_opname").serialize();

            if(tanggal_awal.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Tanggal Awal tidak boleh kosong',
                    class_name: 'gritter-error'
                });
                $("#tanggal_awal").focus();
                return false();
            }

            if(tanggal_akhir.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Tanggal Akhir tidak boleh kosong',
                    class_name: 'gritter-error'
                });
                $("#tanggal_akhir").focus();
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
                    if (data=="Maaf, Data Belum Lengkap") {
                        return false();
                    } else {
                        location.replace("<?php echo site_url(); ?>henkel_adm_stok_opname");
                    }
                  }
              });
            }else {
              return false();
            }
        });

        $("#tunda_stok_opname").click(function(){
          var kode_gudang = $("#kode_gudang").val();
          var tanggal_awal = $("#tanggal_awal").val();
          var tanggal_akhir = $("#tanggal_akhir").val();

          var string = $("#form_stok_opname").serialize();

          if(tanggal_awal.length==0){
              $.gritter.add({
                  title: 'Peringatan..!!',
                  text: 'Tanggal Awal tidak boleh kosong',
                  class_name: 'gritter-error'
              });
              $("#tanggal_awal").focus();
              return false();
          }

          if(tanggal_akhir.length==0){
              $.gritter.add({
                  title: 'Peringatan..!!',
                  text: 'Tanggal Akhir tidak boleh kosong',
                  class_name: 'gritter-error'
              });
              $("#tanggal_akhir").focus();
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

            var r = confirm("Anda yakin menunda proses ini?");
            if (r == true) {
              $.ajax({
                  type    : 'POST',
                  url     : "<?php echo site_url(); ?>henkel_adm_stok_opname/tunda",
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
            localStorage.setItem('tanggal_awal', $('#tanggal_awal').val());
            localStorage.setItem('tanggal_akhir', $('#tanggal_akhir').val());
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
          $("#kode_gudang").val('');
          $("#tanggal_awal").val('');
          $("#tanggal_akhir").val('');
        }else{
          var kode_gudang = localStorage.getItem('kode_gudang');
          var tanggal_awal = localStorage.getItem('tanggal_awal');
          var tanggal_akhir = localStorage.getItem('tanggal_akhir');
          $('#kode_gudang').val(kode_gudang);
          $('#tanggal_awal').val(tanggal_awal);
          $('#tanggal_akhir').val(tanggal_akhir);
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

function editDataInserted(ID){
	  var cari	= ID;
    console.log(cari);
	$.ajax({
		type	: "GET",
		url		: "<?php echo site_url(); ?>henkel_adm_stok_opname/t_cari_add",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
      $('#id_stok_opname').val('<?php echo $id_stok_opname;?>');
			$('#id_stok_opname_detail').val(data.id_stok_opname_detail);
      $('#kode_item').val(data.kode_item);
      $('#stok_item').val(data.stok_item);
      $('#stok_nyata').val(data.stok_nyata);
      $('#selisih').val(data.selisih);
		}
	});
}

</script>

<form class="form-horizontal" name="form_stok_opname" id="form_stok_opname" action="<?php echo base_url();?>henkel_adm_pembayaran_piutang/cetak" method="post">
<div class="row-fluid">
<div class="table-header">
    <?php echo 'Kode Stok Opname : '.$kode_stok_opname;?><input type="hidden" name="kode_stok_opname" id="kode_stok_opname" value="<?php echo $kode_stok_opname?>">
    <input type="hidden" value="<?php echo $id_stok_opname;?>" name="id" id="id">
</div>
<div class="space"></div>
   <div class="row-fluid">
        <div class="span12">
          <div class="control-group">
              <label class="control-label" for="form-field-1">Tanggal Awal</label>
              <div class="controls">
                <div class="input-append">
                  <input type="text" name="tanggal_awal" id="tanggal_awal" class="date-picker"  data-date-format="dd-mm-yyyy" placeholder="Tanggal Awal"/>
                </div>
              </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-1">Tanggal Akhir</label>
                <div class="controls">
                  <div class="input-append">
                    <input type="text" name="tanggal_akhir" id="tanggal_akhir" class="date-picker"  data-date-format="dd-mm-yyyy" placeholder="Tanggal Akhir"/>
                  </div>
                </div>
              </div>
            <div class="control-group">
              <label class="control-label" for="form-field-1">Gudang</label>
              <div class="controls">
                <?php ?>
                <select name="kode_gudang" id="kode_gudang">
                  <option value="" selected="selected">--Pilih Nama Gudang--</option>
                  <?php
                    $data_gudang = $this->db_kpp->get('gudang');
                    foreach($data_gudang->result() as $dt){
                  ?>
                   <option value="<?php echo $dt->kode_gudang;?>"><?php echo $dt->nama_gudang;?></option>
                  <?php
                    }
                  ?>
                 </select>
              </div>
            </div>
            <div class="space"></div>
                <div class="control-group">
                   <div class="controls">
                      <button type="button" name="submit_kd_gudang" id="submit_kd_gudang" class="btn btn-small btn-success">
                          Proses
                      </button>
                    </div>
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
            <th class="center">Status</th>
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
            <td class="center">
              <?php if ($dt->status > 0)  {
                echo "<span class='label label-success'>Sudah Di Periksa</span>";
              } else {
                echo "<span class='label label-danger'>Belum Di Periksa</span>";
              }?>
          </td>
            <td class="td-actions"><center>
              <div class="text-phone visible-desktop action-buttons">
                <?php if ($dt->status > 0)  { ?>
                  <a href="#modal-table" onclick="javascript:editDataInserted('<?php echo $dt->id_t_stok_opname;?>')" data-toggle="modal">
                    <span class="green">
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </span>
                  </a>
                  <?php  } else { ?>
                  <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_t_stok_opname;?>')" data-toggle="modal">
                      <i class="icon-pencil bigger-130"></i>
                  </a>
                  <?php } ?>
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
            </td>
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
<div class="row-fluid">
     <div class="span12" align="center">
         <button type="button" name="simpan_stok_opname" id="simpan_stok_opname" class="btn btn-small btn-success">
             <i class="icon-save"></i>
             Simpan
         </button>
         <button type="button" name="tunda_stok_opname" id="tunda_stok_opname" class="btn btn-small btn-warning">
             <i class="icon-save"></i>
             Tunda
         </button>
      </div>
</div>

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
