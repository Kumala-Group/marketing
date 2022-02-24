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

<div id="modal-table" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Bank
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
            <input type="hidden" name="id_bank" id="id_bank">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kode Bank</label>

                    <div class="controls">
                        <input type="text" name="kode_bank" id="kode_bank" readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Bank</label>

                    <div class="controls">
                        <input type="text" name="bank" id="bank" placeholder="Bank"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">No Rekening</label>

                    <div class="controls">
                        <input type="text" name="no_rekening" id="no_rekening" placeholder="No Rekening"/>
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
