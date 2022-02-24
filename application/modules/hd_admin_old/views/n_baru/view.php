<script type="text/javascript">
$(document).ready(function(){
$("#simpan").click(function(){
    var id_jenis_hardware = $("#id_jenis_hardware").val();
    var nama = $("#nama").val();

    var string = $("#my-form").serialize();



    if(nama.length==0){
        $.gritter.add({
            title: 'Peringatan..!!',
            text: 'Nama Jenis Hardware tidak boleh kosong',
            class_name: 'gritter-error'
        });

        $("#nama").focus();
        return false();
    }

    $.ajax({
        type    : 'POST',
        url     : "<?php echo site_url(); ?>hd_adm_jenis_hardware/simpan",
        data    : string,
        cache   : false,
        success : function(data){
            alert(data);
            location.reload();
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
</div>
<table class="table fpTable lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">NIK</th>
            <th class="center">Nama Karyawan</th>
            <th class="center">Cabang</th>
            <th class="center">Jabatan</th>
            <th class="center">Tanggal Efektif</th>
            <!--<th class="center">No. Handphone</th>
            <th class="center">Tanggal Efektif</th>-->
            <th class="center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $i=1;
        foreach($data->result() as $dt){ ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->nik;?></td>
            <td class="center"><?php echo $dt->nama_karyawan;?></td>
            <td class="center"><?php echo $dt->nama_perusahaan.' - '.$dt->lokasi;?></td>
            <td class="center"><?php echo $dt->nama_jabatan;?></td>
            <td class="center"><?php echo tgl_sql($dt->tgl_mulai_kerja);?></td>
            <!--<td class="center"><?php echo $dt->handphone;?></td>
            <td class="center"><?php echo tgl_sql($dt->tgl_mulai_kerja);?></td>-->
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">

                    <a class="red" href="<?php echo site_url();?>hd_adm_n_baru/hapus/<?php echo $dt->id_n_baru;?>" onClick="return confirm('Anda yakin telah mendaftarkan data ini ke DATABASE KARYAWAN?')">
                        <i class="icon-flag-checkered bigger-150"></i>
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
