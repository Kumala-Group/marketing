<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title m-0">Data Activity/Pameran</h5>
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
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group mb-1">
                                                            <select id="jenis" name="jenis" class="form-control" required style="width: 100%;">
                                                                <option value="" selected disabled>-- Silahkan Pilih Jenis Activity --</option>
                                                                <?php foreach ($activity as $v) : ?>
                                                                    <option value="<?= $v->id_event_jenis ?>"><?= $v->event_jenis ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <input type="text" id="activity" name="activity" class="form-control" placeholder="Activity" required>
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <input type="text" id="tanggal_awal" name="tanggal_awal" class="form-control" placeholder="Tanggal Awal" autocomplete="off" required>
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <input type="text" id="tanggal_akhir" name="tanggal_akhir" class="form-control" placeholder="Tanggal Akhir" autocomplete="off" required>
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <select id="lokasi" name="lokasi" class="form-control" required style="width: 100%;">
                                                                <option value="" selected disabled>-- Silahkan Pilih Lokasi --</option>
                                                                <?php foreach ($lokasi as $v) : ?>
                                                                    <option value="<?= $v->id_event_lokasi ?>"><?= "$v->event_area - $v->lokasi" ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <label for="">Biaya Actual</label>
                                                            <input type="text" id="biaya_actual" name="biaya_actual" class="form-control" value="0" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <h5 class="card-title">Biaya Actual</h5>
                                                <div class="form-group mb-1"><button type="button" id="button_tambah_biaya" class="btn btn-success btn-sm">Tambah</button></div>
                                                <div class="table-responsive">
                                                    <table class="table table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>Jenis</th>
                                                                <th>Biaya</th>
                                                                <th>Keterangan</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tabel_biaya_actual"></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="simpan" value="true">
                                    <input type="hidden" id="id_event" name="id_event">
                                    <div class="form-actions center">
                                        <a href="" class="btn btn-warning mr-1">
                                            <i class="icon-reload"></i> Reset
                                        </a>
                                        <button id="submit" class="btn btn-primary">
                                            <i class="icon-check2"></i> Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane active" id="tab2">
                                <div class="table-responsive">
                                    <table class="table table-sm" id="datatable" width="100%"></table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade text-xs-left" id="small">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form id="form_biaya">
                <div class="modal-body">
                    <div class="form-group mb-1">
                        <input type="text" id="jenis_biaya" name="modal_jenis_biaya" class="form-control" placeholder="Jenis Biaya" required>
                    </div>
                    <div class="form-group mb-1">
                        <input type="text" id="biaya" name="modal_biaya" onkeydown="input_number(event);" onkeyup="$(this).val(format_rupiah($(this).val()))" class="form-control" placeholder="Biaya" required>
                    </div>
                    <div class="form-group mb-1">
                        <textarea id="keterangan_biaya" name="modal_keterangan_biaya" rows="2" class="form-control" placeholder="Keterangan" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-warning" data-dismiss="modal">Close</button>
                    <button id="tambah_biaya" class="btn btn-outline-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#tanggal_awal').datepicker({
        'format': 'dd-mm-yyyy'
    });
    $('#tanggal_akhir').datepicker({
        'format': 'dd-mm-yyyy'
    });
    $('#jenis').select2();
    $('#jenis').change(function() {
        $('#form').valid();
    });
    $('#lokasi').select2();
    $('#lokasi').change(function() {
        $('#form').valid();
    });
    var datatable = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        order: [],
        responsive: true,
        ajax: {
            type: 'post',
            url: location,
            data: function(data) {
                data.datatable = true;
            }
        },
        columns: [{
            data: 'event_jenis',
            title: 'Jenis Event',
        }, {
            data: 'event',
            title: 'Activity',
        }, {
            data: 'tgl_mulai',
            title: 'Tanggal Mulai',
        }, {
            data: 'tgl_selesai',
            title: 'Tanggal Selesai',
        }, {
            data: 'lokasi',
            title: 'Lokasi',
        }, {
            data: 'total_biaya',
            title: 'Total Biaya',
            orderable: false
        }, {
            data: null,
            title: 'Aksi',
            orderable: false,
            searchable: false,
            responsivePriority: -1,
            render: function(r) {
                return `<div class="form-group mb-0">
                    <div class="btn-group btn-group-sm">
                    <button type="button" onclick="edit_data(` + r.id_event + `);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                    <button type="button" onclick="hapus_data('` + r.id_event + `','` + r.event + `');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
                    </div></div>`;
            },
        }],
    });

    $('#submit').click(function(e) {
        e.preventDefault();
        var breakout = false;
        if ($('#form').valid()) {
            var proposal_biaya = toAngka($('#proposal_biaya').val());
            var proposal_biaya_internal = toAngka($('#proposal_biaya_internal').val());
            var biaya_actual = toAngka($('#biaya_actual').val());
            if (proposal_biaya.length == 0) {
                swal("", "Proposal biaya wajib diisi", "warning").then(function() {
                    $('#proposal_biaya').focus();
                });
                breakout = true;
            }
            if (parseInt(proposal_biaya) < parseInt(proposal_biaya_internal)) {
                swal("", "Proposal biaya harus lebih besar dari proposal biaya internal", "warning").then(function() {
                    $('#proposal_biaya').focus();
                });
                breakout = true;
            }
            if (proposal_biaya_internal.length == 0) {
                swal("", "Proposal biaya internal wajib diisi", "warning").then(function() {
                    $('#proposal_biaya').focus();
                });
                breakout = true;
            }
            if (parseInt(proposal_biaya_internal) < parseInt(biaya_actual)) {
                swal("", "Proposal biaya internal harus lebih besar dari biaya actual", "warning").then(function() {
                    $('#proposal_biaya_internal').focus();
                });
                breakout = true;
            }
            if (breakout) return false;
            else {
                loading();
                var data = $('#form').serialize();
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
        }
    });

    //proses perhitungan di view
    var total_biaya = 0;

    $('#button_tambah_biaya').click(function() {
        $('#modal_status').val("");
        $('#small').modal('show');
    });
    $('#tambah_biaya').click(function(e) {
        e.preventDefault();
        if ($('#form_biaya').valid()) {
            var biaya = toAngka($('#biaya').val());
            total_biaya = parseInt(total_biaya) + parseInt(biaya);
            html = `<tr>
                <td><input type="hidden" name="id_biaya[]">
                <input type="hidden" name="jenis_biaya[]" value="` + $('#jenis_biaya').val() + `">` + $('#jenis_biaya').val() + `</td>
                <td><input type="hidden" name="biaya[]" value="` + $('#biaya').val() + `">` + $('#biaya').val() + `</td>
                <td><input type="hidden" name="keterangan_biaya[]" value="` + $('#keterangan_biaya').val() + `">` + $('#keterangan_biaya').val() + `</td>
                <td>
                    <div class="form-group mb-0">
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="hapus_biaya btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
                        </div>
                    </div>
                </td>
            </tr>`;
            $('#biaya_actual').val(format_rupiah(total_biaya.toString()));
            $('#tabel_biaya_actual').append(html);
            $('#jenis_biaya').val("");
            $('#biaya').val("");
            $('#keterangan_biaya').val("");
            $('#small').modal('hide');
            recount();
        }
    });
    $('#tabel_biaya_actual').on('click', '.hapus_biaya', function() {
        var biaya = toAngka($(this).closest('tr').find('input').eq(2).val());
        total_biaya = parseInt(total_biaya) - parseInt(biaya);
        var id_biaya = $(this).closest('tr').find('input').eq(0).val();
        if (id_biaya.length != 0) $.post(location, {
            'hapus_biaya': true,
            'id_event': $('#id_event').val(),
            'id': id_biaya,
            'biaya': total_biaya
        }, function() {
            swal("", "Data berhasil dihapus!", "success");
        });
        $('#biaya_actual').val(format_rupiah(total_biaya.toString()));
        $(this).closest('tr').remove();
        recount();
    });
    //end perhitungan

    function edit_data(id) {
        $('#form').trigger('reset');
        $('#title_user').html("Edit");
        $('#id_event').val(id);
        $('.nav-tabs a:first').tab('show');
        $('#submit').removeAttr('disabled');
        $('#submit').html('<i class="icon-check2"></i> Update');
        $('input').eq(0).focus();
        $('#tabel_biaya_actual').children().remove();
        $.post(location, {
                'edit': true,
                'id': id
            }, function(r) {
                total_biaya = parseInt(toAngka(r.total_biaya));

                $("#jenis").val(r.id_event_jenis).trigger('change');
                $('#activity').val(r.event);
                $('#lokasi').val(r.id_event_lokasi).trigger('change');
                $('#tanggal_awal').datepicker('update', r.tgl_mulai);
                $('#tanggal_akhir').datepicker('update', r.tgl_selesai);
                $('#biaya_actual').val(r.total_biaya);

                $.each(r.biaya, function(i, v) {
                    html = `<tr>
                        <td><input type="hidden" name="id_biaya[]" value="` + v.id_biaya + `">
                        <input type="hidden" name="jenis_biaya[]" value="` + v.jenis_biaya + `">` + v.jenis_biaya + `</td>
                        <td><input type="hidden" name="biaya[]" value="` + v.biaya + `">` + v.biaya + `</td>
                        <td><input type="hidden" name="keterangan_biaya[]" value="` + v.keterangan_biaya + `">` + v.keterangan_biaya + `</td>
                        <td>
                            <div class="form-group mb-0">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="hapus_biaya btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>`;
                    $('#tabel_biaya_actual').append(html);
                });
                $('#form').valid();
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
                        reload();
                        datatable.draw(false);
                    });
                });
            }
        });
    }
</script>