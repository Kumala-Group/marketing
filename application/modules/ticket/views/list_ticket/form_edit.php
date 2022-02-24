<script>
    $(document).ready(function(){
        $('.date-picker').datepicker({
            autoclose: true,
        }).next().on(ace.click_event, function() {
            $(this).prev().focus();
        });
    });
</script>
<style>
    .form-ticket {
        width: 300px;
    }
</style>

<div>
    <form id="form" method="POST" action="<?php echo site_url();?>ticket_list/simpan_update/<?php echo $item[0]['id']; ?>" enctype="multipart/form-data">
        <div style="border: 0px solid; border-radius: 0px; margin-top: 30px;">
            <div style="display: flex;">
                <div style="padding: 10px 30px;">
                    <label>NIK</label>
                    <input type="text" name="nik" class="form-ticket" placeholder="Masukkan NIK..." value="<?php echo $item[0]['nik']; ?>" autocomplete="off">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-ticket" placeholder="Masukkan nama..." value="<?php echo $item[0]['nama']; ?>" autocomplete="off">
                    <label>Cabang</label>
                    <input type="text" name="cabang" class="form-ticket" placeholder="Masukkan cabang..." value="<?php echo $item[0]['cabang']; ?>" autocomplete="off">
                    <label>Tanggal Masuk</label>
                    <input type="text" name="tanggal_masuk" autocomplete="off" id="tanggal_masuk" value="<?php echo date("d-m-Y", strtotime($item[0]['tanggal_masuk'])); ?>" class="date-picker form-ticket" placeholder="Tanggal update" data-date-format="dd-mm-yyyy" />
                </div>
                <div style="padding: 10px 30px;">
                <label>Brand</label>
                    <select name="brand">
                        <option value="<?php echo $item[0]['id_brand']; ?>" selected>
                            <?php
                                foreach($list_brand as $row_brand){
                                    if($item[0]['id_brand'] == $row_brand['id_brand']){
                                        echo $row_brand['nama_brand'];
                                    }
                                }
                            ?>
                        </option>
                        <?php
                            foreach($list_brand as $row){ ?>
                                <option value="<?php echo $row['id_brand'];?>"><?php echo $row['nama_brand'];?></option>
                            <?php }
                        ?>
                    </select>
                    <label>Type Job</label>
                    <select name="type_job">
                        <option value="<?php echo $item[0]['type_job']; ?>" disabled selected><?php echo $item[0]['type_job']; ?></option>
                        <option>Bug/Error/Troubleshoot</option>
                        <option>Request</option>
                        <option>Update</option>
                        <option>Training User</option>
                    </select>
                    <label>Departement</label>
                    <select name="dep">
                        <option value="<?php echo $item[0]['id_divisi']; ?>" selected>
                            <?php
                                foreach($list_dep as $row_dep){
                                    if($item[0]['id_divisi'] == $row_dep['id_divisi']){
                                        echo $row_dep['divisi'];
                                    }
                                }
                            ?>
                        </option>
                        <?php
                            foreach($list_dep as $row){ ?>
                                <option value="<?php echo $row['id_divisi'];?>"><?php echo $row['divisi'];?></option>
                            <?php }
                        ?>
                    </select>
                </div>
            </div>
            <div style="margin-top: 0px;">
                <div style="padding: 10px 30px;">
                    <label>Detail Problem</label>
                    <textarea name="detail_problem" style="width: 580px; height: 80px;"><?php echo $item[0]['detail_problem']; ?></textarea>
                    <label>Upload Gambar</label>
                    <input type="file" id="file" name="gambar"/>
                    <br>
                    <br>
                    <label>Upload File Dokumen</label>
                    <input type="file" id="dokumen" name="dokumen"/>
                </div>
            </div>
            <div style="padding: 25px 30px">
                <button type="submit" class="btn btn-primary"> Simpan Perubahan </button>
            </div>
        </div>
    </form>
</div>