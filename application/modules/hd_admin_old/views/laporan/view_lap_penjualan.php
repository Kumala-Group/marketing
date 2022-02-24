<script type="text/javascript">
function showDetail(ID){
    var cari    = ID;
    console.log(cari);
    $.ajax({
        type    : "GET",
        url     : "<?php echo site_url(); ?>ban_adm_lap_penjualan/cari",
        data    : "cari="+cari,
        dataType: "json",
        success : function(data){
            //alert(data.ref);
            $('#kode_ban').html(data.kode_ban);
            $('#nama_ban').html(data.nama_ban);
            $('#jumlah').html(data.jumlah);
        }
    });
}
</script>
<table  class="table fpTable lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Tanggal</th>
            <th class="center">No. Transaksi</th>
            <th class="center">Detail</th>
        </tr>
    </thead>
    <tbody>
    <?php
		$i=1;
		    foreach($data->result() as $dt){
		?>
        <tr>
        	<td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo tgl_sql($dt->tgl);?></td>
            <td class="center"><?php echo $dt->no_transaksi;?></td>
            <td class="center"><a class="blue" href="#modal-table-detail" onclick="javascript:showDetail('<?php echo $dt->id_pesanan_penjualan;?>')" data-toggle="modal" title="Detail">
              <i class="fa fa-list" aria-hidden="true"></i>
            </a></td>
        </tr>
		<?php } ?>
    </tbody>
</table>
<div id="modal-table-detail" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Detail Transaksi
        </div>
    </div>

    <div class="modal-body no-padding">
      <table class="table">
        <tr>
          <td>Kode Ban</td>
          <td>Nama Ban</td>
          <td>Jumlah</td>
        </tr>
        <tr>
          <td id="kode_ban_detail"></td>
          <td id="nama_ban_detail"></td>
          <td id="jumlah_detail"></td>
        </tr>
      </table>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-small btn-danger pull-right" data-dismiss="modal">
          <i class="icon-remove"></i>
          Close
      </button>
    </div>
  </div>
