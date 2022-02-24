<script type="text/javascript">
$(document).ready(function(){
        $("body").on("click", ".delete", function (e) {
            $(this).parent("div").remove();
        });
        $("#tunai").keyup(function(){
          var tp=$('#total_penjualan').val();
          var t=$('#tunai').val();
          $('#sisa').val(sisa(toAngka(tp),toAngka(t)));
        });

        $("#enable").change(function() {
          if(this.checked) {
              $('#deposit').val('0');
              $('#tunai').attr('readonly', false);
              $('#tunai').focus();
              $('#enable_deposit').attr('disabled', true);
          }else {
              $('#tunai').attr('readonly', true);
              $('#enable_deposit').attr('disabled', false);
              $('#tunai').val('0')
          }
      });

      $("#enable_deposit").change(function() {
        if(this.checked) {
            $('#tunai').val('0');
            $('#deposit').attr('readonly', false);
            $('#deposit').focus();
            $('#enable').attr('disabled', true);
        }else {
            $('#deposit').attr('readonly', true);
            $('#enable').attr('disabled', false);
            $('#deposit').val('0');
        }
    });

    $("#enable_pot_piutang").change(function() {
      if(this.checked) {
          var total_retur=$('#total_retur').val();
          $('#potong_piutang').val(total_retur);
          $('#potong_piutang').attr('readonly', false);
          $('#potong_piutang').focus();
      }else {
          $('#potong_piutang').attr('readonly', true);
          $('#potong_piutang').val('0');
      }
  });
        //datatables
        $("#show").click(function(){
            var pelanggan= $("#kode_pelanggan").val();
            $.ajax({
              type  : "GET",
              url   : "<?php echo site_url();?>henkel_adm_datatable/no_penjualan",
              data  : "kode_pelanggan="+pelanggan,
              dataType: "json",
              success : function(data){
                        table = $('#show_transaksi').DataTable({
                        "bProcessing": true,
                        "bDestroy": true,
                        "sAjaxSource": '<?php echo site_url();?>henkel_adm_datatable/no_penjualan?kode_pelanggan='+pelanggan,
                        "bSort": true,
                         "bAutoWidth": true,
                        "iDisplayLength": 10, "aLengthMenu": [10,20,40,80], // can be removed for basic 10 items per page
                        "sPaginationType": "full_numbers",
                        "aoColumnDefs": [{"bSortable": false,
                                         "aTargets": [ -1 , 0]}], //Feature control DataTables' server-side processing mode.
                        "aoColumns": [
                          {"mData" : "no"},
                          {"mData" : "no_transaksi"},
                          {"mData" : "tanggal"},
                          {"mData" : "kode_pelanggan"},
                          {"mData" : "kode_sales"},
                          {"mData" : "total_item"},
                          {"mData" : "total"}
                        ]
                    });
                    $('#modal-search').modal('show');
              },
              error : function(data){
                alert('Data Transaksi Kosong');
                var id= $("#id").val();
                $.ajax({
                    type    : 'POST',
                    url     : "<?php echo site_url(); ?>henkel_adm_retur_penjualan/baru",
                    data    : "id_new="+id,
                    success : function(data){
                      location.reload();
                    }
                });
              }
            });

          });
          $('#show_transaksi tbody').on( 'click', 'tr', function () {
              var data=$(this).find('td').eq(1).text();
              $("#no_penjualan").val(data);
              $('#modal-search').modal('hide');
          } );

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

        $("#kode_sales").autocomplete({
                // serviceUrl berisi URL ke controller/fungsi yang menangani request kita
                serviceUrl: '<?php echo site_url();?>henkel_adm_search/search_kd_sales',
                // fungsi ini akan dijalankan ketika user memilih salah satu hasil request
                onSelect: function (suggestion) {
                    $('#nama_sales').val(''+suggestion.nama_karyawan);
                }
        });

        $("#nama_sales").autocomplete({
                // serviceUrl berisi URL ke controller/fungsi yang menangani request kita
                serviceUrl: '<?php echo site_url();?>henkel_adm_search/search_nm_sales',
                // fungsi ini akan dijalankan ketika user memilih salah satu hasil request
                onSelect: function (suggestion) {
                    $('#kode_sales').val(''+suggestion.nik);
                }
        });

        $("#cek").click(function(){
          var no_pe= $("#no_penjualan").val();
          var id= $("#id").val();
          $.ajax({
              type    : 'POST',
              url     : "<?php echo site_url(); ?>henkel_adm_retur_penjualan/cek",
              data    : {no_penjualan:no_pe,id_retur_penjualan:id},
              success : function(data){
                if(data==0){
                  alert('Transaksi dengan Kode '+no_pe+' kosong');
                  location.reload();
                }else {
                  location.replace("<?php echo site_url(); ?>henkel_adm_retur_penjualan/tambah");
                }

              }
          });

        });

        $("#kode_gudang").change(function(){
           $("#nama_item").val('');
           $("#harga_satuan").val('');
           $("#kode_item").val('');
           $("#stok").val('0');
           search_kd_item();
        });

        $("#kode_item").change(function(){
           search_nm_item();
        });

        $("#new").click(function(){
          var id= $("#id").val();
          $.ajax({
              type    : 'POST',
              url     : "<?php echo site_url(); ?>henkel_adm_retur_penjualan/baru",
              data    : "id_new="+id,
              success : function(data){
                location.replace("<?php echo site_url(); ?>henkel_adm_retur_penjualan/tambah");
              }
          });
        });

        $("#harga_satuan").keyup(function(){
          var harga_satuan = $('#harga_satuan').val();
          $('#jumlah').val('1');
          $('#diskon').val('0');
          $('#harga').val(harga_satuan);
          $('#total').val(harga_satuan);
        });

        $("#jumlah").keyup(function(){
          //call function diskon
          var harga_satuan = $('#harga_satuan').val();
          var jumlah = $('#jumlah').val();
          $('#harga').val(f_jumlah(toAngka(harga_satuan),jumlah));
          //call function diskon
          var harga = $("#harga").val();
          var diskon = $("#diskon").val();
          $('#total').val(f_diskon(toAngka(harga),diskon));
        });
        /*
        $("#diskon").keyup(function(){
          var harga = $("#harga").val();
          var diskon = $("#diskon").val();
          $('#total').val(f_diskon(harga,diskon));
        });

        $("#diskon_all").keyup(function(){
          var harga = $("#total_akhir2").val();
          var clean = harga.replace(/\D/g,'');
          var persen = $("#diskon_all").val();
          var diskon = (clean * persen)/100;
          var total = parseInt(clean) + diskon;
          var bilangan = separator_harga2(total);
          $('#total_retur').val(bilangan);
          $('#potong_piutang').val(bilangan);
          $('#enable').attr('checked', false);
          $('#tunai').val('0');
          $('#tunai').attr('readonly', true);
          $('#potong_piutang').attr('readonly', false);
          $('#tunai').attr('readonly', true);
          var tp=$('#total_penjualan').val();
          var pp=$('#potong_piutang').val();
          $('#sisa').val(sisa(tp,pp));
        });
        */

        $("#simpan").click(function(){
          var kode_item = $("#kode_item").val();
          var jumlah = parseInt($("#jumlah").val());
          var jumlah_jual = parseInt($("#jumlah_jual").val());
          var harga_satuan = toAngka($("#harga_satuan").val());

          var string = $("#my-form").serialize();
          if(!$("#kode_gudang").val()){
              $.gritter.add({
                  title: 'Peringatan..!!',
                  text: 'Kode Gudang tidak boleh kosong',
                  class_name: 'gritter-error'
              });

              $("#kode_gudang").focus();
              return false();
          }

          if(kode_item.length==0){
              $.gritter.add({
                  title: 'Peringatan..!!',
                  text: 'Kode Item tidak boleh kosong',
                  class_name: 'gritter-error'
              });

              $("#kode_item").focus();
              return false();
          }

          if(jumlah>jumlah_jual){
              $.gritter.add({
                  title: 'Peringatan..!!',
                  text: 'Jumlah Retur Melebihi Batas Jumlah Jual',
                  class_name: 'gritter-error'
              });

              $("#jumlah").focus();
              return false();
          }

          if(harga_satuan.length==0){
              $.gritter.add({
                  title: 'Peringatan..!!',
                  text: 'Harga Satuan Tidak Boleh Kosong',
                  class_name: 'gritter-error'
              });

              $("#harga_satuan").focus();
              return false();
          }

            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_r_penjualan/simpan",
                data    : string,
                cache   : false,
                success : function(data){
                    location.reload();
                }
            });
        });

        $("#simpan_retur_penjualan").click(function(){
            var id=$("#id").val();
            var kode_pelanggan = $("#kode_pelanggan").val();
            var pelanggan = $("#nama_pelanggan").val();
            var alamat = $("#alamat").val();
            var kode_sales = $("#kode_sales").val();
            var nama_sales = $("#nama_sales").val();
            var total_retur = toAngka($("#total_retur").val());
            var keterangan = $("#keterangan").val();
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

            if(kode_sales.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Kode Sales tidak boleh kosong',
                    class_name: 'gritter-error'
                });
                $("#kode_sales").focus();
                return false();
            }

            if(nama_sales.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Nama Sales tidak boleh kosong',
                    class_name: 'gritter-error'
                });
                $("#nama_sales").focus();
                return false();
            }

            if(total_retur==0 || total_retur==''){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Blum dilakukan retur',
                    class_name: 'gritter-error'
                });
                return false();
            }

            if(keterangan.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'keterangan tidak boleh kosong',
                    class_name: 'gritter-error'
                });
                $("#keterangan").focus();
                return false();
            }

            var r = confirm("Anda sudah yakin? Data yang sudah disimpan tidak dapat diubah lagi");
            if (r == true) {
              $.ajax({
                  type    : 'POST',
                  url     : "<?php echo site_url(); ?>henkel_adm_retur_penjualan/simpan",
                  data    : string,
                  cache   : false,
                  success : function(data){
                    var id= $("#id").val();
                    alert(data);
                    location.replace("<?php echo site_url(); ?>henkel_adm_retur_penjualan")
                  }
              });
            }else {
              return false();
            }


        });

        $("#tambah").click(function(){
          $("#id_retur_penjualan").val(<?php echo "$id_retur_penjualan" ?>);
          $("#kode_item").val('');
          $("#nama_item").val('');
          $("#harga_satuan").val('');
          $("#jumlah").val('1');
          $("#harga").val('');
          $("#diskon").val('0');
          $("#total").val('');
          $("#stok").val('0');
        });

        var cetak_invoice = 1;
        $("#cetak").click(function(){
          $("#cetak_invoice").val(cetak_invoice++);
          cetak();
        });

        $(window).on('beforeunload', function(){
            localStorage.setItem('kode_pelanggan', $('#kode_pelanggan').val());
            localStorage.setItem('nama_pelanggan', $('#nama_pelanggan').val());
            localStorage.setItem('alamat', $('#alamat').val());
            localStorage.setItem('no_penjualan', $('#no_penjualan').val());
            localStorage.setItem('kode_sales', $('#kode_sales').val());
            localStorage.setItem('nama_sales', $('#nama_sales').val());
        });

});

window.onload = function() {
  $.ajax({
    type : 'GET',
    url  : "<?php echo site_url(); ?>henkel_adm_retur_penjualan/get_total_transaksi",
    data : "no_penjualan="+"<?php echo $no_penjualan ?>",
    dataType:'json',
    success : function(data){
      $('#total_penjualan').val(data.total_akhir);
      $('#diskon_transaksi').val(data.diskon);
      $('#pajak').val(data.pajak);
      $('#total_bayar').val(data.bayar);
      var total_akhir=$('#total_akhir').val();
      var diskon=f_diskon(toAngka(total_akhir),data.diskon);
      $('#total_retur').val(diskon);
      var total_retur=$('#total_retur').val();
      var retur=f_retur(toAngka(total_retur),data.pajak);
      $('#total_retur').val(retur);
    }
  });
}

function sisa(a,b){
  var c_a=parseFloat(a);
  var c_b=parseFloat(b);
  var hasil=c_a-c_b;
  var bilangan = toHarga(parseFloat(hasil));
  return bilangan;
}

function search_kd_item(){
  var kode_gudang = $("#kode_gudang").val();
  $.ajax({
    type  : "POST",
    url   : "<?php echo site_url(); ?>henkel_adm_search/search_kd_item",
    data  : "kode_gudang="+kode_gudang,
    dataType: "json",
    success : function(data){
      $('#kode_item').html(data);
    }
  });
}

function search_nm_item(){
  var kode_item = $("#kode_item").val();
  var kode_gudang = $("#kode_gudang").val();

  $.ajax({
    type  : "POST",
    url   : "<?php echo site_url(); ?>henkel_adm_search/search_nm_item",
    data  : {kode_item: kode_item, kode_gudang: kode_gudang},
    dataType: "json",
    success : function(data){
      $('#nama_item').val(data.nama_item);
      $('#harga_satuan').val(toHarga(data.harga_satuan));
      $('#stok').val(data.stok);
      $('#harga').val(toHarga(data.harga_satuan));
      $('#total').val(toHarga(data.harga_satuan));
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
    var cari  = ID;
    console.log(cari);
  $.ajax({
    type  : "GET",
    url   : "<?php echo site_url(); ?>henkel_adm_r_penjualan/cari",
    data  : "cari="+cari,
    dataType: "json",
    success : function(data){
      $('#id_r_penjualan').val(data.id_r_penjualan);
      $('#id_retur_penjualan').val(data.id_retur_penjualan);
      $('#kode_gudang').val(data.kode_gudang);
      $('#kode_item').val(data.kode_item);
      $('#nama_item').val(data.nama_item);
      $('#harga_satuan').val(data.harga_item);
      $('#jumlah').val(data.jumlah_retur);
      $('#jumlah_jual').val(data.jumlah);
      $('#diskon').val(data.diskon);
      //call function jumlah
      var harga_satuan = data.harga_item;
      var jumlah = data.jumlah_retur;
      $('#harga').val(f_jumlah(toAngka(harga_satuan),jumlah));
      //call function diskon
      var harga = $("#harga").val();
      var diskon = data.diskon;
      $('#total').val(f_diskon(toAngka(harga),diskon));
    }
  });
}

function f_jumlah(satuan,jml){
  var harga_satuan = satuan;
  var jumlah = jml;
  var clean = parseFloat(harga_satuan);
  var harga = clean * jumlah;
  var bilangan = toHarga(parseFloat(harga));
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

function f_retur(hrg,pjk){
  var harga = hrg;
  var persen = pjk;
  var clean = parseFloat(harga);
  var diskon = (clean * persen)/100;
  var total = parseFloat(clean) + parseFloat(diskon);
  var bilangan = toHarga(parseFloat(total));
  return bilangan;
}

function separator_harga2(ID){
  var bilangan  = ID;
  var reverse = bilangan.toString().split('').reverse().join(''),
    ribuan  = reverse.match(/\d{1,3}/g);
    ribuan  = ribuan.join('.').split('').reverse().join('');
  return ribuan;
}

  function cetak() {
      var id= $("#id").val();
      var no_transaksi= $("#no_transaksi").val();
      var tgl= $("#tanggal").val();
      var kode_pelanggan= $("#kode_pelanggan").val();
      var alamat= $("#alamat").val();
      var nama_pelanggan= $("#nama_pelanggan").val();
      var no_penjualan= $("#no_penjualan").val();
      var kode_sales= $("#kode_sales").val();
      var nama_sales= $("#nama_sales").val();
      var tunai= $("#tunai").val();
      var deposit= $("#deposit").val();
      var pot_piutang= $("#potong_piutang").val();
      var total_penjualan= $("#total_penjualan").val();
      var total_dp= $("#total_bayar").val();
      var total_retur= $("#total_retur").val();
      var cetak_invoice= $("#cetak_invoice").val();
      window.open("<?php echo site_url(); ?>henkel_adm_retur_penjualan/cetak?id="+id+"&no_transaksi="+no_transaksi+"&tanggal="+tgl+"&kode_pelanggan="+kode_pelanggan+"&alamat="+alamat+"&nama_pelanggan="+nama_pelanggan+"&no_penjualan="+no_penjualan+"&kode_sales="+kode_sales+"&nama_sales="+nama_sales+"&tunai="+tunai+"&deposit="+deposit+"&pot_piutang="+pot_piutang+"&total_penjualan="+total_penjualan+"&total_dp="+total_dp+"&total_retur="+total_retur+"&cetak_invoice="+cetak_invoice)
  }
</script>

<form class="form-horizontal" name="form_penjualan" id="form_penjualan">
<div class="row-fluid">
<div class="table-header">
    <?php echo 'No. Retur : '.$no_transaksi;?><input type="hidden" name="no_transaksi" id="no_transaksi" value="<?php echo $no_transaksi?>">
    <div class="pull-right" style="padding-right:15px;"><?php echo 'Tanggal : '.tgl_indo($tanggal);?></div><input type="hidden" name="tanggal" id="tanggal" value="<?php echo $tanggal?>">
    <input type="hidden" value="<?php echo $id_retur_penjualan;?>" name="id" id="id">
</div>
<div class="space"></div>
   <div class="row-fluid">
        <div class="span6">
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
                        <input type="text" class="autocomplete" value="<?php echo $alamat;?>" name="alamat" id="alamat" placeholder="Alamat" readonly/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">No. Transaksi</label>
                    <div class="controls">
                        <input type="text" class="autocomplete" value="<?php echo $no_penjualan;?>" name="no_penjualan" id="no_penjualan" placeholder="No. Transaksi" readonly/>
                        <!--<button type="button" id="show" name="show" class="btn btn-info btn-small" data-toggle="modal">Cari</button>-->
                    </div>
                </div>
                <!--
                <div class="control-group">
                    <div class="controls">
                        <button type="button" id="cek" name="cek" class="btn btn-warning btn-small" >Cek Transaksi</button>
                    </div>
                </div>
                -->
         </div>
         <!--<div class="span6">
                 <div class="control-group">
                     <label class="control-label" for="form-field-1">Kode Sales</label>
                     <div class="controls">
                         <input type="text" class="autocomplete" value="<?php echo $kode_sales;?>" name="kode_sales" id="kode_sales" placeholder="Kode Sales" readonly/>
                     </div>
                </div>
                 <div class="control-group">
                     <label class="control-label" for="form-field-1">Nama Sales</label>
                     <div class="controls">
                         <input type="text" class="autocomplete" value="<?php echo $nama_sales;?>" name="nama_sales" id="nama_sales" placeholder="Sales" readonly/>
                     </div>
                 </div>
          </div>-->
    </div>
<div class="space"></div>
<div class="table-header">
 Tabel Item Retur
</div>
<table class="table lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Kode Item</th>
            <th class="center">Nama Item</th>
            <th class="center">Harga Jual</th>
            <th class="center">Kode Gudang</th>
            <th class="center">Jumlah Jual</th>
            <th class="center">Jumlah Retur</th>
            <th class="center">Sub. Total</th>
            <th class="center">Diskon</th>
            <th class="center">Total</th>
            <!--<th class="center">Aksi</th>-->
        </tr>
    </thead>
    <tbody>
        <?php
        $i=1;
        $total_transaksi=0;
        $total_item=0;
        foreach($data->result() as $dt){ ?>
        <tr>
          <?php
            $harga_retur= $dt->harga_retur;
            $jumlah= $dt->qty_retur;
            $diskon= $dt->diskon;
            $harga = $harga_retur * $jumlah;
            $persen = ($harga * $diskon)/100;
            $total = $harga-$persen;
            $total_transaksi += $total;
            $total_item += $jumlah;
          ?>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->kode_item;?></td>
            <td class="center"><?php echo $dt->nama_item;?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($harga_retur);?></td>
            <td class="center"><?php echo $dt->kode_gudang;?></td>
            <td class="center"><?php echo $dt->qty;?></td>
            <td class="center"><?php echo $dt->qty_retur;?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($harga);?></td>
            <td class="center"><?php echo $dt->diskon." %";?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($total);?></td>
            <!--<td class="td-actions"><center>
                <div class="text-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_r_penjualan;?>')" data-toggle="modal">
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
</br>
<div class="row-fluid">
     <div class="span4">
             <div class="control-group">
                 <label class="control-label" for="form-field-1">Diskon Transaksi</label>
                 <div class="controls">
                     <input class="span6" type="text" name="diskon_transaksi" id="diskon_transaksi" readonly="readonly" /><span style="font-weight:bold"> %</span>
                 </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-1">Pajak</label>
                <div class="controls">
                    <input class="span6" type="text" name="pajak" id="pajak" readonly="readonly"/> <span style="font-weight:bold"> %</span>
                </div>
            </div>
      </div>
      <div class="span4">
        <div class="control-group" id="form_enable">
            <label class="control-label" for="form-field-1">  <input type="checkbox" name="enable" id="enable"> <span class="lbl"></span> Tunai</label>
            <div class="controls total_harga">
                <input type="text" class="span12 number" style="text-align: right;" value="<?php echo $tunai;?>" name="tunai" id="tunai" placeholder="0" onkeyup = "javascript:this.value=autoseparator(this.value);" readonly="readonly"/>
            </div>
       </div>
       <div id="form_deposit" class="control-group">
           <label class="control-label" for="form-field-1">  <input type="checkbox" name="enable_deposit" id="enable_deposit"> <span class="lbl"></span> Deposit</label>
           <div class="controls">
               <input class="span12 number" type="text" style="text-align: right;" value="<?php echo $deposit;?>"  name="deposit" id="deposit" placeholder="0" onkeyup = "javascript:this.value=autoseparator(this.value);" readonly="readonly"/>
           </div>
       </div>
       <div id="form_pp" class="control-group">
           <label class="control-label" for="form-field-1"><input type="checkbox" name="enable_pot_piutang" id="enable_pot_piutang"> <span class="lbl"></span> Pot. Piutang</label>
           <div class="controls total_harga">
             <input type="text" class="span12 number" style="text-align: right;" value="<?php echo $pot_piutang;?>"  name="potong_piutang" id="potong_piutang" placeholder="0" onkeyup = "javascript:this.value=autoseparator(this.value);" readonly="readonly"/>
           </div>
      </div>

      </div>

      <div class="span4">
              <div class="control-group">
                  <label class="control-label" for="form-field-1"> Total Transaksi</label>
                  <div class="controls total_harga">
                      <input type="text" class="span12 number" style="text-align: right;"  min='0' name="total_penjualan" id="total_penjualan" placeholder="0" readonly="readonly" />
                  </div>
             </div>
             <div class="control-group">
                 <label class="control-label" for="form-field-1"> Total DP</label>
                 <div class="controls total_harga">
                     <input type="text" class="span12 number" style="text-align: right;"  min='0' name="total_bayar" id="total_bayar" placeholder="0" readonly="readonly" />
                 </div>
            </div>
             <div class="text">
                  <input type="hidden" class="span12 number" style="text-align: right;" value="<?php echo separator_harga2($total_transaksi); ?>" min='0' name="total_akhir" id="total_akhir" placeholder="0" readonly="readonly" />
             </div>
              <div class="control-group">
                  <label class="control-label" for="form-field-1"> Total Retur</label>
                  <div class="controls total_harga">
                      <input type="text" class="span12 number" style="text-align: right;" value="<?php echo separator_harga2($total_transaksi); ?>" min='0' name="total_retur" id="total_retur" placeholder="0" readonly="readonly" />
                  </div>
             </div>
             <!--<div class="control-group">
                 <label class="control-label" for="form-field-1"> Sisa</label>
                 <div class="controls total_harga">
                     <input type="text" class="span12" style="text-align: right;"  min='0' name="sisa" id="sisa" placeholder="0" readonly="readonly" />
                 </div>
            </div>-->
            <input type="hidden" value="0" min="0" name="cetak_invoice" id="cetak_invoice" readonly="readonly" />
       </div>
 </div>
 <div class="row-fluid">
   <div class="span12">
     <div class="control-group">
         <label class="control-label" for="form-field-1"> Keterangan</label>
         <div class="controls">
             <input type="text" class="span4"  value="<?php echo $keterangan; ?>" name="keterangan" id="keterangan" placeholder="Keterangan" readonly/>
         </div>
    </div>
   </div>
 </div>
 <br>

</form>

</br>
<div class="row-fluid">
     <div class="span12" align="center">
         <a href="<?php echo base_url();?>henkel_adm_pesanan_penjualan" class="btn btn-small btn-danger">
             <i class="icon-remove"></i>
             Cancel
         </a>
         <button type="button" name="cetak" id="cetak" class="btn btn-small btn-primary">
         <i class="icon-print"></i> Cetak
         </button>
         <button type="button" name="new" id="new" class="btn btn-small btn-success">
             <i class="icon-save"></i>
             Transaksi Baru
         </button>
          <!--<button type="button" name="simpan_retur_penjualan" id="simpan_retur_penjualan" class="btn btn-small btn-warning">
              <i class="icon-save"></i>
              Simpan
          </button>-->

      </div>
</div>

</div>

<div id="modal-search" class="modal hide fade" style="width:80%;max-height:80%;left:30%;" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Cari No. Penjualan
        </div>
    </div>

    <div class="no-padding">
        <div class="row-fluid">
          <table class="table lcnp table-striped table-bordered table-hover" style='min-width:100%;' id="show_transaksi">
              <thead>
                  <tr>
                      <th class="center">No</th>
                      <th class="center">No Transaksi</th>
                      <th class="center">Tanggal</th>
                      <th class="center">Kode Pelanggan</th>
                      <th class="center">Kode Sales</th>
                      <th class="center">Total Item</th>
                      <th class="center">Total</th>
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
            <input type="hidden" name="id_retur_penjualan" id="id_retur_penjualan">
            <input type="hidden" name="id_r_penjualan" id="id_r_penjualan">
            <br>
            <div class="control-group">
                <label class="control-label" for="form-field-1">Gudang</label>
                <div class="controls">
                  <?php ?>
                  <select name="kode_gudang" id="kode_gudang">
                    <option value="" selected="selected">--Pilih Nama Gudang--</option>
                    <?php
                      $data = $this->db_kpp->get('gudang');
                      foreach($data->result() as $dt){
                    ?>
                     <option value="<?php echo $dt->kode_gudang;?>"><?php echo $dt->nama_gudang;?></option>
                    <?php
                      }
                    ?>
                   </select>
                </div>
            </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kode Item</label>

                    <div class="controls">
                        <input type="text" name="kode_item" id="kode_item" placeholder="Kode Item" readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Item</label>

                    <div class="controls">
                        <input type="text" name="nama_item" id="nama_item" placeholder="Nama Item" readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Harga Jual</label>

                    <div class="controls">
                        <input type="text" class="number" value="0" min="0" name="harga_satuan" id="harga_satuan" placeholder="0" readonly="readonly" /> <span style="font-weight:bold">Rp</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Jumlah Jual</label>

                    <div class="controls">
                        <input type="text" value="1" min="1" name="jumlah_jual" id="jumlah_jual" placeholder="0" readonly="readonly"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Jumlah Retur</label>

                    <div class="controls">
                        <input type="text" value="1" min="1" onkeydown="return justAngka(event)" name="jumlah" id="jumlah" placeholder="Jumlah" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Sub. Total</label>

                    <div class="controls">
                        <input type="text" class="number" value="0" min="0" name="harga" id="harga" placeholder="Harga" readonly="readonly"/> <span style="font-weight:bold">Rp</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Diskon</label>

                    <div class="controls">
                        <input type="text" value="0" onkeydown="return justAngka(event)" min="0" maxlength="3" name="diskon" id="diskon" placeholder="0" readonly="readonly"/> <span style="font-weight:bold">%</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Total</label>

                    <div class="controls">
                        <input type="text" class="number" value="0" min="0" name="total" id="total" placeholder="Total" readonly="readonly" /> <span style="font-weight:bold">Rp</span>
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
