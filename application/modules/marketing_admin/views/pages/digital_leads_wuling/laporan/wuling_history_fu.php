<style>
    .form-check-input {
        margin-left: 0em;
        margin-top: .8em;
    }

    .form-check-label {
        margin-top: .5em;
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
                                            Tanggal Awal:
                                            <input type="date" class="form-control" name="tgl-awal" id="tgl-awal">
                                        </div>
                                        <div class="col-sm-6">
                                            Tanggal Akhir:
                                            <input type="date" class="form-control" name="tgl-akhir" id="tgl-akhir">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 border border-secondary rounded p-1">

                                    <div class="row">
                                        <div class="col-sm-6">

                                            <p>Pilih berdasarkan:</p>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p>Sales Digital:</p>
                                                    <div id="daftar-sales-digital"></div>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="col-sm-6">


                                            <p>Filter Berdasarkan:</p>
                                            <div class="row mt-1">
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
                                                <div class="col-md-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input sales-force" type="checkbox" name="sales-force" value="sales-force" id="filter-sales-force">
                                                        <label class="form-check-label" for="filter-sales-force">
                                                            Sales Force:
                                                        </label>
                                                        <div id="daftar-sales-force"></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row mt-1">
                                            <center class="col-md-12 mt-1">
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
    function input_sales() {
        $('#daftar-sales-digital').empty()
        $.ajax({
            method: 'POST',
            url: '<?= base_url() ?>digital_leads/wuling_history_fu/data_sales_digital',
            dataType: "json",
            success: function(data) {
                data.forEach(sales => {

                    $('#daftar-sales-digital').append(
                        `<div class="form-check form-check-inline">
                        <input class="form-check-input sales-digital" type="checkbox" id="sales-${sales.id}" name='sales-digital' value="${sales.id}">
                        <label class="form-check-label" for="sales-${sales.id}">${sales.nama_lengkap}</label>
                        </div>`
                    )

                });
            }
        })
    }

    function input_sales_force() {
        $('#daftar-sales-force').empty()
        $.ajax({
            method: 'POST',
            url: '<?= base_url() ?>digital_leads/wuling_history_fu/data_sales_force',
            data: `id_brand=` + $('#pilih-brand').val(),
            dataType: "json",
            success: function(data) {
                data.forEach(sales => {

                    $('#daftar-sales-force').append(
                        `<div class="form-check form-check-inline">
                        <input class="form-check-input sales-force-id" type="checkbox" id="sales-${sales.id_karyawan}" name='sales-force-id' value="${sales.id_karyawan}">
                        <label class="form-check-label" for="sales-${sales.id_karyawan}">${sales.nama_karyawan}</label>
                        </div>`
                    )

                });
            }
        })
    }

    $("#filter-sales-force").change(function(e) {
        if ($(this).prop("checked") == true) {
            input_sales_force()
        } else if ($(this).prop("checked") == false) {
            $('#daftar-sales-force').empty();
        }
    })


    $('#ambil').click(function(e) {
        e.preventDefault()
        $('#tabel-data').DataTable().ajax.reload()
    })

    $('#ekspor').click(function(e) {
        e.preventDefault()
        var sales_digital = get_filter('sales-digital')
        var spk = get_filter('spk')
        var d_o = get_filter('do')
        var sales_force_id = get_filter('sales-force-id')
        var tgl_awal = $('#tgl-awal').val()
        var tgl_akhir = $('#tgl-akhir').val()

        location.replace("<?= site_url(); ?>digital_leads/wuling_history_fu/export_excel?spk=" + spk +
            "&do=" + d_o + "&sales_digital=" + sales_digital + "&sales_force_id=" + sales_force_id +
            "&tgl_awal=" + tgl_awal + "&tgl_akhir=" + tgl_akhir);
    })

    function get_filter(class_name) {
        var filter = [];
        $('.' + class_name + ':checked').each(function() {
            filter.push($(this).val());
        });
        return filter;
    }

    $(document).ready(function() {
        input_sales()
        $('#tabel-data').DataTable({
            responsive: false,
            serverSide: true,
            processing: true,
            ajax: {
                url: "<?= base_url() ?>digital_leads/wuling_history_fu/semua_data",
                type: 'POST',
                data: function(d) {
                    if (get_filter('sales-digital')) d.sales_digital = get_filter('sales-digital')
                    if (get_filter('spk')) d.spk = get_filter('spk')
                    if (get_filter('do')) d.do = get_filter('do')
                    if (get_filter('sales-force')) d.sales_force = get_filter('sales-force')
                    if (get_filter('sales-force-id')) d.sales_force_id = get_filter('sales-force-id')
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
                    data: 'lead_source',
                    title: 'Lead Source',
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
                    data: 'id_customer_digital',
                    title: 'ID Customer Digital',
                    responsivePriority: -1,
                },
                {
                    data: 'nama_status_customer',
                    title: 'Status Customer',
                },
                {
                    data: 'nama_status_fu',
                    title: 'Status Follow Up',
                },
                {
                    data: 'lokasi',
                    title: 'Cabang',
                },
                {
                    data: 'sales_digital',
                    title: 'Sales Digital',
                },
                {
                    data: 'sales_force',
                    title: 'Sales Force',
                },
                {
                    data: 'tgl_fu',
                    title: 'Tgl Follow Up',
                    responsivePriority: -1,
                },
                {
                    data: 'tgl_spk',
                    title: 'Tgl. SPK',
                    responsivePriority: -1,
                },
                {
                    data: 'tgl_do',
                    title: 'Tgl. DO',
                    responsivePriority: -1,
                },
                {
                    data: 'id_prospek',
                    title: 'ID Prospek',
                },
            ]
        });
    });
</script>