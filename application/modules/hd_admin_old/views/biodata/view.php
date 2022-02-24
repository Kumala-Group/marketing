<script type="text/javascript">
$(document).ready(function(){
    $("#simpan").click(function(){
        var id_karyawan = $('#id_karyawan').val();
        var nik         = $('#inp_nik').val();
        var nama        = $('#inp_nama').val();
        var jen_kel     = $('input[name="inp_jenkel"]:checked').val();
        var agama       = $('#inp_agama').val();
        var alamat      = $('#inp_alamat').val();        

        if ( nik.length == 0 || nik == '' ) {
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Nik tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $('#inp_nik').focus();
            return false;
        } else if ( nama.length == 0 || nama == '' ) {
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Nama tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $('#inp_nama').focus();
            return false;
        } else if ( typeof jen_kel === "undefined" || jen_kel == '' ) {
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Jenis Kelamin tidak boleh kosong',
                class_name: 'gritter-error'
            });

            return false;
        } else if ( agama.length == 0 || agama == '' ) {
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Agama tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $('#inp_agama').focus();
            return false;
        } else if ( alamat.length == 0 || alamat == '' ) {
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Alamat tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $('#inp_alamat').focus();
            return false;
        }

        var string = $("#my-form").serialize();

        $.ajax({
            type    : 'POST',
            url     : "<?= site_url(); ?>biodata/simpan",
            data    : string,
            cache   : false,
            success : function(data){
                // alert(data);
                // location.reload();
            }
        });
    });

    $("#tambah").click(function(){
        $('#id_jenis_hardware').val('');
        $('#nama').val('');
    });
});

function editData(ID){
    var cari  = ID;
    console.log(cari);
  $.ajax({
    type  : "GET",
    url   : "<?php echo site_url(); ?>hd_adm_jenis_hardware/cari",
    data  : "cari="+cari,
    dataType: "json",
    success : function(data){
      $('#id_jenis_hardware').val(data.id_jenis_hardware);
      $('#nama').val(data.nama);
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
            <th class="center">Nik</th>
            <th class="center">Nama</th>
            <th class="center">Jenis Kelamin</th>
            <th class="center">Agama</th>
            <th class="center">Alamat</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $i=1;
        foreach($data->result() as $dt){ ?>
        <tr>
            <td class="center span1"><?= $i++?></td>
            <td class="center"><?= $dt->nik;?></td>
            <td class="center"><?= $dt->nama;?></td>
            <td class="center"><?= $dt->jenis_kelamin;?></td>
            <td class="center"><?= $dt->agama;?></td>
            <td class="center"><?= $dt->alamat;?></td>
            <td class="td-actions">
                <center>
                    <div class="hidden-phone visible-desktop action-buttons">
                        <a class="green" href="#modal-table" data-toggle="modal" onclick="javascript:editData('<?php echo $dt->id_karyawan;?>')">
                            <i class="icon-pencil bigger-130"></i>
                        </a>

                        <a class="red" href="<?php echo site_url();?>hd_adm_jenis_hardware/hapus/<?php echo $dt->id_karyawan;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
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
            Lokasi
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
            <input type="hidden" name="id_karyawan"id="id_karyawan">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nik</label>
                    <div class="controls">
                        <input type="text" name="inp_nik" id="inp_nik" placeholder="Masukkan Nik"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama</label>
                    <div class="controls">
                        <input type="text" name="inp_nama" id="inp_nama" placeholder="Masukkan Nama"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Jenis Kelamin</label>
                    <div class="controls">
                        <div class="radio">
                            <label>
                                <input name="inp_jenkel" id="L" type="radio" class="ace" value="L" />
                                <span class="lbl"> Laki-laki </span>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input name="inp_jenkel" id="P" type="radio" class="ace" value="P" />
                                <span class="lbl"> Perempuan </span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Agama</label>
                    <div class="controls">
                        <select class="form-control" name="inp_agama" id="inp_agama">
                            <option value="">Pilih</option>
                            <option value="Islam">Islam</option>
                            <option value="Protestan">Protestan</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Alamat</label>
                    <div class="controls">
                        <textarea class="form-control" name="inp_alamat" id="inp_alamat"></textarea>
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
