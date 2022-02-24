<script type="text/javascript">
$(document).ready(function(){

  $('.date-picker').datepicker({
    format: 'yyyy-mm-dd'
	});

	$("#view").click(function(){
    var tgl_awal = $("#tgl_awal").val();
    var tgl_akhir = $("#tgl_akhir").val();

    if(tgl_awal.length==0){
				$.gritter.add({
						title: 'Peringatan..!!',
						text: 'Tanggal Awal tidak boleh kosong',
						class_name: 'gritter-error'
				});

				$("#tgl_awal").focus();
				return false();
		}
		if(tgl_akhir.length==0){
				$.gritter.add({
						title: 'Peringatan..!!',
						text: 'Tanggal Akhir tidak boleh kosong',
						class_name: 'gritter-error'
				});

				$("#tgl_akhir").focus();
				return false();
		}
		cari_data();
	});

  $("#cetak_pdf").click(function(){
		var tgl_awal = $("#tgl_awal").val();
		var tgl_akhir = $("#tgl_akhir").val();

		if(tgl_awal.length==0){
				$.gritter.add({
						title: 'Peringatan..!!',
						text: 'Tanggal Awal tidak boleh kosong',
						class_name: 'gritter-error'
				});

				$("#tgl_awal").focus();
				return false();
		}
		if(tgl_akhir.length==0){
				$.gritter.add({
						title: 'Peringatan..!!',
						text: 'Tanggal Akhir tidak boleh kosong',
						class_name: 'gritter-error'
				});

				$("#tgl_akhir").focus();
				return false();
		}
    cari_data();
	});

  $("#cetak_excel").click(function(){
		var tgl_awal = $("#tgl_awal").val();
		var tgl_akhir = $("#tgl_akhir").val();

		if(tgl_awal.length==0){
				$.gritter.add({
						title: 'Peringatan..!!',
						text: 'Tanggal Awal tidak boleh kosong',
						class_name: 'gritter-error'
				});

				$("#tgl_awal").focus();
				return false();
		}
		if(tgl_akhir.length==0){
				$.gritter.add({
						title: 'Peringatan..!!',
						text: 'Tanggal Akhir tidak boleh kosong',
						class_name: 'gritter-error'
				});

				$("#tgl_akhir").focus();
				return false();
		}
	});

});

function cari_data(){
  var tgl_awal = $("#tgl_awal").val();
  var tgl_akhir = $("#tgl_akhir").val();
  $.ajax({
    type	: 'POST',
    url		: "<?php echo site_url(); ?>henkel_adm_lap_hutang/cari_data",
    data	: "tgl_awal="+tgl_awal+"&tgl_akhir="+tgl_akhir,
    cache	: false,
    success	: function(data){
      $("#view_detail").html(data);
    }
  });
}

function cetak_data(data){
		var form = document.getElementById('my-form');
		form.action = data;
		form.submit();
}
</script>

<div class="widget-box ">
    <div class="widget-header">
        <h4 class="lighter smaller">
            <i class="icon-book blue"></i>
            <?php echo $judul;?>
        </h4>
    </div>

    <div class="widget-body">
    	<div class="widget-main">
            <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
              <div class="control-group">
                  <label class="control-label" for="form-field-1">Periode</label>
                   <div class="controls">
                      <div class="input-append">
                        <input type="text" name="tgl_awal" id="tgl_awal" class="date-picker"  data-date-format="dd-mm-yyyy" />
                            <span class="add-on">
                              <i class="icon-calendar"></i>
                            </span>
                      </div>
                      <b> s/d </b>
                      <div class="input-append">
                        <input type="text" name="tgl_akhir" id="tgl_akhir" class="date-picker" data-date-format="dd-mm-yyyy" />
                          <span class="add-on">
                            <i class="icon-calendar"></i>
                          </span>
                      </div>
                </div>
              </div>
              <br />
            <div class="alert alert-success">
              <center>
                <button type="button" name="view" id="view" class="btn btn-mini btn-primary">
                	 <i class="icon-th"></i> Lihat Data
                </button>
                <button type="button" name="cetak_pdf" id="cetak_pdf" class="btn btn-mini btn-danger" onclick="cetak_data('<?php echo site_url();?>henkel_adm_lap_hutang/cetak_pdf_hutang')">
                	 <i class="fa fa-file-pdf-o"></i> Cetak PDF
                </button>
  							<button type="button" name="cetak_excel" id="cetak_excel" class="btn btn-mini btn-success" onclick="cetak_data('<?php echo site_url();?>henkel_adm_lap_hutang/cetak_excel_hutang')">
                	 <i class="fa fa-file-excel-o"></i> Cetak Excel
                </button>
             </center>
           </div>
           </form>
           </div>
           <?php
		  	      echo  $this->session->flashdata('result_info');
		       ?>
        </div> <!-- wg body -->
    </div> <!--wg-main-->
</div>
<div id="view_detail"></div>
