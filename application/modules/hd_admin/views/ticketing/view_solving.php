<div class="row-fluid">
<div class="table-header">
    <?php echo $judul;
    ?>
    <div class="widget-toolbar no-border pull-right">  
        <form action="<?php echo site_url(); ?>hd_adm_solving/cetak_excel" method="POST">
            <a class="btn btn-primary btn-sm" style="border: none; width: 80px;" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                Sort
            </a>
            <input type="hidden" name="sort_tanggal_dari" value="<?php echo $data['download']['tanggal_dari'];?>">
            <input type="hidden" name="sort_tanggal_sampai" value="<?php echo $data['download']['tanggal_sampai'];?>">
            <input type="hidden" name="brand" value="<?php echo $data['download']['brand'];?>">
            <input type="hidden" name="cabang" value="<?php echo $data['download']['cabang'];?>">
            <input type="hidden" name="dep" value="<?php echo $data['download']['dep'];?>">
            <button type="submit" class="btn btn-success" style="border: none; width: 150px;"> 
                Download Excel
            </button>
        </form>
           
    </div>
</div>

<form method="POST" action="<?php echo site_url(); ?>hd_adm_solving/sortir">
    <div style="display: flex;" class="collapse" id="collapseExample">
        <div style="display: flex; margin: 10px 0;">
            <div style="margin: 0 20px;">
                <div>
                    <label class="col-sm-3 control-label no-padding-right" style="margin: 0;"> Tanggal &nbsp</label>
                    <input style="vertical-align: middle; margin: 0; width: 83px;" autocomplete="off" name="sort_tanggal_dari" type="text" class="date-picker" data-date-format="yyyy-mm-dd" value="<?php echo $data['download']['tanggal_dari']; ?>">
                    <input type="text" value="-" style="vertical-align: middle; margin: 0; width: 4px;" readonly>
                    <input style="vertical-align: middle; margin: 0; width: 84px;" autocomplete="off" name="sort_tanggal_sampai" type="text" class="date-picker" data-date-format="yyyy-mm-dd" value="<?php echo $data['download']['tanggal_sampai']; ?>">
                </div>
                <div>
                    <label class="col-sm-3 control-label no-padding-right" style="margin: 0;"> Brand &nbsp</label>
                    <select name="brand" style="vertical-align: middle; margin: 0;">
                    <option value="">None</option>
                    <?php 
                        foreach($data['list_brand'] as $row){
                            if($row['id_brand'] == $data['download']['brand']){
                            ?>
                                <option value="<?php echo $row['id_brand'];?>" selected><?php echo $row['nama_brand'];?></option>
                            <?php
                            }else{ ?>
                                <option value="<?php echo $row['id_brand'];?>"><?php echo $row['nama_brand'];?></option>
                            <?php 
                            }
                        }
                    ?>
                    </select>
                </div>
                <div style="margin-top: 10px;">
                    <button type="submit" class="btn btn-primary" style="border: none; width: 80px;"> Cari </button>
                </div> 
            </div>
            <div>
                <div>
                    <label class="col-sm-3 control-label no-padding-right" style="margin: 0;"> Cabang &nbsp</label>
                    <select name="cabang" style="vertical-align: middle; margin: 0;">
                    <option value="">None</option>
                    <?php 
                        foreach($data['list_cabang'] as $row){
                            if($row == $data['download']['cabang']){
                            ?>
                                <option value="<?php echo $row;?>" selected><?php echo $row;?></option>
                            <?php
                            }else{ ?>
                                <option value="<?php echo $row;?>"><?php echo $row;?></option>
                            <?php 
                            }
                        }
                    ?>
                    </select>
                </div>
                <div>
                    <label class="col-sm-3 control-label no-padding-right" style="margin: 0;"> Departement &nbsp</label>
                    <select name="dep" style="vertical-align: middle; margin: 0;">
                    <option value="">None</option>
                    <?php 
                        foreach($data['list_dep'] as $row){
                            if($row['id_divisi'] == $data['download']['dep']){
                            ?>
                                <option value="<?php echo $row['id_divisi'];?>" selected><?php echo $row['divisi'];?></option>
                            <?php
                            }else{ ?>
                                <option value="<?php echo $row['id_divisi'];?>"><?php echo $row['divisi'];?></option>
                            <?php 
                            }
                        }
                    ?>
                    </select>
                </div>
            </div>
            
            
        </div>
        
    </div>
</form>
<!-- <table class="table fpTable lcnp table-striped table-bordered table-hover"> -->
<table class="table lcnp table-striped table-bordered table-hover">
    
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">No Ticket</th>
            <th class="center">NIK</th>
            <th class="center">Nama Pengadu</th>
            <th class="center">Cabang</th>
            <th class="center">Nama Executor</th>
            <th class="center">Level Task</th>
            <th class="center">Tgl. Masuk</th>
            <th class="center">Tgl. Mulai</th>
            <th class="center">Tgl. Selesai</th>
            <th class="center">Detail</th>
            <th class="center">Status Tiket</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php
            $no=1;
            if($data['tickets'] == ''){
                echo "<tr><td colspan='13'><center>Tidak ada data<center></td></tr>";
            }else{
                foreach($data['tickets'] as $row){
        ?>
            <tr>
                <td style="vertical-align:middle; text-align:center">
                    <?php echo $no; ?>
                </td>
                <td style="vertical-align:middle; text-align:center">
                    <?php echo $row['no_ticket'] == '' ? ' - ' : $row['no_ticket']; ?>
                </td>
                <td style="vertical-align:middle; text-align:center">
                    <?php echo $row['nik']; ?>
                </td>
                <td style="vertical-align:middle; text-align:center">
                    <?php echo $row['nama']; ?>
                </td>
                <td style="vertical-align:middle; text-align:center">
                    <?php echo $row['cabang']; ?>
                </td>
                <td style="vertical-align:middle; text-align:center">
                    <?php echo $row['nama_executor']; ?>
                </td>
                <td style="vertical-align:middle; text-align:center">
                    <div style="padding: 4px 8px; color: white; background-color: <?php echo $row['level_task_color']; ?>;"><?php echo $row['level_task'] ;?></div>
                </td>
                <td style="vertical-align:middle; text-align:center">
                    <?php echo $row['tanggal_masuk']; ?>
                </td>
                <td style="vertical-align:middle; text-align:center">
                    <?php echo $row['tanggal_mulai']; ?>
                </td>
                <td style="vertical-align:middle; text-align:center">
                    <?php
                        if($row['tanggal_selesai'] == ''){
                            echo 'Belum selesai';
                        }else{
                            echo $row['tanggal_selesai'];
                        }
                    ?>
                </td>
                <td style="vertical-align:middle; text-align:center">
                    <a href="#show_data" onclick="show_data('<?php echo $no; ?>')" data-toggle="modal">Lihat</a>
                </td>
                <td style="vertical-align:middle; text-align:center">
                    <?php
                        if($row['status'] == 0){
                            echo '<p style="padding: 10px 5px; background-color: grey; color: white;">Waiting</p>';     
                        }else if($row['status'] == 1){
                            echo '<p style="padding: 10px 5px; background-color: orange; color: white;">Pickup</p>';     
                        }else if($row['status'] == 2){
                            echo '<p style="padding: 10px 5px; background-color: lightskyblue; color: white;">Done</p>';     
                        }else if($row['status'] == 3){
                            echo '<p style="padding: 10px 5px; background-color: tomato; color: white;">Canceled</p>';     
                        }
                    ?>
                </td>
                <td style="vertical-align:middle; text-align:center">
                    <a href="<?php echo site_url(); ?>hd_adm_solving/edit/<?php echo $row['id']; ?>"><i class="icon-edit icon-large icon-border" style="color: green;"></i>Edit</a>
                </td>
            </tr>
        <?php
            $no++;
            }
        }
        ?>
    </tbody>

</table>
</div>

<div id="show_data" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Detail Problem
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form-detail" id="my-form-detail">
                <div style="display: flex;">
                    <div style="display: flex; margin: 20px 0 0 25px;">
                        <div>
                            <p style="margin: 0;" id="show_no_ticket">No Ticket</p>
                            <p style="margin: 0;" id="show_nik">NIK</p>
                            <p style="margin: 0;" id="show_nama">Nama</p>
                            <p style="margin: 0;" id="show_cabang">Cabang</p>
                            <p style="margin: 0;" id="show_tanggal_masuk">Tanggal Masuk</p>
                            <p style="margin: 0;" id="show_brand">Brand</p>
                            <p style="margin: 0;" id="show_dep">Departement</p>
                            <p style="margin: 0;" id="show_type_job">Type Job</p>
                            <br>
                            <a href="#" id="show_dokumen" class="btn btn-small btn-info" target="_blank" download> Download Dokumen </a>
                        </div>
                    </div>
                    <div style="display: flex; justify-content: center; padding: 20px;">
                        <a href="#show_image" onclick="open_image()" data-toggle="modal"><img id="show_gambar" src="" style="width: 200px; height: auto;" /></a>
                    </div>
                </div>
                <div class="control-group">
                    <div style="display: flex; justify-content: center;">
                        <textarea id="detail-problem-textarea" style="resize: none; width: 500px; height: 100px; margin: 30px 0;" disabled></textarea>
                    </div>
                </div>
               
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.date-picker').datepicker({
            autoclose: true,
        }).next().on(ace.click_event, function() {
            $(this).prev().focus();
        });
    });

    var data = <?php echo json_encode($data['tickets']);?>;
    var brand = <?php echo json_encode($data['list_brand']);?>;
    var dep = <?php echo json_encode($data['list_dep']);?>;

    function show_data(id){
        document.getElementById('detail-problem-textarea').innerHTML = data[id-1].detail_problem;
        document.getElementById('show_no_ticket').innerHTML = '<strong>No Ticket</strong> = '+data[id-1].no_ticket;
        document.getElementById('show_nik').innerHTML = '<strong>NIK</strong> = '+data[id-1].nik;
        document.getElementById('show_nama').innerHTML = '<strong>Nama</strong> = '+data[id-1].nama;
        document.getElementById('show_cabang').innerHTML = '<strong>Cabang</strong> = '+data[id-1].cabang;
        document.getElementById('show_tanggal_masuk').innerHTML = '<strong>Tgl. Masuk</strong> = '+data[id-1].tanggal_masuk;
        document.getElementById('show_dokumen').setAttribute('href', '<?php echo base_url(); ?>assets/ticketing_dokumen/'+data[id-1].dokumen);
        for(var x=0; x<brand.length; x++){
            if(brand[x].id_brand == data[id-1].id_brand){
                document.getElementById('show_brand').innerHTML = '<strong>Brand</strong> = '+brand[x].nama_brand;
            }
        }
        for(var y=0; y<dep.length; y++){
            if(dep[y].id_divisi == data[id-1].id_divisi){
                document.getElementById('show_dep').innerHTML = '<strong>Departement</strong> = '+dep[y].divisi;
            }
        }
        document.getElementById('show_type_job').innerHTML = '<strong>Type Job</strong> = '+data[id-1].type_job;
        console.log(data[id-1].gambar);
        if(data[id-1].gambar == null || data[id-1].gambar == undefined){
            document.getElementById('show_gambar').style.display = 'none';
        }else{
            document.getElementById('show_gambar').src = '<?php echo base_url(); ?>assets/ticketing_gambar/'+data[id-1].gambar;
        }
    }

    
    function open_image(){
        document.querySelector('.image_pop').src = document.getElementById('show_gambar').src;
        document.querySelector('.div_pop').style.display = 'flex';

        // var gambar_el = document.querySelector('#show_gambar');
        var g = document.querySelector('.image_pop');
        g.onload = function(){
            if(g.height >= g.width){
                document.querySelector('.div_image').style.width = '60vw';
                document.querySelector('.div_pop').style.height = parseInt(g.height)+100+'px';
            }else{
                document.querySelector('.div_image').style.width = '80vw';
            }
            console.log(g.offsetHeight);
        }
        
    }
    
    function close_image(){
        document.querySelector('.div_pop').style.display = 'none';
    }
</script>