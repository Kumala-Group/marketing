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
</script>

<form class="form-horizontal" name="form_komisi_sales" id="form_komisi_sales" action="<?php echo base_url();?>henkel_adm_pembayaran_hutang/cetak" method="post">
<div class="row-fluid">
<div class="table-header">
</div>
<div class="space"></div>
<div class="table-header">
 Tabel Penerima Komisi (Sales)
</div>
<table class="table lcnp table-striped table-bordered table-hover">
  <thead>
      <tr>
          <th class="center">No</th>
          <th class="center">Nik</th>
          <th class="center">Nama Karyawan</th>
          <th class="center">Jumlah Insentif</th>
      </tr>
  </thead>
  <tbody>
      <?php
        $i=1;

        $data_total_akhir = $this->db_kpp->query("SELECT pp.total_akhir, pp.tgl, pp.tgl_lunas, pp.kode_sales, gp.nama_group
                                                  FROM pesanan_penjualan pp
                                                  JOIN pelanggan p ON p.kode_pelanggan=pp.kode_pelanggan
                                                  JOIN group_pelanggan gp ON gp.kode_group_pelanggan=p.kode_group_pelanggan
                                                  WHERE (pp.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir') AND pp.status='Lunas'
                                                 ");
        foreach($data->result() as $dt){
          foreach ($data_total_akhir->result() as $dta_a) {
            $total_akhir=0;
            $datetime1 = new DateTime($dta_a->tgl);
            $datetime2 = new DateTime($dta_a->tgl_lunas);
            $interval = $datetime1->diff($datetime2);
            $umur_hutang_total = $interval->format('%a');

            $status_komisi = $dt->status_komisi;
            $status_target_penjualan = $dt->status_target_penjualan;

            $total_akhir += $dta_a->total_akhir;
          }
          $data_status_target_penjualan = $this->db_kpp->query("SELECT * FROM target_penjualan_detail WHERE id_target_penjualan_detail='$status_target_penjualan'");
          $data_status_komisi = $this->db_kpp->query("SELECT * FROM komisi_sales WHERE id_komisi='$status_komisi'");

        foreach ($data_total_akhir->result() as $dta_b) {
        $jumlah_insentif=0;
          foreach ($data_status_target_penjualan->result() as $dstp) {
            foreach ($data_status_komisi->result() as $dsk) {
                if ($dt->nik==$dta_b->kode_sales && $umur_hutang_total>=$dsk->range_hari_awal && $umur_hutang_total<=$dsk->range_hari_akhir && $total_akhir>=$dstp->jumlah_target) {
                  $jumlah_insentif = ($dsk->target_capai*$total_akhir)/100;
                } elseif ($dt->nik==$dta_b->kode_sales && $umur_hutang_total>=$dsk->range_hari_awal && $umur_hutang_total<=$dsk->range_hari_akhir && $total_akhir<$dstp->jumlah_target) {
                  $jumlah_insentif = ($dsk->target_tidakcapai*$total_akhir)/100;
                }
      			 }
           }
         }
      ?>
      <tr>
          <td class="center span1"><?php echo $i++?></td>
          <td class="center"><?php echo $dt->nik;?></td>
          <td class="center"><?php echo $dt->nama_karyawan;?></td>
          <td class="center"><?php echo 'Rp. '. separator_harga2($jumlah_insentif);?></td>
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
<div class="table-header">
 Tabel Penerima Komisi (Supervisor/Operational Manager)
</div>
<div align="center">
  <table class="table lcnp table-striped table-bordered table-hover">
    <?php
      $_om0=0;
      $_spv0=0;
      $_om1=0;
      $_spv1=0;
      $_om2=0;
      $_spv2=0;
      $_om3=0;
      $_spv3=0;
      $_om4=0;
      $_spv4=0;
      foreach ($data_total_akhir->result() as $dta_c) {
        $_retail0=0;
        $_toko0=0;
        $_retail1=0;
        $_toko1=0;
        $_retail2=0;
        $_toko2=0;
        $_retail3=0;
        $_toko3=0;
        $_retail4=0;
        $_toko4=0;
        $datetime1 = new DateTime($dta_c->tgl);
        $datetime2 = new DateTime($dta_c->tgl_lunas);
        $interval = $datetime1->diff($datetime2);
        $umur_hutang_total_c = $interval->format('%a');
        $nama_group = strtolower($dta_c->nama_group);
        if ($umur_hutang_total_c>=0 && $umur_hutang_total_c<=60) {
          if ($nama_group='retail') {
              $_retail0+=$dta_c->total_akhir;
          } elseif ($nama_group='toko') {
              $_toko0+=$dta_c->total_akhir;
          }
        } elseif ($umur_hutang_total_c>=61 && $umur_hutang_total_c<=90) {
          if ($nama_group='retail') {
              $_retail1+=$dta_c->total_akhir;
          } elseif ($nama_group='toko') {
              $_toko1+=$dta_c->total_akhir;
          }
        } elseif ($umur_hutang_total_c>=91 && $umur_hutang_total_c<=120) {
          if ($nama_group='retail') {
              $_retail2+=$dta_c->total_akhir;
          } elseif ($nama_group='toko') {
              $_toko2+=$dta_c->total_akhir;
          }
        } elseif ($umur_hutang_total_c>=121 && $umur_hutang_total_c<=150) {
          if ($nama_group='retail') {
              $_retail3+=$dta_c->total_akhir;
          } elseif ($nama_group='toko') {
              $_toko3+=$dta_c->total_akhir;
          }
        } elseif ($umur_hutang_total_c>=151) {
          if ($nama_group='retail') {
              $_retail4+=$dta_c->total_akhir;
          } elseif ($nama_group='toko') {
              $_toko4+=$dta_c->total_akhir;
          }
        }
      }
    ?>
    <tr>
      <td>No</td>
      <td>TOP (Lunas)</td>
      <td>Retail</td>
      <td>OM</td>
      <td>SPV</td>
      <td>Toko</td>
      <td>OM</td>
      <td>SPV</td>
      <td>Total Insentif (OM)</td>
      <td>Total Insentif (SPV)</td>
    </tr>
    <tr>
      <td>1</td>
      <td>0-60 Hari</td>
      <td><?php echo 'Rp. '.separator_harga2($_retail0);?></td>
      <td>0,30%</td>
      <td>0,10%</td>
      <td><?php echo 'Rp. '.separator_harga2($_toko0);?></td>
      <td>0,30%</td>
      <td>0,10%</td>
      <td>
      <?php
        $_om0=($_retail0*0.30)/100+($_toko0*0.10)/100;
        echo 'Rp. '.separator_harga2($_om0);
      ?>
      </td>
      <td>
        <?php
          $_spv0=($_retail0*0.30)/100+($_toko0*0.10)/100;
          echo 'Rp. '.separator_harga2($_spv0);
        ?>
      </td>
    </tr>
    <tr>
      <td>2</td>
      <td>61-90 Hari</td>
      <td><?php echo 'Rp. '.separator_harga2($_retail1);?></td>
      <td>0,30%</td>
      <td>0,10%</td>
      <td><?php echo 'Rp. '.separator_harga2($_toko1);?></td>
      <td>0,20%</td>
      <td>0,08%</td>
      <td>
      <?php
        $_om1=($_retail1*0.30)/100+($_toko1*0.10)/100;
        echo 'Rp. '.separator_harga2($_om1);
      ?>
      </td>
      <td>
        <?php
          $_spv1=($_retail1*0.20)/100+($_toko1*0.08)/100;
          echo 'Rp. '.separator_harga2($_spv1);
        ?>
      </td>
    </tr>
    <tr>
      <td>3</td>
      <td>91-120 Hari</td>
      <td><?php echo 'Rp. '.separator_harga2($_retail2);?></td>
      <td>0,20%</td>
      <td>0,10%</td>
      <td><?php echo 'Rp. '.separator_harga2($_toko2);?></td>
      <td>0,10%</td>
      <td>0,05%</td>
      <td>
      <?php
        $_om2=($_retail2*0.20)/100+($_toko2*0.10)/100;
        echo 'Rp. '.separator_harga2($_om2);
      ?>
      </td>
      <td>
        <?php
          $_spv2=($_retail2*0.10)/100+($_toko2*0.05)/100;
          echo 'Rp. '.separator_harga2($_spv2);
        ?>
      </td>
    </tr>
    <tr>
      <td>4</td>
      <td>121-150 Hari</td>
      <td><?php echo 'Rp. '.separator_harga2($_retail3);?></td>
      <td>0,10%</td>
      <td>0%</td>
      <td><?php echo 'Rp. '.separator_harga2($_toko3);?></td>
      <td>0,05%</td>
      <td>0%</td>
      <td>
      <?php
        $_om3=($_retail3*0.10)/100+($_toko3*0.05)/100;
        echo 'Rp. '.separator_harga2($_om3);
      ?>
      </td>
      <td>
        <?php
          $_spv3=($_retail3*0)/100+($_toko3*0)/100;
          echo 'Rp. '.separator_harga2($_spv3);
        ?>
      </td>
    </tr>
    <tr>
      <td>5</td>
      <td>151 Hari</td>
      <td><?php echo 'Rp. '.separator_harga2($_retail4);?></td>
      <td>0,10%</td>
      <td>0%</td>
      <td><?php echo 'Rp. '.separator_harga2($_toko4);?></td>
      <td>0,05%</td>
      <td>0%</td>
      <td>
      <?php
        $_om4=($_retail4*0.10)/100+($_toko4*0.05)/100;
        echo 'Rp. '.separator_harga2($_om4);
      ?>
      </td>
      <td>
        <?php
          $_spv4=($_retail4*0)/100+($_toko4*0)/100;
          echo 'Rp. '.separator_harga2($_spv4);
        ?>
      </td>
    </tr>
  </table>
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
