<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-1">Master Customer</h5>
                    <form id="form" class="form-inline" action="<?= base_url("marketing_support/wuling/master_customer/export") ?>" method="post">
                        <div class="form-group m-0">
                            <select id="perusahaan" name="perusahaan" class="form-control">
                                <option value="" selected>-- Semua Cabang --</option>
                                <?php foreach ($lokasi as $v) : ?>
                                    <option value="<?= $v->id_perusahaan ?>"><?= "$v->singkat - $v->lokasi" ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <button id="export" name="export" class="btn btn-success">
                            <i class="icon-share"></i> Export
                        </button>
                    </form>
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
                                        <table class="table table-sm" id="datatable" width="100%"></table>
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
                data.perusahaan = $('#perusahaan').val();
            }
        },
        columns: [{
            data: 'no_ktp',
            title: 'No. KTP',
        }, {
            data: 'nama',
            title: 'Nama Customer',
        }, {
            data: 'jenis_kelamin',
            title: 'Jemis Kelamin',
        }, {
            data: 'no_rangka',
            title: 'No. Rangka',
        }, {
            data: 'no_mesin',
            title: 'No. Mesin',
        }, {
            data: 'varian',
            title: 'Varian',
        }, {
            data: 'model',
            title: 'Model',
        }, {
            data: 'warna',
            title: 'Warna',
        }, {
            data: 'tgl_do',
            title: 'Tanggal DO',
        }],
    });
    $("#perusahaan").change(function() {
        datatable.draw();
    });
</script>