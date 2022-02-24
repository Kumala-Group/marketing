<script type="text/javascript">
$(document).ready(function(){
$("#simpan").click(function(){
    var id_perusahaan = $("#id_perusahaan").val();
    var status = $("#status").val();
    var last_update = $("#last_update").val();
    var ket_status = $("#ket_status").val();

    var string = $("#my-form").serialize();



    if(status.length==0){
        $.gritter.add({
            title: 'Peringatan..!!',
            text: 'Status Absensi tidak boleh kosong',
            class_name: 'gritter-error'
        });

        $("#status").focus();
        return false();
    }

    $.ajax({
        type    : 'POST',
        url     : "<?php echo site_url(); ?>hd_adm_absensi/simpan",
        data    : string,
        cache   : false,
        success : function(data){
            alert(data);
            location.reload();
        }
    });
});

$("#tambah").click(function(){
    $('#id_perusahaan').val('');
    $('#status').val('');
    $('#ket_status').val('');
});
});

function editData(ID){
    var cari  = ID;
    console.log(cari);
  $.ajax({
    type  : "GET",
    url   : "<?php echo site_url(); ?>hd_adm_absensi/cari",
    data  : "cari="+cari,
    dataType: "json",
    success : function(data){
      $('#id_perusahaan').val(data.id_perusahaan);
      $('#status').val(data.status);
      $('#ket_status').val(data.ket_status);
    }
  });
}
</script>

  <div class="infobox-container">
      <div class="infobox infobox-green  ">
          <div class="infobox-icon">
              <i class="icon-thumbs-up"></i>
          </div>

          <div class="infobox-data">
              <span class="infobox-data-number"><?php echo $this->model_absensi->statusOK();?> Cabang</span>
              <div class="infobox-content">OK</div>
          </div>
      </div>


      <div class="infobox infobox-red  ">
          <div class="infobox-icon">
              <i class="icon-warning-sign"></i>
          </div>

          <div class="infobox-data">
              <span class="infobox-data-number"><?php echo $this->model_absensi->statusTROUBLE();?> Cabang</span>
              <div class="infobox-content">TROUBLE</div>
          </div>
      </div>

      <div class="infobox infobox-grey ">
          <div class="infobox-icon">
              <i class="icon-eye-close"></i>
          </div>

          <div class="infobox-data">
              <span class="infobox-data-number"><?php echo $this->model_absensi->statusNO();?> Cabang</span>
              <div class="infobox-content">NO DATA</div>
          </div>
      </div>

  </div>
<div class="row-fluid">

<div class="table-header">

    <?php echo $judul;?>
    <div class="widget-toolbar no-border pull-right">
<?php date_default_timezone_set('Asia/Makassar');echo date('d-m-Y');?>
    </div>
</div>
<table class="table fpTable lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Cabang</th>
            <th class="center">Status</th>
            <th class="center">Last Update</th>
            <th class="center">Keterangan</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $i=1;
        foreach($data->result() as $dt){ ?>
        <tr>
            <td class="center span1"style="font-size: 14px;"><?php echo $i++?></td>
            <td class="center" style="font-size: 14px;"><?php echo $dt->singkat.' - '.$dt->nama_brand.' - '.$dt->lokasi;?></td>
            <td class="center">
									<?php
									if($dt->status == 'OK'){
										echo "<button style='background-color:#4CAF50;border: none;color: black;padding: 7px 28px;text-align: center;text-decoration: none;display: inline-block;font-size: 14px;'>";
									}elseif ($dt->status == 'TROUBLE') {
										echo "<button style='background-color:#f44336;border: none;color: black;padding: 7px 5px;text-align: center;text-decoration: none;display: inline-block;font-size: 14px;'>";
									}else {
										echo "<button style='background-color:#C0C0C0;border: none;color: black;padding: 7px 8px;text-align: center;text-decoration: none;display: inline-block;font-size: 14px;'>";
									}
									?>

									<?php echo $dt->status;?></button>
            </td>
            <td class="center"style="font-size: 14px;"><?php echo $dt->last_update;?></td>
            <td class="center"style="font-size: 14px;"><?php echo $dt->ket_status;?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" data-toggle="modal" onclick="javascript:editData('<?php echo $dt->id_perusahaan;?>')">
                        <i class="icon-edit bigger-200"></i>
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
            Status Absensi
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
            <input type="hidden" name="id_perusahaan"id="id_perusahaan">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Status Absensi</label>

                    <div class="controls">

                      <select name="status" id="status">
                            <option value="OK">OK</option>
                            <option value="TROUBLE">TROUBLE</option>
                            <option value="NO DATA">NO DATA</option>

                       </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Keterangan</label>

                    <div class="controls">


                      <textarea rows="4" cols="50" id="ket_status" name="ket_status">

                      </textarea>
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
