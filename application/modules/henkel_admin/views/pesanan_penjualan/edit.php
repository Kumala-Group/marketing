<script type="text/javascript">
$(document).ready(function(){
        $(".disabled_key").keydown(function(event) {
            return false;
        });
        $("body").on("click", ".delete", function (e) {
            $(this).parent("div").remove();
        });

        $("#form_kembali").hide();


        /*$("#enable_pajak").change(function() {
          if(this.checked) {
              $('#pajak').attr('readonly', false);
              $('#pajak').focus();
              $("#form_faktur").show();
          }else {
              $('#pajak').attr('readonly', true);
              $("#form_faktur").hide();
              $('#no_faktur').val('');
          }
      });

        $("#enable_pajak").change(function() {
          if(this.checked) {
              $('#pajak').attr('readonly', false);
              $('#pajak').focus();
              $('#pajak').val('0');
              var harga = $("#total_transaksi").val();
              var clean = toAngka(harga);
              var persen = $("#diskon_all").val();
              var diskon = (parseFloat(clean) * persen)/100;
              var total = parseFloat(clean) - diskon;
              var bilangan = toHarga(parseFloat(total));
              $('#total_akhir').val(bilangan);
              $('#total_akhir2').val(bilangan);
          }else {
              $('#pajak').attr('readonly', true);
          }
      });*/

      /*$("#no_faktur").dblclick(function(){
        $.ajax({
          url   : "<?php echo site_url();?>henkel_adm_datatable/no_faktur",
          dataType: "json",
          success : function(){
                    table = $('#show_faktur').DataTable({
                    "bProcessing": true,
                    "bDestroy": true,
                    "sAjaxSource": '<?php echo site_url();?>henkel_adm_datatable/no_faktur',
                    "bSort": true,
                     "bAutoWidth": true,
                    "iDisplayLength": 10, "aLengthMenu": [10,20,40,80], // can be removed for basic 10 items per page
                    "sPaginationType": "full_numbers",
                    "aoColumnDefs": [{"bSortable": false,
                                     "aTargets": [ -1 , 0]}], //Feature control DataTables' server-side processing mode.
                    "aoColumns": [
                      {"mData" : "no"},
                      {"mData" : "no_faktur"}
                    ]
                });
                $('#modal-faktur').modal('show');
          },
          error : function(data){
            alert('No Faktur Kosong');
          }
        });
      });

      $('#show_faktur tbody').on( 'click', 'tr', function () {
          var data=$(this).find('td').eq(1).text();
          $("#no_faktur").val(data);
          $('#modal-faktur').modal('hide');
      } );*/

        $("#new").click(function(){
          var id= $("#id").val();
          $.ajax({
              type    : 'POST',
              url     : "<?php echo site_url(); ?>henkel_adm_pesanan_penjualan/baru",
              data    : "id_new="+id,
              success : function(data){
                location.replace("<?php echo site_url(); ?>henkel_adm_pesanan_penjualan/tambah");
              }
          });
        });

        //datatables
        $("#cari_kode_item").click(function(){
            var kode_gudang= $("#kode_gudang").val();
            $.ajax({
              type  : "GET",
              url   : "<?php echo site_url();?>henkel_adm_datatable/kode_item",
              data  : "kode_gudang="+kode_gudang,
              dataType: "json",
              success : function(data){
                        table = $('#show_item').DataTable({
                        "bProcessing": true,
                        "bDestroy": true,
                        "sAjaxSource": '<?php echo site_url();?>henkel_adm_datatable/kode_item?kode_gudang='+kode_gudang,
                        "bSort": true,
                         "bAutoWidth": true,
                        "iDisplayLength": 10, "aLengthMenu": [10,20,40,80], // can be removed for basic 10 items per page
                        "sPaginationType": "full_numbers",
                        "aoColumnDefs": [{"bSortable": false,
                                         "aTargets": [ -1 , 0]}], //Feature control DataTables' server-side processing mode.
                        "aoColumns": [
                          {"mData" : "no"},
                          {"mData" : "kode_item"},
                          {"mData" : "nama_item"},
                          {"mData" : "tipe"},
                          {"mData" : "kode_gudang"},
                          {"mData" : "nama_gudang"},
                          {"mData" : "stok"}
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
              var data=$(this).find('td').eq(1).text();
              $("#kode_item").val(data);
              var stok=$(this).find('td').eq(6).text();
              $("#stok").val(stok);
              search_nm_item();
              $('#modal-item').modal('hide');
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

        $("#kode_gudang").change(function(){
           $("#nama_item").val('');
           $("#harga_satuan").val('');
           $("#kode_item").val('');
           $("#stok").val('0');
           $("#jumlah").val('1');
           $('#he_terendah_dpp').val('0');
           $('#he_terendah_dpp_ppn').val('0');
           $('#he_tertinggi_dpp').val('0');
           $('#he_tertinggi_dpp_ppn').val('0');
           $('#harga_jual').val('0');
           $('#harga_jual_rendah').val('0');
           $('#harga_jual_rendah_covered').val('0');
           $("#diskon").val('');
           $("#disk_rp").val('');
           $('#sub_total').val('0');
           $('#total').val('0');
           search_kd_item();
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
          var tarikharga_jual = $('#harga_jual').val();
          var harga_jual = toAngka(tarikharga_jual);
          var jumlah = $('#jumlah').val();
          $('#sub_total').val(f_jumlah(tarikharga_jual,jumlah));

          var he_terendah_dpp = $('#he_terendah_dpp').val();
          $('#harga_jual_rendah').val(f_jumlah(he_terendah_dpp,jumlah));
          $('#harga_jual_rendah_covered').val(f_jumlah(he_terendah_dpp,jumlah));

          //call function diskon
          var sub_total = $("#sub_total").val();
          var diskon = $("#diskon").val();
          $('#total').val(f_diskon(sub_total,diskon));
        });

        $("#disk_rp").keyup(function(){
          var disk_rp = $("#disk_rp").val()
          var sub_total = $("#sub_total").val();
          var c_disk_rp = toAngka(disk_rp);
          var c_sub_total = toAngka(sub_total);
          var diskon= (parseFloat(c_disk_rp)/parseFloat(c_sub_total))*100;
          var total = parseFloat(c_sub_total)-parseFloat(c_disk_rp);
          var bilangan = toHarga(parseFloat(total));
          $('#total').val(bilangan);
          $('#diskon').val(diskon);
        });

        $("#diskon").keyup(function(){
          var sub_total = $("#sub_total").val();
          var diskon = $("#diskon").val();
          $('#total').val(f_diskon(sub_total,diskon));
        });

        $("#diskon_rp").keyup(function(){
          var diskon_rp = $("#diskon_rp").val()
          var harga = $("#total_transaksi").val();
          var c_diskon_rp = parseFloat(diskon_rp);
          var c_harga = parseFloat(harga);
          var diskon_all= (parseFloat(c_diskon_rp)/parseFloat(c_harga))*100;
          var total = parseFloat(c_harga)-parseFloat(c_diskon_rp);
          var bilangan = toHarga(parseFloat(total));
          $('#total_akhir').val(bilangan);
          $('#total_akhir2').val(bilangan);
          $('#kredit').val(bilangan);
          $('#diskon_all').val(diskon_all);
          reset_pajak();
        });

        $("#diskon_all").keyup(function(){
          var harga = $("#total_transaksi").val();
          var clean = toAngka(harga);
          var persen = $("#diskon_all").val();
          var diskon = (parseFloat(clean) * persen)/100;
          var total = parseFloat(clean) - diskon;
          var bilangan = toHarga(parseFloat(total));
          $('#total_akhir').val(bilangan);
          $('#total_akhir2').val(bilangan);
          $('#kredit').val(bilangan);
          $('#diskon_rp').val(toHarga(parseFloat(diskon)));
          reset_pajak();
        });

        $("#pajak").keyup(function(){
          var harga = $("#total_akhir2").val();
          var clean = toAngka(harga);
          var persen = $("#pajak").val();
          var pajak = (parseFloat(clean) * persen)/100;
          var total = parseFloat(clean) + parseFloat(pajak);
          var bilangan = toHarga(parseFloat(total));
          $('#total_akhir').val(bilangan);
          $('#kredit').val(bilangan);
        });

        $("#bayar").keyup(function(){
          //call function diskon
          var total_akhir = $('#total_akhir').val();
          var bayar = $('#bayar').val();
          var c_total_akhir = toAngka(total_akhir);
          var c_bayar = toAngka(bayar);
          if(parseFloat(c_total_akhir)>0){
            if(parseFloat(c_bayar) >= parseFloat(c_total_akhir)){
              $('#kredit').val('0');
              $('#status').val('Lunas');
              $('#status').css("color","rgb(5, 166, 16)");
              $('#form_kembali').show();
              var kembali = parseFloat(c_bayar) - parseFloat(c_total_akhir);
              $('#kembali').val(toHarga(kembali));
            } else {
              var kredit = parseFloat(c_total_akhir) - parseFloat(c_bayar);
              $('#kredit').val(toHarga(kredit));
              $('#status').val('Kredit');
              $('#status').css("color","rgb(218, 142, 12)");
              $('#form_kembali').hide();
            }
          }else {
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
          var jumlah = parseInt($("#jumlah").val());
          var stok = parseInt($("#stok").val());
          var tharga_jual_rendah = $("#harga_jual_rendah_covered").val();
          var ttotal = $("#total").val();
          var harga_jual_rendah = toAngka(tharga_jual_rendah);
          var total = toAngka(ttotal);

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

          if(jumlah<1){
              $.gritter.add({
                  title: 'Peringatan..!!',
                  text: 'Jumlah tidak boleh kosong',
                  class_name: 'gritter-error'
              });

              $("#jumlah").focus();
              return false();
          }

          if(jumlah>stok){
              $.gritter.add({
                  title: 'Peringatan..!!',
                  text: 'Jumlah Melebihi Batas Stok',
                  class_name: 'gritter-error'
              });

              $("#jumlah").focus();
              return false();
          }

          if(total<harga_jual_rendah){
              $.gritter.add({
                  title: 'Peringatan..!!',
                  text: 'Pembelian berada dibawah harga jual terendah',
                  class_name: 'gritter-error'
              });

              $("#harga_jual_rendah").focus();
              return false();
          }

            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_penjualan/simpan",
                data    : string,
                cache   : false,
                success : function(data){
                  var id = $("#id").val();
                  var total_transaksi = $("#total_transaksi").val();
                  $.ajax({
                    type  : "GET",
                    url   : "<?php echo site_url(); ?>henkel_adm_pesanan_penjualan/reset",
                    data  : "id="+id,
                    dataType: "json",
                    success : function(data){
                      location.reload();
                    }
                  });
                }
            });
        });

        $("#simpan_pesanan_penjualan").click(function(){
            var kode_pelanggan = $("#kode_pelanggan").val();
            var pelanggan = $("#nama_pelanggan").val();
            var alamat = $("#alamat").val();
            var kode_sales = $("#kode_sales").val();
            var nama_sales = $("#nama_sales").val();
            var bayar = parseInt($("#bayar").val());
            var limit_a = $("#limit").val();
            var limit = parseFloat(toAngka(limit_a));
            var total_akhir_a = $("#total_akhir").val();
            var total_akhir = parseFloat(toAngka(total_akhir_a));
            var string = $("#form_penjualan").serialize();

            if(bayar==0){
                var total_akhir=$("#total_akhir").val();
                $("#kredit").val(total_akhir);
            }

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



            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_pesanan_penjualan/simpan",
                data    : string,
                cache   : false,
                success : function(data){
                  alert(data);
                }
            });
        });

        $("#tambah").click(function(){
          $("#id_pesanan_penjualan").val(<?php echo "$id_pesanan_penjualan" ?>);
          $("#kode_gudang").val('');
          $("#kode_item").val('');
          $("#nama_item").val('');
          $("#stok").val('0');
          $("#jumlah").val('1');
          $('#he_terendah_dpp').val('0');
          $('#he_terendah_dpp_ppn').val('0');
          $('#he_tertinggi_dpp').val('0');
          $('#he_tertinggi_dpp_ppn').val('0');
          $("#harga_jual").val('0');
          $("#harga_jual_rendah").val('0');
          $("#harga_jual_rendah_covered").val('0');
          $("#sub_total").val('0');
          $("#diskon").val('');
          $("#disk_rp").val('');
          $("#total").val('');
        });

        $('#jt_hari').val(Date.parse("<?php echo tgl_sql($tanggal)?>").addDays(<?php echo $jt; ?>).toString('d-MMMM-yyyy'));

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

        $("#surat_jalan").click(function(){
          surat_jalan();
        });

        var cetak_invoice = 1;
        $("#invoice").click(function(){
          $("#cetak_invoice").val(cetak_invoice++);
          invoice();
        });
});

/*window.onload = function() {
  if($("#pajak").val()=='0'){
    $('#enable_pajak').prop('checked', false);
    $('#form_faktur').hide();
    $('#no_faktur').val('');
  }else {
    $('#enable_pajak').prop('checked', true);
  }
}*/

function search_nm_item(){
  var kode_item = $("#kode_item").val();
  var kode_gudang = $("#kode_gudang").val();
  var margin_min = $("#margin_min").val();
  var margin_max = $("#margin_max").val();
  $.ajax({
    type  : "POST",
    url   : "<?php echo site_url(); ?>henkel_adm_search/search_nonseparated_item",
    data  : {kode_item: kode_item, kode_gudang: kode_gudang},
    dataType: "json",
    success : function(data){
      $('#nama_item').val(data.nama_item);

      var harga_tebus_dpp = data.harga_tebus_dpp;
      var ppn_htdpp = (parseFloat(harga_tebus_dpp)*10)/100;
      var harga_tebus_dpp_ppn = parseFloat(harga_tebus_dpp)+parseFloat(ppn_htdpp);

      /* Kalkulasi Untuk Margin Minimal*/
      var harga_tebus_ongkir = parseFloat(harga_tebus_dpp_ppn)+parseFloat(data.ongkos_kirim);
      var ongkir_marginmin = parseFloat(harga_tebus_ongkir)*parseInt(margin_min)/100;

      $('#he_terendah_dpp_ppn').val(toHarga(harga_tebus_ongkir+ongkir_marginmin));
      var he_terendah_dpp_ppn = harga_tebus_ongkir+ongkir_marginmin;
      $('#he_terendah_dpp').val(toHarga(parseFloat(he_terendah_dpp_ppn)/parseFloat(1.1)));

      /* Kalkulasi Untuk Margin Maksimal*/
      var harga_tebus_ongkir = parseFloat(harga_tebus_dpp_ppn)+parseFloat(data.ongkos_kirim);
      var ongkir_marginmax = parseFloat(harga_tebus_ongkir)*parseInt(margin_max)/100;

      $('#he_tertinggi_dpp_ppn').val(toHarga(harga_tebus_ongkir+ongkir_marginmax));
      var he_tertinggi_dpp_ppn = harga_tebus_ongkir+ongkir_marginmax;
      $('#he_tertinggi_dpp').val(toHarga(parseFloat(he_tertinggi_dpp_ppn)/parseFloat(1.1)));

      $('#harga_jual').val(toHarga(parseFloat(parseFloat(he_tertinggi_dpp_ppn)/parseFloat(1.1))));
      $('#harga_jual_rendah').val(toHarga(parseFloat(parseFloat(he_terendah_dpp_ppn)/parseFloat(1.1))));
      $('#harga_jual_rendah_covered').val(toHarga(parseFloat(parseFloat(he_terendah_dpp_ppn)/parseFloat(1.1))));
      $('#sub_total').val(toHarga(parseFloat(parseFloat(he_tertinggi_dpp_ppn)/parseFloat(1.1))));
      $('#total').val(toHarga(parseFloat(parseFloat(he_tertinggi_dpp_ppn)/parseFloat(1.1))));
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
    var margin_min = $("#margin_min").val();
    var margin_max = $("#margin_max").val();
    console.log(cari);
  $.ajax({
    type  : "GET",
    url   : "<?php echo site_url(); ?>henkel_adm_penjualan/cari",
    data  : "cari="+cari,
    dataType: "json",
    success : function(data){
      var harga_tebus_dpp = data.harga_tebus_dpp;
      var ppn_htdpp = (parseFloat(harga_tebus_dpp)*10)/100;
      var harga_tebus_dpp_ppn = parseFloat(harga_tebus_dpp)+parseFloat(ppn_htdpp);
      var harga_tebus_ongkir = parseFloat(harga_tebus_dpp_ppn)+parseFloat(data.ongkos_kirim);
      var ongkir_marginmin = parseFloat(harga_tebus_ongkir)*parseInt(margin_min)/100;
      var harga_tebus_ongkir = parseFloat(harga_tebus_dpp_ppn)+parseFloat(data.ongkos_kirim);
      var ongkir_marginmax = parseFloat(harga_tebus_ongkir)*parseInt(margin_max)/100;
      $('#id_penjualan').val(data.id_penjualan);
      $('#id_pesanan_penjualan').val(data.id_pesanan_penjualan);
      $('#kode_gudang').val(data.kode_gudang);
      $('#kode_item').html(data.kode_item);
      $('#kode_item').val(data.kode_item_val);
      $('#nama_item').val(data.nama_item);
      $('#he_terendah_dpp_ppn').val(toHarga(harga_tebus_ongkir+ongkir_marginmin));
      var he_terendah_dpp_ppn = harga_tebus_ongkir+ongkir_marginmin;
      $('#he_terendah_dpp').val(toHarga(parseFloat(he_terendah_dpp_ppn)/parseFloat(1.1)));

      $('#he_tertinggi_dpp_ppn').val(toHarga(harga_tebus_ongkir+ongkir_marginmax));
      var he_tertinggi_dpp_ppn = harga_tebus_ongkir+ongkir_marginmax;
      $('#he_tertinggi_dpp').val(toHarga(parseFloat(he_tertinggi_dpp_ppn)/parseFloat(1.1)));

      $('#harga_jual').val(toHarga(data.harga_jual));
      $('#harga_jual_rendah').val(toHarga(parseFloat(parseFloat(he_terendah_dpp_ppn)/parseFloat(1.1))));
      $('#harga_jual_rendah_covered').val(toHarga(parseFloat(parseFloat(he_terendah_dpp_ppn)/parseFloat(1.1))));
      $('#sub_total').val(toHarga(data.sub_total));
      $('#stok').val(data.stok);
      $('#jumlah').val(data.jumlah);
      $('#disk_rp').val(toHarga(data.disk_rp));
      $('#diskon').val(data.diskon);

      //call function diskon
      var sub_total = data.sub_total;
      var diskon = data.diskon;
      $('#total').val(f_diskon(toHarga(sub_total),diskon));
    }
  });

}

function hapusData(id){
  $.ajax({
    type  : "POST",
    url   : "<?php echo site_url(); ?>henkel_adm_penjualan/hapus/"+id,
    data  : "id_h="+id,
    dataType: "json",
    success : function(){
      location.reload();
    }
    });
}

function f_jumlah(satuan,jml){
  var harga_satuan = satuan;
  var jumlah = jml;
  var clean = toAngka(harga_satuan);
  var harga = parseFloat(clean) * jumlah;
  var bilangan = toHarga(harga);
  return bilangan;
}

function f_diskon(hrg,disk){
  var harga = hrg;
  var persen = disk;
  var clean = parseFloat(toAngka(harga));
  var diskon = (clean * persen)/100;
  var total = clean - diskon;
  var bilangan = toHarga(parseFloat(total));
  $("#disk_rp").val(toHarga(parseFloat(diskon)));
  return bilangan;
}

function separator_harga2(ID){
  var bilangan  = ID;
  var reverse = bilangan.toString().split('').reverse().join(''),
    ribuan  = reverse.match(/\d{1,3}/g);
    ribuan  = ribuan.join('.').split('').reverse().join('');
  return ribuan;
}

function reset_pajak()
  {
    $('#enable_pajak').prop('checked', false);
    $('#pajak').val('0');
    $("#form_faktur").hide();
    $("#bayar").val('0');
  }

function invoice() {
    var id= $("#id").val();
    var no_transaksi= $("#no_transaksi").val();
    var tgl= $("#tanggal").val();
    var kode_pelanggan= $("#kode_pelanggan").val();
    var alamat= $("#alamat").val();
    var nama_pelanggan= $("#nama_pelanggan").val();
    var kode_sales= $("#kode_sales").val();
    var nama_sales= $("#nama_sales").val();
    var diskon= $("#diskon_all").val();
    var pajak= $("#pajak").val();
    var no_e_faktur= $("#no_faktur").val();
    var jt= $("#jt").val();
    var total_transaksi= $("#total_transaksi").val();
    var total_akhir= $("#total_akhir").val();
    var cetak_invoice= $("#cetak_invoice").val();
    window.open("<?php echo site_url(); ?>henkel_adm_pesanan_penjualan/cetak?id="+id+"&no_transaksi="+no_transaksi+"&tanggal="+tgl+"&kode_pelanggan="+kode_pelanggan+"&alamat="+alamat+"&nama_pelanggan="+nama_pelanggan+"&kode_sales="+kode_sales+"&nama_sales="+nama_sales+"&diskon_all="+diskon+"&pajak="+pajak+"&no_e_faktur="+no_e_faktur+"&jt="+jt+"&total_transaksi="+total_transaksi+"&total_akhir="+total_akhir+"&cetak_invoice="+cetak_invoice)
}

function surat_jalan() {
  var id= $("#id").val();
  var no_transaksi= $("#no_transaksi").val();
  var tgl= $("#tanggal").val();
  var kode_pelanggan= $("#kode_pelanggan").val();
  var alamat= $("#alamat").val();
  var nama_pelanggan= $("#nama_pelanggan").val();
  var kode_sales= $("#kode_sales").val();
  window.open("<?php echo site_url(); ?>henkel_adm_pesanan_penjualan/cetak_sj?id="+id+"&no_transaksi="+no_transaksi+"&tanggal="+tgl+"&kode_pelanggan="+kode_pelanggan+"&alamat="+alamat+"&nama_pelanggan="+nama_pelanggan+"&kode_sales="+kode_sales)
}
</script>

<form class="form-horizontal" name="form_penjualan" id="form_penjualan">
<div class="row-fluid">
<div class="table-header">
    <?php echo 'No. Transaksi : '.$no_transaksi;?><input type="hidden" name="no_transaksi" id="no_transaksi" value="<?php echo $no_transaksi?>">
    <div class="pull-right" style="padding-right:15px;"><?php echo 'Tanggal : '.tgl_indo($tanggal);?></div><input type="hidden" name="tanggal" id="tanggal" value="<?php echo $tanggal?>">
    <input type="hidden" value="<?php echo $id_pesanan_penjualan;?>" name="id" id="id">
</div>
</br>
   <div class="row-fluid">
        <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kode Pelanggan</label>
                    <div class="controls">
                        <input type="text" class="autocomplete span10" value="<?php echo $kode_pelanggan;?>" name="kode_pelanggan" id="kode_pelanggan" placeholder="Kode Pelanggan" readonly/>
                    </div>
               </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Pelanggan</label>
                    <div class="controls">
                        <input type="text" class="autocomplete span10" value="<?php echo $nama_pelanggan;?>" name="nama_pelanggan" id="nama_pelanggan" placeholder="Nama Pelanggan" readonly/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Alamat</label>
                    <div class="controls">
                        <input type="text" class="autocomplete span10" value="<?php echo $alamat;?>" name="alamat" id="alamat" placeholder="Alamat" readonly/>
                    </div>
                </div>
         </div>
         <div class="span6">
                 <div class="control-group">
                     <label class="control-label" for="form-field-1">Kode Sales</label>
                     <div class="controls">
                         <input type="text"  class="autocomplete" value="<?php echo $kode_sales;?>" name="kode_sales" id="kode_sales" placeholder="Kode Sales" readonly/>
                     </div>
                </div>
                 <div class="control-group">
                     <label class="control-label" for="form-field-1">Nama Sales</label>
                     <div class="controls">
                         <input type="text"  class="autocomplete" value="<?php echo $nama_sales;?>" name="nama_sales" id="nama_sales" placeholder="Sales" readonly/>
                     </div>
                 </div>
          </div>
    </div>
<br />
<div class="table-header">
 Tabel Item Penjualan Item
 <div class="widget-toolbar no-border pull-right">
   <!--<a href="#modal-table" data-toggle="modal" name="tambah" id="tambah" class="btn btn-small btn-success">
       <i class="icon-plus"></i>
       Tambah Item
   </a>-->
 </div>
</div>
<table class="table lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Kode Item</th>
            <th class="center">Nama Item</th>
            <th class="center">Harga Jual</th>
            <th class="center">Kode Gudang</th>
            <th class="center">Jumlah</th>
            <th class="center">Sub Total</th>
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
            $harga_item= $dt->harga_jual;
            $jumlah= $dt->qty;
            $diskon= $dt->diskon;
            $harga = $harga_item * $jumlah;
            $persen = ($harga * $diskon)/100;
            $total = $harga-$persen;
            $total_transaksi += $total;
            $total_item += $jumlah;
          ?>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->kode_item;?></td>
            <td class="center"><?php echo $dt->nama_item;?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($dt->harga_jual);?></td>
            <td class="center"><?php echo $dt->kode_gudang;?></td>
            <td class="center"><?php echo $dt->qty;?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($harga);?></td>
            <td class="center"><?php echo $dt->diskon." %";?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($total);?></td>
            <!--<td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_penjualan;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a class="red" onclick="javascript:hapusData('<?php echo $dt->id_penjualan;?>')">
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
            </td>-->
        </tr>
        <?php } ?>
    </tbody>
</table>
</br>
<div class="row-fluid">
     <div class="span4">
             <div class="control-group">
                 <label class="control-label" for="form-field-1">Diskon</label>
                 <div class="controls">
                   <input class="span4" type="text" min="0" max="100" value="<?php echo $diskon_all;?>" maxlength="3" name="diskon_all" id="diskon_all" onkeydown="return justAngka(event)" placeholder="0" readonly/><span style="font-weight:bold"> %</span>
                   <input class="span10 number" type="text" min="0" max="100" value="<?php echo separator_harga2($diskon_rp);?>" name="diskon_rp" id="diskon_rp" placeholder="Potongan" readonly/><span style="font-weight:bold"> Rp</span>
                  </div>
             </div>
             <div class="control-group">
                 <label class="control-label" for="form-field-1">Pajak</label>
                 <div class="controls">
                     <input class="span5" type="text" max="100" maxlength="3" max="100" value="<?php echo $pajak;?>" name="pajak" id="pajak" onkeydown="return justAngka(event)" placeholder="0" readonly="readonly"/> <span style="font-weight:bold"> %</span>
                     <!--<input type="checkbox" name="enable_pajak" id="enable_pajak"> <span class="lbl"></span>-->
                 </div>
             </div>
             <div class="control-group">
                 <label class="control-label" for="form-field-1">No E - Faktur</label>
                 <div class="controls">
                     <input type="text" name="no_faktur" id="no_faktur" value="<?php echo $no_e_faktur?>" placeholder="Klik 2 Kali di sini !" readonly>
                 </div>
             </div>
             <div class="control-group">
                 <label class="control-label" for="form-field-1">Jatuh Tempo</label>
                 <div class="controls">
                     <input type="text" class="span5" value="<?php echo $jt;?>" min="0" name="jt" id="jt"  placeholder="" disabled="disabled"/> <span style="font-weight:bold"> Hari</span>
                     <input type="text" value="" name="jt_hari" id="jt_hari" placeholder="" readonly/>
                 </div>
             </div>
             <div class="control-group">
                 <label class="control-label" for="form-field-1">Program Penjualan</label>
                 <div class="controls">
                   <?php ?>
                   <select name="program_penjualan" id="program_penjualan">
                     <option value="<?php echo $program_penjualan;?>"></option>
                    </select>
                 </div>
             </div>
      </div>
      <div class="span4">
              <div class="control-group">
                  <label class="control-label" for="form-field-1">Bayar (Tunai/DP)</label>
                  <div class="controls">
                      <input class="span12 number" type="text"  style="text-align: right;"  value="<?php echo separator_harga2($bayar);?>" name="bayar" id="bayar" onkeydown="return justAngka(event)" placeholder="0" readonly/>
                  </div>
             </div>
              <div class="control-group">
                  <label class="control-label" for="form-field-1">Kredit</label>
                  <div class="controls">
                      <input class="span12 number" type="text" style="text-align: right;" value="<?php echo separator_harga2($kredit); ?>"  name="kredit" id="kredit" placeholder="0" readonly="readonly"/>
                  </div>
              </div>
              <div id="form_kembali" class="control-group">
                  <label class="control-label" for="form-field-1">Kembali</label>
                  <div class="controls">
                      <input class="span12 number" type="text" style="text-align: right;" value=""  name="kembali" id="kembali" placeholder="0" readonly/>
                  </div>
              </div>
              <div class="control-group">
                  <label class="control-label" for="form-field-1">Status</label>
                  <div class="controls">
                      <input class="span12 status" type="text" value="<?php echo $status;?>"  style="font-weight:bold" name="status" id="status" placeholder="Lunas/Kredit" readonly="readonly"/>
                  </div>
              </div>
       </div>
      <div class="span4">
              <div class="control-group">
                  <label class="control-label" for="form-field-1"> Total Item</label>
                  <div class="controls total_harga">
                      <input type="text" class="span4" style="text-align: right;" value="<?php echo $total_item; ?>" min='0' name="total_item" id="total_item" placeholder="0" readonly="readonly"/>
                  </div>
             </div>
              <div class="control-group">
                  <label class="control-label" for="form-field-1"> Sub Total</label>
                  <div class="controls total_harga">
                      <input type="text" class="span12 number" style="text-align: right;" value="<?php echo separator_harga2($total_transaksi); ?>" name="total_transaksi" id="total_transaksi" placeholder="Sub Total" readonly="readonly"/>
                  </div>
             </div>
             <div class="control-group">
                  <label class="control-label" for="form-field-1"> Diskon</label>
                  <div class="controls total_harga">
                    <?php $diskon_all_rp = ($total_transaksi*$diskon_all)/100?>
                      <input type="text" class="span12 number" style="text-align: right;" value="<?php echo separator_harga2($diskon_all_rp); ?>" name="diskon_all_rp" id="diskon_all_rp" placeholder="Sub Total" readonly="readonly"/>
                  </div>
             </div>
             <div class="control-group">
                  <label class="control-label" for="form-field-1"> Pajak</label>
                  <div class="controls total_harga">
                    <?php $pajak_rp = $total_transaksi-$diskon_rp?>
                      <input type="text" class="span12 number" style="text-align: right;" value="<?php echo separator_harga2(($pajak_rp*$pajak)/100); ?>" name="pajak" id="pajak" placeholder="Sub Total" readonly="readonly"/>
                  </div>
             </div>
             <div class="control-group">
                 <label class="control-label" for="form-field-1">Total Akhir</label>
                 <div class="controls total_harga">
                   <input type="text" class="span12 number" style="text-align: right;" value="<?php echo separator_harga2($total_akhir_transaksi); ?>" name="total_akhir" id="total_akhir" placeholder="Total Akhir"  readonly="readonly"/>
                   <input type="hidden" class="span12 number" style="text-align: right;" value="<?php echo separator_harga2($total_akhir_transaksi); ?>" name="total_akhir2" id="total_akhir2" placeholder="Total Akhir"  readonly="readonly"/>
                 </div>
            </div>
            <input type="hidden" value="0" min="0" name="cetak_invoice" id="cetak_invoice" readonly="readonly" />
            <div class="control-group">
                <label class="control-label" for="form-field-1">Limit</label>
                <div class="controls total_harga">
                  <input type="text" class="span12 number" style="text-align: right;" name="limit" id="limit" value="<?php echo separator_harga2($limit); ?>" placeholder="0"  readonly="readonly"/>
                </div>
           </div>
       </div>
 </div>
 <br>
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

<div class="row-fluid">
     <div class="span12" align="center">
         <button type="button" name="invoice" id="invoice" class="btn btn-small btn-primary">
         <i class="icon-print"></i> Invoice
         </button>
         <button type="button" name="surat_jalan" id="surat_jalan" class="btn btn-small btn-primary">
         <i class="icon-print"></i> Surat Jalan
         </button>
         <button type="button" name="new" id="new" class="btn btn-small btn-success">
             <i class="icon-save"></i>
             Transaksi Baru
         </button>
        <!--<button type="button" name="simpan_pesanan_penjualan" id="simpan_pesanan_penjualan" class="btn btn-small btn-warning">
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
            Tambah Item
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
            <input type="hidden" name="id_pesanan_penjualan" id="id_pesanan_penjualan">
            <input type="hidden" name="id_penjualan" id="id_penjualan">
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
                          <button type="button" name="cari_kode_item" id="cari_kode_item" class="btn btn-small btn-info">
                            <i class="icon-search"></i>
                            Cari
                          </button>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Item</label>

                    <div class="controls">
                        <input type="text" name="nama_item" id="nama_item" placeholder="Nama Item" readonly="readonly" />
                    </div>
                </div>
                <input type="hidden" class="autocomplete" name="margin_min" id="margin_min" value="<?php echo $margin_min;?>" class="span2" readonly="readonly"/>
                <input type="hidden" class="autocomplete" name="margin_max" id="margin_max" value="<?php echo $margin_max;?>" class="span2" readonly="readonly"/>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Stok Tersedia</label>

                    <div class="controls">
                        <input type="text" value="0" min="0" name="stok" id="stok" placeholder="0" readonly="readonly" /> <span style="font-weight:bold">Rp</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Jumlah</label>

                    <div class="controls">
                        <input type="text" value="1" min="1" onkeydown="return justAngka(event)" name="jumlah" id="jumlah" placeholder="Jumlah" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">HE Terendah DPP</label>

                    <div class="controls">
                        <input type="text" class="number" name="he_terendah_dpp" id="he_terendah_dpp" readonly="readonly"/> <span style="font-weight:bold">Rp</span><br />
                        <input type="text" class="number" name="he_terendah_dpp_ppn" id="he_terendah_dpp_ppn" readonly/><span class="required" style="font-size:9px;">+PPN(10%)</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">HE Tertinggi DPP</label>

                    <div class="controls">
                        <input type="text" class="number" name="he_tertinggi_dpp" id="he_tertinggi_dpp" readonly="readonly"/> <span style="font-weight:bold">Rp</span><br />
                        <input type="text" class="number" name="he_tertinggi_dpp_ppn" id="he_tertinggi_dpp_ppn" readonly/><span class="required" style="font-size:9px;">+PPN(10%)</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Harga Jual</label>

                    <div class="controls">
                        <input type="text" class="number" value="0" min="0" name="harga_jual" id="harga_jual" placeholder="Harga Jual" readonly="readonly"/> <span style="font-weight:bold">Rp</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Sub Total</label>
                    <div class="controls">
                        <input type="text" class="number" name="sub_total" id="sub_total" placeholder="0" style="background-color: #FFD700;" class="disabled_key"/> <span style="font-weight:bold">Rp</span><br>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Harga Jual (Rendah)</label>
                    <div class="controls">
                        <input type="text" class="number" name="harga_jual_rendah" id="harga_jual_rendah" placeholder="0" style="background-color: #b30000; color: white;" class="disabled_key"/> <span style="font-weight:bold">Rp</span><br>
                        <input type="hidden" class="number" name="harga_jual_rendah_covered" id="harga_jual_rendah_covered" placeholder="0"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Diskon</label>
                    <div class="controls">
                        <input type="text" value="0" class="span2" onkeydown="return justAngka(event)" min="0"  name="diskon" id="diskon" placeholder="0" /> <span style="font-weight:bold">%</span><br>
                        <input type="text"  class="number" value="0"   min="0"  name="disk_rp" id="disk_rp" placeholder="0" /> <span style="font-weight:bold">Rp</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Total</label>

                    <div class="controls">
                        <input type="text"  class="number" value="0" min="0" name="total" id="total" placeholder="Total" style="background-color: #FF6347; color: white" class="disabled_key"/> <span style="font-weight:bold">Rp</span>
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


<div id="modal-item" class="modal hide fade" style="width:80%;max-height:80%;left:30%;" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Cari Kode Item
        </div>
    </div>

    <div class="no-padding">
        <div class="row-fluid">
          <table class="table lcnp table-striped table-bordered table-hover" style='min-width:100%;' id="show_item">
              <thead>
                  <tr>
                      <th class="center">No</th>
                      <th class="center">Kode Item</th>
                      <th class="center">Nama Item</th>
                      <th class="center">Tipe</th>
                      <th class="center">Kode Gudang</th>
                      <th class="center">Nama Gudang</th>
                      <th class="center">Stok</th>
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
<div id="modal-faktur" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Cari No. E-Faktur
        </div>
    </div>

    <div class="no-padding">
        <div class="row-fluid">
          <table class="table lcnp table-striped table-bordered table-hover" style='min-width:100%;' id="show_faktur">
              <thead>
                  <tr>
                      <th class="center">No</th>
                      <th class="center">No. E-Faktur</th>
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
