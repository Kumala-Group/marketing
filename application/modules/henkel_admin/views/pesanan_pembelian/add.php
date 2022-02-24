<script type="text/javascript">
$(document).ready(function(){

        $('.date-picker').datepicker();

        $("body").on("click", ".delete", function (e) {
            $(this).parent("div").remove();
        });

        $("#form_kembali").hide();

        $("#kode_supplier").autocomplete({
                // serviceUrl berisi URL ke controller/fungsi yang menangani request kita
                serviceUrl: '<?php echo site_url();?>henkel_adm_pembelian/search_kd_supplier',
                // fungsi ini akan dijalankan ketika user memilih salah satu hasil request
                onSelect: function (suggestion) {
                    $('#nama_supplier').val(''+suggestion.nama_supplier);
                    $('#alamat').val(''+suggestion.alamat);
                }

        });

        $("#nama_supplier").autocomplete({
                // serviceUrl berisi URL ke controller/fungsi yang menangani request kita
                serviceUrl: '<?php echo site_url();?>henkel_adm_pembelian/search_nm_supplier',
                // fungsi ini akan dijalankan ketika user memilih salah satu hasil request
                onSelect: function (suggestion) {
                    $('#kode_supplier').val(''+suggestion.kode_supplier);
                    $('#alamat').val(''+suggestion.alamat);
                }

        });

        /*$("#kode_item").autocomplete({
                // serviceUrl berisi URL ke controller/fungsi yang menangani request kita
                serviceUrl: '<?php echo site_url();?>henkel_adm_pembelian/search_kd_item',
                // fungsi ini akan dijalankan ketika user memilih salah satu hasil request
                onSelect: function (suggestion) {
                    $('#nama_item').val(''+suggestion.nama_item);
                    var harga = parseInt(suggestion.harga_item);
                    var bilangan = separator_harga2(harga);
                    $('#harga_satuan').val('Rp. '+bilangan);
                    $('#harga').val('Rp. '+bilangan);
                    $('#total').val('Rp. '+bilangan);
                }
        });*/

        $("#new").click(function(){
          var id= $("#id").val();
          $.ajax({
              type    : 'POST',
              url     : "<?php echo site_url(); ?>henkel_adm_pesanan_pembelian/baru",
              data    : "id_new="+id,
              success : function(data){
                location.replace("<?php echo site_url(); ?>henkel_adm_pesanan_pembelian/tambah");
              }
          });
      	});

        $("#item_baru").toggle(function(){
          $("#kode_item").val('<?php echo $kode_item_henkel?>');
          $("#kode_item_now").val('<?php echo $kode_item_now_henkel?>');
          $("#nama_item").val('');
          $("#harga_tebus_dpp").val(0);
          $("#nama_item").attr("readonly", false);
        },function(){
          $("#kode_item").val('<?php echo $kode_item_oli?>');
          $("#kode_item_now").val('<?php echo $kode_item_now_oli?>');
          $("#nama_item").val('');
          $("#harga_tebus_dpp").val(0);
          $("#nama_item").attr("readonly", false);
        });

        $("#harga_tebus").keyup(function(){
          var harga_tebus = $("#harga_tebus").val();
          var c_harga_tebus = toAngka(harga_tebus);
          $("#harga_tebus_o").val(c_harga_tebus);
          $("#sub_total_item").val(harga_tebus);
          $('#total').val(harga_tebus);
        });

        $("#jumlah").keyup(function(){
          //call function diskon
          var harga_tebus = $('#harga_tebus').val();
          var jumlah = $('#jumlah').val();
          var c_harga_tebus = toAngka(harga_tebus);
          var sub_total_item = c_harga_tebus * jumlah ;
          $('#sub_total_item').val(toHarga(sub_total_item));
          //call function diskon
          var diskon = $("#diskon").val();
          var persen = (c_harga_tebus*diskon)/100;
          var total = sub_total_item - persen;
          $('#total').val(toHarga(total));
        });

        $("#diskon").keyup(function(){
          var sub_total_item = $("#sub_total_item").val();
          var diskon = $("#diskon").val();
          var total = f_diskon(sub_total_item,diskon);
          $('#total').val(total);
        });

        $("#disk_rp").keyup(function(){
          var disk_rp = $("#disk_rp").val()
          var sub_total_item = $("#sub_total_item").val();
          var c_disk_rp = toAngka(disk_rp);
          var c_sub_total_item = toAngka(sub_total_item);
          var diskon = (c_disk_rp/c_sub_total_item)*100;
          var total = c_sub_total_item - c_disk_rp;
          $('#total').val(toHarga(total));
          $('#diskon').val(diskon);
        });

        $("#diskon_rp").keyup(function(){
          var diskon_rp = $("#diskon_rp").val()
          var harga = $("#total_akhir3").val();
          var c_diskon_rp = toAngka(diskon_rp);
          var c_harga = toAngka(harga);
          var diskon_all= (c_diskon_rp / harga)*100;
          var total = harga - c_diskon_rp;
          $('#total_akhir').val(toHarga(total));
          $('#kredit').val(toHarga(total));
          $('#kredit_o').val(total.toFixed(2));
          $('#diskon_all').val(diskon_all);
        });

        $("#diskon_all").keyup(function(){
          var harga = $("#sub_total_o").val();
          var t_persen = $("#diskon_all").val();
          var persen = 0;
          if ($("#diskon_all").val().length != 0){
              persen = t_persen;
          }else {
            persen = 0;
          }
          var diskon = (parseFloat(harga) * parseFloat(persen))/100;
          var total = parseFloat(harga) - parseFloat(diskon);
          var ppn = (parseFloat(total) * 10)/100;
          var bilangan = parseFloat(total)+parseFloat(ppn);
          var bilangan2 = bilangan.toFixed(2);
          var diskon2 = diskon.toFixed(2);
          $('#total_akhir').val(separator_harga2(bilangan2));
          $('#kredit').val(separator_harga2(bilangan2));
          $('#kredit_o').val(bilangan2);
          $('#diskon_rp').val(separator_harga2(diskon2));
        });

        $("#bayar").keyup(function(){
          //call function diskon
          var bayar = $('#bayar').val();
          var total_akhir = $('#total_akhir3').val();
          var c_bayar = toAngka(bayar);
          var c_total_akhir = toAngka(total_akhir);
          //alert(c_bayar+' - '+c_total_akhir);
          if(parseFloat(c_total_akhir)>0){
            if(parseFloat(c_bayar) >= parseFloat(total_akhir)){
              $('#kredit').val('0');
              $('#status').val('Lunas');
              $('#status').css("color","rgb(5, 166, 16)");
              $('#form_kembali').show();
              var kembali =  total_akhir - c_bayar;
              $('#kembali').val(toHarga(kembali));
            } else {
              var kredit = total_akhir - c_bayar;
              $('#kredit').val(toHarga(kredit));
              $('#kredit_o').val(kredit.toFixed(2));
              $('#status').val('Kredit');
              $('#status').css("color","rgb(218, 142, 12)");
              $('#form_kembali').hide();
            }
          } else {
            $.gritter.add({
                title: 'Peringatan..!!',
                text: 'Total Akhir tidak boleh 0',
                class_name: 'gritter-error'
            });
            $('#bayar').val('0');
          }
      	});

        $("#simpan").click(function(){
            var kode_item = $("#kode_item").val();
            var kode_item_rest = kode_item.substring(3, 5);
            var kode_item_now = $("#kode_item_now").val();
            var kode_item_now_rest = kode_item_now.substring(3, 5);
            var jumlah = $("#jumlah").val();
            var harga_tebus = $("#harga_tebus").val();
            var c_harga_tebus = toAngka(harga_tebus);
            var harga_tebus_dpp = $("#harga_tebus_dpp").val();

            var string = $("#my-form").serialize();

            if(kode_item.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Kode Item tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#kode_item").focus();
                return false();
            }

            if(nama_item.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Nama Item tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#nama_item").focus();
                return false();
            }

            if(c_harga_tebus.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Harga Tebus tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#harga_tebus").focus();
                return false();
            }

            if(jumlah<1){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Jumlah tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#jumlah").focus();
                return false();
            }

            if (kode_item_rest>kode_item_now_rest) {
                $.ajax({
                    type    : 'POST',
                    url     : "<?php echo site_url(); ?>henkel_adm_pembelian/t_simpan",
                    data    : string,
                    cache   : false,
                    start   : $("#simpan").html('Sedang diproses...'),
                    success : function(data){
                        $("#simpan").html('<i class="icon-save"></i> Simpan');
                        alert(data);
                        location.reload();
                    }
                });
          } else {
              if(harga_tebus_dpp==c_harga_tebus){
                  $.ajax({
                    type    : 'POST',
                    url     : "<?php echo site_url(); ?>henkel_adm_pembelian/t_simpan",
                    data    : string,
                    cache   : false,
                    start   : $("#simpan").html('Sedang diproses...'),
                    success : function(data){
                        $("#simpan").html('<i class="icon-save"></i> Simpan');
                        alert(data);
                        location.reload();
                 }
               });
             } else if(harga_tebus_dpp!=c_harga_tebus) {
              var r = confirm("Akan terjadi perubahan harga pada Master Item dengan Kode Item "+kode_item+" Simpan?");
              if (r == true) {
                $.ajax({
                    type    : 'POST',
                    url     : "<?php echo site_url(); ?>henkel_adm_pembelian/t_simpan",
                    data    : string+"&status=changed",
                    cache   : false,
                    start   : $("#simpan").html('Sedang diproses...'),
                    success : function(data){
                        $("#simpan").html('<i class="icon-save"></i> Simpan');
                        alert(data);
                        location.reload();
                    }
                });
              } else {
                $.ajax({
                    type    : 'POST',
                    url     : "<?php echo site_url(); ?>henkel_adm_pembelian/t_simpan",
                    data    : string+"&status=same",
                    cache   : false,
                    start   : $("#simpan").html('Sedang diproses...'),
                    success : function(data){
                        $("#simpan").html('<i class="icon-save"></i> Simpan');
                        alert(data);
                        location.reload();
                    }
                });
              }
            }
        }
    });

        $("#simpan_pesanan_pembelian").click(function(){
            var id=$("#id").val();
            var kode_supplier = $("#kode_supplier").val();
            var keterangan = $("#keterangan").val();
            var tanggal = $("#tanggal").val();

            var string = $("#form_pembelian").serialize();

            if(tanggal.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Tanggal tidak boleh kosong',
                    class_name: 'gritter-error'
                });
                $("#tanggal").focus();
                return false();
            }

            if(kode_supplier.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Kode Supplier tidak boleh kosong',
                    class_name: 'gritter-error'
                });
                $("#kode_supplier").focus();
                return false();
            }

            if(keterangan.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Keterangan tidak boleh kosong',
                    class_name: 'gritter-error'
                });
                $("#keterangan").focus();
                return false();
            }

            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_pesanan_pembelian/cek_table",
                data    : "id_cek="+id,
                success : function(data){
                  if(data==0){
                    $.gritter.add({
                        title: 'Peringatan..!!',
                        text: 'Tabel Item Tidak Boleh Kosong',
                        class_name: 'gritter-error'
                    });
                    return false();
                  }else{
                    $.ajax({
                        type    : 'POST',
                        url     : "<?php echo site_url(); ?>henkel_adm_pesanan_pembelian/t_simpan",
                        data    : string,
                        cache   : false,
                        start   : $("#simpan_pesanan_pembelian").html('Sedang diproses...'),
                        success : function(data){
                          $("#simpan_pesanan_pembelian").html('<i class="icon-save"></i> Simpan');
                          var id= $("#id").val();
                          alert(data);
                          location.replace("<?php echo site_url(); ?>henkel_adm_pesanan_pembelian/edit/"+id)
                        }
                    });
                  }
                }
            });
        });

        //datatables
        $("#cari_kode_item").click(function(){
            $("#nama_item").attr("readonly", true);
            var kode_gudang= $("#kode_gudang").val();
            $.ajax({
              type	: "GET",
              url		: "<?php echo site_url();?>henkel_adm_datatable/search_item",
              dataType: "json",
              success	: function(data){
                        table = $('#show_item').DataTable({
                        "bProcessing": true,
                        "bDestroy": true,
                        "sAjaxSource": '<?php echo site_url();?>henkel_adm_datatable/search_item',
                        "bSort": false,
                        "bAutoWidth": true,
                        "iDisplayLength": 10, "aLengthMenu": [10,20,40,80], // can be removed for basic 10 items per page
                        "sPaginationType": "full_numbers",
                        "aoColumnDefs": [{"bSortable": false,
                                          "aTargets": [ -1, 0]}], //Feature control DataTables' server-side processing mode.
                        "aoColumns": [
                          {"mData" : "no"},
                          {"mData" : "kode_item"},
                          {"mData" : "nama_item"},
                          {"mData" : "harga_tebus_dpp"}
                        ]

                    });
                    $('#modal-item').modal('show');
              },
              error : function(data){
                alert('Data Item Kosong');
              }
            });
          });

          $('#show_item tbody').on( 'click', 'tr', function () {
              var kode_item=$(this).find('td').eq(1).text();
              var nama_item=$(this).find('td').eq(2).text();
              var harga_tebus_dpp=$(this).find('td').eq(3).text();
              $("#kode_item").val(kode_item);
                if (kode_item.substring(0, 4)=='HNKL') {
                  $("#kode_item_now").val('<?php echo $kode_item_now_henkel?>');
                } else if (kode_item.substring(0, 3)=='OLI') {
                  $("#kode_item_now").val('<?php echo $kode_item_now_oli?>');
                }
              $("#nama_item").val(nama_item);
              $("#harga_tebus_dpp").val(harga_tebus_dpp);
              $("#sub_total").val(0);
              $("#total").val(0);
              $('#modal-item').modal('hide');
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

        $("#tambah").click(function(){
          var kode_supplier = $("#kode_supplier").val();

          if(kode_supplier.length==0){
              $.gritter.add({
                  title: 'Peringatan..!!',
                  text: 'Anda Belum Mengisi Kode Supplier',
                  class_name: 'gritter-error'
              });
              $("#kode_supplier").focus();
              return false();
          } else {
          $("#id_pesanan_pembelian").val(<?php echo "$id_pesanan_pembelian" ?>);
          $("#kode_item").val('');
          $("#kode_item_now").val('');
          $("#nama_item").val('');
          $("#harga_tebus").val('');
          $("#harga_tebus_dpp").val('');
          $("#jumlah").val('1');
          $("#sub_total_item").val('');
          $("#diskon").val('');
          $("#disk_rp").val('');
          $("#total").val('');

          $("#modal-table").modal('show');
        }
        });

        $(window).on('beforeunload', function(){
          localStorage.setItem('kode_supplier', $('#kode_supplier').val());
          localStorage.setItem('nama_supplier', $('#nama_supplier').val());
          localStorage.setItem('alamat', $('#alamat').val());
          localStorage.setItem('keterangan', $('#keterangan').val());
        });

        $('#jt_hari').val(Date.today().addDays(0).toString('d-MMMM-yyyy'));

        $("#jt").keyup(function() {
          var jt = parseInt($('#jt').val());
          if(isNaN(jt)) {
            var jt = 0;
          }
          $('#jt_hari').val(Date.today().addDays(jt).toString('d-MMMM-yyyy'));
        });

        $("#jt").bind('keyup mouseup', function () {
          var jt = parseInt($('#jt').val());
          if(isNaN(jt)) {
            var jt = 0;
          }
          $('#jt_hari').val(Date.today().addDays(jt).toString('d-MMMM-yyyy'));
        });
});

window.onload = function() {
  var id=$("#id").val();
  $.ajax({
      type    : 'POST',
      url     : "<?php echo site_url(); ?>henkel_adm_pesanan_pembelian/cek_table",
      data    : "id_cek="+id,
      success : function(data){
        if(data==0){
          $("#kode_supplier").val('');
          $("#nama_supplier").val('');
          $("#alamat").val('');
          $("#keterangan").val('');
        }else{
          var kode_supplier = localStorage.getItem('kode_supplier');
          var nama_supplier = localStorage.getItem('nama_supplier');
          var alamat = localStorage.getItem('alamat');
          var keterangan = localStorage.getItem('keterangan');
          $('#kode_supplier').val(kode_supplier);
          $('#nama_supplier').val(nama_supplier);
          $('#alamat').val(alamat);
          $('#keterangan').val(keterangan);
        }
    }
    });
}

function editData(ID){
    var cari  = ID;
    console.log(cari);
  $.ajax({
    type  : "GET",
    url   : "<?php echo site_url(); ?>henkel_adm_pembelian/t_cari",
    data  : "cari="+cari,
    dataType: "json",
    success : function(data){
      $('#id_t_pembelian').val(data.id_t_pembelian);
      $('#id_pesanan_pembelian').val(data.id_pesanan_pembelian);
      $('#kode_item').val(data.kode_item);
      $('#kode_item_now').val(data.kode_item);
      $('#nama_item').val(data.nama_item);
      $('#harga_tebus').val(toHarga(data.harga_tebus_dpp));
      $('#harga_tebus_dpp').val('Rp. '+data.harga_tebus_master);
      $('#jumlah').val(data.jumlah);
      $('#disk_rp').val(data.disk_rp);
      $('#diskon').val(data.diskon);
      //call function jumlah
      var harga_satuan = data.harga_tebus_dpp;
      var jumlah = data.jumlah;
      var sub_total_item = parseFloat(harga_satuan)*parseFloat(jumlah);
      $('#sub_total_item').val(toHarga(sub_total_item));
      //call function diskon
      var harga = $("#sub_total_item").val();
      var diskon = data.diskon;
      var diskon = (toAngka(harga) * diskon)/100;
      var total = toAngka(harga) - diskon;
      $('#total').val(toHarga(total));
    }
  });
}

function hapusData(id){
  var r = confirm("Anda yakin ingin menghapus data ini?");
  if (r == true) {
  $.ajax({
    		type	: "POST",
    		url		: "<?php echo site_url(); ?>henkel_adm_pembelian/t_hapus/"+id,
    		data	: "id_h="+id,
    		dataType: "json",
    		success	: function(){
          location.reload();
    		}
      });
    }
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

/*function f_diskon(hrg,disk){
  var harga = hrg;
  var persen = disk;
  var diskon = (toAngka(harga) * persen)/100;
  var total = toAngka(harga) - diskon;
  var bilangan = total;
  $("#disk_rp").val(toHarga(diskon));
  return toHarga(bilangan);
}*/

function f_diskon(hrg,disk){
  var harga = hrg;
  var persen = disk;
  var clean = harga.replace(/\D/g,'');
  var diskon = (parseInt(clean) * persen)/100;
  var total = parseInt(clean) - parseInt(diskon);
  var bilangan = separator_harga2(total);
  $("#disk_rp").val(separator_harga2(diskon));
  return bilangan;
}

function separator_harga2(ID){
  var bilangan  = ID;
  var reverse = bilangan.toString().split('').reverse().join(''),
  ribuan  = reverse.match(/\d{1,3}/g);
  ribuan  = ribuan.join('.').split('').reverse().join('');
  return ribuan;
}
</script>
<form class="form-horizontal" name="form_pembelian" id="form_pembelian" method="post">
<div class="row-fluid">
<div class="table-header">
    <?php echo 'No. PO : '.$no_po;?><input type="hidden" name="no_po" id="no_po" value="<?php echo $no_po?>">
    <!--<div class="pull-right" style="padding-right:15px;"><?php echo 'Tanggal : '.tgl_indo($tanggal);?></div><input type="hidden" name="tanggal" id="tanggal" value="<?php echo $tanggal?>">-->
    <input type="hidden" value="<?php echo $id_pesanan_pembelian;?>" name="id" id="id">
</div>
</br>
<?php
error_reporting(E_ALL ^ E_NOTICE);
?>
   <div class="row-fluid">
        <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Tanggal</label>
                    <div class="controls">
                        <input type="text" class="date-picker" data-date-format="yyyy-mm-dd" name="tanggal" id="tanggal" placeholder="Tanggal" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kode Supplier</label>
                    <div class="controls">
                        <input type="text" class="autocomplete" name="kode_supplier" id="kode_supplier" value="<?php echo $kode_supplier;?>" placeholder="Kode Supplier" />
                        <button type="button" name="cari_kode_supplier" id="cari_kode_supplier" class="btn btn-small btn-info">
                          <i class="icon-search"></i>
                          Cari
                        </button>
                    </div>
               </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Supplier</label>
                    <div class="controls">
                        <input type="text" class="autocomplete" name="nama_supplier" id="nama_supplier" placeholder="Nama Supplier" value="<?php echo $nama_supplier;?>" />
                    </div>
                </div>
         </div>
         <div class="span6">
                 <div class="control-group">
                     <label class="control-label" for="form-field-1">Alamat</label>
                     <div class="controls">
                         <?php echo '<textarea name="alamat" id="alamat" readonly="readonly" style="background-color: #F5F5F5; resize: none;" rows="5" placeholder="Alamat">'.$alamat.'</textarea>'; ?>
                     </div>
                 </div>
          </div>
    </div>

<div class="table-header">
 Tabel Item Pembelian Item
 <div class="widget-toolbar no-border pull-right">
   <a data-toggle="modal" name="tambah" id="tambah" class="btn btn-small btn-success">
       <i class="icon-plus"></i>
       Tambah Item
   </a>
 </div>
</div>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Kode Item</th>
            <th class="center">Nama Item</th>
            <th class="center">Harga Tebus</th>
            <th class="center">Jumlah</th>
            <th class="center">Harga</th>
            <th class="center">Diskon</th>
            <th class="center">Total</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=1;
        $total_transaksi=0;
        $total_transaksi_ppn=0;
        $jml = 0;
        foreach($data->result() as $dt){ ?>
        <tr>
          <?php
            $harga_item= $dt->harga_tebus_dpp;
            $jumlah= $dt->jumlah;
            $diskon= $dt->diskon;
            $harga = $harga_item * $jumlah;
            $persen = ($harga * $diskon)/100;
            $total = $harga-$persen;
            $total_transaksi += $total;
            $jml += $jumlah;
        		$ppn = ($total_transaksi * 10)/100;
            $total_transaksi_ppn = $total_transaksi+$ppn;
          ?>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->kode_item;?></td>
            <td class="center"><?php echo $dt->nama_item;?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($dt->harga_tebus_dpp);?></td>
            <td class="center"><?php echo $dt->jumlah;?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($harga);?></td>
            <td class="center"><?php echo $dt->diskon." %";?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($total);?>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_t_pembelian;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a class="red" href="#" onclick="javascript:hapusData('<?php echo $dt->id_t_pembelian;?>')">
                        <i class="icon-trash bigger-130"></i>
                    </a>
                </div>

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
        <?php } ?>
    </tbody>
</table>
</br>
   <div class="row-fluid">
        <div class="span4">
          <div class="control-group">
              <label class="control-label" for="form-field-1">Jatuh Tempo</label>
              <div class="controls">
                  <input type="number" class="span5" value="<?php echo $jt;?>" min="0" name="jt" id="jt" onkeydown="return justAngka(event)" placeholder="" /> <span style="font-weight:bold"> Hari</span> <br />
                  <input type="text" class="span9" value="" name="jt_hari" id="jt_hari" placeholder="" readonly/>
              </div>
          </div>
          <div class="control-group">
              <label class="control-label" for="form-field-1">Keterangan</label>
              <div class="controls total_harga">
                <?php echo '<textarea name="keterangan" id="keterangan" style="resize: none;" rows="5" placeholder="Keterangan" class="span12">'.$keterangan.'</textarea>'; ?>
              </div>
           </div>
        </div>
         <div class="span4">
          <div class="control-group">
               <label class="control-label" for="form-field-1">Bayar(Tunai/DP)</label>
               <div class="controls total_harga">
                   <input type="text" class="span12 number" name="bayar" id="bayar" placeholder="0" />
              </div>
          </div>
          <div class="control-group">
              <label class="control-label" for="form-field-1">Kredit</label>
              <div class="controls total_harga">
                  <input type="text" class="span12" name="kredit" id="kredit" placeholder="0" value="<?php echo separator_harga2($total_transaksi_ppn); ?>" readonly="readonly"/>
                  <input type="hidden" class="span12" name="kredit_o" id="kredit_o" placeholder="0" value="<?php echo number_format($total_transaksi_ppn, 2, '.', ''); ?>" readonly="readonly"/>
              </div>
         </div>
         <div id="form_kembali" class="control-group">
             <label class="control-label" for="form-field-1">Kembali</label>
             <div class="controls">
                 <input class="span12" type="text" value="" name="kembali" id="kembali" placeholder="0" readonly="readonly"/>
             </div>
         </div>
         <div class="control-group">
             <label class="control-label" for="form-field-1">Status</label>
             <div class="controls status">
                 <input type="text" class="span12" style="font-weight:bold" value="<?php echo $status; ?>" name="status" id="status" placeholder="" readonly="readonly"/>
             </div>
        </div>
        </div>
        <div class="span4">
              <div class="control-group">
                    <label class="control-label" for="form-field-1">Total Item</label>
                    <div class="controls total_harga">
                      <input type="text" class="span6" name="total_item" id="total_item" value="<?php echo $jml; ?>" placeholder="Total Item"  readonly="readonly"/>
                    </div>
               </div>
               <div class="control-group">
                   <label class="control-label" for="form-field-1">Sub Total</label>
                   <div class="controls">
                     <input type="text" class="span12" name="sub_total" id="sub_total" value="<?php echo separator_harga2($total_transaksi); ?>" readonly="readonly">
                     <input type="hidden" class="span12" name="sub_total_o" id="sub_total_o" value="<?php echo $total_transaksi; ?>" readonly="readonly">
                   </div>
              </div>
               <div class="control-group">
                   <label class="control-label" for="form-field-1">Diskon</label>
                   <div class="controls">
                        <input class="span4" type="text" max="100"  maxlength="3" name="diskon_all" id="diskon_all" onkeydown="return justAngka(event)" placeholder="0" /><span style="font-weight:bold"> %</span> <br />
                        <input class="span10 number" type="text" name="diskon_rp" id="diskon_rp" placeholder="0" /><span style="font-weight:bold"> Rp</span>
                    </div>
               </div>
             <div class="control-group">
                   <label class="control-label" for="form-field-1">Total Akhir <br /><span style="font-size: 10px;">+PPn (10%)</span></label>
                   <div class="controls">
                     <input type="hidden" class="span12" name="total_akhir2" id="total_akhir2" value="<?php echo $total_transaksi; ?>" placeholder="Total Akhir" readonly="readonly"/>
                     <input type="hidden" class="span12" name="total_akhir3" id="total_akhir3" value="<?php echo number_format($total_transaksi_ppn, 2, '.', ''); ?>" placeholder="Total Akhir" readonly="readonly"/>
                     <input type="text" class="span12" name="total_akhir" id="total_akhir" value="<?php echo separator_harga2($total_transaksi_ppn); ?>" readonly>
                     <input type="hidden" class="span12" name="total_akhir4" id="total_akhir4" value="<?php echo remove_separator2($total_transaksi_ppn); ?>" readonly>
                   </div>
              </div>
        </div>
    </div>
</form>

<div class="row-fluid">
     <div class="span12" align="center">
          <a href="<?php echo base_url();?>index.phphenkel_adm_pesanan_pembelian" class="btn btn-small btn-danger">
             <i class="icon-remove"></i>
             Cancel
          </a>
          <button type="submit" name="new" id="new" class="btn btn-small btn-success">
            <i class="icon-print"></i>
              Transaksi Baru
          </button>
          <button type="button" name="simpan_pesanan_pembelian" id="simpan_pesanan_pembelian" class="btn btn-small btn-warning">
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
            Tambah Item
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
            <input type="hidden" name="id_pesanan_pembelian" id="id_pesanan_pembelian">
            <input type="hidden" name="id_t_pembelian" id="id_t_pembelian">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kode Item</label>

                    <div class="controls">
                        <input type="text" name="kode_item" id="kode_item" placeholder="Kode Item" readonly/>
                        <input type="hidden" name="kode_item_now" id="kode_item_now" placeholder="Kode Item" readonly/>
                        <button type="button" name="cari_kode_item" id="cari_kode_item" class="btn btn-small btn-info">
                          <i class="icon-search"></i>
                          Cari
                        </button>
                        <button type="button" name="item_baru" id="item_baru" class="btn btn-small btn-info">
                          <i class="fa fa-file"></i>
                          Baru
                        </button>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Item</label>

                    <div class="controls">
                        <input type="text" name="nama_item" id="nama_item" placeholder="Nama Item" readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Harga Tebus</label>

                    <div class="controls">
                        <input type="text" name="harga_tebus" id="harga_tebus" placeholder="0" onkeydown="return justAngka(event)" onkeyup="javascript:this.value=autoseparator(this.value);"/>
                        <input type="hidden" name="harga_tebus_o" id="harga_tebus_o" placeholder="0" onkeydown="return justAngka(event)"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Harga Tebus DPP</label>

                    <div class="controls">
                        <input type="text" name="harga_tebus_dpp" id="harga_tebus_dpp" placeholder="Harga Tebus DPP (Master Item)" readonly/><span class="required" style="font-size:9px;">(Master Item)</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Jumlah</label>

                    <div class="controls">
                        <input type="text" value="1" min="1" onkeydown="return justAngka(event)" name="jumlah" id="jumlah" placeholder="Jumlah" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Sub Total</label>

                    <div class="controls">
                        <input type="text" value="0" min="0" name="sub_total_item" id="sub_total_item" placeholder="Sub Total" readonly="readonly"/>
                        <input type="hidden" value="0" min="0" name="sub_total_item_hid" id="sub_total_item_hid" placeholder="Sub Total" readonly="readonly"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Diskon</label>

                    <div class="controls">
                        <input type="text" value="0" onkeydown="return justAngka(event)" min="0" maxlength="3" name="diskon" id="diskon" placeholder="0" /> <span style="font-weight:bold">%</span>
                        <input type="text" class="number" value="0" min="0"  name="disk_rp" id="disk_rp" placeholder="0" /> <span style="font-weight:bold">Rp</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Total</label>

                    <div class="controls">
                        <input type="text" value="0" min="0" name="total" id="total" placeholder="Total" readonly="readonly" />
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
<div id="modal-item" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Cari Item
        </div>
    </div>

    <div class="no-padding">
        <div class="row-fluid">
          <table class="table lcnp table-striped table-bordered table-hover" style='min-width:100%;'  id="show_item">
              <thead>
                  <tr>
                      <th class="center">No</th>
                      <th class="center">Kode Item</th>
                      <th class="center">Nama Item</th>
                      <th class="center">Harga Tebus DPP</th>
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
