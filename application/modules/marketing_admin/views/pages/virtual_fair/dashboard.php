<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_profil">Dashboard</h5>
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
                                <div class="col-lg-12">
                                    <figure class="highcharts-figure">
                                        <div id="aktivitas"></div>
                                    </figure>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <figure class="highcharts-figure">
                                        <div id="transaksi"></div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
    var options = {
        exporting: {
            enabled: false
        },
        chart: {
            type: 'spline'
        },
        title: {
            text: null
        },
        xAxis: {
            title: {
                text: 'Tanggal Bulan Berjalan'
            }
        },
        yAxis: {
            title: {
                text: null
            }
        },
        plotOptions: {
            spline: {
                lineWidth: 3,
                states: {
                    hover: {
                        lineWidth: 5
                    }
                },
                marker: {
                    enabled: false
                },
                pointStart: 1
            }
        },
        series: null
    };

    // aktivitas customer
    $.post(location, {
        aktivitas: true
    }, function(response) {
        options.title.text = 'Aktivitas Customer <?= getBulan(date('m')) . ' ' . date('Y') ?>';
        options.tooltip = {
            crosshairs: [true, true],
            formatter: function() {
                if (this.series.name == 'Registrasi') {
                    return this.x + ` <?= getBulan(date('m')) ?>
                    <br><strong>` + this.y + ' customer</strong>';
                } else {
                    return this.x + ` <?= getBulan(date('m')) ?>
                    <br><strong>Dikunjungi: ` + this.y + ' kali</strong>';
                }
            }
        };
        options.series = response;
        new Highcharts.chart('aktivitas', options);
    });

    //transaksi
    $.post(location, {
        transaksi: true
    }, function(response) {
        options.title.text = 'Transaksi Customer <?= getBulan(date('m')) . ' ' . date('Y') ?>';
        options.tooltip = {
            crosshairs: [true, true],
            formatter: function() {
                return `<strong>` + this.series.name + `</strong>
                    <br>` + this.x + ` <?= getBulan(date('m')) ?>
                    <br><strong>` + this.y + ' transaksi</strong>';
            }
        };
        options.series = response;
        new Highcharts.chart('transaksi', options);
    });
</script>