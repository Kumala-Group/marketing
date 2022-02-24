<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
<div class="row-fluid">
    <div class="table-header">
        <?php echo $judul;
        ?>
        <div class="widget-toolbar no-border pull-right">  
            
        </div>
    </div>
    <form method="POST" action="<?php echo site_url(); ?>/hd_adm_ticketing_dashboard/sortir">
        <div style="display: flex;">
            <div style="display: flex; margin: 10px 0;">
                <div style="margin: 0 20px; display: flex;">
                    <div style="margin: 0 10px;">
                        <label class="col-sm-3 control-label no-padding-right" style="margin: 0;">Bulan</label>
                        <select name="bulan">
                            <?php 
                                $bulan = array(
                                    '1'=>'Januari',
                                    '2'=>'Februari',
                                    '3'=>'Maret',
                                    '4'=>'April',
                                    '5'=>'Mei',
                                    '6'=>'Juni',
                                    '7'=>'Juli',
                                    '8'=>'Agustus',
                                    '9'=>'September',
                                    '10'=>'Oktober',
                                    '11'=>'November',
                                    '12'=>'Desember',
                                );

                                if(isset($data['desc_sortir']['bulan'])){
                                    $now = $data['desc_sortir']['bulan'];
                                }else{
                                    $now = date('m');
                                }
                                
                                foreach($bulan as $key => $value){
                                    if($now == $key){
                                ?>
                                    <option value="<?php echo $key; ?>" selected><?php echo $value; ?></option>
                                <?php   
                                    }else{
                                ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div style="margin: 0 10px;">
                        <label class="col-sm-3 control-label no-padding-right" style="margin: 0;">Tahun</label>
                        <select name="tahun">
                            <?php
                                if(isset($data['desc_sortir']['tahun'])){
                                    $now = $data['desc_sortir']['tahun'];
                                }else{
                                    $now = date('Y');
                                }
                            
                                for($x=date('Y');$x>'2000';$x--){
                                    if($now == $x){
                                ?>
                                    <option value="<?php echo $x; ?>" selected><?php echo $x; ?></option>
                                <?php   
                                    }else{
                                ?>
                                    <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div style="margin: 19px 10px 0;">
                        <button type="submit" class="btn btn-primary" style="border: none; width: 80px;"> Filter </button>
                    </div> 
                </div>
                
                
            </div>
            
        </div>
    </form>

    <div style="display: flex; justify-content: center;">
        <h3>Jumlah Pengaduan Ticket Masuk Bulan ini Sebanyak <strong><?php echo $data['total_ticket']; ?></strong> Pengaduan</h3>
    </div>
    <div style="display: flex; justify-content: space-around;">
        <div>
            <canvas id="stack" width="400" height="400"></canvas>
            <h5 style="margin-top: 10px;"><strong><center>Pengaduan Ticket by Proses</center></strong></h5>
        </div>
        <div>
            <canvas id="donat" width="400" height="400"></canvas>
            <h5 style="margin-top: 10px;"><strong><center>Pengaduan Ticket by Brand</center></strong></h5>
        </div>
    </div>
    <div style="display: flex; justify-content: space-around;">
        <div>
            <canvas id="level" width="400" height="400"></canvas>
            <h5 style="margin-top: -20px;"><strong><center>Pengaduan Ticket by Level Task</center></strong></h5>
        </div>
        <div>
            <canvas id="dep" width="400" height="400"></canvas>
            <h5 style="margin-top: -20px;"><strong><center>Pengaduan Ticket by Departement</center></strong></h5>
        </div>
    </div>

    
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $('.date-picker').datepicker({
            autoclose: true,
        }).next().on(ace.click_event, function() {
            $(this).prev().focus();
        });
    
    console.log(<?php echo json_encode($data['graph_dep']); ?>);;

    <?php 
        foreach($data['graph_brand'] as $key => $value){
            $datas_brands[] = $value;
            $labels_brands[] = $key;
        }
        foreach($data['graph_level'] as $value){
            $datas_levels[] = $value['jumlah'];
            $labels_levels[] = $value['nama'];
        }
        foreach($data['graph_dep'] as $value){
            $datas_deps[] = $value['jumlah'];
            $labels_deps[] = $value['nama'];
        }
    ?>
    var datas = <?php echo json_encode($datas_brands); ?>;
    var labels = <?php echo json_encode($labels_brands); ?>;
    var datasets = <?php echo json_encode($data['graph_status']); ?>;
    var bgcolor = [
        "#63b598", "#ce7d78", "#ea9e70", "#a48a9e", "#c6e1e8", "#648177" ,"#0d5ac1" ,
        "#f205e6" ,"#1c0365" ,"#14a9ad" ,"#4ca2f9" ,"#a4e43f" ,"#d298e2" ,"#6119d0",
        "#d2737d" ,"#c0a43c" ,"#f2510e" ,"#651be6" ,"#79806e" ,"#61da5e" ,"#cd2f00" ,
        "#9348af" ,"#01ac53" ,"#c5a4fb" ,"#996635","#b11573" ,"#4bb473" ,"#75d89e" ,
        "#2f3f94" ,"#2f7b99" ,"#da967d" ,"#34891f" ,"#b0d87b" ,"#ca4751" ,"#7e50a8" ,
        "#c4d647" ,"#e0eeb8" ,"#11dec1" ,"#289812" ,"#566ca0" ,"#ffdbe1" ,"#2f1179" ,
        "#935b6d" ,"#916988" ,"#513d98" ,"#aead3a", "#9e6d71", "#4b5bdc", "#0cd36d",
        "#250662", "#cb5bea", "#228916", "#ac3e1b", "#df514a", "#539397", "#880977",
        "#f697c1", "#ba96ce", "#679c9d", "#c6c42c", "#5d2c52", "#48b41b", "#e1cf3b",
        "#5be4f0", "#57c4d8", "#a4d17a", "#225b8", "#be608b", "#96b00c", "#088baf",
    ];

    var ctx = document.getElementById('donat');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($labels_brands); ?>,
            datasets: [{
                label: '# of Votes',
                data: <?php echo json_encode($datas_brands); ?>,
                backgroundColor: bgcolor,
                borderWidth: 1
            }]
        },
        options: {
            legend: {
                position: 'right'
            }
        }
    });

    var ctx = document.getElementById('level');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($labels_levels); ?>,
            datasets: [{
                data: <?php echo json_encode($datas_levels); ?>,
                backgroundColor: [
                    '#f77b00', '#f73601', '#cc014a', '#a3006a'
                ],
                borderWidth: 1
            }]
        },
        options: {
            legend: {
                position: 'right'
            }
        }
    });


    var ctx = document.getElementById('dep');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($labels_deps); ?>,
            datasets: [{
                data: <?php echo json_encode($datas_deps); ?>,
                backgroundColor: bgcolor,
                borderWidth: 1
            }]
        },
        options: {
            legend: {
                position: 'right'
            }
        }
    });
    
    var barChartData = {
        labels: ['Waiting', 'Pickup', 'Done', 'Canceled'],
        datasets: datasets

    };
    var ctx = document.getElementById('stack');
    var myBar = new Chart(ctx, {
        type: 'bar',
        data: barChartData,
        options: {
            legend: {
                position: 'right'
            },
            title: {
                display: true,
                // text: 'Chart.js Bar Chart - Stacked'
            },
            tooltips: {
                mode: 'index',
                intersect: false
            },
            responsive: true,
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }
    });
});
</script>