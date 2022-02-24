<section id="basic-form-layouts">
	<div class="row match-height">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h5 class="card-title mb-1">Data Customer Test Drive</h5>
					<form id="form" class="form-inline" style="margin-left:-15px" action="<?= base_url("marketing_support/wuling/customer_testdrive/export") ?>" method="post">				
						<div class="form-group m-0 col-md-3">
							<select id="opt-cabang" name="opt-cabang" class="form-control" style="width:100%">
								<option value=""></option>
							</select>
						</div>
						<div class="form-group m-0 col-md-3">
							<select id="opt-tahun" name="opt-tahun" class="form-control" style="width:100%">
								<option value=""></option>
							</select>
						</div>
						<div class="form-group m-0 col-md-3">
							<select id="opt-bulan" name="opt-bulan" class="form-control" style="width:100%">
								<option value=""></option>
							</select>
						</div>
						<div class="form-group m-0 col-md-3">
							<button id="btn-export" name="btn-export" class="btn btn-success">
								<i class="icon-file"></i> Export
							</button>
						</div>
					</form>
					<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
					<div class="heading-elements">
						<ul class="list-inline mb-0">
							<li><a data-action="expand"><i class="icon-expand2"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="card-body collapse in">
					<div class="card-block pt-1">
						<div class="form-body">
							<div class="row">
								<div class="col-md-12">
									<div class="table-responsive">
										<table class="table table-sm" id="datatable" width="100%"></table>
									</div>
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
		//Init 
		//fill data cabang to select2
		$.ajax({
			url: "<?php echo site_url('marketing_support/wuling/customer_testdrive/select2_cabang'); ?>",
			dataType: 'json',
			async: false,
			success: function(data) {
				$("#opt-cabang").select2({
					data: data,
					allowClear: true,
					placeholder: "SEMUA CABANG",
				}).on('select2:select', function(e) {
					datatable.draw();
				}).on('select2:unselecting', function(e) {
					datatable.draw();
				});;
			},
		});
		//fill data tahun to select2
		$.ajax({
			url: "<?php echo site_url('marketing_support/wuling/customer_testdrive/select2_tahun'); ?>",
			dataType: 'json',
			async: false,
			success: function(data) {
				$("#opt-tahun").select2({
					data: data,
				}).change(function() {
					datatable.draw();
				});
			}
		});
		//fill data bulan to select2
		$.ajax({
			url: "<?php echo site_url('marketing_support/wuling/customer_testdrive/select2_bulan'); ?>",
			dataType: 'json',
			async: false,
			success: function(data) {
				$("#opt-bulan").select2({
					data: data,
				}).change(function() {
					datatable.draw();
				});
			}
		});
		
		$.fn.dataTable.ext.errMode = 'none';
		var datatable = $('#datatable').DataTable({
			processing: true,
			serverSide: true,
			order: [],
			responsive: true,
			ajax: {
				type: 'post',
				url: location,
				data: function(data) {
					data.datatable = true;
					data.cabang = $('#opt-cabang').val();
					data.tahun =  $('#opt-tahun').val();
					data.bulan =  $('#opt-bulan').val();
				}
			},		
			columns: [{
					title: 'ID Prospek',
					data: "id_prospek",
					className: "center"
				},
				{
					title: "Cabang",
					data: "cabang",
					className: "center"
				},
				{
					title: "Tahapan",
					data: "tahapan",
					className: "center"
				},
				{
					title: "Nama Sales",
					data: "sales"
					//className: "center"
				},
				{
					title: "Nama SPV",
					data: "spv"
				},
				{
					title: "Nama Customer",
					data: "customer"
				},
				{
					title: "No Telp",
					data: "telepone",
					className: "center"
				},
				{
					title: "Model",
					data: "model",
					className: "center"
				},
				{
					title: "Waktu",
					data: "waktu",
					className: "center"
				},
				{
					title: "Lokasi",
					data: "tempat"
				},
			],
		}).on( 'error.dt', function (e, settings, techNote, message) {
			alert('error',message);
			console.log( 'Error DataTables: ', message );
		}); ;



	}); //ready
</script>