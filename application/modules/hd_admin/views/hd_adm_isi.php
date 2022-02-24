<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<!--
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
-->
<?php
$jabatan = $this->session->userdata('id_jabatan');
$divisi = $this->session->userdata('id_divisi');
if ($jabatan == '45' || $divisi == '3') {
?>
    <div class="row-fluid">
        <div class="span12">

        </div>
        <div class="span12 infobox-container">
    <a href="<?php echo base_url();?>hd_adm_n_baru">
        <div class="infobox infobox-black">
            <div class="infobox-icon">
                <i class="icon-user"></i>
            </div>

            <div class="infobox-data">
                <span class="infobox-data-number">
                    <?php
                    echo $this->model_isi->n_baru();
                    ?>
                    Karyawan</span>
                <div class="infobox-content">Perlu Didaftarkan!</div>
            </div>
        </div>
    </a>
    <a href="<?php echo base_url();?>hd_adm_n_tiket">
        <div class="infobox infobox-purple">
            <div class="infobox-icon">
                <i class="icon-question-sign"></i>
            </div>

            <div class="infobox-data">
                <span class="infobox-data-number">
                    <?php
                    $n_nik = $this->session->userdata('username');
                    echo $this->model_isi->n_tiket($n_nik);
                    ?>
                    Tiket</span>
                <div class="infobox-content">Perlu Tindak Lanjut!</div>
            </div>
        </div>
    </a>
    <a href="<?php echo base_url();?>hd_adm_absensi">
            <div class="infobox infobox-green  ">
                <div class="infobox-icon">
                    <i class="icon-thumbs-up"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?php echo $this->model_isi->statusOK();?> Cabang</span>
                    <div class="infobox-content">OK</div>
                </div>
            </div>


            <div class="infobox infobox-red  ">
                <div class="infobox-icon">
                    <i class="icon-warning-sign"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?php echo $this->model_isi->statusTROUBLE();?> Cabang</span>
                    <div class="infobox-content">TROUBLE</div>
                </div>
            </div>

            <div class="infobox infobox-grey ">
                <div class="infobox-icon">
                    <i class="icon-eye-close"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?php echo $this->model_isi->statusNO();?> Cabang</span>
                    <div class="infobox-content">NO DATA</div>
                </div>
            </div>
            </a>
        </div>
        <div class="span12">
        <?php
$datestring= date('Y-m-d', strtotime(date('Y-m')));
$date=date_create($datestring);

$total = $this->model_isi->pengaduan_total_bulan();
$open = $this->model_isi->pengaduan_open_bulan();
$working = $this->model_isi->pengaduan_working_bulan();
$pending = $this->model_isi->pengaduan_pending_bulan();
$solved = $this->model_isi->pengaduan_solved_bulan();

        ?>
        <h3 align="center">
            Laporan Pengaduan <?php echo $date->format('M Y');?>
        </h3>
        </div>
    <div class="span12 infobox-container">
        <div class="infobox infobox-black">
            <div class="infobox-icon">
                <i class="icon-plus"></i>
            </div>

            <div class="infobox-data">
                <span class="infobox-data-number"><?php echo $total?> Pengaduan</span>
                <div class="infobox-content">Total Pengaduan</div>
            </div>
        </div>
    <div class="infobox infobox-purple">
        <div class="infobox-icon">
            <i class="icon-time"></i>
        </div>

        <div class="infobox-data">
            <span class="infobox-data-number"><?php echo $open?> Open</span>
            <div class="infobox-content">Pengaduan Diterima</div>
        </div>
    </div>
    <div class="infobox infobox-green  ">
        <div class="infobox-icon">
            <i class="icon-refresh"></i>
        </div>

        <div class="infobox-data">
            <span class="infobox-data-number"><?php echo $working?> Working</span>
            <div class="infobox-content">Pengaduan Dikerjakan</div>
        </div>
    </div>
    <div class="infobox infobox-red  ">
        <div class="infobox-icon">
            <i class="icon-warning-sign"></i>
        </div>

        <div class="infobox-data">
            <span class="infobox-data-number"><?php echo $pending?> Pending</span>
            <div class="infobox-content">Pengaduan Ditunda</div>
        </div>
    </div>
    <div class="infobox infobox-blue ">
        <div class="infobox-icon">
            <i class="icon-ok"></i>
        </div>

        <div class="infobox-data">
            <span class="infobox-data-number"><?php echo $solved?> Solved</span>
            <div class="infobox-content">Pengaduan Selesai</div>
        </div>
    </div>

    </div>
    <div class="row-fluid">  
    <div id="container1" style="width:100%; height:400px;" class="span12"></div>
    <div id="container2" style="width:100%; height:400px;" class="span12"></div>
    <div id="container3" style="height:400px;" class="span3"></div>
    <div class="span1"></div>
    <div id="container4" style="height:400px;" class="span3"></div>
    <div class="span1"></div>
    <div id="container5" style="height:400px;" class="span3"></div>
    <div id="container6" style="width:100%; height:400px;" class="span12"></div>
</div>
    
<?php
} else {
    $n_nik = $this->session->userdata('username');
?>
<div class="row-fluid">
    <div class="span12">
        
    </div>
    <div class="span12 infobox-container">
    <div class="infobox infobox-black">
        <div class="infobox-icon">
            <i class="icon-plus"></i>
        </div>

        <div class="infobox-data">
            <span class="infobox-data-number"><?php echo $this->model_isi->pengaduan_total($n_nik);?> Pengaduan</span>
            <div class="infobox-content">Total Pengaduan</div>
        </div>
    </div>
    <div class="infobox infobox-purple">
        <div class="infobox-icon">
            <i class="icon-time"></i>
        </div>

        <div class="infobox-data">
            <span class="infobox-data-number"><?php echo $this->model_isi->pengaduan_open($n_nik);?> Open</span>
            <div class="infobox-content">Pengaduan Diterima</div>
        </div>
    </div>
    <div class="infobox infobox-green  ">
        <div class="infobox-icon">
            <i class="icon-refresh"></i>
        </div>

        <div class="infobox-data">
            <span class="infobox-data-number"><?php echo $this->model_isi->pengaduan_working($n_nik);?> Working</span>
            <div class="infobox-content">Pengaduan Dikerjakan</div>
        </div>
    </div>
    <div class="infobox infobox-red  ">
        <div class="infobox-icon">
            <i class="icon-warning-sign"></i>
        </div>

        <div class="infobox-data">
            <span class="infobox-data-number"><?php echo $this->model_isi->pengaduan_pending($n_nik);?> Pending</span>
            <div class="infobox-content">Pengaduan Ditunda</div>
        </div>
    </div>
    <div class="infobox infobox-blue ">
        <div class="infobox-icon">
            <i class="icon-ok"></i>
        </div>

        <div class="infobox-data">
            <span class="infobox-data-number"><?php echo $this->model_isi->pengaduan_solved($n_nik);?> Solved</span>
            <div class="infobox-content">Pengaduan Selesai</div>
        </div>
    </div>
</div>

<?php
}
?>


<script>
//Pie Status Pengaduan 1
Highcharts.chart('container1', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Grafik Pengaduan <?php echo $date->format('M Y');?>'
    },
    subtitle: {
        text: 'KUMALA MOTOR GROUP'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                connectorColor: 'silver'
            }
        }
    },
    series: [{
        name: 'Persentase Status',
        data: [
            { name: 'Open', y:<?php echo $this->model_isi->pengaduan_open_bulan();?>},
            { name: 'Working', y:<?php echo $this->model_isi->pengaduan_working_bulan();?>},
            { name: 'Pending', y:<?php echo $this->model_isi->pengaduan_pending_bulan();?>},
            { name: 'Solved', y:<?php echo $this->model_isi->pengaduan_solved_bulan();?>},
            { name: 'Cancel', y: <?php echo $this->model_isi->pengaduan_cancel_bulan();?>}
        ]
    }]
});

//Kolom Status Type 2
<?php
    $type = $this->model_isi->pengaduan_type();
    $open_type = $this->model_isi->pengaduan_open_type();
    $working_type = $this->model_isi->pengaduan_working_type();
    $pending_type = $this->model_isi->pengaduan_pending_type();
    $solved_type = $this->model_isi->pengaduan_solved_type();
    $cancel_type = $this->model_isi->pengaduan_cancel_type(); 
?>
Highcharts.chart('container2', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Pengaduan <?php echo $date->format('M Y');?>'
    },
    subtitle: {
        text: 'KUMALA MOTOR GROUP'
    },
    xAxis: {
        categories: <?php echo json_encode($type);?>,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Jumlah Pengaduan'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Open',
        data: <?php echo json_encode($open_type)?>
    }, {
        name: 'Working',
        data: <?php echo json_encode($working_type)?>
    }, {
        name: 'Pending',
        data: <?php echo json_encode($pending_type)?>
    }, {
        name: 'Solved',
        data: <?php echo json_encode($solved_type)?>
    }, {
        name: 'Cancel',
        data: <?php echo json_encode($cancel_type)?>
    }]
});

//Kolom IT Support 3
<?php
    $software_support = $this->model_isi->pengaduan_jenis_masalah('S');
    $hardware_support = $this->model_isi->pengaduan_jenis_masalah('H');
    $network_support = $this->model_isi->pengaduan_jenis_masalah('N');
    $pengadaan_support = $this->model_isi->pengaduan_jenis_masalah('P');

?>
Highcharts.chart('container3', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Pengaduan <?php echo $date->format('M Y');?>'
    },
    subtitle: {
        text: 'KUMALA MOTOR GROUP'
    },
    xAxis: {
        categories: [
            'Software',
            'Hardware',
            'Network',
            'Pengadaan'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Jumlah Pengaduan'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'IT Support',
        data: [<?php echo $software_support.','.$hardware_support.','.$network_support.','.$pengadaan_support; ?>],
        events: {
        		legendItemClick: function(e) {
            		e.preventDefault()
            }
        }
    }]
});


//Kolom Web Developer 4
<?php
    $bug_web = $this->model_isi->pengaduan_jenis_masalah('B');
    $new_web = $this->model_isi->pengaduan_jenis_masalah('NF');
    $request_web = $this->model_isi->pengaduan_jenis_masalah('R');
    $issue_web = $this->model_isi->pengaduan_jenis_masalah('I');

?>
Highcharts.chart('container4', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Pengaduan <?php echo $date->format('M Y');?>'
    },
    subtitle: {
        text: 'KUMALA MOTOR GROUP'
    },
    xAxis: {
        categories: [
            'Bug / Error',
            'New Feature',
            'Request',
            'Issue'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Jumlah Pengaduan'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Web Developer',
        data: [<?php echo $bug_web.','.$new_web.','.$request_web.','.$issue_web; ?>],
        events: {
        		legendItemClick: function(e) {
            		e.preventDefault()
            }
        }
    }]
});

//Kolom Android Developer 5
<?php
    $bug_and = $this->model_isi->pengaduan_jenis_masalah('BA');
    $new_and = $this->model_isi->pengaduan_jenis_masalah('NA');
    $request_and = $this->model_isi->pengaduan_jenis_masalah('RA');
    $issue_and = $this->model_isi->pengaduan_jenis_masalah('IA');

?>
Highcharts.chart('container5', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Pengaduan <?php echo $date->format('M Y');?>'
    },
    subtitle: {
        text: 'KUMALA MOTOR GROUP'
    },
    xAxis: {
        categories: [
            'Bug / Error',
            'New Feature',
            'Request',
            'Issue'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Jumlah Pengaduan'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Android Developer',
        data: [<?php echo $bug_and.','.$new_and.','.$request_and.','.$issue_and; ?>],
        events: {
        		legendItemClick: function(e) {
            		e.preventDefault()
            }
        }
    }]
});

//Kolom Status Brand 6
<?php
    $brand = $this->model_isi->pengaduan_brand();
    $open_brand = $this->model_isi->pengaduan_open_brand();
    $working_brand = $this->model_isi->pengaduan_working_brand();
    $pending_brand = $this->model_isi->pengaduan_pending_brand();
    $solved_brand = $this->model_isi->pengaduan_solved_brand();
    $cancel_brand = $this->model_isi->pengaduan_cancel_brand();
?>
Highcharts.chart('container6', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Pengaduan <?php echo $date->format('M Y');?>'
    },
    subtitle: {
        text: 'KUMALA MOTOR GROUP'
    },
    xAxis: {
        categories: <?php echo json_encode($brand);?>,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Jumlah Pengaduan'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Open',
        data: <?php echo json_encode($open_brand);?>
    }, {
        name: 'Working',
        data: <?php echo json_encode($working_brand);?>
    }, {
        name: 'Pending',
        data: <?php echo json_encode($pending_brand);?>
    }, {
        name: 'Solved',
        data: <?php echo json_encode($solved_brand);?>
    }, {
        name: 'Cancel',
        data: <?php echo json_encode($cancel_brand);?>
    }]
});


</script>
