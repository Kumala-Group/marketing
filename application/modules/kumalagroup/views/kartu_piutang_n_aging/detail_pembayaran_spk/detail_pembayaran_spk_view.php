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

<div class="modal fade text-xs-left modal_large" id="pembayaran_spk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <label class="modal-title text-text-bold-600" id="myModalLabel33">Pembayaran SPK</label>
            </div>
            <div class="modal-header">
                <div class="modal-body modal_large_body">
                    <table class="table1">
                        <tbody id="data_spk">
                        </tbody>
                    </table>
                    <br>
                    <label class="modal-title text-text-bold-600" id="myModalLabel33">Detail Transaksi</label>
                    <table class="table table-sm  table-hover table-striped">
                        <thead>
                            <tr>
                                <th class="center">Tanggal</th>
                                <th class="center">No Transaksi</th>
                                <th class="center">Keterengan</th>
                                <th class="center">Jenis Bayar</th>
                                <th class="center">Debet</th>
                                <th class="center">Kredit</th>
                            </tr>
                        </thead>
                        <tbody id="detail_spk">

                        </tbody>
                        <tfoot id="tfoot_saldo">

                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" id="alokasi_to_sales" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_sales">
                    <i class="icon-save"></i> Alokasi to Sales
                </button> -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-xs-left" id="detal_pembayaran_spk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <label class="modal-title text-text-bold-600" id="myModalLabel33">Data Transaksi</label>
            </div>

            <div class="modal-body ">
                <table class="table table-sm table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="center">Tanggal</th>
                            <th class="center">No Transaksi</th>
                            <th class="center">Cabang</th>
                            <th class="center">Keterengan</th>
                            <th class="center">Nama Akun</th>
                            <th class="center">Kode Akun</th>
                            <th class="center">Debet</th>
                            <th class="center">Kredit</th>
                        </tr>
                    </thead>
                    <tbody id="detail_spk_pembayaran">

                    </tbody>
                    <tfoot id="tfoot_saldo_pembayaran">

                    </tfoot>
                </table>
            </div>

            <div class="modal-footer">
                <!-- <button type="button" id="alokasi_to_sales" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_sales">
                    <i class="icon-save"></i> Alokasi to Sales
                </button> -->
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
            url: "<?= base_url(); ?>audit/kumalagroup_kartu_piutang_n_aging/get_detail_pembayaran_spk",
            type: 'POST',

            data: function(data) {
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
                data: 'cabang',
                title: 'Cabang',

            },
            {
                data: 'tanggal',
                title: 'Tanggal',
            },
            {
                data: 'nama_customer',
                title: 'Nama Customer',
            },
            {
                data: 'alamat_customer',
                title: 'Alamat Customer',
            },
            {
                data: null,
                title: 'Aksi',
                orderable: false,
                searchable: false,
                render: function(data, type, full, meta) {
                    return `<div class="form-group mb-0">
                        <div class="btn-group btn-group-sm">
                        <a href=#pembayaran_spk type="button" id="tes" data-toggle="modal" data-no_spk="` + full.no_spk + `" data-jenis_penjualan="` + full.jenis_penjualan + `" data-tanggal="` + full.tanggal + `" data-type="` + full.type + `" data-nama_customer="` + full.nama_customer + `" class="btn btn-info"><i class="icon-ios-compose-outline"></i></a>
                        </div></div>`;
                },
            }
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