<section id="basic-form-layouts">
	<div class="row match-height">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h5 class="card-title" id="title_profil">Tabel Pelamar</h5>
					<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
					<div class="heading-elements">
						<ul class="list-inline mb-0">
							<li><a data-action="expand"><i class="icon-expand2"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="card-body collapse in">
					<div class="card-block pt-1">
						<!-- <div class="form-body"> -->
							<div class="row-fluid">
								<!-- <div class="col-md-12"> -->
									<!-- <div class="table-responsive"> -->
										<!-- <table class="table table-sm table_aplikasi"> -->
										<table id="table_pelamar" class="table stripe hover table-bordered nowrap">	
											<!-- <thead>
												<tr>
													<th class="nowrap">Posisi</th>
													<th>Nama</th>
													<th>Email</th>
													<th>Alamat</th>
													<th>Telepon</th>
													<th>Pendidikan</th>
													<th>Foto</th>
													<th>CV</th>
													<th>Surat Lamaran</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												< ?php foreach ($data as $v) : ?>
													<tr>
														<td class="nowrap">< ?= $v->posisi ?></td>
														<td>< ?= $v->nama ?></td>
														<td>< ?= $v->email ?></td>
														<td>< ?= $v->alamat ?></td>
														<td>< ?= $v->telepon ?></td>
														<td>< ?= $v->pendidikan ?></td>
														<td class="foto-karyawan">															
															<a class="btn btn-sm btn-blue" href="< ?= $img_server ?>assets/img_marketing/pelamar/<?= $v->foto ?>" title="<?= $v->nama ?>" data-rel="colorbox"><i class="icon-user"></i></a>
														</td>
														<td>
															<a class="btn btn-sm btn-primary" download href="< ?= $img_server ?>assets/img_marketing/pelamar/<?= $v->cv ?>" target="_blank"><i class="icon-file"></i></a>
														</td>
														<td>
															<a class="btn btn-sm btn-primary" download href="< ?= $img_server ?>assets/img_marketing/pelamar/<?= $v->surat_lamaran ?>" target="_blank"><i class="icon-file"></i></a>
														</td>
														<td>															
															<button type="button" onclick="hapus_data(< ?= $v->id ?>,'<?= $v->nama ?>');" class="btn btn-sm btn-danger"><i class="icon-ios-trash"></i></button>
														</td>
													</tr>
												< ?php endforeach ?>
											</tbody> -->
										</table>
									<!-- </div> -->
								<!-- </div> -->
							</div>
						<!-- </div> -->
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

	$(function() {
		 //datatable10
		 $.fn.dataTable.ext.errMode = 'none';
		table_pelamar = $("#table_pelamar").DataTable({
			serverSide: true,
			processing: true,
			order: [],
			autoWidth: false,
			ajax: {
				type: "POST",
				url: "<?= site_url('admin/pelamar/get') ?>",				
			},
			language: {
				"processing": "Memproses, silahkan tunggu...",
				"emptyTable": "Data masih kosong..."
			},
			columns: [
				{
					data: "posisi",
					title: "Posisi",	
					className: "dt-head-center",
				},
				{
					data: "nama",
					title: "Nama",
					className: "dt-head-center",	
				},
				{
					data: "email",
					title: "Email",
					className: "dt-head-center",
				},
				{
					data: "alamat",
					title: "Alamat",
					className: "dt-head-center",		
				},
				{
					data: "telepon",
					title: "Telepon",
					className: "dt-head-center",
				},
				{
					data: "pendidikan",
					title: "Pendidikan",
					className: "dt-head-center",
				},
				{
					data: "foto",
					title: "Foto",
					className: "dt-body-center foto-karyawan",
					orderable: false,
					render: function ( data, type, row, meta ) {				
						return `<a class="btn btn-sm btn-blue btn-foto" href="${data}" title="${row.nama}" data-rel="colorbox"><i class="icon-user"></i></a>`;
					},
				},
				{
					data: "cv",
					title: "CV",
					className: "dt-body-center",
					orderable: false,
					render: function ( data, type, row, meta ) {
						return `<a class="btn btn-sm btn-primary" download href="${data}" target="_blank"><i class="icon-file"></i></a>`;						
					},
				},
				{
					data: "surat_lamaran",
					title: "Surat Lamaran",
					className: "dt-body-center",
					orderable: false,
					render: function ( data, type, row, meta ) {
						return `<a class="btn btn-sm btn-primary" download href="${data}" target="_blank"><i class="icon-file"></i></a>`;						
					},
				},				
				{
					data: "id",
					title: "Aksi",
					className: "dt-body-center",
					width: "70px",
					orderable: false,
					render: function ( data, type, row, meta ) {						
						return `<span style="text-align:center"><button type="button" onclick="hapus_data('${data}','${row.nama}');" class="btn btn-sm btn-danger"><i class="icon-trash2"></i></button></span>`;
					},
				},
				
			],				
			initComplete: function(settings, json) {
				//if (json.level == 'hino_gm') {
				//table_pelamar.columns(10).visible(false);
				//} else {
				// table_pelamar.columns(10).visible(true);
				//}
				$("#table_pelamar").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
				

				$("#cboxLoadingGraphic").append("<i class='icon-spinner orange'></i>"); //let's add a custom loading icon
			},
		}).on('error.dt', function(e, settings, techNote, message) {
			pesan('error', message);
			console.log('Error DataTables: ', message);
		}); //table_pelamar

		var colorbox_params = {
			reposition: true,
			scalePhotos: true,
			scrolling: false,
			//loop: false, //ini disable looping
			rel: 'nofollow', //disable ambil semua foto
			//previous: '<i class="icon-arrow-left"></i>',
			//next: '<i class="icon-arrow-right"></i>',
			previous: '',
			next: '',
			close: '&times;',
			// current: '{current} of {total}',
			current: false,
			maxWidth: '100%',
			maxHeight: '100%',
			onOpen: function() {
				document.body.style.overflow = 'hidden';
			},
			onClosed: function() {
				document.body.style.overflow = 'auto';
			},
			onComplete: function() {
				$.colorbox.resize();
			}
		};		
			
		$('#table_pelamar').on('click', '.btn-foto', function(){
			$('.foto-karyawan [data-rel="colorbox"]').colorbox(colorbox_params);
			$("#cboxLoadingGraphic").append("<i class='icon-spinner orange'></i>"); 
		});

	});
</script>