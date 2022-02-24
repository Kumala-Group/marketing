<script type="text/javascript">
    $(document).ready(function(){
      $('.date-picker').datepicker().next().on(ace.click_event, function(){
    		$(this).prev().focus();
    	});

      $('#wkt_tiket').timepicker({
					minuteStep: 1,
					showSeconds: true,
					showMeridian: false,
					disableFocus: true,
					icons: {
						up: 'fa fa-chevron-up',
						down: 'fa fa-chevron-down'
					}
				}).on('focus', function() {
					$('#timepicker1').timepicker('showWidget');
				}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});


        $("#cari_karyawan").click(function(){
          var id_perusahaan = $("#id_perusahaan").val();
        $.ajax({
          type	: "GET",
          url		: "<?php echo site_url();?>hd_adm_datatable/karyawan/"+id_perusahaan,
          dataType: "json",
          success	: function(data){
                    var table = $('#show_karyawan').DataTable({
                    "bProcessing": true,
                    "bDestroy": true,
                    "sAjaxSource": '<?php echo site_url();?>hd_adm_datatable/karyawan/'+id_perusahaan,
                    "bSort": false,
                    "bAutoWidth": true,
                    "iDisplayLength": 10, "aLengthMenu": [10,20,40,80], // can be removed for basic 10 items per page
                    "sPaginationType": "full_numbers",
                    "aoColumnDefs": [{"bSortable": false,
                                     "aTargets": [ -1 , 0]}], //Feature control DataTables' server-side processing mode.
                    "aoColumns": [
                      {"mData" : "no"},
                      {"mData" : "nik"},
                      {"mData" : "nama_karyawan"},
                      {"mData" : "nama_jabatan"}
                    ]
                });
                $('#modal-search').modal('show');
          }
        });
        });
        $('#show_karyawan tbody').on( 'click', 'tr', function () {
                      var nik=$(this).find('td').eq(1).text();
                      var nama_karyawan=$(this).find('td').eq(2).text();
                      var nama_jabatan=$(this).find('td').eq(3).text();
                      $("#nik_tiket").val(nik);
                      $("#nama_karyawan").val(nama_karyawan);
                      $("#jabatan").val(nama_jabatan);
                      $('#modal-search').modal('hide');
                  });

                  $("#simpan").click(function(){
                      var id_perusahaan = $("#id_perusahaan").val();
                      var nik_tiket = $("#nik_tiket").val();
                      var tgl_tiket = $("#tgl_tiket").val();
                      var wkt_tiket = $("#wkt_tiket").val();
                      var masalah = $("#masalah").val();
                      var priority = $("#priority").val();

                      var string = $("#my-form").serialize();



                      if(nik_tiket.length==0){
                          $.gritter.add({
                              title: 'Peringatan..!!',
                              text: 'NIK tidak boleh kosong',
                              class_name: 'gritter-error'
                          });

                          $("#nik_tiket").focus();
                          return false();
                      }
                      if(tgl_tiket.length==0){
                          $.gritter.add({
                              title: 'Peringatan..!!',
                              text: 'Tanggal Tiket tidak boleh kosong',
                              class_name: 'gritter-error'
                          });

                          $("#tgl_tiket").focus();
                          return false();
                      }
                      if(wkt_tiket.length==0){
                          $.gritter.add({
                              title: 'Peringatan..!!',
                              text: 'Waktu Tiket tidak boleh kosong',
                              class_name: 'gritter-error'
                          });

                          $("#wkt_tiket").focus();
                          return false();
                      }
                      if(masalah.length==0){
                          $.gritter.add({
                              title: 'Peringatan..!!',
                              text: 'Masalah tidak boleh kosong',
                              class_name: 'gritter-error'
                          });

                          $("#masalah").focus();
                          return false();
                      }
                      if(priority.length==0){
                          $.gritter.add({
                              title: 'Peringatan..!!',
                              text: 'Prioritas tidak boleh kosong',
                              class_name: 'gritter-error'
                          });

                          $("#priority").focus();
                          return false();
                      }


                      $.ajax({
                          type    : 'POST',
                          url     : "<?php echo site_url(); ?>hd_adm_ticketing/simpan",
                          data    : string,
                          cache   : false,
                          start   : $("#simpan").html('...Sedang diproses...'),
                          success : function(data){
                              $("#simpan").html('<i class="icon-save"></i> Simpan');
                              alert(data);
                              <?php
                        			$jabatan = $this->session->userdata('id_jabatan');
                        			if ($jabatan == '45') {

                        			?>
                              location.replace("<?php echo site_url(); ?>hd_adm_ticketing")
                              <?php
                            }else {
                        			?>

                              location.replace("<?php echo site_url(); ?>hd_adm_ticketing/tambah")
                              <?php
                            }
                        			?>
                          }
                      });

                  });

    });

</script>




<form class="form-horizontal" name="my-form" id="my-form"  method="post">
<div class="row-fluid">
<div class="table-header">
    <div class="pull-right" style="padding-right:15px;"><?php echo 'Tanggal : '.tgl_indo($tanggal);?></div><input type="hidden" name="tanggal" id="tanggal" value="<?php echo $tanggal?>">
    <input type="hidden" value="" name="id" id="id">
</div>
<div class="space"></div>
   <div class="row-fluid">
        <div class="span6">
                <div class="control-group">
                      <?php
      								$jabatan = $this->session->userdata('id_jabatan');
      								if ($jabatan == '45') {

      								?>

                      <label class="control-label" for="form-field-1">Cabang</label>
                      <div class="controls">
                      <select name="id_perusahaan" id="id_perusahaan">
                      <?php
                      foreach($perusahaan as $dt){
                      ?>
                      <option value="<?php echo $dt->id_perusahaan;?>"><?php echo $dt->nama_brand.' - '.$dt->lokasi;?></option>
                      <?php
                      }
                      ?>
                      </select>
                        <button type="button" name="cari_karyawan" id="cari_karyawan" class="btn btn-small btn-info">
                            <i class="icon-search"></i>
                            Cari
                        </button>

                    </div>

                        <?php
                      }else {



        								?>
                        <div class="controls">
                        <input type="hidden" name="id_perusahaan" id="id_perusahaan" readonly="readonly" value="<?php echo $this->session->userdata('id_perusahaan');?>" />
                      </div>
                        <?php
                      }



        								?>
               </div>
               <?php
               $jabatan = $this->session->userdata('id_jabatan');
               if ($jabatan == '45') {

               ?>
               <div class="control-group">
                   <label class="control-label" for="form-field-1">NIK</label>
                   <div class="controls">
                       <input type="text" name="nik_tiket" id="nik_tiket" placeholder="NIK" readonly="readonly"  />

                   </div>
              </div>

                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Karyawan</label>
                    <div class="controls">
                        <input type="text" name="nama_karyawan" id="nama_karyawan" placeholder="Nama Karyawan" readonly="readonly" />
                    </div>
                </div>

                <?php
              }else{



                ?>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">NIK</label>
                    <div class="controls">
                        <input type="text" name="nik_tiket" id="nik_tiket" placeholder="NIK" readonly="readonly" value="<?php echo $this->session->userdata('username');?>" />

                    </div>
               </div>

                 <div class="control-group">
                     <label class="control-label" for="form-field-1">Nama Karyawan</label>
                     <div class="controls">
                         <input type="text" name="nama_karyawan" id="nama_karyawan" placeholder="Nama Karyawan" readonly="readonly" value="<?php echo $this->session->userdata('nama_lengkap');?>"/>
                     </div>
                 </div>

                      <?php
                    }
      								$jabatan = $this->session->userdata('id_jabatan');
      								if ($jabatan == '45') {

      								?>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Jabatan</label>
                    <div class="controls">
                        <input type="text" name="jabatan" id="jabatan" placeholder="Jabatan" readonly="readonly"/>
                    </div>
                </div>
                <?php
              }



                ?>
         </div>
         <div class="span6">
                 <div class="control-group">
                     <label class="control-label" for="form-field-1">Tanggal</label>
                     <div class="controls">

     											<div class="input-append">
     														<input type="text" name="tgl_tiket" id="tgl_tiket" class="date-picker" placeholder="Tanggal Tiket" data-date-format="dd-mm-yyyy"/>
     												<span class="add-on">
     														<i class="icon-calendar"></i>
     												</span>
     												</div>
                     </div>

                </div>
                 <div class="control-group">
                     <label class="control-label" for="form-field-1">Waktu</label>
                     <div class="controls">
                       <div class="input-append bootstrap-timepicker">
															<input id="wkt_tiket" name="wkt_tiket" type="text" class="form-control" />
															<span class="add-on">
																<i class="fa fa-clock-o bigger-110"></i>
															</span>
                            </div>
                     </div>
                 </div>
          </div>
    </div>
<div class="space"></div>
</br>
<div class="row-fluid">
     <div class="span4">
             <div class="control-group">
                 <label class="control-label" for="form-field-1">Masalah</label>
                 <div class="controls">
                     <textarea name="masalah" id="masalah"></textarea>
                 </div>
             </div>
             <div class="control-group" id="form_faktur">
                 <label class="control-label" for="form-field-1">Prioritas</label>
                 <div class="controls">
                       <select name="priority" id="priority">
                         <option value="">--Pilih Prioritas Tiket--</option>
                         <option value="High">High</option>
                         <option value="Normal">Normal</option>
                         <option value="Low">Low</option>

                        </select>
                 </div>
             </div>

      </div>


 </div>

</form>

<div class="row-fluid">
     <div class="span12" align="center">
         <a href="<?php echo base_url();?>hd_adm_ticketing" class="btn btn-small btn-danger">
             <i class="icon-remove"></i>
             Cancel
         </a>
          <button type="button" name="simpan" id="simpan" class="btn btn-small btn-warning">
              <i class="icon-save"></i>
              Simpan
          </button>

      </div>
</div>

<div id="modal-search" class="modal hide fade" style="width:80%;max-height:80%;left:30%;" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Daftar Karyawan Perusahaan
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
                      <th class="center">Jabatan</th>
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
