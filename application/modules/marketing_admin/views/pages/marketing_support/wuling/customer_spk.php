<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-1">Data Customer SPK</h5>
                    <form id="form" class="form-inline">
                        <div class="form-group m-0">
                            <select id="perusahaan" name="perusahaan" class="form-control" required>
                                <option value="" selected disabled>-- Silahkan Pilih Cabang --</option>
                                <?php foreach ($lokasi as $v) : ?>
                                    <option value="<?= $v->id_perusahaan ?>"><?= "$v->singkat - $v->lokasi" ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
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
            data: 'no_spk',
            title: 'No. SPK',
        }, {
            data: 'tgl_spk',
            title: 'Tanggal SPK',
        }, {
            data: 'customer',
            title: 'Customer',
        }, {
            data: 'supervisor',
            title: 'Supervisor',
        }, {
            data: 'sales',
            title: 'Sales',
        }, {
            data: 'umur',
            title: 'Umur SPK',
            orderable: false,
        }, {
            data: 'cara_bayar',
            title: 'Cara Bayar',
            orderable: false,
        }, {
            data: 'total_bayar',
            title: 'Total Bayar',
        }, {
            data: 'status',
            title: 'Status',
            searchable: false,
        }, {
            data: 'keterangan',
            title: 'Keterangan',
        }],
    });
    $("#perusahaan").change(function() {
        datatable.draw();
    });
</script>