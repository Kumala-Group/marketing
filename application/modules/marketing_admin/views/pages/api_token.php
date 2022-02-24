<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_profil">Tambah Token</h5>
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
                                            <input type="text" onkeydown="input_number(event)" id="username" name="username" class="form-control" placeholder="Username" required>
                                        </div>
                                        <input type="hidden" name="simpan" value="true">
                                        <p>Generate Token untuk akses API</p>
                                        <div class="form-actions right">
                                            <button id="submit" class="btn btn-primary">
                                                <i class="icon-check2"></i> Generate
                                            </button>
                                        </div>

                                    </div>
                                    <div class="col-md-9">
                                        <div class="table-responsive">
                                            <table class="table table-sm table_aplikasi">
                                                <thead>
                                                    <tr>
                                                        <th>Username</th>
                                                        <th>Akses Token</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($data)) :
                                                        foreach ($data as $r) : ?>
                                                            <tr>
                                                                <td><?= $r['username'] ?></td>
                                                                <td><?= $r['token'] ?></td>
                                                                <td>
                                                                    <div class="form-group mb-0">
                                                                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                            <button type="button" onclick="hapus_data(<?= $r['id'] ?>,'<?= $r['token'] ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                    <?php endforeach;
                                                    endif ?>
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
    $('#submit').click(function(e) {
        e.preventDefault();
        var data = $('#form').serialize();
        if ($('#form').valid()) {
            $.post(location, data, function(r) {
                if (r == 1) swal("", "Token berhasil dibuat!", "success").then(function() {
                    location.reload();
                });
                else if (r == 2) swal("", "Username tidak ditemukan!", "error");
                else swal("", "Anda sudah membuat token!", "warning");
            });
        }
    });

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