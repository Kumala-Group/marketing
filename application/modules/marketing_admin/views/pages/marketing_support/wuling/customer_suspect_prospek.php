<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-1">Data Customer Suspect & Prospek</h5>
                    <form id="form" class="form-inline">
                        <div class="form-group m-0">
                            <input type="text" id="tanggal_awal" name="tanggal_awal" class="form-control" placeholder="Tanggal Awal" autocomplete="off" required>
                        </div>
                        <div class="form-group m-0">
                            <input type="text" id="tanggal_akhir" name="tanggal_akhir" class="form-control" placeholder="Tanggal Akhir" autocomplete="off" required>
                        </div>
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
    $('#tanggal_awal').datepicker({
        'format': 'dd-mm-yyyy'
    });
    $('#tanggal_akhir').datepicker({
        'format': 'dd-mm-yyyy'
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
                data.tanggal_awal = $('#tanggal_awal').val();
                data.tanggal_akhir = $('#tanggal_akhir').val();
                data.perusahaan = $('#perusahaan').val();
            }
        },
        columns: [{
            data: 'id_prospek',
            title: 'Id Prospek',
        }, {
            data: 'nama_karyawan',
            title: 'Sales',
        }, {
            data: 'nama',
            title: 'Customer',
        }, {
            data: 'alamat',
            title: 'Alamat',
        }, {
            data: 'status',
            title: 'Status',
        }],
    });
    $("#perusahaan").change(function() {
        if ($('#form').valid()) datatable.draw();
    });
</script>