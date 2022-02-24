<script type="text/javascript">
$(document).ready(function(){
        $("body").on("click", ".delete", function (e) {
            $(this).parent("div").remove();
        });

        $("#tunai").keyup(function(){
          var tp=$('#total_pembelian').val();
          var t=$('#tunai').val();
          $('#sisa').val(sisa(tp,t));
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

    $("#enable_pot_hutang").change(function() {
      if(this.checked) {
          var total_retur=$('#total_retur').val();
          $('#potong_hutang').val(total_retur);
          $('#potong_hutang').attr('readonly', false);
          $('#potong_hutang').focus();
      }else {
          $('#potong_hutang').attr('readonly', true);
          $('#potong_hutang').val('0');
      }
  });

        //datatables
        $("#show").click(function(){
            var supplier= $("#kode_supplier").val();
            $.ajax({
          		type	: "GET",
          		url		: "<?php echo site_url();?>henkel_adm_datatable/search_no_invoice",
          		data	: "kode_supplier="+supplier,
          		dataType: "json",
          		success	: function(data){
                        table = $('#show_transaksi').DataTable({
                        "bProcessing": true,
                        "bDestroy": true,
                        "sAjaxSource": '<?php echo site_url();?>henkel_adm_datatable/search_no_invoice?kode_supplier='+supplier,
                        "bSort": true,
                        "bAutoWidth": true,
                        "iDisplayLength": 10, "aLengthMenu": [10,20,40,80], // can be removed for basic 10 items per page
                        "sPaginationType": "full_numbers",
                        "aoColumnDefs": [{"bSortable": false,
                                         "aTargets": [ -1 , 0]}], //Feature control DataTables' server-side processing mode.
                        "aoColumns": [
                          {"mData" : "no_invoice"},
                          {"mData" : "tanggal"},
                          {"mData" : "kode_supplier"},
                          {"mData" : "qty"},
                          {"mData" : "total_akhir"}
                        ]
                    });
                    $('#modal-search').modal('show');
          		},
              error : function(data){
                alert('Data Transaksi Kosong');
                var id= $("#id").val();
                $.ajax({
                    type    : 'POST',
                    url     : "<?php echo site_url(); ?>henkel_adm_retur_pembelian/baru",
                    data    : "id_new="+id,
                    success : function(data){
                      location.reload();
                    }
                });
              }
          	});

        	});
          $('#show_transaksi tbody').on( 'click', 'tr', function () {
              var data=$(this).find('td').eq(0).text();
              $("#no_pembelian").val(data);
              $('#modal-search').modal('hide');
          } );

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

        $("#cek").click(function(){
          var no_pe= $("#no_pembelian").val();
          var id= $("#id").val();
          $.ajax({
              type    : 'POST',
              url     : "<?php echo site_url(); ?>henkel_adm_retur_pembelian/cek",
              data    : {no_pembelian:no_pe,id_retur_pembelian:id},
              success : function(data){
                if(data==0){
                  alert('Transaksi dengan Kode '+no_pe+' kosong');
                  location.reload();
                }else {
                  location.replace("<?php echo site_url(); ?>henkel_adm_retur_pembelian/tambah");
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
              url     : "<?php echo site_url(); ?>henkel_adm_retur_pembelian/baru",
              data    : "id_new="+id,
              success : function(data){
                location.replace("<?php echo site_url(); ?>henkel_adm_retur_pembelian/tambah");
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
          var harga_beli = $('#harga_beli').val();
          var c_harga_beli = toAngka(harga_beli);
          var jumlah = $('#jumlah').val();
          var fjumlah = c_harga_beli * jumlah;
          $('#harga').val(toHarga(fjumlah));
          //call function diskon
          var harga = $("#harga").val();
          var c_harga = toAngka(harga);
          var diskon = $("#diskon").val();
          var persen = (c_harga*diskon)/100;
          var total = c_harga - persen;
          $('#total').val(toHarga(total));
      	});

        $("#simpan").click(function(){
          var kode_item = $("#kode_item").val();
          var jumlah = parseInt($("#jumlah").val());
          var jumlah_beli = parseInt($("#jumlah_beli").val());

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

          if(jumlah>jumlah_beli){
              $.gritter.add({
                  title: 'Peringatan..!!',
                  text: 'Jumlah Retur Melebihi Batas Jumlah Beli',
                  class_name: 'gritter-error'
              });

              $("#jumlah").focus();
              return false();
          }

            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_r_pembelian/t_simpan",
                data    : string,
                cache   : false,
                success : function(data){
                    location.reload();
                }
            });
        });

        $("#simpan_retur_pembelian").click(function(){
            var id=$("#id").val();
            var kode_supplier = $("#kode_supplier").val();
            var supplier = $("#nama_supplier").val();
            var alamat = $("#alamat").val();
            var total_retur = $("#total_retur").val();
            var keterangan = $("#keterangan").val();

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


            if(total_retur==0 || total_retur==''){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Belum dilakukan retur',
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
                  url     : "<?php echo site_url(); ?>henkel_adm_retur_pembelian/t_simpan",
                  data    : string,
                  cache   : false,
                  success : function(data){
                    var id= $("#id").val();
                    alert(data);
                    location.replace("<?php echo site_url(); ?>henkel_adm_retur_pembelian/edit/"+id)
                  }
              });
            }else {
              return false();
            }


        });

        $("#tambah").click(function(){
          $("#id_retur_pembelian").val(<?php echo $id_retur_pembelian ?>);
          $("#kode_item").val('');
          $("#nama_item").val('');
          $("#harga_satuan").val('');
          $("#jumlah").val('1');
          $("#harga").val('');
          $("#diskon").val('0');
          $("#total").val('');
          $("#stok").val('0');
        });

        $(window).on('beforeunload', function(){
            localStorage.setItem('kode_supplier', $('#kode_supplier').val());
            localStorage.setItem('nama_supplier', $('#nama_supplier').val());
            localStorage.setItem('alamat', $('#alamat').val());
            localStorage.setItem('no_pembelian', $('#no_pembelian').val());
        });

});

window.onload = function() {
  var id=$("#id").val();
  $.ajax({
      type    : 'POST',
      url     : "<?php echo site_url(); ?>henkel_adm_retur_pembelian/cek_table",
      data    : "id_cek="+id,
      success : function(data){
        if(data==0){
          $("#kode_supplier").val('');
          $("#nama_supplier").val('');
          $("#alamat").val('');
          $("#no_pembelian").val('');
        }else{
          var kode_supplier = localStorage.getItem('kode_supplier');
          var nama_supplier = localStorage.getItem('nama_supplier');
          var alamat = localStorage.getItem('alamat');
          var no_pembelian = localStorage.getItem('no_pembelian');
          $('#kode_supplier').val(kode_supplier);
          $('#nama_supplier').val(nama_supplier);
          $('#alamat').val(alamat);
          $('#no_pembelian').val(no_pembelian);
          $.ajax({
            type : 'GET',
            url  : "<?php echo site_url(); ?>henkel_adm_retur_pembelian/get_total_transaksi",
            data : "no_pembelian="+no_pembelian,
            dataType:'json',
            success : function(data){
              $('#total_pembelian').val(data.total_akhir);
              $('#diskon_transaksi').val(data.diskon);
              $('#total_bayar').val(data.bayar);
              var total_akhir=$('#total_akhir').val();
              var diskon=f_diskon(total_akhir,data.diskon);
              $('#total_retur').val(diskon);

            }
          });
        }
    }
    });
}

function sisa(a,b){
  var c_a=a.replace(/\D/g,'');
  var c_b=b.replace(/\D/g,'');
  var hasil=c_a-c_b;
  var bilangan = separator_harga2(hasil);
  return bilangan;
}

function search_kd_item(){
  var kode_gudang = $("#kode_gudang").val();
  $.ajax({
    type	: "POST",
    url		: "<?php echo site_url(); ?>henkel_adm_search/search_kd_item",
    data	: "kode_gudang="+kode_gudang,
    dataType: "json",
    success	: function(data){
      $('#kode_item').html(data);
    }
  });
}

function search_nm_item(){
  var kode_item = $("#kode_item").val();
  var kode_gudang = $("#kode_gudang").val();

  $.ajax({
    type	: "POST",
    url		: "<?php echo site_url(); ?>henkel_adm_search/search_nm_item",
    data	: {kode_item: kode_item, kode_gudang: kode_gudang},
    dataType: "json",
    success	: function(data){
      $('#nama_item').val(data.nama_item);
      $('#harga_satuan').val(data.harga_satuan);
      $('#stok').val(data.stok);
      $('#harga').val(data.harga_satuan);
      $('#total').val(data.harga_satuan);
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
		url		: "<?php echo site_url(); ?>henkel_adm_r_pembelian/t_cari",
		data	: "cari="+cari,
		dataType: "json",
		success	: function(data){
			$('#id_r_pembelian').val(data.id_r_pembelian);
			$('#id_retur_pembelian').val(data.id_retur_pembelian);
      $('#kode_item').val(data.kode_item);
      $('#nama_item').val(data.nama_item);
      $('#harga_beli').val(data.harga_item);
      $('#jumlah_beli').val(data.jumlah);
      $('#jumlah').val(data.jumlah_retur);
      $('#diskon').val(data.diskon);
      //call function jumlah
      var harga_satuan = data.harga_item;
      var jumlah = data.jumlah_retur;
      $('#harga').val(f_jumlah(harga_satuan,jumlah));
      //call function diskon
      var harga = $("#harga").val();
      var diskon = data.diskon;
      $('#total').val(f_diskon(harga,diskon));
		}
	});
}

function hapusData(id){
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

<form class="form-horizontal" name="form_pembelian" id="form_pembelian" action="<?php echo base_url();?>henkel_adm_pesanan_pembelian/cetak" method="post">
<div class="row-fluid">
<div class="table-header">
    <?php echo 'No. Retur : '.$no_transaksi;?><input type="hidden" name="no_transaksi" id="no_transaksi" value="<?php echo $no_transaksi?>">
    <div class="pull-right" style="padding-right:15px;"><?php echo 'Tanggal : '.tgl_indo($tanggal);?></div><input type="hidden" name="tanggal" id="tanggal" value="<?php echo $tanggal?>">
    <input type="hidden" value="<?php echo $id_retur_pembelian;?>" name="id" id="id">
</div>
<div class="space"></div>
   <div class="row-fluid">
        <div class="span6">
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
                    <label class="control-label" for="form-field-1">No. Invoice</label>
                    <div class="controls">
                        <input type="text" class="autocomplete" value="" name="no_pembelian" id="no_pembelian" placeholder="No. Invoice"/>
                        <button type="button" id="show" name="show" class="btn btn-info btn-small" data-toggle="modal"><i class="icon-search"></i>
                        Cari</button>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="button" id="cek" name="cek" class="btn btn-warning btn-small" >Cek Transaksi</button>
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
            <th class="center">Jumlah Beli</th>
            <th class="center">Jumlah Retur</th>
            <th class="center">Sub. Total</th>
            <th class="center">Diskon</th>
            <th class="center">Total</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        error_reporting(0);
        $i=1;
        $total_transaksi=0;
        $harga=0;
        $persen=0;
        $total_item=0;
        foreach($data->result() as $dt){ ?>
        <tr>
          <?php
            $jumlah_beli = $dt->qty;
            $jumlah_retur = $dt->qty_retur;
            $sub_total = $jumlah_beli*$dt->harga_tebus_dpp;
            $sub_total_retur = $jumlah_retur*$dt->harga_tebus_dpp;
            $harga = $dt->harga_tebus_dpp*$jumlah_beli;
            $persen = ($harga * $dt->diskon)/100;
            $persen_retur = ($sub_total_retur * $dt->diskon)/100;
            $harga_retur = $sub_total_retur-$persen_retur;
            if ($sub_total_retur==0) { $total=0; }
            $total = $sub_total-$persen;
            $total_transaksi += ($jumlah_beli*$dt->harga_tebus_dpp)-$persen;
            $ppn = ($total_transaksi * 10)/100;
            $total_transaksi_ppn = $total_transaksi+$ppn;
            $total_retur += $harga_retur;
          ?>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->kode_item;?></td>
            <td class="center"><?php echo $dt->nama_item;?></td>
            <td class="center"><?php echo $jumlah_beli;?></td>
            <td class="center"><?php echo $dt->qty_retur;?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($sub_total_retur);?></td>
            <td class="center"><?php echo $dt->diskon." %";?></td>
            <td class="center"><?php echo 'Rp. '.separator_harga2($harga_retur);?></td>
            <td class="td-actions"><center>
                <div class="text-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_t_r_pembelian;?>')" data-toggle="modal">
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
</br>
<div class="row-fluid">
     <div class="span4">
             <!--<div class="control-group">
                 <label class="control-label" for="form-field-1">Diskon Transaksi</label>
                 <div class="controls">
                     <input class="span6" type="text" min="0" max="100" value="" maxlength="3" name="diskon_transaksi" id="diskon_transaksi"  placeholder="0" readonly="readonly" /><span style="font-weight:bold"> %</span>
                 </div>
            </div>-->
             <div class="control-group">
                 <label class="control-label" for="form-field-1">Pajak</label>
                 <div class="controls">
                     <input class="span6" type="text" value="" min="0" name="pajak" id="pajak" placeholder="0"/> <span style="font-weight:bold"> %</span>
                 </div>
             </div>
      </div>
      <div class="span4">
        <div class="control-group" id="form_enable">
            <label class="control-label" for="form-field-1">  <input type="checkbox" name="enable" id="enable"> <span class="lbl"></span> Tunai</label>
            <div class="controls total_harga">
                <input type="text" class="span12" style="text-align: right;" value="" name="tunai" id="tunai" placeholder="0" onkeyup = "javascript:this.value=autoseparator(this.value);" readonly="readonly"/>
            </div>
       </div>
       <div id="form_deposit" class="control-group">
           <label class="control-label" for="form-field-1"><input type="checkbox" name="enable_deposit" id="enable_deposit"> <span class="lbl"></span> Deposit</label>
           <div class="controls">
               <input class="span12" type="text" style="text-align: right;" value=""  name="deposit" id="deposit" placeholder="0" onkeyup = "javascript:this.value=autoseparator(this.value);" readonly="readonly"/>
           </div>
       </div>
       <div id="form_pp" class="control-group">
           <label class="control-label" for="form-field-1"><input type="checkbox" name="enable_pot_hutang" id="enable_pot_hutang"> <span class="lbl"></span> Pot. Hutang</label>
           <div class="controls total_harga">
             <input type="text" class="span12" style="text-align: right;" name="potong_hutang" id="potong_hutang" placeholder="0" onkeyup = "javascript:this.value=autoseparator(this.value);" readonly="readonly"/>
           </div>
      </div>

      </div>

      <div class="span4">
              <div class="control-group">
                  <label class="control-label" for="form-field-1"> Total Transaksi</label>
                  <div class="controls total_harga">
                      <input type="text" class="span12" style="text-align: right;"  name="total_transaksi" id="total_transaksi" value="<?php echo separator_harga2($total_transaksi_ppn); ?>" placeholder="0" readonly="readonly" />
                  </div>
             </div>
            <div class="control-group">
                <label class="control-label" for="form-field-1"> Total DP</label>
                <div class="controls total_harga">
                    <input type="text" class="span12" style="text-align: right;"  min='0' name="total_bayar" id="total_bayar" placeholder="0" readonly="readonly" />
                </div>
           </div>
             <div class="hidden">
                  <input type="text" class="span12" style="text-align: right;" value="<?php echo separator_harga2($total_dp); ?>" min='0' name="total_akhir" id="total_akhir" placeholder="0" readonly="readonly" />
             </div>
              <div class="control-group">
                  <label class="control-label" for="form-field-1"> Total Retur</label>
                  <div class="controls total_harga">
                      <input type="text" class="span12" style="text-align: right;" value="<?php echo separator_harga2($total_retur); ?>" min='0' name="total_retur" id="total_retur" placeholder="0" readonly="readonly" />
                  </div>
             </div>
       </div>
 </div>
 <div class="row-fluid">
   <div class="span12">
     <div class="control-group">
         <label class="control-label" for="form-field-1"> Keterangan</label>
         <div class="controls">
             <input type="text" class="span4"  value="<?php echo $keterangan; ?>" name="keterangan" id="keterangan" placeholder="Keterangan"/>
         </div>
    </div>
   </div>
 </div>
 <br>

</form>

</br>
<div class="row-fluid">
     <div class="span12" align="center">
         <a href="<?php echo base_url();?>henkel_adm_pesanan_pembelian" class="btn btn-small btn-danger">
             <i class="icon-remove"></i>
             Cancel
         </a>
         <button type="button" name="new" id="new" class="btn btn-small btn-success">
             <i class="icon-save"></i>
             Transaksi Baru
         </button>
          <button type="button" name="simpan_retur_pembelian" id="simpan_retur_pembelian" class="btn btn-small btn-warning">
              <i class="icon-save"></i>
              Simpan
          </button>

      </div>
</div>

</div>

<div id="modal-search" class="modal hide fade" style="width:80%;max-height:80%;left:30%;" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Cari No. Invoice
        </div>
    </div>

    <div class="no-padding">
        <div class="row-fluid">
          <table class="table lcnp table-striped table-bordered table-hover" style='min-width:100%;' id="show_transaksi">
              <thead>
                  <tr>
                      <th class="center" style="display: none">No</th>
                      <th class="center">No Invoice</th>
                      <th class="center">Tanggal Invoice</th>
                      <th class="center">Kode Supplier</th>
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
            <input type="hidden" name="id_retur_pembelian" id="id_retur_pembelian">
            <input type="hidden" name="id_r_pembelian" id="id_r_pembelian">
            <br>
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
                    <label class="control-label" for="form-field-1">Harga Beli</label>

                    <div class="controls">
                        <input type="text" value="0" min="0" name="harga_beli" id="harga_beli" placeholder="0" readonly="readonly" /> <span style="font-weight:bold">Rp</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Jumlah Beli</label>

                    <div class="controls">
                        <input type="text" value="1" min="1" name="jumlah_beli" id="jumlah_beli" placeholder="0" readonly="readonly"/>
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
                        <input type="text" value="0" min="0" name="harga" id="harga" placeholder="Harga" readonly="readonly"/> <span style="font-weight:bold">Rp</span>
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
                        <input type="text" value="0" min="0" name="total" id="total" placeholder="Total" readonly="readonly" /> <span style="font-weight:bold">Rp</span>
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
