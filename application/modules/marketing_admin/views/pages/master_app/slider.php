<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_user">Tambah Slider</h5>
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
                                        <label>Tampilkan di: <small class="text-danger">*Untuk Website</small></label>
                                        <div class="form-group m-0 pl-1">
                                            <fieldset>
                                                <input type="checkbox" class="kategori" name="beranda" value="beranda">
                                                <label> Beranda</label>
                                            </fieldset>
                                            <?php foreach ($brand as $v) : if (!in_array($v->jenis, ['mercedes-benz'])) : ?>
                                                    <fieldset>
                                                        <input type="checkbox" class="kategori" name="<?= $v->jenis ?>" value="<?= $v->jenis ?>">
                                                        <label> <?= ucwords($v->jenis) ?></label>
                                                    </fieldset>
                                            <?php endif;
                                            endforeach ?>
                                        </div>
                                        <div class="form-group mb-1">
                                            <span id="error_kategori" class="error hidden">This field is required.</span>
                                        </div>
                                        <div class="form-group mb-1">
                                            <textarea id="url" name="url" rows="2" class="form-control" placeholder="Link URL" required></textarea>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="gambar">Gambar <small class="text-danger">*Maks 500kB</small></label>
                                            <input type="file" id="gambar" name="gambar" class="form-control-file" required>
                                        </div>
                                        <input type="hidden" id="id" name="id" class="form-control">
                                        <div class="form-actions right">
                                            <a href="" class="btn btn-warning mr-1">
                                                <i class="icon-reload"></i> Reset
                                            </a>
                                            <button id="submit" class="btn btn-primary" disabled>
                                                <i class="icon-check2"></i> Simpan
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#tab2">
                                                    <p class="card-title m-0">Beranda</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#tab3">
                                                    <p class="card-title m-0">Hino</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#tab4">
                                                    <p class="card-title m-0">Honda</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#tab5">
                                                    <p class="card-title m-0">Wuling</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#tab6">
                                                    <p class="card-title m-0">Mazda</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#tab7">
                                                    <p class="card-title m-0">Carimobilku</p>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content px-1 pt-1">
                                            <div class="tab-pane active" id="tab2">
                                                <div class="table-responsive">
                                                    <table class="table table-sm table_aplikasi">
                                                        <thead>
                                                            <tr>
                                                                <th>Link URL</th>
                                                                <th>Gambar</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($beranda as $r) : ?>
                                                                <tr>
                                                                    <td><?= $r->aksi ?></td>
                                                                    <td><a class="btn btn-sm btn-info" target="_blank" href="<?= $img_server ?>assets/img_marketing/slider/<?= $r->gambar ?>">Show image</a></td>
                                                                    <td>
                                                                        <div class="form-group mb-0">
                                                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                                <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                                <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->aksi ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
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
                                                                <th>Link URL</th>
                                                                <th>Gambar</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($hino as $r) : ?>
                                                                <tr>
                                                                    <td><?= $r->aksi ?></td>
                                                                    <td><a class="btn btn-sm btn-info" target="_blank" href="<?= $img_server ?>assets/img_marketing/slider/<?= $r->gambar ?>">Show image</a></td>
                                                                    <td>
                                                                        <div class="form-group mb-0">
                                                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                                <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                                <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->aksi ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
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
                                                                <th>Link URL</th>
                                                                <th>Gambar</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($honda as $r) : ?>
                                                                <tr>
                                                                    <td><?= $r->aksi ?></td>
                                                                    <td><a class="btn btn-sm btn-info" target="_blank" href="<?= $img_server ?>assets/img_marketing/slider/<?= $r->gambar ?>">Show image</a></td>
                                                                    <td>
                                                                        <div class="form-group mb-0">
                                                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                                <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                                <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->aksi ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
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
                                                                <th>Link URL</th>
                                                                <th>Gambar</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($wuling as $r) : ?>
                                                                <tr>
                                                                    <td><?= $r->aksi ?></td>
                                                                    <td><a class="btn btn-sm btn-info" target="_blank" href="<?= $img_server ?>assets/img_marketing/slider/<?= $r->gambar ?>">Show image</a></td>
                                                                    <td>
                                                                        <div class="form-group mb-0">
                                                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                                <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                                <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->aksi ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
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
                                                                <th>Link URL</th>
                                                                <th>Gambar</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($mazda as $r) : ?>
                                                                <tr>
                                                                    <td><?= $r->aksi ?></td>
                                                                    <td><a class="btn btn-sm btn-info" target="_blank" href="<?= $img_server ?>assets/img_marketing/slider/<?= $r->gambar ?>">Show image</a></td>
                                                                    <td>
                                                                        <div class="form-group mb-0">
                                                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                                <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                                <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->aksi ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab7">
                                                <div class="table-responsive">
                                                    <table class="table table-sm table_aplikasi">
                                                        <thead>
                                                            <tr>
                                                                <th>Link URL</th>
                                                                <th>Gambar</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($carimobilku as $r) : ?>
                                                                <tr>
                                                                    <td><?= $r->aksi ?></td>
                                                                    <td><a class="btn btn-sm btn-info" target="_blank" href="<?= $img_server ?>assets/img_marketing/slider/<?= $r->gambar ?>">Show image</a></td>
                                                                    <td>
                                                                        <div class="form-group mb-0">
                                                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                                <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                                <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->aksi ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $("#url").keyup(function() {
        $('#submit').removeAttr('disabled');
    });
    var kategori = [];
    var cek = 0;
    $('.kategori').click(function() {
        if ($(this).is(':checked')) kategori.push($(this).val());
        else {
            var index = kategori.indexOf($(this).val())
            kategori.splice(index, 1);
        }
        if (cek == 1 && kategori.length == 0) $('#error_kategori').removeClass('hidden');
        else $('#error_kategori').addClass('hidden');
    });
    $('#submit').click(function(e) {
        var breakout = false;
        e.preventDefault();
        if (kategori.length == 0) {
            cek = 1;
            $('#error_kategori').removeClass('hidden');
            breakout = true;
        }
        if ($('#form').valid()) {
            var form_data = new FormData();
            form_data.append('simpan', true);
            form_data.append('kategori', kategori.toString());
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
                if ($('#gambar')[0].files[0].size / 1048576 > 0.5) {
                    swal("", "Ukuran file melebihi 500kB!", "warning");
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
                        if (r == 0) swal("", "Data gagal disimpan!", "error").then(function() {
                            unload();
                        });
                        else swal("", r, "success").then(function() {
                            location.reload();
                        });
                    }
                });
            }
        }
    });

    function edit_data(id) {
        $('#form').trigger('reset');
        $('#title_user').html("Edit Slider");
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
                $('#url').val(r.url);
                kategori.length = 0;
                $.each(r.kategori, function(key, v) {
                    kategori.push(v);
                    $('input[value=' + v + ']').prop('checked', true);
                });
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