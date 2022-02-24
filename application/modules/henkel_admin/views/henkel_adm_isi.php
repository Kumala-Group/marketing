<script type="text/javascript" src="<?php echo base_url();?>grafik/js/jquery-1.8.2.min.js"></script>
<script src="<?php echo base_url();?>grafik/js/highcharts.js"></script>
<script src="<?php echo base_url();?>grafik/js/modules/exporting.js"></script>
<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {


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
                renderTo: 'grafik_penjualan',
                type: 'column'
            },
            title: {
                text: ' Grafik Penjualan'
            },
            subtitle: {
                text: 'KUMALA PUTRA PRIMA'
            },
            xAxis: {
                categories:  <?php echo json_encode($category)?>,
                title: {
                    text: 'Bulan'
                }

            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total Penjualan (Rp.)'
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
                        this.x +': '+ IDR(this.y, 'Rp. ');
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                            return ''+ IDR(this.y, 'Rp. ');
                        }
                    },
                    color:'#177c2a'
                }
            },
                series: [{
                name: 'Total Penjualan',
                data: <?php echo json_encode($tot_penjualan);?>
            }]

        });

        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'grafik_ar',
                type: 'column'
            },
            labels : {
              formatter: function() {
                return IDR(this.value, 'Rp. ');
              }
            },
            title: {
                text: ' Grafik AR Piutang'
            },
            subtitle: {
                text: 'KUMALA PUTRA PRIMA'
            },
            xAxis: {
                categories:  <?php echo json_encode($category_ar)?>,
                title: {
                    text: 'Bulan'
                }

            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total AR (Rp.)'
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
                        this.x +': '+ IDR(this.y, 'Rp. ');
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                            return ''+ IDR(this.y, 'Rp. ');
                        }
                    },
                    color:'#a7c225'
                }
            },
                series: [{
                name: 'Total AR',
                data: <?php echo json_encode($tot_ar);?>
              }
            ]

        });





    });

});
function IDR(angka,prefix){
  var number_string=angka.toString().replace(/[^,\d]/g, ''),
  split=number_string.split(','),
  sisa=split[0].length % 3,
  rupiah = split[0].substr(0, sisa),
  ribuan = split[0].substr(sisa).match(/\d{3}/gi);

  if(ribuan){
    separator= sisa ? '.' : '';
    rupiah += separator + ribuan.join('.');
  }
  rupiah=split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
  return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah :'');
}
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
                <span class="infobox-data-number"><?php echo $this->model_isi->jml_data('pelanggan');?> Data</span>
                <div class="infobox-content">Pelanggan</div>
            </div>
        </div>


        <div class="infobox infobox-red  ">
            <div class="infobox-icon">
                <i class="icon-eye-open"></i>
            </div>

            <div class="infobox-data">
                <span class="infobox-data-number"><?php echo $this->model_isi->jml_data('gudang');?> Data</span>
                <div class="infobox-content">Gudang</div>
            </div>
        </div>

        <div class="infobox infobox-purple ">
            <div class="infobox-icon">
                <i class="icon-shopping-cart"></i>
            </div>

            <div class="infobox-data">
                <span class="infobox-data-number"><?php echo $this->model_isi->jml_data('item');?> Data</span>
                <div class="infobox-content">Item</div>
            </div>
        </div>

        <div class="infobox infobox-blue  ">
            <div class="infobox-icon">
                <i class="icon-hand-right"></i>
            </div>

            <div class="infobox-data">
                <span class="infobox-data-number"><?php echo $this->model_isi->jml_data('supplier');?> Data</span>
                <div class="infobox-content">Supplier</div>
            </div>
        </div>
    </div>

    <div class="span12 infobox-container">
        <div id="grafik_penjualan" style="min-width: 400px; height: 300px;"></div>
    </div>
    <div class="span12 infobox-container">
        <div id="grafik_ar" style="min-width: 400px; height: 300px;"></div>
    </div>
</div>
