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
                                                                <?php if (isset($activity)) : ?>
                                                                    <?php foreach ($activity as $v) : ?>
                                                                        <option value="<?= $v->id_event_jenis ?>"><?= $v->event_jenis ?></option>
                                                                    <?php endforeach ?>
                                                                <?php endif ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <input type="text" id="activity" name="activity" class="form-control" placeholder="Activity" required>
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <select id="lokasi" name="lokasi" class="form-control" required style="width: 100%;">
                                                                <option value="" selected disabled>-- Silahkan Pilih Lokasi --</option>
                                                                <?php if (isset($lokasi)) : ?>
                                                                    <?php foreach ($lokasi as $v) : ?>
                                                                        <option value="<?= $v->id_event_lokasi ?>"><?= "$v->event_area - $v->lokasi" ?></option>
                                                                    <?php endforeach ?>
                                                                <?php endif ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <select id="provinsi" name="provinsi" class="form-control" required style="width: 100%;">
                                                                <option value="" selected disabled>-- Silahkan Pilih Provinsi --</option>
                                                                <?php if (isset($provinsi)) : ?>
                                                                    <?php foreach ($provinsi as $v) : ?>
                                                                        <option value="<?= $v->id_provinsi ?>"><?= $v->nama ?></option>
                                                                    <?php endforeach ?>
                                                                <?php endif ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <select id="kabupaten" name="kabupaten" class="form-control" required style="width: 100%;">
                                                                <option value="" selected disabled>-- Silahkan Pilih Kabupaten --</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <select id="kecamatan" name="kecamatan" class="form-control" required style="width: 100%;">
                                                                <option value="" selected disabled>-- Silahkan Pilih Kecamatan --</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <input type="text" id="booth_size" name="booth_size" class="form-control" placeholder="Booth Size" required>
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <input type="text" id="tanggal_awal" name="tanggal_awal" class="form-control" placeholder="Tanggal Awal" autocomplete="off" required>
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <input type="text" id="tanggal_akhir" name="tanggal_akhir" class="form-control" placeholder="Tanggal Akhir" autocomplete="off" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h5 class="card-title">Display</h5>
                                                        <div class="form-group mb-1">
                                                            <input type="text" id="display_1" name="display_1" class="form-control" placeholder="Display 1" required>
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <input type="text" id="display_2" name="display_2" class="form-control" placeholder="Display 2">
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <input type="text" id="display_3" name="display_3" class="form-control" placeholder="Display 3">
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <input type="text" id="display_4" name="display_4" class="form-control" placeholder="Display 4">
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <input type="text" id="proposal_biaya_internal" name="proposal_biaya_internal" onkeydown="input_number(event);" class="form-control" placeholder="Proposal Biaya Internal" required>
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <textarea id="alasan" name="alasan" rows="2" class="form-control" placeholder="Alasan Memilih Lokasi"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h5 class="card-title">Marketing Review</h5>
                                                        <div class="form-group mb-1">
                                                            <input type="text" id="market_size" name="market_size" class="form-control" placeholder="Market Size">
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <input type="text" id="market_share" name="market_share" class="form-control" placeholder="Market Share">
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <input type="text" id="spk_taking" name="spk_taking" class="form-control" placeholder="SPK Taking">
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <input type="text" id="analisis" name="analisis" class="form-control" placeholder="Analisis">
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <input type="text" id="rekomendasi" name="rekomendasi" class="form-control" placeholder="Rekomendasi">
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <textarea id="notes" name="notes" rows="2" class="form-control" placeholder="Notes"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-1">
                                                            <label for="">Biaya Actual</label>
                                                            <input type="text" id="biaya_actual" name="biaya_actual" class="form-control" value="0" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-1">
                                                            <label for="">Sisa Biaya Internal</label>
                                                            <input type="text" id="sisa_biaya_internal" name="sisa_biaya_internal" class="form-control" value="0" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5 class="card-title">Target</h5>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-1">
                                                                    <input type="text" id="visitor" name="visitor" onkeydown="input_number(event);" class="form-control" placeholder="Visitor" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-1">
                                                                    <input type="text" id="prospect" name="prospect" onkeydown="input_number(event);" class="form-control" placeholder="Prospect" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-1">
                                                                    <input type="text" id="spk" name="spk" class="form-control" onkeydown="input_number(event);" placeholder="SPK" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group mb-1">
                                                            <input type="text" id="proposal_biaya" name="proposal_biaya" onkeydown="input_number(event);" onkeyup="$(this).val(format_rupiah($(this).val()))" class="form-control" placeholder="Proposal Biaya" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5 class="card-title">Result</h5>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group mb-1">
                                                            <input type="text" id="r_visitor" name="r_visitor" onkeydown="input_number(event);" class="form-control" placeholder="Visitor" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group mb-1">
                                                            <input type="text" id="r_prospect" name="r_prospect" onkeydown="input_number(event);" class="form-control" placeholder="Prospect" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group mb-1">
                                                            <input type="text" id="r_spk" name="r_spk" class="form-control" onkeydown="input_number(event);" placeholder="SPK" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="">Cost Per Prospect</label>
                                                        <div class="form-group mb-1">
                                                            <input type="text" id="cost_per_prospect" name="cost_per_prospect" class="form-control" value="0" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="">Cost Per SPK</label>
                                                        <div class="form-group mb-1">
                                                            <input type="text" id="cost_per_spk" name="cost_per_spk" class="form-control" value="0" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group mb-1">
                                                            <textarea id="keterangan" name="keterangan" rows="2" class="form-control" placeholder="Keterangan"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
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
    $('#lokasi').select2();
    $('#provinsi').select2();
    $('#kabupaten').select2();
    $('#kecamatan').select2();
    $('#jenis').change(function() {
        $('#form').valid();
    });
    $('#lokasi').change(function() {
        $('#form').valid();
    });
    $('#provinsi').change(function() {
        $.post(location, {
            'kabupaten': true,
            'id': $('#provinsi').val()
        }, function(r) {
            $('#kabupaten').html(r);
        });
        $('#form').valid();
    });
    $('#kabupaten').change(function() {
        $.post(location, {
            'kecamatan': true,
            'id': $('#kabupaten').val()
        }, function(r) {
            $('#kecamatan').html(r);
        });
        $('#form').valid();
    });
    $('#kecamatan').change(function() {
        $('#form').valid();
    });

    <?php if (isset($lokasi)) : ?>
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

        $('#prospect').keyup(function() {
            var visitor = $('#visitor').val();
            if (visitor.length == 0) $(this).val("");
            if (parseInt($(this).val()) > parseInt(visitor)) $(this).val(visitor);
            $('#spk').val($(this).val());
        });
        $('#spk').keyup(function() {
            var prospect = $('#prospect').val();
            if (prospect.length == 0) $(this).val("");
            if (parseInt($(this).val()) > parseInt(prospect)) $(this).val(prospect);
        });

        //proses perhitungan di view
        var total_biaya = 0;

        $('#proposal_biaya_internal').keyup(function() {
            $(this).val(format_rupiah($(this).val()));
            recount();
        });
        $('#r_prospect').keyup(function() {
            var r_visitor = $('#r_visitor').val();
            if (r_visitor.length == 0) $(this).val("");
            if (parseInt($(this).val()) > parseInt(r_visitor)) $(this).val(r_visitor);
            $('#r_spk').val($(this).val());
            recount();
        });
        $('#r_spk').keyup(function() {
            var r_prospect = $('#r_prospect').val();
            if (r_prospect.length == 0) $(this).val("");
            if (parseInt($(this).val()) > parseInt(r_prospect)) $(this).val(r_prospect);
            recount();
        });
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

        function recount() {
            sisa_biaya_internal();
            cost_per_prospect();
            cost_per_spk();
        }

        function sisa_biaya_internal() {
            var proposal_biaya_internal = parseInt(toAngka($('#proposal_biaya_internal').val()));
            var biaya_actual = parseInt(toAngka($('#biaya_actual').val()));
            if (proposal_biaya_internal >= biaya_actual) {
                var sisa_biaya_internal = proposal_biaya_internal - biaya_actual;
                $('#sisa_biaya_internal').val(format_rupiah(sisa_biaya_internal.toString()));
            } else $('#sisa_biaya_internal').val("0");
        }

        function cost_per_prospect() {
            var biaya_actual = parseInt(toAngka($('#biaya_actual').val()));
            var r_prospect = parseInt($('#r_prospect').val());
            if (biaya_actual >= r_prospect) {
                var cost_per_prospect = biaya_actual / r_prospect;
                $('#cost_per_prospect').val(format_rupiah(Math.round(cost_per_prospect).toString()));
            } else $('#cost_per_prospect').val("0");
        }

        function cost_per_spk() {
            var sisa_biaya_internal = parseInt(toAngka($('#sisa_biaya_internal').val()));
            var r_spk = parseInt($('#r_spk').val());
            if (sisa_biaya_internal >= r_spk) {
                var cost_per_spk = sisa_biaya_internal / r_spk;
                $('#cost_per_spk').val(format_rupiah(Math.round(cost_per_spk).toString()));
            } else $('#cost_per_spk').val("0");
        }
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
                $('#provinsi').val(r.id_provinsi);
                $('#select2-provinsi-container').html(r.provinsi);
                $.post(location, {
                    'kabupaten': true,
                    'id': r.id_provinsi
                }, function(s) {
                    $('#kabupaten').html(s);
                    $('#kabupaten').val(r.id_kabupaten);
                    $('#select2-kabupaten-container').html(r.kabupaten);
                    $('#form').valid();
                    $.post(location, {
                        'kecamatan': true,
                        'id': r.id_kabupaten
                    }, function(t) {
                        $('#kecamatan').html(t);
                        $('#kecamatan').val(r.id_kecamatan);
                        $('#select2-kecamatan-container').html(r.kecamatan);
                        $('#form').valid();
                    });
                });
                $("#jenis").val(r.id_event_jenis).trigger('change');
                $('#activity').val(r.event);
                $('#lokasi').val(r.id_event_lokasi).trigger('change');
                $('#booth_size').val(r.booth_size);
                $('#tanggal_awal').datepicker('update', r.tgl_mulai);
                $('#tanggal_akhir').datepicker('update', r.tgl_selesai);
                $('#visitor').val(r.t_visitor);
                $('#prospect').val(r.t_prospect);
                $('#spk').val(r.t_spk);
                $('#proposal_biaya').val(r.proposal_biaya);
                $('#alasan').val(r.alasan_memilih_lokasi);
                $('#display_1').val(r.display_1);
                $('#display_2').val(r.display_2);
                $('#display_3').val(r.display_3);
                $('#display_4').val(r.display_4);
                $('#proposal_biaya_internal').val(r.proposal_biaya_internal);
                $('#market_size').val(r.market_size);
                $('#market_share').val(r.market_share);
                $('#spk_taking').val(r.spk_taking);
                $('#analisis').val(r.analisis);
                $('#rekomendasi').val(r.rekomendasi);
                $('#notes').val(r.notes);
                $('#biaya_actual').val(r.total_biaya);
                $('#sisa_biaya_internal').val(r.sisa_biaya_internal);
                $('#r_visitor').val(r.r_visitor);
                $('#r_prospect').val(r.r_prospect);
                $('#r_spk').val(r.r_spk);
                $('#cost_per_prospect').val(r.cost_per_prospect);
                $('#cost_per_spk').val(r.cost_per_spk);
                $('#keterangan').val(r.keterangan);

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
                    }, function(r) {
                        swal("", "Data berhasil dihapus!", "success").then(function() {
                            reload();
                            datatable.draw(false);
                        });
                    });
                }
            });
        }
    <?php else : ?>
        $(document).ready(function() {
            swal({
                title: "Tidak dapat membuka halaman menu!",
                text: "Akun anda tidak memiliki coverage cabang",
                icon: "error",
                closeOnClickOutside: false,
                closeOnEsc: false,
            }).then((ok) => {
                if (ok) window.location.replace('<?= base_url() ?>marketing/beranda');
            })
        });
    <?php endif ?>
</script>