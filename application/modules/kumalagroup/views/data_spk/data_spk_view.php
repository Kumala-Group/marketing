<div class="content-wrapper">
    <div class="content-body">
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?= $judul ?></h4>
                        <div class="card-body collapse in">
                            <div class="card-block font-small-2">
                                <div class="row">
                                    <form name="form_unit" id="form_unit">
                                        <div class="col-md-2 col-sm-4">
                                            <div class="form-group">
                                                <label for="tgl_awal">Dari Tanggal</label>
                                                <div class="datepicker input-group date" data-provide="datepicker">
                                                    <input type="text" name="dari_tgl" id="dari_tgl" class="center form-control" data-date-format="dd-mm-yyyy" value="<?= date('d-m-Y') ?>">
                                                    <div class="input-group-addon">
                                                        <i class="icon-calendar5"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-4">
                                            <div class="form-group">
                                                <label for="tgl_akhir">Sampai Tanggal</label>
                                                <div class="datepicker input-group date" data-provide="datepicker">
                                                    <input type="text" name="sampai_tgl" id="sampai_tgl" class="center form-control" data-date-format="dd-mm-yyyy" value="<?= Date('d-m-Y') ?>">
                                                    <div class="input-group-addon">
                                                        <i class="icon-calendar5"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-4">
                                            <div class="form-group">
                                                <label for="cabang">Cabang</label>
                                                <select name="cabang" id="cabang" class="form-control select2">
                                                    <?php foreach ($cabang as $dt) : ?>
                                                        <option value="<?= $dt->id_perusahaan ?>"><?= $dt->singkat . ' - ' . $dt->lokasi ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="col-md-2">
                                        <div class="form-actions right" style="margin-top: 25px;">
                                            <button id="cari_data" class="btn btn-primary">
                                                <i class="icon-search"></i> Cari Data
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body collapse in">
                        <div class="card-block">
                            <div class="table-responsive">
                                <div style="height: 50%;width: 100%;overflow-x: auto;overflow-y: auto;white-space: nowrap;">
                                    <table class="table table-sm table-bordered" id="tabel-data-spk">
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.datepicker').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            todayBtn: "linked",
            todayHighlight: true,
            language: 'id',
        });

        $('.select2').select2({
            placeholder: "Pilih Cabang",
        });

    });



    var datatables = $('#tabel-data-spk').DataTable({
        // scrollY: 450,
        processing: true,
        serverSide: true,
        order: [],
        // responsive: true,
        ajax: {
            url: "<?= base_url(); ?>audit/kumalagroup_data_spk/get_data_spk",
            type: 'POST',

            data: function(data) {
                data.dari_tgl = $('#dari_tgl').val();
                data.sampai_tgl = $('#sampai_tgl').val();
                data.cabang = $('#cabang').val();
            }
        },
        columns: [{
                data: null,
                title: 'No',
                width: 35,
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            {
                data: 'no_spk',
                title: 'No. SPK',
            },
            {
                data: 'tgl_spk',
                title: 'Tanggal SPK',

            },
            {
                data: 'customer',
                title: 'Customer',
            },
            {
                data: 'supervisor',
                title: 'Supervisor',
            },
            {
                data: 'sales',
                title: 'Sales',
            },
            {
                data: 'cara_bayar',
                title: 'Cara Bayar',
            },
            {
                data: 'status',
                title: 'Status',
            },
            {
                data: 'keterangan',
                title: 'Keterangan',
            },
            // {
            //     data: null,
            //     title: 'Aksi',
            //     orderable: false,
            //     searchable: false,
            //     render: function(data, type, full, meta) {
            //         var status = (full.status == '2' ? 'checked' : false);
            //         return `<input type="checkbox" ` + status + ` onChange="update_status($(this).is(':checked'), '` + full.no_pengeluaran + `')">`;
            //     },
            // }
        ]
    });

    $('#cari_data').click(function(e) {
        loading();
        datatables.ajax.reload();
    });

    function update_status(value, no_pengeluaran) {
        var status = (value == true ? '2' : '1');
        $.post("<?= base_url(); ?>audit/kumalagroup_kas_pengeluaran/set_status_cek_pengeluaran_unit_for_audit", {
                'status': status,
                'no_pengeluaran': no_pengeluaran,
            },
            function(data) {
                if (data == 'updates') {
                    swal("", "Data ini sudah di periksa!", "success").then(function() {
                        // location.reload();
                    });
                }
            },

        );
    }
</script>