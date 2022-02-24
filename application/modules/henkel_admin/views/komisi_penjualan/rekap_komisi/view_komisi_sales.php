<script type="text/javascript">
$(document).ready(function(){
    $("body").on("click", ".delete", function (e) {
        $(this).parent("div").remove();
    });
});

function cetak_pdf(ID){
    var cari  = ID;
    console.log(cari);
  $.ajax({
    type  : "GET",
    url   : "<?php echo site_url(); ?>henkel_adm_lap_penerima_komisi_sales/cari_komisi_sales",
    data  : "cari="+cari,
    dataType: "json",
    success : function(data){
       window.open("<?php echo site_url(); ?>henkel_adm_lap_penerima_komisi_sales/cetak_pdf_komisi_sales?id_penerima_komisi_sales="+data.id_penerima_komisi_sales+"&tgl_awal="+data.tgl_awal+"&tgl_akhir="+data.tgl_akhir);
    }
  });
}

function cetak_excel(ID){
    var cari  = ID;
    console.log(cari);
  $.ajax({
    type  : "GET",
    url   : "<?php echo site_url(); ?>henkel_adm_lap_penerima_komisi_sales/cari_komisi_sales",
    data  : "cari="+cari,
    dataType: "json",
    success : function(data){
       window.open("<?php echo site_url(); ?>henkel_adm_lap_penerima_komisi_sales/cetak_excel_komisi_sales?id_penerima_komisi_sales="+data.id_penerima_komisi_sales+"&tgl_awal="+data.tgl_awal+"&tgl_akhir="+data.tgl_akhir);
    }
  });
}


</script>
<div class="row-fluid">
<div class="table-header">
    <?php echo $judul;?>
    <div class="widget-toolbar no-border pull-right">
    </div>
</div>

<table class="table fpTable lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Tanggal Awal</th>
            <th class="center">Tanggal Akhir</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $i=1;
        foreach($data->result() as $dt){
       ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo tgl_sql($dt->tgl_awal);?></td>
            <td class="center"><?php echo tgl_sql($dt->tgl_akhir);?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="blue" href="<?php echo site_url();?>henkel_adm_penerima_komisi/hitung_insentif_sales/<?php echo $dt->id_penerima_komisi_sales;?>">
                        <i class="icon-eye-open" data-toggle="tooltip" title="Lihat Total Insentif"></i>
                    </a>

                    <a class="red" onclick="javascript:cetak_pdf('<?php echo $dt->id_penerima_komisi_sales;?>')">
                        <i class="fa fa-file-pdf-o" data-toggle="tooltip" title="Cetak PDF"></i>
                    </a>

                    <!--<a class="green" onclick="javascript:cetak_excel('<?php echo $dt->id_penerima_komisi_sales;?>')">
                        <i class="fa fa-file-excel-o" data-toggle="tooltip" title="Cetak Excel"></i>
                    </a>-->
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
