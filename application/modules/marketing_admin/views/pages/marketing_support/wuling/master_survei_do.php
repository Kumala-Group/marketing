<section id="basic-form-layouts">
	<div class="row match-height">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h5 class="card-title mb-1">Survei DO</h5>
					<form id="form" class="form-inline" action="<?= base_url("marketing_support/wuling/master_survei_do/export") ?>" method="post">
						<div class="form-group m-0">
							<select id="perusahaan" name="perusahaan" class="form-control">
								<option value="" selected>-- Semua Cabang --</option>
								<?php foreach ($lokasi as $v) : ?>
									<option value="<?= $v->id_perusahaan ?>"><?= "$v->singkat - $v->lokasi" ?></option>
								<?php endforeach ?>
							</select>
						</div>
						<div class="form-group m-0">
							<select id="bulan" name="bulan" class="form-control" required>
								<?php
								$nama_bulan = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
								$now = (int) date('m');
								$selected = '';
								for ($bln = 1; $bln <= 12; $bln++) {
									echo '<option ' . ($bln == $now ? 'selected' : '') . ' value="' . $bln . '">' . $nama_bulan[$bln] . '</option>';
								}
								?>
							</select>
						</div>
						<div class="form-group m-0">
							<select id="tahun" name="tahun" class="form-control" required>
								<?php $thn_skrng = date('Y');
								for ($thn = $thn_skrng; $thn >= 2017; $thn--) {
									echo "<option value=$thn>$thn</option>";
								}
								?>
							</select>
						</div>

						<button id="export" name="export" class="btn btn-success">
							<i class="icon-share"></i> Export
						</button>
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
				data.perusahaan = $('#perusahaan').val();
				data.tahun = $('#tahun').val();
				data.bulan = $('#bulan').val();
			}
		},
		columns: [{
			data: 'nama',
			title: 'Nama Customer',
		}, {
			data: 'jenis_kelamin',
			title: 'Jemis Kelamin',
		}, {
			data: 'tgl_lahir',
			title: 'Tanggal Lahir',
			width: '100px',
		}, {
			data: 'usia',
			title: 'Usia',
			width: '90px',
			orderable: false
		}, {
			data: 'telepone',
			title: 'Telepon',
		}, {
			data: 'email',
			title: 'Email',
		}, {
			data: 'alamat',
			title: 'Alamat',
		}],
	});
	$("#perusahaan").change(function() {
		datatable.draw();
	});
	$("#tahun").change(function() {
		datatable.draw();
	});
	$("#bulan").change(function() {
		datatable.draw();
	});
</script>