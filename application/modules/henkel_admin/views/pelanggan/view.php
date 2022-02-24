<script type="text/javascript">
$(document).ready(function(){

    $("#simpan").click(function(){
        var id_pelanggan = $("#id_pelanggan").val();
        var group_pelanggan = $("#kode_pelanggan").val();
        var nama_pelanggan = $("#nama_pelanggan").val();
        var alamat = $("#alamat").val();
        var kota = $("#kota").val();
        var telepon = $("#telepon").val();
        var string = $("#my-form").serialize();

        /*if(group_pelanggan.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Group Pelanggan tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#group_pelanggan").focus();
            return false();
        }*/

        if(nama_pelanggan.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Nama Pelanggan tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#nama_pelanggan").focus();
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
            url     : "<?php echo site_url(); ?>henkel_adm_pelanggan/simpan",
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

    $("#kategori_pelanggan").change(function(){
        var kategori_pelanggan = $('#kategori_pelanggan').val();
        if (kategori_pelanggan=='henkel') {
           $("#kode_pelanggan").val('<?php echo "$kode_pelanggan_henkel" ?>');
        } else if (kategori_pelanggan=='oli'){
           $("#kode_pelanggan").val('<?php echo "$kode_pelanggan_oli" ?>');
        } else {
            $("#kode_pelanggan").val('<?php echo ''?>');
        }      
        $("#nama_item").val('');
        $("#harga_tebus_dpp").val(0);
        $("#nama_item").attr("readonly", false);
    });

    $("#tambah").click(function(){
        $('#kategori_pelanggan').val('');
        $('#group_pelanggan').val('');
        $('#nama_pelanggan').val('');
        $('#alamat').val('');
        $('#kota').val('');
        $('#telepon').val('');
        $('#email').val('');
        $('#kontak').val('');
        $('#provinsi').val('');
        $('#kodepos').val('');
        $('#fax').val('');
        $('#no_rekening').val('');
        $('#nama_rekening').val('');
        $('#nama_bank').val('');
        $('#keterangan').val('');
        $('#npwp').val('');
        $('#limit').val('');
    });
});

function editData(ID){
    var cari    = ID;
    console.log(cari);
    $.ajax({
        type    : "GET",
        url     : "<?php echo site_url(); ?>henkel_adm_pelanggan/cari",
        data    : "cari="+cari,
        dataType: "json",
        success : function(data){
            //alert(data.ref);
            $('#id_pelanggan').val(data.id_pelanggan);
            $('#kategori_pelanggan').val(data.kategori_pelanggan);
            $('#kode_pelanggan').val(data.kode_pelanggan);
            $('#nama_pelanggan').val(data.nama_pelanggan);
            $('#group_pelanggan').html(data.group_pelanggan);
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
            $('#limit').val(toHarga(data.limit));
        }
    });
}

function showDetail(ID){
    var cari    = ID;
    console.log(cari);
    $.ajax({
        type    : "GET",
        url     : "<?php echo site_url(); ?>henkel_adm_pelanggan/cari",
        data    : "cari="+cari,
        dataType: "json",
        success : function(data){
            //alert(data.ref);
            $('#id_pelanggan_detail').html(data.id_pelanggan);
            $('#nama_group_pelanggan_detail').html(data.nama_group_pelanggan);
            $('#kode_pelanggan_detail').html(data.kode_pelanggan);
            $('#nama_pelanggan_detail').html(data.nama_pelanggan);
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
            $('#deposit_detail').html('<b>'+'Rp. '+toHarga(data.deposit)+'</b>');
            $('#keterangan_detail').html(data.keterangan);
            $('#npwp_detail').html(data.npwp);
            $('#limit_detail').html('<b>'+'Rp. '+toHarga(data.limit)+'</b>');
        }
    });
}
</script>
<style type="text/css">
    textarea {
        resize: none;
    }
</style>
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
            <th class="center">Kode Pelanggan</th>
            <th class="center">Nama Pelanggan</th>
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
            <td class="center"><?php echo $dt->kode_pelanggan;?></td>
            <td class="center"><?php echo $dt->nama_pelanggan;?></td>
            <td class="center"><?php echo $dt->alamat;?></td>
            <td class="center"><?php echo $dt->kota;?></td>
            <td class="center"><?php echo $dt->telepon;?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_pelanggan;?>')" data-toggle="modal" title="Edit">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a class="red" href="<?php echo site_url();?>henkel_adm_pelanggan/hapus/<?php echo $dt->id_pelanggan;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Delete">
                        <i class="icon-trash bigger-130"></i>
                    </a>
                    <a class="blue" href="#modal-table-detail" onclick="javascript:showDetail('<?php echo $dt->id_pelanggan;?>')" data-toggle="modal" title="Detail">
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
                                <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_pelanggan;?>')" data-toggle="modal" title="Edit">
                                    <span class="green">
                                        <i class="icon-edit bigger-120"></i>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a class="red" href="<?php echo site_url();?>/henkel_adm_pelanggan/hapus/<?php echo $dt->id_pelanggan;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')" title="Delete">
                                    <span class="red">
                                        <i class="icon-trash bigger-120"></i>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a class="blue" href="#modal-table-detail" onclick="javascript:showDetail('<?php echo $dt->id_pelanggan;?>')" data-toggle="modal" title="Detail">
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
            Pelanggan
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
            <input type="hidden" name="id_pelanggan" id="id_pelanggan">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kategori Pelanggan</label>

                    <div class="controls">
                        <select id="kategori_pelanggan">
                          <option value="">-- Pilih Kategori Pelanggan --</option>
                          <option value="henkel">Henkel</option>
                          <option value="oli">Oli</option>
                        </select>
                        <span class="required"> *</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kode Pelanggan</label>

                    <div class="controls">
                        <input type="text" name="kode_pelanggan" id="kode_pelanggan" readonly="readonly" />
                    </div>
                </div>
                <!--<div class="control-group">
                    <label class="control-label" for="form-field-1">Group Pelanggan</label>
                    <div class="controls">
                      <?php ?>
                      <select name="group_pelanggan" id="group_pelanggan">
                        <option value="" selected="selected">--Pilih Group Pelanggan--</option>
                        <?php
                          $data = $this->db_kpp->get('group_pelanggan');
                          foreach($data->result() as $dt){
                        ?>
                         <option value="<?php echo $dt->kode_group_pelanggan;?>"><?php echo $dt->nama_group;?></option>
                        <?php
                          }
                        ?>
                       </select>
                       <span class="required"> *</span>
                    </div>
                </div>-->
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Pelanggan</label>

                    <div class="controls">
                        <input type="text" name="nama_pelanggan" id="nama_pelanggan" placeholder="Nama Pelanggan"/><span class="required"> *</span>
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
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Limit</label>

                    <div class="controls">
                        <input type="text" name="limit" id="limit" placeholder="Limit" class="number"/>
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
            Detail Pelanggan
        </div>
    </div>

    <div class="modal-body no-padding">
      <table class="table">
        <tr>
          <td>Nama Group Pelanggan</td>
          <td id="nama_group_pelanggan_detail"></td>
        </tr>
        <tr>
          <td>Kode Pelanggan</td>
          <td id="kode_pelanggan_detail"></td>
        </tr>
        <tr>
          <td>Nama Pelanggan</td>
          <td id="nama_pelanggan_detail"></td>
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
          <td>Deposit</td>
          <td id="deposit_detail"></td>
        </tr>
        <tr>
          <td>Keterangan</td>
          <td id="keterangan_detail"></td>
        </tr>
        <tr>
          <td>NPWP</td>
          <td id="npwp_detail"></td>
        </tr>
        <tr>
          <td>Limit</td>
          <td id="limit_detail"></td>
        </tr>
      </table>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-small btn-danger pull-right" data-dismiss="modal">
          <i class="icon-remove"></i>
          Close
      </button>
    </div>
  </div>
