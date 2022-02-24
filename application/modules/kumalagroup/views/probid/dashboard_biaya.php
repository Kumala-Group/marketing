<section id="basic-form-layout">
    <div class="row-match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Dashboard</h5>
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
                                <div class="form-body">
                                    <div class="col-md-2 col-sm-4">
                                        <div class="form-group">
                                            <label for="">Cabang</label>
                                            <div>
                                                <select name="cabang" id="cabang" class="form-control">
                                                    <option></option>
                                                    <?php foreach ($cabang as $dt) : ?>
                                                        <option value="<?= $dt->id_perusahaan ?>"><?= $dt->singkat . ' - ' . $dt->lokasi ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
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
                                    <div class="col-md-2">
                                        <div class="form-group  ">
                                            <label for="">Type Biaya</label>
                                            <select name="detail_biaya" id="detail_biaya" class="form-control">
                                                <option value="">Pilih Type Biaya</option>
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
                                </div>
                                <div class="col-md-2">
                                    <div class="form-actions" style="margin-top: 25px;">
                                        <button id="cari_data" name="cari_data" class="btn btn-primary">
                                            <i class="icon-search"></i> Cari Data
                                        </button>

                                    </div>
                                </div>
                            </div>
                            <div class="card-header">

                            </div>
                            <div class="col-md-12" style="margin-top: 40px;">
                                <div id="container"> </div>
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
    var options = {
        chart: {
            type: null,
            renderTo: null
        },
        title: {
            text: null
        },
        exporting: {
            enabled: false
        },
        xAxis: {
            categories: null,
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: "Total Pembayaran"
            }
        },
        tooltip: {
            headerFormat: '<strong>{point.key}</strong><table>',
            pointFormat: `<tr>
                        <td style="color:{series.color};padding:0">{series.name}:</td>
                        <td style="padding:0"> <b>{point.y} </b></td>
                        </tr>`,
            footerFormat: '</table>',
            useHTML: true
        },
        plotOptions: {
            column: {
                stacking: null,
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: null
    }

    $('#cabang').select2({
        placeholder: "Pilih Cabang",
    });

    $('#jenis_biaya').select2({
        placeholder: "Pilih Jenis Biaya",
    });

    $('#jenis_biaya').change(function(e) {
        $("#detail_biaya").html('<option value="">Loading...</option>');
        var kategori_biaya = $('#jenis_biaya').val();
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: "<?= base_url() ?>probid/kumalagroup_dashboard_biaya/detail_biaya",
            data: {
                'kategori_biaya': kategori_biaya
            },
            dataType: "json",
            success: function(data) {
                $("#detail_biaya").html('<option value=""> Pilih Detail Biaya</option>');
                for (index = 0; index < data['id'].length; index++) {
                    $("#detail_biaya").append('<option value="' + data['id'][index] + '">' + data['biaya'][index] + '</option>');
                }
            }
        });
    });

    $('#cari_data').click(function() {
        var id_perusahaan = $('#cabang').val();
        var jenis_biaya = $('#jenis_biaya').val();
        var tahun = $('#tahun').val();
        var detail_biaya = $('#detail_biaya').val();
        $.ajax({
            type: "GET",
            url: "<?= base_url() ?>probid/kumalagroup_dashboard_biaya/json_chart_get_data",
            data: {
                'cabang': id_perusahaan,
                'jenis_biaya': jenis_biaya,
                'tahun': tahun,
                'detail_biaya': detail_biaya,
            },
            dataType: "json",
            success: function(data) {
                $("#cari_data").html("<i class='icon-search'></i> Cari Data");
                $("#cari_data").prop('disabled', false);
                options.chart.type = 'column'
                options.chart.renderTo = 'container'
                options.title.text = null
                options.plotOptions.column.stacking = 'normal'
                options.xAxis.categories = data.categories
                options.xAxis.title.text = null
                options.series = data.series
                new Highcharts.chart(options)
            },
            beforeSend: function() {
                $("#cari_data").html("Loading...");
                $("#cari_data").prop('disabled', true);
            },
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