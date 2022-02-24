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
            var penerima_komisi = $("#penerima_komisi").val();
            var target_komisi = $("#target_komisi").val();
            var range_hari_awal = $("#range_hari_awal").val();
            var range_hari_akhir = $("#range_hari_akhir").val();

            var string = $("#my-form").serialize();

            if(penerima_komisi.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Penerima Komisi tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#penerima_komisi").focus();
                return false();
            }

            if(target_komisi.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Target Komisi tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#target_komisi").focus();
                return false();
            }

            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_komisi/simpan_detail",
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

        $("#simpan_komisi").click(function(){
            var id=$("#id").val();
            var nama_komisi = $("#nama_skema").val();
            var string = $("#form_komisi").serialize();

            if(nama_komisi.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Nama Komisi tidak boleh kosong',
                    class_name: 'gritter-error'
                });
                $("#nama_komisi").focus();
                return false();
            }

            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_komisi/cek_table_k",
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
                        url     : "<?php echo site_url(); ?>henkel_adm_komisi/simpan_k",
                        data    : string,
                        cache   : false,
                        start   : $("#simpan_komisi").html('Sedang diproses...'),
                        success : function(data){
                          $("#simpan_komisi").html('<i class="icon-save"></i> Simpan');
                          var id= $("#id").val();
                          alert(data);
                          location.replace("<?php echo site_url(); ?>henkel_adm_komisi");
                        }
                    });
                  }
                }
            });
        });

        $("#tambah").click(function(){
          $("#id_komisi").val('<? echo $id_komisi ?>');
          $("#range_hari_awal").val('');
          $("#range_hari_akhir").val('');
          $("#penerima_komisi").val('');
          $("#target_komisi").val('');
        });
});


function editData(ID){
    var cari  = ID;
    console.log(cari);
  $.ajax({
    type  : "GET",
    url   : "<?php echo site_url(); ?>henkel_adm_komisi/cari_detail",
    data  : "cari="+cari,
    dataType: "json",
    success : function(data){
      $('#id_komisi_detail').val(data.id_komisi_detail);
      $('#id_komisi').val(data.id_komisi);
      $('#range_hari_awal').val(data.range_hari_awal);
      $('#range_hari_akhir').val(data.range_hari_akhir);
      $('#penerima_komisi').val(data.aktor);
      $('#target_komisi').val(data.target);
    }
  });
}

function hapusData(id){
  var r = confirm("Anda yakin ingin menghapus data ini?");
  if (r == true) {
  $.ajax({
    		type	: "POST",
    		url		: "<?php echo site_url(); ?>henkel_adm_komisi/hapus_detail/"+id,
    		data	: "id_h="+id,
    		dataType: "json",
    		success	: function(){
          location.reload();
    		}
      });
    }
}
</script>
<form class="form-horizontal" name="form_komisi" id="form_komisi" method="post">
<div class="row-fluid">
<div class="table-header">
    <?php echo 'Kode Komisi: '.$kode_komisi;?><input type="hidden" name="kode_komisi" id="kode_komisi" value="<?php echo $kode_komisi?>">
    <input type="hidden" value="<?php echo $id_komisi;?>" name="id" id="id">
</div>
<br />
<?php
error_reporting(E_ALL ^ E_NOTICE);
?>
   <div class="row-fluid">
        <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Skema</label>
                    <div class="controls">
                        <input type="text" class="autocomplete" name="nama_skema" id="nama_skema" value="<?php echo $nama_skema;?>" placeholder="Nama Skema"/>
                    </div>
               </div>
         </div>
    </div>

<div class="table-header">
 Tabel Item Komisi
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
            <th class="center">TOP (Hari)</th>
            <th class="center">Penerima Komisi</th>
            <th class="center">Target Komisi (%)</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=1;
        foreach($data->result() as $dt){ ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->range_hari_awal.' - '.$dt->range_hari_akhir;?></td>
            <td class="center"><?php echo $dt->aktor;?></td>
            <td class="center"><?php echo $dt->target;?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_komisi_detail;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a class="red" href="#" onclick="javascript:hapusData('<?php echo $dt->id_komisi_detail;?>')">
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
          <a href="<?php echo base_url();?>henkel_adm_komisi" class="btn btn-small btn-danger">
             <i class="icon-remove"></i>
             Cancel
          </a>
          <button type="button" name="simpan_komisi" id="simpan_komisi" class="btn btn-small btn-success">
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
            <input type="hidden" name="id_komisi" id="id_komisi">
            <input type="hidden" name="id_komisi_detail" id="id_komisi_detail">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">TOP</label>

                    <div class="controls">
                        <input type="text" class="span2" name="range_hari_awal" id="range_hari_awal" onkeydown="return justAngka(event)" placeholder="Awal" /> -
                        <input type="text" class="span2" name="range_hari_akhir" id="range_hari_akhir" onkeydown="return justAngka(event)" placeholder="Akhir" /> <span style="font-weight:bold"> Hari</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Penerima Komisi</label>

                    <div class="controls">
                        <input type="text" name="penerima_komisi" id="penerima_komisi" placeholder="Penerima Komisi" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Target Komisi</label>

                    <div class="controls">
                        <input type="text" class="span4" name="target_komisi" id="target_komisi" placeholder="Target Komisi" onkeydown="return justAngka(event)"/> <span style="font-weight:bold"> %</span>
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
