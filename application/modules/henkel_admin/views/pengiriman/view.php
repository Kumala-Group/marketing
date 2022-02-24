
<script type="text/javascript">
$(document).ready(function(){
    $("#simpan").click(function(){
        var id_pesanan_pengiriman = $("#id_pesanan_pengiriman").val();
        var no_po = $("#no_po").val();
        var tanggal = $("#tanggal").val();
        var nama_supplier = $("#nama_supplier").val();

        var string = $("#my-form").serialize();



        if(nama_supplier.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Nama Supplier tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#nama_supplier").focus();
            return false();
        }

        $.ajax({
            type    : 'POST',
            url     : "<?php echo site_url(); ?>/henkel_adm_pengiriman/simpan",
            data    : string,
            cache   : false,
            success : function(data){
                alert(data);
                location.reload();
            }
        });

    });

    $("#tambah").click(function(){
        var d = new Date();
        $('#id_pesanan_pengiriman').val('');
        $('#no_po').val('<?php echo $no_po;?>');
        $('#tanggal').val(d.getFullYear()+'-'+("0" + (d.getMonth() + 1)).slice(-2)+'-'+d.getDate());
        $('#supplier').val('');
    });
});

function editData(ID){
    var cari    = ID;
    console.log(cari);
    $.ajax({
        type    : "GET",
        url     : "<?php echo site_url(); ?>/henkel_adm_pengiriman/cari",
        data    : "cari="+cari,
        dataType: "json",
        success : function(data){
            //alert(data.ref);
            $('#id_pesanan_pengiriman').val(data.id_pesanan_pengiriman);
            $('#no_po').val(data.no_po);
            $('#tanggal').val(data.tanggal);
            $('#supplier').val(data.supplier);
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
            <th class="center">No PO</th>
            <th class="center">Tanggal</th>
            <th class="center">Supplier</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $i=1;
        foreach($data->result() as $dt){ ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->no_po;?></td>
            <td class="center"><?php echo $dt->tanggal;?></td>
            <td class="center"><?php echo $dt->supplier;?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" onclsick="javascript:editData('<?php echo $dt->id_pengiriman;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a class="red" href="<?php echo site_url();?>/henkel_adm_pengiriman/hapus/<?php echo $dt->id_pengiriman;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
                        <i class="icon-trash bigger-130"></i>
                    </a>
                    <a class="red" href="">
                        <i class="fa fa-print"></i>
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
            Pembelian
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
            <input type="hidden" name="id_pesanan_pengiriman"id="id_pesanan_pengiriman">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">No PO</label>

                    <div class="controls">
                        <input type="text" name="no_po" id="no_po" readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Tanggal</label>

                    <div class="controls">
                        <input type="text" name="tanggal" id="tanggal" readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Supplier</label>
                    <div class="controls">
                        <select name="nama_supplier" id="nama_supplier">
                        <option value="" selected="selected">-- Pilih Supplier --</option>
                        <?php
                            $data = $this->model_pengiriman->data_supplier();
                            foreach($data->result() as $dt){
                        ?>
                        <option value="<?php echo $dt->id_supplier;?>"><?php echo $dt->nama_supplier;?></option>
                        <?php
                            }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Item</label>
                    <div class="controls">
                        <select name="nama_supplier" id="nama_supplier">
                        <option value="" selected="selected">-- Pilih Item --</option>
                        <?php
                            $data = $this->model_pengiriman->data_item();
                            foreach($data->result() as $dt){
                        ?>
                        <option value="<?php echo $dt->id_item;?>"><?php echo $dt->nama_item;?></option>
                        <?php
                            }
                        ?>
                        </select>

                        <br />
                        <div id="items">
                            <div></div>
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
