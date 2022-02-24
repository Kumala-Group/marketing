<script type="text/javascript">
$(document).ready(function(){

      $('.date-picker').datepicker().next().on(ace.click_event, function(){
        $(this).prev().focus();
      });

    //datatables
  $("#per_perusahaan").click(function(){
      var perusahaan= $("#perusahaan").val();
      var bulan= $("#bulan").val();
      $.ajax({
        type    : "GET",
        url     : "<?php echo site_url();?>marketing_dept_lap_summary/summary_per_perusahaan",
        data    : "perusahaan="+perusahaan+"&bulan="+bulan,
        start   : $("#per_perusahaan").html('...Sedang diproses...'),
        dataType: "json",
        success : function(data){
                  $("#per_perusahaan").html('<i class="icon-check"></i> Lihat');
                  table = $('#show_summary').DataTable({
                  "bProcessing": true,
                  "bDestroy": true,
                  "sAjaxSource": '<?php echo site_url();?>marketing_dept_lap_summary/summary_per_perusahaan?perusahaan='+perusahaan+"&bulan="+bulan,
                  "bSort": false,
                   "bAutoWidth": true,
                  "iDisplayLength": 20, "aLengthMenu": [10,20,40,80], // can be removed for basic 10 items per page
                  "sPaginationType": "full_numbers",
                  "aoColumnDefs": [{"bSortable": false,
                                   "aTargets": [ -1 , 0]}], //Feature control DataTables' server-side processing mode.
                  "aoColumns": [
                    {"mData" : "no"},
                    {"mData" : "jenis_event"},
                    {"mData" : "event"},
                    {"mData" : "tgl_mulai"},
                    {"mData" : "tgl_selesai"},
                    {"mData" : "lokasi"},
                    {"mData" : "total_biaya"}
                  ]
              });
                $("#total").val(data.ta);
        },
        error : function(data){
          alert('Data Kosong');
          location.reload();
        }
      });
    });

});


</script>
<div class="row-fluid">
<div class="table-header">
    <?php echo $judul;?>
    <div class="widget-toolbar no-border pull-right">

    </div>
</div>
<div class="space"></div>

<div class="control-group">
    <div class="controls">
                  <?php
                  $now= (int)date('m');
                  $nama_bln = array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                  ?>
      <select name="bulan" id="bulan">
        <option value="<?php echo str_pad($now, 2, '0', STR_PAD_LEFT);?>" selected="selected"><?php echo $nama_bln[$now];?></option>
        <?php
        for($bln=1;$bln<=12;$bln++)
          {
          echo '<option value="'.str_pad($bln, 2, '0', STR_PAD_LEFT).'">'.$nama_bln[$bln].'</option>';
          }
        ?>
        </select>
      &nbsp;
      <?php ?>
      <select name="perusahaan" id="perusahaan">
        <?php
         //$coverage=$this->session->userdata('coverage');
         $data_per_wuling = $this->db->query("SELECT id_perusahaan,singkat,lokasi FROM perusahaan WHERE id_brand='5'");
          foreach($data_per_wuling->result() as $dt){
        ?>
         <option value="<?php echo $dt->id_perusahaan;?>"><?php echo $dt->singkat.' - '.$dt->lokasi;?></option>
        <?php
          }
        ?>
      </select><br>
       <button type="button" name="per_perusahaan" id="per_perusahaan" class="btn btn-small btn-info">
           <i class="icon-check"></i>
           Lihat
       </button>
    </div>
</div>
<br>

              <div class="control-group">
                  <label class="control-label" for="form-field-1">Total Biaya Event</label>
                   <div class="controls">
                      <div class="input-append">
                        <input type="text" name="total" id="total" readonly />
                          <span class="add-on">
                            <i class="icon-money"></i>
                          </span>
                      </div>
                </div>
              </div>
<br>
<table class="table fpTable lcnp table-striped table-bordered table-hover" id="show_summary" width="100%">
    <thead>
        <tr>
            <th class="center">No.</th>
            <th class="center">Jenis Event</th>
            <th class="center">Event</th>
            <th class="center">Tgl. Mulai</th>
            <th class="center">Tgl. Selesai</th>
            <th class="center">Lokasi</th>
            <th class="center">Total Biaya</th>
        </tr>
    </thead>

    <tbody>
    </tbody>

</table>
</div>
