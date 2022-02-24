<script type="text/javascript">
$(document).ready(function(){
        $("#simpan").click(function(){
          var head = $("#head").val();
          var inputan_awal = $("#inputan_awal").val();
          var inputan_akhir = parseInt($("#inputan_akhir").val());

          var string = $("#my-form").serialize();


          if(head.length==0){
              $.gritter.add({
                  title: 'Peringatan..!!',
                  text: 'Head tidak boleh kosong',
                  class_name: 'gritter-error'
              });

              $("#head").focus();
              return false();
          }

          if(inputan_awal.length==0){
              $.gritter.add({
                  title: 'Peringatan..!!',
                  text: 'Inputan Awal tidak boleh kosong',
                  class_name: 'gritter-error'
              });

              $("#inputan_awal").focus();
              return false();
          }

          if(inputan_akhir.length==0){
              $.gritter.add({
                  title: 'Peringatan..!!',
                  text: 'Inputan Akhir tidak boleh kosong',
                  class_name: 'gritter-error'
              });

              $("#inputan_akhir").focus();
              return false();
          }
            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_e_faktur/simpan",
                data    : string,
                cache   : false,
                start   : $("#simpan").html('...Sedang diproses...'),
                success : function(data){
                    $("#simpan").html('<i class="icon-save"></i> Simpan');
                    location.reload();
                }
            });

            $("#tambah").click(function(){
                $('#id_e_faktur').val('');
                $('#head').val('');
                $('#inputan_awal').val('');
                $('#inputan_akhir').val('');
            });
        });
});
</script>
<div class="row-fluid">
<div class="table-header">
    <?php echo $judul;?>
    <div class="widget-toolbar no-border pull-right">
        <a href="#modal-table" class="btn btn-small btn-success"  role="button" data-toggle="modal" name="tambah" id="tambah">
            <i class="icon-check"></i>
            Tambah Data
        </a>
    </div>
</div>

<table class="table fpTable lcnp table-striped table-bordered table-hover">
  <div id="alert_message">
  </div>
    <thead>
        <tr>
            <th class="center">ID</th>
            <th class="center">No E-Faktur</th>
            <th class="center">Status</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=1;
        foreach($data->result() as $dt){ ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->no_e_faktur;?></td>
            <?php if ($dt->status==0) {?>
            <td class="center"><?php echo "<span class='label label-warning'>Belum Terpakai</span>";?></td>
            <?php } else if ($dt->status==1) {?>
            <td class="center"><?php echo "<span class='label label-success'>Sudah Terpakai</span>";?></td>
            <?php } ?>
            <td class="td-actions"><center>
            <?php if ($dt->status==0) {?>
                <div class="hidden-phone visible-desktop action-buttons">
                    <!--<a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_e_faktur;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>-->
                    <a class="red" href="<?php echo site_url();?>henkel_adm_e_faktur/hapus/<?php echo $dt->id_e_faktur;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
                        <i class="icon-trash bigger-130"></i>
                    </a>
                </div>
                <?php } else if ($dt->status==1) { ?>
                  <div class="hidden-phone visible-desktop action-buttons">
                      <a class="blue">
                          <i class="icon-lock"></i>
                      </a>
                  </div>
                <?php } ?>

                <div class="hidden-desktop visible-phone">
                    <div class="inline position-relative">
                        <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-caret-down icon-only bigger-120"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-icon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
                            <li>
                                <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
                                    <span class="green">
                                        <i class="icon-edit bigger-120"></i>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                                    <span class="red">
                                        <i class="icon-trash bigger-120"></i>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                </center>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>

<div id="modal-table" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            E - Faktur
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
              <input type="hidden" name="id_e_faktur" id="id_e_faktur" />
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Head</label>

                    <div class="controls">
                        <input type="text" min="0" name="head" id="head" placeholder="Head" /><span class="required"> *</span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-field-1">Dari</label>

                    <div class="controls">
                        <input type="text" min="0" name="inputan_awal" id="inputan_awal" placeholder="Awal" /><span class="required"> *</span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-field-1">Hingga</label>

                    <div class="controls">
                        <input type="text" min="0" name="inputan_akhir" id="inputan_akhir" placeholder="Akhir" /><span class="required"> *</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-footer">
        <div class="pagination pull-right no-margin">
        <button type="button" class="btn btn-small btn-danger pull-left" data-dismiss="modal">
            <i class="icon-remove"></i>
            Close
        </button>
        <button type="button" name="simpan" id="simpan" class="btn btn-small btn-success pull-left">
            <i class="icon-save"></i>
            Simpan
        </button>
        </div>
    </div>
</div>


<!--<script type="text/javascript" language="javascript" >
 $(document).ready(function(){

  //fetch_data();

  function fetch_data() {
      var dataTable = $('#e_faktur_data').DataTable({
       "processing" : true,
       "serverSide" : true,
       "order" : [],
       "ajax" : {
        url:"<?php echo site_url(); ?>henkel_adm_e_faktur/fetchdata",
        type:"POST"
       }
     });
   }

   $('#tambah').click(function(){
     var html = '<tr>';
     html += '<td id="id_e_faktur"><?php echo $id_e_faktur?></td>';
     html += '<td id="no_e_faktur" contenteditable></td>';
     html += '<td id="status"><center>Belum Terpakai</center></td>';
     html += '<td><center><button type="button" name="simpan" id="simpan" class="btn btn-success btn-small">Simpan</button></center></td>';
     html += '</tr>';
     $('#e_faktur_data tbody').prepend(html);
   });

    $(document).on('click', '#simpan', function(){
        var id_e_faktur = $('#id_e_faktur').text();
        var no_e_faktur = $('#no_e_faktur').text();
        var status = $('#status').text();
        if(no_e_faktur != '') {
         $.ajax({
          url:"<?php echo site_url(); ?>henkel_adm_e_faktur/simpan",
          method:'POST',
          data:{id_e_faktur:id_e_faktur, no_e_faktur:no_e_faktur, status:status},
          success:function(data)
          {
           $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
           $('#e_faktur_data').DataTable().destroy();
           //fetch_data();
          }
         });
         setInterval(function(){
          $('#alert_message').html('');
        }, 50000);
        }
        else {
         alert("Both Fields is required");
        }
     });
  });
  /*function update_data(id, column_name, value)
  {
   $.ajax({
    url:"update.php",
    method:"POST",
    data:{id:id, column_name:column_name, value:value},
    success:function(data)
    {
     $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
     $('#user_data').DataTable().destroy();
     fetch_data();
    }
   });
   setInterval(function(){
    $('#alert_message').html('');
   }, 5000);
  }

  $(document).on('blur', '.update', function(){
   var id = $(this).data("id");
   var column_name = $(this).data("column");
   var value = $(this).text();
   update_data(id, column_name, value);
 });*/





  /*$(document).on('click', '.delete', function(){
   var id = $(this).attr("id");
   if(confirm("Are you sure you want to remove this?"))
   {
    $.ajax({
     url:"delete.php",
     method:"POST",
     data:{id:id},
     success:function(data){
      $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      $('#user_data').DataTable().destroy();
      fetch_data();
     }
    });
    setInterval(function(){
     $('#alert_message').html('');
    }, 5000);
   }
 });*/

</script>-->
