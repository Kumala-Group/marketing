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
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-sm table_aplikasi">
                                            <thead>
                                                <tr>
                                                    <th>Posisi</th>
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
                                                <?php foreach ($data as $v) : ?>
                                                    <tr>
                                                        <td><?= $v->posisi ?></td>
                                                        <td><?= $v->nama ?></td>
                                                        <td><?= $v->email ?></td>
                                                        <td><?= $v->alamat ?></td>
                                                        <td><?= $v->telepon ?></td>
                                                        <td><?= $v->pendidikan ?></td>
                                                        <td><img src="<?= $img_server ?>assets/img_marketing/pelamar/<?= $v->foto ?>" width="100px"></td>
                                                        <td><a download href="<?= $img_server ?>assets/img_marketing/pelamar/<?= $v->cv ?>" target="_blank"><i class="icon-ios-eye"></i> Lihat</a></td>
                                                        <td><a download href="<?= $img_server ?>assets/img_marketing/pelamar/<?= $v->surat_lamaran ?>" target="_blank"><i class="icon-ios-eye"></i> Lihat</a></td>
                                                        <td>
                                                            <div class="form-group mb-0">
                                                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                    <button type="button" onclick="hapus_data(<?= $v->id ?>,'<?= $v->nama ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
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
</script>