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

<div class="modal fade text-xs-left modal_large" id="detail_piutang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
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
                    <table class="table table-sm  table-hover table-striped" id="detail_table_piutang">
                        <thead>
                            <tr>
                                <th class="center">Tanggal</th>
                                <th class="center">No Transaksi</th>
                                <th class="center">Keterengan</th>
                                <th class="center">Jenis Bayar</th>
                                <th class="center">Debet</th>
                                <th class="center">Kredit</th>
                                <th class="center">Soldo</th>
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

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var datatables = $('#tabel-data-spk').DataTable({
            order: [],
            info: true,
            paging: true,
            // lengthChange: true,
            searching: true,
            // responsive: true,
            ajax: {
                url: "<?= base_url(); ?>audit/kumalagroup_kartu_piutang_n_aging/piutang_invoice",
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
                    data: 'no_transaksi',
                    title: 'No. Transaksi',
                },
                {
                    data: 'tgl',
                    title: 'Tanggal',
                },
                {
                    data: 'no_spk',
                    title: 'No. SPK',
                },
                {
                    data: 'no_rangka',
                    title: 'No. Rangka',
                },
                {
                    data: 'no_mesin',
                    title: 'No Masin',

                },
                {
                    data: 'nama_customer',
                    title: 'Customer',
                },
                {
                    data: 'alamat_customer',
                    title: 'Alamat Customer',
                },
                {
                    data: 'harga_otr',
                    title: 'Harga OTR',
                },
                {
                    data: 'spk_diskon',
                    title: 'Diskon',
                },
                {
                    data: 'leasing',
                    title: 'Leasing',
                },
                {
                    data: 'piutang',
                    title: 'Piutang',
                },
                {
                    data: null,
                    title: 'Aksi',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return `<div class="form-group mb-0">
                    <div class="btn-group btn-group-sm">
                    <a href=#detail_piutang type="button" id="tes" data-toggle="modal" data-no_transaksi="` + full.no_transaksi + `" data-no_spk="` + full.no_spk + `" data-cara_bayar="` + full.cara_bayar + `" data-tgl="` + full.tgl + `" data-nama_customer="` + full.nama_customer + `" data-type="` + full.type + `"  class="btn btn-info"><i class="icon-ios-compose-outline"></i></a>
                    </div></div>`;
                    },
                }

            ]
        });

        $('#cari_data').click(function(e) {
            loading();
            datatables.ajax.reload();
        });

        $(document).on('click', '#tes', function() {
            var no_spk = $(this).data('no_spk');
            var no_transaksi = $(this).data('no_transaksi');
            var tanggal = $(this).data('tgl');
            var nama_customer = $(this).data('nama_customer');
            var cara_bayar = $(this).data('cara_bayar');
            var type = $(this).data('type');
            var jenis_penjualan = cara_bayar == 'k' ? 'Leasing' : 'Chas';
            $('#data_spk').html('');
            $('#data_spk').append(
                "<tr>" +
                "<td>" + 'No SPK' + "</td>" +
                "<td>" + ':' + "</td>" +
                "<td>" + no_spk + "</td>" +
                "</tr>" +
                "<tr>" +
                "<td>" + 'Tanggal' + "</td>" +
                "<td >" + ':' + "</td>" +
                "<td>" + tanggal + "</td>" +
                "</tr>" +
                "<tr>" +
                "<td>" + 'Type Unit' + "</td>" +
                "<td>" + ':' + "</td>" +
                "<td>" + no_transaksi + "</td>" +
                "</tr>" +
                "<tr>" +
                "<td>" + 'Jenis Penjualan' + "</td>" +
                "<td >" + ':' + "</td>" +
                "<td>" + jenis_penjualan + "</td>" +
                "</tr>" +
                "<tr>" +
                "<td>" + 'Nama Customer' + "</td>" +
                "<td>" + ':' + "</td>" +
                "<td>" + nama_customer + "</td>" +
                "</tr>" +
                "<tr>" +
                "<td>" + 'Type' + "</td>" +
                "<td>" + ':' + "</td>" +
                "<td>" + type + "</td>" +
                "</tr>"

            );

            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>audit/kumalagroup_kartu_piutang_n_aging/detail_piutang_invoice",
                data: {
                    'no_spk': no_spk,
                    'no_transaksi': no_transaksi,
                    'cara_bayar': cara_bayar,
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
                            $debit = data[index]['debet'];
                            $kredit = data[index]['kredit'];
                            $kredit == '0' ? $saldo_v = parseInt($debit) - parseInt($kredit) : $saldo_v = $saldo_v - parseInt($kredit);
                            $('#detail_spk').append(
                                "<tr>" +
                                "<td>" + data[index]['tgl'] + "</td>" +
                                "<td>" + data[index]['no_transaksi'] + "</td>" +
                                "<td>" + data[index]['ket'] + "</td>" +
                                "<td>" + data[index]['jenis_bayar'] + "</td>" +
                                "<td>" + autoseparator(data[index]['debet']) + "</td>" +
                                "<td>" + autoseparator(data[index]['kredit']) + "</td>" +
                                "<td>" + autoseparator($saldo_v) + "</td>" +
                                "</tr>"
                            );
                        }
                        $kredit_v = 0;
                        $debit_v = 0;
                        $.each(data, function(key, value) {
                            $kredit_v += parseInt(value.kredit);
                            $debit_v += value.debet;
                            $saldo = parseInt($debit_v) - parseInt($kredit_v);

                        });
                        $('#tfoot_saldo').html(
                            "<tr>" +
                            "<td colspan='4'>" + 'Saldo' + "</td>" +
                            "<td>" + autoseparator($debit_v) + "</td>" +
                            "<td>" + autoseparator($kredit_v) + "</td>" +
                            "<td>" + autoseparator($saldo) + "</td>" +
                            "</tr>"
                        );
                    }
                }
            });
        });
    });

    function autoseparator(Num) {
        Num += '';
        Num = Num.replace('.', '');
        Num = Num.replace('.', '');
        Num = Num.replace('.', '');
        Num = Num.replace('.', '');
        Num = Num.replace('.', '');
        Num = Num.replace('.', '');
        x = Num.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        return x1 + x2;
    }
</script>