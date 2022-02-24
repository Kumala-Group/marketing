<script type="text/javascript">
$(document).ready(function(){
  $("#add").click(function(){

  if(confirm("Apakah Anda Yakin?"))
  {
   var id = [];
   $(':checkbox:checked').each(function(i){
    id[i] = $(this).val();
   });

   if(id.length === 0) //tell you if the array is empty
   {
    alert("Anda belum memilih data");
   }
   else
   {
    var id_leader=$("#id_leader").val();
    $.ajax({
     url:'<?php echo site_url(); ?>wuling_adm_sales_supervisor/simpan_team',
     method:'POST',
     data:{id:id,id_leader:id_leader},
     start : $('#add').html('...sedang diproses...'),
     success:function()
     {
      $('#add').html('<i class="icon-plus"></i>Tambahkan ke Team <?php echo $nama;?>');
      for(var i=0; i<id.length; i++)
      {
       $('tr#'+id[i]+'').css('background-color', '#ccc');
       $('tr#'+id[i]+'').fadeOut('slow');
      }
     }

    });
   }

  }
  else
  {
   return false;
  }
 });

});

</script>
<div class="row-fluid">
<div class="table-header">
    <?php echo $judul.' '.$nama;?>
    <div class="widget-toolbar no-border pull-right">
      <button type="button" name="add" id="add" class="btn btn-small btn-success">
          <i class="icon-plus"></i>
          Tambahkan ke Team <?php echo $nama;?>
      </button>
      <input type="hidden" name="id_leader" id="id_leader" value="<?php echo $id_leader;?>"></input>
    </div>
</div>

<table class="table fpTable lcnp table-striped table-bordered table-hover" id="show_perusahaan">
    <thead>
        <tr>
            <th class="center">NIK</th>
            <th class="center">Nama</th>
            <th class="center">Jabatan</th>
            <th class="center">Perusahaan</th>
            <th class="center"></th>
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
            <td class="center"><input type="checkbox" name="select[]" id="select" value="<?php echo $dt->id_sales;?>"> <span class="lbl"></span></td>
        </tr>
        <?php } ?>
    </tbody>

</table>
</div>
