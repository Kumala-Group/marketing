<script type="text/javascript">
$(document).ready(function(){
$("#simpan").click(function(){
    var id_pesanan_pembelian = $("#id_pesanan_pembelian").val();
    var nama_group = $("#nama_group").val();
    var margin_min = parseInt($("#margin_min").val());
    var margin_max = parseInt($("#margin_max").val());

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
        url     : "<?php echo site_url(); ?>henkel_adm_group_pelanggan/simpan",
        data    : string,
        cache   : false,
        success : function(data){
            alert(data);
            location.reload();
        }
    });
});

$("#tambah").click(function(){
    $('#id_group_pelanggan').val('');
    $('#kode_group_pelanggan').val('<?php echo $kode_group_pelanggan; ?>');
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
    url   : "<?php echo site_url(); ?>henkel_adm_group_pelanggan/cari",
    data  : "cari="+cari,
    dataType: "json",
    success : function(data){
      $('#id_group_pelanggan').val(data.id_group_pelanggan);
      $('#kode_group_pelanggan').val(data.kode_group_pelanggan);
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
            <th class="center">Nama Group</th>
            <th class="center">Margin Min</th>
            <th class="center">Margin Max</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $i=1;
        foreach($data->result() as $dt){ ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->nama_group;?></td>
            <td class="center"><?php echo $dt->margin_min;?></td>
            <td class="center"><?php echo $dt->margin_max;?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" data-toggle="modal" onclick="javascript:editData('<?php echo $dt->id_group_pelanggan;?>')">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a class="red" href="<?php echo site_url();?>henkel_adm_group_pelanggan/hapus/<?php echo $dt->id_group_pelanggan;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
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
            Group Pelanggan
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
            <input type="hidden" name="id_group_pelanggan"id="id_group_pelanggan">
            <br>
            <div class="control-group">
                <label class="control-label" for="form-field-1">Kode Group Pelanggan</label>

                <div class="controls">
                    <input type="text" name="kode_group_pelanggan" id="kode_group_pelanggan" placeholder="Kode Group Pelanggan" readonly/>
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
