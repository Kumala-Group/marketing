<script type="text/javascript">
$(document).ready(function(){
    var date = new Date();
    date.setDate(date.getDate()-1);
    $('.date-picker').datepicker({
      startDate: date
    });

    $("#gudang_asal").change(function(){
       $("#nama_item").val('');
       search_kd_item();
    });

    $("#kode_item").change(function(){
       search_nm_item();
       search_stok_item();
    });

    $("#simpan").click(function(){
        var gudang_asal = $("#gudang_asal").val();
        var gudang_tujuan = $("#gudang_tujuan").val();
        var jumlah = parseInt($("#jumlah").val());
        var stok = parseInt($("#stok").val());
        var keterangan = $("#keterangan").val();
        var tanggal_mutasi = $("#tanggal_mutasi").val();

        var string = $("#my-form").serialize();


        if (gudang_asal=='') {
          $.gritter.add({
              title: 'Peringatan..!!',
              text: 'Gudang Asal tidak boleh kosong',
              class_name: 'gritter-error'
          });
          $("#gudang_asal").focus();
          return false();
        }

        if (gudang_tujuan=='') {
          $.gritter.add({
              title: 'Peringatan..!!',
              text: 'Gudang Tujuan tidak boleh kosong',
              class_name: 'gritter-error'
          });
          $("#gudang_tujuan").focus();
          return false();
        }

        if (gudang_asal==gudang_tujuan) {
          $.gritter.add({
              title: 'Peringatan..!!',
              text: 'Gudang Asal & Gudang Tujuan tidak boleh sama',
              class_name: 'gritter-error'
          });
          return false();
        }

        if(jumlah>stok){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Jumlah melebihi stok item',
                class_name: 'gritter-error'
            });

            $("#jumlah").focus();
            return false();
        }

        if(jumlah<1){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Jumlah tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#jumlah").focus();
            return false();
        }

        if(tanggal_mutasi.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Tanggal Mutasi tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#tanggal_mutasi").focus();
            return false();
        }

        $.ajax({
            type    : 'POST',
            url     : "<?php echo site_url(); ?>/henkel_adm_mutasi_item/simpan",
            data    : string,
            cache   : false,
            success : function(data){
                alert(data);
                location.reload();
            }
        });

    });

    $("#tambah").click(function(){
        $('#id_mutasi_item').val('');
        $('#gudang_asal').val('');
        $('#gudang_tujuan').val('');
        $('#kode_item').val('');
        $('#nama_item').val('');
        $('#stok').val('');
        $('#jumlah').val('');
        $('#keterangan').val('');
        $('#tanggal_mutasi').val('');
    });
});

function editData(ID){
    var cari    = ID;
    console.log(cari);
    $.ajax({
        type    : "GET",
        url     : "<?php echo site_url(); ?>/henkel_adm_mutasi_item/cari",
        data    : "cari="+cari,
        dataType: "json",
        success : function(data){
            $('#id_mutasi_item').val(data.id_mutasi_item);
            $('#gudang_asal').val(data.gudang_asal);
            $('#gudang_tujuan').val(data.gudang_tujuan);
            $('#kode_item').html(data.kode_item);
            $('#nama_item').val(data.nama_item);
            $('#jumlah').val(data.jumlah);
            $('#keterangan').val(data.keterangan);
            $('#tanggal_mutasi').val(data.tanggal_mutasi);
        }
    });
}



    function search_kd_item(){
      var kode_gudang = $("#gudang_asal").val();

      $.ajax({
        type  : "POST",
        url   : "<?php echo site_url(); ?>/henkel_adm_mutasi_item/search_kd_item",
        data  : "kode_gudang="+kode_gudang,
        dataType: "json",
        success : function(data){
          $('#kode_item').html(data);

        }
      });
    }

    function search_nm_item(){
      var kode_item = $("#kode_item").val();

      $.ajax({
        type  : "POST",
        url   : "<?php echo site_url(); ?>/henkel_adm_mutasi_item/search_nm_item",
        data  : "kode_item="+kode_item,
        dataType: "json",
        success : function(data){
          $('#nama_item').val(data.nama_item);
        }
      });
    }

    function search_stok_item(){
      var kode_item = $("#kode_item").val();
      var kode_gudang = $("#gudang_asal").val();

      $.ajax({
        type  : "POST",
        url   : "<?php echo site_url(); ?>/henkel_adm_mutasi_item/search_stok_item",
        data  : "kode_item="+kode_item+"&kode_gudang="+kode_gudang,
        dataType: "json",
        success : function(data){
          $('#stok').val(data.stok);
        }
      });
    }

</script>
<div class="row-fluid">
<div class="table-header">
    <?php echo $judul;?>
    <div class="widget-toolbar no-border pull-right">
        <a href="#modal-table" class="btn btn-small btn-success"  role="button" data-toggle="modal" name="tambah" id="tambah">
            <i class="icon-check"></i>
            Tambah Data
        </a>
    </div>
</div>

<table class="table fpTable lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Gudang Asal</th>
            <th class="center">Gudang Tujuan</th>
            <th class="center">Kode Item</th>
            <th class="center">Nama Item</th>
            <th class="center">Jumlah</th>
            <th class="center">Tanggal Mutasi</th>
            <th class="center">Keterangan</th>
            <!--<th class="center">Aksi</th>-->
        </tr>
    </thead>

    <tbody>
        <?php

        $i=1;
        foreach($data->result() as $dt){ ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td ><?php echo $dt->gudang_asal.' - '.$dt->gd_asal;?></td>
            <td ><?php echo $dt->gudang_tujuan.' - '.$dt->gd_tujuan;?></td>
            <td class="center"><?php echo $dt->kode_item;?></td>
            <td class="center"><?php echo $dt->nama_item;?></td>
            <td class="center"><?php echo $dt->jumlah;?></td>
            <td class="center"><?php echo tgl_sql($dt->tanggal_mutasi);?></td>
            <td class="center"><?php echo $dt->keterangan;?></td>
            <!--<td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_mutasi_item;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a class="red" href="<?php echo site_url();?>/henkel_adm_mutasi_item/hapus/<?php echo $dt->id_mutasi_item;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
                        <i class="icon-trash bigger-130"></i>
                    </a>
                </div>-->

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
            Mutasi Item
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
              <input type="hidden" name="id_mutasi_item" id="id_mutasi_item" />
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Gudang Asal</label>
                    <div class="controls">
                      <?php ?>
                      <select name="gudang_asal" id="gudang_asal">
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
                    <label class="control-label" for="form-field-1">Gudang Tujuan</label>
                    <div class="controls">
                      <?php ?>
                      <select name="gudang_tujuan" id="gudang_tujuan">
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
                            <option value="" selected="selected">-- Pilih Kode Item --</option>
                          </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Item</label>

                    <div class="controls">
                        <input type="text" name="nama_item" id="nama_item" placeholder="Nama Item" readonly/>
                    </div>
                </div>

                <input type="hidden" id="stok" name="stok">

                <div class="control-group">
                    <label class="control-label" for="form-field-1">Jumlah</label>

                    <div class="controls">
                        <input type="text" onkeydown="return justAngka(event)" name="jumlah" id="jumlah" placeholder="Jumlah" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Keterangan</label>

                    <div class="controls">
                        <input type="text" name="keterangan" id="keterangan" placeholder="Keterangan" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Tanggal Mutasi</label>
                    <div class="controls">
                      <div class="input-append">
                        <input type="text" name="tanggal_mutasi" id="tanggal_mutasi" class="date-picker"  data-date-format="dd-mm-yyyy" placeholder="Tanggal Mutasi"/>
                      </div>
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
