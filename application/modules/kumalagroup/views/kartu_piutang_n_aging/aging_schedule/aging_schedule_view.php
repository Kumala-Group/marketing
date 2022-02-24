<style>
    .table1,
    td {
        padding: 5px 10px;
        /* text-align: center; */
    }

    .modal-lg {
        max-width: 70% !important;
    }
</style>
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
                                        <div class="col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <select name="cabang" id="cabang" class="form-control select2">
                                                    <option value=""></option>
                                                    <?php foreach ($cabang as $dt) : ?>
                                                        <option value="<?= $dt->id_perusahaan ?>"><?= $dt->singkat . ' - ' . $dt->lokasi ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-4">
                                            <div class="form-group">
                                                <div class="datepicker input-group date" data-provide="datepicker">
                                                    <input type="text" name="tanggal" id="tanggal" class="center form-control" data-date-format="dd-mm-yyyy" value="<?= date('d-m-Y') ?>">
                                                    <div class="input-group-addon">
                                                        <i class="icon-calendar5"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="form-actions right">
                                                <button id="cari_data" class="btn btn-primary">
                                                    <i class="icon-search"></i> Cari Data
                                                </button>
                                            </div>
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
                                    <table class="table table-sm table-bordered" id="tabel-aging-schedule">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="center">No. SPK</th>
                                                <th rowspan="2" class="center span2">Tanggal SPK </th>
                                                <th rowspan="2" class="center">No Invoice</th>
                                                <th rowspan="2" class="center">Tanggal Invoice</th>
                                                <th rowspan="2" class="center">Nama Customer / Nama STNK </th>
                                                <th rowspan="2" class="center">Jenis Penjualan</th>
                                                <th rowspan="2" class="center">HG Unit</th>
                                                <th rowspan="2" class="center">Disc</th>
                                                <th rowspan="2" class="center">Nilai Invoice</th>
                                                <th rowspan="2" class="center">Current</th>
                                                <th class="center">OD 1</th>
                                                <th class="center">OD 2</th>
                                                <th class="center">OD 3</th>
                                                <th class="center">OD 4</th>
                                                <th rowspan="2" class="center">Aksi</th>
                                            </tr>
                                            <tr>
                                                <th class="center">1-30HR</th>
                                                <th class="center">31-60HR</th>
                                                <th class="center">61-90HR</th>
                                                <th class="center">90HR></th>
                                            </tr>
                                        </thead>
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
            placeholder: "--- Pilih Cabang ---",
        });

    });



    var datatables = $('#tabel-aging-schedule').DataTable({
        // scrollY: 450,
        processing: true,
        serverSide: true,
        order: [],
        // responsive: true,
        ajax: {
            url: "<?= base_url(); ?>audit/kumalagroup_kartu_piutang_n_aging/get_aging_schedule",
            type: 'POST',
            data: function(data) {
                data.tanggal = $('#tanggal').val();
                data.cabang = $('#cabang').val();
            }
        },
        columns: [{
                data: 'no_spk'
            },
            {
                data: 'tanggal_spk',
            },
            {
                data: 'no_invoice',
            },
            {
                data: 'tanggal_invoice',
            },
            {
                data: 'nama_cutomer_stnk',
            },
            {
                data: 'jenis_penjualan',
            },
            {
                data: 'hg_unit',
            },
            {
                data: 'disc',
            },
            {
                data: 'nilai_invoice',
            },
            {
                data: 'current',
            },
            {
                data: '1_30hr',

            },
            {
                data: '31_60hr',

            },
            {
                data: '61_90hr',

            },
            {
                data: '90hr_',

            },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function(data, type, full, meta) {
                    var status = (full.status == '2' ? 'checked' : false);
                    return `<input type="checkbox" ` + status + ` onChange="update_status($(this).is(':checked'), '` + full.no_pengeluaran + `')">`;
                },
            }
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
    $(document).on('click', '#tes', function() {
        var no_spk = $(this).data('no_spk')
        var jenis_penjualan = $(this).data('jenis_penjualan')
        var tanggal = $(this).data('tanggal')
        var nama_customer = $(this).data('nama_customer')
        var type = $(this).data('type')

        $('#data_spk').html('');
        $('#data_spk').append(
            "<tr>" +
            "<td>" + 'No SPK' + "</td>" +
            "<td>" + ':' + "</td>" +
            "<td>" + no_spk + "</td>" +
            "</tr>" +
            "<tr>" +
            "<td>" + 'Nama Customer' + "</td>" +
            "<td>" + ':' + "</td>" +
            "<td>" + nama_customer + "</td>" +
            "</tr>" +
            "<tr>" +
            "<td>" + 'Tanggal' + "</td>" +
            "<td >" + ':' + "</td>" +
            "<td>" + tanggal + "</td>" +
            "</tr>" +
            "<tr>" +
            "<td>" + 'Jenis Penjualan' + "</td>" +
            "<td >" + ':' + "</td>" +
            "<td>" + jenis_penjualan + "</td>" +
            "</tr>" +
            "<tr>" +
            "<td>" + 'Type Unit' + "</td>" +
            "<td>" + ':' + "</td>" +
            "<td>" + type + "</td>" +
            "</tr>"

        );

        $.ajax({
            type: "GET",
            url: "<?= base_url() ?>audit/kumalagroup_kartu_piutang_n_aging/detail_penerimaan_unit",
            data: {
                'no_spk': no_spk,
            },
            dataType: "json",
            success: function(data) {
                $('#detail_spk').html('');
                $('#tfoot_saldo').empty();
                if (!$.trim(data)) {
                    $('#detail_spk').html('');
                    $('#tfoot_saldo').empty();
                } else {
                    for (var index = 0; index < data.length; index++) {
                        $('#detail_spk').append(
                            "<tr>" +
                            "<td>" + data[index]['tanggal'] + "</td>" +
                            "<td>" + "<span style='font-weight: 900;color: brown;cursor: pointer;' id='detal_pembayaran' data-no_penerimaan='" + data[index]['no_penerimaan'] + "' data-journal='' class='show_trans'>" + data[index]['no_penerimaan'] + "</td>" +
                            "<td>" + data[index]['keterangan'] + "</td>" +
                            "<td>" + data[index]['jenis_bayar'] + "</td>" +
                            "<td>" + data[index]['debit'] + "</td>" +
                            "<td>" + data[index]['kredit'] + "</td>" +
                            "</tr>"
                        );
                    }
                    $.each(data, function(key, value) {
                        $saldo = value.saldo;
                        $debit = value.debit;
                        $name = value.name_saldo;
                    });
                    $('#tfoot_saldo').html(
                        "<tr>" +
                        "<td colspan='4'>" + $name + "</td>" +
                        "<td>" + $debit + "</td>" +
                        "<td>" + $saldo + "</td>" +
                        "</tr>"
                    );
                }
            }
        });
    });

    $(document).on('click', '#detal_pembayaran', function() {
        var no_penerimaan = $(this).data('no_penerimaan');
        $('#pembayaran_spk').modal('hide');
        $('#detal_pembayaran_spk').modal('show');
        $.ajax({
            type: "GET",
            url: "<?= base_url() ?>audit/kumalagroup_kartu_piutang_n_aging/penerimaan_buku_besar",
            data: {
                'no_penerimaan': no_penerimaan,
            },
            dataType: "json",
            success: function(data) {
                $('#detail_spk_pembayaran').html('');
                $('#tfoot_saldo_pembayaran').empty();
                if (!$.trim(data)) {
                    $('#detail_spk_pembayaran').html('');
                    $('#tfoot_saldo_pembayaran').empty();
                } else {
                    for (var index = 0; index < data.length; index++) {

                        $('#detail_spk_pembayaran').append(
                            "<tr>" +
                            "<td>" + data[index]['tanggal'] + "</td>" +
                            "<td>" + data[index]['no_transaksi'] + "</td>" +
                            "<td>" + data[index]['cabang'] + "</td>" +
                            "<td>" + data[index]['keterangan'] + "</td>" +
                            "<td>" + data[index]['nama_akun'] + "</td>" +
                            "<td>" + data[index]['kode_akun'] + "</td>" +
                            "<td>" + data[index]['debit'] + "</td>" +
                            "<td>" + data[index]['kredit'] + "</td>" +
                            "</tr>"

                        );

                    }
                    $.each(data, function(key, value) {
                        $debit = value.total_debit;
                        $kredit = value.total_kredit;
                    });
                    $('#tfoot_saldo_pembayaran').html(
                        "<tr>" +
                        "<td colspan='6'></td>" +
                        "<td>" + $debit + "</td>" +
                        "<td>" + $kredit + "</td>" +
                        "</tr>"
                    );
                }
            }
        });
    });
</script>