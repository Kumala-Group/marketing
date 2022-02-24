<script>
    $(document).ready(function(){
        console.log(<?php json_encode($data) ;?>);
        $('.date-picker').datepicker({
            autoclose: true,
        }).next().on(ace.click_event, function() {
            $(this).prev().focus();
        });

        
    });
</script>
<style>
    .form-ticket {
        width: 450px;
    }
</style>

<div>
    <form id="form" method="POST" action="<?php echo site_url(); ?>hd_adm_solving/simpan_edited" enctype="multipart/form-data">
        <div style="border: 0px solid; border-radius: 0px; margin-top: 30px;">
            <div style="display: flex;">
                <div style="padding: 10px 30px;">
                    <input type="hidden" name="id_ticket" value="<?php echo $data['tickets']['id']; ?>">
                    <label>No Ticket</label>
                    <input type="text" name="no_ticket" class="form-ticket" value="<?php echo $data['tickets']['no_ticket'];?>" autocomplete="off" readonly>
                    <label>NIK</label>
                    <input type="text" name="nik" class="form-ticket" placeholder="Masukkan NIK..." value="<?php echo $data['tickets']['nik'];?>" autocomplete="off" readonly>
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-ticket" placeholder="Masukkan nama..." value="<?php echo $data['tickets']['nama'];?>" autocomplete="off" readonly>
                    <label>Cabang</label>
                    <input type="text" name="cabang" class="form-ticket" placeholder="Masukkan cabang..." value="<?php echo $data['tickets']['cabang'];?>" autocomplete="off" readonly>
                    <div style="display: flex;">
                        <div style="margin-right: 20px;"> 
                            <label>Type Job</label>
                            <select name="type_job">
                                <?php 
                                $type_job = array(
                                    'Bug/Error/Troubleshoot', 'Request', 'Update', 'Training User'
                                );
                                foreach($type_job as $row){
                                    if($data['tickets']['type_job'] == $row){
                                    ?>
                                        <option selected><?php echo $row; ?></option>
                                    <?php
                                    }else{ ?>
                                        <option><?php echo $row; ?></option>
                                    <?php
                                    }
                                } 
                                ?>
                            </select>
                        </div>
                        <div>
                            <label>Level</label>
                            <select name="level">
                                <?php
                                $levels = array(
                                    array('level' => '1', 'level_task' => 'Easy'),
                                    array('level' => '2', 'level_task' => 'Medium'),
                                    array('level' => '3', 'level_task' => 'High'),
                                    array('level' => '4', 'level_task' => 'Expert')
                                );
                                foreach($levels as $row){
                                    if($data['tickets']['level'] == $row['level']){
                                    ?>
                                        <option value="<?php echo $row['level']; ?>" selected><?php echo $row['level_task']; ?></option>
                                    <?php
                                    }else{ ?>
                                        <option value="<?php echo $row['level']; ?>"><?php echo $row['level_task']; ?></option>
                                    <?php
                                    }
                                } 
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div style="padding: 10px 30px;">
                    <label>Tanggal Masuk</label>
                    <input type="text" name="tanggal_masuk" value="<?php echo $data['tickets']['tanggal_masuk']; ?>" readonly>
                    <label>Brand</label>
                        <?php
                            foreach($data['list_brand'] as $row){
                                if($row['id_brand'] == $data['tickets']['id_brand']){
                                    $nama_brand = $row['nama_brand'];
                                }
                            }
                        ?>
                    <input type="text" value="<?php echo $nama_brand;?>" readonly>
                    <input type="hidden" name="brand" value="<?php echo $data['tickets']['id_brand'];?>" hidden>
                    
                    <label>Departement</label>
                        <?php
                            foreach($data['list_dep'] as $row){
                                if($row['id_divisi'] == $data['tickets']['id_divisi']){
                                    $nama_dep = $row['divisi'];
                                }
                            }
                        ?>
                    <input type="text" value="<?php echo $nama_dep;?>" readonly>
                    <input type="hidden" name="dep" value="<?php echo $data['tickets']['id_divisi'];?>">

                    
                </div>
            </div>
            <div style="margin-top: 0px;">
                <div style="padding: 10px 30px;">
                    <label>Detail Problem</label>
                    <textarea name="detail_problem" style="width: 580px; height: 80px;"><?php echo $data['tickets']['detail_problem']; ?></textarea>
                </div>
            </div>
            <div style="padding: 25px 30px">
                <button type="submit" class="btn btn-primary"> Simpan </button>
            </div>
        </div>
    </form>
</div>