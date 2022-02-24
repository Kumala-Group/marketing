<script type="text/javascript">
$(document).ready(function(){
        $("body").on("click", ".delete", function (e) {
            $(this).parent("div").remove();
        });

        $('.date-picker').datepicker();

        //datatables
        $("#show").click(function(){
            var no_po = $("#no_po").val();
            $.ajax({
          		type	: "GET",
          		url		: "<?php echo site_url();?>henkel_adm_datatable/no_po",
          		//data	: "no_po="+no_po,
          		dataType: "json",
          		success	: function(data){
                        var table = $('#show_transaksi').DataTable({
                        "bProcessing": true,
                        "bDestroy": true,
                        "sAjaxSource": '<?php echo site_url();?>henkel_adm_datatable/no_po',
                        "bSort": false,
                        "bAutoWidth": true,
                        "iDisplayLength": 10, "aLengthMenu": [10,20,40,80], // can be removed for basic 10 items per page
                        "sPaginationType": "full_numbers",
                        "aoColumnDefs": [{"bSortable": false,
                                         "aTargets": [ -1 , 0]}], //Feature control DataTables' server-side processing mode.
                        "aoColumns": [
                          {"mData" : "no"},
                          {"mData" : "no_po"},
                          {"mData" : "id_pesanan_pembelian"},
                          {"mData" : "tanggal"},
                          {"mData" : "kode_supplier"},
                          {"mData" : "total_item"},
                          {"mData" : "total_akhir"},
                          {"mData" : "keterangan"}
                        ]
                    });
                    $('#modal-search').modal('show');
              }
          	});
        	});

          $("#nama_gudang").change(function(){
             search_nm_gudang();
          });

          $('#show_transaksi tbody').on( 'click', 'tr', function () {
              var no_po=$(this).find('td').eq(1).text();
              var id_pesanan_pembelian=$(this).find('td').eq(2).text();
              var tanggal_po=$(this).find('td').eq(3).text();
              $("#no_po").val(no_po);
              $("#id_pesanan_pembelian").val(id_pesanan_pembelian);
              $("#tanggal_po").val(tanggal_po);
              $('#modal-search').modal('hide');
          });


        $("#new").click(function(){
          var id= $("#id_hapus").val();
          if (confirm('Anda yakin? Semua yang telah diinputkan akan terhapus!')) {
            $.ajax({
              type    : 'POST',
              url     : "<?php echo site_url(); ?>henkel_adm_item_masuk/baru",
              data    : "id_new="+id,
              success : function(data){
                location.replace("<?php echo site_url(); ?>henkel_adm_item_masuk/tambah");
              }
          });
          } else {
              return false();
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
                  location.replace("<?php echo site_url(); ?>henkel_adm_item_masuk/tambah_invoice");
                }

              }
          });
      	});

        $("#simpan").click(function(){
            var jumlah_order = $("#jumlah_order").val();
            var nama_gudang = $("#nama_gudang").val();
            var tambah_stok = $("#tambah_stok").val();

            var string = $("#my-form").serialize();

            if(nama_gudang.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Nama Gudang tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#nama_gudang").focus();
                return false();
            }

            if(tambah_stok==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Tambah Stok tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#tambah_stok").focus();
                return false();
            }

            if(parseInt(tambah_stok) > parseInt(jumlah_order)){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Tambah Stok melebihi Status Order',
                    class_name: 'gritter-error'
                });

                $("#tambah_stok").focus();
                return false();
            }

            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_item_masuk/t_simpan",
                data    : string,
                cache   : false,
                start   : $("#simpan").html('...Sedang diproses...'),
                success : function(data){
                    $("#simpan").html('<i class="icon-save"></i> Simpan');
                    alert(data);
                    location.reload();
                }
            });
        });

        $("#simpan_item_masuk").click(function(){
            var id=$("#id").val();
            var no_po = $("#no_po").val();
            var no_invoice = $("#no_invoice").val();
            var tanggal_invoice = $("#tanggal_invoice").val();
            var tanggal_item_masuk = $("#tanggal_item_masuk").val();

            var string = $("#form_item_masuk").serialize();

            if(tanggal_item_masuk.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Tanggal Item Masuk tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#tanggal_item_masuk").focus();
                return false();
            }

            if(no_invoice.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'No Invoice tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#no_invoice").focus();
                return false();
            }

            if(tanggal_invoice.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Tanggal Invoice tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#tanggal_invoice").focus();
                return false();
            }

            if(no_po.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'No PO tidak boleh kosong',
                    class_name: 'gritter-error'
                });
                $("#no_po").focus();
                return false();
            }

            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_item_masuk/cek_table",
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
                        url     : "<?php echo site_url(); ?>henkel_adm_item_masuk/t_simpan",
                        data    : string,
                        cache   : false,
                        start   : $("#simpan_item_masuk").html('Sedang diproses...'),
                        success : function(data){
                          $("#simpan_item_masuk").html('<i class="icon-save"></i> Simpan');
                          var id= $("#id").val();
                          alert(data);
                          location.replace("<?php echo site_url(); ?>henkel_adm_item_masuk")
                        }
                    });
                  }
                }
            });
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

        $(window).on('beforeunload', function(){
          localStorage.setItem('tanggal_item_masuk', $('#tanggal_item_masuk').val());
          localStorage.setItem('no_invoice', $('#no_invoice').val());
          localStorage.setItem('tanggal_invoice', $('#tanggal_invoice').val());
          localStorage.setItem('jt', $('#jt').val());
        });
});

window.onload = function() {
  var id=$("#id").val();
  $.ajax({
      type    : 'POST',
      url     : "<?php echo site_url(); ?>henkel_adm_item_masuk/cek_table",
      data    : "id_cek="+id,
      success : function(data){
        if(data==0){
          $("#tanggal_item_masuk").val('');
          $("#no_invoice").val('');
          $("#tanggal_invoice").val('');
          $("#jt").val('');
        }else{
          var tanggal_item_masuk = localStorage.getItem('tanggal_item_masuk');
          var no_invoice = localStorage.getItem('no_invoice');
          var tanggal_invoice = localStorage.getItem('tanggal_invoice');
          var jt = localStorage.getItem('jt');
          $('#tanggal_item_masuk').val(tanggal_item_masuk);
          $('#no_invoice').val(no_invoice);
          $('#tanggal_invoice').val(tanggal_invoice);
          $('#jt').val(jt);
        }
    }
    });
}

function editData(ID){
    var cari  = ID;
    console.log(cari);
  $.ajax({
    type  : "GET",
    url   : "<?php echo site_url(); ?>henkel_adm_item_masuk/t_cari",
    data  : "cari="+cari,
    dataType: "json",
    success : function(data){
      $('#id_t_item_masuk').val(data.id_t_item_masuk);
      $('#kode_item').val(data.kode_item);
      $('#nama_item').val(data.nama_item);
      $('#tipe').val(data.tipe);
      $('#jumlah_order_disp').val('- '+data.jumlah_order);
      $('#jumlah_order').val(data.jumlah_order);
      $('#nama_gudang').html(data.nama_gudang);
      $('#keterangan').val(data.keterangan);
      $('#tambah_stok').val(data.tambah_stok);
    }
  });
}

function hapusData(id){
  var r = confirm("Anda yakin ingin menghapus data ini?");
  if (r == true) {
  $.ajax({
    		type	: "POST",
    		url		: "<?php echo site_url(); ?>henkel_adm_item_masuk/t_hapus/"+id,
    		data	: "id_h="+id,
    		dataType: "json",
    		success	: function(){
          location.reload();
    		}
      });
    }
}

function search_nm_gudang(){
  var kode_gudang = $("#nama_gudang").val();

  $.ajax({
    type	: "POST",
    url		: "<?php echo site_url(); ?>henkel_adm_item_masuk/search_nm_gudang",
    data	: "kode_gudang="+kode_gudang,
    dataType: "json",
    success	: function(data){
      $('#kode_gudang').val(data.kode_gudang);
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
</script>
<form class="form-horizontal" name="form_item_masuk" id="form_item_masuk" method="post">
<div class="row-fluid">
<div class="table-header">
    <?php echo 'No PO : '.$no_po;?><input type="hidden" name="no_po" id="no_po" value="<?php echo $no_po; ?>">
    <!--<div class="pull-right" style="padding-right:15px;"><?php echo 'Tanggal : '.tgl_indo($tanggal);?></div><input type="hidden" name="tanggal" id="tanggal" value="<?php echo tgl_indo($tanggal)?>">-->
    <input type="hidden" id="id" name="id" value="<?php echo $id_item_masuk?>">
    <input type="hidden" id="id_hapus" name="id_hapus" value="<?php echo $id_pes_pem?>">
</div>
</br>
<?php
error_reporting(E_ALL ^ E_NOTICE);
?>
   <div class="row-fluid">
        <div class="span6">
                <div class="control-group">
                   <label class="control-label" for="form-field-1">Tanggal Item Masuk</label>
                   <div class="controls">
                        <input type="text" class="date-picker" data-date-format="dd-mm-yyyy" name="tanggal_item_masuk" id="tanggal_item_masuk" placeholder="Tanggal Item Masuk" />
                    </div>
                    <div class="space"></div>
                    <label class="control-label" for="form-field-1">No Invoice</label>
                    <div class="controls">
                        <input type="text" name="no_invoice" id="no_invoice" placeholder="No Invoice" />
                    </div>
                    <div class="space"></div>
                    <label class="control-label" for="form-field-1">Tanggal Invoice</label>
                    <div class="controls">
                        <input type="text" name="tanggal_invoice" id="tanggal_invoice" class="date-picker" data-date-format="dd-mm-yyyy" placeholder="Tanggal Invoice" />
                    </div>
                    <div class="space"></div>
                    <label class="control-label" for="form-field-1">Jatuh Tempo</label>
                    <div class="controls">
                      <input type="number" class="span3" value="<?php echo $jt;?>" min="0" name="jt" id="jt" onkeydown="return justAngka(event)" placeholder="JT" /> <span style="font-weight:bold"> Hari</span> <br />
                      <input type="text" value="" name="jt_hari" id="jt_hari" placeholder="" readonly/>
                    </div>
               </div>
         </div>
    </div>

<div class="table-header">
 Tabel Item Pembelian Item
 <div class="widget-toolbar no-border pull-right">
 </div>
</div>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Kode Item</th>
            <th class="center">Nama Item</th>
            <th class="center">Tipe</th>
            <th class="center">Status Order</th>
            <th class="center">Kode Gudang</th>
            <th class="center">Nama Gudang</th>
            <th class="center">Keterangan</th>
            <th class="center">Tambah Stok</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=1;
        foreach($data->result() as $dt){
          $harga_item= $dt->harga_tebus_dpp;
          $jumlah= $dt->total_item_item_masuk;
          $diskon= $dt->diskon;
          $harga = $harga_item * $jumlah;
          $persen = ($harga * $diskon)/100;
          $total = $harga-$persen;
          $total_transaksi += $total;
        ?>

        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->kode_item;?></td>
            <td class="center"><?php echo $dt->nama_item;?></td>
            <td class="center"><?php echo $dt->tipe;?></td>
            <?php if ($dt->jumlah_o==0) {?>
            <td class="center"><?php echo $dt->jumlah_o;?></td>
            <?php } else { ?>
            <td class="center"><?php echo '- '.$dt->jumlah_o;?></td>
            <?php } ?>
            <?php if($dt->kode_gudang==''){ ?>
            <td class="center"><?php echo "<span class='label label-danger'>Belum Ada Data</span>";?></td>
            <?php } else { ?>
            <td class="center"><?php echo $dt->kode_gudang;?></td>
            <?php } ?>
            <?php if($dt->nama_gudang==''){ ?>
            <td class="center"><?php echo "<span class='label label-danger'>Belum Ada Data</span>";?></td>
            <?php } else { ?>
            <td class="center"><?php echo $dt->nama_gudang;?></td>
            <?php } ?>
            <td class="center"><?php echo $dt->keterangan;?></td>
            <?php if($dt->total_item_item_masuk==0){ ?>
            <td class="center"><?php echo "<span class='label label-danger'>Belum Ada Data</span>";?></td>
            <?php } else { ?>
            <td class="center"><?php echo $dt->total_item_item_masuk;?></td>
            <?php } ?>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_t_item_masuk;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <!--<a class="red" href="#" onclick="javascript:hapusData('<?php echo $dt->id_t_item_masuk;?>')">
                        <i class="icon-trash bigger-130"></i>
                    </a>-->
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
<div class="span4">
  <div class="control-group">
      <div class="controls total_harga">
        <input type="hidden" value="<?php echo $total_transaksi;?>" name="total_akhir" id="total_akhir" placeholder="" readonly/>
      </div>
   </div>
</div>
</form>

<div class="row-fluid">
     <div class="span12" align="center">
          <a href="<?php echo base_url();?>henkel_adm_item_masuk" class="btn btn-small btn-danger">
             <i class="icon-remove"></i>
             Batal
          </a>
          <!--<button type="submit" name="new" id="new" class="btn btn-small btn-success">
            <i class="icon-print"></i>
              Transaksi Baru
          </button>-->
          <button type="button" name="simpan_item_masuk" id="simpan_item_masuk" class="btn btn-small btn-warning">
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
            <input type="hidden" name="id_t_item_masuk" id="id_t_item_masuk">
            <input type="hidden" name="id_item_masuk" id="id_item_masuk" value="<?php echo $id_item_masuk?>">
            <input type="hidden" id="id_pes_pem" name="id_pes_pem" value="<?php echo $id_pes_pem?>">
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
                        <input type="text" name="nama_item" id="nama_item" placeholder="Nama Item" readonly="readonly"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Tipe</label>

                    <div class="controls">
                        <input type="text" name="tipe" id="tipe" placeholder="Tipe" readonly="readonly"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Jumlah Order</label>

                    <div class="controls">
                        <input type="text" name="jumlah_order_disp" id="jumlah_order_disp" placeholder="Jumlah Order" readonly="readonly"/>
                        <input type="hidden" name="jumlah_order" id="jumlah_order" placeholder="Jumlah Order" readonly="readonly"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Gudang</label>
                    <div class="controls">
                      <?php ?>
                      <select name="nama_gudang" id="nama_gudang">
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
                       <input type="hidden" name="kode_gudang" id="kode_gudang" placeholder="Kode Gudang" readonly="readonly"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Keterangan</label>

                    <div class="controls">
                        <input type="text" name="keterangan" id="keterangan" placeholder="Keterangan" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Tambah Stok</label>

                    <div class="controls">
                        <input type="text" value="0" onkeydown="return justAngka(event)" min="0" name="tambah_stok" id="tambah_stok" placeholder="Tambah Stok" />
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

<div id="modal-search" class="modal hide fade" style="min-width:80%;max-height:80%;left:30%;" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Cari No. Po
        </div>
    </div>

    <div class="no-padding">
        <div class="row-fluid">
          <table class="table lcnp table-striped table-bordered table-hover" style="width: 1500px;" id="show_transaksi">
              <thead>
                  <tr>
                      <th class="center">No</th>
                      <th class="center">No PO</th>
                      <th class="center">Id Pesanan Pembelian</th>
                      <th class="center">Tanggal PO</th>
                      <th class="center">Kode Supplier</th>
                      <th class="center">Total Item</th>
                      <th class="center">Total Akhir</th>
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
