<script type="text/javascript">
$(document).ready(function(){

  $("#cari_spv").click(function(){
      var cabang= $("#cabang").val();
    $.ajax({
      url		: "<?php echo site_url();?>wuling_adm_sales_datatable/supervisor",
      data	: "cabang="+cabang,
      dataType: "json",
      success	: function(){
                table = $('#show_spv').DataTable({
                "bProcessing": true,
                "bDestroy": true,
                "sAjaxSource": '<?php echo site_url();?>wuling_adm_sales_datatable/supervisor?cabang='+cabang,
                "bSort": true,
                 "bAutoWidth": true,
                "iDisplayLength": 10, "aLengthMenu": [10,20,40,80],
                "sPaginationType": "full_numbers",
                "aoColumnDefs": [{"bSortable": false,
                                 "aTargets": [ -1 , 0]}],
                "aoColumns": [
                  {"mData" : "id_sales"},
                  {"mData" : "nik"},
                  {"mData" : "nama"},
                  {"mData" : "jabatan"},
                  {"mData" : "perusahaan"}
                ]
            });
            $('#modal-supervisor').modal('show');
      },
      error : function(data){
        alert('Supervisor Kosong');
      }
    });
  });

  $('#show_spv tbody').on( 'click', 'tr', function () {
      var id_supervisor=$(this).find('td').eq(0).text();
      var nama=$(this).find('td').eq(2).text();
      $("#supervisor").val(nama);
      $("#id_supervisor").val(id_supervisor);
      $('#modal-supervisor').modal('hide');
  } );

  $("#simpan").click(function(){
		var nama_team = $("#nama_team").val();
    var cabang = $("#cabang").val();
    var supervisor = $("#supervisor").val();

		var string = $("#my-form").serialize();

    if(cabang.length==0){
			$.gritter.add({
                title: 'Peringatan..!!',
                text: 'Cabang tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#cabang").focus();
            return false();
		}

		if(nama_team.length==0){
			$.gritter.add({
                title: 'Peringatan..!!',
                text: 'Nama team tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#nama_team").focus();
            return false();
		}

    if(supervisor.length==0){
			$.gritter.add({
                title: 'Peringatan..!!',
                text: 'Supervisor tidak boleh kosong',
                class_name: 'gritter-error'
            });
            return false();
		}


		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/wuling_adm_sales_supervisor/simpan",
			data	: string,
			cache	: false,
      start : $('#simpan').html('...Sedang diproses...'),
			success	: function(data){
        $('#simpan').html('<i class="icon-save"></i>Simpan');
				alert(data);
				location.reload();
			}
		});
	});

  $("#tambah").click(function(){
    $('#id_team_supervisor').val('');
    $('#cabang').val('');
		$('#nama_team').val('');
    $('#supervisor').val('');
	});

  $("#cabang").change(function(){
    $('#supervisor').val('');
    $('#id_supervisor').val('');
    $('#nama_team').val('');
	});

  $("#team").change(function(){
    $('#nama_sales').val('');
    $('#nik').val('');
	});

  $("#show_perusahaan tbody").on( 'click', '#tambah_team', function () {
    var id= $(this).closest('tr').find('td:eq(4)').text();
    var id_team= $(this).closest('tr').find('td:eq(5)').text();
    var nama= $(this).closest('tr').find('td:eq(2)').text();
    location.replace("<?php echo site_url();?>wuling_adm_sales_supervisor/tambah_team?id_perusahaan="+id+"&nama="+nama+"&id_leader="+id_team);
  });

  $("#cari").click(function(){
      var team= $("#team").val();
    $.ajax({
      url		: "<?php echo site_url();?>wuling_adm_sales_datatable/sales_per_team_supervisor",
      data	: "team="+team,
      dataType: "json",
      success	: function(){
                table = $('#show_team').DataTable({
                "bProcessing": true,
                "bDestroy": true,
                "sAjaxSource": '<?php echo site_url();?>wuling_adm_sales_datatable/sales_per_team_supervisor?team='+team,
                "bSort": true,
                 "bAutoWidth": true,
                "iDisplayLength": 10, "aLengthMenu": [10,20,40,80],
                "sPaginationType": "full_numbers",
                "aoColumnDefs": [{"bSortable": false,
                                 "aTargets": [ -1 , 0]}],
                "aoColumns": [
                  {"mData" : "id_sales"},
                  {"mData" : "nik"},
                  {"mData" : "nama"},
                  {"mData" : "jabatan"},
                  {"mData" : "perusahaan"}
                ]
            });
            $('#modal-team').modal('show');
      },
      error : function(data){
        alert('Team Kosong');
      }
    });
  });

  $('#show_team tbody').on( 'click', 'tr', function () {
      var nik=$(this).find('td').eq(1).text();
      var id_sales=$(this).find('td').eq(0).text();
      var nama=$(this).find('td').eq(2).text();
      $("#nik").val(nik);
      $("#nama_sales").val(nama);
      $("#id_sales").val(id_sales);
      $('#modal-team').modal('hide');
  } );

  $("#mutasi").click(function(){
    var ke = $("#ke").val();
    var sales = $("#nik").val();
    var string = $("#form-mutasi").serialize();

    if(sales.length==0){
			$.gritter.add({
                title: 'Peringatan..!!',
                text: 'Sales tidak boleh kosong',
                class_name: 'gritter-error'
            });
            return false();
		}

    if(ke.length==0){
			$.gritter.add({
                title: 'Peringatan..!!',
                text: 'Tujuan Mutasi tidak boleh kosong',
                class_name: 'gritter-error'
            });
            $("#ke").focus();
            return false();
		}

		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/wuling_adm_sales_supervisor/mutasi",
			data	: string,
			cache	: false,
      start : $('#mutasi').html('...Sedang diproses...'),
			success	: function(data){
        $('#mutasi').html('<i class="icon-save"></i>Simpan');
				alert(data);
				location.reload();
			}
		});
	});

});

function editData(ID){
    var cari    = ID;
    console.log(cari);
    $.ajax({
        type    : "GET",
        url     : "<?php echo site_url(); ?>wuling_adm_sales_supervisor/cari",
        data    : "cari="+cari,
        dataType: "json",
        success : function(data){
            $('#id_team_supervisor').val(data.id_team_supervisor);
            $('#cabang').val(data.cabang);
            $('#nama_team').val(data.nama_team);
            $('#supervisor').val(data.supervisor);
            $('#id_supervisor').val(data.id_supervisor);
        }
    });

}

</script>
<div class="row-fluid">
<div class="table-header">
    <?php echo $judul;?>
    <div class="widget-toolbar no-border pull-right">
      <a href="#modal-mutasi" class="btn btn-small btn-info"  role="button" data-toggle="modal" name="mutasi_team" id="mutasi_team" >
          <i class="icon-plus"></i>
          Mutasi Team
      </a>
      <a href="#modal-tambah" class="btn btn-small btn-success"  role="button" data-toggle="modal" name="tambah" id="tambah" >
          <i class="icon-plus"></i>
          Tambah Team
      </a>
    </div>
</div>

<table class="table fpTable lcnp table-striped table-bordered table-hover" id="show_perusahaan">
    <thead>
        <tr>
            <th class="center span2">No</th>
            <th class="center">Supervisor</th>
            <th class="center">Nama Team</th>
            <th class="center">Cabang</th>
            <th class="center hidden">id_perusahaan</th>
            <th class="center hidden">id_team_supervisor</th>
            <th class="center">Jumlah Team</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $i=1;
        foreach($data->result() as $dt){
          $perusahaan=$this->model_data->nama_perusahaan_singkat($dt->id_perusahaan);
          $supervisor=$this->model_data->get_nama_karyawan($dt->id_supervisor);
          $jml=$this->db_wuling->query("SELECT COUNT(id_sales) as jml_team FROM adm_sales WHERE id_leader='$dt->id_team_supervisor' ");
          foreach($jml->result() as $d){
      			$jumlah = (int) $d->jml_team;
      		}
        ?>
        <tr>
            <td class="center"><?php echo $i++;?></td>
            <td class="center"><?php echo $supervisor;?></td>
            <td class="center"><?php echo $dt->nama_team;?></td>
            <td class="center"><?php echo $perusahaan;?></td>
            <td class="center hidden"><?php echo $dt->id_perusahaan;?></td>
            <td class="center hidden"><?php echo $dt->id_team_supervisor;?></td>
            <td class="center"><?php echo $jumlah;?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="blue" data-rel="tooltip" title="Edit" href="#modal-tambah" onclick="javascript:editData('<?php echo $dt->id_team_supervisor;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>
                    <a class="red" href="<?php echo site_url();?>wuling_adm_sales_supervisor/hapus/<?php echo $dt->id_team_supervisor;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
                        <i class="icon-trash bigger-130"></i>
                    </a>
                    <a class="" href="<?php echo site_url();?>wuling_adm_sales_supervisor/detail_team/<?php echo $dt->id_team_supervisor."/".$dt->nama_team;?>">
                        <i class="icon-eye-open bigger-130"></i>
                    </a>
                    <a class="green" id="tambah_team">
                        <i class="icon-plus bigger-130"></i>
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
                                    <span class="red">
                                        <i class="icon-eye-open bigger-120"></i>
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

<div id="modal-tambah" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Tambah Team
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
            <input type="hidden" name="id_team_supervisor" id="id_team_supervisor">
            <br>
              <div class="control-group">
                  <label class="control-label" for="form-field-1">Cabang Perusahaan</label>
                  <div class="controls">
                    <?php ?>
                    <select name="cabang" id="cabang">
                      <option value="" selected="selected">-- Pilih Cabang --</option>
                      <?php
                        $data_per_wuling = $this->db->query("SELECT id_perusahaan,singkat,lokasi FROM perusahaan WHERE id_brand='5'");
                        foreach($data_per_wuling->result() as $dt){
                      ?>
                       <option value="<?php echo $dt->id_perusahaan;?>"><?php echo $dt->singkat.' - '.$dt->lokasi;?></option>
                      <?php
                        }
                      ?>
                     </select>
                  </div>
              </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Team</label>
                    <div class="controls">
                        <input type="text" name="nama_team" id="nama_team"  />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Supervisor</label>
                    <div class="controls">
                        <input type="text" name="supervisor" id="supervisor" readonly="readonly" />
                        <input type="hidden" name="id_supervisor" id="id_supervisor"  />
                        <button type="button" name="cari_spv" id="cari_spv" class="btn btn-small btn-info">
                            ...
                        </button>
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

<div id="modal-mutasi" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Mutasi Team
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="form-mutasi" id="form-mutasi">
            <input type="hidden" name="id_team_supervisor" id="id_team_supervisor">
            <br>
            <div class="control-group">
                <label class="control-label" for="form-field-1">Dari Team</label>
                <div class="controls">
                  <?php ?>
                  <select name="team" id="team">
                    <option value="-1" selected="selected">-- Pilih Team --</option>
                    <?php
                      $data_team = $this->db_wuling->query("SELECT id_team_supervisor,nama_team,id_perusahaan FROM adm_team_supervisor ORDER BY id_perusahaan");
                      foreach($data_team->result() as $dt){
                      $perusahaan=$this->model_data->nama_perusahaan_singkat($dt->id_perusahaan);
                    ?>
                     <option value="<?php echo $dt->id_team_supervisor;?>"><?php echo $dt->nama_team.' - '.$perusahaan;?></option>
                    <?php
                      }
                    ?>
                   </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-1">NIK</label>

                <div class="controls">
                    <input type="text" name="nik" id="nik" placeholder="NIK" readonly="readonly" />
                    <input type="hidden" name="id_sales" id="id_sales" placeholder="" readonly="readonly" />
                    <button type="button" name="cari" id="cari" class="btn btn-small btn-info">
                        ...
                    </button>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-1">Nama Sales</label>

                <div class="controls">
                    <input type="text" name="nama_sales" id="nama_sales" placeholder="Nama Sales" readonly="readonly" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-1">Ke Team</label>
                <div class="controls">
                  <?php ?>
                  <select name="ke" id="ke">
                    <option value="" selected="selected">-- Pilih Team --</option>
                    <?php
                      $data_team = $this->db_wuling->query("SELECT id_team_supervisor,nama_team,id_perusahaan FROM adm_team_supervisor");
                      foreach($data_team->result() as $dt){
                      $perusahaan=$this->model_data->nama_perusahaan_singkat($dt->id_perusahaan);
                    ?>
                     <option value="<?php echo $dt->id_team_supervisor;?>"><?php echo $dt->nama_team.' - '.$perusahaan;?></option>
                    <?php
                      }
                    ?>
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
        <button type="button" name="mutasi" id="mutasi" class="btn btn-small btn-success pull-left">
            <i class="icon-save"></i>
            Simpan
        </button>
        </div>
    </div>
</div>

<div id="modal-team" class="modal hide fade" tabindex="-1" style="width:60%;left:40%;" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Cari Sales
        </div>
    </div>

    <div class="no-padding">
        <div class="row-fluid">
          <table class="table lcnp table-striped table-bordered table-hover" style='min-width:100%;' id="show_team">
              <thead>
                  <tr>
                      <th class="center" style="width:2px;"></th>
                      <th class="center">NIK</th>
                      <th class="center">Nama</th>
                      <th class="center">Jabatan</th>
                      <th class="center">Perusahaan</th>
                  </tr>
              </thead>
              <tbody>
              </tbody>
          </table>
        </div>
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

<div id="modal-supervisor" class="modal hide fade" tabindex="-1" style="width:60%;left:40%;" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Cari Supervisor
        </div>
    </div>

    <div class="no-padding">
        <div class="row-fluid">
          <table class="table lcnp table-striped table-bordered table-hover" style='min-width:100%;' id="show_spv">
              <thead>
                  <tr>
                      <th class="center" style="width:2px;"></th>
                      <th class="center">NIK</th>
                      <th class="center">Nama</th>
                      <th class="center">Jabatan</th>
                      <th class="center">Perusahaan</th>
                  </tr>
              </thead>
              <tbody>
              </tbody>
          </table>
        </div>
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
