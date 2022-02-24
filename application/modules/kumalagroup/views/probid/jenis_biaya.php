<section id="basic-form-layouts">
	<div class="row match-height">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h5 class="card-title" id="title_profil"><?= $judul ?></h5>
					<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
					<div class="heading-elements">
						<ul class="list-inline mb-0">
							<li><a data-action="expand"><i class="icon-expand2"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="card-body collapse in">
					<div class="card-block pt-1">
						<form id="form" class="form">
							<div class="form-body">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group mb-1">
											<input type="text" id="kategori_biaya" name="kategori_biaya" class="form-control" value="<?php echo GenerateCode('kumalagroup', 'jenis_biaya', 'id_biaya', 'KTB00') ?>" readonly required>
										</div>
										<div class="form-group mb-1">
											<select name="akun" id="akun" class="select2" style="width: 100%;">
												<option></option>
												<?php foreach ($akun as $dt) : ?>
													<option value="<?= $dt->kode_akun ?>"><?= $dt->kode_akun . ' - ' . $dt->nama_akun ?></option>
												<?php endforeach ?>
											</select>
										</div>
										<div class="form-group mb-1">
											<input type="text" id="nama_biaya" name="nama_biaya" class="form-control" placeholder="Nama Biaya" required>
										</div>
										<div class="form-group mb-1">
											<textarea id="deskripsi" name="deskripsi" rows="2" class="form-control" placeholder="Deskripsi"> </textarea>
										</div>

										<input type="hidden" id="id_biaya" name="id_biaya">
										<div class="form-actions right">
											<a href="" class="btn btn-warning mr-1">
												<i class="icon-reload"></i> Reset
											</a>
											<button id="submit" class="btn btn-primary">
												<i class="icon-check2"></i> Simpan
											</button>
										</div>

									</div>
									<div class="col-md-9">
										<div class="table-responsive">
											<table class="table table-sm table_aplikasi" id="table_jenis_biaya">

											</table>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="modal fade text-xs-left" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<label class="modal-title text-text-bold-600" id="myModalLabel33">Detail Master Biaya</label>
			</div>
			<form action="" name="detail_biaya" id="detail_biaya">
				<div class="modal-body">
					<div class="form-group md-1">
						<input type="text" id="detail_kategori" name="detail_kategori" class="form-control" style="width: 40%;" readonly required>
					</div>
					<div class="form-group md-1">
						<select name="perusahaan" id="perusahaan" class="select2 form-control" style="width: 40%;">
							<option></option>
							<?php foreach ($perusahaan as $dt) : ?>
								<option value="<?= $dt->id_perusahaan ?>"><?= $dt->singkat . ' - ' . $dt->lokasi ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="form-group md-1">
						<input type="text" id="id_pelanggan" name="id_pelanggan" class="form-control" style="width: 40%;" placeholder="ID Pelanggan" required>
					</div>
					<div class="form-group mb-1">
						<select name="type_biaya" id="type_biaya" class="select2 form-control" style="width: 40%;" required>
							<option value="">Pilih Type Biaya</option>
							<option value="1">Biaya Internal</option>
							<option value="2">Biaya External</option>
						</select>
					</div>
					<div class="form-group mb-1">
						<textarea id="deskripsi_detail" name="deskripsi_detail" rows="2" class="form-control" style="width: 40%;" placeholder="Deskripsi"> </textarea>
					</div>

				</div>
			</form>
			<div class="modal-footer">
				<button type="button" id="simpan_detail" name="simpan_detail" class="btn btn-sm btn-primary">
					<i class="icon-save"></i> Simpan
				</button>
			</div>
		</div>
	</div>
</div>
<script>
	$('#akun').select2({
		placeholder: "Pilih Akun",
		// width: 'auto',
		// dropdownAutoWidth: true,
		// allowClear: true,
	});
	$('#perusahaan').select2({
		placeholder: "Pilih Perusahaan"
	});
	$('#submit').click(function(e) {
		var data = $('#form').serialize();
		e.preventDefault();
		loading();
		$.post("<?= base_url(); ?>probid/kumalagroup_probid/simpan_master_biaya", data,
			function(data) {
				if (data == 'data_update') {
					swal("", "Data berhasil diupdate!", "success").then(function() {
						location.reload();
					});
				} else if (data == 'data_insert') {
					swal("", "Data berhasil disimpan!", "success").then(function() {
						location.reload();
					});
				} else {
					swal("", data + '!', "warning").then(function() {
						unload();
					});
				}
			},

		);
	});

	var untukTableDatatable = function() {
		$('#table_jenis_biaya').DataTable({
			// responsive: true,
			serverside: true,
			processing: true,
			info: true,

			ajax: {
				url: "<?= base_url(); ?>probid/kumalagroup_probid/get_data_jenis_biaya",
				type: 'POST',
			},
			columns: [{
					data: 'kategori_biaya',
					title: 'Kategori Biaya',
				},
				{
					data: null,
					title: 'Kode - Nama Akun',
					searchable: false,
					render: function(data, type, full, meta) {
						return full.kode_akun + ' - ' + full.nama_akun;
					}

				},
				{
					data: 'nama_biaya',
					title: 'Nama Biaya',
				},
				{
					data: 'deskripsi',
					title: 'Deskripsi',
				},

				{
					data: null,
					title: 'Aksi',
					orderable: false,
					searchable: false,
					render: function(data, type, full, meta) {
						return `<div class="form-group mb-0">
                        <div class="btn-group btn-group-sm">
                        <button type="button" onclick="edit_data(` + full.id_biaya + `,'` + full.kategori_biaya + `','` + full.kode_akun + `','` + full.nama_biaya + `', '` + full.deskripsi + `', '` + full.nama_akun + `');" class="btn btn-info" title="Edit Biaya"><i class="icon-ios-compose-outline"></i></button>
                        </div>
						<div class="btn-group btn-group-sm">
						<a href="#modal_detail" type="button" data-toggle="modal" data-kategori_biaya="` + full.kategori_biaya + `" class="btn btn-primary" title="Detail biaya"><i class="icon-edit"></i></a>
                     	</div></div>`;

					},
				}

			],

		});
	}();

	function edit_data(id_biaya, kategori_biaya, kode_akun, nama_biaya, deskripsi, nama_akun) {
		$('#id_biaya').val(id_biaya);
		$('#kategori_biaya').val(kategori_biaya);
		$('#akun').val(kode_akun);
		$('#select2-akun-container').html(nama_akun);
		$('#nama_biaya').val(nama_biaya);
		$('#deskripsi').val(deskripsi);
	}

	var untukModalDetail = function() {
		$('#modal_detail').on('show.bs.modal', function(e) {
			$('#perusahaan').val('');
			$('#id_pelanggan').val('');
			$('#deskripsi_detail').val('');
			kategori_biaya = $(e.relatedTarget).data('kategori_biaya');
			$('#detail_kategori').val(kategori_biaya);
		});
	}();

	$('#simpan_detail').click(function(e) {
		var detail = $('#detail_biaya').serialize();
		var form = $('#detail_biaya');
		e.preventDefault();
		if (form.valid()) {
			modal_loading();
			$.post("<?= base_url() ?>probid/kumalagroup_probid/simpan_detail_biaya", detail,
				function(data) {
					if (data == 'update_detail') {
						swal("", "Data berhasil diupdate!", "success").then(function() {
							location.reload();
						});
					} else if (data == 'inser_detail') {
						swal("", "Data berhasil disimpan!", "success").then(function() {
							location.reload();
						});
					} else {
						swal("", data + '!', "warning").then(function() {
							modal_unload();
						});
					}
				},
			);
		}
	});
</script>