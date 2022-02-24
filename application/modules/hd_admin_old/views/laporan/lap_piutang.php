<script type="text/javascript">
$(document).ready(function(){
	$('.date-picker').datepicker().next().on(ace.click_event, function(){
		$(this).prev().focus();
	});

	$("#kode_pelanggan").autocomplete({
					// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
					serviceUrl: '<?php echo site_url();?>/ban_adm_search/search_kd_pelanggan',
					// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
					onSelect: function (suggestion) {
							$('#nama_pelanggan').val(''+suggestion.nama_pelanggan);
							$('#alamat').val(''+suggestion.alamat);
					}

	});

	$("#nama_pelanggan").autocomplete({
					// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
					serviceUrl: '<?php echo site_url();?>/ban_adm_search/search_nm_pelanggan',
					// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
					onSelect: function (suggestion) {
							$('#kode_pelanggan').val(''+suggestion.kode_pelanggan); // membuat id 'v_nim' untuk ditampilkan
							$('#alamat').val(''+suggestion.alamat); // membuat id 'v_jurusan' untuk ditampilkan
					}

	});

	$("#view").click(function(){
		cari_data();
	});

	$("#cetak").click(function(){
		return cetak_pdf();
	});

	function cari_data(){
		var tgl_awal = $("#tgl_awal").val();
		var tgl_akhir = $("#tgl_akhir").val();
		var kode_pelanggan = $("#kode_pelanggan").val();
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ban_adm_lap_piutang/cari_data",
			data	: "tgl_awal="+tgl_awal+"&tgl_akhir="+tgl_akhir+"&kode_pelanggan="+kode_pelanggan,
			cache	: false,
			success	: function(data){
				$("#view_detail").html(data);
			}
		});
	}

	function cetak_pdf(){
		var tgl_awal = $("#tgl_awal").val();
		var tgl_akhir = $("#tgl_akhir").val();
		var kode_pelanggan = $("#kode_pelanggan").val();

		if(tgl_awal.length==0){
				$.gritter.add({
						title: 'Peringatan..!!',
						text: 'Tanggal Awal tidak boleh kosong',
						class_name: 'gritter-error'
				});
				$('#tgl_awal').focus();
				return false;
		}

		if(tgl_akhir.length==0){
				$.gritter.add({
						title: 'Peringatan..!!',
						text: 'Tanggal Akhir tidak boleh kosong',
						class_name: 'gritter-error'
				});
				$('#tgl_akhir').focus();
				return false;
		}

		window.open("<?php echo site_url(); ?>/ban_adm_lap_piutang/cetak?tgl_awal="+tgl_awal+"&tgl_akhir="+tgl_akhir+"&kode_pelanggan="+kode_pelanggan);

	}

});
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
                        <label class="control-label" for="form-field-1"> Dari Tanggal</label>
                         <div class="controls">
	                    		<div class="input-append">
			                            <input type="text" name="tgl_awal" id="tgl_awal" class="span6 date-picker"  data-date-format="dd-mm-yyyy" />
			                        <span class="add-on">
			                            <i class="icon-calendar"></i>
			                        </span>
		                        </div>
	                    </div>
                    </div>

                     <div class="control-group">
                        <label class="control-label" for="form-field-1">s/d Tanggal </label>
                         <div class="controls">
	                    		<div class="input-append">
			                            <input type="text" name="tgl_akhir" id="tgl_akhir" class="span6 date-picker"  data-date-format="dd-mm-yyyy" />
			                        <span class="add-on">
			                            <i class="icon-calendar"></i>
			                        </span>
		                        </div>
	                    </div>
                    </div>

		    				    <div class="control-group">
                        <label class="control-label" for="form-field-1">Kode Pelanggan</label>
                        <div class="controls">
                            <input type="text" name="kode_pelanggan" id="kode_pelanggan" class="span2" />
                        </div>
                    </div>
										<div class="control-group">
                        <label class="control-label" for="form-field-1">Nama Pelanggan</label>
                        <div class="controls">
                            <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="span5" />
                        </div>
                    </div>
										<div class="control-group">
                        <label class="control-label" for="form-field-1">Alamat</label>
                        <div class="controls">
                            <input type="text" name="alamat" id="alamat" class="span8" />
                        </div>
                    </div>

            <div class="alert alert-success">
            <center>
                     <button type="button" name="view" id="view" class="btn btn-mini btn-info">
                     <i class="icon-th"></i> Lihat Data
                     </button>
                     <button type="submit" name="cetak" id="cetak" class="btn btn-mini btn-primary">
                     <i class="icon-print"></i> Cetak
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
