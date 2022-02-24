<style>
    td.center.rowspan {
        vertical-align: middle;
    }
    .table th, .table td {padding:0.6rem;}
</style>

<style>
    #chart_data {
        height: 500px;
    }

    .highcharts-figure,
    .highcharts-data-table table {
        min-width: 100%;
        max-width: 100%;
        margin: 1em auto;
    }

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #EBEBEB;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 100%;
    }

    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }

    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }

    .highcharts-data-table td,
    .highcharts-data-table th,
    .highcharts-data-table caption {
        padding: 0.5em;
    }

    .highcharts-data-table thead tr,
    .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }

    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }  
</style>
<div id="chart_container"></div>

    <!-- table moms -->
    <?php            
    if(count($performance)==1){ //untuk satu model, datanya cuma 1
        foreach($performance as $p){ ?>
            <h5 class="form-section"><i class="icon-folder-o"></i> <?=$p["model"]?></h5>
            <div style="overflow-x:auto;" class="">
                <table class="table table-bordered table-hover font-small-3">
                    <thead class="bg-grey bg-lighten-2">
                        <tr class="font-small-3">
                            <th class="center">Type</th>
                            <?php
                            $now = (int)date('m');
                            $nama_bln = array(1=>"Jan","Feb","Mar","Apr","Mei","Juni","Juli","Agst","Sept","Okt","Nov","Des");                             
                            for($bln=1;$bln<=12;$bln++) {
                                echo '<th class="center">'.$nama_bln[$bln].'</th>';
                            }
                            ?> 
                            <th class="center">Total</th>
                        </tr>                   
                    </thead>
                    <tbody class="font-small-3">                                 
                        <tr>
                            <td>Target</td>
                            <?php 
                            foreach($p["target"] as $target) { 
                                echo '<td class="text-xs-center">'.($target<>'0'?$target:'').'</td>';
                            }
                            ?>                             
                        </tr>
                        <tr>
                            <td>Achievement</td>
                            <?php 
                            foreach($p["aktual"] as $aktual) { 
                                echo '<td class="text-xs-center">'.($aktual<>'0'?$aktual:'').'</td>';
                            }
                            ?>  
                        </tr>
                        <tr>
                            <td>Diff</td>
                            <?php 
                            foreach($p["diff"] as $diff) { 
                                echo '<td class="text-xs-center">'.($diff<>'0'?$diff:'').'</td>';
                            }
                            ?>  
                        </tr>            
                        <?php 
                        //}
                        ?>
                    </tbody>
                    <tfoot class="bg-grey bg-lighten-4 text-bold-700">
                        <tr>
                            <td class="center">% Achievement</td>
                            <?php                              
                            foreach($p["%achv"] as $p_achv) { 
                                echo '<td class="text-xs-center">'.($p_achv<>'0'?$p_achv:'').'</td>';
                            }
                            ?>  
                        </tr>          
                    </tfoot>
                </table>
            </div>    
        <?php
        }//foreach        
    } else {//all model
        foreach($performance as $p){ 
            if ($p["model"]=="All Model") { ?>
                <h5 class="form-section"><i class="icon-folder-o"></i> <?=$p["model"]?></h5>
                <div style="overflow-x:auto;" class="">
                    <table class="table table-bordered table-hover font-small-3">
                        <thead class="bg-grey bg-lighten-2">
                            <tr class="font-small-3">
                                <th class="center">Type</th>
                                <?php
                                $now = (int)date('m');
                                $nama_bln = array(1=>"Jan","Feb","Mar","Apr","Mei","Juni","Juli","Agst","Sept","Okt","Nov","Des");                             
                                for($bln=1;$bln<=12;$bln++) {
                                    echo '<th class="center">'.$nama_bln[$bln].'</th>';
                                }
                                ?> 
                                <th class="center">Total</th>
                            </tr>                   
                        </thead>                                                
                        <tbody class="font-small-3">
                            <tr>
                                <td>Target</td>
                                <?php 
                                foreach($p["total_target"] as $total_target) { 
                                    echo '<td class="text-xs-center">'.($total_target<>'0'?$total_target:'').'</td>';
                                }                            
                                ?>                             
                            </tr>
                            <tr>
                                <td>Achievement</td>
                                <?php                           
                                foreach($p["total_aktual"] as $total_aktual) { 
                                    echo '<td class="text-xs-center">'.($total_aktual<>'0'?$total_aktual:'').'</td>';
                                }                            
                                ?>  
                            </tr>
                            <tr>
                                <td>Diff</td>
                                <?php                            
                                foreach($p["total_diff"] as $total_diff) { 
                                    echo '<td class="text-xs-center">'.($total_diff<>'0'?$total_diff:'').'</td>';
                                }                            
                                ?>  
                            </tr>                                    
                        </tbody>
                        <tfoot class="bg-grey bg-lighten-4 text-bold-700">
                            <tr>
                                <td class="center">% Achievement</td>
                                <?php                                  
                                foreach($p["total_achvs"] as $total_achvs) { 
                                    echo '<td class="text-xs-center">'.($total_achvs<>'0'?$total_achvs:'').'</td>';
                                }                            
                                ?>  
                            </tr>          
                        </tfoot>                      
                    </table>
                </div>    
        <?php
            }//if
        }//foreach
    }
    ?>
    <?php
    //}
    ?> 
    <!-- table productivity  -->


<script>
<?php
$nama_bln = array("'Jan'","'Feb'","'Mar'","'Apr'","'Mei'","'Juni'","'Juli'","'Agst'","'Sept'","'Okt'","'Nov'","'Des'");
$kategori_bulan = implode(',', $nama_bln);

foreach($performance as $p){ 
    $judul_chart = 'RS Target vs Achievement ('.$p["model"].')';
}
?> 
//highchart
var judul_chart = '<?php echo $judul_chart; ?>';
var kategori = [<?php echo($kategori_bulan); ?>];
var data_series = [<?php            
                    if(count($performance)==1){
                        foreach($performance as $p){ 
                            $target = $p["target"];
                            $v_target= array_pop($target);                                
                            $dt = implode(',',$target);
                            echo $dt;
                        }
                    } else {
                        foreach($performance as $p){ 
                            //print_r($p);
                            if ($p["model"]=="All Model") { 
                                $target = $p["total_target"];
                                $v_target= array_pop($target);                                
                                $dt = implode(',',$target);
                                echo $dt;
                            }    
                        }
                    }
                    ?>];
var data_spline = [<?php            
                    if(count($performance)==1){
                        foreach($performance as $p){ 
                            $aktual = $p["aktual"];
                            $v_aktual= array_pop($aktual);                                
                            $dt = implode(',',$aktual);
                            echo $dt;
                        }
                    } else {
                        foreach($performance as $p){ 
                            //print_r($p);
                            if ($p["model"]=="All Model") { 
                                $aktual = $p["total_aktual"];
                                $v_aktual= array_pop($aktual);                                
                                $dt = implode(',',$aktual);
                                echo $dt;
                            }    
                        }
                    }
                    ?>];

 Highcharts.chart('chart_container', {
    title: {
        text: judul_chart
    },
    xAxis: {
        categories: kategori
    },
    labels: {
        items: [{
            
        }]
    },
    chart: {
        renderTo: 'chart',
        //marginLeft: 100,
        //marginRight:100
    },  
    series: [{
        type: 'column',
        name: 'Target',
        data: data_series
    }, 
    {
        type: 'spline',
        name: 'Achievement',
        data: data_spline,
        marker: {
            lineWidth: 2,
            lineColor: Highcharts.getOptions().colors[3],
            fillColor: 'white'
        }
    }
    ]
});
        
</script>