<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Sparepart</h5>
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
                                <a class="nav-link" data-toggle="tab" href="#tab1">
                                    <p class="card-title m-0" id="title_user">Tambah</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tab2">
                                    <p class="card-title m-0">Hino</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab3">
                                    <p class="card-title m-0">Honda</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab4">
                                    <p class="card-title m-0">Mazda</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab5">
                                    <p class="card-title m-0">Mercedes-Benz</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab6">
                                    <p class="card-title m-0">Wuling</p>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content px-1 pt-1">
                            <div class="tab-pane" id="tab1">
                                <form id="form" class="form">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="offset-md-3 col-md-6">
                                                <div class="form-group mb-1">
                                                    <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama" required>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group mb-1 col-md-6">
                                                        <select id="brand" name="brand" class="form-control" required>
                                                            <option value="" selected disabled>-- Silahkan Pilih Brand --</option>
                                                            <?php foreach ($brand as $v) : ?>
                                                                <option value="<?= $v->id ?>"><?= ucwords($v->jenis) ?></option>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group mb-1 col-md-6">
                                                        <input type="text" id="kategori" name="kategori" class="form-control" placeholder="Kategori" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group mb-1 col-md-6">
                                                        <input type="text" onkeydown="input_number(event)" onkeyup="$(this).val(format_rupiah($(this).val()))" id="harga" name="harga" class="form-control" placeholder="Harga" required>
                                                    </div>
                                                    <div class="form-group mb-1 col-md-6">
                                                        <input type="text" onkeydown="input_number(event)" id="berat" name="berat" class="form-control" placeholder="Berat" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group mb-1 col-md-6">
                                                        <input type="text" id="merek" name="merek" class="form-control" placeholder="Merek" required>
                                                    </div>
                                                    <div class="form-group mb-1 col-md-6">
                                                        <input type="text" id="asal" name="asal" class="form-control" placeholder="Asal" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group mb-1 col-md-6">
                                                        <select id="tahun" name="tahun" class="form-control" required>
                                                            <option value="" selected disabled>-- Silahkan Pilih Tahun --</option>
                                                            <?php for ($i = 2000; $i < 2030; $i++) : ?>
                                                                <option value="<?= $i ?>"><?= $i ?></option>
                                                            <?php endfor ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group mb-1 col-md-6">
                                                        <select id="status" name="status" class="form-control" required>
                                                            <option value="" selected disabled>-- Silahkan Pilih Status --</option>
                                                            <option value="Tersedia">Tersedia</option>
                                                            <option value="Tidak Tersedia">Tidak Tersedia</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="form-group mb-1">
                                                    <textarea id="deskripsi" name="deskripsi" rows="2" class="form-control" placeholder="Deskripsi" required></textarea>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <label for="gambar">Gambar <small class="text-danger">*Maks 1MB</small></label>
                                                    <input type="file" id="gambar" name="gambar" class="form-control-file" required>
                                                </div>
                                                <input type="hidden" id="id" name="id" class="form-control">
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
                            <div class="tab-pane active" id="tab2">
                                <div class="table-responsive">
                                    <table class="table table-sm table_aplikasi">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Kategori</th>
                                                <th>Harga</th>
                                                <th>Berat</th>
                                                <th>Merek</th>
                                                <th>Asal</th>
                                                <th>Tahun</th>
                                                <th>Status</th>
                                                <th>Deskripsi</th>
                                                <th>Gambar</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($hino as $r) : ?>
                                                <tr>
                                                    <td><?= $r->nama ?></td>
                                                    <td><?= $r->kategori ?></td>
                                                    <td><?= separator_harga($r->harga) ?></td>
                                                    <td><?= $r->berat ?></td>
                                                    <td><?= $r->merek ?></td>
                                                    <td><?= $r->asal ?></td>
                                                    <td><?= $r->tahun ?></td>
                                                    <td><?= $r->status ?></td>
                                                    <td><?= $r->deskripsi ?></td>
                                                    <td><img src="<?= $img_server ?>assets/img_marketing/sparepart/<?= $r->gambar ?>" width="200px"></td>
                                                    <td>
                                                        <div class="form-group mb-0">
                                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->nama ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
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
                                                <th>Nama</th>
                                                <th>Kategori</th>
                                                <th>Harga</th>
                                                <th>Berat</th>
                                                <th>Merek</th>
                                                <th>Asal</th>
                                                <th>Tahun</th>
                                                <th>Status</th>
                                                <th>Deskripsi</th>
                                                <th>Gambar</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($honda as $r) : ?>
                                                <tr>
                                                    <td><?= $r->nama ?></td>
                                                    <td><?= $r->kategori ?></td>
                                                    <td><?= separator_harga($r->harga) ?></td>
                                                    <td><?= $r->berat ?></td>
                                                    <td><?= $r->merek ?></td>
                                                    <td><?= $r->asal ?></td>
                                                    <td><?= $r->tahun ?></td>
                                                    <td><?= $r->status ?></td>
                                                    <td><?= $r->deskripsi ?></td>
                                                    <td><img src="<?= $img_server ?>assets/img_marketing/sparepart/<?= $r->gambar ?>" width="200px"></td>
                                                    <td>
                                                        <div class="form-group mb-0">
                                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->nama ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab4">
                                <div class="table-responsive">
                                    <table class="table table-sm table_aplikasi">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Kategori</th>
                                                <th>Harga</th>
                                                <th>Berat</th>
                                                <th>Merek</th>
                                                <th>Asal</th>
                                                <th>Tahun</th>
                                                <th>Status</th>
                                                <th>Deskripsi</th>
                                                <th>Gambar</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($mazda as $r) : ?>
                                                <tr>
                                                    <td><?= $r->nama ?></td>
                                                    <td><?= $r->kategori ?></td>
                                                    <td><?= separator_harga($r->harga) ?></td>
                                                    <td><?= $r->berat ?></td>
                                                    <td><?= $r->merek ?></td>
                                                    <td><?= $r->asal ?></td>
                                                    <td><?= $r->tahun ?></td>
                                                    <td><?= $r->status ?></td>
                                                    <td><?= $r->deskripsi ?></td>
                                                    <td><img src="<?= $img_server ?>assets/img_marketing/sparepart/<?= $r->gambar ?>" width="200px"></td>
                                                    <td>
                                                        <div class="form-group mb-0">
                                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->nama ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab5">
                                <div class="table-responsive">
                                    <table class="table table-sm table_aplikasi">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Kategori</th>
                                                <th>Harga</th>
                                                <th>Berat</th>
                                                <th>Merek</th>
                                                <th>Asal</th>
                                                <th>Tahun</th>
                                                <th>Status</th>
                                                <th>Deskripsi</th>
                                                <th>Gambar</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($mercedes as $r) : ?>
                                                <tr>
                                                    <td><?= $r->nama ?></td>
                                                    <td><?= $r->kategori ?></td>
                                                    <td><?= separator_harga($r->harga) ?></td>
                                                    <td><?= $r->berat ?></td>
                                                    <td><?= $r->merek ?></td>
                                                    <td><?= $r->asal ?></td>
                                                    <td><?= $r->tahun ?></td>
                                                    <td><?= $r->status ?></td>
                                                    <td><?= $r->deskripsi ?></td>
                                                    <td><img src="<?= $img_server ?>assets/img_marketing/sparepart/<?= $r->gambar ?>" width="200px"></td>
                                                    <td>
                                                        <div class="form-group mb-0">
                                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->nama ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab6">
                                <div class="table-responsive">
                                    <table class="table table-sm table_aplikasi">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Kategori</th>
                                                <th>Harga</th>
                                                <th>Berat</th>
                                                <th>Merek</th>
                                                <th>Asal</th>
                                                <th>Tahun</th>
                                                <th>Status</th>
                                                <th>Deskripsi</th>
                                                <th>Gambar</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($wuling as $r) : ?>
                                                <tr>
                                                    <td><?= $r->nama ?></td>
                                                    <td><?= $r->kategori ?></td>
                                                    <td><?= separator_harga($r->harga) ?></td>
                                                    <td><?= $r->berat ?></td>
                                                    <td><?= $r->merek ?></td>
                                                    <td><?= $r->asal ?></td>
                                                    <td><?= $r->tahun ?></td>
                                                    <td><?= $r->status ?></td>
                                                    <td><?= $r->deskripsi ?></td>
                                                    <td><img src="<?= $img_server ?>assets/img_marketing/sparepart/<?= $r->gambar ?>" width="200px"></td>
                                                    <td>
                                                        <div class="form-group mb-0">
                                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->nama ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
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
</section>
<script type="text/javascript">
    $("#nama").keyup(function() {
        $('#submit').removeAttr('disabled');
    });
    $('#submit').click(function(e) {
        var breakout = false;
        e.preventDefault();
        if ($('#form').valid()) {
            var form_data = new FormData();
            form_data.append('simpan', true);
            $.each($('.form-body').find('.form-control'), function() {
                form_data.append($(this).attr('id'), $(this).val());
            });
            if ($('#gambar')[0].files.length != 0) {
                var gambar = $('#gambar')[0].files[0];
                var allowed_types = ["jpg", "jpeg", "png"];
                var ext = gambar.name.split(".").pop().toLowerCase();
                form_data.append('gambar', gambar);
                if ($.inArray(ext, allowed_types) == -1) {
                    swal("", "Silahkan pilih file gambar!", "warning");
                    breakout = true;
                }
                if ($('#gambar')[0].files[0].size / 1048576 > 1) {
                    swal("", "Ukuran file melebihi 1MB!", "warning");
                    breakout = true;
                }
            }
            if (breakout) return false;
            else {
                loading();
                $.ajax({
                    type: 'post',
                    url: location,
                    data: form_data,
                    processData: false,
                    contentType: false,
                    success: function(r) {
                        if (r == 1) swal("", "Data berhasil disimpan!", "success").then(function() {
                            location.reload();
                        });
                        else if (r == 2) swal("", "Data berhasil diupdate!", "success").then(function() {
                            location.reload();
                        });
                        else swal("", "Data gagal disimpan!", "error").then(function() {
                            unload();
                        });
                    }
                });
            }
        }
    });

    function edit_data(id) {
        $('#form').trigger('reset');
        $('#title_user').html("Edit");
        $('#id').val(id);
        $('.nav-tabs a:first').tab('show');
        $('#gambar').removeAttr('required');
        $('#submit').removeAttr('disabled');
        $('#submit').html('<i class="icon-check2"></i> Update');
        $('input').eq(0).focus();
        $.post(location, {
                'edit': true,
                'id': id
            }, function(r) {
                $('#brand').val(r.brand);
                $('#nama').val(r.nama);
                $('#harga').val(r.harga);
                $('#kategori').val(r.kategori);
                $('#berat').val(r.berat);
                $('#merek').val(r.merek);
                $('#asal').val(r.asal);
                $('#tahun').val(r.tahun);
                $('#status').val(r.status);
                $('#deskripsi').val(r.deskripsi);
            },
            "json"
        );
    }

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
                }, function() {
                    swal("", "Data berhasil dihapus!", "success").then(function() {
                        location.reload();
                    });
                });
            }
        });
    }
</script>