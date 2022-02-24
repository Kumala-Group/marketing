<script type="text/javascript">
$(document).ready(function(){

    $("#simpan").click(function(){
        var id_item = $("#id_item").val();
        var jenis_item = $("#jenis_item").val();
        var kode_item = $("#kode_item").val();
        var nama_item = $("#nama_item").val();
        var harga_tebus_dpp = $("#harga_tebus_dpp").val();
        var ongkos_kirim = $("#ongkos_kirim").val();
        var satuan = $("#satuan").val();
        var tipe = $("#tipe").val();
        var stock_kritis = $("#stock_kritis").val();

        var string = $("#my-form").serialize();

        if(jenis_item.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Jenis Item tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#jenis_item").focus();
            return false();
        }

        if(nama_item.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Nama Item tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#nama_item").focus();
            return false();
        }

        if(harga_tebus_dpp.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Harga Tebus DPP tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#harga_tebus_dpp").focus();
            return false();
        }

        if(tipe.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Tipe tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#tipe").focus();
            return false();
        }

        if(satuan.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Satuan tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#satuan").focus();
            return false();
        }

        if(ongkos_kirim.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Ongkos Kirim tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#ongkos_kirim").focus();
            return false();
        }

        if(stock_kritis.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Stock Kritis tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#status_jual").focus();
            return false();
        }

        $.ajax({
            type    : 'POST',
            url     : "<?php echo site_url(); ?>henkel_adm/simpan",
            data    : string,
            cache   : false,
            start   : $("#simpan").html('...Sedang diproses...'),
            success : function(data){
                $("#simpan").html('<i class="icon-save"></i> Simpan');
                alert(data);
                location.reload();
            }
        });

    });

    $("#harga_tebus_dpp").keyup(function(){
      var harga_tebus_dpp = $("#harga_tebus_dpp").val();
     harga_tebus_dpp_clean = toAngka(harga_tebus_dpp);
     var ppn = parseFloat(harga_tebus_dpp_clean)+(parseFloat(harga_tebus_dpp_clean)*10)/100;
     var htdpp_ppn = parseFloat(ppn);
     if (isNaN(htdpp_ppn)) {
       $('#harga_tebus_dpp_ppn').val(0);
     } else {
       $('#harga_tebus_dpp_ppn').val(toHarga(htdpp_ppn));
     }
    });

    $("#jenis_item").change(function(){
        var jenis_item = $('#jenis_item').val();
        if (jenis_item=='henkel') {
           $("#kode_item").val('<?php echo "$kode_item_henkel" ?>');
        } else if (jenis_item=='oli'){
           $("#kode_item").val('<?php echo "$kode_item_oli" ?>');
        } else {
            $("#kode_item").val('<?php echo ''?>');
        }      
        $("#nama_item").val('');
        $("#harga_tebus_dpp").val(0);
        $("#nama_item").attr("readonly", false);
    });

    $("#tambah").click(function(){
        $('#id_item').val('');
        $('#jenis_item').val('');
        $('#kode_item').val('');
        $('#nama_item').val('');
        $('#harga_tebus_dpp').val('');
        $('#harga_tebus_dpp_ppn').val('');
        $('#ongkos_kirim').val('');
        $('#satuan').val('');
        $('#tipe').val('');
        $('#stock_kritis').val('');
    });
});

function editData(ID){
    var cari    = ID;
    console.log(cari);
    $.ajax({
        type    : "GET",
        url     : "<?php echo site_url(); ?>henkel_adm/cari",
        data    : "cari="+cari,
        dataType: "json",
        success : function(data){
            $("#simpan").html('<i class="icon-save"></i> Simpan');
            $('#id_item').val(data.id_item);
            $('#kode_item').val(data.kode_item);
            $('#nama_item').val(data.nama_item);
            $('#harga_pricelist').val(data.harga_pricelist);
            $('#harga_tebus_dpp').val(data.harga_tebus_dpp);
            var harga_tebus_dpp = toAngka(data.harga_tebus_dpp);
            var ppn = parseFloat(harga_tebus_dpp)+(parseFloat(harga_tebus_dpp)*10)/100;
            var htdpp_ppn = parseFloat(ppn);
            $('#harga_tebus_dpp_ppn').val(toHarga(htdpp_ppn));
            $('#ongkos_kirim').val(data.ongkos_kirim);
            $('#tipe').val(data.tipe);
            $('#satuan').html(data.satuan);
            $('#stock_kritis').val(data.stock_kritis);
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
            <th class="center">Kode Item</th>
            <th class="center">Nama Item</th>
            <th class="center">Harga Tebus DPP</th>
            <th class="center">Harga Tebus DPP + PPN</th>
            <th class="center">Harga Pricelist</th>
            <th class="center">Ongkos Kirim</th>
            <th class="center">Satuan</th>
            <th class="center">Tipe</th>
            <th class="center">Stock Kritis</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $i=1;
        foreach($data->result() as $dt){
        $harga_tebus_dpp = $dt->harga_tebus_dpp;
        $ppn = ($harga_tebus_dpp*10)/100;
        $harga_tebus_dpp_ppn = $harga_tebus_dpp+$ppn;
        ?>

        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->kode_item;?></td>
            <td class="center"><?php echo $dt->nama_item;?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($dt->harga_tebus_dpp);?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($harga_tebus_dpp_ppn);?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($dt->harga_pricelist);?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($dt->ongkos_kirim);?></td>
            <td class="center"><?php echo $dt->kode_satuan;?></td>
            <td class="center"><?php echo $dt->tipe;?></td>
            <td class="center"><?php echo $dt->stock_kritis;?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" id="a" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_item;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a class="red" href="<?php echo site_url();?>henkel_adm/hapus/<?php echo $dt->id_item;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
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
            Item
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
              <input type="hidden" name="id_item" id="id_item" />
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Jenis Item</label>

                    <div class="controls">
                        <select id="jenis_item">
                          <option value="">-- Pilih Jenis Item --</option>
                          <option value="henkel">Henkel</option>
                          <option value="oli">Oli</option>
                        </select>
                        <span class="required"> *</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kode Item</label>

                    <div class="controls">
                        <input type="text" name="kode_item" id="kode_item"  readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Item</label>

                    <div class="controls">
                        <input type="text" name="nama_item" id="nama_item" placeholder="Nama Item"/><span class="required"> *</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Harga Pricelist</label>

                    <div class="controls">
                        <input type="text" name="harga_pricelist" class="number" id="harga_pricelist" placeholder="Harga Pricelist"/><span class="required"> *</span><br />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Harga Tebus DPP</label>

                    <div class="controls">
                        <input type="text" name="harga_tebus_dpp" class="number" id="harga_tebus_dpp" placeholder="Harga Tebus DPP" /><span class="required"> *</span><br />
                        <input type="text" name="harga_tebus_dpp_ppn" id="harga_tebus_dpp_ppn" placeholder="Harga Tebus DPP + PPN" readonly/><span class="required" style="font-size:9px;">+PPN(10%)</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Ongkos Kirim</label>

                    <div class="controls">
                        <input type="text" name="ongkos_kirim" id="ongkos_kirim" class="number" placeholder="Ongkos Kirim" onkeyup="javascript:this.value=autoseparator(this.value);" onkeydown="return justAngka(event)"/><span class="required"> *</span>
                    </div>
                </div>
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
                         <option value="<?php echo $dt->kode_satuan;?>"><?php echo $dt->satuan;?></option>
                        <?php
                          }
                        ?>
                       </select>
                       <span class="required"> *</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Tipe</label>

                    <div class="controls">
                        <input type="text" name="tipe" id="tipe" placeholder="Tipe" /><span class="required"> *</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Stock Kritis</label>

                    <div class="controls">
                        <input type="number" name="stock_kritis" id="stock_kritis" class="span3" placeholder="Stock Kritis" /><span class="required"> *</span>
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
