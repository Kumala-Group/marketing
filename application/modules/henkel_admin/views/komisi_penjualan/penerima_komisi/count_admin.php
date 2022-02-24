<script type="text/javascript">
$(document).ready(function(){


        $("#proses").click(function(){
          var id_perusahaan = 20;
          var no_transaksi = $("#no_transaksi").val();
          $.ajax({
              type    : 'POST',
              url     : "<?php echo site_url(); ?>henkel_adm_penerima_komisi/proses",
              data    : "id_perusahaan="+id_perusahaan+"&no_transaksi="+no_transaksi,
              success : function(data){
                if(data==0){
                  alert('Maaf, Terjadi Kesalahan Pada Sistem');
                  //location.reload();
                }else {
                  location.replace("<?php echo site_url(); ?>henkel_adm_penerima_komisi/tambah_penerima_komisi");
                }
              }
          });
      	});

        $("#simpan").click(function(){
            var string = $("#my-form").serialize();
            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_penerima_komisi/t_simpan_status_komisi",
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

        $("#hitung_komisi_sales").click(function(){
            var string = $("#form_komisi_sales").serialize();
            var id=$("#id").val();
            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_penerima_komisi/t_simpan_komisi_sales",
                data    : string,
                cache   : false,
                start   : $("#simpan").html('...Sedang diproses...'),
                success : function(data){
                    $("#simpan").html('<i class="icon-save"></i> Simpan');
                    alert(data);
                    location.replace("<?php echo site_url(); ?>henkel_adm_penerima_komisi/hitung_insentif_sales/"+id);
                }
            });
        });

});

function editData(ID){
    var cari  = ID;
    console.log(cari);
  $.ajax({
    type  : "GET",
    url   : "<?php echo site_url(); ?>henkel_adm_penerima_komisi/t_cari_status_komisi",
    data  : "cari="+cari,
    dataType: "json",
    success : function(data){
      $('#id_t_penerima_komisi_detail').val(data.id_t_penerima_komisi_detail);
      $('#status_komisi').val(data.status_komisi);
      $('#status_target_penjualan').val(data.status_target_penjualan);
    }
  });
}

function kembali() {
    location.replace("<?php echo site_url(); ?>henkel_adm_lap_penerima_komisi_admin")
}
</script>

<form class="form-horizontal" name="form_komisi_admin" id="form_komisi_admin" action="<?php echo site_url(); ?>henkel_adm_lap_penerima_komisi_admin" method="post">
<div class="row-fluid">
<div class="table-header">
</div>
<div class="space"></div>
<div class="table-header">
 Tabel Penerima Komisi (Admin/Gudang) <?php echo "<br />Periode : ".tgl_sql($tgl_awal).' - '.tgl_sql($tgl_akhir)?>
</div>
<table class="table lcnp table-striped table-bordered table-hover">
  <thead>
      <tr>
          <th class="center">No</th>
          <th class="center">Nik</th>
          <th class="center">Nama Karyawan</th>
          <th class="center">Persentase 1</th>
          <th class="center">Persentase 2 (Admin)</th>
          <th class="center">Jumlah Insentif</th>
      </tr>
  </thead>
  <tbody>
      <?php
      $i=1;


  foreach($data->result() as $dt_komisi) {
    $status_komisi=$dt_komisi->status_komisi;
    $data_satuan = $this->db_kpp->query("SELECT s.id_satuan, COUNT(s.id_satuan) AS total, ka.insentif_pcs
                                         FROM pesanan_penjualan pp
                                         JOIN penjualan p ON p.id_pesanan_penjualan=pp.id_pesanan_penjualan
                                         JOIN item o ON o.kode_item=p.kode_item
                                         JOIN satuan s ON s.kode_satuan=o.kode_satuan
                                         JOIN komisi_admin ka ON ka.id_satuan=s.id_satuan
                                         WHERE (pp.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir') AND ka.id_komisi='$status_komisi'
                                         GROUP BY s.id_satuan
                                        ");
  }

      foreach($data->result() as $dt){
        $jumlah_insentif1=0;
        $jumlah_insentif2=0;
        $take2=0;
      ?>
      <tr>
          <td class="center span1"><?php echo $i++?></td>
          <td class="center"><?php echo $dt->nik;?></td>
          <td class="center"><?php echo $dt->nama_karyawan;?></td>
          <td class="center"><?php echo $dt->persentase1;?></td>
          <td class="center"><?php echo $dt->persentase2;?></td>
          <?php
          foreach ($data_satuan->result() as $ds) {
              if ($dt->persentase2!=0) {
                $take2 += (($ds->total*$ds->insentif_pcs)*$dt->persentase1)/100;
                $jumlah_insentif2 = ($take2*$dt->persentase2)/100;
              } elseif ($dt->persentase2==0) {
                $jumlah_insentif1 += (($ds->total*$ds->insentif_pcs)*$dt->persentase1)/100;
              }
          }
          ?>
          <?php if ($dt->persentase2!=0) {?>
          <td class="center"><?php echo $jumlah_insentif2; ?></td>
          <?php } else { ?>
          <td class="center"><?php echo $jumlah_insentif1; ?></td>
          <?php } ?>
          <?php //$dt->persentase2 ?>
          <!--<td class="center"><?php echo $target_penjualan_detail;?></td>-->
          <!--<td class="td-actions"><center>
              <div class="hidden-phone visible-desktop action-buttons">
                <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_t_penerima_komisi_detail ?>')" data-toggle="modal">
                    <i class="icon-user bigger-130"></i>
                </a>
              </div>

              <div class="hidden-desktop visible-phone">
                  <div class="inline position-relative">
                      <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
                          <i class="icon-caret-down icon-only bigger-120"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-icon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
                          <li>
                            <!--<a class="green" href="#modal-table" onclick="javascript:editData('')" data-toggle="modal">
                                <i class="icon-pencil bigger-130"></i>
                            </a>-->
                          <!--</li>
                          <li>
                              <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                                  <span class="red">
                                      <i class="icon-trash bigger-120"></i>
                                  </span>
                              </a>
                          </li>
                      </ul>-->
                  </div>
              </div>
              </center>
          </td>
      </tr>
      <?php } ?>
  </tbody>
</table>
</form>
</br>
<div class="row-fluid">
     <div class="span12" align="center">
          <button type="submit" class="btn btn-small btn-success">
            <i class="fa fa-sign-out" aria-hidden="true"></i>
              Kembali
          </button>
      </div>
</div>
</div>

<div id="modal-table" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
  <div class="modal-header no-padding">
      <div class="table-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          Tambah Item
      </div>
  </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
              <input type="hidden" name="id_t_penerima_komisi_detail" id="id_t_penerima_komisi_detail">
            <br>
            <div class="control-group">
                <label class="control-label" for="form-field-1">Status Komisi</label>
                <div class="controls">
                  <?php ?>
                  <select name="status_komisi" id="status_komisi">
                    <option value="" selected="selected">--Pilih Status Komisi--</option>
                    <?php
                      $data_komisi = $this->db_kpp->get('komisi');
                      foreach($data_komisi->result() as $dt_komisi){
                    ?>
                     <option value="<?php echo $dt_komisi->id_komisi;?>"><?php echo $dt_komisi->nama_komisi;?></option>
                    <?php
                      }
                    ?>
                   </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-1">Target Penjualan</label>
                <div class="controls">
                  <?php ?>
                  <select name="status_target_penjualan" id="status_target_penjualan">
                    <option value="" selected="selected">--Pilih Target Penjualan--</option>
                    <?php
                      $data_target_penjualan = $this->db_kpp->get('target_penjualan_detail');
                      foreach($data_target_penjualan->result() as $dt_target_penjualan){
                    ?>
                     <option value="<?php echo $dt_target_penjualan->id_target_penjualan_detail;?>"><?php echo $dt_target_penjualan->nama_target;?></option>
                    <?php
                      }
                    ?>
                   </select>
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
<br />
<div id="modal-transaksi" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Cari Transaksi
        </div>
    </div>

    <div class="no-padding">
        <div class="row-fluid">
          <table class="table lcnp table-striped table-bordered table-hover" style='min-width:100%;' id="show_transaksi">
              <thead>
                  <tr>
                      <th class="center">No</th>
                      <th class="center">No Transaksi</th>
                      <th class="center">Umur Transaksi</th>
                  </tr>
              </thead>
              <tbody>
              </tbody>
          </table>
        </div>
    </div>

    <div class="modal-footer">
        <div class="pagination pull-right no-margin">
        <button type="button" class="btn btn-small btn-danger pull-left" data-dismiss="modal">
            <i class="icon-remove"></i>
            Close
        </button>
        </div>
    </div>
</div>
<script type="text/javascript">
function justAngka(e){
       // Allow: backspace, delete, tab, escape, enter and .
       if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A, Command+A
           (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: home, end, left, right, down, up
           (e.keyCode >= 35 && e.keyCode <= 40)) {
                // let it happen, don't do anything
                return;
       }
       // Ensure that it is a number and stop the keypress
       if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
           e.preventDefault();
       }
};
</script>
