<div class="row-fluid">
    <div class="table-header">
        <?php echo 'Ticket'; ?>
        <div class="widget-toolbar no-border pull-right">
            <p style="margin: 0 20px;"><?php echo date('d F Y'); ?></p>
        </div>
    </div>
    <table class="table lcnp table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="center span1">No</th>
                <th class="center span1">No Ticket</th>
                <th class="center span2">NIK</th>
                <th class="center span2">Nama</th>
                <th class="center span2">Cabang</th>
                <th class="center span2">Tanggal Masuk</th>
                <th class="center span2">Brand</th>
                <th class="center span2">Departement</th>
                <th class="center span2">Type Job</th>
                <th class="center">Detail Problem</th>
                <th class="center span2">Status</th>
                <th class="center span1">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i = 1;
                foreach($items as $row){ ?>
                    <tr>
                        <td style="vertical-align:middle; text-align:center">
                            <?php echo $i ;?>
                        </td>
                        <td style="vertical-align:middle; text-align:center">
                            <?php echo $row['no_ticket'] == '' ? ' - ' : $row['no_ticket'] ;?>
                        </td>
                        <td style="vertical-align:middle; text-align:center">
                            <?php echo $row['nik'] ;?>
                        </td>
                        <td style="vertical-align:middle; text-align:center">
                            <?php echo $row['nama'] ;?>
                        </td>
                        <td style="vertical-align:middle; text-align:center">
                            <?php echo $row['cabang'] ;?>
                        </td>
                        <td style="vertical-align:middle; text-align:center">
                            <?php echo $row['tanggal_masuk'] ;?>
                        </td>
                        <td style="vertical-align:middle; text-align:center">
                            <?php
                                $id_brand = $row['id_brand'];
                                foreach($list_brand as $brands){
                                    if($id_brand == $brands['id_brand']){
                                        echo $brands['nama_brand'];
                                    }
                                }
                            ?>
                        </td>
                        <td style="vertical-align:middle; text-align:center">
                            <?php
                                $id_dep = $row['id_divisi'];
                                foreach($list_dep as $deps){
                                    if($id_dep == $deps['id_divisi']){
                                        echo $deps['divisi'];
                                    }
                                }
                            ?>
                        </td>
                        <td style="vertical-align:middle; text-align:center">
                            <?php echo $row['type_job'] ;?>
                        </td>
                        <td style="vertical-align:middle; text-align:center">
                            <a href="#show_data" style="text-decoration:none;" onclick="show_data('<?php echo $i;?>')" data-toggle="modal">Lihat</a>
                        </td>
                        <td style="vertical-align:middle; text-align:center">
                            <?php
                                if($row['status'] == 0){
                                    echo '<p style="padding: 10px 5px; background-color: grey; color: white;">Menunggu</p>';     
                                }else if($row['status'] == 1){
                                    echo '<p style="padding: 10px 5px; background-color: orange; color: white;">Pickup</p>';     
                                }else if($row['status'] == 2){
                                    echo '<p style="padding: 10px 5px; background-color: lightskyblue; color: white;">Done</p>';     
                                }else if($row['status'] == 3){
                                    echo '<p style="padding: 10px 5px; background-color: tomato; color: white;">Cancel</p>';     
                                }
                            ?>
                        </td>
                        <td style="vertical-align:middle; text-align:center">
                            <!-- <a href="<?php echo site_url();?>ticket_list/edit/<?php echo $row['id']; ?>" style="text-decoration:none;" class="green"><i class="icon-edit icon-large icon-border"></i>edit</a> -->
                            <?php if($row['status'] > 0) {?>
                                <p>Tidak Bisa Dihapus</p>
                            <?php }else{?>
                                <a href="<?php echo site_url();?>ticket/hapus/<?php echo $row['id']; ?>" style="text-decoration:none;" class="red"><i class="icon-trash icon-large icon-border"></i>hapus</a>
                            <?php }?>
                        </td>
                    </tr>
                <?php 
                $i++;
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
    var data = <?php echo json_encode($items);?>;
    var brand = JSON.parse('<?php echo json_encode($list_brand);?>');
    var dep = JSON.parse('<?php echo json_encode($list_dep);?>');

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