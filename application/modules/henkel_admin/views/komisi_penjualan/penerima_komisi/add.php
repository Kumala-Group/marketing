<script type="text/javascript">
$(document).ready(function(){

  $('.date-picker').datepicker();

        $("#proses_sales").click(function(){
          var id_perusahaan = 20;
          var tanggal_awal_sales = $("#tanggal_awal_sales").val();
          var tanggal_akhir_sales = $("#tanggal_akhir_sales").val();

            if (tanggal_awal_sales.length==0) {
              $.gritter.add({
                  title: 'Peringatan..!!',
                  text: 'Tanggal Awal tidak boleh kosong',
                  class_name: 'gritter-error'
              });
              $("#tanggal_awal_sales").focus();
              return false();
            }

            if (tanggal_akhir_sales.length==0) {
              $.gritter.add({
                  title: 'Peringatan..!!',
                  text: 'Tanggal Akhir tidak boleh kosong',
                  class_name: 'gritter-error'
              });
              $("#tanggal_akhir_sales").focus();
              return false();
            }

          $.ajax({
              type    : 'POST',
              url     : "<?php echo site_url(); ?>henkel_adm_penerima_komisi/proses_sales",
              data    : "id_perusahaan="+id_perusahaan+"&tanggal_awal="+tanggal_awal_sales+"&tanggal_akhir="+tanggal_akhir_sales,
              success : function(data){
                if(data==0){
                  alert('Maaf, Terjadi Kesalahan Pada Sistem');
                } else if(data==1){
                  alert('Sudah pernah terjadi pengecekan dalam range tanggal dipilih');
                } else {
                  location.replace("<?php echo site_url(); ?>henkel_adm_penerima_komisi/komisi_sales");
                }
              }
          });
      	});

        $("#proses_kolektor").click(function(){
          var tanggal_awal = $("#tanggal_awal_kolektor").val();
          var tanggal_akhir = $("#tanggal_akhir_kolektor").val();

            if (tanggal_awal.length==0) {
              $.gritter.add({
                  title: 'Peringatan..!!',
                  text: 'Tanggal Awal tidak boleh kosong',
                  class_name: 'gritter-error'
              });
              $("#tanggal_awal").focus();
              return false();
            }

            if (tanggal_akhir.length==0) {
              $.gritter.add({
                  title: 'Peringatan..!!',
                  text: 'Tanggal Akhir tidak boleh kosong',
                  class_name: 'gritter-error'
              });
              $("#tanggal_akhir").focus();
              return false();
            }

          $.ajax({
              type    : 'POST',
              url     : "<?php echo site_url(); ?>henkel_adm_penerima_komisi/proses_kolektor",
              data    : "tanggal_awal="+tanggal_awal+"&tanggal_akhir="+tanggal_akhir,
              success : function(data){
                if(data==0){
                  alert('Maaf, Terjadi Kesalahan Pada Sistem');
                } else if(data==1){
                  alert('Sudah pernah terjadi pengecekan dalam range tanggal dipilih');
                } else {
                  location.replace("<?php echo site_url(); ?>henkel_adm_penerima_komisi/komisi_kolektor");
                }
              }
          });
      	});

        $("#proses_admin").click(function(){
          var id_perusahaan = 20;
          var tanggal_awal = $("#tanggal_awal").val();
          var tanggal_akhir = $("#tanggal_akhir").val();

            if (tanggal_awal.length==0) {
              $.gritter.add({
                  title: 'Peringatan..!!',
                  text: 'Tanggal Awal tidak boleh kosong',
                  class_name: 'gritter-error'
              });
              $("#tanggal_awal").focus();
              return false();
            }

            if (tanggal_akhir.length==0) {
              $.gritter.add({
                  title: 'Peringatan..!!',
                  text: 'Tanggal Akhir tidak boleh kosong',
                  class_name: 'gritter-error'
              });
              $("#tanggal_akhir").focus();
              return false();
            }

          $.ajax({
              type    : 'POST',
              url     : "<?php echo site_url(); ?>henkel_adm_penerima_komisi/proses_admin",
              data    : "id_perusahaan="+id_perusahaan+"&tanggal_awal="+tanggal_awal+"&tanggal_akhir="+tanggal_akhir,
              success : function(data){
                if(data==0){
                  alert('Maaf, Terjadi Kesalahan Pada Sistem');
                } else if(data==1){
                  alert('Sudah pernah terjadi pengecekan dalam range tanggal dipilih');
                } else {
                  location.replace("<?php echo site_url(); ?>henkel_adm_penerima_komisi/komisi_admin");
                }
              }
          });
      	});


});
</script>
<?php
error_reporting(E_ALL ^ E_NOTICE);
?>
<form class="form-horizontal" name="form_penerima_komisi" id="form_penerima_komisi" action="<?php echo base_url();?>henkel_adm_pesanan_penjualan/cetak" method="post">
<div class="row-fluid">
<div class="table-header">
    <?php echo 'Tabel Penerima Komisi (Sales/Supervisor/Operational Manager) ';?>
</div>
<div class="space"></div>
   <div class="row-fluid">
        <div class="span6">
               <div class="control-group">
                   <label class="control-label" for="form-field-1">Tanggal Awal</label>
                   <div class="controls">
                     <div class="input-append">
                       <input type="text" name="tanggal_awal_sales" id="tanggal_awal_sales" class="date-picker"  data-date-format="yyyy-mm-dd" placeholder="Tanggal Awal"/>
                     </div>
                   </div>
                 </div>
                 <div class="control-group">
                     <label class="control-label" for="form-field-1">Tanggal Akhir</label>
                     <div class="controls">
                       <div class="input-append">
                         <input type="text" name="tanggal_akhir_sales" id="tanggal_akhir_sales" class="date-picker"  data-date-format="yyyy-mm-dd" placeholder="Tanggal Akhir"/>
                       </div>
                     </div>
                  </div>
                  <div class="control-group">
                     <div class="controls">
                        <button type="button" name="proses_sales" id="proses_sales" class="btn btn-small btn-success">
                            Proses
                        </button>
                      </div>
                  </div>
         </div>
    </div>
    <?php for ($i=0; $i < 5; $i++) {
      echo "<br />";
    }?>
</div>

<div class="row-fluid">
<div class="table-header">
    <?php echo 'Tabel Penerima Komisi (Admin/Gudang)';?>
</div>
<div class="space"></div>
   <div class="row-fluid">
        <div class="span6">
          <div class="control-group">
              <label class="control-label" for="form-field-1">Tanggal Awal</label>
              <div class="controls">
                <div class="input-append">
                  <input type="text" name="tanggal_awal" id="tanggal_awal" class="date-picker"  data-date-format="yyyy-mm-dd" placeholder="Tanggal Awal"/>
                </div>
              </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-1">Tanggal Akhir</label>
                <div class="controls">
                  <div class="input-append">
                    <input type="text" name="tanggal_akhir" id="tanggal_akhir" class="date-picker"  data-date-format="yyyy-mm-dd" placeholder="Tanggal Akhir"/>
                  </div>
                </div>
              </div>
                  <div class="control-group">
                     <div class="controls">
                        <button type="button" name="proses_admin" id="proses_admin" class="btn btn-small btn-success">
                            Proses
                        </button>
                      </div>
                  </div>
         </div>
    </div>
    <?php for ($i=0; $i < 5; $i++) {
      echo "<br />";
    }?>
</div>

<div class="row-fluid">
<div class="table-header">
    <?php echo 'Tabel Penerima Komisi (Kolektor)';?>
</div>
<div class="space"></div>
   <div class="row-fluid">
        <div class="span6">
          <div class="control-group">
              <label class="control-label" for="form-field-1">Tanggal Awal</label>
              <div class="controls">
                <div class="input-append">
                  <input type="text" name="tanggal_awal_kolektor" id="tanggal_awal_kolektor" class="date-picker"  data-date-format="yyyy-mm-dd" placeholder="Tanggal Awal"/>
                </div>
              </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-1">Tanggal Akhir</label>
                <div class="controls">
                  <div class="input-append">
                    <input type="text" name="tanggal_akhir_kolektor" id="tanggal_akhir_kolektor" class="date-picker"  data-date-format="yyyy-mm-dd" placeholder="Tanggal Akhir"/>
                  </div>
                </div>
              </div>
                  <div class="control-group">
                     <div class="controls">
                        <button type="button" name="proses_kolektor" id="proses_kolektor" class="btn btn-small btn-success">
                            Proses
                        </button>
                      </div>
                  </div>
         </div>
    </div>
<div class="space"></div>
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
