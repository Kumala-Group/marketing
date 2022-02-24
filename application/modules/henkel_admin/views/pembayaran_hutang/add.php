<script type="text/javascript">
$(document).ready(function(){
        $("body").on("click", ".delete", function (e) {
            $(this).parent("div").remove();
        });

        $('.date-picker').datepicker();

        $("#form_kembali").hide();

        $("#kode_supplier").autocomplete({
                // serviceUrl berisi URL ke controller/fungsi yang menangani request kita
                serviceUrl: '<?php echo site_url();?>henkel_adm_search/search_kd_supplier',
                // fungsi ini akan dijalankan ketika user memilih salah satu hasil request
                onSelect: function (suggestion) {
                    $('#nama_supplier').val(''+suggestion.nama_supplier);
                    $('#alamat').val(''+suggestion.alamat);
                }

        });

        $("#nama_supplier").autocomplete({
                // serviceUrl berisi URL ke controller/fungsi yang menangani request kita
                serviceUrl: '<?php echo site_url();?>henkel_adm_search/search_nm_supplier',
                // fungsi ini akan dijalankan ketika user memilih salah satu hasil request
                onSelect: function (suggestion) {
                    $('#kode_supplier').val(''+suggestion.kode_supplier); // membuat id 'v_nim' untuk ditampilkan
                    $('#alamat').val(''+suggestion.alamat); // membuat id 'v_jurusan' untuk ditampilkan
                }

        });

        //datatables
        $("#cari_kode_supplier").click(function(){
            $.ajax({
              type	: "GET",
              url		: "<?php echo site_url();?>henkel_adm_datatable/search_supplier",
              dataType: "json",
              success	: function(data){
                        table = $('#show_supplier').DataTable({
                        "bProcessing": true,
                        "bDestroy": true,
                        "sAjaxSource": '<?php echo site_url();?>henkel_adm_datatable/search_supplier',
                        "bSort": false,
                        "bAutoWidth": true,
                        "iDisplayLength": 10, "aLengthMenu": [10,20,40,80], // can be removed for basic 10 items per page
                        "sPaginationType": "full_numbers",
                        "aoColumnDefs": [{"bSortable": false,
                                         "aTargets": [ -1 , 0]}], //Feature control DataTables' server-side processing mode.
                        "aoColumns": [
                          {"mData" : "no"},
                          {"mData" : "kode_supplier"},
                          {"mData" : "nama_supplier"},
                          {"mData" : "alamat"}
                        ]
                    });
                    $('#modal-supplier').modal('show');
              },
              error : function(data){
                alert('Data Supplier Kosong');
              }
            });
          });

          $('#show_supplier tbody').on( 'click', 'tr', function () {
              var kode_supplier=$(this).find('td').eq(1).text();
              var nama_supplier=$(this).find('td').eq(2).text();
              var alamat=$(this).find('td').eq(3).text();
              $("#kode_supplier").val(kode_supplier);
              $("#nama_supplier").val(nama_supplier);
              $("#alamat").val(alamat);
              $('#modal-supplier').modal('hide');
          });

        $("#new").click(function(){
          var id= $("#id").val();
          $.ajax({
              type    : 'POST',
              url     : "<?php echo site_url(); ?>henkel_adm_pembayaran_hutang/baru",
              data    : "id_new="+id,
              success : function(data){
                location.replace("<?php echo site_url(); ?>henkel_adm_pembayaran_hutang/tambah");
              }
          });
      	});

        $("#cek").click(function(){
          var supplier= $("#kode_supplier").val();
          $.ajax({
              type    : 'POST',
              url     : "<?php echo site_url(); ?>henkel_adm_pembayaran_hutang/cek",
              data    : "kode_supplier="+supplier,
              success : function(data){
                if(data==0){
                  alert('Tidak memiliki hutang kepada supplier dengan Kode '+supplier+' ');
                  location.reload();
                }else {
                  location.replace("<?php echo site_url(); ?>henkel_adm_pembayaran_hutang/tambah");
                }

              }
          });
      	});

        $("#bayar").keyup(function(){
          var total = $('#total').val();
          var bayar = $('#bayar').val();
          var c_total= toAngka(total);
          var c_bayar = toAngka(bayar);
          if(parseFloat(c_bayar)>=parseFloat(c_total)){
            $('#form_kembali').show();
            var kembali_lunas = c_bayar - c_total;
            $('#kembali').val(toHarga(kembali_lunas));
          }else{
            $('#form_kembali').hide();
            var kembali = c_total - c_bayar;
            $('#kembali').val(toHarga(kembali));
          }
      	});

        $("#diskon").keyup(function(){
          var total = $("#kredit").val();
          var diskon = $("#diskon").val();
          $('#total').val(f_diskon(total,diskon));
          $('#form_kembali').hide();
          $('#bayar').val('0');
        });

        $("#diskon_all").keyup(function(){
          var total = $("#total_kredit").val();
          var diskon = $("#diskon_all").val();
          $('#total_akhir').val(f_diskon(total,diskon));
        });

        $("#simpan").click(function(){
            var bayar = $("#bayar").val();
            var kredit = $("#kredit").val();
            var clean_b = bayar.replace(/\D/g,'');
            var clean_k = kredit.replace(/\D/g,'');
            var string = $("#my-form").serialize();
            if(parseInt(bayar)==0){
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
                url     : "<?php echo site_url(); ?>henkel_adm_hutang/t_simpan",
                data    : string,
                cache   : false,
                success : function(data){
                    alert(data);
                    location.reload();
                }
            });
        });

        $("#simpan_pembayaran_hutang").click(function(){
            var id=$("#id").val();
            var kode_supplier = $("#kode_supplier").val();
            var supplier = $("#nama_supplier").val();
            var alamat = $("#alamat").val();
            var total_bayar = $("#total_bayar").val();

            var string = $("#form_pembelian").serialize();

            if(kode_supplier.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Kode Supplier tidak boleh kosong',
                    class_name: 'gritter-error'
                });
                $("#kode_supplier").focus();
                return false();
            }

            if(supplier.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Nama Supplier tidak boleh kosong',
                    class_name: 'gritter-error'
                });
                $("#nama_supplier").focus();
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

            if(total_bayar==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Belum ada Pembayaran',
                    class_name: 'gritter-error'
                });
                return false();
            }

            var r = confirm("Anda sudah yakin? Data yang sudah disimpan tidak dapat diubah lagi");
            if (r == true) {
              $.ajax({
                  type    : 'POST',
                  url     : "<?php echo site_url(); ?>henkel_adm_pembayaran_hutang/t_simpan",
                  data    : string,
                  cache   : false,
                  success : function(data){
                    var id= $("#id").val();
                    alert(data);
                    location.replace("<?php echo site_url(); ?>henkel_adm_pembayaran_hutang/edit/"+id)
                  }
              });
            }else {
              return false();
            }
        });

        $(window).on('beforeunload', function(){
            localStorage.setItem('kode_supplier', $('#kode_supplier').val());
            localStorage.setItem('nama_supplier', $('#nama_supplier').val());
            localStorage.setItem('alamat', $('#alamat').val());
        });

});

window.onload = function() {
  var id=$("#id").val();
  $.ajax({
      type    : 'POST',
      url     : "<?php echo site_url(); ?>henkel_adm_pembayaran_hutang/cek_table",
      data    : "id_cek="+id,
      success : function(data){
        if(data==0){
          $("#kode_supplier").val('');
          $("#nama_supplier").val('');
          $("#alamat").val('');
        }else{
          var kode_supplier = localStorage.getItem('kode_supplier');
          var nama_supplier = localStorage.getItem('nama_supplier');
          var alamat = localStorage.getItem('alamat');
          $('#kode_supplier').val(kode_supplier);
          $('#nama_supplier').val(nama_supplier);
          $('#alamat').val(alamat);
        }
    }
    });
}

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
		url		: "<?php echo site_url(); ?>henkel_adm_hutang/t_cari",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
      var id = $("#id").val();
			$('#id_pembayaran_hutang').val(id);
			$('#id_hutang').val(data.id_t_hutang);
      $('#no_invoice').val(data.no_invoice);
      $('#bayar').val(data.bayar);
      $('#kredit').val(data.kredit);
      $('#sisa').val(data.sisa);
      $('#diskon').val(data.diskon);
      //call function jumlah
      var kredit = data.kredit;
      var bayar = data.bayar;
      var total = f_bayar(kredit,bayar);
      var diskon = data.diskon;
      $('#total').val(f_diskon(total,diskon));
		}
	});
}

function f_bayar(kredit,bayar){
  var clean1 = toAngka(kredit);
  var clean2 = toAngka(bayar);
  var total = clean1 - clean2;
  var bilangan = toHarga(total);
  return bilangan;
}

function f_diskon(hrg,disk){
  var harga = hrg;
  var persen = disk;
  var clean = toAngka(harga);
  var diskon = (clean * persen)/100;
  var total = clean - diskon;
  var bilangan = toHarga(total);
  return bilangan;
}

function separator_harga2(ID){
	var bilangan	= ID;
  var	reverse = bilangan.toString().split('').reverse().join(''),
    ribuan 	= reverse.match(/\d{1,3}/g);
    ribuan	= ribuan.join('.').split('').reverse().join('');
  return ribuan;
}
</script>

<form class="form-horizontal" name="form_pembelian" id="form_pembelian" action="<?php echo base_url();?>henkel_adm_pembayaran_hutang/cetak" method="post">
<div class="row-fluid">
<div class="table-header">
    <?php echo 'No. Transaksi : '.$no_transaksi;?><input type="hidden" name="no_transaksi" id="no_transaksi" value="<?php echo $no_transaksi?>">
    <!--<div class="pull-right" style="padding-right:15px;"><?php echo 'Tanggal : '.tgl_indo($tanggal);?></div><input type="hidden" name="tanggal" id="tanggal" value="<?php echo $tanggal?>">-->
    <input type="hidden" value="<?php echo $id_pembayaran_hutang;?>" name="id" id="id">
</div>
<div class="space"></div>
   <div class="row-fluid">
        <div class="span12">
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Tanggal</label>
                    <div class="controls">
                        <input type="text" class="date-picker" name="tanggal" id="tanggal" placeholder="Tanggal"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kode Supplier</label>
                    <div class="controls">
                        <input type="text" class="autocomplete" value="<?php echo $kode_supplier;?>" name="kode_supplier" id="kode_supplier" placeholder="Kode Supplier" />
                        <button type="button" name="cari_kode_supplier" id="cari_kode_supplier" class="btn btn-small btn-info">
                          <i class="icon-search"></i>
                          Cari
                        </button>
                    </div>
               </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Supplier</label>
                    <div class="controls">
                        <input type="text" class="autocomplete" value="<?php echo $nama_supplier;?>" name="nama_supplier" id="nama_supplier" placeholder="Nama Supplier"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Alamat</label>
                    <div class="controls">
                        <input type="text" class="autocomplete span8" value="<?php echo $alamat;?>" name="alamat" id="alamat" placeholder="Alamat"/>
                    </div>
                </div>
                <div class="control-group">
                   <div class="controls">
                      <button type="button" name="cek" id="cek" class="btn btn-small btn-warning">
                          Cek Hutang
                      </button>
                    </div>
                </div>
         </div>
    </div>
<div class="space"></div>
<div class="table-header">
 Tabel Transaksi Supplier
</div>
<table class="table lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">No Invoice</th>
            <th class="center">Tanggal Invoice</th>
            <th class="center">Total Item</th>
            <th class="center">Jatuh Tempo</th>
            <th class="center">Kredit</th>
            <th class="center">Diskon</th>
            <th class="center">Bayar</th>
            <th class="center">Sisa</th>
            <th class="center">Aksi</th>
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
    			$tgl_jt = strtotime($tanggal);
    			$date = date('Y-m-j', strtotime('+'.$jt.' day', $tgl_jt));
          $total_kredit+=$dt->total_sisa;
          $total_bayar+=$dt->bayar;
          ?>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->no_invoice;?></td>
            <td class="center"><?php echo tgl_sql($dt->tanggal_invoice);?></td>
            <td class="center"><?php echo $dt->total_item_item_masuk;?></td>
            <td class="center"><?php echo tgl_sql($date);?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($dt->sisa);?></td>
            <td class="center"><?php echo $dt->diskon." %";?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($dt->bayar);?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($dt->total_sisa);?></td>
            <td class="td-actions"><center>
                <div class="text-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_t_hutang;?>')" data-toggle="modal">
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
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<div class="row-fluid">
  <div class="span6">
    <div class="control-group">
        <label class="control-label" for="form-field-1"> Keterangan</label>
        <div class="controls">
            <input type="text" class="span12"  value="<?php echo $keterangan; ?>" name="keterangan" id="keterangan" placeholder="Keterangan"/>
        </div>
   </div>
  </div>
  <div class="span6 ">
    <div class="control-group">
        <label class="control-label" for="form-field-1"> Total Bayar</label>
        <div class="controls total_harga">
            <input type="text" class="span12" style="text-align: right;" value="<?php echo separator_harga2($total_bayar); ?>" min='0' name="total_bayar" id="total_bayar" placeholder="0" readonly="readonly"/>
        </div>
   </div>
          <div class="control-group">
              <label class="control-label" for="form-field-1"> Total Sisa</label>
              <div class="controls total_harga">
                  <input type="text" class="span12" style="text-align: right;" value="<?php echo separator_harga2($total_kredit); ?>" min='0' name="total_kredit" id="total_kredit" placeholder="0" readonly="readonly"/>
              </div>
         </div>
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
         <a href="<?php echo base_url();?>henkel_adm_pembayaran_hutang" class="btn btn-small btn-danger">
             <i class="icon-remove"></i>
             Cancel
         </a>
         <button type="button" name="new" id="new" class="btn btn-small btn-success">
             <i class="icon-save"></i>
             Transaksi Baru
         </button>
          <button type="button" name="simpan_pembayaran_hutang" id="simpan_pembayaran_hutang" class="btn btn-small btn-warning">
              <i class="icon-save"></i>
              Simpan
          </button>

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
            <input type="hidden" name="id_hutang" id="id_hutang">
            <input type="hidden" name="id_pembayaran_hutang" id="id_pembayaran_hutang">
            <input type="hidden" name="no_invoice" id="no_invoice">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Tanggal Bayar</label>

                    <div class="controls">
                        <input type="text" name="tanggal_bayar" id="tanggal_bayar" placeholder="Tanggal Bayar" class="date-picker"  data-date-format="dd-mm-yyyy"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kredit</label>

                    <div class="controls">
                        <input type="text" name="kredit" id="kredit" placeholder="0" readonly="readonly"/> <span style="font-weight:bold">Rp</span>
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
                        <input type="text" value="0" min="0" name="total" id="total" placeholder="Total" readonly="readonly" /> <span style="font-weight:bold">Rp</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Bayar</label>
                    <div class="controls">
                        <input type="text" name="bayar" id="bayar" onkeydown="return justAngka(event)" class="number" placeholder="0"/> <span style="font-weight:bold">Rp</span>
                    </div>
                </div>
                <div id="form_kembali" class="control-group">
                    <label class="control-label" for="form-field-1">Kembali</label>
                    <div class="controls">
                        <input type="text" name="kembali" id="kembali" placeholder="0" readonly="readonly"/> <span style="font-weight:bold">Rp</span>
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

<div id="modal-supplier" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Cari Supplier
        </div>
    </div>

    <div class="no-padding">
        <div class="row-fluid">
          <table class="table lcnp table-striped table-bordered table-hover" style='min-width:100%;'  id="show_supplier">
              <thead>
                  <tr>
                      <th class="center">No</th>
                      <th class="center">Kode Supplier</th>
                      <th class="center">Nama Supplier</th>
                      <th class="center">Alamat</th>
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
