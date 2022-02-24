<script type="text/javascript">
$(document).ready(function(){
  $("#simpan").click(function(){
      var jabatan_karyawan = $("#jabatan_karyawan").val();

      var string = $("#my-form").serialize();
      if(jabatan_karyawan.length==0){
          $.gritter.add({
              title: 'Peringatan..!!',
              text: 'Jabatan Karyawan tidak boleh kosong',
              class_name: 'gritter-error'
          });

          $("#jabatan_karyawan").focus();
          return false();
      }

      $.ajax({
          type    : 'POST',
          url     : "<?php echo site_url(); ?>henkel_adm_jabatan_karyawan/simpan",
          data    : string,
          cache   : false,
          success : function(data){
              alert(data);
              location.reload();
          }
      });
  });
});

function editData(ID){
    var cari	= ID;
    console.log(cari);
  $.ajax({
    type	: "GET",
    url		: "<?php echo site_url(); ?>henkel_adm_jabatan_karyawan/cari",
    data	: "cari="+cari,
    dataType: "json",
    success	: function(data){
      $('#id_jabatan_karyawan').val(data.id_jabatan_karyawan);
      $('#nik').val(data.nik);
      $('#nama_karyawan').val(data.nama_karyawan);
      $('#jabatan_karyawan').val(data.jabatan_karyawan);
    }
  });
}
</script>
<div class="row-fluid">
<div class="table-header">
    <?php echo $judul;?>
    <div class="widget-toolbar no-border pull-right">
    </div>
</div>
<table  class="table fpTable lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">NIK</th>
            <th class="center">Nama Karyawan</th>
            <th class="center">Jabatan Karyawan</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php
		//$data = $this->model_data->data_mk();
		$i=1;

		foreach($data->result() as $dt){
		?>
        <tr>
        	<td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->nik;?></td>
            <td class="center"><?php echo $dt->nama_karyawan;?></td>
            <?php  if ($dt->jabatan_karyawan==0) { ?>
            <td class="center"><?php echo "<span class='label label-warning'>Belum Ditentukan</span>";?></td>
            <?php   } elseif ($dt->jabatan_karyawan==1) { ?>
            <td class="center"><?php echo 'Sales/OM/SPV';?></td>
            <?php } elseif ($dt->jabatan_karyawan==2) { ?>
            <td class="center"><?php echo 'Admin/Div. Gudang';?></td>
            <?php } elseif ($dt->jabatan_karyawan==3) { ?>
            <td class="center"><?php echo 'Kolektor';?></td>
            <?php  } ?>
            <td class="td-actions"><center>
            	<div class="hidden-phone visible-desktop action-buttons">

                    <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_jabatan_karyawan;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
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
<div id="modal-table" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Tambah Data
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
            <input type="hidden" name="id_jabatan_karyawan" id="id_jabatan_karyawan">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">NIK</label>

                    <div class="controls">
                        <input type="text" name="nik" id="nik" placeholder="NIK" readonly/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Karyawan</label>

                    <div class="controls">
                        <input type="text" name="nama_karyawan" id="nama_karyawan" placeholder="Jabatan Karyawan" readonly="readonly"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Jabatan Karyawan</label>

                    <div class="controls">
                      <select name="jabatan_karyawan" id="jabatan_karyawan">
                            <option value="0">-- Pilih Jabatan Karyawan --</option>
                            <option value="1">Sales/OM/SPV</option>
                            <option value="2">Admin/Div. Gudang</option>
                            <option value="3">Kolektor</option>
                      </select>
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
