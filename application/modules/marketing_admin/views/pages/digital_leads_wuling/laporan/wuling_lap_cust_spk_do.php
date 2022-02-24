<style>
    .form-check-input {
        margin-left: 0em;
    }
</style>

<section>
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_profil"><?= $judul ?></h5>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block pt-1">

                        <form id="form" action="" method="post">
                            <div class="row">
                                <div class="col-sm-12 border border-secondary rounded p-1">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            Tanggal Awal (SPK):
                                            <input type="date" class="form-control" name="tgl-awal" id="tgl-awal">
                                        </div>
                                        <div class="col-sm-6">
                                            Tanggal Akhir (SPK):
                                            <input type="date" class="form-control" name="tgl-akhir" id="tgl-akhir">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-6">
                                            <p>Filter Berdasarkan:</p>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input spk" type="checkbox" name="spk" value="spk" id="filter-spk">
                                                        <label class="form-check-label" for="filter-spk">
                                                            SPK
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input do" type="checkbox" name="do" value="do" id="filter-do">
                                                        <label class="form-check-label" for="filter-do">
                                                            DO
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <center class="col-md-12">
                                                <button id="ambil" class="btn btn-primary">Lihat Data</button>
                                                <button id="ekspor" class="btn btn-success">Ekspor Data</button>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-block pt-1">
                    <div class="table-responsive">
                        <table class="table table-sm" id="tabel-data"></table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    $('#ambil').click(function(e) {
        e.preventDefault()
        $('#tabel-data').DataTable().ajax.reload()
    })

    $('#ekspor').click(function(e) {
        e.preventDefault()
        var spk = get_filter('spk')
        var d_o = get_filter('do')
        var tgl_awal = $('#tgl-awal').val()
        var tgl_akhir = $('#tgl-akhir').val()

        location.replace("<?= site_url(); ?>digital_leads/wuling_lap_cust_spk_do/export_excel?spk=" + spk +
            "&do=" + d_o + "&tgl_awal=" + tgl_awal + "&tgl_akhir=" + tgl_akhir);
    })

    function get_filter(class_name) {
        var filter = [];
        $('.' + class_name + ':checked').each(function() {
            filter.push($(this).val());
        });
        return filter;
    }

    $(document).ready(function() {
        $('#tabel-data').DataTable({
            responsive: false,
            serverSide: true,
            processing: true,
            ajax: {
                url: "<?= base_url() ?>digital_leads/wuling_lap_cust_spk_do/ambil_data",
                type: 'POST',
                data: function(d) {
                    if (get_filter('spk')) d.spk = get_filter('spk')
                    if (get_filter('do')) d.do = get_filter('do')
                    if ($('#tgl-awal').val()) d.tgl_awal = $('#tgl-awal').val()
                    if ($('#tgl-akhir').val()) d.tgl_akhir = $('#tgl-akhir').val()
                }
            },
            columns: [{
                    data: null,
                    title: "No.",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'id_customer_digital',
                    title: 'ID Customer Digital',
                },
                {
                    data: 'id_prospek',
                    title: 'ID Prospek',
                },
                {
                    data: 'nama_customer_digital',
                    title: 'Nama Customer Digital',
                },
                {
                    data: 'nama_customer_cabang',
                    title: 'Nama Customer Cabang',
                },
                {
                    data: 'lokasi',
                    title: 'Cabang',
                },
                {
                    data: 'tgl_spk',
                    title: 'Tgl. SPK',
                },
                {
                    data: 'tgl_do',
                    title: 'Tgl. DO',
                },
            ]
        });
    });
</script>