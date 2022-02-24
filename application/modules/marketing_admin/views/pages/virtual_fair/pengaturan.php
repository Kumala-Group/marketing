<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_profil">Pengaturan Umum</h5>
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
                                <div class="offset-md-3 col-md-6">
                                    <form id="form" class="form">
                                        <h5 class="card-title">Diskon</h5>
                                        <div class="form-group row mb-1">
                                            <label class="col-sm-3">Tanggal</label>
                                            <div class="col-sm-9">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" name="tanggalAwal" id="tanggalAwal" placeholder="Tanggal Awal" autocomplete="off" required readonly value="<?= $data[0]->val ?>" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" name="tanggalAkhir" id="tanggalAkhir" placeholder="Tanggal Akhir" autocomplete="off" required readonly value="<?= $data[1]->val ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-1">
                                            <label class="col-sm-3">Jumlah Diskon</label>
                                            <div class="col-sm-9">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" name="persen" id="persen" onkeydown="input_number(event)" placeholder="Persen (%)" autocomplete="off" required value="<?= $data[2]->val ?>" />
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="maks" id="maks" onkeydown="input_number(event)" onkeyup="$(this).val(format_rupiah($(this).val()))" placeholder="Batas Diskon (200.000)" autocomplete="off" required value="<?= $data[3]->val ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="main_stage" value="true">
                                        <div class="form-actions center">
                                            <button id="submit" class="btn btn-primary">
                                                <i class="icon-check2"></i> Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- begin:: pengaturan background -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_profil">Pengaturan Background</h5>
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
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Login</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#main" role="tab" aria-controls="main" aria-selected="false">Main Stage</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <!-- begin:: background login -->
                                        <div class="tab-pane fade active in" id="login" role="tabpanel">
                                            <br>
                                            <div class="container-fluid">
                                                <form id="form-login" action="<?= base_url() ?>virtual_fair/pengaturan/ubah_bg_login" method="post" enctype="multipart/form-data">
                                                    <div class="form-group row mb-1">
                                                        <label class="col-sm-3">Background Login 1 (Desktop & Tablet) Version</label>
                                                        <div class="col-sm-9">
                                                            <input type="file" name="bg_login" id="bg_login" required="required" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-1">
                                                        <label class="col-sm-3">Background Login 2 (Mobile) Version</label>
                                                        <div class="col-sm-9">
                                                            <input type="file" name="bg_login_m" id="bg_login_m" required="required" />
                                                        </div>
                                                    </div>
                                                    <div class=" form-actions center">
                                                        <button type="submit" id="simpan-login" class="btn btn-primary">
                                                            <i class="icon-check2"></i> Simpan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- end:: background login -->

                                        <!-- begin:: background main stage -->
                                        <div class="tab-pane fade" id="main" role="tabpanel">
                                            <br>
                                            <div class="container-fluid">
                                                <form id="form-main-stage" action="<?= base_url() ?>virtual_fair/pengaturan/ubah_main_stage" method="post" enctype="multipart/form-data">
                                                    <div class="form-group row mb-1">
                                                        <label class="col-sm-3">Background Main Stage (Desktop & Tablet) Version</label>
                                                        <div class="col-sm-9">
                                                            <input type="file" name="bg_main" id="bg_main" required="required" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-1">
                                                        <label class="col-sm-3">Background Main Stage (Mobile) Version</label>
                                                        <div class="col-sm-9">
                                                            <input type="file" name="bg_main_m" id="bg_main_m" required="required" />
                                                        </div>
                                                    </div>
                                                    <div class="form-actions center">
                                                        <button type="submit" id="simpan-main-stage" class="btn btn-primary">
                                                            <i class="icon-check2"></i> Simpan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- end:: background main stage -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end:: pengaturan background -->
    </div>
</section>
<script>
    $('#tanggalAwal').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true
    })
    $('#tanggalAkhir').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true
    })

    $('#submit').on('click', async function(e) {
        var breakout = false;
        e.preventDefault()
        var formData = new FormData()
        formData.append('simpan', true)
        $.each($('#form').find('.form-control'), function() {
            formData.append($(this).attr('id'), $(this).val())
        })
        if (breakout) {
            return false
        } else {
            if ($('#form').valid()) {
                $(this).prop('disabled', true)
                var response = await $.ajax({
                    type: 'post',
                    url: location,
                    data: formData,
                    processData: false,
                    contentType: false
                })
                alert(response.msg)
                $(this).prop('disabled', false)
            }
        }
    })

    // untuk ubah bg login
    var untukUbahBgLogin = function() {
        $(document).on('submit', '#form-login', function(e) {
            e.preventDefault();

            var ini = $(this);

            $.ajax({
                method: ini.attr('method'),
                url: ini.attr('action'),
                data: new FormData(document.getElementById("form-login")),
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: function() {
                    $('#simpan-login').attr('disabled', 'disabled');
                    $('#simpan-login').html('<i class="icon-spinner icon-spin"></i> Tunggu...');
                },
                success: function(data) {
                    alert(data.msg);
                    location.reload();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert('Koneksi Buruk!');
                    location.reload();
                }
            })
        });
    }();

    // untuk ubah bg main stage
    var untukUbahBgMainStage = function() {
        $(document).on('submit', '#form-main-stage', function(e) {
            e.preventDefault();

            var ini = $(this);

            $.ajax({
                method: ini.attr('method'),
                url: ini.attr('action'),
                data: new FormData(document.getElementById("form-main-stage")),
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: function() {
                    $('#simpan-main-stage').attr('disabled', 'disabled');
                    $('#simpan-main-stage').html('<i class="icon-spinner icon-spin"></i> Tunggu...');
                },
                success: function(data) {
                    alert(data.msg);
                    location.reload();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert('Koneksi Buruk!');
                    location.reload();
                }
            })
        });
    }();
</script>