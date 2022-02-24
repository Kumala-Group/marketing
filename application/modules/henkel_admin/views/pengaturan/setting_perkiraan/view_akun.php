  <option value="" selected="selected">--Pilih Nama Akun--</option>
  <?php
    $data = $this->db_kpp->get('akun');
    foreach($data->result() as $dt){
  ?>
    <option value="<?php echo $dt->kode_akun;?>"><?php echo $dt->nama_akun;?></option>
  <?php
    }
  ?>
