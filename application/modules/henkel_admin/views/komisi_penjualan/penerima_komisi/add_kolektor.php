<script type="text/javascript">
$(document).ready(function(){

$('.date-picker').datepicker();

        $("#simpan").click(function(){
            var string = $("#my-form").serialize();
            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_penerima_komisi/t_simpan_penerima_komisi_kolektor_detail",
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

        $("#simpan_info_piutang_exception").click(function(){
            var bayar = $("#bayar").val();
            var string = $("#form-piutang-exception").serialize();

            if(bayar<=0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Bayar tidak boleh nol',
                    class_name: 'gritter-error'
                });

                $("#bayar").focus();
                return false();
            }
            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_penerima_komisi/simpan_info_piutang_exception",
                data    : string,
                cache   : false,
                start   : $("#simpan_info_piutang_exception").html('...Sedang diproses...'),
                success : function(data){
                    $("#simpan_info_piutang_exception").html('<i class="icon-save"></i> Simpan');
                    alert(data);
                    location.reload();
                }
            });
        });

        $("#hitung_komisi_kolektor").click(function(){
            var string = $("#form_komisi_kolektor").serialize();
            var id=$("#id_penerima_komisi_kolektor").val();
            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_penerima_komisi/simpan_penerima_komisi_kolektor_detail",
                data    : string,
                cache   : false,
                start   : $("#hitung_komisi_kolektor").html('...Sedang diproses...'),
                success : function(data){
                    $("#hitung_komisi_kolektor").html('<i class="icon-save"></i> Simpan');
                    alert(data);
                    location.replace("<?php echo site_url(); ?>henkel_adm_penerima_komisi/hitung_insentif_kolektor/"+id);
                }
            });
        });

});

function info_piutang_exception(ID){
    var cari  = ID;
    console.log(cari);
  $.ajax({
    type  : "GET",
    url   : "<?php echo site_url(); ?>henkel_adm_penerima_komisi/cari_info_piutang_exception",
    data  : "cari="+cari,
    dataType: "json",
    success : function(data){
      $('#id_piutang_exception').val(data.id_piutang_exception);
      $('#tanggal_bayar').val(data.tgl_bayar);
      $('#bayar').val(data.bayar);
      $('#keterangan').val(data.keterangan);
    }
  });
}
</script>

<form class="form-horizontal" name="form_komisi_kolektor" id="form_komisi_kolektor" action="<?php echo base_url();?>henkel_adm_pembayaran_hutang/cetak" method="post">
<div class="row-fluid">
<div class="table-header">
  <input type="hidden" value="<?php echo $id_penerima_komisi_kolektor;?>" name="id_penerima_komisi_kolektor" id="id_penerima_komisi_kolektor">
</div>
<div class="space"></div>
<div class="table-header">
 Tabel Penerima Komisi (Kolektor)
</div>
<table class="table lcnp table-striped table-bordered table-hover">
  <thead>
      <tr>
          <th class="center">No</th>
          <th class="center">Nik</th>
          <th class="center">Nama Karyawan</th>
          <!--<th class="center">Status Komisi</th>-->
          <!--<th class="center">Tetapkan Sebagai</th>-->
      </tr>
  </thead>
  <tbody>
      <?php
        $i=1;
        foreach($data_kolektor->result() as $dt){
          $status_komisi = $this->model_penerima_komisi->getKd_status_komisi($dt->status_komisi);
      ?>
      <tr>
          <td class="center span1"><?php echo $i++?></td>
          <td class="center"><?php echo $dt->nik;?></td>
          <td class="center"><?php echo $dt->nama_karyawan;?></td>
          <!--<td class="center"><?php echo $status_komisi;?></td>-->
          <!--<td class="td-actions"><center>
              <div class="hidden-phone visible-desktop action-buttons">
                <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_t_penerima_komisi_kolektor_detail ?>')" data-toggle="modal">
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
                        <!--  </li>
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
          </td>-->
      </tr>
      <?php } ?>
  </tbody>
</table>
</form>
<br />
<div class="table-header">
 Tabel Informasi Piutang
</div>
<table class="table lcnp table-striped table-bordered table-hover">
  <thead>
      <tr>
          <th class="center">No</th>
          <th class="center">No Transaksi</th>
          <th class="center">Tanggal Invoice</th>
          <th class="center">Umur</th>
          <th class="center">Total Transaksi</th>
          <th class="center">Sisa</th>
          <th class="center">Bayar</th>
          <th class="center">Keterangan Bayar</th>
          <th class="center">Aksi</th>
      </tr>
  </thead>
  <tbody>
      <?php
        $i=1;
        foreach($data_piutang_exception->result() as $dt_dpe){
          $datetime1 = new DateTime($dt_dpe->tgl);
          $datetime2 = new DateTime(date('Y-m-d'));
          $interval = $datetime1->diff($datetime2);
          $hitung_umur = $interval->format('%a Hari');
      ?>
      <tr>
          <td class="center span1"><?php echo $i++?></td>
          <td class="center"><?php echo $dt_dpe->no_transaksi;?></td>
          <td class="center"><?php echo $dt_dpe->tgl;?></td>
          <td class="center"><?php echo $hitung_umur;?></td>
          <td class="center"><?php echo 'Rp. '.separator_harga2($dt_dpe->total_akhir);?></td>
          <td class="center"><?php echo 'Rp. '.separator_harga2($dt_dpe->sisa_o);?></td>
          <td class="center"><?php echo 'Rp. '.separator_harga2($dt_dpe->bayar);?></td>
          <td class="center"><?php echo $dt_dpe->keterangan;?></td>
          <td class="td-actions"><center>
              <div class="hidden-phone visible-desktop action-buttons">
                <a class="green" href="#modal-table-info-piutang" onclick="javascript:info_piutang_exception('<?php echo $dt_dpe->id_piutang_exception ?>')" data-toggle="modal">
                    <i class="icon-pencil bigger-130"></i>
                </a>
              </div>

              <div class="hidden-desktop visible-phone">
                  <div class="inline position-relative">
                      <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
                          <i class="icon-caret-down icon-only bigger-120"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-icon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
                          <li>
                            <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt_dpe->id_piutang_exception ?>')" data-toggle="modal">
                                <i class="icon-pencil bigger-130"></i>
                            </a>-->
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
</br>
<div class="row-fluid">
     <div class="span12" align="center">
         <a href="<?php echo base_url();?>henkel_adm_penerima_komisi" class="btn btn-small btn-danger">
             <i class="icon-remove"></i>
             Cancel
         </a>
         <button type="button" name="hitung_komisi_kolektor" id="hitung_komisi_kolektor" class="btn btn-small btn-primary">
             <i class="icon-plus"></i>
             Hitung
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
              <input type="text" name="id_t_penerima_komisi_sales_detail" id="id_t_penerima_komisi_sales_detail">
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
<div id="modal-table-info-piutang" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
  <div class="modal-header no-padding">
      <div class="table-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          Tambah Item
      </div>
  </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="form-piutang-exception" id="form-piutang-exception">
              <input type="text" name="id_piutang_exception" id="id_piutang_exception">
            <br>
            <div class="control-group">
                <label class="control-label" for="form-field-1">Tanggal Bayar</label>

                <div class="controls">
                    <input type="text" name="tanggal_bayar" id="tanggal_bayar" placeholder="Tanggal Bayar" class="date-picker"  data-date-format="dd-mm-yyyy"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-1">Bayar</label>

                <div class="controls">
                    <input type="text" name="bayar" id="bayar" placeholder="Bayar" onkeydown="return justAngka(event)"/> <span style="font-weight:bold"> Rp</span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-1">Keterangan</label>

                <div class="controls">
                    <input type="text" name="keterangan" id="keterangan" placeholder="Keterangan"/>
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
        <button type="button" name="simpan_info_piutang_exception" id="simpan_info_piutang_exception" class="btn btn-small btn-success pull-left">
            <i class="icon-save"></i>
            Simpan
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
