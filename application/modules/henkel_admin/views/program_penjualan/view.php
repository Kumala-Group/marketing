<script type="text/javascript">
$(document).ready(function(){
$("#simpan").click(function(){
    var id_pesanan_pembelian = $("#id_pesanan_pembelian").val();
    var nama_program = $("#nama_program").val();
    var jumlah_bonus = $("#jumlah_bonus").val();

    var string = $("#my-form").serialize();



    if(nama_program.length==0){
        $.gritter.add({
            title: 'Peringatan..!!',
            text: 'Nama Program tidak boleh kosong',
            class_name: 'gritter-error'
        });

        $("#nama_program").focus();
        return false();
    }

    if(jumlah_bonus.length==0){
        $.gritter.add({
            title: 'Peringatan..!!',
            text: 'Jumlah Bonus tidak boleh kosong',
            class_name: 'gritter-error'
        });

        $("#jumlah_bonus").focus();
        return false();
    }

    $.ajax({
        type    : 'POST',
        url     : "<?php echo site_url(); ?>henkel_adm_program_penjualan/simpan",
        data    : string,
        cache   : false,
        success : function(data){
            alert(data);
            location.reload();
        }
    });
});

$("#new").click(function(){
  var id=$("#id_ret").val();
  $.ajax({
      type    : 'POST',
      url     : "<?php echo site_url(); ?>henkel_adm_program_penjualan/baru",
      data    : "id_new="+id,
      success : function(data){
        location.replace("<?php echo site_url(); ?>henkel_adm_program_penjualan/tambah");
      }
  });
});
});
</script>
<div class="row-fluid">
<div class="table-header">
    <?php echo $judul;?>
    <div class="widget-toolbar no-border pull-right">
      <button type="button" name="new" id="new" class="btn btn-small btn-success">
          <i class="icon-check"></i>
          Tambah Data
      </button>
    </div>
</div>
<table class="table fpTable lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Nama Program</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $i=1;
        foreach($data->result() as $dt){ ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->nama_program;?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="<?php echo site_url();?>henkel_adm_program_penjualan/edit/<?php echo $dt->id_program_penjualan;?>">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a class="red" href="<?php echo site_url();?>henkel_adm_program_penjualan/hapus/<?php echo $dt->id_program_penjualan;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
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
                                    <span class="blue">
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
                                    <span class="green">
                                        <i class="icon-plus bigger-130"></i>
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
            Program Penjualan
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
            <input type="hidden" name="id_program_penjualan" id="id_program_penjualan">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Program</label>

                    <div class="controls">
                        <input type="text" name="nama_program" id="nama_program" placeholder="Nama Profil"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Jumlah Bonus</label>

                    <div class="controls">
                        <input type="text" name="jumlah_bonus" id="jumlah_bonus" placeholder="Jumlah Bonus" />
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
