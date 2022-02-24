<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_profil">Tambah Brand</h5>
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
                                            <input type="text" id="jenis" name="jenis" class="form-control" placeholder="Jenis" required>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="level">Gambar <small class="text-danger">*Maks 1MB</small></label>
                                            <input type="file" id="gambar" name="gambar" class="form-control-file" required>
                                        </div>
                                        <div class="form-group mb-1">
                                            <textarea id="url" name="url" rows="2" class="form-control" placeholder="Link URL" required></textarea>
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
                                        <div class="table-responsive">
                                            <table class="table table-sm table_aplikasi">
                                                <thead>
                                                    <tr>
                                                        <th>Jenis</th>
                                                        <th>Gambar</th>
                                                        <th>Link URL</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($data as $r) : ?>
                                                        <tr>
                                                            <td><?= ucwords($r->jenis) ?></td>
                                                            <td><img src="<?= $img_server ?>assets/img_marketing/head/<?= $r->foto ?>" width="200px"></td>
                                                            <td><?= $r->url ?></td>
                                                            <td>
                                                                <div class="form-group mb-0">
                                                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                        <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                        <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->jenis ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $("#jenis").keyup(function() {
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
        $('#title_profil').html("Edit Brand");
        $('#id').val(id);
        $('#gambar').removeAttr('required');
        $('#submit').removeAttr('disabled');
        $('#submit').html('<i class="icon-check2"></i> Update');
        $('input').eq(0).focus();
        $.post(location, {
                'edit': true,
                'id': id
            }, function(r) {
                $('#jenis').val(r.jenis);
                $('#url').val(r.url);
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