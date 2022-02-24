<script type="text/javascript">
$(document).ready(function(){
    var date = new Date();
    date.setDate(date.getDate()-1);
    $('.date-picker').datepicker({
      startDate: date
    });

    /*$("#kode_item").autocomplete({
            // serviceUrl berisi URL ke controller/fungsi yang menangani request kita
            serviceUrl: '<?php echo site_url();?>henkel_adm_stok_awal_item/search_kd_item',
            // fungsi ini akan dijalankan ketika user memilih salah satu hasil request
            onSelect: function (suggestion) {
                $('#nama_item').val(''+suggestion.nama_item);
                $('#tipe').val(''+suggestion.tipe);
            }

    });*/

    $("#simpan").click(function(){
        var kode_gudang = $("#kode_gudang").val();
        var kode_item = $("#kode_item").val();
        var nama_item = $("#nama_item").val();
        var tipe = $("#tipe").val();
        var harga_perkiraan = toAngka($("#harga_perkiraan").val());
        var tambah_stok = $("#tipe").val();

        var string = $("#my-form").serialize();


        if (kode_gudang=='') {
          $.gritter.add({
              title: 'Peringatan..!!',
              text: 'Kode Gudang tidak boleh kosong',
              class_name: 'gritter-error'
          });
          $("#kode_gudang").focus();
          return false();
        }

        if (nama_item=='') {
          $.gritter.add({
              title: 'Peringatan..!!',
              text: 'Nama Item tidak boleh kosong',
              class_name: 'gritter-error'
          });
          $("#nama_item").focus();
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

        if(tipe==''){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Tipe tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#tipe").focus();
            return false();
        }

        if(harga_perkiraan==''){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Harga Perkiraan tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#harga_perkiraan").focus();
            return false();
        }

        if(tambah_stok==''){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Tambah Stok tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#tambah_stok").focus();
            return false();
        }

        $.ajax({
            type    : 'POST',
            url     : "<?php echo site_url(); ?>henkel_adm_stok_awal_item/simpan",
            data    : string,
            cache   : false,
            success : function(data){
                alert(data);
                location.reload();
            }
        });
    });

    $("#tambah").click(function(){
        var today = new Date();
        var yyyy = today.getFullYear();
        var mm = today.getMonth()+1;
        if(mm<10) {
          mm = '0'+mm;
        }
        var dd = today.getDate();
        if(dd<10) {
          dd = '0'+dd;
        }
        $('#id_stok_awal_item').val('');
        $('#tanggal').val(dd+'-'+mm+'-'+yyyy);
        $('#kode_gudang').val('');
        $('#kode_item').val('<?php echo $kode_item?>');
        $('#nama_item').val('');
        $('#tipe').val('');
        $('#harga_perkiraan').val('');
        $('#tambah_stok').val('');
    });
});

function editData(ID){
    var cari    = ID;
    console.log(cari);
    $.ajax({
        type    : "GET",
        url     : "<?php echo site_url(); ?>henkel_adm_stok_awal_item/cari",
        data    : "cari="+cari,
        dataType: "json",
        success : function(data){
            $('#id_stok_awal_item').val(data.id_stok_awal_item);
            $('#tanggal').val(data.tanggal);
            $('#kode_gudang').html(data.kode_gudang);
            $('#kode_item').val(data.kode_item);
            $('#nama_item').val(data.nama_item);
            $('#tipe').val(data.tipe);
            $('#harga_perkiraan').val(data.harga_perkiraan);
            $('#tambah_stok').val(data.tambah_stok);
        }
    });
}


   function search_kd_item(){
      var kode_item = $("#kode_item").val();

      $.ajax({
        type	: "POST",
        url		: "<?php echo site_url(); ?>henkel_adm_stok_awal_item/search_kd_item",
        data	: "kode_item="+kode_item,
        dataType: "json",
        success	: function(data){
          $('#nama_item').val(data.nama_item);
          $('#tipe').val(data.tipe);
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
<div class="row-fluid">
<div class="table-header">
    <?php echo $judul;?>
    <div class="widget-toolbar no-border pull-right">
        <a href="<?php echo site_url();?>henkel_adm_stok_awal_item/cetak" class="btn btn-small btn-success"  role="button" data-toggle="modal" name="cetak" id="cetak">
            <i class="icon-print"></i>
            Cetak
        </a>
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
            <th class="center">Tanggal</th>
            <th class="center">Kode Gudang</th>
            <th class="center">Nama Gudang</th>
            <th class="center">Kode Item</th>
            <th class="center">Nama Item</th>
            <th class="center">Tipe</th>
            <th class="center">Harga Perkiraan</th>
            <th class="center">Tambah Stok</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $i=1;
        foreach($data->result() as $dt){ ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo tgl_sql($dt->tanggal);?></td>
            <td class="center"><?php echo $dt->kode_gudang;?></td>
            <td class="center"><?php echo $dt->nama_gudang;?></td>
            <td class="center"><?php echo $dt->kode_item;?></td>
            <td class="center"><?php echo $dt->nama_item;?></td>
            <td class="center"><?php echo $dt->tipe;?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($dt->harga_perkiraan);?></td>
            <td class="center"><?php echo $dt->tambah_stok;?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_stok_awal_item;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a class="red" href="<?php echo site_url();?>henkel_adm_stok_awal_item/hapus/<?php echo $dt->id_stok_awal_item;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
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
</div>

<div id="modal-table" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Stok Awal Item
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
            <input type="hidden" name="id_stok_awal_item" id="id_stok_awal_item" />
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
                      <select name="kode_gudang" id="kode_gudang">
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
                        <input type="text" name="kode_item" id="kode_item" placeholder="Kode Item" readonly class="autocomplete"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Item</label>

                    <div class="controls">
                        <input type="text" name="nama_item" id="nama_item" placeholder="Nama Item"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Tipe</label>

                    <div class="controls">
                        <input type="text" name="tipe" id="tipe" placeholder="Tipe"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Harga Perkiraan</label>

                    <div class="controls">
                        <input type="text" class="number"name="harga_perkiraan" id="harga_perkiraan" placeholder="Harga Perkiraan" onkeydown="return justAngka(event)" onkeyup="javascript:this.value=autoseparator(this.value);"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Tambah Stok</label>

                    <div class="controls">
                        <input type="text" name="tambah_stok" id="tambah_stok" placeholder="Tambah Stok"/>
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
