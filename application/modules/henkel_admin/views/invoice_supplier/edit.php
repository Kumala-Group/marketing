<script type="text/javascript">
$(document).ready(function(){
  $("#simpan").click(function(){
      var no_invoice = $("#no_invoice").val();

      var string = $("#form_item_masuk").serialize();

      var r = confirm("Anda Sudah Yakin?");
      if (r == true) {
        $.ajax({
            type    : 'POST',
            url     : "<?php echo site_url(); ?>henkel_adm_invoice_supplier/simpan_noinvoice",
            data    : string,
            cache   : false,
            success : function(data){
                alert(data);
                location.reload();
            }
        });
      } else {
      }
  });
});

function kembali() {
  location.replace("<?php echo site_url(); ?>henkel_adm_invoice_supplier");
}
</script>

<form class="form-horizontal" name="form_item_masuk" id="form_item_masuk" method="post">
<div class="row-fluid">
<div class="table-header">
    <?php echo 'Tanggal: '.tgl_indo($tanggal);?><input type="hidden" name="tanggal" id="tanggal" value="<?php echo tgl_indo($tanggal)?>">
    <input type="hidden" id="id_item_masuk" name="id_item_masuk" value="<?php echo $id_item_masuk ?>"/>
</div>
</br>
<?php
error_reporting(E_ALL ^ E_NOTICE);
?>
<div class="row-fluid">
   <div class="span6">
          <div class="control-group">
                  <label class="control-label" for="form-field-1">No Invoice</label>
              <div class="controls">
                    <input type="text" placeholder="No Invoice" id="no_invoice" name="no_invoice" value="<?php echo $no_invoice ?>"/>
              </div>
          </div>
    </div>
</div>
<div class="space"></div>
<div class="table-header">
 Tabel Item Pembelian Item
 <div class="widget-toolbar no-border pull-right">
 </div>
</div>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Kode Item</th>
            <th class="center">Nama Item</th>
            <th class="center">Tipe</th>
            <th class="center">Kode Gudang</th>
            <th class="center">Nama Gudang</th>
            <th class="center">Item Masuk</th>
            <th class="center">Sub Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no=1;
        $sub_total=0;
          foreach($data->result() as $dt){
            $harga_item= $dt->harga_tebus_dpp;
            $jumlah= $dt->total_item_item_masuk;
            $harga = $harga_item * $jumlah;
            $diskon = $dt->diskon;
            $persen = ($harga * $diskon)/100;
            $total = $harga-$persen;
            $total_akhir += $total;
            $ppn = ($total_akhir * 10)/100;
    				$total_akhir_ppn = $total_akhir+$ppn;
        ?>
        <tr>
            <td class="center"><?php echo $no;?></td>
            <td class="center"><?php echo $dt->kode_item;?></td>
            <td class="center"><?php echo $dt->nama_item;?></td>
            <td class="center"><?php echo $dt->tipe;?></td>
            <td class="center"><?php echo $dt->kode_gudang;?></td>
            <td class="center"><?php echo $dt->nama_gudang;?></td>
            <td class="center"><?php echo $dt->total_item_item_masuk;?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($total);?></td>
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
        <?php $no++; } ?>
    </tbody>
</table>
<div class="row-fluid">
   <!--<div class="span6">
          <div class="control-group">
                  <label class="control-label" for="form-field-1">Total Akhir (+PPN)</label>
              <div class="controls">
                    <input type="text" placeholder="total_akhir_ppn" value="<?php echo 'Rp. '.separator_harga2($total_akhir_ppn); ?>" readonly/>
              </div>
          </div>
    </div>-->
</div>
</br>
</form>

<div class="row-fluid">
     <div class="span12" align="center">
          <button type="button" class="btn btn-small btn-success" id="simpan">
            <i class="icon-save"></i>
              Simpan
          </button>
          <button type="button" onclick="kembali()" class="btn btn-small btn-warning">
            <i class="fa fa-sign-out" aria-hidden="true"></i>
              Kembali
          </button>
      </div>
</div>
</div>
