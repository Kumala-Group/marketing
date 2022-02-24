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
        width: 450px;
    }
</style>

<div>
    <form id="form" method="POST" action="<?php echo site_url();?>ticket/simpan" enctype="multipart/form-data">
        <div style="border: 0px solid; border-radius: 0px; margin-top: 30px;">
            <div style="display: flex;">
                <div style="padding: 10px 30px;">
                    <label>No Tikcet</label>
                    <input type="text" name="no_ticket" class="form-ticket" value="<?php echo $generate_ticket_number;?>" autocomplete="off" readonly>
                    <label>NIK</label>
                    <input type="text" name="nik" class="form-ticket" placeholder="Masukkan NIK..." value="<?php echo $this->session->userdata('username');?>" autocomplete="off" readonly>
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-ticket" placeholder="Masukkan nama..." value="<?php echo $this->session->userdata('nama_lengkap');?>" autocomplete="off" readonly>
                    <label>Cabang</label>
                    <input type="text" name="cabang" class="form-ticket" placeholder="Masukkan cabang..." value="<?php echo $cabang[0]['singkat'].' - '.$cabang[0]['lokasi'];?>" autocomplete="off" readonly>
                    <label>Type Job</label>
                    <select name="type_job">
                        <option value="" readonly selected>Pilih Type Job</option>
                        <option>Bug/Error/Troubleshoot</option>
                        <option>Request</option>
                        <option>Update</option>
                        <option>Training User</option>
                    </select>                    
                </div>
                <div style="padding: 10px 30px;">
                    <label>Tanggal Masuk</label>
                    <input type="text" name="tanggal_masuk" value="<?php echo date('Y-m-d H:i:s'); ?>" readonly>
                    <label>Brand</label>
                        <?php
                            foreach($list_brand as $row){
                                if($row['id_brand'] == $this->session->userdata('id_brand')){
                                    $nama_brand = $row['nama_brand'];
                                }
                            }
                        ?>
                    <input type="text" value="<?php echo $nama_brand;?>" readonly>
                    <input type="hidden" name="brand" value="<?php echo $this->session->userdata('id_brand');?>" hidden>
                    
                    <label>Departement</label>
                        <?php
                            foreach($list_dep as $row){
                                if($row['id_divisi'] == $this->session->userdata('id_divisi')){
                                    $nama_dep = $row['divisi'];
                                }
                            }
                        ?>
                    <input type="text" value="<?php echo $nama_dep;?>" readonly>
                    <input type="hidden" name="dep" value="<?php echo $this->session->userdata('id_divisi');?>">

                    
                </div>
            </div>
            <div style="margin-top: 0px;">
                <div style="padding: 10px 30px;">
                    <label>Detail Problem</label>
                    <textarea name="detail_problem" style="width: 580px; height: 80px;"></textarea>
                    <label>Upload Gambar</label>
                    <input type="file" id="file" name="gambar" accept="image/*"/>
                    <br>
                    <br>
                    <label>Upload File Dokumen</label>
                    <input type="file" id="file" name="dokumen" accept="*"/>
                </div>
            </div>
            <div style="padding: 25px 30px">
                <button type="submit" class="btn btn-primary"> Simpan </button>
            </div>
        </div>
    </form>
</div>