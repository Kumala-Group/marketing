<section>
    <div id="basic-form-layouts">
        <div class="row-match-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Laporan Biaya</h5>
                        <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body collapse in">
                        <div class="card-block pt-1 font-small-2">
                            <div class="form-body">
                                <div class="row">
                                    <form name="my_form" id="my_form" action="">
                                        <div class="col-md-2 col-sm-4">
                                            <div class="form-group">
                                                <label for="">Jenis Biaya</label>
                                                <select name="jenis_biaya" id="jenis_biaya" class="form-control" required>
                                                    <option></option>
                                                    <?php foreach ($jenis_biaya as $dt) : ?>
                                                        <option value="<?= $dt->kategori_biaya ?>"><?= $dt->kode_akun . ' - ' . $dt->nama_biaya ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-4">
                                            <div class="form-group">
                                                <label for="">Bulan</label>
                                                <select name="bulan" id="bulan" class="form-control" required>
                                                    <?php
                                                    $bln = (int) date('m');
                                                    $bulan = array(1 => "January", "February", "Maret", "April", "Mei", "juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                                                    ?>
                                                    <option value="<?php echo $bln; ?>" selected="selected"><?php echo $bulan[$bln]; ?></option>
                                                    <?php $jumlah_bulan = count($bulan);
                                                    for ($i = 1; $i <= 12; $i++) {
                                                        echo "<option value='$i'>$bulan[$i]</option>";
                                                    } ?><?php echo date('m') ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-4">
                                            <div class="form-group">
                                                <label for="">Tahun</label>
                                                <select name="tahun" id="tahun" class="form-control" required>
                                                    <?php $thn_skrng = date('Y'); ?>
                                                    <?php
                                                    for ($thn = $thn_skrng; $thn >= 2017; $thn--) {
                                                        echo '<option value="' . $thn . '">' . $thn . '</option>';
                                                    } ?>
                                                </select>
                                            </div>

                                        </div>
                                    </form>
                                    <div class="col-md-6">
                                        <div class="form-actions" style="margin-top: 25px;">
                                            <button id="cari_data" name="cari_data" class="btn btn-primary" disabled>
                                                <i class="icon-search"></i> Cari Data
                                            </button>
                                            <button id="export" name="export" class="btn btn-success" disabled>
                                                <i class="icon-print"></i> Export Excel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-header">

                                </div>
                                <div class="form-actions" style="margin-top: 50px;">
                                    <div class="table-responsive">
                                        <div style="height: 50%;width: 100%;overflow-x: auto;overflow-y: auto;white-space: nowrap;">
                                            <table class="table table-sm table-bordered" id="laporan_biaya">
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
    </div>
</section>
<script type="text/javascript">
    $('#jenis_biaya').select2({
        placeholder: "Pilih Jenis Biaya",
    });

    $('#jenis_biaya').change(function(e) {
        $('#cari_data').removeAttr('disabled');
        $('#export').removeAttr('disabled');

    });

    var datatables = $('#laporan_biaya').DataTable({
        // scrollY: 450,
        processing: true,
        serverSide: true,
        order: [],
        // responsive: true,
        ajax: {
            url: "<?= base_url(); ?>probid/kumalagroup_laporan_biaya/get_laporan_biaya",
            type: 'POST',

            data: function(data) {
                data.jenis_biaya = $('#jenis_biaya').val();
                data.tahun = $('#tahun').val();
                data.bulan = $('#bulan').val();
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
                data: 'perusahaan',
                title: 'Perusahaan',
            },
            {
                data: 'no_transaksi',
                title: 'No Transaksi',
            },
            {
                data: 'tgl_transaksi',
                title: 'Tanggal Transaksi',
            },
            {
                data: 'id_pelanggan',
                title: 'ID Pelanggan',
            },
            {
                data: 'status',
                title: 'Status',
            },
            {
                data: 'biaya',
                title: 'Biaya',
            },
            {
                data: 'keterangan',
                title: 'Keterangan',
            },
            {
                data: 'no_bku',
                title: 'No BKU',
            },
        ],
        rowsGroup: [
            'first:name',
            'second:name'
        ],
    });

    $('#cari_data').click(function(e) {
        datatables.ajax.reload();
    });

    $('#export').click(function(e) {
        e.preventDefault();
        var jenis_biaya = $('#jenis_biaya').val();
        var tahun = $('#tahun').val();
        var bulan = $('#bulan').val();

        $.ajax({
            success: function(data) {
                $("#export").html("<i class='icon-print'></i> Export Excel");
                $("#export").prop('disabled', false);
                location.replace("<?php echo site_url(); ?>probid/kumalagroup_laporan_biaya/export_excel?jenis_biaya=" + jenis_biaya + "&tahun=" + tahun + "&bulan=" + bulan);
            },
            beforeSend: function() {
                $("#export").html("Loading...");
                $("#export").prop('disabled', true);
            },
        });

    });
</script>