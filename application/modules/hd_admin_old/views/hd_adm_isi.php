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

    <div class="span12 infobox-container">
        <img style="width:30%;margin-top:10px;" src="<?php echo base_url();?>assets/images/hd.png"></img>
    </div>
</div>
<br>
