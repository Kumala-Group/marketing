<script type="text/javascript">
$(document).ready(function(){
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

        $("#kode_item").autocomplete({
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
        });

        $("#new").click(function(){
          var id= $("#id").val();
          $.ajax({
              type    : 'POST',
              url     : "<?php echo site_url(); ?>henkel_adm_biaya_angkut/baru",
              data    : "id_new="+id,
              success : function(data){
                location.replace("<?php echo site_url(); ?>henkel_adm_biaya_angkut/tambah");
              }
          });
      	});
        var date = new Date();
        date.setDate(date.getDate()-1);
        $('.date-picker').datepicker({
          startDate: date
        });

        $("#jumlah").keyup(function(){
          //call function diskon
          var harga_satuan = $('#harga_satuan').val();
          var jumlah = $('#jumlah').val();
          $('#harga').val('Rp. '+f_jumlah(harga_satuan,jumlah));
          //call function diskon
          var harga = $("#harga").val();
          var diskon = $("#diskon").val();
          $('#total').val('Rp. '+f_diskon(harga,diskon));
        });

        $("#diskon").keyup(function(){
          var harga = $("#harga").val();
          var diskon = $("#diskon").val();
          var total = f_diskon(harga,diskon);
          $('#total').val(total);
        });

        $("#disk_rp").keyup(function(){
          var disk_rp = $("#disk_rp").val()
          var harga = $("#harga").val();
          var c_disk_rp = disk_rp.replace(/\D/g,'');
          var c_harga = harga.replace(/\D/g,'');
          var diskon= (c_disk_rp/c_harga)*100;
          var total = c_disk_rp - c_harga;
          var bilangan = separator_harga2(parseInt(total));
          $('#total').val(bilangan);
          $('#diskon').val(diskon);
        });

        $("#diskon_rp").keyup(function(){
          var diskon_rp = $("#diskon_rp").val()
          var harga = $("#total_akhir3").val();
          var c_diskon_rp = diskon_rp.replace(/\D/g,'');
          var c_harga = harga.replace(/\D/g,'');
          var diskon_all= (c_diskon_rp/c_harga)*100;
          var total = c_diskon_rp - c_harga;
          var bilangan = separator_harga2(parseInt(total));
          $('#total_akhir').val(bilangan);
          $('#kredit').val(bilangan);
          $('#diskon_all').val(diskon_all);
        });

        $("#diskon_all").keyup(function(){
          var harga = $("#total_akhir2").val();
          var clean = harga.replace(/\D/g,'');
          var persen = $("#diskon_all").val();
          var ppn = (clean * 10)/100;
          var diskon = (clean * persen)/100;
          var total = clean - diskon;
          var bilangan =separator_harga2(parseInt(total)+parseInt(ppn));
          $('#total_akhir').val(bilangan);
          $('#kredit').val(bilangan);
          $('#diskon_rp').val(separator_harga2(parseInt(diskon)));
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
              $('#kembali').val(separator_harga2(parseInt(kembali)));
            } else {
              var kredit = c_total_akhir - c_bayar;
              $('#kredit').val(separator_harga2(parseInt(kredit)));
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
          var id_t_biaya_angkut = $("#id_t_biaya_angkut").val();
            var no_inv_pengirimank = $("#no_inv_pengirimank").val();
            var no_inv_supplier = $("#no_inv_supplier").val();
            var id_pesanan_pembelian = $("#id_pesanan_pembelian").val();

            var string = $("#my-form").serialize();

            if(no_inv_supplier.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Kode Item tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#no_inv_supplier").focus();
                return false();
            }

            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_biaya_angkut/t_simpan",
                data    : string,
                cache   : false,
                start   : $("#simpan").html('Sedang diproses...'),
                success : function(data){
                    $("#simpan").html('<i class="icon-save"></i> Simpan');
                    alert(data);
                    location.reload();
                }
            });
        });

        $("#simpan_biaya").click(function(){
            var id=$("#id").val();
            var no_inv_pengiriman = $("#no_inv_pengiriman").val();
            var keterangan = $("#biaya_pengiriman").val();
            var tanggal_pengiriman = $("#tanggal_pengiriman").val();

            var string = $("#form_biaya_angkut").serialize();


            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_biaya_angkut/cek_table",
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
                        url     : "<?php echo site_url(); ?>henkel_adm_biaya_angkut/simpan",
                        data    : string,
                        cache   : false,
                        start   : $("#simpan_biaya").html('Sedang diproses...'),
                        success : function(data){
                          $("#simpan_biaya").html('<i class="icon-save"></i> Simpan');
                          var id= $("#id").val();
                          alert(data);
                          location.replace("<?php echo site_url(); ?>henkel_adm_biaya_angkut/edit/"+id)
                        }
                    });
                  }
                }
            });
        });

        //datatables
        $("#cari_no_po").click(function(){
          var no_po = $("#no_po").val();
          $.ajax({
            type	: "GET",
            url		: "<?php echo site_url();?>henkel_adm_datatable/no_po_angkut",
            //data	: "no_po="+no_po,
            dataType: "json",
            success	: function(data){
                      var table = $('#show_transaksi').DataTable({
                      "bProcessing": true,
                      "bDestroy": true,
                      "sAjaxSource": '<?php echo site_url();?>henkel_adm_datatable/no_po_angkut',
                      "bSort": false,
                      "bAutoWidth": true,
                      "iDisplayLength": 10, "aLengthMenu": [10,20,40,80], // can be removed for basic 10 items per page
                      "sPaginationType": "full_numbers",
                      "aoColumnDefs": [{"bSortable": false,
                                       "aTargets": [ -1 , 0]}], //Feature control DataTables' server-side processing mode.
                      "aoColumns": [
                        {"mData" : "no"},
                        {"mData" : "id_pesanan_pembelian"},
                        {"mData" : "no_po"},
                        {"mData" : "tanggal"},
                        {"mData" : "kode_supplier"},
                        {"mData" : "nama_supplier"},
                        {"mData" : "keterangan"}
                      ]
                  });
                  $('#modal-search').modal('show');
            }
          });
          });

          $('#show_transaksi tbody').on( 'click', 'tr', function () {
              var id_pesanan_pembelian=$(this).find('td').eq(1).text();
              var no_po=$(this).find('td').eq(2).text();
              var tanggal=$(this).find('td').eq(3).text();
              var kode_supplier=$(this).find('td').eq(4).text();
              var nama_supplier=$(this).find('td').eq(5).text();
              var keterangan=$(this).find('td').eq(6).text();
              $("#id_pesanan_pembelian").val(id_pesanan_pembelian);
              $("#no_po").val(no_po);
              $("#tanggal_po").val(tanggal);
              $("#kode_supplier").val(kode_supplier);
              $("#nama_supplier").val(nama_supplier);
              $("#keterangan_po").val(keterangan);
              $('#modal-search').modal('hide');
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
          $("#id_pesanan_pembelian").val(<?php echo "$id_pesanan_pembelian" ?>);
            $("#no_inv_pengirimank").val($("#no_inv_pengiriman").val());
          $("#kode_item").val('');
          $("#nama_item").val('');
          $("#harga_satuan").val('');
          $("#jumlah").val('1');
          $("#harga").val('');
          $("#diskon").val('');
          $("#disk_rp").val('');
          $("#total").val('');
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
      url     : "<?php echo site_url(); ?>henkel_adm_biaya_angkut/cek_table",
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
      $('#id_biaya_angkut').val(data.id_biaya_angkut);
      $('#kode_item').val(data.kode_item);
      $('#nama_item').val(data.nama_item);
      $('#harga_satuan').val('Rp. '+data.harga_item);
      $('#jumlah').val(data.jumlah);
      $('#disk_rp').val(data.disk_rp);
      $('#diskon').val(data.diskon);
      //call function jumlah
      var harga_satuan = data.harga_item;
      var jumlah = data.jumlah;
      $('#harga').val(f_jumlah(harga_satuan,jumlah));
      //call function diskon
      var harga = $("#harga").val();
      var diskon = data.diskon;
      $('#total').val(f_diskon(harga,diskon));
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
<form class="form-horizontal" name="form_biaya_angkut" id="form_biaya_angkut" method="post">
<div class="row-fluid">
<div class="table-header">
    <?php echo 'No. Invoice Pengiriman : ';?><input type="text" name="no_inv_pengiriman" id="no_inv_pengiriman" placeholder="No. Invoice Pengiriman">
    <div class="pull-right" style="padding-right:15px;"><?php echo 'Tanggal : '.tgl_indo($tanggal);?></div><input type="hidden" name="tanggal" id="tanggal" value="<?php echo $tanggal?>">
    <input type="hidden" value="<?php echo $id_pesanan_pembelian;?>" name="id" id="id">
</div>
</br>
<?php
error_reporting(E_ALL ^ E_NOTICE);
?>


<div class="table-header">
 Tabel Invoice Pembelian
 <div class="widget-toolbar no-border pull-right">
   <a href="#modal-table" data-toggle="modal" name="tambah" id="tambah" class="btn btn-small btn-success">
       <i class="icon-plus"></i>
       Tambah Invoice Pembelian
   </a>
 </div>
</div>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Invoice Supplier</th>
            <th class="center">No. PO</th>
            <th class="center">Kode Supplier</th>
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
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->no_inv_supplier;?></td>
            <td class="center"><?php echo $dt->no_po;?></td>
            <td class="center"><?php echo $dt->kode_supplier;?></td>
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

        </div>
         <div class="span4">


        <div class="span4">
          <div class="control-group">
              <label class="control-label" for="form-field-1">Tanggal Pengiriman</label>
              <div class="controls">
                <div class="input-append">
                  <input type="text" name="tanggal_pengiriman" id="tanggal_pengiriman" class="date-picker"  data-date-format="dd-mm-yyyy" placeholder="Tanggal Pengiriman"/>
                </div>
              </div>
          </div>
          <div class="control-group">
              <label class="control-label" for="form-field-1">Biaya Pengiriman</label>

              <div class="controls">
                  <input type="text" name="biaya_pengiriman" id="biaya_pengiriman" placeholder="Biaya Pengiriman" onkeyup="javascript:this.value=autoseparator(this.value);" onkeydown="return justAngka(event)"/>
          </div>
       </div>

        </div>
    </div>
</form>

<div class="row-fluid">
     <div class="span12" align="center">
          <a href="<?php echo base_url();?>index.phphenkel_adm_biaya_angkut" class="btn btn-small btn-danger">
             <i class="icon-remove"></i>
             Cancel
          </a>
          <button type="submit" name="new" id="new" class="btn btn-small btn-success">
            <i class="icon-print"></i>
              Transaksi Baru
          </button>
          <button type="button" name="simpan_biaya" id="simpan_biaya" class="btn btn-small btn-warning">
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
            Tambah Invoice
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
            <input type="hidden" name="id_t_biaya_angkut" id="id_t_biaya_angkut"><input type="hidden" name="no_inv_pengirimank" id="no_inv_pengirimank">
            <input type="hidden" name="id_pesanan_pembelian" id="id_pesanan_pembelian">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">No. Po</label>

                    <div class="controls">
                        <input type="text" name="no_po" id="no_po" placeholder="No. PO" />
                        <button type="button" name="cari_no_po" id="cari_no_po" class="btn btn-small btn-info">
                          <i class="icon-search"></i>
                          Cari
                        </button>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Tanggal</label>

                    <div class="controls">
                        <input type="text" name="tanggal_po" id="tanggal_po" placeholder="Tanggal PO" readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kode Supplier</label>

                    <div class="controls">
                        <input type="text" name="kode_supplier" id="kode_supplier" placeholder="Kode Supplier" readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Supplier</label>

                    <div class="controls">
                        <input type="text" name="nama_supplier" id="nama_supplier" placeholder="Nama Supplier" readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Keterangan</label>

                    <div class="controls">
                        <input type="text" name="keterangan_po" id="keterangan_po" placeholder="Keterangan" readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">No. Invoice Supplier</label>

                    <div class="controls">
                        <input type="text" name="no_inv_supplier" id="no_inv_supplier" placeholder="No. Invoice Supplier">

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

<div id="modal-search" class="modal hide fade" style="width:80%;max-height:80%;left:30%;" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Cari No. Po
        </div>
    </div>

    <div class="no-padding">
        <div class="row-fluid">
          <table class="table lcnp table-striped table-bordered table-hover" style="width: 100%;" id="show_transaksi">
              <thead>
                  <tr>
                      <th class="center">No</th>
                      <th class="center">Id Pesanan Pembelian</th>
                      <th class="center">No PO</th>
                      <th class="center">Tanggal PO</th>
                      <th class="center">Kode Supplier</th>
                      <th class="center">Nama Supplier</th>
                      <th class="center">Keterangan</th>
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
