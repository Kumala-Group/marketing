<style>
    .form-check-input {
        margin-left: 0em;
        margin-top: .3em;
    }

    .form-check-label {
        margin-top: .0em;
    }

    .form-check {
        margin-bottom: 0;
    }
</style>
<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_profil"><?= $judul ?></h5>
                    <div class="heading-elements">
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block pt-1">
                        <div class="row">
                            <div class="col-md-3">
                                <form id="form" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <center>
                                            <label for="">Dealer: </label><br>
                                            <select id="dealer" name="dealer[]" multiple="multiple"></select>
                                        </center>
                                    </div>
                                    <div class="form-group">
                                        <center>
                                            <label for="">Tahun & Bulan DO: </label><br>
                                            <select id="thn-bln-do" name="bln[]" multiple="multiple"></select>
                                        </center>
                                    </div>
                                </form>
                                <div class="form-group border border-secondary">
                                    <center style="padding-top: .7em;">
                                        <h4>Belum Survei</h4>
                                        <p id="nilai-belum-survei">0</p>
                                    </center>
                                </div>

                                <div class="form-group">
                                    <center>
                                        <button id="lihat" style="padding-top: .9em;" class="btn btn-warning">
                                            <h3>Lihat</h3>
                                        </button>
                                    </center>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <center>
                                            <h5>Status Survei</h5>
                                        </center><br>
                                    </div>
                                </div>
                                <div id="status_survei"></div>
                            </div>
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <center>
                                            <h5>Status Belum Survei Customer</h5>
                                        </center><br>
                                    </div>
                                    <!-- <div class="col-sm-12">
                                        <center>
                                            Urut Berdasarkan:
                                            <button id="sort-dealer" class="btn btn-sm btn-primary">Nama Dealer</button>
                                            <button id="sort-jumlah" class="btn btn-sm btn-success">Jumlah</button>
                                        </center>
                                    </div> -->
                                </div>
                                <div id="status_dealer"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-block pt-1">
                        <div class="row">
                            <div class="col-sm-12">
                                <b>Rincian Nama Customer</b>
                            </div>
                            <div class="col-sm-12">
                                <table class="table" id="table" class="display" style="width:100%"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    let status_survei
    let dealer

    function init_grafik_status_survei() {
        let list_dealer = [];
        $('.dealer:checked').each(function(i) {
            list_dealer[i] = $(this).val()
        })
        let list_thn_bln = [];
        $('.thn-bln:checked').each(function(i) {
            list_thn_bln[i] = $(this).val()
        })
        $.ajax({
            method: 'POST',
            url: '<?= base_url() ?>dashboard/wuling_ctrl_survey_do/jumlah_survei',
            dataType: "json",
            data: {
                dealer: list_dealer,
                thn_bln: list_thn_bln
            },
            success: function(data) {
                status_survei = Highcharts.chart('status_survei', {
                    credits: {
                        enabled: false
                    },
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: ''
                    },
                    tooltip: {
                        pointFormat: '<b>{point.y}</b><br>({point.percentage:.1f}%)'
                    },
                    accessibility: {
                        point: {
                            valueSuffix: '%'
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                distance: -45,
                                format: '<b>{point.y}</b><br>({point.percentage:.1f}%)'
                            },
                            showInLegend: true
                        }
                    },
                    legend: {
                        enabled: true,
                        layout: 'horizontal',
                        verticalAlign: 'bottom',
                        adjustChartSize: true
                    },
                    series: [{
                        minPointSize: 10,
                        innerSize: '40%',
                        zMin: 0,
                        colorByPoint: true,
                        data: [{
                            name: 'Belum',
                            y: data.belum,
                        }, {
                            name: 'Selesai',
                            y: data.selesai
                        }]
                    }]
                });
                $('#nilai-belum-survei').html(data.belum)
                init_grafik_dealer()
            }
        })
    }

    function update_grafik_status_survei() {
        let list_dealer = [];
        $('.dealer:checked').each(function(i) {
            list_dealer[i] = $(this).val()
        })
        let list_thn_bln = [];
        $('.thn-bln:checked').each(function(i) {
            list_thn_bln[i] = $(this).val()
        })
        $.ajax({
            method: 'POST',
            url: '<?= base_url() ?>dashboard/wuling_ctrl_survey_do/jumlah_survei',
            dataType: "json",
            data: {
                dealer: list_dealer,
                thn_bln: list_thn_bln
            },
            success: function(data) {
                status_survei.update({
                    series: [{
                        data: [{
                            name: 'Belum',
                            y: data.belum,
                        }, {
                            name: 'Selesai',
                            y: data.selesai
                        }]
                    }]
                })
                $('#nilai-belum-survei').html(data.belum)
                // update_grafik_dealer()
            }
        })
    }

    function init_grafik_dealer() {
        let list_dealer = [];
        $('.dealer:checked').each(function(i) {
            list_dealer[i] = $(this).val()
        })
        let list_thn_bln = [];
        $('.thn-bln:checked').each(function(i) {
            list_thn_bln[i] = $(this).val()
        })
        $.ajax({
            method: 'POST',
            url: '<?= base_url() ?>dashboard/wuling_ctrl_survey_do/data_survei_dealer',
            dataType: "json",
            data: {
                dealer: list_dealer,
                thn_bln: list_thn_bln
            },
            success: function(data) {
                let graphWidth = 500;
                if (data.nama_dealer.length < 15) graphWidth = 400
                if (data.nama_dealer.length < 10) graphWidth = 300
                if (data.nama_dealer.length < 5) graphWidth = 200

                dealer = Highcharts.chart('status_dealer', {
                    chart: {
                        type: 'bar',
                        events: {
                            load: function() {
                                var points = this.series[0].points,
                                    chart = this,
                                    newPoints = [];

                                Highcharts.each(points, function(point, i) {
                                    point.update({
                                        name: data.nama_dealer[i]
                                    }, false);
                                    newPoints.push({
                                        x: point.x,
                                        y: point.y,
                                        name: point.name
                                    });
                                });
                                chart.redraw();

                                // Sorting A - Z
                                $('#sort-1').on('click', function() {
                                    newPoints.sort(function(a, b) {
                                        if (a.name < b.name)
                                            return -1;
                                        if (a.name > b.name)
                                            return 1;
                                        return 0;
                                    });

                                    Highcharts.each(newPoints, function(el, i) {
                                        el.x = i;
                                    });

                                    chart.series[0].setData(newPoints, true, false, false);
                                });

                                // Sorting min - max
                                $('#sort-1').on('click', function() {
                                    newPoints.sort(function(a, b) {
                                        return a.y - b.y
                                    });

                                    Highcharts.each(newPoints, function(el, i) {
                                        el.x = i;
                                    });

                                    chart.series[0].setData(newPoints, true, false, false);
                                });

                                // Sorting max - min
                                $('#sort3').on('click', function() {
                                    newPoints.sort(function(a, b) {
                                        return b.y - a.y
                                    });

                                    Highcharts.each(newPoints, function(el, i) {
                                        el.x = i;
                                    });

                                    chart.series[0].setData(newPoints, true, false, false);
                                });
                            }
                        }
                    },
                    title: {
                        text: '',
                    },
                    subtitle: {
                        text: ''
                    },
                    xAxis: {
                        type: 'category'
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Belum',
                            align: 'high'
                        },
                        labels: {
                            overflow: 'justify'
                        }
                    },
                    tooltip: {
                        valueSuffix: ''
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: -40,
                        y: 80,
                        floating: true,
                        borderWidth: 1,
                        backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                        shadow: true
                    },
                    plotOptions: {
                        series: {
                            dataLabels: {
                                enabled: true,
                            }
                        }
                    },
                    credits: {
                        enabled: false
                    },
                    series: [{
                        showInLegend: false,
                        data: data.jumlah_survei
                    }]
                });
                dealer.setSize(400, graphWidth - (data.nama_dealer.length * 2));
            }
        })
    }

    function update_grafik_dealer() {
        let list_dealer = [];
        $('.dealer:checked').each(function(i) {
            list_dealer[i] = $(this).val()
        })
        let list_thn_bln = [];
        $('.thn-bln:checked').each(function(i) {
            list_thn_bln[i] = $(this).val()
        })
        $.ajax({
            method: 'POST',
            url: '<?= base_url() ?>dashboard/wuling_ctrl_survey_do/data_survei_dealer',
            dataType: "json",
            data: {
                dealer: list_dealer,
                thn_bln: list_thn_bln
            },
            success: function(data) {
                let graphWidth = 600;
                if (data.nama_dealer.length < 15) graphWidth = 500
                if (data.nama_dealer.length < 10) graphWidth = 400
                if (data.nama_dealer.length < 5) graphWidth = 300

                dealer.update({
                    xAxis: {
                        categories: data.nama_dealer,
                        title: {
                            text: null
                        }
                    },
                    series: [{
                        data: data.jumlah_survei
                    }]
                });
                dealer.setSize(400, graphWidth - (data.nama_dealer.length * 2));
            }
        })
    }

    function input_thn_bln() {
        $.ajax({
            method: 'POST',
            url: '<?= base_url() ?>dashboard/wuling_ctrl_survey_do/get_thn_bln_do',
            dataType: "json",
            success: function(data) {
                let options = [];
                data.forEach(dt => {
                    options.push({
                        class: 'thn-bln',
                        label: `${dt.tahun} - ${dt.bulan}`,
                        title: `${dt.tahun} - ${dt.bulan}`,
                        value: dt.tahun_bulan,
                        selected: true
                    })
                });
                $('#thn-bln-do').multiselect('dataprovider', options);
                init_grafik_status_survei()
            }
        })
    }

    function input_dealer() {
        $.ajax({
            method: 'POST',
            url: '<?= base_url() ?>dashboard/wuling_ctrl_survey_do/get_dealer',
            dataType: "json",
            success: function(data) {
                let options = [];
                data.forEach(dt => {
                    options.push({
                        class: 'dealer',
                        label: dt.lokasi,
                        title: dt.lokasi,
                        value: dt.id_perusahaan,
                        selected: true
                    })
                });
                $('#dealer').multiselect('dataprovider', options);
                input_thn_bln()
            }
        })
    }


    $('#lihat').click(function(e) {
        e.preventDefault()
        update_grafik_status_survei()
        update_grafik_dealer()

        $('#table').DataTable().ajax.reload()
    })

    $('#sort-dealer').click(function(e) {
        e.preventDefault()
        dealer.update({
            dataSorting: {
                enabled: true,
                //sortKey: 'value',
                matchByName: true
            }
        })
    })


    $(document).ready(function() {
        input_dealer()

        $('#table').DataTable({
            responsive: false,
            serverSide: true,
            processing: true,
            ajax: {
                url: "<?= base_url() ?>dashboard/wuling_ctrl_survey_do/data_customer",
                type: 'POST',
                data: function(d) {
                    let list_dealer = [];
                    $('.dealer:checked').each(function(i) {
                        list_dealer[i] = $(this).val()
                    })
                    d.dealer = list_dealer
                    let list_thn_bln = [];
                    $('.thn-bln:checked').each(function(i) {
                        list_thn_bln[i] = $(this).val()
                    })
                    d.thn_bln = list_thn_bln
                }
            },
            columns: [{
                    data: "id_prospek",
                    title: "No.",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'tgl_do',
                    title: 'Tanggal DO',
                },
                {
                    data: 'nama_customer',
                    title: 'Nama Customer',
                },
                {
                    data: 'dealer',
                    title: 'Dealer',
                },
                {
                    data: 'nama_sales',
                    title: 'Nama Sales',
                },
            ]
        });

        const multiselect_props = {
            enableFiltering: true,
            includeFilterClearBtn: false,
            templates: {
                filter: `<div class="multiselect-filter">
                            <div class="input-group input-group-sm p-1">
                                <div class="input-group-prepend">
                                </div><input class="form-control multiselect-search" type="text" />
                            </div>
                        </div>`
            },
            includeSelectAllOption: true,
            enableCaseInsensitiveFiltering: true,
        }
        $('#dealer').multiselect(multiselect_props);
        $('#thn-bln-do').multiselect(multiselect_props);
    });
</script>