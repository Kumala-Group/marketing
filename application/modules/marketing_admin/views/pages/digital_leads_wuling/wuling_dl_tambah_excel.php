<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_profil"><?= $judul ?></h5>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                        <a class="btn btn-sm btn-success" style="padding: 0.25rem 0.5rem;" href="<?php echo base_url(); ?>assets/template_excell/template_wuling_dl_customer.xlsx">
                            <i class="icon-download" style="color: #fff;"></i>
                            Download Template
                        </a>
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#view_modal_upload">
                            <i class="icon-upload" style="color: #fff;"></i>
                            Upload Data Customer
                        </button>
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block pt-1">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tab-1" id="tab-1-click">
                                    <p class="card-title m-0">Data Upload</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab-2" id="tab-2-click">
                                    <p class="card-title m-0">History Upload File</p>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content px-1 pt-1">
                            <div class="tab-pane show active" id="tab-1">
                                <form action="<?php echo base_url(); ?>digital_leads/wuling_dl_tambah_excel/simpan_upload" id="form-kirim">
                                    <div class="row">
                                        <div class="card-block pt-1">
                                            <!-- begin:: untuk hasil view import -->
                                            <div id="hasil-import" class="pt-1"></div>
                                            <!-- end:: untuk hasil view import -->
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="tab-2">
                                <div class="table-responsive">
                                    <table class="table table-sm" id="tabel-file"></table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<!-- begin:: modal-upload-excel -->
<div class="modal fade text-xs-left" id="view_modal_upload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <label class="modal-title text-text-bold-600" id="myModalLabel33">Upload Format Digital Leads</label>
            </div>
            <form action="<?php echo base_url(); ?>digital_leads/wuling_dl_tambah_excel/proses_upload" id="import-data" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pilih File Digital</label>
                        <label id="projectinput7" class="file center-block">
                            <input type="file" name="excel" id="fileToUpload">
                            <span class="file-custom"></span>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="batal" class="btn btn-sm btn-danger" data-dismiss="modal">
                        <i class="icon-close"></i>
                        Batal
                    </button>
                    <button type="submit" id="simpan" class="btn btn-sm btn-success">
                        <i class="icon-save"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end:: modal -->

<script>
    $(document).ready(function() {
        $('#tabel-file').DataTable({
            responsive: true,
            serverSide: true,
            processing: true,
            order: [],
            ajax: {
                url: "<?= base_url() ?>digital_leads/wuling_dl_tambah_excel/history_file",
                type: 'POST',
            },
            columns: [{
                    data: "id_file",
                    title: "No.",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'nama_file',
                    title: 'Nama File',
                },
                {
                    data: 'waktu_upload',
                    title: 'Waktu Upload',
                },
                {
                    data: null,
                    title: 'Aksi',
                    orderable: false,
                    searchable: false,
                    responsivePriority: -1,
                    render: function(data) {
                        return `<div class="form-group mb-0">
                    <div class="btn-group btn-group-sm">
                    <a class="btn btn-success" href="<?= base_url(); ?>assets/upload_excel/dl_wuling/${data.nama_file}"><i class="icon-save"></i> Download File</a>
                    </div></div>`;
                    },
                }
            ]
        });
    });

    var untukProsesImportData = function() {
        $(document).on('submit', '#import-data', function(e) {
            e.preventDefault();

            var ini = $(this);

            if ($('#fileToUpload').val() == '') {
                $('#fileToUpload').attr('required', 'required');
            } else {
                $.ajax({
                    method: 'POST',
                    url: ini.attr('action'),
                    data: new FormData(document.getElementById("import-data")),
                    contentType: false,
                    processData: false,
                    dataType: 'html',
                    beforeSend: function() {
                        $('#batal').attr('disabled', 'disabled');
                        $('#batal').html('<i class="icon-repeat2"></i> Tunggu...');

                        $('#simpan').attr('disabled', 'disabled');
                        $('#simpan').html('<i class="icon-repeat2"></i> Tunggu...');
                    },
                    success: function(data) {
                        $('#fileToUpload').val('');
                        $('#view_modal_upload').modal('hide');

                        $('#hasil-import').html(data);

                        $('#batal').removeAttr('disabled');
                        $('#batal').html('<i class="icon-close"></i> Batal');

                        $('#simpan').removeAttr('disabled');
                        $('#simpan').html('<i class="icon-save"></i> Simpan');
                        $('#tab-1-click').click()
                    }
                })
            }
        });
    }();

    var untukProsesSimpanData = function() {
        $(document).on('submit', '#form-kirim', function(e) {
            e.preventDefault();

            var ini = $(this);

            swal({
                    title: "Simpan Data",
                    text: "Apakah anda ingin menyimpan data ini?",
                    icon: "warning",
                    buttons: true,
                })
                .then((confirm) => {
                    if (confirm) {
                        $.ajax({
                            method: 'POST',
                            url: ini.attr('action'),
                            data: ini.serialize(),
                            dataType: 'json',
                            beforeSend: function() {
                                $('#simpan_data').attr('disabled', 'disabled');
                                $('#simpan_data').html('<i class="icon-repeat2"></i> Tunggu...');
                            },
                            success: function(data) {
                                $("#simpan_data").removeAttr('disabled');
                                $('#simpan_data').html('<i class="icon-save"></i> Simpan');
                                if (data.status) {
                                    swal("Berhasil Mengupload data", data.message, "success")
                                        .then((confirm) => {
                                            if (confirm) location.reload()
                                        });
                                } else {
                                    swal("Gagal Mengupload data", data.message, "error");
                                }
                            }
                        })
                    }
                });
        });
    }();
</script>