<script type="text/javascript">
$(document).ready(function(){

    $("#simpan").click(function(){
        var id_ban = $("#id_ban").val();
        var kode_ban = $("#kode_ban").val();
        var nama_ban = $("#nama_ban").val();
        var harga_ban = $("#harga_ban").val();
        var satuan = $("#satuan").val();
        var tipe = $("#tipe").val();
        var stock_kritis = $("#stock_kritis").val();

        var string = $("#my-form").serialize();



        if(nama_ban.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Nama Ban tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#nama_ban").focus();
            return false();
        }

        if(harga_ban.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Harga ban tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#harga_ban").focus();
            return false();
        }

        if(tipe.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Tipe tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#tipe").focus();
            return false();
        }

        if(satuan.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Satuan tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#satuan").focus();
            return false();
        }


        if(stock_kritis.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Stock Kritis tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#status_jual").focus();
            return false();
        }

        $.ajax({
            type    : 'POST',
            url     : "<?php echo site_url(); ?>ban_adm/simpan",
            data    : string,
            cache   : false,
            start   : $("#simpan").html('...Sedang diproses...'),
            success : function(data){
                $("#simpan").html('<i class="icon-save"></i> Simpan');
                alert(data);
                location.reload();
            }
        });

    });

    $("#tambah").click(function(){
        $('#id_ban').val('');
        $('#kode_ban').val('<?php echo $kode_ban;?>');
        $('#nama_ban').val('');
        $('#harga_ban').val('');
        $('#satuan').val('');
        $('#tipe').val('');
        $('#stock_kritis').val('');
        $('#nama_ban').focus();

    });
});

function editData(ID){
    var cari    = ID;
    console.log(cari);
    $.ajax({
        type    : "GET",
        url     : "<?php echo site_url(); ?>ban_adm/cari",
        data    : "cari="+cari,
        dataType: "json",
        success : function(data){
            $("#simpan").html('<i class="icon-save"></i> Simpan');
            $('#id_ban').val(data.id_ban);
            $('#kode_ban').val(data.kode_ban);
            $('#nama_ban').val(data.nama_ban);
            $('#harga_ban').val(separator_harga(data.harga_ban));
            $('#tipe').val(data.tipe);
            $('#satuan').html(data.satuan);
            $('#stock_kritis').val(data.stock_kritis);
        }
    });
}

function autoseparator(Num) { //function to add commas to textboxes
        Num += '';
        Num = Num.replace('.', ''); Num = Num.replace('.', ''); Num = Num.replace('.', '');
        Num = Num.replace('.', ''); Num = Num.replace('.', ''); Num = Num.replace('.', '');
        x = Num.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        return x1 + x2;
    }

    function separator_harga(ID){
    	var bilangan	= ID;
      var	reverse = bilangan.toString().split('').reverse().join(''),
        ribuan 	= reverse.match(/\d{1,3}/g);
        ribuan	= ribuan.join('.').split('').reverse().join('');
      return ribuan;
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
            <th class="center">Kode Ban</th>
            <th class="center">Nama Ban</th>
            <th class="center">Harga Jual</th>
            <th class="center">Satuan</th>
            <th class="center">Tipe</th>
            <th class="center">Stock Kritis</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $i=1;
        foreach($data->result() as $dt){ ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td ><?php echo $dt->kode_ban;?></td>
            <td ><?php echo $dt->nama_ban;?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga($dt->harga_ban);?></td>
            <td class="center"><?php echo $dt->kode_satuan;?></td>
            <td class="center"><?php echo $dt->tipe;?></td>
            <td class="center"><?php echo $dt->stock_kritis;?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" id="a" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_ban;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a class="red" href="<?php echo site_url();?>ban_adm/hapus/<?php echo $dt->id_ban;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
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
            Ban
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
              <input type="hidden" name="id_ban" id="id_ban" />
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kode Ban</label>

                    <div class="controls">
                        <input type="text" name="kode_ban" id="kode_ban"  readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Ban</label>

                    <div class="controls">
                        <input type="text" name="nama_ban" id="nama_ban" placeholder="Nama Ban"/><span class="required"> *</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Harga Ban</label>

                    <div class="controls">
                        <input type="text" onkeyup = "javascript:this.value=autoseparator(this.value);" name="harga_ban" id="harga_ban" placeholder="Harga Ban" /><span class="required"> *</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Satuan</label>
                    <div class="controls">
                      <?php ?>
                      <select name="satuan" id="satuan">
                        <option value="" selected="selected">--Pilih Satuan--</option>
                        <?php
                          $data = $this->db_ban->get('satuan');
                          foreach($data->result() as $dt){
                        ?>
                         <option value="<?php echo $dt->kode_satuan;?>"><?php echo $dt->satuan;?></option>
                        <?php
                          }
                        ?>
                       </select>
                       <span class="required"> *</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Tipe</label>

                    <div class="controls">
                        <input type="text" name="tipe" id="tipe" placeholder="Tipe" /><span class="required"> *</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Stock Kritis</label>

                    <div class="controls">
                        <input type="number" name="stock_kritis" id="stock_kritis" class="span3" placeholder="Stock Kritis" /><span class="required"> *</span>
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
