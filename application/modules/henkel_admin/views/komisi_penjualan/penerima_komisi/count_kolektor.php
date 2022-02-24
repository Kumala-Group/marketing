<script type="text/javascript">
$(document).ready(function(){


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

        $("#hitung_komisi_kolektor").click(function(){
            var string = $("#form_komisi_kolektor").serialize();
            var id=$("#id").val();
            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_penerima_komisi/t_simpan_komisi_kolektor",
                data    : string,
                cache   : false,
                start   : $("#simpan").html('...Sedang diproses...'),
                success : function(data){
                    $("#simpan").html('<i class="icon-save"></i> Simpan');
                    alert(data);
                    location.replace("<?php echo site_url(); ?>henkel_adm_penerima_komisi/hitung_insentif_kolektor/"+id);
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
    location.replace("<?php echo site_url(); ?>henkel_adm_lap_penerima_komisi_kolektor")
}
</script>

<form class="form-horizontal" name="form_komisi_kolektor" id="form_komisi_kolektor" action="<?php echo site_url(); ?>henkel_adm_lap_penerima_komisi_admin" method="post">
<div class="row-fluid">
<div class="table-header">
</div>
<div class="space"></div>
<div class="table-header">
 Tabel Penerima Komisi (Kolektor) <?php echo "<br />Periode : ".tgl_sql($tgl_awal).' - '.tgl_sql($tgl_akhir)?>
</div>
<table class="table lcnp table-striped table-bordered table-hover">
  <thead>
      <tr>
          <th class="center">No</th>
          <th class="center">Nik</th>
          <th class="center">Nama Karyawan</th>
          <th class="center">Total Ar (Piutang)</th>
          <th class="center">Total Bayar</th>
          <th class="center">Sisa</th>
          <th class="center">Persentase Pencapaian</th>
          <th class="center">Jumlah Insentif</th>
      </tr>
  </thead>
  <tbody>
      <?php
      $i=1;



    $data_piutang = $this->db_kpp->query("SELECT pp.tgl, pp.no_transaksi, pp.total_akhir, p.bayar
                                          FROM pesanan_penjualan pp
                                          JOIN piutang p ON p.no_transaksi=pp.no_transaksi
                                          WHERE p.tanggal_bayar BETWEEN '$tgl_awal' AND '$tgl_akhir'
                                         ");

   $data_piutang_exception = $this->db_kpp->query("SELECT pp.tgl, pp.no_transaksi, pp.total_akhir, pe.bayar
                                                   FROM pesanan_penjualan pp
                                                   JOIN piutang_exception pe ON pe.no_transaksi=pp.no_transaksi
                                                   WHERE pe.tgl_bayar BETWEEN '$tgl_awal' AND '$tgl_akhir'
                                                  ");
      foreach($data->result() as $dt){
        $total_ar=0;
        $total_ar1=0;
        $total_ar2=0;

        $total_bayar=0;
        $total_p_bayar=0;
        $total_pe_bayar=0;

        $sisa=0;

        $tp=0;
        $tpe=0;

            foreach($data_piutang->result() as $dt_piutang) {
              $total_ar1+=$dt_piutang->total_akhir;
              $total_p_bayar+=$dt_piutang->bayar;

              $datetimetp1 = new DateTime($dt_piutang->tgl);
              $datetimetp2 = new DateTime(date('Y-m-d'));
              $interval1 = $datetimetp1->diff($datetimetp2);
              $hitung_umur1 = $interval1->format('%a');
              if ($hitung_umur1>120) {
                $tp+=$dt_piutang->bayar;
              }
            }

            foreach($data_piutang_exception->result() as $dt_piutang_exception) {
              $total_ar2+=$dt_piutang_exception->total_akhir;
              $total_pe_bayar=$dt_piutang_exception->bayar;

              $datetimetp3 = new DateTime($dt_piutang_exception->tgl);
              $datetimetp4 = new DateTime(date('Y-m-d'));
              $interval2 = $datetimetp3->diff($datetimetp4);
              $hitung_umur2 = $interval2->format('%a');
              if ($hitung_umur2>120) {
                $tpe+=$dt_piutang_exception->bayar;
              }
            }

      ?>
      <tr>
          <td class="center span1"><?php echo $i++?></td>
          <td class="center"><?php echo $dt->nik;?></td>
          <td class="center"><?php echo $dt->nama_karyawan;?></td>
          <?php
            $total_bayar=$total_p_bayar+$total_pe_bayar;
            $total_ar=$total_ar1+$total_ar2;
            $_120=$tp+$tpe;
            $jumlah_insentif=0;
            $sisa=$total_ar-$total_bayar;
            if ($total_bayar && $total_ar==0) {
              $persentase_pencapaian=0;
            } else {
              $persentase_pencapaian=($total_bayar/$total_ar)*100;
            }


            if ($persentase_pencapaian>=0 && $persentase_pencapaian<=59) {
              $jumlah_insentif = (($total_bayar-$_120)*0.15)/100;
            } elseif ($persentase_pencapaian>=60 && $persentase_pencapaian<=79) {
              $jumlah_insentif = (($total_bayar-$_120)*0.25)/100;
            } elseif ($persentase_pencapaian>=80) {
              $jumlah_insentif = (($total_bayar-$_120)*0.3)/100;
            }
          ?>
          <td class="center"><?php echo 'Rp. '.separator_harga2($total_ar);?></td>
          <td class="center"><?php echo 'Rp. '.separator_harga2($total_bayar);?></td>
          <td class="center"><?php echo 'Rp. '.separator_harga2($sisa);?></td>
          <td class="center"><?php echo number_format($persentase_pencapaian, 2).' %'?></td>
          <td class="center"><?php echo 'Rp. '.separator_harga2($jumlah_insentif);?></td>
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
<br />
<div class="row-fluid">
     <div class="span12" align="center">
          <button type="submit" class="btn btn-small btn-success">
            <i class="fa fa-sign-out" aria-hidden="true"></i>
              Kembali
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
