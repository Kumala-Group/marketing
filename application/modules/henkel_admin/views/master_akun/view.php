<script type="text/javascript">
$(document).ready(function(){
    $("#form_parent").hide();

    $("#akun_group").change(function(){
      var akun_group = $("#akun_group").val();
      $.ajax({
          type    : 'POST',
          url     : "<?php echo site_url();?>/henkel_adm_master_akun/max_kode_akun",
          data    : "akun_group="+akun_group,
          dataType: 'json',
           success:function(data){
                $('#kode_akun').val(data.kode_akun);
                $('#level').val('0');
                $('#form_parent').hide();
           }
      });
    });

    $("#level").change(function(){
      var level = $("#level").val();
      var akun_group = $("#akun_group").val();
      if (level>0){
        $.ajax({
            type    : 'POST',
            url     : "<?php echo site_url();?>/henkel_adm_master_akun/search_parent",
            data    : {level:level,akun_group:akun_group},
            dataType: 'json',
             success:function(data){
                  $('#form_parent').show();
                  $('#kode_akun').val('');
                  $('#parent').html(data);
             }
        });
      }else {
        $.ajax({
            type    : 'POST',
            url     : "<?php echo site_url();?>/henkel_adm_master_akun/max_kode_akun",
            data    : "akun_group="+akun_group,
            dataType: 'json',
             success:function(data){
                  $('#kode_akun').val(data.kode_akun);
             }
        });
        $('#form_parent').hide();
      }
    });

    $("#parent").change(function(){
      var parent = $("#parent").val();
      var level = $("#level").val();
      if(parent==''){
        $('#kode_akun').val('');
      }else {
        $.ajax({
            type    : 'POST',
            url     : "<?php echo site_url();?>/henkel_adm_master_akun/max_kode_akun_parent",
            data    : {level:level,parent:parent},
            dataType: 'json',
             success:function(data){
                  $('#kode_akun').val(parent+'.'+data.kode_akun);
             }
        });
      }
    });

    $("#simpan").click(function(){
        var id_akun = $("#id_akun").val();
        var akun_group = $("#akun_group").val();
        var kode_akun = $("#kode_akun").val();
        var nama_akun = $("#nama_akun").val();
        var string = $("#my-form").serialize();
        if(akun_group.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Group tidak boleh kosong',
                class_name: 'gritter-error'
            });
            $("#akun_group").focus();
            return false();
        }

        if(kode_akun.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Kode Akun tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#kode_akun").focus();
            return false();
        }

        if(nama_akun.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Nama Akun tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#nama_akun").focus();
            return false();
        }

        $.ajax({
            type    : 'POST',
            url     : "<?php echo site_url(); ?>/henkel_adm_master_akun/simpan",
            data    : string,
            cache   : false,
            success : function(data){
                alert(data);
                location.reload();
            }
        });

    });

    $("#tambah").click(function(){
        $('#id_akun').val('');
        $('#akun_group').val('');
        $('#level').val('');
        $('#form_parent').hide();
        $('#kode_akun').val('');
        $('#nama_akun').val('');
        $('#parent').val('');

    });
});

function editData(ID){
    var cari    = ID;
    console.log(cari);
    $.ajax({
        type    : "GET",
        url     : "<?php echo site_url(); ?>/henkel_adm_master_akun/cari",
        data    : "cari="+cari,
        dataType: "json",
        success : function(data){
            //alert(data.ref);
            $('#id_akun').val(data.id_akun);
            $('#akun_group').val(data.akun_group);
            $('#level').val(data.level);
            if (data.level>0) {
              $('#form_parent').show();
            }else {
              $('#form_parent').hide();
            }
            $('#parent').html(data.parent);
            $('#parent').val(data.parent2);
            $('#kode_akun').val(data.kode_akun);
            $('#nama_akun').val(data.nama_akun);
        }
    });
}

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
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Kode Akun</th>
            <th class="center">Nama Akun</th>
            <th class="center">Group</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $i=1;
        foreach($data->result() as $dt){
          $kode_akun_group = $this->model_master_akun->getGroup($dt->kode_akun_group);
        ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td ><?php echo $dt->kode_akun;?></td>
            <td ><?php echo $dt->nama_akun;?></td>
            <td class="center"><?php echo $kode_akun_group;?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_akun;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a class="red" href="<?php echo site_url();?>/henkel_adm_master_akun/hapus/<?php echo $dt->id_akun;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
                        <i class="icon-trash bigger-130"></i>
                    </a>
                </div>

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
            Tambah Akun
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
              <input type="hidden" name="id_akun" id="id_akun" />
            <br>
            <div class="control-group">
                <label class="control-label" for="form-field-1">Group Akun</label>
                <div class="controls">
                    <select name="akun_group" id="akun_group" class="span7">
                       <option value="" selected="selected">-- Pilih Group --</option>
                     <?php
                      $data = $this->model_p_akun_group->all();
                      foreach($data->result() as $dt){
                      ?>
                      <option value="<?php echo $dt->kode_akun_group;?>"><?php echo $dt->nama_group_akun;?></option>
                      <?php
                      }
                      ?>
                     </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-1">Level</label>
                <div class="controls">
                    <select name="level" id="level" class="span5">
                       <option value="0"> 1 </option>
                       <option value="1"> 2 </option>
                       <option value="2"> 3 </option>
                     </select>
                </div>
            </div>

            <div id="form_parent" class="control-group">
                <label class="control-label" for="form-field-1">Parent</label>
                <div class="controls">
                    <select name="parent" id="parent" class="span5">
                       <option value="">-- Pilih Parent --</option>
                     </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-1">Kode Akun</label>
                <div class="controls">
                    <input type="text" name="kode_akun" id="kode_akun"  readonly="readonly" />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-1">Nama Akun</label>

                <div class="controls">
                    <input type="text" name="nama_akun" id="nama_akun" placeholder="Nama Akun"/>
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
