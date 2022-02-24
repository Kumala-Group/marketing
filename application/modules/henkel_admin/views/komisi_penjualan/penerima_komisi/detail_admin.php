<script type="text/javascript">
$(document).ready(function(){
});

</script>
<div class="row-fluid">
<div class="table-header">
    <?php echo 'Data '.$judul.' '.$nama;?>
    <div class="widget-toolbar no-border pull-right">
    </div>
</div>

<table class="table fpTable lcnp table-striped table-bordered table-hover" id="show_perusahaan">
    <thead>
        <tr>
            <th class="center">NIK</th>
            <th class="center">Nama</th>
            <th class="center">Jabatan</th>
            <th class="center">Perusahaan</th>
        </tr>
    </thead>

    <tbody>
        <?php
        foreach($data->result() as $dt){
          $jabatan=$this->model_data->JabatanToKaryawan($dt->id_jabatan);
          $perusahaan=$this->model_data->nama_perusahaan_singkat($dt->id_perusahaan);
        ?>
        <tr id="<?php echo $dt->id_sales;?>">
            <td class="center"><?php echo $dt->nik;?></td>
            <td ><?php echo $dt->nama_karyawan;?></td>
            <td class="center"><?php echo $jabatan;?></td>
            <td class="center"><?php echo $perusahaan;?></td>
        </tr>
        <?php } ?>
    </tbody>

</table>
</div>
