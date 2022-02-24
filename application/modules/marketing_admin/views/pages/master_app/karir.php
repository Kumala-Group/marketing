<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_profil">Tambah Karir</h5>
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
                                            <input type="text" id="posisi" name="posisi" class="form-control" placeholder="Posisi" required>
                                        </div>
                                        <div class="form-group mb-1">
                                            <input type="text" onkeydown="input_number(event)" id="jumlah" name="jumlah" class="form-control" placeholder="Jumlah" required>
                                        </div>
                                        <div class="form-group mb-1">
                                            <textarea id="deskripsi" name="deskripsi" rows="2" class="form-control" placeholder="Deskripsi" required></textarea>
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
                                        <div class="table-responsive">
                                            <table class="table table-sm table_aplikasi">
                                                <thead>
                                                    <tr>
                                                        <th>Posisi</th>
                                                        <th>Jumlah</th>
                                                        <th>Deskripsi</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($data as $r) : ?>
                                                        <tr>
                                                            <td><?= $r->posisi ?></td>
                                                            <td><?= $r->jumlah ?></td>
                                                            <td><?= $r->deskripsi ?></td>
                                                            <td>
                                                                <div class="form-group mb-0">
                                                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                        <button type="button" onclick="edit_data(<?= $r->id ?>);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                                                        <button type="button" onclick="hapus_data(<?= $r->id ?>,'<?= $r->posisi ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
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
    $("#posisi").keyup(function() {
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

    function edit_data(id) {
        $('#form').trigger('reset');
        $('#title_profil').html("Edit Karir");
        $('#id').val(id);
        $('#submit').removeAttr('disabled');
        $('#submit').html('<i class="icon-check2"></i> Update');
        $('input').eq(0).focus();
        $.post(location, {
                'edit': true,
                'id': id
            }, function(r) {
                $('#posisi').val(r.posisi);
                $('#jumlah').val(r.jumlah);
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
                }, function(r) {
                    swal("", "Data berhasil dihapus!", "success").then(function() {
                        location.reload();
                    });
                });
            }
        });
    }
</script>