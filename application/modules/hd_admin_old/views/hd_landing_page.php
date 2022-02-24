
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>
      <?php
      $jabatan = $this->session->userdata('id_jabatan');
      if ($jabatan == '45') {
          echo 'ADMIN IT | HelpDesk';
        }else {
          echo $this->session->userdata('nama_lengkap').' | HelpDesk';
        }

      ?>

    </title>
    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="<?php echo base_url();?>assets/img/favicon_kmg.png" type="image/gif">
    <!--basic styles-->
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/font-awesome.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/icon/css/font-awesome.min.css" />


    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.autocomplete.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ui.jqgrid.min.css" />
    <!--ace styles-->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace2.min.css" class="ace-main-stylesheet" id="main-ace-style" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-responsive.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-skins.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-fonts.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/app.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/custom.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/hd.css" />
    <!--<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui-1.10.3.custom.min.css" />-->
    <!--<link rel="stylesheet" href="<?php echo base_url();?>assets/css/chosen.css" />-->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/datepicker.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-timepicker.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.gritter.css" />
    <script src="<?php echo base_url();?>assets/js/jquery-1.8.2.min.js"></script>
    <!--<script src="<?php echo base_url();?>assets/js/jquery.mobile.custom.min.js"></script>-->
    <script src="https://maxcdn.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
    <!--<script src="<?php echo base_url();?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>-->
    <!--<script src="<?php echo base_url();?>assets/js/jquery.ui.touch-punch.min.js"></script>-->
    <!--<script src="<?php echo base_url();?>assets/js/chosen.jquery.min.js"></script>-->
    <!--<script src="<?php echo base_url();?>assets/js/flot/jquery.flot.resize.min.js"></script>-->
    <script src="<?php echo base_url();?>assets/js/date-time/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/date-time/bootstrap-timepicker.min.js"></script>
    <script src='<?php echo base_url();?>assets/js/jquery.autocomplete.js'></script>
    <!--<script src="<?php echo base_url();?>assets/js/jquery.jqGrid.min.js"></script>-->
        <!--Table-->
    <script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
    
    
        <!--ace scripts-->
    <script type='text/javascript' src='<?php echo base_url()?>assets/js/app.js'></script>
    <script src="<?php echo base_url();?>assets/js/jquery.gritter.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/ace-elements.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/ace.min.js"></script>
    <!--<script src="<?php echo base_url();?>assets/js/dataTables.tableTools.min.js"></script>-->
  </head>
<script type="text/javascript" src="<?php echo base_url();?>grafik/js/jquery-1.8.2.min.js"></script>
<script src="<?php echo base_url();?>grafik/js/highcharts.js"></script>
<script src="<?php echo base_url();?>grafik/js/modules/exporting.js"></script>


<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {

      /*Cek Sisa Cuti*/
      $("#modal-2").hide();

      $("#nik").keyup(function(e){
    		var isi = $(e.target).val();
    		$(e.target).val(isi.toUpperCase());
    		cari_cuti();
    	});

      function cari_cuti(){
    		var nik = $("#nik").val();

    		$.ajax({
    			type	: "POST",
    			url		: "<?php echo site_url(); ?>/cuti/cek_sisa_cuti",
    			data	: "nik="+nik,
    			dataType: "json",
    			success	: function(data){
    				$('#nama_karyawan').val(data.nama_karyawan);
    				$('#perusahaan').val(data.perusahaan);
    				$('#nama_jabatan').val(data.nama_jabatan);
    				$('#nama_brand').val(data.nama_brand);
    				$('#sisa_cuti').val(data.sisa_cuti);
            $('#id_riwayat').val(data.nik);
            var $sa = $('#id_riwayat').val(data.nik);

    			}
    		});
    	}
      /*Cek Sisa Cuti*/


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
                text: 'Grafik Laba Rugi'
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
                        name: 'Laba',
                        y: <?php echo $aktif;?>,
                        sliced: true,
                        selected: true
                    },
                    ['Rugi',<?php echo $resign;?>],

                ]
            }]
        });


        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'karyawan_masuk',
                type: 'column'
            },
            title: {
                text: ' Grafik Perkembangan per Tahun'
            },
            subtitle: {
                text: 'KUMALA MOTOR GROUP'
            },
            xAxis: {
                categories:  <?php echo json_encode($category)?>,
                title: {
                    text: 'Tahun'
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
                name: 'Jumlah pelanggan',
                data: <?php echo json_encode($karyawan);?>
            }]

        });





    });

});
</script>
<script type="text/javascript">
$(document).ready(function(){
$("#simpan").click(function(){
    var id_jenis_hardware = $("#id_jenis_hardware").val();
    var nama = $("#nama").val();

    var string = $("#my-form").serialize();



    if(nama.length==0){
        $.gritter.add({
            title: 'Peringatan..!!',
            text: 'Nama Jenis Hardware tidak boleh kosong',
            class_name: 'gritter-error'
        });

        $("#nama").focus();
        return false();
    }

    $.ajax({
        type    : 'POST',
        url     : "<?php echo site_url(); ?>hd_adm_jenis_hardware/simpan",
        data    : string,
        cache   : false,
        success : function(data){
            alert(data);
            location.reload();
        }
    });
});

$("#tambah").click(function(){
    $('#id_jenis_hardware').val('');
    $('#nama').val('');
});
});

function editData(ID){
    var cari  = ID;
    console.log(cari);
  $.ajax({
    type  : "GET",
    url   : "<?php echo site_url(); ?>hd_adm_jenis_hardware/cari",
    data  : "cari="+cari,
    dataType: "json",
    success : function(data){
      $('#id_jenis_hardware').val(data.id_jenis_hardware);
      $('#nama').val(data.nama);
    }
  });
}
</script>
  <body>
    <div id="preloader">
      <div id="loading"></div>
    </div>


      <div class="main-content">

        <div class="page-content">



<div class="row-fluid">
  <div class="span12">

    </div>
    <div class="span12 infobox-container">
      <div class="span12 infobox-container">
        <img style="width:20%;margin-top:10px;" src="<?php echo base_url();?>assets/img/logo.png"></img>
    </div>
<a href="<?php echo base_url();?>">
      <div class="infobox infobox-blue span4" style="padding-bottom:10px;">
          <div class="infobox-icon">
              <i class="icon-user"></i>
          </div>

          <div class="infobox-data">
              <span class="infobox-data-number" style="margin-bottom:0px;">
                Head Office</span>
              <div class="infobox-content" style="margin-bottom:10px;">
                <br></div>
          </div>
      </div>
</a>
      <div class="span12 infobox-container">
        <img style="width:20%;margin-top:10px;" src="<?php echo base_url();?>assets/img/wuling.png"></img>
    </div>
<a href="<?php echo base_url();?>wuling_sales_login">
      <div class="infobox infobox-red span4" style="padding-bottom:10px;">
          <div class="infobox-icon">
              <i class="icon-user"></i>
          </div>

          <div class="infobox-data">
              <span class="infobox-data-number" style="margin-bottom:0px;">
                Sales Division</span>
              <div class="infobox-content" style="margin-bottom:10px;">
                Sales, Supervisor, Sales Manager
                <br></div>
          </div>
      </div>
</a>
<div class="span12 infobox-container">
        <img style="width:20%;margin-top:10px;" src="<?php echo base_url();?>assets/img/wuling.png"></img>
    </div>
<a href="<?php echo base_url();?>wuling">
      <div class="infobox infobox-red span4">
          <div class="infobox-icon">
              <i class="icon-user"></i>
          </div>

          <div class="infobox-data">
              <span class="infobox-data-number" style="margin-top:10px;">
                Office Division</span>
              <div class="infobox-content"></div>
          </div>
      </div>
</a>
      <div class="span12 infobox-container">
        <img style="width:20%;margin-top:10px;" src="<?php echo base_url();?>assets/img/hino.png"></img>
    </div>
<a href="<?php echo base_url();?>hino_sales_login">
      <div class="infobox infobox-green span4" style="padding-bottom:10px;">
          <div class="infobox-icon">
              <i class="icon-user"></i>
          </div>

          <div class="infobox-data">
              <span class="infobox-data-number" style="margin-bottom:0px;">
                Sales Division</span>
              <div class="infobox-content" style="margin-bottom:10px;">
                Sales, Supervisor, Sales Manager
                <br></div>
          </div>
      </div>
</a>
<div class="span12 infobox-container">
        <img style="width:20%;margin-top:10px;" src="<?php echo base_url();?>assets/img/hino.png"></img>
    </div>
<a href="<?php echo base_url();?>hino">
      <div class="infobox infobox-green span4">
          <div class="infobox-icon">
              <i class="icon-user"></i>
          </div>

          <div class="infobox-data">
              <span class="infobox-data-number" style="margin-top:10px;">
                Office Division</span>
              <div class="infobox-content"></div>
          </div>
      </div>
</a>
<br>
    </div>

    
</div>
<br>

        </div><!--/.page-content-->
      </div><!--/.main-content-->
    </div><!--/.main-container-->

    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-small btn-inverse">
      <i class="icon-double-angle-up icon-only bigger-110"></i>
    </a>
  </body>

</html>