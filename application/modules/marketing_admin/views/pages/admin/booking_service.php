<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_profil">Tabel Booking Service</h5>
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
                                                    <th>Tanggal Service</th>
                                                    <th>Dealer</th>
                                                    <th>No Polisi</th>
                                                    <th>Nama</th>
                                                    <th>Telepon</th>
                                                    <th>Alamat</th>
                                                    <th>Jam Service</th>
                                                    <th>Jenis Service</th>
                                                    <th>Keterangan</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($id)) :
                                                    foreach ($id as $i => $v) : ?>
                                                        <tr>
                                                            <td><?= tgl_sql($tanggal_service[$i]) ?></td>
                                                            <td><?= $_dealer[$i] ?></td>
                                                            <td><?= $no_polisi[$i] ?></td>
                                                            <td><?= $nama[$i] ?></td>
                                                            <td><?= $telepon[$i] ?></td>
                                                            <td><?= $alamat[$i] ?></td>
                                                            <td><?= $jam_service[$i] ?></td>
                                                            <td><?= $jenis_service[$i] ?></td>
                                                            <td><?= $keterangan[$i] ?></td>
                                                            <td id="status" data-id="<?= $v ?>" data-status="<?= $status[$i] ?>"><?= ($status[$i] == '0' || $status[$i] == null) ? 'Belum dikonfirmasi' : 'Terkonfirmasi' ?></td>
                                                            <td>
                                                                <div class="form-group mb-0">
                                                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                        <button type="button" onclick="hapus_data(<?= $v ?>,'<?= $nama[$i] ?>');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                <?php endforeach;
                                                endif; ?>
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
    // untuk ubah status konfirmasi
    var untukUbahStatus = function() {
        $(document).on('click', '#status', function(e) {
            var ini = $(this);

            ini.removeAttr('id');

            var n = (ini.data('status') == 0) ? 'selected' : '';
            var y = (ini.data('status') == 1) ? 'selected' : '';

            ini.html(`<select name="ubah_status" id="ubah_status" class="form-control" data-id="` + ini.data('id') + `">
                        <option value="0" ` + n + `>Belum dikonfirmasi</option>
                        <option value="1" ` + y + `>Terkonfirmasi</option>
                    </select>`);
        });
    }();

    // untuk proses ubah
    var untukProsesUbahStatus = function() {
        $(document).on('change', '#ubah_status', function() {
            var ini = $(this);

            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>admin/booking_service/ubah_status",
                dataType: 'json',
                data: {
                    id: ini.data('id'),
                    val: ini.val()
                },
                success: function(data) {
                    if (data.status == true) {
                        swal("", data.message, "success").then(function() {
                            location.reload();
                        });
                    } else {
                        swal("", data.message, "error").then(function() {
                            location.reload();
                        });
                    }
                },
            });
        });
    }();

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