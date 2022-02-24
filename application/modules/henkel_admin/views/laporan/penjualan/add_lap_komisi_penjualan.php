<script type="text/javascript">
$(document).ready(function(){
        $(".disabled_key").keydown(function(event) {
          return false;
        });
        $("body").on("click", ".delete", function (e) {
            $(this).parent("div").remove();
        });
        $("#form_kembali").hide();
        $("#form_faktur").hide();

        $("#enable_pajak").change(function() {
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


      $("#show_data_transaksi").click(function(){
        $.ajax({
          url		: "<?php echo site_url();?>henkel_adm_datatable/search_data_transaksi",
          dataType: "json",
          success	: function(){
                    table = $('#show_transaksi').DataTable({
                    "bProcessing": true,
                    "bDestroy": true,
                    "sAjaxSource": '<?php echo site_url();?>henkel_adm_datatable/search_data_transaksi',
                    "bSort": false,
                    "bAutoWidth": true,
                    "iDisplayLength": 10, "aLengthMenu": [10,20,40,80], // can be removed for basic 10 items per page
                    "sPaginationType": "full_numbers",
                    "aoColumnDefs": [{"bSortable": false,
                                     "aTargets": [ -1 , 0]}], //Feature control DataTables' server-side processing mode.
                    "aoColumns": [
                      {"mData" : "no"},
                      {"mData" : "no_transaksi"},
                      {"mData" : "umur_transaksi"},
                    ]
                });
                $('#modal-transaksi').modal('show');
          },
          error : function(data){
            alert('No Transaksi Kosong');
          }
        });
      });

      $('#show_transaksi tbody').on( 'click', 'tr', function () {
          var no_transaksi=$(this).find('td').eq(1).text();
          $("#no_transaksi").val(no_transaksi);
          $('#modal-transaksi').modal('hide');
      } );

        $("#kode_gudang").change(function(){
           $("#nama_item").val('');
           $("#harga_satuan").val('');
           $("#kode_item").val('');
           $("#stok").val('0');
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

        $("#harga_satuan").keyup(function(){
          var harga_satuan = $('#harga_satuan').val();
          $('#jumlah').val('1');
          $('#diskon').val('0');
          $('#disk_rp').val('0');
          $('#harga').val(harga_satuan);
          $('#total').val(harga_satuan);
        });

        $("#jumlah").keyup(function(){
          //call function diskon
          var harga_jual = $('#harga_jual').val();
          var jumlah = $('#jumlah').val();
          $('#sub_total').val(f_jumlah(harga_jual,jumlah));

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
          var c_disk_rp = disk_rp.replace(/\D/g,'');
          var c_sub_total = sub_total.replace(/\D/g,'');
          var diskon= (c_disk_rp/c_sub_total)*100;
          var total = c_disk_rp - c_sub_total;
          var bilangan = separator_harga2(parseInt(total));
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
          var c_diskon_rp = diskon_rp.replace(/\D/g,'');
          var c_harga = harga.replace(/\D/g,'');
          var diskon_all= (c_diskon_rp/c_harga)*100;
          var total = c_diskon_rp - c_harga;
          var bilangan = separator_harga2(parseInt(total));
          $('#total_akhir').val(bilangan);
          $('#total_akhir2').val(bilangan);
          $('#kredit').val(bilangan);
          $('#diskon_all').val(diskon_all);
          reset();
        });

        $("#diskon_all").keyup(function(){
          var harga = $("#total_transaksi").val();
          var clean = harga.replace(/\D/g,'');
          var persen = $("#diskon_all").val();
          var diskon = (clean * persen)/100;
          var total = clean - diskon;
          var bilangan = separator_harga2(parseInt(total));
          $('#total_akhir').val(bilangan);
          $('#total_akhir2').val(bilangan);
          $('#kredit').val(bilangan);
          $('#diskon_rp').val(separator_harga2(parseInt(diskon)));
          reset();
        });

        $("#pajak").keyup(function(){
          var harga = $("#total_akhir2").val();
          var clean = harga.replace(/\D/g,'');
          var persen = $("#pajak").val();
          var pajak = (clean * persen)/100;
          var total = parseInt(clean) + parseInt(pajak);
          var bilangan = separator_harga2(parseInt(total));
          $('#total_akhir').val(bilangan);
          $('#kredit').val(bilangan);
        });

        $("#bayar").keyup(function(){
          //call function diskon
          var total_akhir = $('#total_akhir').val();
          var bayar = $('#bayar').val();
          var c_total_akhir = total_akhir.replace(/\D/g,'');
          var c_bayar = bayar.replace(/\D/g,'');
          if(parseInt(c_total_akhir)>0){
            if(parseInt(c_bayar) >= parseInt(c_total_akhir)){
              $('#kredit').val('0');
              $('#status').val('Lunas');
              $('#status').css("color","rgb(5, 166, 16)");
              $('#form_kembali').show();
              var kembali = c_bayar - c_total_akhir;
              $('#kembali').val(separator_harga2(kembali));
            } else {
              var kredit = c_total_akhir - c_bayar;
              $('#kredit').val(separator_harga2(kredit));
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
          var harga_jual_rendah = $("#harga_jual_rendah_covered").val();
          var total = $("#total").val();

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
                url     : "<?php echo site_url(); ?>henkel_adm_penjualan/t_simpan",
                data    : string,
                cache   : false,
                start   : $("#simpan").html('...Sedang diproses...'),
                success : function(data){
                    $("#simpan").html('<i class="icon-save"></i> Simpan');
                    location.reload();
                }
            });
        });

        $("#simpan_pesanan_penjualan").click(function(){
            var id=$("#id").val();
            var kode_pelanggan = $("#kode_pelanggan").val();
            var pelanggan = $("#nama_pelanggan").val();
            var alamat = $("#alamat").val();
            var kode_sales = $("#kode_sales").val();
            var nama_sales = $("#nama_sales").val();
            var limit_a = $("#limit").val();
            var limit = parseInt(limit_a.replace(/\D/g,''));
            var total_akhir_a = $("#total_akhir").val();
            var total_akhir = parseInt(total_akhir_a.replace(/\D/g,''));
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

            if(total_akhir>limit){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Limit melebihi Total Akhir pembelian',
                    class_name: 'gritter-error'
                });
                $("#limit").focus();
                return false();
            }

            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_pesanan_penjualan/cek_table",
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
                    var r = confirm("Anda sudah yakin? Data yang sudah disimpan tidak dapat diubah lagi");
                    if (r == true) {
                      $.ajax({
                          type    : 'POST',
                          url     : "<?php echo site_url(); ?>henkel_adm_pesanan_penjualan/t_simpan",
                          data    : string,
                          cache   : false,
                          success : function(data){
                            var id= $("#id").val();
                            alert(data);
                            location.replace("<?php echo site_url(); ?>henkel_adm_pesanan_penjualan/edit/"+id)
                          }
                      });
                    }else {
                      return false();
                    }

                  }
                }
            });
        });

        $("#tambah").click(function(){
          var kode_pelanggan = $("#kode_pelanggan").val();

          if(kode_pelanggan.length==0){
              $.gritter.add({
                  title: 'Peringatan..!!',
                  text: 'Anda Belum Mengisi Kode Pelanggan',
                  class_name: 'gritter-error'
              });
              $("#kode_pelanggan").focus();
              return false();
          }else {
            $("#id_pesanan_penjualan").val('');
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

            $("#modal-table").modal('show');
          }
        });

        $("#cek").click(function(){
          var id_pes= $("#id_pesanan_pembelian").val();
          var no_po= $("#no_po").val();
          $.ajax({
              type    : 'POST',
              url     : "<?php echo site_url(); ?>henkel_adm_item_masuk/cek",
              data    : "id_pes="+id_pes,
              success : function(data){
                if(data==0){
                  alert('Tidak ada Data Pada No PO : '+no_po+' ');
                  location.reload();
                }else {
                  location.replace("<?php echo site_url(); ?>henkel_adm_item_masuk/tambah_invoice/"+btoa(id_pes));
                }

              }
          });
      	});

        $(window).on('beforeunload', function(){
            localStorage.setItem('kode_pelanggan', $('#kode_pelanggan').val());
            localStorage.setItem('nama_pelanggan', $('#nama_pelanggan').val());
            localStorage.setItem('alamat', $('#alamat').val());
            localStorage.setItem('margin_min', $('#margin_min').val());
            localStorage.setItem('margin_max', $('#margin_max').val());
            localStorage.setItem('limit', $('#limit').val());
            localStorage.setItem('kode_sales', $('#kode_sales').val());
            localStorage.setItem('nama_sales', $('#nama_sales').val());
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
      url     : "<?php echo site_url(); ?>henkel_adm_pesanan_penjualan/cek_table",
      data    : "id_cek="+id,
      success : function(data){
        if(data==0){
          $("#kode_pelanggan").val('');
          $("#nama_pelanggan").val('');
          $("#alamat").val('');
          $("#margin_min").val('');
          $("#margin_max").val('');
          $("#limit").val('');
          $("#kode_sales").val('');
          $("#nama_sales").val('');
        }else{
          var kode_pelanggan = localStorage.getItem('kode_pelanggan');
          var nama_pelanggan = localStorage.getItem('nama_pelanggan');
          var alamat = localStorage.getItem('alamat');
          var margin_min = localStorage.getItem('margin_min');
          var margin_max = localStorage.getItem('margin_max');
          var limit = localStorage.getItem('limit');
          var kode_sales = localStorage.getItem('kode_sales');
          var nama_sales = localStorage.getItem('nama_sales');
          $('#kode_pelanggan').val(kode_pelanggan);
          $('#nama_pelanggan').val(nama_pelanggan);
          $('#alamat').val(alamat);
          $('#margin_min').val(margin_min);
          $('#margin_max').val(margin_max);
          $('#limit').val(limit);
          $('#kode_sales').val(kode_sales);
          $('#nama_sales').val(nama_sales);
        }
    }
    });
}

function search_nm_item(){
  var kode_item = $("#kode_item").val();
  var kode_gudang = $("#kode_gudang").val();
  var margin_min = $("#margin_min").val();
  var margin_max = $("#margin_max").val();
  $.ajax({
    type	: "POST",
    url		: "<?php echo site_url(); ?>henkel_adm_search/search_nonseparated_item",
    data	: {kode_item: kode_item, kode_gudang: kode_gudang},
    dataType: "json",
    success	: function(data){
      $('#nama_item').val(data.nama_item);

      var harga_tebus_dpp = data.harga_tebus_dpp;
      var harga_tebus_dpp_clean = harga_tebus_dpp.replace(/\D/g,'');
      var ppn_htdpp = (harga_tebus_dpp_clean*10)/100;
      var harga_tebus_dpp_ppn = parseInt(harga_tebus_dpp_clean)+parseInt(ppn_htdpp);

      $('#he_terendah_dpp_ppn').val(separator_harga2(parseInt(harga_tebus_dpp_ppn)+((parseInt(harga_tebus_dpp_ppn)*parseInt(margin_min))/100)+parseInt(data.ongkos_kirim)));
      var he_terendah_dpp_ppn = parseInt(harga_tebus_dpp_ppn)+((parseInt(harga_tebus_dpp_ppn)*parseInt(margin_min))/100)+parseInt(data.ongkos_kirim);
      $('#he_terendah_dpp').val(separator_harga2(parseInt(he_terendah_dpp_ppn/parseFloat(1.1))));

      $('#he_tertinggi_dpp_ppn').val(separator_harga2(parseInt(harga_tebus_dpp_ppn)+((parseInt(harga_tebus_dpp_ppn)*parseInt(margin_max))/100)+parseInt(data.ongkos_kirim)));
      var he_tertinggi_dpp_ppn = parseInt(harga_tebus_dpp_ppn)+((parseInt(harga_tebus_dpp_ppn)*parseInt(margin_max))/100)+parseInt(data.ongkos_kirim);
      $('#he_tertinggi_dpp').val(separator_harga2(parseInt(he_tertinggi_dpp_ppn/parseFloat(1.1))));

      $('#harga_jual').val(separator_harga2(parseInt(he_tertinggi_dpp_ppn/parseFloat(1.1))));
      $('#harga_jual_rendah').val(separator_harga2(parseInt(he_terendah_dpp_ppn/parseFloat(1.1))));
      $('#harga_jual_rendah_covered').val(separator_harga2(parseInt(he_terendah_dpp_ppn/parseFloat(1.1))));
      $('#sub_total').val(separator_harga2(parseInt(he_tertinggi_dpp_ppn/parseFloat(1.1))));
      $('#total').val(separator_harga2(parseInt(he_tertinggi_dpp_ppn/parseFloat(1.1))));
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
    var margin_min = $("#margin_min").val();
    var margin_max = $("#margin_max").val();
    console.log(cari);
	$.ajax({
		type	: "GET",
		url		: "<?php echo site_url(); ?>henkel_adm_penjualan/t_cari",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
      var harga_tebus_dpp = data.harga_tebus_dpp;
      var ppn_htdpp = (harga_tebus_dpp*10)/100;
      var harga_tebus_dpp_ppn = parseInt(harga_tebus_dpp)+parseInt(ppn_htdpp);
			$('#id_penjualan').val(data.id_penjualan);
			$('#id_pesanan_penjualan').val(data.id_pesanan_penjualan);
      $('#kode_gudang').val(data.kode_gudang);
      $('#kode_item').html(data.kode_item);
      $('#kode_item').val(data.kode_item_val);
      $('#nama_item').val(data.nama_item);
      $('#he_terendah_dpp_ppn').val(separator_harga2(parseInt(harga_tebus_dpp_ppn)+((parseInt(harga_tebus_dpp_ppn)*parseInt(margin_min))/100)+parseInt(data.ongkos_kirim)));
      var he_terendah_dpp_ppn = parseInt(harga_tebus_dpp_ppn)+((parseInt(harga_tebus_dpp_ppn)*parseInt(margin_min))/100)+parseInt(data.ongkos_kirim);
      $('#he_terendah_dpp').val(separator_harga2(parseInt(he_terendah_dpp_ppn/parseFloat(1.1))));
      $('#he_tertinggi_dpp_ppn').val(separator_harga2(parseInt(harga_tebus_dpp_ppn)+((parseInt(harga_tebus_dpp_ppn)*parseInt(margin_max))/100)+parseInt(data.ongkos_kirim)));
      var he_tertinggi_dpp_ppn = parseInt(harga_tebus_dpp_ppn)+((parseInt(harga_tebus_dpp_ppn)*parseInt(margin_max))/100)+parseInt(data.ongkos_kirim);
      $('#he_tertinggi_dpp').val(separator_harga2(parseInt(he_tertinggi_dpp_ppn/parseFloat(1.1))));
      $('#harga_jual').val(separator_harga2(data.harga_jual));
      $('#sub_total').val(data.sub_total);
      $('#stok').val(data.stok);
      $('#jumlah').val(data.jumlah);
      $('#disk_rp').val(data.disk_rp);
      $('#diskon').val(data.diskon);

      //call function diskon
      var sub_total = data.sub_total;
      var diskon = data.diskon;
      $('#total').val(f_diskon(sub_total,diskon));
		}
	});
}

function hapusData(id){
  $.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>henkel_adm_penjualan/t_hapus/"+id,
		data	: "id_h="+id,
		dataType: "json",
		success	: function(){
      location.reload();
		}
    });
}

function f_jumlah(satuan,jml){
  var harga_satuan = satuan;
  var jumlah = jml;
  var clean = harga_satuan.replace(/\D/g,'');
  var harga = clean * jumlah;
  var bilangan = separator_harga2(harga);
  return bilangan;
}

function f_diskon(hrg,disk){
  var harga = hrg;
  var persen = disk;
  var clean = harga.replace(/\D/g,'');
  var diskon = (clean * persen)/100;
  var total = clean - diskon;
  var bilangan = separator_harga2(parseInt(total));
  $("#disk_rp").val(separator_harga2(parseInt(diskon)));
  return bilangan;
}

function separator_harga2(ID){
  var bilangan  = ID;
  var reverse = bilangan.toString().split('').reverse().join(''),
  ribuan  = reverse.match(/\d{1,3}/g);
  ribuan  = ribuan.join('.').split('').reverse().join('');
  return ribuan;
}

function reset()
  {
    $('#enable_pajak').prop('checked', false);
    $('#pajak').val('0');
    $("#form_faktur").hide();
    $("#bayar").val('0');
  }
</script>
<?php
error_reporting(E_ALL ^ E_NOTICE);
?>
<form class="form-horizontal" name="form_penjualan" id="form_penjualan" action="<?php echo base_url();?>henkel_adm_pesanan_penjualan/cetak" method="post">
<div class="row-fluid">
<div class="table-header">
    <?php echo 'No. Transaksi : '.$no_transaksi;?><input type="hidden" name="notransaksi" id="notransaksi" value="<?php echo $no_transaksi?>">
    <div class="pull-right" style="padding-right:15px;"><?php echo 'Tanggal : '.tgl_indo($tanggal);?></div><input type="hidden" name="tanggal" id="tanggal" value="<?php echo $tanggal?>">
    <input type="hidden" value="<?php echo $id_pesanan_penjualan;?>" name="id" id="id">
</div>
<div class="space"></div>
   <div class="row-fluid">
        <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="form-field-1">No Transaksi</label>
                    <div class="controls">
                        <input type="text" class="autocomplete" value="<?php echo $no_transaksi;?>" name="no_transaksi" id="no_transaksi" placeholder="No Transaksi" readonly="readonly" />
                        <button type="button" name="show_data_transaksi" id="show_data_transaksi" class="btn btn-small btn-info">
                            <i class="icon-search"></i>
                            Cari
                        </button>
                    </div>
               </div>
               <div class="control-group">
                 <label class="control-label" for="form-field-1">Skema Komisi</label>
                      <div class="controls">
                      <?php ?>
                      <select name="kode_komisi" id="kode_komisi">
                        <option value="" selected="selected">--Pilih Nama Komisi--</option>
                          <?php
                            $data = $this->db_kpp->get('komisi');
                            foreach($data->result() as $dt){
                          ?>
                           <option value="<?php echo $dt->kode_komisi;?>"><?php echo $dt->nama_komisi;?></option>
                          <?php
                            }
                          ?>
                         </select>
                      </div>
                  </div>
                  <div class="control-group">
                     <div class="controls">
                        <button type="button" name="cek" id="cek" class="btn btn-small btn-success">
                            Proses
                        </button>
                      </div>
                  </div>
         </div>
    </div>
<div class="space"></div>
<div class="table-header">
 Tabel Data Karyawan
 <div class="widget-toolbar no-border pull-right">
 </div>
</div>
<table class="table lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Nik</th>
            <th class="center">Nama Karyawan</th>
            <th class="center">Tetapkan Sebagai</th>
        </tr>
    </thead>
    <tbody>
        <?php
        //error_reporting(0);
        $i=1;
        foreach($data_karyawan->result() as $dt){ ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->nik;?></td>
            <td class="center"><?php echo $dt->nama_karyawan;?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_t_penjualan;?>')" data-toggle="modal">
                        <i class="icon-th-large" aria-hidden="true"></i>
                    </a>
                </div>

                <div class="hidden-desktop visible-phone">
                    <div class="inline position-relative">
                        <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-caret-down icon-only bigger-120"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-icon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
                            <li>
                              <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_t_penjualan;?>')" data-toggle="modal">
                                  <i class="icon-pencil bigger-130"></i>
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
<br>

<div class="row-fluid">
     <div class="span12" align="center">
         <a href="<?php echo base_url();?>henkel_adm_pesanan_penjualan" class="btn btn-small btn-danger">
             <i class="icon-remove"></i>
             Cancel
         </a>
         <button type="button" name="new" id="new" class="btn btn-small btn-success">
             <i class="icon-save"></i>
             Transaksi Baru
         </button>
          <button type="button" name="simpan_pesanan_penjualan" id="simpan_pesanan_penjualan" class="btn btn-small btn-primary">
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
