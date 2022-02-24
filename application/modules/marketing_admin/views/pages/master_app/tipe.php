<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_profil">Tambah Tipe</h5>
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
                                            <select id="brand" name="brand" class="form-control" required>
                                                <option value="" selected disabled>-- Silahkan Pilih Brand --</option>
                                                <?php foreach ($brand as $v) : ?>
                                                    <option value="<?= $v->id ?>"><?= ucwords($v->jenis) ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="form-group mb-1">
                                            <select id="model" name="model" class="form-control" required>
                                                <option value="" selected disabled>-- Silahkan Pilih Model --</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-1">
                                            <input type="text" id="tipe" name="tipe" class="form-control" placeholder="Tipe" required>
                                        </div>
                                        <input type="hidden" id="id" name="id">
                                        <input type="hidden" name="simpan" value="true">
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
                                            <div class="tab-pane active" id="tab2">
                                                <div class="table-responsive">
                                                    <table class="table table-sm table_aplikasi">
                                                        <thead>
                                                            <tr>
                                                                <th>Model</th>
                                                                <th>Tipe</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($hino)) foreach ($hino as $v) : ?>
                                                                <tr>
                                                                    <td><?= $v['_model'] ?></td>
                                                                    <td><?= $v['nama_tipe'] ?></td>
                                                                    <td>
                                                                        <div class="form-group mb-0">
                                                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                                <button type="button" onclick="edit_data(<?= $v['id'] ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                                <button type="button" onclick="hapus_data(<?= $v['id'] ?>,'<?= $v['nama_tipe'] ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
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
                                                                <th>Model</th>
                                                                <th>Tipe</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($honda)) foreach ($honda as $v) : ?>
                                                                <tr>
                                                                    <td><?= $v['_model'] ?></td>
                                                                    <td><?= $v['nama_tipe'] ?></td>
                                                                    <td>
                                                                        <div class="form-group mb-0">
                                                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                                <button type="button" onclick="edit_data(<?= $v['id'] ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                                <button type="button" onclick="hapus_data(<?= $v['id'] ?>,'<?= $v['nama_tipe'] ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
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
                                                                <th>Model</th>
                                                                <th>Tipe</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($mazda)) foreach ($mazda as $v) : ?>
                                                                <tr>
                                                                    <td><?= $v['_model'] ?></td>
                                                                    <td><?= $v['nama_tipe'] ?></td>
                                                                    <td>
                                                                        <div class="form-group mb-0">
                                                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                                <button type="button" onclick="edit_data(<?= $v['id'] ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                                <button type="button" onclick="hapus_data(<?= $v['id'] ?>,'<?= $v['nama_tipe'] ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
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
                                                                <th>Model</th>
                                                                <th>Tipe</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($mercedes)) foreach ($mercedes as $v) : ?>
                                                                <tr>
                                                                    <td><?= $v['_model'] ?></td>
                                                                    <td><?= $v['nama_tipe'] ?></td>
                                                                    <td>
                                                                        <div class="form-group mb-0">
                                                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                                <button type="button" onclick="edit_data(<?= $v['id'] ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                                <button type="button" onclick="hapus_data(<?= $v['id'] ?>,'<?= $v['nama_tipe'] ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
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
                                                                <th>Model</th>
                                                                <th>Tipe</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($wuling)) foreach ($wuling as $v) : ?>
                                                                <tr>
                                                                    <td><?= $v['_model'] ?></td>
                                                                    <td><?= $v['nama_tipe'] ?></td>
                                                                    <td>
                                                                        <div class="form-group mb-0">
                                                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                                <button type="button" onclick="edit_data(<?= $v['id'] ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                                <button type="button" onclick="hapus_data(<?= $v['id'] ?>,'<?= $v['nama_tipe'] ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
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
<script>
    $("#tipe").keyup(function() {
        $('#submit').removeAttr('disabled');
    });
    var form = $('#form');
    $('#submit').click(function(e) {
        e.preventDefault();
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
                else swal("", "Data gagal disimpan!", "error").then(function() {
                    unload();
                });
            });
        }
    });
    $('#brand').change(function() {
        $.post("<?= base_url() ?>aplikasi/model", {
            'load': true,
            'brand': $(this).val()
        }, function(r) {
            $('#model').html(r);
        });
    });

    function edit_data(id) {
        $('#form').trigger('reset');
        $('#title_profil').html("Edit Tipe");
        $('#id').val(id);
        $('#submit').removeAttr('disabled');
        $('#submit').html('<i class="icon-check2"></i> Update');
        $('input').eq(0).focus();
        $.post(location, {
                'edit': true,
                'id': id
            }, function(r) {
                $('#brand').val(r.brand);
                $('#tipe').val(r.tipe);
                $.post("<?= base_url() ?>aplikasi/model", {
                    'load': true,
                    'brand': r.brand
                }, function(s) {
                    $('#model').html(s);
                    $('#model').val(r.model);
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