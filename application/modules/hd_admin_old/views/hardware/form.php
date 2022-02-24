<div class="">
    <div class="widget-box">
        <div class="widget-header">
            <h4><i class="icon-user"></i> <?php echo $judul;?></h4>
            <div class="widget-toolbar no-border pull-right">


            </div>
        </div>
        <div class="widget-body">
            <div class="widget-main">
                <div class="row-fluid">
					<form action="<?php echo site_url();?>hd_adm_hardware/view_data" method="post">
                        <label class="control-label" for="form-field-1">Filter Perusahaan</label>
                        <div class="controls">
                        <select name="cari_perusahaan" id="cari_perusahaan">
                        <?php
                        foreach($perusahaan as $dt){
                        ?>
                        <option value="<?php echo $dt->id_perusahaan;?>"><?php echo $dt->singkat.' - '.$dt->lokasi;?></option>
                        <?php
                        }
                        ?>
                        </select>
                        </div>
                        <button type="submit" name="lanjut" id="lanjut" class="btn btn-small btn-success" >
                        Lanjut
                        <i class="icon-arrow-right icon-on-right bigger-110"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><!--/span-->


</div>
