<script type="text/javascript">
$(document).ready(function(){

    $("#simpan").click(function(){
        var id_jenis_pembayaran = $("#id_jenis_pembayaran").val();
        var jenis_pembayaran = $("#jenis_pembayaran").val();

        var string = $("#my-form").serialize();


        if(jenis_pembayaran.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Jenis Pembayaran tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#jenis_pembayaran").focus();
            return false();
        }

        $.ajax({
            type    : 'POST',
            url     : "<?php echo site_url(); ?>henkel_adm_jenis_pembayaran/simpan",
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

    $("#tambah").click(function(){
       $('#id_jenis_pembayaran').val('');
        $('#jenis_pembayaran').val('');
        $('#jenis_pembayaran').focus('');
    });
});

function editData(ID){
    var cari    = ID;
    console.log(cari);
    $.ajax({
        type    : "GET",
        url     : "<?php echo site_url(); ?>henkel_adm_jenis_pembayaran/cari",
        data    : "cari="+cari,
        dataType: "json",
        success : function(data){
            //alert(data.ref);
            $('#id_jenis_pembayaran').val(data.id_jenis_pembayaran);
            $('#jenis_pembayaran').val(data.jenis_pembayaran);
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
            <th class="center">Jenis Pembayaran</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $i=1;
        foreach($data->result() as $dt){ ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->jenis_pembayaran;?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_jenis_pembayaran;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a class="red" href="<?php echo site_url();?>henkel_adm_jenis_pembayaran/hapus/<?php echo $dt->id_jenis_pembayaran;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
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
            Jenis Pembayaran
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
            <input type="hidden" name="id_jenis_pembayaran" id="id_jenis_pembayaran">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Jenis Pembayaran</label>

                    <div class="controls">
                        <input type="text" name="jenis_pembayaran" id="jenis_pembayaran" placeholder="Jenis Pembayaran" />
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
