<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">User</h5>
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
                                <a class="nav-link active" data-toggle="tab" href="#tab1">
                                    <p class="card-title m-0" id="title_user">Tambah</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab2">
                                    <p class="card-title m-0">User</p>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content px-1 pt-1">
                            <div class="tab-pane active" id="tab1">
                                <form id="form" class="form">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group mb-1">
                                                    <input type="text" id="nik" name="nik" onkeydown="input_number(event)" class="form-control" placeholder="NIK" required>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <input type="text" id="username" name="username" class="form-control" placeholder="Username" readonly>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <select id="level" name="level" class="form-control" required>
                                                        <option value="" selected disabled>-- Silahkan Pilih Profil --</option>
                                                        <?php foreach ($data_profil as $dt) : ?>
                                                            <option value="<?= $dt->id ?>"><?= $dt->nama_level ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <input type="password" id="r_password" name="r_password" class="form-control" placeholder="Ulangi Password" required>
                                                </div>
                                                <input type="hidden" id="coverage" name="coverage">
                                                <input type="hidden" id="id" name="id">
                                                <input type="hidden" name="simpan" value="true">
                                            </div>
                                            <div class="col-md-9">
                                                <h5 class="card-title" style="text-align: center;">User Coverage</h5>
                                                <ul class="nav nav-tabs">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-toggle="tab" href="#child_tab2">
                                                            <p class="card-title m-0">
                                                                <?php foreach ($brand_hino as $hino) : ?>
                                                                    <?= $hino->nama_brand ?>
                                                                <?php endforeach; ?>
                                                            </p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#child_tab3">
                                                            <p class="card-title m-0">
                                                                <?php foreach ($brand_honda as $honda) : ?>
                                                                    <?= $honda->nama_brand ?>
                                                                <?php endforeach; ?>
                                                            </p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#child_tab4">
                                                            <p class="card-title m-0">
                                                                <?php foreach ($brand_mazda as $mazda) : ?>
                                                                    <?= $mazda->nama_brand ?>
                                                                <?php endforeach; ?>
                                                            </p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#child_tab5">
                                                            <p class="card-title m-0">
                                                                <?php foreach ($brand_mercy as $marcy) : ?>
                                                                    <?= $marcy->nama_brand ?>
                                                                <?php endforeach; ?>
                                                            </p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#child_tab6">
                                                            <p class="card-title m-0">
                                                                <?php foreach ($brand_wuling as $wuling) : ?>
                                                                    <?= $wuling->nama_brand ?>
                                                                <?php endforeach; ?>
                                                            </p>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content px-1 pt-1">
                                                    <div class="tab-pane active" id="child_tab2">
                                                        <?php foreach ($coverage_hino as $v) : ?>
                                                            <div class="col-sm-6 col-lg-4">
                                                                <input type="checkbox" class="coverage" value="<?= $v->id_perusahaan ?>"> <span><?= "$v->singkat - $v->lokasi" ?></span>
                                                            </div>
                                                        <?php endforeach ?>
                                                    </div>
                                                    <div class="tab-pane" id="child_tab3">
                                                        <?php foreach ($coverage_honda as $v) : ?>
                                                            <div class="col-sm-6 col-lg-4">
                                                                <input type="checkbox" class="coverage" value="<?= $v->id_perusahaan ?>"> <span><?= "$v->singkat - $v->lokasi" ?></span>
                                                            </div>
                                                        <?php endforeach ?>
                                                    </div>
                                                    <div class="tab-pane" id="child_tab4">
                                                        <?php foreach ($coverage_mazda as $v) : ?>
                                                            <div class="col-sm-6 col-lg-4">
                                                                <input type="checkbox" class="coverage" value="<?= $v->id_perusahaan ?>"> <span><?= "$v->singkat - $v->lokasi" ?></span>
                                                            </div>
                                                        <?php endforeach ?>
                                                    </div>
                                                    <div class="tab-pane" id="child_tab5">
                                                        <?php foreach ($coverage_marcy as $v) : ?>
                                                            <div class="col-sm-6 col-lg-4">
                                                                <input type="checkbox" class="coverage" value="<?= $v->id_perusahaan ?>"> <span><?= "$v->singkat - $v->lokasi" ?></span>
                                                            </div>
                                                        <?php endforeach ?>
                                                    </div>
                                                    <div class="tab-pane" id="child_tab6">
                                                        <?php foreach ($coverage_wuling as $v) : ?>
                                                            <div class="col-sm-6 col-lg-4">
                                                                <input type="checkbox" class="coverage" value="<?= $v->id_perusahaan ?>"> <span><?= "$v->singkat - $v->lokasi" ?></span>
                                                            </div>
                                                        <?php endforeach ?>
                                                    </div>
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
                            <div class="tab-pane" id="tab2">
                                <div class="table-responsive">
                                    <table class="table table-sm" id="table_data_user">

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

<script>
    var coverage = [];
    $('.coverage').click(function() {
        console.log(coverage);
        if ($(this).is(':checked')) coverage.push($(this).val());
        else {
            var index = coverage.indexOf($(this).val())

            coverage.splice(index, 1);
        }
    });


    $('#nik').keyup(function(e) {
        $('#submit').removeAttr('disabled');
        var nik = $("#nik").val();
        $("#username").val(nik);
    });

    $('#submit').click(function(e) {
        var form = $('form');
        var password = $('#password').val();
        var r_password = $('#r_password').val();
        if (password == r_password) {
            $('#coverage').val(coverage.toString());
            var data = form.serialize();

            e.preventDefault();
            if (form.valid()) {
                loading();
                $.post("<?= base_url(); ?>kumalagroup_konfigurasi_user/simpan", data,
                    function(data) {
                        console.log(data);
                        if (data == 'data_fail') {
                            swal("", "Nik tidak di temukan! Atau Nik sudah ada!", "warning").then(function() {
                                location.reload();
                            });;
                        }

                        if (data == 'data_sukses') {
                            swal("", "Data berhasil disimpan!", "success").then(function() {
                                location.reload();
                            });
                        }
                        if (data == 'data_update') {
                            swal("", "Data berhasil diupdate!", "success").then(function() {
                                location.reload();
                            });
                        }
                    },

                );
            }
        } else swal("", "Password yang anda masukkan salah!", "error").then(function() {
            location.reload();
        });

    });
    var untukTableDatatable = function() {
        $('#table_data_user').DataTable({
            // responsive: true,
            serverSide: true,
            processing: true,
            info: true,

            ajax: {
                url: "<?= base_url(); ?>kumalagroup_konfigurasi_user/data_user",
                type: 'POST',
            },
            columns: [{
                    data: null,
                    title: 'Status',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        var status = (full.status_aktif == 'on' ? 'checked' : false);
                        return `<input type="checkbox" data-color="success" data-size="sm" class="switchery" ` + status + ` onChange="update_status($(this).is(':checked'), '` + full.nik + `')">`;
                    },

                },
                {
                    data: 'nik',
                    title: 'Nik',
                },
                {
                    data: 'username',
                    title: 'UserName',
                },
                {
                    data: 'nama_level',
                    title: 'Profil',
                },
                {
                    data: 'nama_karyawan',
                    title: 'Nama Karyawan',
                },
                {
                    data: 'nama_jabatan',
                    title: 'Jabatan',
                },
                {

                    data: "perusahaan",
                    title: 'Perusahaan',
                    searchable: false,
                    // render: function(data, type, full, meta) {
                    //     return full.singkat + ' - ' + full.lokasi;
                    // }

                },
                {
                    data: null,
                    title: 'Aksi',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return `<div class="form-group mb-0">
                        <div class="btn-group btn-group-sm">
                        <button type="button" onclick="edit_data(` + full.id_user + `,'` + full.nik + `','` + full.username + `', '` + full.id + `');" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                        </div></div>`;
                    },
                },
                {
                    data: "id",
                    title: 'id',
                    visible: false
                },

            ],
            drawCallback: function(settings, json) {
                this.api().rows().every(function(rowIdx, tableLoop, rowLoop) {
                    this.nodes().to$().find('.switchery').each(function(i, e) {
                        var switchery = new Switchery(e, {
                            color: '#26B99A'
                        })
                    })
                })
            },
            initComplete: function() {
                $("#table_data_user").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
                // this.api().rows().every(function(rowIdx, tableLoop, rowLoop) {
                //     this.nodes().to$().find('.switchery').each(function(i, e) {
                //         var switchery = new Switchery(e, {
                //             color: '#26B99A'
                //         })
                //     })
                // })
            },
        });
    }();

    function edit_data(id_user, nik, username, id) {
        console.log(id);
        $('#submit').removeAttr('disabled');
        $('.nav-tabs a:first').tab('show');
        $('#submit').html('<i class="icon-check2"></i> Update');
        $('#nik').val(nik);
        $('#username').val(username);
        $('#level').val(id);
        $('#id').val(id_user);

    }

    function update_status(value, nik) {
        var status = (value == true ? 'on' : 'off');
        loading();
        $.post("<?= base_url(); ?>kumalagroup_konfigurasi_user/update_status", {
                'status': status,
                'nik': nik,
            },
            function(data) {
                if (data == 'updates') {
                    swal("", "Data berhasil diupdate!", "success").then(function() {
                        location.reload();
                    });
                }
            },

        );
    }
</script>