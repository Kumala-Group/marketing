<script type="text/javascript">
$(document).ready(function(){

    $("#simpan").click(function(){
        var id_supplier = $("#id_supplier").val();
        var kode_supplier = $("#kode_supplier").val();
        var nama_supplier = $("#nama_supplier").val();
        var alamat = $("#alamat").val();
        var kota = $("#kota").val();
        var telepon = $("#telepon").val();
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

        if(alamat.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Alamat tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#alamat").focus();
            return false();
        }

        if(kota.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Kota tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#kota").focus();
            return false();
        }

        if(telepon.length==""){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Telepon tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#telepon").focus();
            return false();
        }

        $.ajax({
            type    : 'POST',
            url     : "<?php echo site_url(); ?>henkel_adm_supplier/simpan",
            data    : string,
            cache   : false,
            start : $("#simpan").html('...Sedang diproses...'),
            success : function(data){
                $("#simpan").html('<i class="icon-save"></i> Simpan');
                alert(data);
                location.reload();
            }
        });

    });

    $("#kategori_supplier").change(function(){
        var kategori_supplier = $('#kategori_supplier').val();
        if (kategori_supplier=='henkel') {
           $("#kode_supplier").val('<?php echo "$kode_supplier_henkel" ?>');
        } else if (kategori_supplier=='oli'){
           $("#kode_supplier").val('<?php echo "$kode_supplier_oli" ?>');
        } else {
            $("#kode_supplier").val('<?php echo ''?>');
        }      
        $("#nama_item").val('');
        $("#harga_tebus_dpp").val(0);
        $("#nama_item").attr("readonly", false);
    });

    $("#tambah").click(function(){
        $('#id_kode_supplier').val('');
        $('#kategori_supplier').val('');
        $('#kode_supplier').val('');
        $('#nama_supplier').val('');
        $('#alamat').val('');
        $('#kota').val('');
        $('#telpon').val();
        $('#email').val();
        $('#kontak').focus('');
        $('#provinsi').val('');
        $('#kodepos').val('');
        $('#fax').focus('');
        $('#no_rekening').val();
        $('#nama_rekening').val();
        $('#nama_bank').focus('');
        $('#keterangan').focus('');
        $('#npwp').val('');
    });
});

function editData(ID){
    var cari    = ID;
    console.log(cari);
    $.ajax({
        type    : "GET",
        url     : "<?php echo site_url(); ?>henkel_adm_supplier/cari",
        data    : "cari="+cari,
        dataType: "json",
        success : function(data){
            //alert(data.ref);
            $('#id_supplier').val(data.id_supplier);
            $('#kategori_supplier').val(data.kategori_supplier);
            $('#kode_supplier').val(data.kode_supplier);
            $('#nama_supplier').val(data.nama_supplier);
            $('#alamat').val(data.alamat);
            $('#kota').val(data.kota);
            $('#telepon').val(data.telepon);
            $('#email').val(data.email);
            $('#kontak').val(data.kontak);
            $('#provinsi').val(data.provinsi);
            $('#kodepos').val(data.kodepos);
            $('#fax').val(data.fax);
            $('#no_rekening').val(data.no_rekening);
            $('#nama_rekening').val(data.nama_rekening);
            $('#nama_bank').val(data.nama_bank);
            $('#keterangan').val(data.keterangan);
            $('#npwp').val(data.npwp);
        }
    });
}

function showDetail(ID){
    var cari    = ID;
    console.log(cari);
    $.ajax({
        type    : "GET",
        url     : "<?php echo site_url(); ?>henkel_adm_supplier/cari",
        data    : "cari="+cari,
        dataType: "json",
        success : function(data){
            //alert(data.ref);
            $('#id_supplier_detail').html(data.id_supplier);
            $('#kode_supplier_detail').html(data.kode_supplier);
            $('#nama_supplier_detail').html(data.nama_supplier);
            $('#alamat_detail').html(data.alamat);
            $('#kota_detail').html(data.kota);
            $('#telepon_detail').html(data.telepon);
            $('#email_detail').html(data.email);
            $('#kontak_detail').html(data.kontak);
            $('#provinsi_detail').html(data.provinsi);
            $('#kodepos_detail').html(data.kodepos);
            $('#fax_detail').html(data.fax);
            $('#no_rekening_detail').html(data.no_rekening);
            $('#nama_rekening_detail').html(data.nama_rekening);
            $('#nama_bank_detail').html(data.nama_bank);
            $('#keterangan_detail').html(data.keterangan);
            $('#npwp_detail').html(data.npwp);
        }
    });
}
</script>
<style type="text/css">
    textarea {
        resize: none;
    }
</style>
<div id="divLoading">
</div>
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

<table class="table fpTable lcnp table-striped table-bordered table-hover" id="my-table">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Kode Supplier</th>
            <th class="center">Nama Supplier</th>
            <th class="center">Alamat</th>
            <th class="center">Kota</th>
            <th class="center">Telepon</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $i=1;
        foreach($data->result() as $dt){ ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->kode_supplier;?></td>
            <td class="center"><?php echo $dt->nama_supplier;?></td>
            <td class="center"><!--<p style="word-wrap: break-word; width: 150px;">--><?php echo $dt->alamat;?></td>
            <td class="center"><?php echo $dt->kota;?></td>
            <td class="center"><?php echo $dt->telepon;?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_supplier;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a class="red" href="<?php echo site_url();?>henkel_adm_supplier/hapus/<?php echo $dt->id_supplier;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
                        <i class="icon-trash bigger-130"></i>
                    </a>
                    <a class="blue" href="#modal-table-detail" onclick="javascript:showDetail('<?php echo $dt->id_supplier;?>')" data-toggle="modal" title="Detail">
                      <i class="fa fa-list" aria-hidden="true"></i>
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
                            <li>
                                <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                                    <span class="red">
                                      <i class="fa fa-list" aria-hidden="true"></i>
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
            Supplier
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
            <input type="hidden" name="id_supplier" id="id_supplier">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kategori Supplier</label>

                    <div class="controls">
                        <select id="kategori_supplier">
                          <option value="">-- Pilih Kategori Supplier --</option>
                          <option value="henkel">Henkel</option>
                          <option value="oli">Oli</option>
                        </select>
                        <span class="required"> *</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kode Supplier</label>

                    <div class="controls">
                        <input type="text" name="kode_supplier" id="kode_supplier" readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Supplier</label>

                    <div class="controls">
                        <input type="text" name="nama_supplier" id="nama_supplier" placeholder="Nama Supplier"/><span class="required"> *</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Alamat</label>

                    <div class="controls">
                        <textarea name="alamat" id="alamat" placeholder="Alamat"></textarea><span class="required"> *</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kota</label>

                    <div class="controls">
                        <input type="text" name="kota" id="kota" placeholder="Kota" /><span class="required"> *</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Telepon</label>

                    <div class="controls">
                        <input type="text" name="telepon" id="telepon" placeholder="Telepon" /><span class="required"> *</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Email</label>

                    <div class="controls">
                        <input type="text" name="email" id="email" placeholder="Email" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kontak</label>

                    <div class="controls">
                        <input type="text" name="kontak" id="kontak" placeholder="Kontak" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Provinsi</label>

                    <div class="controls">
                        <input type="text" name="provinsi" id="provinsi" placeholder="Provinsi" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kodepos</label>

                    <div class="controls">
                        <input type="number" name="kodepos" id="kodepos" placeholder="Kodepos" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Fax</label>

                    <div class="controls">
                        <input type="number" name="fax" id="fax" placeholder="Fax" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">No Rekening</label>

                    <div class="controls">
                        <input type="number" name="no_rekening" id="no_rekening" placeholder="No Rekening" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Rekening a/n</label>

                    <div class="controls">
                        <input type="text" name="nama_rekening" id="nama_rekening" placeholder="Nama Rekening" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Bank</label>

                    <div class="controls">
                        <input type="text" name="nama_bank" id="nama_bank" placeholder="Nama Bank" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Keterangan</label>

                    <div class="controls">
                        <input type="text" name="keterangan" id="keterangan" placeholder="Keterangan" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">NPWP</label>

                    <div class="controls">
                        <input type="text" name="npwp" id="npwp" placeholder="NPWP" />
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

<div id="modal-table-detail" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Detail Supplier
        </div>
    </div>

    <div class="modal-body no-padding">
      <table class="table">
        <tr>
          <td>Kode Supplier</td>
          <td id="kode_supplier_detail"></td>
        </tr>
        <tr>
          <td>Nama Supplier</td>
          <td id="nama_supplier_detail"></td>
        </tr>
        <tr>
          <td>Alamat</td>
          <td id="alamat_detail"></td>
        </tr>
        <tr>
          <td>Kota</td>
          <td id="kota_detail"></td>
        </tr>
        <tr>
          <td>Telepon</td>
          <td id="telepon_detail"></td>
        </tr>
        <tr>
          <td>Email</td>
          <td id="email_detail"></td>
        </tr>
        <tr>
          <td>Kontak</td>
          <td id="kontak_detail"></td>
        </tr>
        <tr>
          <td>Provinsi</td>
          <td id="provinsi_detail"></td>
        </tr>
        <tr>
          <td>Kode Pos</td>
          <td id="kodepos_detail"></td>
        </tr>
        <tr>
          <td>Fax</td>
          <td id="fax_detail"></td>
        </tr>
        <tr>
          <td>No. Rekening</td>
          <td id="no_rekening_detail"></td>
        </tr>
        <tr>
          <td>Nama Rekening</td>
          <td id="nama_rekening_detail"></td>
        </tr>
        <tr>
          <td>Keterangan</td>
          <td id="keterangan_detail"></td>
        </tr>
        <tr>
          <td>NPWP</td>
          <td id="npwp_detail"></td>
        </tr>
      </table>
    </div>

    <div class="modal-footer">
        <div class="pagination pull-right no-margin">
        <button type="button" class="btn btn-small btn-danger pull-left" data-dismiss="modal">
            <i class="icon-remove"></i>
            Close
        </button>
        </div>
    </div>
</div>
