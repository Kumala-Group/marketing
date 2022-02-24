<script type="text/javascript">
$(document).ready(function(){
        $("body").on("click", ".delete", function (e) {
            $(this).parent("div").remove();
        });

        $("#form_kembali").hide();

        $("#kode_pelanggan").autocomplete({
                // serviceUrl berisi URL ke controller/fungsi yang menangani request kita
                serviceUrl: '<?php echo site_url();?>henkel_adm_search/search_kd_pelanggan',
                // fungsi ini akan dijalankan ketika user memilih salah satu hasil request
                onSelect: function (suggestion) {
                    $('#nama_pelanggan').val(''+suggestion.nama_pelanggan);
                    $('#alamat').val(''+suggestion.alamat);
                }

        });

        $("#nama_pelanggan").autocomplete({
                // serviceUrl berisi URL ke controller/fungsi yang menangani request kita
                serviceUrl: '<?php echo site_url();?>henkel_adm_search/search_nm_pelanggan',
                // fungsi ini akan dijalankan ketika user memilih salah satu hasil request
                onSelect: function (suggestion) {
                    $('#kode_pelanggan').val(''+suggestion.kode_pelanggan); // membuat id 'v_nim' untuk ditampilkan
                    $('#alamat').val(''+suggestion.alamat); // membuat id 'v_jurusan' untuk ditampilkan
                }

        });

        $("#new").click(function(){
          var id= $("#id").val();
          $.ajax({
              type    : 'POST',
              url     : "<?php echo site_url(); ?>henkel_adm_pembayaran_piutang/baru",
              data    : "id_new="+id,
              success : function(data){
                location.replace("<?php echo site_url(); ?>henkel_adm_pembayaran_piutang/tambah");
              }
          });
      	});

        $("#bayar").keyup(function(){
          var total = $('#total').val();
          var bayar = $('#bayar').val();
          var c_total= parseFloat(toAngka(total));
          var c_bayar = parseFloat(toAngka(bayar));
          if(c_bayar>c_total){
            var kredit = $('#total').val();
            var bayar = $('#bayar').val();
            $('#form_kembali').show();
            $('#kembali').val(f_bayar(toAngka(kredit),toAngka(bayar)));
          }else{
            $('#form_kembali').hide();
            var kembali = c_total-c_bayar;
            $('#kembali').val(toHarga(kembali));
          }
      	});

        $("#diskon").keyup(function(){
          var total = $("#kredit").val();
          var diskon = $("#diskon").val();
          $('#total').val(f_diskon(toAngka(total),diskon));
          $('#form_kembali').hide();
          $('#bayar').val('0');
        });

        $("#diskon_all").keyup(function(){
          var total = $("#total_kredit").val();
          var diskon = $("#diskon_all").val();
          $('#total_akhir').val(f_diskon(toAngka(total),diskon));
        });

        $("#simpan").click(function(){
            var bayar = $("#bayar").val();
            var kredit = $("#kredit").val();
            var clean_b = toAngka(bayar);
            var clean_k = toAngka(kredit);
            var string = $("#my-form").serialize();
            if(parseFloat(toAngka(bayar))==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Bayar tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#bayar").focus();
                return false();
            }

            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_piutang/simpan",
                data    : string,
                cache   : false,
                success : function(data){
                    alert(data);
                    location.reload();
                }
            });
        });

        $("#simpan_pembayaran_piutang").click(function(){
            var id=$("#id").val();
            var kode_pelanggan = $("#kode_pelanggan").val();
            var pelanggan = $("#nama_pelanggan").val();
            var alamat = $("#alamat").val();
            var string = $("#form_penjualan").serialize();

            if(kode_pelanggan.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Kode Pelanggan tidak boleh kosong',
                    class_name: 'gritter-error'
                });
                $("#kode_pelanggan").focus();
                return false();
            }

            if(pelanggan.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Nama Pelanggan tidak boleh kosong',
                    class_name: 'gritter-error'
                });
                $("#nama_pelanggan").focus();
                return false();
            }

            if(alamat.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Alamat tidak boleh kosong',
                    class_name: 'gritter-error'
                });
                $("#alamat").focus();
                return false();
            }

            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_pembayaran_piutang/cek_table",
                data    : "id_cek="+id,
                success : function(data){
                    $.ajax({
                        type    : 'POST',
                        url     : "<?php echo site_url(); ?>henkel_adm_pembayaran_piutang/simpan",
                        data    : string,
                        cache   : false,
                        success : function(data){
                          var id= $("#id").val();
                          alert(data);
                          location.replace("<?php echo site_url(); ?>henkel_adm_pembayaran_piutang/edit/"+id)
                        }
                    });
                }
            });
        });

        var cetak_piutang = 1;
        $("#cetak").click(function(){
          $("#cetak_piutang").val(cetak_piutang++);
          cetak();
        });

});

function autoseparator(Num) { //function to add commas to textboxes
        Num += '';
        Num = Num.replace('.', ''); Num = Num.replace('.', ''); Num = Num.replace('.', '');
        Num = Num.replace('.', ''); Num = Num.replace('.', ''); Num = Num.replace('.', '');
        x = Num.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        return x1 + x2;
    }

    function editData(ID){
    	  var cari	= ID;
        console.log(cari);
    	$.ajax({
    		type	: "GET",
    		url		: "<?php echo site_url(); ?>henkel_adm_piutang/cari",
    		data	: "cari="+cari,
    		dataType: "json",
    		success	: function(data){
          var id = $("#id").val();
    			$('#id_pembayaran_piutang').val(id);
    			$('#id_piutang').val(data.id_piutang);
          $('#no_penjualan').val(data.no_penjualan);
          $('#bayar').val(data.bayar);
          $('#kredit').val(data.kredit);
          $('#sisa').val(data.sisa);
          $('#diskon').val(data.diskon);
          //call function jumlah
          var kredit = data.kredit;
          var bayar = data.bayar;
          $('#total').val(f_bayar(kredit,bayar));
          var total = $("#kredit").val();
          var diskon = data.diskon;
          $('#total').val(f_diskon(toAngka(total),diskon));
          var kredit = $('#total').val();
          var bayar = $('#bayar').val();
          $('#form_kembali').show();
          $('#kembali').val(f_bayar(toAngka(kredit),toAngka(bayar)));
    		}
    	});

    }

function f_bayar(kredit,bayar){
  var kredit = kredit;
  var bayar = bayar;
  var clean1 = parseFloat(kredit);
  var clean2 = parseFloat(bayar);
  var total = clean1 - clean2;
  var bilangan = toHarga(total);
  return bilangan;
}

function f_diskon(hrg,disk){
  var harga = hrg;
  var persen = disk;
  var clean = parseFloat(harga);
  var diskon = (clean * persen)/100;
  var total = clean - diskon;
  var bilangan = toHarga(parseFloat(total));
  return bilangan;
}

function cetak() {
    var id= $("#id").val();
    var no_transaksi= $("#no_transaksi").val();
    var tgl= $("#tanggal").val();
    var kode_pelanggan= $("#kode_pelanggan").val();
    var alamat= $("#alamat").val();
    var nama_pelanggan= $("#nama_pelanggan").val();
    var total_bayar= $("#total_bayar").val();
    var total_sisa= $("#total_kredit").val();
    var sisa_kredit= $("#total_kredit").val();
    var keterangan= $("#keterangan").val();
    var cetak_piutang= $("#cetak_piutang").val();
    window.open("<?php echo site_url(); ?>henkel_adm_pembayaran_piutang/cetak?id="+id+"&no_transaksi="+no_transaksi+"&tanggal="+tgl+"&kode_pelanggan="+kode_pelanggan+"&alamat="+alamat+"&nama_pelanggan="+nama_pelanggan+"&total_bayar="+total_bayar+"&total_sisa="+total_sisa+"&sisa_kredit="+sisa_kredit+"&keterangan="+keterangan+"&cetak_piutang="+cetak_piutang)
}

function separator_harga2(ID){
	var bilangan	= ID;
  var	reverse = bilangan.toString().split('').reverse().join(''),
    ribuan 	= reverse.match(/\d{1,3}/g);
    ribuan	= ribuan.join('.').split('').reverse().join('');
  return ribuan;
}
</script>

<form class="form-horizontal" name="form_penjualan" id="form_penjualan" action="<?php echo base_url();?>henkel_adm_pembayaran_piutang/cetak" method="post">
<div class="row-fluid">
<div class="table-header">
    <?php echo 'No. Transaksi : '.$no_transaksi;?><input type="hidden" name="no_transaksi" id="no_transaksi" value="<?php echo $no_transaksi?>">
    <div class="pull-right" style="padding-right:15px;"><?php echo 'Tanggal : '.tgl_indo($tanggal);?></div><input type="hidden" name="tanggal" id="tanggal" value="<?php echo $tanggal?>">
    <input type="hidden" value="<?php echo $id_pembayaran_piutang;?>" name="id" id="id">
</div>
<div class="space"></div>
   <div class="row-fluid">
        <div class="span12">
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kode Pelanggan</label>
                    <div class="controls">
                        <input type="text" class="autocomplete" value="<?php echo $kode_pelanggan;?>" name="kode_pelanggan" id="kode_pelanggan" placeholder="Kode Pelanggan" readonly/>
                    </div>
               </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Pelanggan</label>
                    <div class="controls">
                        <input type="text" class="autocomplete" value="<?php echo $nama_pelanggan;?>" name="nama_pelanggan" id="nama_pelanggan" placeholder="Nama Pelanggan" readonly/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Alamat</label>
                    <div class="controls">
                        <input type="text" class="autocomplete span8" value="<?php echo $alamat;?>" name="alamat" id="alamat" placeholder="Alamat" readonly/>
                    </div>
                </div>
         </div>
    </div>
<div class="space"></div>
<div class="table-header">
 Tabel Transaksi Pelanggan
</div>
<table class="table lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">No Transaksi</th>
            <th class="center">Tanggal</th>
            <th class="center">Total Item</th>
            <th class="center">Jt</th>
            <th class="center">Kredit</th>
            <th class="center">Diskon</th>
            <th class="center">Bayar</th>
            <th class="center">Sisa</th>
            <!--<th class="center">Aksi</th>-->
        </tr>
    </thead>
    <tbody>
        <?php
        $i=1;
        $total_sisa=0;
        $total_kredit=0;
        $total_bayar=0;
        foreach($data->result() as $dt){ ?>
        <tr>
          <?php
          $jt = $dt->jt;
          $tgl_jt = strtotime($dt->tgl);
          $date = date('Y-m-j', strtotime('+'.$jt.' day', $tgl_jt));
          $total_kredit+=$dt->total_sisa;
          $total_bayar+=$dt->bayar;
          $total_sisa+=$sisa;
          ?>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->no_transaksi;?></td>
            <td class="center"><?php echo tgl_sql($dt->tgl);?></td>
            <td class="center"><?php echo $dt->total_item;?></td>
            <td class="center"><?php echo tgl_sql($date);?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($dt->sisa);?></td>
            <td class="center"><?php echo $dt->diskon." %";?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($dt->bayar);?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($dt->total_sisa);?></td>
            <!--<td class="td-actions"><center>
                <div class="text-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_piutang;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>
                </div>

                <div class="text-desktop visible-phone">
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
            </td>-->
        </tr>
        <?php } ?>
    </tbody>

    <!-- Jika Metode Pembayaran BG -->
    <tbody>
        <?php
        /*$total_sisa=0;
        $total_kredit=0;
        $total_bayar=0;*/
        foreach($data_exception->result() as $dt_exception){ ?>
        <tr>
          <?php
          $jt = $dt_exception->jt;
          $tgl_jt = strtotime($dt_exception->tgl);
          $date = date('Y-m-j', strtotime('+'.$jt.' day', $tgl_jt));
          /*$total_kredit+=$dt_exception->total_sisa;
          $total_bayar+=$dt_exception->bayar;
          $total_sisa+=$sisa;*/
          ?>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt_exception->no_transaksi;?></td>
            <td class="center"><?php echo tgl_sql($dt_exception->tgl);?></td>
            <td class="center"><?php echo $dt_exception->total_item;?></td>
            <td class="center"><?php echo tgl_sql($date);?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($dt_exception->sisa);?></td>
            <td class="center"><?php echo $dt_exception->diskon." %";?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($dt_exception->bayar);?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($dt_exception->total_sisa);?></td>
            <!--<td class="td-actions"><center>
                <div class="text-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_piutang;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>
                </div>

                <div class="text-desktop visible-phone">
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
            </td>-->
        </tr>
        <?php } ?>
    </tbody>
</table>
<div class="row-fluid">
  <div class="span6">
    <div class="control-group">
        <label class="control-label" for="form-field-1"> Keterangan</label>
        <div class="controls">
            <input type="text" class="span12"  value="<?php echo $keterangan; ?>" name="keterangan" id="keterangan" placeholder="Keterangan" readonly/>
        </div>
   </div>
  </div>
  <div class="span6 ">
    <div class="control-group">
        <label class="control-label" for="form-field-1"> Total Bayar</label>
        <div class="controls total_harga">
            <input type="text" class="span12 number" style="text-align: right;" value="<?php echo separator_harga2($total_bayar); ?>" min='0' name="total_bayar" id="total_bayar" placeholder="0" readonly="readonly"/>
        </div>
   </div>
          <div class="control-group">
              <label class="control-label" for="form-field-1"> Total Sisa</label>
              <div class="controls total_harga">
                  <input type="text" class="span12 number" style="text-align: right;" value="<?php echo separator_harga2($sisa_kredit); ?>" min='0' name="total_kredit" id="total_kredit" placeholder="0" readonly="readonly"/>
              </div>
         </div>
        <input type="hidden" value="0" min="0" name="cetak_piutang" id="cetak_piutang" readonly="readonly" />
   </div>
 </div>
 <br>
 <div class="row-fluid">

 </div>
 <br>

</form>
</br>
<div class="row-fluid">
     <div class="span12" align="center">
       <a href="<?php echo base_url();?>henkel_adm_pembayaran_piutang" class="btn btn-small btn-danger">
           <i class="icon-remove"></i>
           Close
       </a>
       <button type="button" name="cetak" id="cetak" class="btn btn-small btn-primary">
       <i class="icon-print"></i> Cetak
       </button>
         <button type="button" name="new" id="new" class="btn btn-small btn-success">
             <i class="icon-save"></i>
             Transaksi Baru
         </button>
         <!--<button type="button" name="simpan_pembayaran_piutang" id="simpan_pembayaran_piutang" class="btn btn-small btn-warning">
            <i class="icon-save"></i>
            Simpan
         </button>-->
      </div>
</div>

</div>

<div id="modal-table" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Bayar
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
            <input type="hidden" name="id_piutang" id="id_piutang">
            <input type="hidden" name="id_pembayaran_piutang" id="id_pembayaran_piutang">
            <input type="hidden" name="no_penjualan" id="no_penjualan">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kredit</label>

                    <div class="controls">
                        <input type="text" class="number" name="kredit" id="kredit" placeholder="0" readonly="readonly"/> <span style="font-weight:bold">Rp</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Diskon</label>

                    <div class="controls">
                        <input type="text" class="span2" value="0" onkeydown="return justAngka(event)" min="0" maxlength="3" name="diskon" id="diskon" placeholder="Diskon" /> <span style="font-weight:bold">%</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Total</label>

                    <div class="controls">
                        <input type="text" class="number" value="0" min="0" name="total" id="total" placeholder="Total" readonly="readonly" /> <span style="font-weight:bold">Rp</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Bayar</label>
                    <div class="controls">
                        <input type="text" class="number" name="bayar" id="bayar" onkeydown="return justAngka(event)"  placeholder="0"/> <span style="font-weight:bold">Rp</span>
                    </div>
                </div>
                <div id="form_kembali" class="control-group">
                    <label class="control-label" for="form-field-1">Kembali</label>
                    <div class="controls">
                        <input type="text"  class="number" value=""  name="kembali" id="kembali" placeholder="0" readonly="readonly"/> <span style="font-weight:bold">Rp</span>
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
