<script type="text/javascript">
    $(document).ready(function(){
        $("body").on("click", ".delete", function (e) {
            $(this).parent("div").remove();
        });
        $("#cari_karyawan").click(function(){
        $.ajax({
          type	: "GET",
          url		: "<?php echo site_url();?>hd_adm_datatable/nik_karyawan_it",
          dataType: "json",
          success	: function(data){
                    var table = $('#show_karyawan').DataTable({
                    "bProcessing": true,
                    "bDestroy": true,
                    "sAjaxSource": '<?php echo site_url();?>hd_adm_datatable/nik_karyawan_it',
                    "bSort": false,
                    "bAutoWidth": true,
                    "iDisplayLength": 10, "aLengthMenu": [10,20,40,80], // can be removed for basic 10 items per page
                    "sPaginationType": "full_numbers",
                    "aoColumnDefs": [{"bSortable": false,
                                     "aTargets": [ -1 , 0]}], //Feature control DataTables' server-side processing mode.
                    "aoColumns": [
                      {"mData" : "no"},
                      {"mData" : "nik"},
                      {"mData" : "nama_karyawan"}
                    ]
                });
                $('#modal-search').modal('show');
          }
        });
        });
        $('#show_karyawan tbody').on( 'click', 'tr', function () {
                      var nik=$(this).find('td').eq(1).text();
                      var nama_karyawan=$(this).find('td').eq(2).text();
                      $("#nik_exe").val(nik);
                      $("#nama_exe").val(nama_karyawan);
                      $('#modal-search').modal('hide');
                  });

        $("#new_solv").click(function(){
          var id= $("#id_tiket").val();
          $.ajax({
              type    : 'POST',
              url     : "<?php echo site_url(); ?>oli_adm_pesanan_pengiriman/baru",
              data    : "id_new="+id,
              success : function(data){
              location.replace("<?php echo site_url(); ?>oli_adm_ticketing/tambah_solving");
              }
          });

        });
        $("#simpan").click(function(){
            var status_tiket = $("#status_tiket").val();
            var id_tiket = $("#id_tiket").val();
            var nik_exe = $("#nik_exe").val();
            var id_t_solv = $("#id_t_solv").val();

            var string = $("#my-form").serialize();



            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>hd_adm_ticketing/t_solv_simpan",
                data    : string,
                cache   : false,
                success : function(data){
                    alert(data);
                    location.reload();
                }
            });
        });

            $("#new").click(function(){
              $.ajax({
                  type    : 'POST',
                  url     : "<?php echo site_url(); ?>hd_adm_ticketing/tambah",
                  success : function(data){
                    location.replace("<?php echo site_url(); ?>hd_adm_ticketing/tambah");
                  }
              });

            });

    });

    function editData(ID){
        var cari  = ID;
        console.log(cari);
      $.ajax({
        type  : "GET",
        url   : "<?php echo site_url(); ?>hd_adm_ticketing/cari",
        data  : "cari="+cari,
        dataType: "json",
        success : function(data){
          $('#nik_exe').val('');
          $('#nama_exe').val('');
          $('#id_tiket').val(data.id_tiket);
          $('#nik').val(data.nik);
          $('#nama_pengadu').val(data.nama_karyawan);
          $('#cabang').val(data.nama_brand+' '+data.lokasi);
          $('#waktu_tiket').val(data.tgl_tiket+' '+data.wkt_tiket);
          $('#masalah').val(data.masalah);
          $('#priority').val(data.priority);
          $('#status_tiket').val(data.status_tiket);

        }
      });
    }
</script>
<div class="row-fluid">
<div class="table-header">
    <?php echo $judul;
    ?>
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
            <th class="center">NIK</th>
            <th class="center">Nama Pengadu</th>
            <th class="center">Cabang</th>
            <th class="center">Waktu Tiket</th>
            <th class="center">Masalah</th>
            <th class="center">Prioritas</th>
            <th class="center">Status Tiket</th>
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
            <td class="center"><?php echo $dt->nama_brand.' - '.$dt->lokasi;?></td>
            <td class="center"><?php echo $dt->tgl_tiket.' '.$dt->wkt_tiket;?></td>
            <td class="center"><?php echo $dt->masalah;?></td>
            <td class="center">
              <?php
              if($dt->priority == 'Urgent'){
                echo "<button style='background-color:#ff4000;border: none;color: black;padding: 1px 7px;text-align: center;text-decoration: none;display: inline-block;font-size: 11px;'>";
              }elseif ($dt->priority == 'High') {
                echo "<button style='background-color:#ff8000;border: none;color: black;padding: 1px 13px;text-align: center;text-decoration: none;display: inline-block;font-size: 11px;'>";
              }elseif ($dt->priority == 'Normal') {
                echo "<button style='background-color:#ffbf00;border: none;color: black;padding: 1px 6px;text-align: center;text-decoration: none;display: inline-block;font-size: 11px;'>";
              }else {
                echo "<button style='background-color:#ffff00;border: none;color: black;padding: 1px 15px;text-align: center;text-decoration: none;display: inline-block;font-size: 11px;'>";
              }
              ?>

              <?php echo $dt->priority;?></button>
            </td>
            <td class="center">
              <?php echo $dt->status_tiket;
              if ($dt->status_tiket=='OnHold' or $dt->status_tiket=='Pending') {
                echo " by ";
                $data = $this->db_helpdesk->from('t_solving')->where('id_tiket',$dt->id_tiket)->get();
                foreach($data->result() as $dt_by)
    						{
                  $dataa = $this->db->from('karyawan')->where('nik',$dt_by->nik_exe)->get();
                  foreach($dataa->result() as $dt_nm)
      						{
                    echo $dt_nm->nama_karyawan;
      						}
    						}
              }
              else if ($dt->status_tiket=='Solved') {
                echo " by ";
                $data = $this->db_helpdesk->from('solving')->where('id_tiket',$dt->id_tiket)->get();
                foreach($data->result() as $dt_by)
    						{
                  $dataa = $this->db->from('karyawan')->where('nik',$dt_by->nik_exe)->get();
                  foreach($dataa->result() as $dt_nm)
      						{
                    echo $dt_nm->nama_karyawan;
      						}
    						}
              }


              ?>
            </td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                      <a class="green" href="#modal-table" data-toggle="modal" onclick="javascript:editData('<?php echo $dt->id_tiket;?>')">
                          <i class="icon-magic bigger-230"></i>
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
            Pilih Eksekutor
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
              <input type="hidden" name="id_tiket"id="id_tiket">
            <input type="hidden" name="id_t_solv"id="id_t_solv">
          <input type="hidden" name="waktu_mulai"id="waktu_mulai">
            <br>
            <div class="control-group">
                <label class="control-label" for="form-field-1">Status Tiket</label>
                <div class="controls">
                  <select name="status_tiket" id="status_tiket">
                    <option value="Pending">Pending</option>
                    <option value="Solved">Solved</option>
                    <option value="OnHold">OnHold</option>
                    <option value="Open">Open</option>

                   </select>
                </div>
            </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">NIK Eksekutor</label>

                    <div class="controls">
                        <input type="text" name="nik_exe" id="nik_exe" placeholder="NIK Eksekutor"/>

                        <button type="button" name="cari_karyawan" id="cari_karyawan" class="btn btn-small btn-info">
                          <i class="icon-search"></i>
                        </button>
                    </div>

                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Eksekutor</label>

                    <div class="controls">
                        <input type="text" name="nama_exe" id="nama_exe" placeholder="Nama Eksekutor" readonly/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">NIK Pengadu</label>

                    <div class="controls">
                        <input type="text" name="nik" id="nik" readonly/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Karyawan Pengadu</label>

                    <div class="controls">
                        <input type="text" name="nama_pengadu" id="nama_pengadu" readonly/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Cabang</label>

                    <div class="controls">
                        <input type="text" name="cabang" id="cabang" readonly/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Masalah</label>

                    <div class="controls">
                        <textarea name="masalah" id="masalah" disabled>
</textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Prioritas</label>

                    <div class="controls">
                        <input type="text" name="priority" id="priority" readonly/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Waktu Tiket</label>

                    <div class="controls">
                        <input type="text" name="waktu_tiket" id="waktu_tiket" readonly/>
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

<div id="modal-search" class="modal hide fade" style="width:80%;max-height:80%;left:30%;" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Daftar Staff IT
        </div>
    </div>

    <div class="no-padding">
        <div class="row-fluid">
          <table class="table lcnp table-striped table-bordered table-hover" style="width: 100%;" id="show_karyawan">
              <thead>
                  <tr>
                      <th class="center">No</th>
                      <th class="center">NIK</th>
                      <th class="center">Nama Karyawan</th>
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
