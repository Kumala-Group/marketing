<script type="text/javascript">
    $(document).ready(function(){

    $("#simpan").click(function(){
        var nama_sales = $("#nama_sales").val();

        var string = $("#my-form").serialize();


        if(nama_sales.length==0){
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Nama Sales tidak boleh kosong',
                class_name: 'gritter-error'
            });

            $("#nama_sales").focus();
            return false();
        }

        $.ajax({
            type    : 'POST',
            url     : "<?php echo site_url(); ?>henkel_adm_sales/simpan",
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
        $('#kode_sales').val('<?php echo $kode_sales?>');
        $('#nama_sales').val('');
        $('#alamat').val('');
        $('#email').val('');
        $('#jabatan').val('');
    });
});

    function editData(ID){
    var cari    = ID;
    console.log(cari);
    $.ajax({
        type    : "GET",
        url     : "<?php echo site_url(); ?>henkel_adm_sales/cari",
        data    : "cari="+cari,
        dataType: "json",
        success : function(data){
            //alert(data.ref);
            $('#id_sales').val(data.id_sales);
            $('#kode_sales').val(data.kode_sales);
            $('#nama_sales').val(data.nama_sales);
            $('#alamat').val(data.alamat);
            $('#email').val(data.email);
            $('#jabatan').val(data.jabatan);
        }
    });

}
</script>

<div class="row-fluid">
<div class="table-header">
    <div class="widget-toolbar no-border pull-right">
        <a href="#modal-table" class="btn btn-small btn-success"  role="button" data-toggle="modal" name="tambah" id="tambah">
            <i class="icon-check"></i>
            Tambah Data
        </a>
    </div>
    <?php echo $judul;?>
</div>

<table class="table fpTable lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Kode Sales</th>
            <th class="center">Nama Sales</th>
            <th class="center">Alamat</th>
            <th class="center">Email</th>
            <th class="center">Jabatan</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $i=1;
        foreach($data->result() as $dt){
            $jabatan=$this->model_data->JabatanToKaryawan($dt->id_jabatan);
        ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->nik;?></td>
            <td ><?php echo $dt->nama_karyawan;?></td>
            <td class="center"><?php echo $dt->alamat;?></td>
            <td class="center"><?php echo $dt->email;?></td>
            <td class="center"><?php echo $jabatan;?></td>
            <td class="center"><a class="red"><i class="icon-lock"></i></a></td>
        </tr>
        <?php } ?>
    
        <?php
        foreach($data_sales->result() as $dts){
        ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dts->kode_sales;?></td>
            <td ><?php echo $dts->nama_sales;?></td>
            <td class="center"><?php echo $dts->alamat;?></td>
            <td class="center"><?php echo $dts->email;?></td>
            <td class="center"><?php echo $dts->jabatan;?></td>
            <td class="center">
                    <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dts->id_sales;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>
                    <a class="red" href="<?php echo site_url();?>henkel_adm_sales/hapus/<?php echo $dts->id_sales;?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
                        <i class="icon-trash bigger-130"></i>
                    </a>
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
            Sales
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
            <input type="hidden" name="id_sales" id="id_sales">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kode Sales</label>

                    <div class="controls">
                        <input type="text" name="kode_sales" id="kode_sales" readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Sales</label>

                    <div class="controls">
                        <input type="text" name="nama_sales" id="nama_sales" placeholder="Nama Sales"/><span class="required"> *</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Alamat</label>

                    <div class="controls">
                        <input type="text" name="alamat" id="alamat" placeholder="Alamat" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Email</label>

                    <div class="controls">
                        <input type="text" name="email" id="email" placeholder="Email" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Jabatan</label>

                    <div class="controls">
                        <input type="text" name="jabatan" id="jabatan" placeholder="Jabatan" />
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
