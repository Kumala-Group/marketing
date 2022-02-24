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

        $("#simpan_sales").click(function(){
            var target_capai = $("#target_capai").val();
            var target_tidakcapai = $("#target_tidakcapai").val();
            var range_hari_awal = $("#range_hari_awal").val();
            var range_hari_akhir = $("#range_hari_akhir").val();

            var string = $("#my-form-sales").serialize();


            if(target_capai.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Komisi Capai Target tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#target_capai").focus();
                return false();
            }

            if(target_tidakcapai.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Komisi Tidak Capai Target tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#target_tidakcapai").focus();
                return false();
            }

            if(range_hari_awal.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'TOP (Hari) Awal tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#range_hari_awal").focus();
                return false();
            }

            if(range_hari_akhir.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'TOP (Hari) Akhir tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#range_hari_akhir").focus();
                return false();
            }

            if(range_hari_awal.length==0 && range_hari_akhir.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Range TOP (Hari) tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#range_hari_awal").focus();
                $("#range_hari_akhir").focus();
                return false();
            }

            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_hitungan_komisi/t_simpan_sales",
                data    : string,
                cache   : false,
                start   : $("#simpan_sales").html('Sedang diproses...'),
                success : function(data){
                    $("#simpan_sales").html('<i class="icon-save"></i> Simpan');
                    alert(data);
                    location.reload();
                }
            });
        });

        $("#simpan_admin").click(function(){
            var satuan = $("#satuan").val();
            var insentif_pcs = $("#insentif_pcs").val();

            var string = $("#my-form-admin").serialize();

            if(satuan.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Satuan tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#satuan").focus();
                return false();
            }

            if(insentif_pcs.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Insentif tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#insentif_pcs").focus();
                return false();
            }

            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_hitungan_komisi/t_simpan_admin",
                data    : string,
                cache   : false,
                start   : $("#simpan_admin").html('Sedang diproses...'),
                success : function(data){
                    $("#simpan_admin").html('<i class="icon-save"></i> Simpan');
                    alert(data);
                    location.reload();
                }
            });
        });

        $("#simpan_komisi").click(function(){
            var id=$("#id").val();
            var nama_komisi = $("#nama_komisi").val();
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
                url     : "<?php echo site_url(); ?>henkel_adm_hitungan_komisi/cek_table_edit",
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
                        url     : "<?php echo site_url(); ?>henkel_adm_hitungan_komisi/simpan_edit",
                        data    : string,
                        cache   : false,
                        start   : $("#simpan_komisi").html('Sedang diproses...'),
                        success : function(data){
                          $("#simpan_komisi").html('<i class="icon-save"></i> Simpan');
                          var id= $("#id").val();
                          alert(data);
                          location.replace("<?php echo site_url(); ?>henkel_adm_hitungan_komisi")
                        }
                    });
                  }
                }
            });
        });

        $("#tambah_sales").click(function(){
          $("#id_form_sales").val('<?php echo $id_komisi ?>');
          $("#id_form_sales_komisi").val('<?php echo $id_komisi_sales ?>');
          $("#range_hari_awal").val('');
          $("#range_hari_akhir").val('');
          $("#target_capai").val('');
          $("#target_tidakcapai").val('');
        });

        $("#tambah_admin").click(function(){
          $("#id_form_admin").val('<?php echo $id_komisi ?>');
          $("#id_form_admin_komisi").val('<?php echo $id_komisi_admin ?>');
          $("#satuan").val('');
          $("#insentif_pcs").val('');
        });

});

function editData_sales(ID){
    var cari  = ID;
    console.log(cari);
  $.ajax({
    type  : "GET",
    url   : "<?php echo site_url(); ?>henkel_adm_hitungan_komisi/cari_sales",
    data  : "cari="+cari,
    dataType: "json",
    success : function(data){
      $('#id_form_sales').val(data.id_komisi);
      $('#id_form_sales_komisi').val(data.id_komisi_sales);
      $('#id_form_sales_komisi').val(data.id_komisi_sales);
      $('#range_hari_awal').val(data.range_hari_awal);
      $('#range_hari_akhir').val(data.range_hari_akhir);
      $('#target_capai').val(data.target_capai);
      $('#target_tidakcapai').val(data.target_tidakcapai);
    }
  });
}

function editData_admin(ID){
    var cari  = ID;
    console.log(cari);
  $.ajax({
    type  : "GET",
    url   : "<?php echo site_url(); ?>henkel_adm_hitungan_komisi/cari_admin",
    data  : "cari="+cari,
    dataType: "json",
    success : function(data){
      $('#id_form_admin').val(data.id_komisi);
      $('#id_form_admin_komisi').val(data.id_komisi_admin);
      $('#id_form_admin_komisi').val(data.id_komisi_admin);
      $('#satuan').html(data.satuan);
      $('#insentif_pcs').val(data.insentif_pcs);
    }
  });
}

function hapusData_sales(id){
  var r = confirm("Anda yakin ingin menghapus data ini?");
  if (r == true) {
  $.ajax({
    		type	: "POST",
    		url		: "<?php echo site_url(); ?>henkel_adm_hitungan_komisi/hapus_sales/"+id,
    		data	: "id_h="+id,
    		dataType: "json",
    		success	: function(){
          location.reload();
    		}
      });
    }
 }

 function hapusData_admin(id){
   var r = confirm("Anda yakin ingin menghapus data ini?");
   if (r == true) {
   $.ajax({
     		type	: "POST",
     		url		: "<?php echo site_url(); ?>henkel_adm_hitungan_komisi/hapus_admin/"+id,
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
                    <label class="control-label" for="form-field-1">Nama Komisi</label>
                    <div class="controls">
                        <input type="text" class="autocomplete" name="nama_komisi" id="nama_komisi" value="<?php echo $nama_komisi;?>" placeholder="Nama Komisi" />
                    </div>
               </div>
         </div>
    </div>
<br />
<div class="table-header">
 Tabel Item Komisi (Sales/Operational Manager/Kolektor)
 <div class="widget-toolbar no-border pull-right">
   <a href="#modal-table-sales" data-toggle="modal" name="tambah_sales" id="tambah_sales" class="btn btn-small btn-success">
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
            <th class="center">Komisi Capai Target (%) </th>
            <th class="center">Komisi Tidak Capai Target (%) </th>
            <th class="center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=1;
        foreach($data_sales->result() as $dt_sales){ ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt_sales->range_hari_awal.' - '.$dt_sales->range_hari_akhir;?></td>
            <td class="center"><?php echo $dt_sales->target_capai;?></td>
            <td class="center"><?php echo $dt_sales->target_tidakcapai;?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table-sales" onclick="javascript:editData_sales('<?php echo $dt_sales->id_komisi_sales;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a class="red" href="#" onclick="javascript:hapusData_sales('<?php echo $dt_sales->id_komisi_sales;?>')">
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

<div class="table-header">
 Tabel Item Komisi (Admin/Gudang)
 <div class="widget-toolbar no-border pull-right">
   <a href="#modal-table-admin" data-toggle="modal" name="tambah_admin" id="tambah_admin" class="btn btn-small btn-success">
       <i class="icon-plus"></i>
       Tambah Item
   </a>
 </div>
</div>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Satuan</th>
            <th class="center">Insentif (pcs)</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=1;
        foreach($data_admin->result() as $dt_admin){ ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <?php
              $id_satuan=$this->model_hitungan_komisi->getKd_satuan($dt_admin->id_satuan);
              foreach ($id_satuan as $row) {
            ?>
            <td class="center"><?php echo $row->satuan;?></td>
            <?php } ?>
            <td class="center"><?php echo $dt_admin->insentif_pcs;?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table-admin" onclick="javascript:editData_admin('<?php echo $dt_admin->id_komisi_admin;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a class="red" href="#" onclick="javascript:hapusData_admin('<?php echo $dt_admin->id_komisi_admin;?>')">
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

<div id="modal-table-sales" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Tambah Item
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form-sales" id="my-form-sales">
              <input type="hidden" name="id_form_sales" id="id_form_sales">
              <input type="hidden" name="id_form_sales_komisi" id="id_form_sales_komisi">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">TOP</label>

                    <div class="controls">
                        <input type="text" class="span4" name="range_hari_awal" id="range_hari_awal" onkeydown="return justAngka(event)" placeholder="Awal" /> -
                        <input type="text" class="span4" name="range_hari_akhir" id="range_hari_akhir" onkeydown="return justAngka(event)" placeholder="Akhir" /> <span style="font-weight:bold"> Hari</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Komisi Capai Target</label>

                    <div class="controls">
                        <input type="text" class="span8" name="target_capai" id="target_capai" placeholder="Komisi Capai Target" onkeydown="return justAngka(event)"/> <span style="font-weight:bold"> %</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Komisi Tidak Capai Target</label>

                    <div class="controls">
                        <input type="text" class="span8" name="target_tidakcapai" id="target_tidakcapai" placeholder="Komisi Tidak Capai Target" onkeydown="return justAngka(event)"/> <span style="font-weight:bold"> %</span>
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
        <button type="button" name="simpan_sales" id="simpan_sales" class="btn btn-small btn-success pull-left">
            <i class="icon-save"></i>
            Simpan
        </button>
        </div>
    </div>
</div>

<div id="modal-table-admin" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Tambah Item
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form-admin" id="my-form-admin">
            <input type="hidden" name="id_form_admin" id="id_form_admin">
            <input type="hidden" name="id_form_admin_t_komisi" id="id_form_admin_t_komisi">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Satuan</label>
                    <div class="controls">
                      <?php ?>
                      <select name="satuan" id="satuan">
                        <option value="" selected="selected">--Pilih Satuan--</option>
                        <?php
                          $data = $this->db_kpp->get('satuan');
                          foreach($data->result() as $dt){
                        ?>
                         <option value="<?php echo $dt->id_satuan;?>"><?php echo $dt->satuan;?></option>
                        <?php
                          }
                        ?>
                       </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Insentif (pcs)</label>

                    <div class="controls">
                        <input type="text" name="insentif_pcs" id="insentif_pcs" onkeydown="return justAngka(event)" placeholder="Insentif (pcs)"/> <span style="font-weight:bold"> Rp</span>
                    </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pagination pull-right no-margin">
                    <button type="button" class="btn btn-small btn-danger pull-left" data-dismiss="modal">
                        <i class="icon-remove"></i>
                        Close
                    </button>
                    <button type="button" name="simpan_admin" id="simpan_admin" class="btn btn-small btn-success pull-left">
                        <i class="icon-save"></i>
                        Simpan
                    </button>
                    </div>
                </div>
            </form>
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
