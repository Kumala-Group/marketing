<script type="text/javascript">
$(document).ready(function(){

    $("#simpan").click(function(){
        var id_gudang = $("#id_gudang").val();
        var kode_gudang = $("#kode_gudang").val();
        var nama_gudang = $("#nama_gudang").val();
        var label_gudang = $("#label_gudang").val();
        var alamat = $("#alamat").val();

        var string = $("#my-form").serialize();



        if(nama_gudang.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Nama Gudang tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#nama_gudang").focus();
            return false();
        }

        if(label_gudang.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Label Gudang tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#label_gudang").focus();
            return false();
        }

        if(alamat.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Alamat tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#alamat").focus();
            return false();
        }

        $.ajax({
            type    : 'POST',
            url     : "<?php echo site_url(); ?>henkel_adm_gudang/simpan",
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
        $('#id_gudang').val('');
        $('#kode_gudang').val('<?php echo $kode_gudang?>');
        $('#nama_gudang').val('');
        $('#label_gudang').val('');
        $('#alamat').val('');
        $('#nama_gudang').focus('');
    });
});

function editData(ID){
    var cari    = ID;
    console.log(cari);
    $.ajax({
        type    : "GET",
        url     : "<?php echo site_url(); ?>henkel_adm_gudang/cari",
        data    : "cari="+cari,
        dataType: "json",
        success : function(data){
            //alert(data.ref);
            $('#id_gudang').val(data.id_gudang);
            $('#kode_gudang').val(data.kode_gudang);
            $('#nama_gudang').val(data.nama_gudang);
            $('#label_gudang').val(data.label_gudang);
            $('#alamat').val(data.alamat);
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
            <th class="center">Kode Gudang</th>
            <th class="center">Nama Gudang</th>
            <th class="center">Label Gudang</th>
            <th class="center">Alamat</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $i=1;
        foreach($data->result() as $dt){ ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td ><?php echo $dt->kode_gudang;?></td>
            <td ><?php echo $dt->nama_gudang;?></td>
            <td ><?php echo $dt->label_gudang;?></td>
            <td ><?php echo $dt->alamat;?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_gudang;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a class="red" href="<?php echo site_url();?>henkel_adm_gudang/hapus/<?php echo $dt->id_gudang;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
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
            Gudang
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
            <input type="hidden" name="id_gudang" id="id_gudang">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kode Gudang</label>

                    <div class="controls">
                        <input type="text" name="kode_gudang" id="kode_gudang" readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Gudang</label>

                    <div class="controls">
                        <input type="text" name="nama_gudang" id="nama_gudang" placeholder="Nama Gudang"/><span class="required"> *</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Label Gudang</label>

                    <div class="controls">
                        <input type="text" name="label_gudang" id="label_gudang" placeholder="Label Gudang"/><span class="required"> *</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Alamat</label>

                    <div class="controls">
                        <input type="text" name="alamat" id="alamat" placeholder="Alamat"/><span class="required"> *</span>
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
