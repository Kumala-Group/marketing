<section id="basic-form-layouts">
	<div class="row match-height">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h5 class="card-title" id="title_profil">List Notifikasi</h5>
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
									<ul class="nav nav-tabs">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#tab2">
												<p class="card-title m-0">Belum dilihat</p>
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#tab3">
												<p class="card-title m-0">Sudah dilihat</p>
											</a>
										</li>
									</ul>
									<div class="tab-content px-1 pt-1">
										<div class="tab-pane active" id="tab2">
											<div class="table-responsive">
												<table class="table table-sm table_aplikasi">
													<thead>
														<tr>
															<th>Kategori</th>
															<th>Deskripsi</th>
															<th>Aksi</th>
														</tr>
													</thead>
													<tbody>
														<?php foreach ($unread as $v) : ?>
															<tr>
																<td><?= $v->judul ?></td>
																<td><?= $v->deskripsi ?></td>
																<td>
																	<div class="form-group mb-0">
																		<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
																			<button type="button" onclick="update_notifikasi(<?= $v->id ?>,'<?= $v->link ?>');" class="btn btn-info"><i class="icon-ios-eye"></i></button>
																			<button type="button" onclick="hapus_data(<?= $v->id ?>,'<?= $v->judul ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
																		</div>
																	</div>
																</td>
															</tr>
														<?php endforeach ?>
													</tbody>
												</table>
											</div>
										</div>
										<div class="tab-pane" id="tab3">
											<div class="table-responsive">
												<table class="table table-sm table_aplikasi">
													<thead>
														<tr>
															<th>Kategori</th>
															<th>Deskripsi</th>
															<th>Aksi</th>
														</tr>
													</thead>
													<tbody>
														<?php foreach ($read as $v) : ?>
															<tr>
																<td><?= $v->judul ?></td>
																<td><?= $v->deskripsi ?></td>
																<td>
																	<div class="form-group mb-0">
																		<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
																			<button type="button" onclick="hapus_data(<?= $v->id ?>,'<?= $v->judul ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
																		</div>
																	</div>
																</td>
															</tr>
														<?php endforeach ?>
													</tbody>
												</table>
											</div>
										</div>
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
	function hapus_data(id, data) {
		swal({
			title: "Apakah anda yakin?",
			text: "Anda akan menghapus data " + data + "!",
			icon: "warning",
			buttons: true
		}).then((ok) => {
			if (ok) {
				$.post(location, {
					'hapus': true,
					'id': id
				}, function(r) {
					swal("", "Data berhasil dihapus!", "success").then(function() {
						location.reload();
					});
				});
			}
		});
	}
</script>