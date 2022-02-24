<section id="basic-form-layouts">
	<div class="row match-height">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h5 class="card-title"><i class="icon-android-car"></i> Test Drive</h5>
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
							<form id="form" class="form" action="" method="post">
								<div class="col-md-3">
									<div class="form-group">
										<label>Cabang</label>
										<select id="opt-perusahaan" name="opt-perusahaan" class="form-control">
											<option></option>
											<?php foreach ($cabang as $dt) :
												echo '<option value="' . $dt->id_perusahaan . '">' . $dt->lokasi . '</option>';
											endforeach;
											?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Tahun</label>
										<select id="opt-tahun" name="opt-tahun" class="form-control">
											<?php $thn_skrng = date('Y');
											for ($thn = $thn_skrng; $thn >= 2017; $thn--) {
												echo "<option value=$thn>$thn</option>";
											}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Bulan</label>
										<select id="opt-bulan" name="opt-bulan" class="form-control">
											<?php
											$now = (int) date('m');
											$selected = '';
											?>
											<?php
											for ($bln = 1; $bln <= 12; $bln++) { ?>
												<option <?= ($bln == $now ? 'selected' : '') ?> value=<?= $bln ?>><?= $nama_bulan[$bln] ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								<!-- <div class="col-md-3">
									<div class="form-group mt-2">
										<label>&nbsp;</label>
										<button class="btn btn-success" name="btn-export" id="btn-export"><i class="icon-file"></i> Export</button>
										<button type="button" class="btn btn-success" name="btn-export" id="btn-export"><i class="icon-file"></i> Export</button>
									</div>
								</div> -->
							</form>
						</div>
						<div class="row mt-1">
							<div class="col-xs-12">
								<div class="table-responsive">
									<table class="table table-bordered table-hover" id="table-test-drive">
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
		//init
		$("#opt-perusahaan").select2({
			allowClear: true,
			placeholder: 'SEMUA CABANG',
		}).change(function() {
			// var column = tableTestDrive.column("1");
			// if ($("#opt-perusahaan").val() == '') {
			// 	column.visible(true);
			// } else {
			// 	column.visible(false);
			// }
			//column.visible( ! column.visible() );
			tableTestDrive.draw();
		});
		$("#opt-tahun").select2({

		}).change(function() {
			tableTestDrive.draw();
		});
		$("#opt-bulan").select2({}).change(function() {
			tableTestDrive.draw();
		});

		//datatable10
		$.fn.dataTable.ext.errMode = 'none';
		tableTestDrive = $("#table-test-drive").DataTable({
			processing: true,
			serverSide: true,
			paging: true,
			searching: true,
			ordering: true,
			info: true,
			//order: [],			
			// responsive: true,
			autoWidth: true,
			ajax: {
				type: "POST",
				url: "<?= site_url('marketing_support/wuling/test_drive/get') ?>",
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
					className: "center"
				},
				{
					data: "cabang",
					title: "Cabang",
					className: "center",
				},
				{
					data: "tahapan",
					title: "Tahapan",
					className: "center",
				},
				{
					data: "sales",
					title: "Nama Sales",
				},
				{
					data: "spv",
					title: "Nama SPV",
				},
				{
					data: "customer",
					title: "Nama Customer",
				},
				{
					data: "telepone",
					title: "Telepone",
					className: "center",
				},
				{
					data: "model",
					title: "Model",
					className: "center",
				},
				{
					data: "waktu",
					title: "Waktu",
					className: "center",
				},
				{
					data: "tempat",
					title: "Lokasi",
					className: "center",
				},
			],
			columnDefs: [{
				targets: 10,
				//visible: true,
				// searchable: true,
				// orderable: false,
				title: 'Aksi',
				data: null,
				className: 'center',
				// width: '70px',
				createdCell: function(td, cellData, rowData, row, col) {
					var verified = rowData.verified;
					var id_test_drive = rowData.id_test_drive;
					if (verified == '1') {
						//$(td).html('<a class="success" href="#" title="Verified"><i class="icon-check icon-large "></i></a>');
						$(td).html('<button class="btn btn-minier btn-success" href="#" title="Verified"><i class="icon-check icon-large"></i> Verified</button>');
					} else {
						$(td).html('<button class="btn btn-minier btn-warning" href="#" title="Waiting" onclick="verify(\'' + id_test_drive + '\')"><i class="icon-clock3 icon-large"></i> waiting</button>');
					}
				},
			}],

			// initComplete: function(settings, json) {
			// 	//$("#test_drive").wrap("<div style='overflow:auto; width:97%;position:relative;'></div>");				
			// },
		}).on('error.dt', function(e, settings, techNote, message) {
			pesan('error', message);
			//Swal.fire(message,"","error")
			console.log('Error DataTables: ', message);
		});
	});

	function verify(id_test_drive) {
		var id_perusahaan = $("#opt-perusahaan").val();
		var tahun = $("#opt-tahun").val();
		var bulan = $("#opt-bulan").val();
		//var ajaxUrl = "<?php echo site_url(); ?>wuling_adm_sales_test_drive/get?id_perusahaan="+id_perusahaan+"&tahun="+tahun+"&bulan="+bulan;
		swal({
				title: "Apakah anda yakin?",
				// text: "Apakah Anda yakin verifikasi test drive?",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			})
			.then((willOk) => {
				if (willOk) {
					$.ajax({
						url: "<?= site_url('marketing_support/wuling/test_drive/verifikasi') ?>",
						type: "POST",
						data: {
							id_test_drive: id_test_drive
						},
						beforeSend: function() {
							//$("#btn-export-hpm").html('<i class="icon-spinner icon-spin icon-large"></i>Memproses...')
							//$("#btn-export-hpm").prop('disabled', true);
						},
						success: function(data) {
							tableTestDrive.draw(false);
							swal("", data, "success");
						},
						error: function(xhr, status, error) {
							console.log('Status:' + xhr.status + '\r\nResponse:' + xhr.responseText);
							pesan('error', xhr.status + '::' + error);
						},
					});
				} else {
					// swal("Your imaginary file is safe!");
				}
			});
	}
</script>