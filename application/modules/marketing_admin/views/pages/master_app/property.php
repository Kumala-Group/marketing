<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Property</h5>
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
                                            <div class="col-md-6">
                                                <div class="form-group mb-1">
                                                    <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Property" required>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group mb-1 col-md-6">
                                                        <select id="jenis" name="jenis" class="form-control" required>
                                                            <option value="" selected disabled>-- Silahkan Pilih Jenis --</option>
                                                            <option value="ruko">Ruko</option>
                                                            <option value="perumahan">Perumahan</option>
                                                            <option value="kavling">Kavling</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group mb-1 col-md-6">
                                                        <input type="text" id="daerah" name="daerah" class="form-control" placeholder="Daerah" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group mb-1 col-md-6">
                                                        <input type="text" onkeydown="input_number(event)" onkeyup="$(this).val(format_rupiah($(this).val()))" id="harga_sewa" name="harga_sewa" class="form-control" placeholder="Harga Sewa">
                                                        <label class="m-0 pb-0" for="gambar"><small>*Kosongkan jika tidak ada</small></label>
                                                    </div>
                                                    <div class="form-group mb-1 col-md-6">
                                                        <input type="text" onkeydown="input_number(event)" onkeyup="$(this).val(format_rupiah($(this).val()))" id="harga_jual" name="harga_jual" class="form-control" placeholder="Harga Jual">
                                                        <label class="m-0 pb-0" for="gambar"><small>*Kosongkan jika tidak ada</small></label>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <textarea id="alamat" name="alamat" rows="2" class="form-control" placeholder="Alamat" required></textarea>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <textarea id="map_url" name="map_url" rows="8" class="form-control" placeholder="Map Link URL => <iframe src='https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3518.3411705681974!2d119.43643572274698!3d-5.158944397348144!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNcKwMDknMzIuMiJTIDExOcKwMjYnMTcuOCJF!5e1!3m2!1sid!2sid!4v1599189901251!5m2!1sid!2sid' width='800' height='600' frameborder='0' style='border:0;' allowfullscreen='' aria-hidden='false' tabindex='0'></iframe>" minlength="100" data-msg-minlength="Gunakan peta yang disematkan" required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h5 class="card-title">Spesifikasi</h5>
                                                <div class="row">
                                                    <div class="form-group mb-1 col-md-6">
                                                        <input type="text" id="ukuran" name="ukuran" class="form-control" placeholder="Ukuran">
                                                    </div>
                                                    <div class="form-group mb-1 col-md-6">
                                                        <input type="text" id="jumlah_lantai" name="jumlah_lantai" onkeydown="input_number(event)" class="form-control" placeholder="Jumlah Lantai">
                                                    </div>
                                                    <div class="form-group mb-1 col-md-6">
                                                        <input type="text" id="listrik" name="listrik" class="form-control" placeholder="Listrik">
                                                    </div>
                                                    <div class="form-group mb-1 col-md-6">
                                                        <input type="text" id="sumber_air" name="sumber_air" class="form-control" placeholder="Sumber Air">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <textarea id="keterangan" name="keterangan" rows="5" class="form-control" placeholder="Keterangan/Deskripsi"></textarea>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group mb-1 col-md-6">
                                                        <label for="gambar">Gambar Thumbnail <small class="text-danger">*Maks 50kB</small></label>
                                                        <input type="file" id="gambar" name="gambar" class="form-control-file" required>
                                                    </div>
                                                    <div class="form-group mb-1 col-md-6">
                                                        <label for="denah">Denah <small class="text-danger">*Maks 300kB</small></label>
                                                        <input type="file" id="denah" name="denah" class="form-control-file" required>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <label for="galeri">Foto Galeri <small class="text-danger">*Maks 300kB</small></label>
                                                    <input type="file" id="galeri" name="galeri" class="form-control-file" multiple required>
                                                </div>
                                            </div>
                                            <input type="hidden" id="id" name="id" class="form-control">
                                        </div>
                                        <div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="card-title">Daftar Foto Galeri</h5>
                                                    <div class="row" id="foto_galeri"></div>
                                                </div>
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
                                <form class="form-inline">
                                    <div class="form-group mb-1">
                                        <select id="jenis_tab" name="jenis_tab" class="form-control" required>
                                            <option value="" selected disabled>-- Silahkan Pilih Jenis Property --</option>
                                            <option value="ruko">Ruko</option>
                                            <option value="perumahan">Perumahan</option>
                                            <option value="kavling">Kavling</option>
                                        </select>
                                    </div>

                                </form>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover table-condensed" id="datatable" width="100%"></table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade text-xs-left" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <img src="" alt="" class="img-fluid" style="object-fit: contain;width: 100%;">
        </div>
    </div>
</div>
<script type="text/javascript">
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
                data.jenis = $('#jenis_tab').val();
            }
        },
        columns: [{
            data: 'nama',
            title: 'Nama Property',
        }, {
            data: 'daerah',
            title: 'Daerah',
        }, {
            data: 'alamat',
            title: 'Alamat',
        }, {
            data: null,
            title: 'Gambar',
            orderable: false,
            searchable: false,
            render: function(r) {
                return `<img src="<?= $img_server ?>assets/img_marketing/property/` + r.gambar + `" width="200px">`;
            },
        }, {
            data: 'map_url',
            title: 'Map URL',
        }, {
            data: null,
            title: 'Aksi',
            orderable: false,
            searchable: false,
            responsivePriority: -1,
            render: function(r) {
                return `<div class="form-group mb-0">
                    <div class="btn-group btn-group-sm">
                    <button type="button" onclick="edit_data(` + r.id + `);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                    <button type="button" onclick="hapus_data(` + r.id + `,'` + r.nama + `');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
                    </div></div>`;
            },
        }],
    });
    $('#jenis_tab').change(function() {
        datatable.draw();
    });

    $('#nama').keyup(function() {
        $('#submit').prop('disabled', false);
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
                if ($('#gambar')[0].files[0].size / 1048576 > 0.05) {
                    swal("", "Ukuran file melebihi 50kB!", "warning");
                    breakout = true;
                }
            }
            if ($('#denah')[0].files.length != 0) {
                var denah = $('#denah')[0].files[0];
                var allowed_types = ["jpg", "jpeg", "png"];
                var ext = denah.name.split(".").pop().toLowerCase();
                form_data.append('denah', denah);
                if ($.inArray(ext, allowed_types) == -1) {
                    swal("", "Silahkan pilih file gambar!", "warning");
                    breakout = true;
                }
                if ($('#denah')[0].files[0].size / 1048576 > 0.3) {
                    swal("", "Ukuran file melebihi 300kB!", "warning");
                    breakout = true;
                }
            }
            var galeri_length = $('#galeri')[0].files.length;
            if (galeri_length != 0) {
                var allowed_types = ["jpg", "jpeg", "png"];
                for (var i = 0; i < galeri_length; i++) {
                    var galeri = $('#galeri')[0].files[i];
                    var ext = galeri.name.split(".").pop().toLowerCase();
                    form_data.append('galeri[]', galeri);
                    if ($.inArray(ext, allowed_types) == -1) {
                        swal("", "Silahkan pilih file gambar!", "warning");
                        breakout = true;
                    }
                    if ($('#galeri')[0].files[0].size / 1048576 > 0.3) {
                        swal("", "Ukuran file melebihi 300kB!", "warning");
                        breakout = true;
                    }
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
                        var response = JSON.parse(r);
                        swal("", response.msg, response.status).then(function() {
                            if (response.status == "success") location.reload();
                            else unload();
                        });
                    }
                });
            }
        }
    });
    $('#foto_galeri').on('click', '.hapus_galeri', function(e) {
        e.preventDefault();
        var id_galeri = $(this).closest('.col-md-3').find('.id_galeri').val();
        if (id_galeri.length != 0) $.post(location, {
            'hapus_galeri': true,
            'id': id_galeri
        }, function(r) {
            var response = JSON.parse(r);
            swal("", response.msg, response.status);
        });
        $(this).closest('.col-md-3').remove();
    });
    $('#foto_galeri').on('click', 'a', function(e) {
        var img = $(this).closest('.col-md-3').find('img').attr('src');
        $('#default').find('img').attr('src', img);
    });

    function edit_data(id) {
        $('#form').trigger('reset');
        $('#title_user').html("Edit");
        $('#id').val(id);
        $('.nav-tabs a:first').tab('show');
        $('#gambar').removeAttr('required');
        $('#denah').removeAttr('required');
        $('#galeri').removeAttr('required');
        $('#submit').removeAttr('disabled');
        $('#submit').html('<i class="icon-check2"></i> Update');
        $('input').eq(0).focus();
        $.post(location, {
                'edit': true,
                'id': id
            }, function(r) {
                $('#nama').val(r.nama);
                $('#jenis').val(r.jenis);
                $('#daerah').val(r.daerah);
                $('#harga_sewa').val(r.harga_sewa);
                $('#harga_jual').val(r.harga_jual);
                $('#alamat').val(r.alamat);
                $('#map_url').val(r.map_url);
                $('#ukuran').val(r.ukuran);
                $('#jumlah_lantai').val(r.jumlah_lantai);
                $('#listrik').val(r.listrik);
                $('#sumber_air').val(r.sumber_air);
                $('#keterangan').val(r.keterangan);
                $.each(r.galeri, function(i, v) {
                    html = `<div class="col-xs-6 col-sm-4 col-md-3 mb-1">
                    <a href="#default" data-toggle="modal"><img src="<?= $img_server ?>assets/img_marketing/property/galeri/` + v.img + `" alt="" class="img-fluid" style="width: 100%; height: 150px; object-fit: cover;"></a><input type="hidden" class="id_galeri" value="` + v.id + `">
                    <div class="form-actions m-0 right"><button class="btn btn-danger btn-sm hapus_galeri">Hapus</button></div>
                    </div>`;
                    $('#foto_galeri').append(html);
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
                }, function(r) {
                    var response = JSON.parse(r);
                    swal("", response.msg, response.status).then(function() {
                        if (response.status == "success") location.reload();
                    });
                });
            }
        });
    }
</script>