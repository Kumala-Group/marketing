<section id="basic-form-layouts">
	<div class="row match-height">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h5 class="card-title"><i class="icon-flag" ></i> Survei DO</h5>
					<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
					<div class="heading-elements">
						<ul class="list-inline mb-0">
							<li><a data-action="expand"><i class="icon-expand2"></i></a></li>
						</ul>
					</div>
				</div>

				<div class="card-body collapse in">
					<div class="card-block font-small-2">
						<div class="row">
							<form id="form" class="form" action="<?= base_url("marketing_support/hino_laporan_survei_do/export") ?>" method="post">
								<div class="col-md-3">
									<div class="form-group">
										<label>Cabang</label>
										<select id="opt-perusahaan" name="opt-perusahaan" class="form-control">
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Tahun</label>
										<select id="opt-tahun" name="opt-tahun" class="form-control">
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Bulan</label>
										<select id="opt-bulan" name="opt-bulan" class="form-control">
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group mt-2">
										<label>&nbsp;</label>
										<button class="btn btn-success" name="btn-export" id="btn-export"><i class="icon-file"></i> Export</button>
										<!-- <button type="button" class="btn btn-success" name="btn-export" id="btn-export"><i class="icon-file"></i> Export</button> -->
									</div>
								</div>
							</form>
						</div>						
						<div class="row mt-1">
							<div class="col-xs-12">
								<div class="table-responsive">
									<table class="table table-bordered table-hover" id="table_survei">                                            
									</table>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
	$(document).ready(function() {

		$.ajax({
			type: "POST",
			url: "<?= site_url('marketing_support/hino_laporan_survei_do/select2_cabang'); ?>",
			dataType: "JSON",
			success: function(resultData) {
				$("#opt-perusahaan").select2({
					//placeholder: '-- PILIH CABANG --',                    
					data: resultData,
				}).change(function() {
					table_survei.ajax.reload();
				});
				$.ajax({
					type: "POST",
					url: "<?= site_url('marketing_support/hino_laporan_survei_do/select2_tahun'); ?>",
					dataType: "JSON",
					success: function(data) {
						$("#opt-tahun").select2({
							data: data,
						}).change(function() {
							table_survei.ajax.reload();
						});
						$.ajax({
							type: "POST",
							url: "<?= site_url('marketing_support/hino_laporan_survei_do/select2_bulan'); ?>",
							dataType: "JSON",
							success: function(data) {
								$("#opt-bulan").select2({
									data: data,
								}).change(function() {
									table_survei.ajax.reload();
								});

								//datatable10
								$.fn.dataTable.ext.errMode = 'none';
								table_survei = $("#table_survei").DataTable({
									processing: true,
									//serverSide: true,							
									order: [],
									autoWidth: false,
									ajax: {
										type: "POST",
										url: "<?= site_url('marketing_support/hino_laporan_survei_do/get') ?>",
										data: function(data) {
											data.cabang = $("#opt-perusahaan").val();
											data.bulan = $("#opt-bulan").val();
											data.tahun = $("#opt-tahun").val();										
										},
									},
									language: {
										"processing": "Memproses, silahkan tunggu..."
									},
									columns: [{
											data: "id_prospek",
											title: "ID Prospek",
											className: "center nowrap"
										},
										{
											data: "tgl_do",
											title: "Tgl DO",
											className: "center nowrap"
										},
										{
											data: "nama_customer",
											title: "Nama Customer",
											className: "nowrap"
										},									
										{
											data: "tipe_unit",
											title: "Tipe Unit",
											className: "nowrap"
										},
										{
											data: "cara_bayar",
											title: "Cara Bayar",
											className: "center nowrap"
										},
										{
											data: "nama_sales",
											title: "Nama Sales",
											className: "nowrap",
										},										
									],
									
									initComplete: function(settings, json) {
										//$("#table_survei").wrap("<div style='overflow:auto; width:97%;position:relative;'></div>");				
									},
								}).on('error.dt', function(e, settings, techNote, message) {
									pesan('error', message);
									//Swal.fire(message,"","error")
									console.log('Error DataTables: ', message);
								}).on('xhr', function() { //cek data kosong untuk disable tombol export
									var json = table_survei.ajax.json();
									if (json.aaData.length > 0) {
										$("#btn-export").prop('disabled', false);
									} else {
										$("#btn-export").prop('disabled', true);
									}; //table_survei	
								});
								
							}
						});
					}
				});
			}
		});

	});


	// $("#opt-perusahaan").change(function() {
	// 	table_survei.draw();
	// });

	// $("#opt-tahun").change(function() {
	// 	table_survei.draw();
	// });

	// $("#opt-bulan").change(function() {
	// 	table_survei.draw();
	// });	
	
</script>