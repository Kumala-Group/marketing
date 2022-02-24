<script type="text/javascript" src="<?php echo base_url();?>grafik/js/jquery-1.8.2.min.js"></script>
<script src="<?php echo base_url();?>grafik/js/highcharts.js"></script>
<script src="<?php echo base_url();?>grafik/js/modules/exporting.js"></script>
<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
      $('#floatingBarsG').hide();
      /*Cek Sisa Cuti*/
      $("#modal-2").hide();


         Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
            ]
        };
    });

    chart = new Highcharts.Chart({
            chart: {
                renderTo: 'status',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Grafik Status Karyawan Per <?php echo date('Y');?>'
            },
            subtitle: {
                text: 'KUMALA MOTOR GROUP'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage}%</b>',
                percentageDecimals: 1
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage, 1) +' %';
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Karyawan',
                data: [
                    {
                        name: 'Aktif',
                        y: <?php echo $aktif;?>,
                        sliced: true,
                        selected: true
                    },
                    ['Resign',<?php echo $resign;?>],
                    ['HK',<?php echo $habis_kontrak;?>],

                ]
            }]
        });


        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'karyawan_masuk',
                type: 'column'
            },
            title: {
                text: ' Grafik Karyawan Masuk per <?php echo date('Y');?>'
            },
            subtitle: {
                text: 'KUMALA MOTOR GROUP'
            },
            xAxis: {
                categories:  <?php echo json_encode($category);?>,
                title: {
                    text: 'Bulan'
                }

            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah (Karyawan)'
                }
            },
            legend: {
                layout: 'vertical',
                backgroundColor: '#FFFFFF',
                align: 'left',
                verticalAlign: 'top',
                x: 100,
                y: 70,
                floating: true,
                shadow: true
            },
            tooltip: {
                formatter: function() {
                    return ''+
                        this.x +': '+ this.y +' orang';
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true
                    }
                }
            },
                series: [{
                name: 'Jumlah Karyawan',
                data: <?php echo json_encode($karyawan);?>
            }]

        });





    });

});
</script>



<div class="row-fluid">
	<div class="span12">

    </div>
    <div class="span12 infobox-container">
        <div class="infobox infobox-green  ">
            <div class="infobox-icon">
                <i class="icon-group"></i>
            </div>

            <div class="infobox-data">
                <span class="infobox-data-number"><?php echo $this->model_corp->jml_data('admins');?> Data</span>
                <div class="infobox-content">Pengguna</div>
            </div>
        </div>


        <div class="infobox infobox-red  ">
            <div class="infobox-icon">
                <i class="icon-eye-open"></i>
            </div>

            <div class="infobox-data">
                <span class="infobox-data-number"><?php echo $this->model_corp->jml_all_karyawan();?> Data</span>
                <div class="infobox-content">Karyawan</div>
            </div>
        </div>

        <div class="infobox infobox-purple ">
            <div class="infobox-icon">
                <i class="icon-shopping-cart"></i>
            </div>

            <div class="infobox-data">
                <span class="infobox-data-number"><?php echo $this->model_corp->jml_data('brand');?> Data</span>
                <div class="infobox-content">Brand</div>
            </div>
        </div>

        <div class="infobox infobox-blue  ">
            <div class="infobox-icon">
                <i class="icon-hand-right"></i>
            </div>

            <div class="infobox-data">
                <span class="infobox-data-number"><?php echo $this->model_corp->jml_data('perusahaan');?> Data</span>
                <div class="infobox-content">Cabang</div>
            </div>
        </div>
    </div>
    <div style="margin-top: 150px;">
        <div id="karyawan_masuk" class="span6" style="min-width: 400px; height: 400px;"></div>
        <div id="status" class="span5" style="min-width: 380px; height: 380px;"></div>
    </div>
</div>
<br />