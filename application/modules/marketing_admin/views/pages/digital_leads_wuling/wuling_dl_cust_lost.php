<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_profil"><?= $judul ?></h5>
                </div>
                <div class="card-body collapse in">
                    <div class="row">
                        <div class="card-block pt-1">
                            <div class="col-sm-6">
                                Tanggal Awal:
                                <input type="date" class="form-control" name="tgl-awal" id="tgl-awal">
                            </div>
                            <div class="col-sm-6">
                                Tanggal Akhir:
                                <input type="date" class="form-control" name="tgl-akhir" id="tgl-akhir">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <center class="col-md-12">
                            <button id="ambil" class="btn btn-primary">Lihat Data</button>
                            <button id="ekspor" class="btn btn-success">Ekspor Data</button>
                        </center>
                    </div>
                    <div class="row">
                        <div class="card-block pt-1">
                            <div class="table-responsive">
                                <table class="table table-sm" id="tabel-data"></table>
                            </div>
                        </div>
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
        var tgl_awal = $('#tgl-awal').val()
        var tgl_akhir = $('#tgl-akhir').val()

        location.replace("<?= site_url(); ?>digital_leads/wuling_dl_cust_lost/export_excel?tgl_awal=" + tgl_awal + "&tgl_akhir=" + tgl_akhir);
    })

    $(document).ready(function() {
        $('#tabel-data').DataTable({
            responsive: false,
            serverSide: true,
            processing: true,
            ajax: {
                url: "<?= base_url() ?>digital_leads/wuling_dl_cust_lost/daftar_customer_lost",
                type: 'POST',
                data: function(d) {
                    if ($('#tgl-awal').val()) d.tgl_awal = $('#tgl-awal').val()
                    if ($('#tgl-akhir').val()) d.tgl_akhir = $('#tgl-akhir').val()
                }
            },
            columns: [{
                    data: "id_dl_customer",
                    title: "No.",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'id_customer_digital',
                    title: 'ID Customer Digital',
                    responsivePriority: -1,
                },
                {
                    data: 'tgl_fu',
                    title: 'Tgl. Follow Up Terakhir',
                    responsivePriority: -1,
                },
                {
                    data: 'nama',
                    title: 'Nama',
                    responsivePriority: -1,
                },
                {
                    data: 'no_telp',
                    title: 'No. Telp',
                },
                {
                    data: 'alamat',
                    title: 'Alamat',
                },
                {
                    data: 'kota',
                    title: 'Kota/Kabupaten',
                },
                {
                    data: 'lokasi',
                    title: 'Cabang',
                },
            ]
        });
    });
</script>