<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Otomotif</h5>
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
                                    <p class="card-title m-0" id="title_profil">Tambah</p>
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
                                            <div class="col-md-3" id="form_unit">
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
                                                    <input type="text" onkeydown="input_number(event)" onkeyup="$(this).val(format_rupiah($(this).val()))" id="harga" name="harga" class="form-control" placeholder="Harga" required>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <textarea id="deskripsi" name="deskripsi" rows="2" class="form-control" placeholder="Deskripsi" required></textarea>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <label for="gambar">Gambar <small class="text-danger">*Maks 300kB</small></label>
                                                    <input type="file" id="gambar" name="gambar" class="form-control-file" required>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <label for="brosur">Brosur</label>
                                                    <input type="file" id="brosur" name="brosur" class="form-control-file" required>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <textarea id="video" name="video" rows="2" class="form-control" placeholder="Video" required></textarea>
                                                </div>
                                                <input type="hidden" id="id" name="id" class="form-control">
                                            </div>
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h5 class="card-title">Warna</h5>
                                                        <div id="load_warna" class="row"></div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h5 class="card-title">Spesifikasi</h5>
                                                        <div id="detail_spek" class="row">
                                                            <?php $spesifikasi = ["Transmisi", "Bahan Bakar", "Lampu", "Mesin", "Tempat Duduk", "Speed", "Dimensi", "Suspensi", "Torsi"];
                                                            foreach ($spesifikasi as $i => $v) : ?>
                                                                <div class="form-group mb-1 col-md-4 col-sm-6">
                                                                    <input type="hidden" class="form-control id_spek">
                                                                    <input type="hidden" class="form-control nama_spek" value="<?= $spesifikasi[$i] ?>" required>
                                                                    <input type="text" name="s<?= $i ?>" class="form-control spek" placeholder="<?= $spesifikasi[$i] ?>" required>
                                                                </div>
                                                            <?php endforeach ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5 class="card-title">Detail Tambahan</h5>
                                                <div class="form-group mb-1"><button class="btn btn-success btn-sm" id="tambah_detail" disabled>Tambah</button></div>
                                                <div id="detail_tambahan" class="row"></div>
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
                                                <th>Tampilkan di Digifest</th>
                                                <th>Model</th>
                                                <th>Harga</th>
                                                <th>Gambar</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($hino)) foreach ($hino as $v) : ?>
                                                <tr>
                                                    <td><input type="checkbox" name="is_live" class="is_digifest" data-id="<?= $v['id'] ?>" <?= $v['is_digifest'] == 0 ? '' : 'checked' ?>></td>
                                                    <td><?= $v['_model'] ?></td>
                                                    <td><?= separator_harga($v['harga']) ?></td>
                                                    <td><a href="<?= $img_server ?>assets/img_marketing/otomotif/<?= $v['gambar'] ?>" class="btn btn-small btn-info" target="_blank">View Image</a></td>
                                                    <td>
                                                        <div class="form-group mb-0">
                                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                <button type="button" onclick="edit_data(<?= $v['id'] ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                <button type="button" onclick="hapus_data(<?= $v['id'] ?>,'<?= $v['_model'] ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
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
                                                <th>Tampilkan di Digifest</th>
                                                <th>Model</th>
                                                <th>Harga</th>
                                                <th>Gambar</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($honda)) foreach ($honda as $v) : ?>
                                                <tr>
                                                    <td><input type="checkbox" name="is_live" class="is_digifest" data-id="<?= $v['id'] ?>" <?= $v['is_digifest'] == 0 ? '' : 'checked' ?>></td>
                                                    <td><?= $v['_model'] ?></td>
                                                    <td><?= separator_harga($v['harga']) ?></td>
                                                    <td><a href="<?= $img_server ?>assets/img_marketing/otomotif/<?= $v['gambar'] ?>" class="btn btn-small btn-info" target="_blank">View Image</a></td>
                                                    <td>
                                                        <div class="form-group mb-0">
                                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                <button type="button" onclick="edit_data(<?= $v['id'] ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                <button type="button" onclick="hapus_data(<?= $v['id'] ?>,'<?= $v['_model'] ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
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
                                                <th>Tampilkan di Digifest</th>
                                                <th>Model</th>
                                                <th>Harga</th>
                                                <th>Gambar</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($mazda)) foreach ($mazda as $v) : ?>
                                                <tr>
                                                    <td><input type="checkbox" name="is_live" class="is_digifest" data-id="<?= $v['id'] ?>" <?= $v['is_digifest'] == 0 ? '' : 'checked' ?>></td>
                                                    <td><?= $v['_model'] ?></td>
                                                    <td><?= separator_harga($v['harga']) ?></td>
                                                    <td><a href="<?= $img_server ?>assets/img_marketing/otomotif/<?= $v['gambar'] ?>" class="btn btn-small btn-info" target="_blank">View Image</a></td>
                                                    <td>
                                                        <div class="form-group mb-0">
                                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                <button type="button" onclick="edit_data(<?= $v['id'] ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                <button type="button" onclick="hapus_data(<?= $v['id'] ?>,'<?= $v['_model'] ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
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
                                                <th>Tampilkan di Digifest</th>
                                                <th>Model</th>
                                                <th>Harga</th>
                                                <th>Gambar</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($mercedes)) foreach ($mercedes as $v) : ?>
                                                <tr>
                                                    <td><input type="checkbox" name="is_live" class="is_digifest" data-id="<?= $v['id'] ?>" <?= $v['is_digifest'] == 0 ? '' : 'checked' ?>></td>
                                                    <td><?= $v['_model'] ?></td>
                                                    <td><?= separator_harga($v['harga']) ?></td>
                                                    <td><a href="<?= $img_server ?>assets/img_marketing/otomotif/<?= $v['gambar'] ?>" class="btn btn-small btn-info" target="_blank">View Image</a></td>
                                                    <td>
                                                        <div class="form-group mb-0">
                                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                <button type="button" onclick="edit_data(<?= $v['id'] ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                <button type="button" onclick="hapus_data(<?= $v['id'] ?>,'<?= $v['_model'] ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
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
                                                <th>Tampilkan di Digifest</th>
                                                <th>Model</th>
                                                <th>Harga</th>
                                                <th>Gambar</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($wuling)) foreach ($wuling as $v) : ?>
                                                <tr>
                                                    <td><input type="checkbox" name="is_live" class="is_digifest" data-id="<?= $v['id'] ?>" <?= $v['is_digifest'] == 0 ? '' : 'checked' ?>></td>
                                                    <td><?= $v['_model'] ?></td>
                                                    <td><?= separator_harga($v['harga']) ?></td>
                                                    <td><a href="<?= $img_server ?>assets/img_marketing/otomotif/<?= $v['gambar'] ?>" class="btn btn-small btn-info" target="_blank">View Image</a></td>
                                                    <td>
                                                        <div class="form-group mb-0">
                                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                <button type="button" onclick="edit_data(<?= $v['id'] ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                <button type="button" onclick="hapus_data(<?= $v['id'] ?>,'<?= $v['_model'] ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
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
    var i = 1;
    $('#tambah_detail').click(function(e) {
        e.preventDefault();
        if (i <= 8) {
            html = '<div class="col-md-3 col-sm-6"><div class="form-group mb-1"><input type="text" name="j' + i + '" class="form-control nama_detail" placeholder="Judul" required></div><div class="form-group mb-1"><textarea rows="2" name="d' + i + '" class="form-control deskripsi_detail" placeholder="Deskripsi" required></textarea></div><div class="form-group mb-1"><label>Gambar <small class="text-danger">*Maks 300kB</small></label><input type="file" name="g' + i + '" class="form-control-file gambar_detail" required></div><input type="hidden" class="id_detail"><div class="form-actions m-0 right"><button class="btn btn-danger btn-sm hapus_detail">Hapus</button></div></div>';
            $('#detail_tambahan').append(html);
        } else i = 8;
        i++;
    });
    $('#detail_tambahan').on('click', '.hapus_detail', function(e) {
        e.preventDefault();
        var id_detail = $(this).closest('.col-md-3').find('.id_detail').val();
        if (id_detail.length != 0) $.post(location, {
            'hapus_detail': true,
            'id': id_detail
        }, function() {
            swal("", "Data berhasil dihapus!", "success");
        });
        $(this).closest('.col-md-3').remove();
        i--;
    });
    $('#model').change(function() {
        $('#submit').removeAttr('disabled');
        $('#tambah_detail').removeAttr('disabled');
    });
    var form = $('#form');
    $('#submit').click(function(e) {
        var breakout = false;
        e.preventDefault();
        if ($('#form').valid()) {
            var form_data = new FormData();
            form_data.append('simpan', true);
            $.each($('#form_unit').find('.form-control'), function() {
                if ($(this).attr('id') == "video")
                    if ($(this).val().includes("youtu") == false) {
                        swal("", "Masukkan link Video dari Youtube!", "warning");
                        breakout = true;
                        return false;
                    }
                form_data.append($(this).attr('id'), $(this).val());
            });
            if ($('#gambar')[0].files.length != 0) {
                var gambar_tipe = ["jpg", "jpeg", "png"];
                var ext = $('#gambar')[0].files[0].name.split(".").pop().toLowerCase();
                if ($.inArray(ext, gambar_tipe) == -1) {
                    swal("", "File " + $('#gambar')[0].files[0].name + " - Silahkan pilih file gambar!", "warning");
                    breakout = true;
                }
                if ($('#gambar')[0].files[0].size / 1048576 > 0.3) {
                    swal("", "File " + $('#gambar')[0].files[0].name + " - Ukuran file melebihi 300kB!", "warning");
                    breakout = true;
                }
                form_data.append('gambar', $('#gambar')[0].files[0]);
            }
            if ($('#brosur')[0].files.length != 0) {
                var brosur_tipe = ["pdf", "jpg", "jpeg", "png"];
                var ext = $('#brosur')[0].files[0].name.split(".").pop().toLowerCase();
                if ($.inArray(ext, brosur_tipe) == -1) {
                    swal("", "File " + $('#brosur')[0].files[0].name + " - Silahkan pilih file gambar/pdf!", "warning");
                    breakout = true;
                }
                form_data.append('brosur', $('#brosur')[0].files[0]);
            }
            $.each(form.find('.gambar_warna'), function(key) {
                if ($(this)[0].files.length != 0) {
                    var img_warna = ["jpg", "jpeg", "png"];
                    var ext = $(this)[0].files[0].name.split(".").pop().toLowerCase();
                    if ($.inArray(ext, img_warna) == -1) {
                        swal("", "File " + $(this)[0].files[0].name + " - Silahkan pilih file gambar!", "warning");
                        breakout = true;
                        return false;
                    }
                    if ($(this)[0].files[0].size / 1048576 > 0.3) {
                        swal("", "File " + $(this)[0].files[0].name + " - Ukuran file melebihi 300kB!", "warning");
                        breakout = true;
                        return false;
                    }
                    form_data.append('gambar_warna[]', $(this)[0].files[0]);
                    form_data.append('i_warna[]', key);
                }
                var hex_warna = $(this).closest('.col-md-4').find('.hex_warna').val();
                var id_warna = $(this).closest('.col-md-4').find('.id_warna').val();
                form_data.append('id_warna[]', id_warna);
                form_data.append('hex_warna[]', hex_warna);
            });
            $.each(form.find('.spek'), function() {
                var id_spek = $(this).closest('div').find('.id_spek').val();
                var nama_spek = $(this).closest('div').find('.nama_spek').val();
                form_data.append('id_spek[]', id_spek);
                form_data.append('nama_spek[]', nama_spek);
                form_data.append('spesifikasi[]', $(this).val());
            });
            $.each(form.find('.gambar_detail'), function(key) {
                if ($(this)[0].files.length != 0) {
                    var img_detail = ["jpg", "jpeg", "png"];
                    var ext = $(this)[0].files[0].name.split(".").pop().toLowerCase();
                    if ($.inArray(ext, img_detail) == -1) {
                        swal("", "File " + $(this)[0].files[0].name + " - Silahkan pilih file gambar!", "warning");
                        breakout = true;
                        return false;
                    }
                    if ($(this)[0].files[0].size / 1048576 > 0.3) {
                        swal("", "File " + $(this)[0].files[0].name + " - Ukuran file melebihi 300kB!", "warning");
                        breakout = true;
                        return false;
                    }
                    form_data.append('gambar_detail[]', $(this)[0].files[0]);
                    form_data.append('i_detail[]', key);
                }
                var id_detail = $(this).closest('.col-md-3').find('.id_detail').val();
                var nama_detail = $(this).closest('.col-md-3').find('.nama_detail').val();
                var deskripsi_detail = $(this).closest('.col-md-3').find('.deskripsi_detail').val();
                form_data.append('id_detail[]', id_detail);
                form_data.append('nama_detail[]', nama_detail);
                form_data.append('deskripsi_detail[]', deskripsi_detail);
            });
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
                        else if (r == 3) swal("", "Brosur gagal diupload, silahkan diupdate kembali!", "warning").then(function() {
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
    $('#brand').change(function() {
        $.post("<?= base_url() ?>aplikasi/model", {
            'load': true,
            'brand': $(this).val()
        }, function(r) {
            $('#model').html(r);
            $('#model').change(function() {
                $.post(location, {
                    'load_warna': true,
                    'model': $(this).val()
                }, function(s) {
                    $('#load_warna').html(s);
                });
            });
        });
    });

    function edit_data(id) {
        $('#form').trigger('reset');
        $('#title_profil').html("Edit");
        $('#id').val(id);
        $('.nav-tabs a:first').tab('show');
        $('#brand').prop('disabled', true);
        $('#gambar').removeAttr('required');
        $('#brosur').removeAttr('required');
        $('#tambah_detail').removeAttr('disabled');
        $('#submit').removeAttr('disabled');
        $('#submit').html('<i class="icon-check2"></i> Update');
        $('input').eq(0).focus();
        $('#detail_spek').children().remove();
        $('#detail_tambahan').children().remove();
        $.post(location, {
            'edit': true,
            'id': id
        }, function(r) {
            $.post("<?= base_url() ?>aplikasi/model", {
                'load': true,
                'brand': r.brand
            }, function(s) {
                $('#model').html(s);
                $('#model').val(r.model);
                $.post(location, {
                    'load_warna': true,
                    'id': id,
                    'model': r.model
                }, function(s) {
                    $('#model').prop('disabled', true);
                    $('#load_warna').html(s);
                    $.each(form.find('.gambar_warna'), function() {
                        $(this).removeAttr('required');
                    });
                });
            });
            $.each(r.spek, function(key, v) {
                html = '<div class="form-group mb-1 col-md-4"><input type="hidden" class="form-control id_spek" value="' + v.id + '"><input type="hidden" class="form-control nama_spek" value="' + v.nama_detail + '" required><input type="text" name="s' + key + '" class="form-control spek" placeholder="' + v.nama_detail + '" value="' + v.deskripsi + '" required></div>';
                $('#detail_spek').append(html);
            });
            i = 1;
            $.each(r.detail, function(key, v) {
                html = '<div class="col-md-3 col-sm-6"><div class="form-group mb-1"><input type="text" name="j' + i + '" class="form-control nama_detail" value="' + v.nama_detail + '" placeholder="Judul" required></div><div class="form-group mb-1"><textarea rows="2" name="d' + i + '" class="form-control deskripsi_detail" placeholder="Deskripsi" required>' + v.deskripsi + '</textarea></div><div class="form-group mb-1"><label>Gambar <small class="text-danger">*Maks 300kB</small></label><input type="file" name="g' + i + '" class="form-control-file gambar_detail"></div><input type="hidden" class="id_detail" value="' + v.id + '"><div class="form-actions m-0 right"><button class="btn btn-danger btn-sm hapus_detail">Hapus</button></div></div>';
                $('#detail_tambahan').append(html);
                i++;
            });
            $('#brand').val(r.brand);
            $('#harga').val(r.harga);
            $('#deskripsi').val(r.deskripsi);
            $('#video').val(r.video);
        }, "json");
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

    $('.is_digifest').click(async function() {
        var ini = $(this)
        var id = ini.data('id')
        var value = ini.is(':checked') ? 1 : 0
        ini.attr('disabled', true)
        var response = await $.post(location, {
            digifest: true,
            id: id,
            value: value
        })
        ini.attr('disabled', false)
        if (response.status == 'error') {
            ini.is(':checked') ?
                ini.prop('checked', false) :
                ini.prop('checked', true)
        }
    })
</script>