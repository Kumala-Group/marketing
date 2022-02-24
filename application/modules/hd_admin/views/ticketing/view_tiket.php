<div class="row-fluid">
    <div class="table-header">
        <?php echo $judul.' Sedang Diproses'; ?>
        <div class="widget-toolbar no-border pull-right">
            <p style="margin: 0 20px;"><?php echo date('d F Y'); ?></p>
        </div>
    </div>
    <table class="table lcnp table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="center span1">No</th>
                <th class="center span2">No Ticket</th>
                <th class="center span2">NIK</th>
                <th class="center span2">Nama Pengadu</th>
                <th class="center span2">Cabang</th>
                <th class="center span2">Tgl. Mulai</th>
                <th class="center span2">Tgl. Estimasi</th>
                <th class="center span2">Brand</th>
                <th class="center span2">Departement</th>
                <th class="center span2">Level Task</th>
                <th class="center span2">Type Job</th>
                <th class="center span2">Status</th>
                <th class="center span2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $no = 1;
                $index = 0;
                if($data['executing'] == ''){
                    echo "<tr><td colspan='13'><center>Tidak ada data<center></td></tr>";
                }else{
                    foreach($data['executing'] as $row){ 
                ?>
                    <tr>
                        <td style="vertical-align:middle; text-align:center">
                            <?php echo $no ;?>
                        </td>
                        <td style="vertical-align:middle; text-align:center">
                            <?php echo $row['no_ticket'] == '' ? ' - ' : $row['no_ticket'];?>
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
                                foreach($data['ticket_process'] as $rows){
                                    if($row['id'] == $rows['id']){
                                        echo $rows['estimasi_selesai'];
                                    }
                                }
                            ?>
                        </td>
                        <td style="vertical-align:middle; text-align:center">
                            <?php
                                $id_brand = $row['id_brand'];
                                foreach($data['list_brand'] as $brands){
                                    if($id_brand == $brands['id_brand']){
                                        echo $brands['nama_brand'];
                                    }
                                }
                            ?>
                        </td>
                        <td style="vertical-align:middle; text-align:center">
                            <?php
                                $id_dep = $row['id_divisi'];
                                foreach($data['list_dep'] as $deps){
                                    if($id_dep == $deps['id_divisi']){
                                        echo $deps['divisi'];
                                    }
                                }
                            ?>
                        </td>
                        <td style="vertical-align:middle; text-align:center">
                            <div style="padding: 4px 8px; color: white; background-color: <?php echo $row['level_task_color']; ?>;"><?php echo $row['level_task'] ;?></div>
                        </td>
                        <td style="vertical-align:middle; text-align:center">
                            <?php echo $row['type_job'] ;?>
                        </td>
                        <td style="vertical-align:middle; text-align:center">
                            <?php
                                // if($row['status'] == 0){
                                //     echo '<p style="padding: 10px 5px; background-color: grey; color: white;">Menunggu</p>';     
                                // }else if($row['status'] == 1){
                                    echo '<a href="#update_status_done" onclick="update_status_done('.$index.','.$row['id'].')" data-toggle="modal" style="text-decoration: none; padding: 10px 18px; margin: 10px 10px; background-color: orange; color: white;">Pickup</a>';     
                                // }
                            ?>
                        </td>
                        <td style="vertical-align:middle; text-align:center">
                            <a href="<?php echo site_url(); ?>hd_adm_solving/edit/<?php echo $row['id']; ?>"><i class="icon-edit icon-large icon-border" style="color: green;"></i>Edit</a>
                        </td>
                    </tr>
                <?php 
                $no++;
                $index++;
                }
                
            }
            // }
            ?>
        </tbody>
    </table>

    <div class="table-header">
        <?php echo $judul; ?>
        <div class="widget-toolbar no-border pull-right">
            <p style="margin: 0 20px;"><?php echo date('d F Y'); ?></p>
        </div>
    </div>
    <table class="table lcnp table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="center span1">No</th>
                <th class="center span2">No Ticket</th>
                <th class="center span2">NIK</th>
                <th class="center span2">Nama Pengadu</th>
                <th class="center span2">Cabang</th>
                <th class="center span2">Tgl. Masuk</th>
                <th class="center span2">Brand</th>
                <th class="center span2">Departement</th>
                <th class="center span2">Type Job</th>
                <th class="center span2">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $no = 1;
                $index = 0;
                if($data['items'] == ''){
                    echo "<tr><td colspan='10'><center>Tidak ada data<center></td></tr>";
                }else{
                    foreach($data['items'] as $row){ 
                        if($row['status'] == '0'){    
                ?>
                    <tr>
                        <td style="vertical-align:middle; text-align:center">
                            <?php echo $no ;?>
                        </td>
                        <td style="vertical-align:middle; text-align:center">
                            <?php echo $row['no_ticket'] == '' ? ' - ' : $row['no_ticket'];?>
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
                                foreach($data['list_brand'] as $brands){
                                    if($id_brand == $brands['id_brand']){
                                        echo $brands['nama_brand'];
                                    }
                                }
                            ?>
                        </td>
                        <td style="vertical-align:middle; text-align:center">
                            <?php
                                $id_dep = $row['id_divisi'];
                                foreach($data['list_dep'] as $deps){
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
                            <?php
                                // if($row['status'] == 0){
                                    echo '<a href="#update_status" onclick="update_status('.$index.','.$row['id'].')" data-toggle="modal" style="text-decoration: none; padding: 10px 18px; margin: 10px 10px; background-color: grey; color: white;">Waiting</a>';     
                                // }else if($row['status'] == 1){
                                //     echo '<p style="padding: 10px 5px; background-color: orange; color: white;">Pickup</p>';     
                                // }
                            ?>
                        </td>
                    </tr>
                <?php 
                $no++;
                }
                $index++;
                }
            }
            ?>
        </tbody>
    </table>
</div>

<div id="update_status" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Confirm Execute
        </div>
    </div>
    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" action="<?php echo site_url();?>/hd_adm_ticketing/update" method="POST" name="my-form-detail" id="my-form-detail">
                <div style="display: flex; margin: 20px 0 0 25px;">
                    <input type="hidden" name="id_karyawan" value="<?php echo $this->session->userdata('username'); ?>">
                    <input type="hidden" class="id_pengadu" name="id_pengadu">
                    <input type="hidden" class="id_ticket" name="id_ticket"> 
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
                    <div style="display: flex; justify-content: center; padding: 20px;">
                        <a href="#show_image" onclick="open_image()" data-toggle="modal"><img id="show_gambar" src="" style="width: 200px; height: auto;" /></a>
                    </div>
                </div>
                <div class="control-group">
                    <div style="display: flex; justify-content: center;">
                        <textarea id="detail-problem-textarea" style="resize: none; width: 500px; height: 100px; margin: 30px 0 0 0;" disabled></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <div style="margin: 20px; display: flex; justify-content: center;">
                        <div style="margin-right: 10px;">
                            <label>Estimasi Selesai &nbsp</label>
                            <input type="text" name="tanggal_estimasi" autocomplete="off" id="tanggal_masuk" class="date-picker form-ticket" placeholder="estimasi" data-date-format="yyyy-mm-dd" required/>
                        </div>
                        <div style="margin-left: 10px;">
                            <label>Level Task &nbsp</label>
                            <select name="level">
                                <option value="1">Easy</option>
                                <option value="2">Medium</option>
                                <option value="3">High</option>
                                <option value="4">Expert</option>
                            </select>
                        </div>
                        
                    </div>
                </div>
                <div style="display: flex; justify-content: center; margin-bottom: 20px;">
                    <button type="submit" style="margin: 10px 20px; width: 120px;" class="btn btn-warning" name="pickup" value="pickup"> Pickup </button>
                    <button type="button" style="margin: 10px 20px; width: 120px;" class="btn btn-secondary" data-dismiss="modal"> Kembali </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="update_status_done" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Confirm Status
        </div>
    </div>
    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" action="<?php echo site_url();?>/hd_adm_ticketing/update" method="POST" name="my-form-detail" id="my-form-detail">
                <div style="display: flex; margin: 20px 0 0 25px;">
                    <input type="hidden" name="id_karyawan" value="<?php echo $this->session->userdata('username'); ?>">
                    <input type="hidden" class="id_ticket_done" name="id_ticket"> 
                </div>
                <div class="control-group">
                    <div style="margin: 0px; display: flex; justify-content: center;">
                        <div style="margin: 0 5px;">
                            <label>Tanggal Mulai &nbsp</label>
                            <input type="text" id="modal_tanggal_mulai" readonly/>
                        </div>
                        <div style="margin: 0 5px;">
                            <label>Estimasi Selesai &nbsp</label>
                            <input type="text" id="modal_estimasi_selesai" readonly/>
                        </div>
                    </div>
                </div>
                <div style="display: flex; justify-content: center; margin-bottom: 20px;">
                    <button type="submit" style="margin: 10px 20px; width: 120px;" class="btn btn-primary" name="done" value="done"> Done </button>
                    <button type="submit" style="margin: 10px 20px; width: 120px;" class="btn btn-danger" name="cancel" value="cancel"> Cancel </button>
                    <button type="button" style="margin: 10px 20px; width: 120px;" class="btn btn-secondary" data-dismiss="modal"> Kembali </button>
                </div>
            </div>
        </form>
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
    
    var data = <?php echo json_encode($data['items']);?>;
    var brand = JSON.parse('<?php echo json_encode($data['list_brand']);?>');
    var dep = JSON.parse('<?php echo json_encode($data['list_dep']);?>');
    var ticket_execute = <?php echo json_encode($data['ticket_process']); ?>;

    console.log(<?php echo json_encode($data['ticket_process']); ?>);
    // console.log(data);

    function update_status(index_ticket, id_ticket){
        document.querySelector('.id_ticket').value = id_ticket;
        document.querySelector('.id_pengadu').value = data[index_ticket].nik;
        show_data(index_ticket);
    }

    function update_status_done(index_ticket, id_ticket){
        document.querySelector('.id_ticket_done').value = id_ticket;
        for(let u=0; u<ticket_execute.length; u++){
            if(data[index_ticket].id == ticket_execute[u].id){
                tglm = ticket_execute[u].tanggal_masuk;
                tgle = ticket_execute[u].estimasi_selesai;
            }
        }
        document.querySelector('#modal_tanggal_mulai').value = tglm;
        document.querySelector('#modal_estimasi_selesai').value = tgle;
        show_data(index_ticket);
    }

    function show_data(id){
        document.getElementById('detail-problem-textarea').innerHTML = data[id].detail_problem;
        document.getElementById('show_no_ticket').innerHTML = '<strong>No Ticket</strong> = '+data[id].no_ticket;
        document.getElementById('show_nik').innerHTML = '<strong>NIK</strong> = '+data[id].nik;
        document.getElementById('show_nama').innerHTML = '<strong>Nama</strong> = '+data[id].nama;
        document.getElementById('show_cabang').innerHTML = '<strong>Cabang</strong> = '+data[id].cabang;
        document.getElementById('show_tanggal_masuk').innerHTML = '<strong>Tgl. Masuk</strong> = '+data[id].tanggal_masuk;
        document.getElementById('show_dokumen').setAttribute('href', '<?php echo base_url(); ?>assets/ticketing_dokumen/'+data[id].dokumen);
        for(var x=0; x<brand.length; x++){
            if(brand[x].id_brand == data[id].id_brand){
                document.getElementById('show_brand').innerHTML = '<strong>Brand</strong> = '+brand[x].nama_brand;
            }
        }
        for(var y=0; y<dep.length; y++){
            if(dep[y].id_divisi == data[id].id_divisi){
                document.getElementById('show_dep').innerHTML = '<strong>Departement</strong> = '+dep[y].divisi;
            }
        }
        document.getElementById('show_type_job').innerHTML = '<strong>Type Job</strong> = '+data[id].type_job;
        console.log(data[id].gambar);
        if(data[id].gambar == null || data[id].gambar == undefined){
            document.getElementById('show_gambar').style.display = 'none';
        }else{
            document.getElementById('show_gambar').src = '<?php echo base_url(); ?>assets/ticketing_gambar/'+data[id].gambar;
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