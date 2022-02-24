<script type="text/javascript">
$(document).ready(function(){
        $("body").on("click", ".delete", function (e) {
            $(this).parent("div").remove();
        });

        $("#simpan").click(function(){
            var no_invoice = $("#no_invoice").val();
            var tanggal_invoice = $("#tanggal_invoice").val();
            var jumlah_order = $("#jumlah_order").val();
            var nama_gudang = $("#nama_gudang").val();
            var tambah_stok = $("#tambah_stok").val();

            var string = $("#my-form").serialize();

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

            if(tambah_stok>jumlah_order){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Tambah Stok melebihi Jumlah Order',
                    class_name: 'gritter-error'
                });

                $("#tambah_stok").focus();
                return false();
            }

            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_item_masuk/simpan",
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
          var string = $("#form_item_masuk").serialize();
          $.ajax({
                  type    : 'POST',
                  url     : "<?php echo site_url(); ?>henkel_adm_item_masuk/simpan_edit",
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

        });

        $(window).on('beforeunload', function(){
          localStorage.setItem('no_po', $('#no_po').val());
          localStorage.setItem('id_pesanan_pembelian', $('#id_pesanan_pembelian').val());
        });
});

function editData(ID){
    var cari  = ID;
    console.log(cari);
  $.ajax({
    type  : "GET",
    url   : "<?php echo site_url(); ?>henkel_adm_item_masuk/cari",
    data  : "cari="+cari,
    dataType: "json",
    success : function(data){
      $('#id_item_masuk_detail').val(data.id_item_masuk_detail);
      $('#id_item_masuk').val(data.id_item_masuk);
      $('#id_pes_pem').val(data.id_pesanan_pembelian);
      $('#kode_item').val(data.kode_item);
      $('#nama_item').val(data.nama_item);
      $('#tipe').val(data.tipe);
      //$('#jumlah_order').val(data.jumlah_order);
      $('#nama_gudang').html(data.nama_gudang);
      $('#keterangan').val(data.keterangan);
      $('#tambah_stok').val(data.total_item_item_masuk);
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

function kembali() {
  location.replace("<?php echo site_url(); ?>henkel_adm_item_masuk");
}

</script>
<form class="form-horizontal" name="form_item_masuk" id="form_item_masuk" method="post">
<div class="row-fluid">
<div class="table-header">
    <?php echo 'Tanggal : '.tgl_indo($tanggal);?><input type="hidden" name="tanggal" id="tanggal" value="<?php echo tgl_indo($tanggal)?>">
    <input type="hidden" id="id" name="id" value="<?php echo $id_item_masuk?>">
</div>
</br>
<?php
error_reporting(E_ALL ^ E_NOTICE);
?>
<div class="row-fluid">
     <div class="span6">
             <div class="control-group">
                 <label class="control-label" for="form-field-1">No PO</label>
                 <div class="controls">
                     <input type="text" name="no_po" id="no_po" value="<?php echo $no_po;?>" placeholder="No PO" readonly/>
                 </div>
            </div>
            <div class="control-group">
                 <label class="control-label" for="form-field-1">Tanggal PO</label>
                 <div class="controls">
                     <input type="text" name="tanggal_po" id="tanggal_po" placeholder="Tanggal PO" value="<?php echo $tanggal_po;?>" readonly/>
                 </div>
             </div>
      </div>
      <div class="span6">
            <div class="control-group">
                <label class="control-label" for="form-field-1">No Invoice</label>
                <div class="controls">
                    <input type="text" name="no_invoice" id="no_invoice" placeholder="No Invoice" value="<?php echo $no_invoice;?>" readonly/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-1">Tanggal Invoice</label>
                <div class="controls">
                    <input type="text" name="tanggal_invoice" id="tanggal_invoice" placeholder="Tanggal Invoice" value="<?php echo $tanggal_invoice;?>" readonly/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-1">Jatuh Tempo</label>
                <div class="controls">
                    <input type="text" name="jt" id="jt" placeholder="Jatuh Tempo" value="<?php echo $jt;?>" readonly/>
                </div>
            </div>
       </div>
 </div>
<div class="space"></div>
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
            <!--<th class="center">Jumlah Order</th>-->
            <th class="center">Kode Gudang</th>
            <th class="center">Nama Gudang</th>
            <th class="center">Keterangan</th>
            <th class="center">Tambah Stok</th>
            <!--<th class="center">Aksi</th>-->
        </tr>
    </thead>
    <tbody>
        <?php
        $i=1;
        foreach($data->result() as $dt){ ?>
        <tr>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo $dt->kode_item;?></td>
            <td class="center"><?php echo $dt->nama_item;?></td>
            <td class="center"><?php echo $dt->tipe;?></td>
            <!--<td class="center"><?php echo $dt->jumlah_order;?></td>-->
            <td class="center"><?php echo $dt->kode_gudang;?></td>
            <td class="center"><?php echo $dt->nama_gudang;?></td>
            <td class="center"><?php echo $dt->keterangan;?></td>
            <td class="center"><?php echo $dt->total_item_item_masuk;?></td>
            <!--<td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_item_masuk_detail;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a class="red" href="#" onclick="javascript:hapusData('<?php echo $dt->id_item_masuk_detail;?>')">
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
</form>

<div class="row-fluid">
       <div class="span12" align="center">
            <!--<a href="<?php echo base_url();?>henkel_adm_item_masuk" class="btn btn-small btn-danger">
               <i class="icon-remove"></i>
               Cancel
            </a>
            <button type="submit" name="new" id="new" class="btn btn-small btn-success">
              <i class="icon-print"></i>
                Transaksi Baru
            </button>
            <button type="button" name="simpan_item_masuk" id="simpan_item_masuk" class="btn btn-small btn-warning">
                <i class="icon-save"></i>
                Simpan
            </button>-->
            <button type="button" onclick="kembali()" class="btn btn-small btn-success">
              <i class="fa fa-sign-out" aria-hidden="true"></i>
                Kembali
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
            <input type="hidden" name="id_item_masuk_detail" id="id_item_masuk_detail">
            <input type="hidden" name="id_item_masuk" id="id_item_masuk">
            <input type="hidden" id="id_pes_pem" name="id_pes_pem">
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
                       <input type="hidden" name="kode_gudang" id="kode_gudang" value="<?php echo $dt->kode_gudang;?>" placeholder="Kode Gudang" readonly="readonly"/>
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

<div id="modal-search" class="modal hide fade" style="width:80%;max-height:80%;left:30%;" tabindex="-1" data-backdrop="static" data-keyboard="false">
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
                      <th class="center" style="display: none;">Id Pesanan Pembelian</th>
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
