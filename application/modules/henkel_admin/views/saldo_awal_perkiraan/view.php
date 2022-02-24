<script type="text/javascript">
$(document).ready(function(){
$("#simpan").click(function(){
    var id_pesanan_pembelian = $("#id_pesanan_pembelian").val();
    var nama_group = $("#nama_group").val();
    var margin_min = $("#margin_min").val();
    var margin_max = $("#margin_max").val();

    var string = $("#my-form").serialize();



    if(nama_group.length==0){
        $.gritter.add({
            title: 'Peringatan..!!',
            text: 'Nama Group tidak boleh kosong',
            class_name: 'gritter-error'
        });

        $("#nama_group").focus();
        return false();
    }

    if(margin_min.length==0){
        $.gritter.add({
            title: 'Peringatan..!!',
            text: 'Margin Minimal tidak boleh kosong',
            class_name: 'gritter-error'
        });

        $("#margin_min").focus();
        return false();
    }

    if(margin_max.length==0){
        $.gritter.add({
            title: 'Peringatan..!!',
            text: 'Margin Maksimal tidak boleh kosong',
            class_name: 'gritter-error'
        });

        $("#margin_max").focus();
        return false();
    }

    if(margin_min>=margin_max){
        $.gritter.add({
            title: 'Peringatan..!!',
            text: 'Margin Minimal tidak boleh > / = Margin Maksimal',
            class_name: 'gritter-error'
        });

        $("#margin_min").focus();
        return false();
    }

    $.ajax({
        type    : 'POST',
        url     : "<?php echo site_url(); ?>henkel_adm_saldo_awal_perkiraan/simpan",
        data    : string,
        cache   : false,
        success : function(data){
            alert(data);
            location.reload();
        }
    });
});

$("#tambah").click(function(){
    $('#id_saldo_awal_perkiraan').val('');
    $('#kode_saldo_awal_perkiraan').val('<?php echo $kode_saldo_awal_perkiraan; ?>');
    $('#nama_group').val('');
    $('#margin_min').val('');
    $('#margin_max').val('');
});
});

function editData(ID){
    var cari  = ID;
    console.log(cari);
  $.ajax({
    type  : "GET",
    url   : "<?php echo site_url(); ?>henkel_adm_saldo_awal_perkiraan/cari",
    data  : "cari="+cari,
    dataType: "json",
    success : function(data){
      $('#id_saldo_awal_perkiraan').val(data.id_saldo_awal_perkiraan);
      $('#kode_saldo_awal_perkiraan').val(data.kode_saldo_awal_perkiraan);
      $('#nama_group').val(data.nama_group);
      $('#margin_min').val(data.margin_min);
      $('#margin_max').val(data.margin_max);
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
            <th class="center">Kode.Nama Akun</th>
            <th class="center">Jumlah</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $i=1;
        foreach($data->result() as $dt){ ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->kode_akun;?>.<?php echo $dt->nama_akun;?></td>
            <td class="center"><?php echo $dt->value;?></td>
            <td class="td-actions">
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
            Group Pelanggan
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
            <input type="hidden" name="id_saldo_awal_perkiraan"id="id_saldo_awal_perkiraan">
            <br>
            <div class="control-group">
                <label class="control-label" for="form-field-1">Kode Group Pelanggan</label>

                <div class="controls">
                    <input type="text" name="kode_saldo_awal_perkiraan" id="kode_saldo_awal_perkiraan" placeholder="Kode Group Pelanggan" readonly/>
                </div>
            </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Group</label>

                    <div class="controls">
                        <input type="text" name="nama_group" id="nama_group" placeholder="Nama Group"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Margin Min</label>

                    <div class="controls">
                        <input type="number" name="margin_min" id="margin_min" placeholder="Min" class="span3"/><span style="font-weight:bold"> %</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Margin Max</label>

                    <div class="controls">
                        <input type="number" name="margin_max" id="margin_max" placeholder="Max" class="span3"/><span style="font-weight:bold"> %</span>
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
