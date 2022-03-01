<section id="basic-form-layouts">
	<div class="row match-height">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h5 class="card-title">User</h5>
					<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
					<div class="heading-elements">
						<ul class="list-inline mb-0">
							<li><a data-action="expand"><i class="icon-expand2"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="card-body collapse in">
					<div class="card-block pt-1">
						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#tab1">
									<p class="card-title m-0" id="title_user">Tambah</p>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#tab2">
									<p class="card-title m-0">Aktif</p>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#tab3">
									<p class="card-title m-0">Non Aktif</p>
								</a>
							</li>
						</ul>
						<div class="tab-content px-1 pt-1">
							<div class="tab-pane active" id="tab1">
								<form id="form" class="form">
									<div class="form-body">
										<div class="row">
											<div class="col-md-3">
												<div class="form-group mb-1">
													<input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" autocomplete="off">
												</div>
												<div class="form-group mb-1">
													<input type="text" id="nik" name="nik" onkeydown="input_number(event)" class="form-control" placeholder="NIK" required>
												</div>
												<div class="form-group mb-1">
													<input type="text" id="username" name="username" class="form-control" placeholder="Username" autocomplete="off" readonly>
												</div>
												<!-- <div class="form-group mb-1">
													<select id="level" name="level" class="form-control" required>
														<option value="" selected disabled>-- Silahkan Pilih Profil --</option>
														<?php foreach ($level as $v) : ?>
															<option value="<?= $v->id ?>"><?= $v->nama_level ?></option>
														<?php endforeach ?>
													</select>
												</div> -->
												<div class="form-group mb-1">
													<input type="password" id="password" name="password" class="form-control" placeholder="Password" required autocomplete="off" readonly>
												</div>
												<!-- <div class="form-group mb-1">
													<input type="password" id="r_password" name="r_password" class="form-control" placeholder="Ulangi Password" required autocomplete="off">
												</div> -->
												<input type="hidden" id="coverage" name="coverage">
												<input type="hidden" id="akses_menu" name="akses_menu">
												<input type="hidden" id="id" name="id">
												<input type="hidden" name="simpan" value="true">
											</div>											
											<div class="col-md-9">
												<h5 class="card-title" style="text-align: center;">Hak Akses Menu</h5>												
												<div class="row-fluid" id="load_menu_akses"></div>
											</div>
										</div>																		
									</div>
									<div class="form-actions center">
										<a href="" class="btn btn-warning mr-1">
											<i class="icon-reload"></i> Reset
										</a>
										<button id="submit" class="btn btn-primary" disabled>
											<i class="icon-check2"></i> Simpan
										</button>
									</div>
								</form>
							</div>
							<div class="tab-pane" id="tab2">
								<!-- <div class="table-responsive"> -->
									<!-- <table class="table table-sm table_aplikasi" id="table_user_aktif"> -->
									<table id="table_user_aktif" class="table stripe hover table-bordered nowrap">	
										<!-- <thead>
											<tr>
												<th>Status</th>
												<th>NIK</th>
												<th>Username</th>
												<th>Profil</th>
												<th>Nama</th>
												<th>Jabatan</th>
												<th>Perusahaan</th>
												<th>Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php if (!empty($on)) foreach ($on as $r) : ?>
												<tr>
													<td>
														<?php if ($r['nama_level'] == "IT Kumala" && $this->session->userdata('level') == 2) {
														} else { ?>
															<div class="form-group mb-0">
																<input type="checkbox" class="form-control" onclick="update_status(<?= $r['id'] ?>, $(this).val())" <?= $r['status_aktif'] == "on" ? 'value="off" checked' : 'value="on"' ?>>
															</div>
														<?php  } ?>
													</td>
													<td><?= $r['nik'] ?></td>
													<td><?= $r['username'] ?></td>
													<td><?= $r['nama_level'] ?></td>
													<td><?= $r['nama_lengkap'] ?></td>
													<td><?= $r['nama_jabatan'] ?></td>
													<td><?= $r['perusahaan'] ?></td>
													<td>
														<div class="form-group mb-0">
															<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
																<?php if ($r['nama_level'] == "IT Kumala" && $this->session->userdata('level') == 2) {
																} else { ?>
																	<button type="button" onclick="edit_data(<?= $r['id'] ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
																<?php  }
																if ($this->session->userdata('level') == 1) : ?>
																	<button type="button" onclick="hapus_data(<?= $r['id'] ?>,'<?= $r['username'] ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
																<?php endif ?>
															</div>
														</div>
													</td>
												</tr>
											<?php endforeach ?>
										</tbody> -->
									</table>
								<!-- </div> -->
							</div>
							<div class="tab-pane" id="tab3">
								<!-- <div class="table-responsive"> -->
									<!-- <table class="table table-sm table_aplikasi" id="table_user_tidak_aktif"> -->
									<table id="table_user_tidak_aktif" class="table stripe hover table-bordered nowrap">	
										<!-- <thead>
											<tr>
												<th>Status</th>
												<th>NIK</th>
												<th>Username</th>
												<th>Profil</th>
												<th>Nama</th>
												<th>Jabatan</th>
												<th>Perusahaan</th>
												<th>Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php if (!empty($off)) foreach ($off as $r) : ?>
												<tr>
													<td>
														<?php if ($r['nama_level'] == "IT Kumala" && $this->session->userdata('level') == 2) {
														} else { ?>
															<div class="form-group mb-0">
																<input type="checkbox" class="form-control" onclick="update_status(<?= $r['id'] ?>, $(this).val())" <?= $r['status_aktif'] == "on" ? 'value="off" checked' : 'value="on"' ?>>
															</div>
														<?php  } ?>
													</td>
													<td><?= $r['nik'] ?></td>
													<td><?= $r['username'] ?></td>
													<td><?= $r['nama_level'] ?></td>
													<td><?= $r['nama_lengkap'] ?></td>
													<td><?= $r['nama_jabatan'] ?></td>
													<td><?= $r['perusahaan'] ?></td>
													<td>
														<div class="form-group mb-0">
															<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
																<?php if ($r['nama_level'] == "IT Kumala" && $this->session->userdata('level') == 2) {
																} else { ?>
																	<button type="button" onclick="edit_data(<?= $r['id'] ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
																<?php  }
																if ($this->session->userdata('level') == 1) : ?>
																	<button type="button" onclick="hapus_data(<?= $r['id'] ?>,'<?= $r['username'] ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
																<?php endif ?>
															</div>
														</div>
													</td>
												</tr>
											<?php endforeach ?>
										</tbody> -->
									</table>
								<!-- </div> -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<script type="text/javascript">

	var coverage = [];
	$('.coverage').click(function() {
		if ($(this).is(':checked')) coverage.push($(this).val());
		else {
			var index = coverage.indexOf($(this).val())
			coverage.splice(index, 1);
		}
	});
	var val = [];
	$.post(location, {
		'load': true,
		'akses': null
	}, function(r) {
		$('#load_menu_akses').html(r);
		load_tree($('#m_a'));
		load_tree($('#m_s'));
		load_tree($('#d_l'));
		change_tree();
	});

	$("#nama_lengkap").keyup(function() {
		$('#submit').removeAttr('disabled');
		generate_username();
	});
	$("#nik").keyup(function() {
		$('#submit').removeAttr('disabled');
		generate_username();
	});
	// $("#username").keyup(function() {
	// 	$('#submit').removeAttr('disabled');
	// 	//var nik = $("#nik").val();
	// 	//$("#username").val(nik);
	// });
	var form = $('#form');
	$('#submit').click(function(e) {
		e.preventDefault();
		var password = $('#password').val();
		//var r_password = $('#r_password').val();
		//if (password == r_password) {
		if (password != '') {
			$('#coverage').val(coverage.toString());
			$('#akses_menu').val(val.toString());
			var data = form.serialize();
			if (form.valid()) {
				loading();
				$.post(location, data, function(r) {
					if (r == 1) swal("", "Data berhasil disimpan!", "success").then(function() {
						location.reload();
					});
					else if (r == 2) swal("", "Data berhasil diupdate!", "success").then(function() {
						location.reload();
					});
					else if (r == 3) swal("", "NIK sudah terdaftar!", "warning").then(function() {
						unload();
					});
					else swal("", "Data gagal disimpan!", "error").then(function() {
						unload();
					});
				});
			}
		} else swal("", "Password tidak boleh kosong!", "error");
	});

	function update_status(id, status) {
		$.post(location, {
			'update': true,
			'id': id,
			'status': status
		}, function() {
			swal("", "Data berhasil diupdate!", "success").then(function() {
				location.reload();
			});
		});
	}

	function edit_data(id) {
		$('#form').trigger('reset');
		$('#title_user').html("Edit");
		$('#id').val(id);
		$('.nav-tabs a:first').tab('show');
		$('#password').removeAttr('required');
		$('#r_password').removeAttr('required');
		$('#submit').removeAttr('disabled');
		$('#submit').html('<i class="icon-check2"></i> Update');
		$('input').eq(0).focus();
		$.post(location, {
				'edit': true,
				'id': id
			},
			function(r) {
				$('#nik').val(r.nik);
				$("#username").val(r.nik);
				$('#level').val(r.level);
				if (r.coverage != null) {
					coverage.length = 0;
					$.each(r.coverage, function(key, v) {
						coverage.push(v);
						$('input[value=' + v + ']').prop('checked', true);
					});
				}
				$.post(location, {
					'load': true,
					'akses': r.menu_akses
				}, function(r) {
					$('#load_menu_akses').html(r);
					load_tree($('#m_a'));
					load_tree($('#m_s'));
					load_tree($('#d_l'));
					change_tree();
					open_tree($('#m_a'));
					open_tree($('#m_s'));
					open_tree($('#d_l'));
				});
			}, "json"
		);
	}

	function hapus_data(id, data) {
		swal({
			title: "Apakah anda yakin?",
			text: "Anda akan menghapus user " + data + "!",
			icon: "warning",
			buttons: true
		}).then((ok) => {
			if (ok) {
				$.post(location, {
					'hapus': true,
					'id': id
				}, function() {
					swal("", "User berhasil dihapus!", "success").then(function() {
						//location.reload();
						table_user_aktif.ajax.reload(null,false);
						table_user_tidak_aktif.ajax.reload(null,false);
					});
				});
			}
		});
	}

	function load_tree(tree) {
		tree.jstree({
			"checkbox": {
				"keep_selected_style": false
			},
			"plugins": ["checkbox"],
			"core": {
				"themes": {
					"icons": false
				}
			}
		});
	}

	function change_tree() {
		$('#m_a').on('changed.jstree', function(e, data) {
			nodesOnSelectedPath = [...data.selected.reduce(function(acc, nodeId) {
				var node = data.instance.get_node(nodeId);
				return new Set([...acc, ...node.parents, node.id]);
			}, new Set)];
			val[0] = nodesOnSelectedPath.join(',');
		});
		$('#m_s').on('changed.jstree', function(e, data) {
			nodesOnSelectedPath = [...data.selected.reduce(function(acc, nodeId) {
				var node = data.instance.get_node(nodeId);
				return new Set([...acc, ...node.parents, node.id]);
			}, new Set)];
			val[1] = nodesOnSelectedPath.join(',');
		});
		$('#d_l').on('changed.jstree', function(e, data) {
			nodesOnSelectedPath = [...data.selected.reduce(function(acc, nodeId) {
				var node = data.instance.get_node(nodeId);
				return new Set([...acc, ...node.parents, node.id]);
			}, new Set)];
			val[2] = nodesOnSelectedPath.join(',');
		});
	}

	function open_tree(tree) {
		tree.jstree(true).open_all();
		$('li[data-checkstate="checked"]').each(function() {
			tree.jstree('check_node', $(this));
		});
		tree.jstree(true).close_all();
	}

	function generate_username($element)
	{
		let nama_lengkap = $("#nama_lengkap").val(),
			suku_kata = nama_lengkap.split(" "),
			nik = $('#nik').val(),
			username = '';
		if (nama_lengkap != '') {
			switch(suku_kata.length) {
				case 1:
					//alert('satu');
					// while (username.length < 3) {
  					// 	username += nama_lengkap[Math.floor(Math.random() * nama_lengkap.length)];
					// } 	
					//for (var i = 0; i < 5; i++) 
    				//	text += nama_lengkap.charAt(Math.floor(Math.random() * nama_lengkap.length));
					username = nama_lengkap.substring(0, 3);
					break;
				case 2:
					username = suku_kata[0].substring(0, 1) + suku_kata[1].substring(0, 2);					
					break;
				case 3:
					username = suku_kata[0].substring(0, 1) + suku_kata[1].substring(0, 1) + suku_kata[2].substring(0, 1);					
					break;
				default:
					username = 'wrong';
					break;
			}
		}
		$("#username").val(username+nik);
		//$(element).val(username+nik);
		//console.log(username+nik);
		//return userna
	}

	function generate_password()
	{
		let karakter = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ",
		 	panjang_password = 8,
			password = "";
		for (var i = 0; i <= panjang_password; i++) {
			var randomNumber = Math.floor(Math.random() * karakter.length);
			password += karakter.substring(randomNumber, randomNumber +1);
		}
		$("#password").val(password);
	}

	$(document).ready(function() {
		//datatable10
		$.fn.dataTable.ext.errMode = 'none';
		table_user_aktif = $("#table_user_aktif").DataTable({
			serverSide: true,
			processing: true,
			destroy: true,
			order: [],
			autoWidth: false,
			pagingType: 'simple', 
			ajax: {
				type: "POST",
				url: "<?= site_url('konfigurasi_user/get_user_aktif') ?>",				
			},
			language: {
				"processing": "Memproses, silahkan tunggu...",
				"emptyTable": "Data masih kosong..."
			},
			columns: [
				{
					data: "nik",
					title: "NIK",	
					className: "dt-head-center",
				},
				{
					data: "username",
					title: "Username",
					className: "dt-head-center",	
				},
				{
					data: "nama_lengkap",
					title: "Nama Lengkap",
					className: "dt-head-center",
				},						
				{
					data: "id",
					title: "Aksi",
					className: "dt-body-center",
					width: "70px",
					orderable: false,
					render: function ( data, type, row, meta ) {						
						let html = '';
						html = `<button type="button" onclick="edit_data('${data}');" class="btn btn-sm btn-info"><i class="icon-ios-compose"></i></button>
								<button type="button" onclick="hapus_data('${data}','${row.username}');" class="btn btn-sm btn-danger"><i class="icon-trash2"></i></button>`;						
						// return `<span style="text-align:center"><button type="button" onclick="hapus_data('${data}','${row.nama}');" class="btn btn-sm btn-danger"><i class="icon-trash2"></i></button></span>`;
						return html;
					},
				},				
			],				
			initComplete: function(settings, json) {			
				$("#table_user_aktif").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
				

				$("#cboxLoadingGraphic").append("<i class='icon-spinner orange'></i>"); //let's add a custom loading icon
			},
		}).on('error.dt', function(e, settings, techNote, message) {
			pesan('error', message);
			console.log('Error DataTables: ', message);
		}); //table_user_aktif	
		table_user_tidak_aktif = $("#table_user_tidak_aktif").DataTable({
			serverSide: true,
			processing: true,
			destroy: true,
			order: [],
			autoWidth: false,
			pagingType: 'simple', 
			ajax: {
				type: "POST",
				url: "<?= site_url('konfigurasi_user/get_user_non_aktif') ?>",				
			},
			language: {
				"processing": "Memproses, silahkan tunggu...",
				"emptyTable": "Data masih kosong..."
			},
			columns: [
				{
					data: "nik",
					title: "NIK",	
					className: "dt-head-center",
				},
				{
					data: "username",
					title: "Username",
					className: "dt-head-center",	
				},
				{
					data: "nama_lengkap",
					title: "Nama Lengkap",
					className: "dt-head-center",
				},						
				{
					data: "id",
					title: "Aksi",
					className: "dt-body-center",
					width: "70px",
					orderable: false,
					render: function ( data, type, row, meta ) {						
						let html = '';
						html = `<button type="button" onclick="edit_data('${data}');" class="btn btn-sm btn-info"><i class="icon-ios-compose"></i></button>
								<button type="button" onclick="hapus_data('${data}','${row.username}');" class="btn btn-sm btn-danger"><i class="icon-trash2"></i></button>`;						
						// return `<span style="text-align:center"><button type="button" onclick="hapus_data('${data}','${row.nama}');" class="btn btn-sm btn-danger"><i class="icon-trash2"></i></button></span>`;
						return html;
					},
				},				
			],				
			initComplete: function(settings, json) {			
				$("#table_user_tidak_aktif").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
				

				$("#cboxLoadingGraphic").append("<i class='icon-spinner orange'></i>"); //let's add a custom loading icon
			},
		}).on('error.dt', function(e, settings, techNote, message) {
			pesan('error', message);
			console.log('Error DataTables: ', message);
		}); //table_user_tidak_aktif	
	});

</script>