<script type="text/javascript">
$(document).ready(function(){

	$("#simpan").click(function(){
		var nama_akun_group	= $("#nama_akun_group").val();
		var kode_akun_group	= $("#kode_akun_group").val();

		var string = $("#my-form").serialize();

		if(nama_akun_group.length==0){
			alert('Maaf, Group Tidak boleh kosong');
			$("#nama_akun_group").focus();
			return false();
		}

		if(kode_akun_group.length==0){
			alert('Maaf, Kode Tidak boleh kosong');
			$("#kode_akun_group").focus();
			return false();
		}


		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ban_adm_p_akun_group/simpan",
			data	: string,
			cache	: false,
			success	: function(data){
				alert(data);
				location.reload();
			}
		});

	});

	$("#tambah").click(function(){
    $('#id_akun_group').val('');
		$('#nama_akun_group').val('');
		$('#kode_akun_group').val('');
		$('#deskripsi').val('');
		$('#nama_akun_group').focus();

	});
});

function editData(ID){
	var cari	= ID;
    console.log(cari);
	$.ajax({
		type	: "GET",
		url		: "<?php echo site_url(); ?>/ban_adm_p_akun_group/cari",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
			//alert(data.ref);
      $('#id_akun_group').val(data.id_akun_group);
			$('#nama_akun_group').val(data.nama_group_akun);
			$('#kode_akun_group').val(data.kode_akun_group);
      $('#deskripsi').val(data.deskripsi);
		}
	});

}

</script>
<div class="row-fluid">
<div class="table-header">
    <?php echo $judul;?>
    <div class="widget-toolbar no-border pull-right">
    <a href="#modal-table" class="btn btn-small btn-success"  role="button" data-toggle="modal" name="tambah" id="tambah" >
        <i class="icon-check"></i>
        Tambah Data
    </a>
    </div>
</div>

<table  class="table fpTable lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Group</th>
						<th class="center">Kode</th>
            <th class="center span6">Deskripsi</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>
    <tbody>
    	<?php

		$i=1;
		foreach($data->result() as $dt){ ?>
        <tr>
        	<td class="center span1"><?php echo $i++?></td>
            <td class="center span4"><?php echo $dt->nama_group_akun;?></td>
						<td class="center span4"><?php echo $dt->kode_akun_group;?></td>
            <td class="center span6"><?php echo $dt->deskripsi;?></td>
            <td class="td-actions"><center>
            	<div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_akun_group;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a class="red" href="<?php echo site_url();?>/ban_adm_p_akun_group/hapus/<?php echo $dt->id_akun_group;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
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

<div id="modal-table" class="modal hide fade" tabindex="-1">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Data Group Akun
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
                <input type="hidden" name="id_akun_group" id="id_akun_group" />
                <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Group</label>

                    <div class="controls">
                        <input type="text" name="nama_akun_group" id="nama_akun_group" placeholder="Nama Group"/>
                    </div>
                </div>
								<div class="control-group">
                    <label class="control-label" for="form-field-1">Kode Group</label>

                    <div class="controls">
                        <input type="text" name="kode_akun_group" id="kode_akun_group" placeholder="Kode Group"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Deskripsi</label>

                    <div class="controls">
                        <input type="text" name="deskripsi" id="deskripsi" placeholder="Deskripsi"/>
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
