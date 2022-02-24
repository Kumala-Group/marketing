<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Acara</h5>
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
                                    <p class="card-title m-0">List</p>
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
                                                    <input type="text" id="judul" name="judul" class="form-control" placeholder="Judul" required>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group mb-1 col-md-6">
                                                        <input type="text" id="tanggal" name="tanggal" class="form-control" placeholder="Tanggal" autocomplete="off" required>
                                                    </div>
                                                    <div class="form-group mb-1 col-md-6">
                                                        <input type="time" id="waktu" name="waktu" class="form-control" placeholder="Waktu" required style="padding: 5px;">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <textarea id="lokasi" name="lokasi" rows="2" class="form-control" placeholder="Lokasi" required></textarea>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <input type="text" id="harga" onkeydown="input_number(event)" onkeyup="$(this).val(format_rupiah($(this).val()))" name="harga" class="form-control" placeholder="Harga Tiket" required>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <textarea id="deskripsi" name="deskripsi" rows="2" class="form-control" placeholder="Deskripsi" required></textarea>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <label for="gambar">Gambar <small class="text-danger">*Maks 300kB</small></label>
                                                    <input type="file" id="gambar" name="gambar" class="form-control-file" required>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <textarea id="map_url" name="map_url" rows="2" class="form-control" placeholder="Map Link URL" required></textarea>
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
                                                <th>Judul</th>
                                                <th>Tanggal & Waktu</th>
                                                <th>Harga</th>
                                                <th>Lokasi</th>
                                                <th>Deskripsi</th>
                                                <th>Gambar</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data as $r) : ?>
                                                <tr>

                                                    <td><?= $r->judul ?></td>
                                                    <td><?= $r->tanggal ?></td>
                                                    <td><?= separator_harga($r->harga) ?></td>
                                                    <td><?= $r->lokasi ?></td>
                                                    <td><?= $r->deskripsi ?></td>
                                                    <td><img src="<?= $img_server ?>assets/img_marketing/acara/<?= $r->gambar ?>" width="200px"></td>
                                                    <td>
                                                        <div class="form-group mb-0">
                                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->judul ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
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
    $("#judul").keyup(function() {
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
                if ($('#gambar')[0].files[0].size / 1048576 > 0.3) {
                    swal("", "Ukuran file melebihi 300kB!", "warning");
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
                $('#judul').val(r.judul);
                $('#tanggal').datepicker('update', r.tanggal);
                $('#waktu').val(r.waktu);
                $('#lokasi').val(r.lokasi);
                $('#harga').val(r.harga);
                $('#deskripsi').val(r.deskripsi);
                $('#map_url').val(r.map_url);
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
                }, function(r) {
                    if (r == 1) swal("", "Data berhasil dihapus!", "success").then(function() {
                        location.reload();
                    });
                    else swal("", "Data sedang digunakan!", "error");
                });
            }
        });
    }
</script>