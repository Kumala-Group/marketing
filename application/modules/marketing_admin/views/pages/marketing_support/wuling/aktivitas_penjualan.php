<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card" style="border: 0;box-shadow: none;">
                <div class="card-header">
                    <h5 class="card-title mb-0">Data Aktivitas Penjualan</h5>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block p-0">
                        <div class="row">
                            <div class="col-md-12">
                                <form class="form_line form-inline">
                                    <div class="form-group mb-1">
                                        <select id="bulan" name="bulan" class="form-control" required>
                                            <option value="" selected disabled>-- Silahkan Pilih Bulan --</option>
                                            <?php $bulan = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                                            foreach ($bulan as $i => $v) : ?>
                                                <option value="<?= $i < 10 ? "0$i" : $i ?>"><?= $v ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <select id="tahun" name="tahun" class="form-control" required>
                                            <option value="" selected disabled>-- Silahkan Pilih Tahun --</option>
                                            <?php for ($i = date('Y'); $i >= 2017; $i--) : ?>
                                                <option value="<?= $i ?>"><?= $i ?></option>
                                            <?php endfor ?>
                                        </select>
                                    </div>
                                </form>
                                <form class="form_line form-inline">
                                    <div class="form-group mb-1">
                                        <select id="regional" name="regional" class="form-control" required>
                                            <option value="" selected disabled>-- Silahkan Pilih Regional --</option>
                                            <?php foreach ($regional as $dt) : ?>
                                                <option value="<?php echo $dt->id_team_sm; ?>"><?php echo $dt->region; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <button id="button_regional" name="button_regional" class="btn btn-info">
                                            <i class="icon-ios-eye"></i> Lihat
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div id="chart_sumber_prospek"></div>
                            </div>
                            <div class="col-md-6">
                                <div id="chart_media"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="card-title text-xs-center mb-2">Berdasarkan Sumber Prospek</h5>
                                <div id="sumber_prospek"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="card-title text-xs-center mb-2">Berdasarkan Media Motivator</h5>
                                <div id="media"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <form class="form_line form-inline">
                                    <div class="form-group mb-1">
                                        <select id="perusahaan" name="perusahaan" class="form-control" required>
                                            <option value="" selected disabled>-- Silahkan Pilih Cabang --</option>
                                            <?php foreach ($lokasi as $v) : ?>
                                                <option value="<?= $v->id_perusahaan ?>"><?= "$v->singkat - $v->lokasi" ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <button id="button_perusahaan" name="button_perusahaan" class="btn btn-info">
                                            <i class="icon-ios-eye"></i> Lihat
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div id="chart_sumber_prospek_detail"></div>
                            </div>
                            <div class="col-md-6">
                                <div id="chart_media_detail"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="card-title text-xs-center mb-2">Berdasarkan Sumber Prospek</h5>
                                <div id="sumber_prospek_detail"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="card-title text-xs-center mb-2">Berdasarkan Media Motivator</h5>
                                <div id="media_detail"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    google.charts.load('current', {
        'packages': ['corechart']
    });
    $('body').addClass('bg-white');
    $('#button_regional').click(function(e) {
        e.preventDefault();
        form = $('.form_line');
        var regional = $('#regional').val();
        var bulan = $('#bulan').val();
        var tahun = $('#tahun').val();
        if (form.valid() && regional.length != 0) {
            localStorage.setItem('saveButtonState', $(this).html());
            $(this).prop('disabled', true);
            $(this).html('<i class="icon-check2"></i> Loading...');
            $.post(location, {
                    'load_regional': true,
                    'regional': regional,
                    'bulan': bulan,
                    'tahun': tahun
                },
                function(r) {
                    $('.card').addClass('card-fullscreen');
                    var buttonState = localStorage.getItem('saveButtonState');
                    $('#button_regional').prop('disabled', false);
                    $('#button_regional').html(buttonState);

                    $('#perusahaan').html(r.cabang);
                    $('#sumber_prospek').html(r.sumber_prospek);
                    $('#media').html(r.media);
                    $('#sumber_prospek_detail').html('');
                    $('#media_detail').html('');
                    $('#chart_sumber_prospek_detail').html('');
                    $('#chart_media_detail').html('');
                    google.charts.setOnLoadCallback(chart_sumber_prospek(bulan, tahun, regional, 'chart_sumber_prospek', 'r'));
                    google.charts.setOnLoadCallback(chart_media(bulan, tahun, regional, 'chart_media', 'r'));
                }, "json"
            );
        }
    });

    $('#button_perusahaan').click(function(e) {
        e.preventDefault();
        form = $('.form_line');
        var perusahaan = $('#perusahaan').val();
        var bulan = $('#bulan').val();
        var tahun = $('#tahun').val();
        if (form.valid() && perusahaan.length != 0) {
            localStorage.setItem('saveButtonState', $(this).html());
            $(this).prop('disabled', true);
            $(this).html('<i class="icon-check2"></i> Loading...');
            $.post(location, {
                    'load_perusahaan': true,
                    'perusahaan': perusahaan,
                    'bulan': bulan,
                    'tahun': tahun
                },
                function(r) {
                    $('.card').addClass('card-fullscreen');
                    var buttonState = localStorage.getItem('saveButtonState');
                    $('#button_perusahaan').prop('disabled', false);
                    $('#button_perusahaan').html(buttonState);

                    $('#sumber_prospek_detail').html(r.sumber_prospek);
                    $('#media_detail').html(r.media);
                    google.charts.setOnLoadCallback(chart_sumber_prospek(bulan, tahun, perusahaan, 'chart_sumber_prospek_detail', 'c'));
                    google.charts.setOnLoadCallback(chart_media(bulan, tahun, perusahaan, 'chart_media_detail', 'c'));
                }, "json"
            );
        }
    });

    function chart_sumber_prospek(bln, thn, region, id, param) {
        var jsonData = $.ajax({
            type: "POST",
            url: location,
            dataType: "json",
            data: {
                load_chart_sumber_prospek: true,
                region: region,
                bln: bln,
                thn: thn,
                param: param
            },
            async: false
        }).responseText;

        // Create our data table out of JSON data loaded from server. 
        var data = new google.visualization.DataTable(jsonData);

        // Instantiate and draw our chart, passing in some options. 
        var chart = new google.visualization.PieChart(document.getElementById(id));
        chart.draw(data, {
            'title': 'Chart Sumber Prospek',
            width: 500,
            height: 400
        });
    }

    function chart_media(bln, thn, region, id, param) {
        var jsonData = $.ajax({
            type: "POST",
            url: location,
            dataType: "json",
            data: {
                load_chart_media: true,
                region: region,
                bln: bln,
                thn: thn,
                param: param
            },
            async: false
        }).responseText;

        // Create our data table out of JSON data loaded from server. 
        var data = new google.visualization.DataTable(jsonData);

        // Instantiate and draw our chart, passing in some options. 
        var chart = new google.visualization.PieChart(document.getElementById(id));
        chart.draw(data, {
            'title': 'Chart Media Motivator',
            width: 500,
            height: 400
        });
    }
</script>