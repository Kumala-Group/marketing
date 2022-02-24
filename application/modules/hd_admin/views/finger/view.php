<script type="text/javascript">
$(document).ready(function(){
$("#simpan").click(function(){
    var id_mesin = $("#id_mesin").val();
    var nama_perangkat = $("#nama_perangkat").val();

    var string = $("#my-form").serialize();



    if(nama_perangkat.length==0){
        $.gritter.add({
            title: 'Peringatan..!!',
            text: 'Nama Mesin Finger tidak boleh kosong',
            class_name: 'gritter-error'
        });

        $("#nama_perangkat").focus();
        return false();
    }

    $.ajax({
        type    : 'POST',
        url     : "<?php echo site_url(); ?>hd_adm_fingerscan/simpan",
        data    : string,
        cache   : false,
        success : function(data){
            alert(data);
            location.reload();
        }
    });
});

$("#tambah").click(function(){
    $('#id_mesin').val('');
    $('#nama_perangkat').val('');
    $('#nama_produk').val('');
    $('#no_serial').val('');
    $('#ip_address').val('');
    $('#port').val('');
});
});

function editData(ID){
    var cari  = ID;
    console.log(cari);
  $.ajax({
    type  : "GET",
    url   : "<?php echo site_url(); ?>hd_adm_fingerscan/cari",
    data  : "cari="+cari,
    dataType: "json",
    success : function(data){
      $('#id_mesin').val(data.id_finger);
      $('#nama_perangkat').val(data.nama_perangkat);
      $('#nama_produk').val(data.nama_produk);
      $('#no_serial').val(data.no_serial);
      $('#ip_address').val(data.ip_address);
      $('#port').val(data.port);
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
            <th class="center">Nama Perangkat</th>
            <th class="center">Nama Produk</th>
            <th class="center">No Serial</th>
            <th class="center">IP Address</th>
            <th class="center">Port</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $i=1;
        foreach($data->result() as $dt){ ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="left"><?php echo $dt->nama_perangkat;?></td>
            <td class="center"><?php echo $dt->nama_produk;?></td>
            <td class="center"><?php echo $dt->no_serial;?></td>
            <td class="center"><?php echo $dt->ip_address;?></td>
            <td class="center"><?php echo $dt->port;?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" data-toggle="modal" onclick="javascript:editData('<?php echo $dt->id_mesin;?>')">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a class="red" href="<?php echo site_url();?>hd_adm_fingerscan/hapus/<?php echo $dt->id_mesin;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
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
            Mesin Finger
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
            <input type="hidden" name="id_finger"id="id_finger">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Perangkat</label>

                    <div class="controls">
                        <input type="text" name="nama" id="nama" placeholder="Nama Perangkat"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Produk</label>

                    <div class="controls">
                        <input type="text" name="nama" id="nama" placeholder="Nama Produk"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">No Serial</label>

                    <div class="controls">
                        <input type="text" name="nama" id="nama" placeholder="No Serial"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">IP Address</label>

                    <div class="controls">
                        <input type="text" name="nama" id="nama" placeholder="IP Address"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Port</label>

                    <div class="controls">
                        <input type="text" name="nama" id="nama" placeholder="Port"/>
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
