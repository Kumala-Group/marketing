<script type="text/javascript">
$(document).ready(function(){
    var date = new Date();
    date.setDate(date.getDate()-1);
    $('.date-picker').datepicker({
      startDate: date
    });

    $("#gudang").change(function(){
       $("#nama_item").val('');
       $("#stok").val('');
       search_kd_item();
    });

    $("#kode_item").change(function(){
       search_nm_item();
       search_stok_item();
    });

    $("#simpan").click(function(){
        var gudang = $("#gudang").val();
        var kode_item = $("#kode_item").val();
        var stok_nyata = parseInt($("#stok_nyata").val());

        var string = $("#my-form").serialize();


        if (gudang=='') {
          $.gritter.add({
              title: 'Peringatan..!!',
              text: 'Gudang tidak boleh kosong',
              class_name: 'gritter-error'
          });
          $("#gudang").focus();
          return false();
        }

        if (kode_item=='') {
          $.gritter.add({
              title: 'Peringatan..!!',
              text: 'Kode Item tidak boleh kosong',
              class_name: 'gritter-error'
          });
          $("#kode_item").focus();
          return false();
        }

        if(stok_nyata==''){
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
            url     : "<?php echo site_url(); ?>/henkel_adm_stok_opname/simpan",
            data    : string,
            cache   : false,
            success : function(data){
                alert(data);
                location.reload();
            }
        });
    });

    $("#stok_nyata").keyup(function(){
      //call function diskon
      var stok_nyata = $('#stok_nyata').val();
      var stok_item = $('#stok').val();
      var selisih = stok_nyata - stok_item
      $('#selisih').val(selisih);
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
        $('#id_mutasi_item').val('');
        $('#tanggal').val(dd+'-'+mm+'-'+yyyy)
        $('#gudang').val('');
        $('#kode_item').val('');
        $('#nama_item').val('');
        $('#stok').val('');
        $('#stok_nyata').val('');
        $('#selisih').val('');
    });
});


    function search_kd_item(){
      var kode_gudang = $("#gudang").val();

      $.ajax({
        type	: "POST",
        url		: "<?php echo site_url(); ?>/henkel_adm_mutasi_item/search_kd_item",
        data	: "kode_gudang="+kode_gudang,
        dataType: "json",
        success	: function(data){
          $('#kode_item').html(data);

        }
      });
    }

    function search_nm_item(){
      var kode_item = $("#kode_item").val();

      $.ajax({
        type	: "POST",
        url		: "<?php echo site_url(); ?>/henkel_adm_mutasi_item/search_nm_item",
        data	: "kode_item="+kode_item,
        dataType: "json",
        success	: function(data){
          $('#nama_item').val(data.nama_item);
        }
      });
    }

    function search_stok_item(){
      var kode_item = $("#kode_item").val();

      $.ajax({
        type	: "POST",
        url		: "<?php echo site_url(); ?>/henkel_adm_mutasi_item/search_stok_item",
        data	: "kode_item="+kode_item,
        dataType: "json",
        success	: function(data){
          $('#stok').val(data.stok);
        }
      });
    }

    function cetakPdf(ID){
        var cari = ID;
        console.log(cari);
      $.ajax({
        type  : "GET",
        url   : "<?php echo site_url(); ?>henkel_adm_stok_opname/cari_pdf",
        data  : "cari="+cari,
        dataType: "json",
        success : function(data){
           window.open("<?php echo site_url(); ?>henkel_adm_stok_opname/cetak_pdf?id_stok_opname="+data.id_stok_opname+"&kode_stok_opname="+data.kode_stok_opname+"&tanggal_awal="+data.tanggal_awal+"&tanggal_akhir="+data.tanggal_akhir+"&kode_gudang="+data.kode_gudang);
        }
      });
    }

    function cetakExcel(ID){
        var cari = ID;
        console.log(cari);
      $.ajax({
        type  : "GET",
        url   : "<?php echo site_url(); ?>henkel_adm_stok_opname/cari_excel",
        data  : "cari="+cari,
        dataType: "json",
        success : function(data){
           window.open("<?php echo site_url(); ?>henkel_adm_stok_opname/cetak_excel?id_stok_opname="+data.id_stok_opname+"&kode_stok_opname="+data.kode_stok_opname+"&tanggal_awal="+data.tanggal_awal+"&tanggal_akhir="+data.tanggal_akhir+"&kode_gudang="+data.kode_gudang);
        }
      });
    }

</script>
<div class="row-fluid">
<div class="table-header">
    <?php echo $judul;?>
    <div class="widget-toolbar no-border pull-right">
        <a href="<?php echo site_url(); ?>henkel_adm_stok_opname/tambah" class="btn btn-small btn-success"  role="button" data-toggle="modal" name="tambah" id="tambah">
            <i class="icon-check"></i>
            Opname
        </a>
    </div>
</div>

<table class="table fpTable lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Kode Stok Opname</th>
            <th class="center">Tanggal Mulai</th>
            <th class="center">Tanggal Akhir</th>
            <th class="center">Kode Gudang</th>
            <th class="center">Nama Gudang</th>
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
            <td class="center">
              <?php if ($dt->status==1){ ?>
                  <a href="<?php echo site_url();?>henkel_adm_stok_opname/edit/<?php echo $dt->id_stok_opname;?>" title="Detail Stok Opname"><?php echo $dt->kode_stok_opname;?></a>
              <?php } elseif ($dt->status==2) { ?>
                  <a href="<?php echo site_url(); ?>henkel_adm_stok_opname/edit_tunda/<?php echo $dt->id_stok_opname;?>"><?php echo $dt->kode_stok_opname;?></a>
              <?php } ?>

              </td>
            <td class="center"><?php echo tgl_sql($dt->tanggal_awal);?></td>
            <td class="center"><?php echo tgl_sql($dt->tanggal_akhir);?></td>
            <td class="center"><?php echo $dt->kode_gudang;?></td>
            <td class="center"><?php echo $dt->nama_gudang;?></td>
            <td class="center">
              <?php
                if ($dt->status==1){
                   echo "<span class='label label-success'>Selesai</span>";
                } elseif ($dt->status==2) {
                   echo "<span class='label label-warning'>Tunda</span>";
                }
              ?>
            </td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                  <?php if ($dt->status==1){ ?>
                      <a href="<?php echo site_url();?>henkel_adm_stok_opname/edit/<?php echo $dt->id_stok_opname;?>" title="Detail Stok Opname">
                          <i class="icon-pencil bigger-130"></i>
                      </a>
                      <a class="green" href="#" onclick="javascript:cetakExcel('<?php echo $dt->id_stok_opname;?>')" title="Cetak Excel">
                          <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                      </a>
                      <a class="red" href="#" onclick="javascript:cetakPdf('<?php echo $dt->id_stok_opname;?>')" >
                        <i class="fa fa-file-pdf-o" data-toggle="tooltip" title="Cetak PDF"></i>
                      </a>
                  <?php } elseif ($dt->status==2) { ?>
                    <a href="<?php echo site_url(); ?>henkel_adm_stok_opname/edit_tunda/<?php echo $dt->id_stok_opname;?>" title="Detail Stok Opname">
                        <i class="icon-pencil bigger-130"></i>
                    </a>
                  <?php } ?>
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
            Stok Opname
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
            <input type="hidden" name="id_stok_opname" id="id_stok_opname" />
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Tanggal</label>

                    <div class="controls">
                        <input type="text" name="tanggal" id="tanggal" placeholder="Tanggal" readonly/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Gudang</label>
                    <div class="controls">
                      <?php ?>
                      <select name="gudang" id="gudang">
                        <option value="" selected="selected">--Pilih Nama Gudang--</option>
                        <?php
                          $data = $this->db_kpp->get('gudang');
                          foreach($data->result() as $dt){
                        ?>
                         <option value="<?php echo $dt->kode_gudang;?>"><?php echo $dt->nama_gudang;?></option>
                        <?php
                          }
                        ?>
                       </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kode Item</label>
                    <div class="controls">
                          <select name="kode_item" id="kode_item" class="autocomplete">
                            <option value="" selected="selected">--Pilih Kode Item--</option>
                          </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Item</label>

                    <div class="controls">
                        <input type="text" name="nama_item" id="nama_item" placeholder="Nama Item" readonly/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Stok Item</label>

                    <div class="controls">
                        <input type="text" id="stok" name="stok" placeholder="Stok Item" readonly/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-field-1">Stok Nyata</label>

                    <div class="controls">
                        <input type="text" onkeydown="return justAngka(event)" id="stok_nyata" name="stok_nyata" placeholder="Stok Nyata" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Selisih</label>

                    <div class="controls">
                        <input type="text" name="selisih" id="selisih" placeholder="Selisih" readonly/>
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
