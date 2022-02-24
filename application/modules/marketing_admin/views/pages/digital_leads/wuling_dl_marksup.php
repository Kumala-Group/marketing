<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_profil"><?= $judul ?></h5>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                        <a class="btn btn-sm btn-success" style="padding: 0.25rem 0.5rem;" href="<?php echo base_url(); ?>assets/template_excell/template_digital_leads.xlsx">
                            <i class="icon-download" style="color: #fff;"></i>
                            Download Template
                        </a>
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#view_modal_upload">
                            <i class="icon-upload" style="color: #fff;"></i>
                            Upload Digital Leads
                        </button>
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block pt-1">
                        <form action="<?php echo base_url(); ?>marketing_support/wuling/simpan_upload" id="form-kirim">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tanggal_bagi_leads">Tanggal Bagi Leads</label>
                                    <input type="date" name="tanggal_bagi_leads" id="tanggal_bagi_leads" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Date Opened" data-original-title="" title="" aria-describedby="tooltip198912">
                                    <span class="red">* <h10>(wajib di isi)</h10></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tanggal_masuk_leads">Tanggal Masuk Leads</label>
                                    <input type="date" name="tanggal_masuk_leads" id="tanggal_masuk_leads" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Date Opened" data-original-title="" title="" aria-describedby="tooltip198912">
                                    <span class="red">* <h10>(wajib di isi)</h10></span>
                                </div>
                            </div>

                            <!-- begin:: untuk hasil view import -->
                            <div id="hasil-import"></div>
                            <!-- end:: untuk hasil view import -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
</section>

<!-- begin:: modal -->
<div class="modal fade text-xs-left" id="view_modal_upload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <label class="modal-title text-text-bold-600" id="myModalLabel33">Upload Format Digital Leads</label>
            </div>
            <form action="<?php echo base_url(); ?>marketing_support/wuling/proses_upload" id="import-data" enctype="multipart/form-data">
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
                    }
                })
            }
        });
    }();

    var untukProsesSimpanData = function() {
        $(document).on('submit', '#form-kirim', function(e) {
            e.preventDefault();

            var ini = $(this);

            var tanggal_bagi_leads = $('#tanggal_bagi_leads').val();
            var tanggal_masuk_leads = $('#tanggal_masuk_leads').val();

            if (tanggal_bagi_leads.length == 0) {
                $('#tanggal_bagi_leads').attr('style', 'border: 1px solid red');
                return false;
            }
            if (tanggal_masuk_leads.length === 0) {
                $('#tanggal_masuk_leads').attr('style', 'border: 1px solid red');
                return false;
            }

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
                    if (data.status == true) {
                        $("#simpan_data").removeAttr('disabled');
                        $('#simpan_data').html('<i class="icon-save"></i> Simpan');
                        alert(data.message);
                        location.reload();
                    }
                }
            })
        });
    }();
</script>