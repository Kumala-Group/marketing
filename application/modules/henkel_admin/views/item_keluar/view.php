<script type="text/javascript">
$(document).ready(function(){
        $("body").on("click", ".delete", function (e) {
            $(this).parent("div").remove();
        });

        //datatables
        $("#cari_kode_item").click(function(){
            var kode_gudang= $("#kode_gudang").val();
            $.ajax({
          		type	: "GET",
          		url		: "<?php echo site_url();?>henkel_adm_datatable/kode_item",
          		data	: "kode_gudang="+kode_gudang,
          		dataType: "json",
          		success	: function(data){
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
              var data_kode=$(this).find('td').eq(1).text();
              var data_stok=$(this).find('td').eq(6).text();
              $("#kode_item").val(data_kode);
              search_nm_item();
              $("#stok").val(data_stok);
              $('#modal-item').modal('hide');
          } );

        var date = new Date();
        date.setDate(date.getDate()-1);
        $('.date-picker').datepicker({
          startDate: date
        });

        $("#kode_gudang").change(function(){
           $("#nama_item").val('');
           $("#tipe").val('');
           search_kd_item();
        });

        $("#jumlah").keyup(function(){
          //call function diskon
          var harga_satuan = $('#harga_satuan').val();
          var jumlah = $('#jumlah').val();
          $('#harga').val(f_jumlah(harga_satuan,jumlah));
          //call function diskon
          var harga = $("#harga").val();
          var diskon = $("#diskon").val();
          $('#total').val(f_diskon(harga,diskon));
        });

        $("#diskon").keyup(function(){
          var harga = $("#harga").val();
          var diskon = $("#diskon").val();
          $('#total').val(f_diskon(harga,diskon));
        });

        $("#diskon_all").keyup(function(){
          var harga = $("#total_transaksi").val();
          var clean = harga.replace(/\D/g,'');
          var persen = $("#diskon_all").val();
          var diskon = (clean * persen)/100;
          var total = clean - diskon;
          var bilangan = separator_harga2(total);
          $('#total_akhir').val(bilangan);
        });

        $("#simpan").click(function(){
            var tanggal_item_keluar = $("#tanggal_item_keluar").val();
            var kode_item = $("#kode_item").val();
            var stok = $("#stok").val();
            var jumlah = $("#jumlah").val();
            var satuan = $("#kode_satuan").val();
            var keterangan = $("#keterangan").val();

            var string = $("#my-form").serialize();

            if(tanggal_item_keluar.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Tanggal Item Keluar tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#tanggal_item_keluar").focus();
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

            if(jumlah>stok){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Jumlah melebihi stok item',
                    class_name: 'gritter-error'
                });

                $("#jumlah").focus();
                return false();
            }

            if(jumlah<=0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Jumlah tidak boleh 0 / kosong',
                    class_name: 'gritter-error'
                });

                $("#jumlah").focus();
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
                url     : "<?php echo site_url(); ?>henkel_adm_item_keluar/simpan",
                data    : string,
                cache   : false,
                success : function(data){
                    alert(data);
                    location.reload();
                }
            });
        });


        $("#tambah").click(function(){
          var today = new Date();
          var yyyy = today.getFullYear();
          var mm = today.getMonth()+1;
          if(mm<10) {
            mm = '0'+mm
          }
          var dd = today.getDate();
          if(dd<10) {
            dd = '0'+dd
          }
          $("#id_item_keluar").val('');
          $('#kode_item_keluar').val('<?php echo $kode_item_keluar?>');
          $("#kode_gudang").val('');
          $("#kode_item").val('');
          $("#nama_item").val('');
          $("#tipe").val('');
          $("#stok").val('0');
          $("#jumlah").val('0');
          $("#kode_satuan").val('');
          $("#tanggal_item_keluar").val('');
          $("#tanggal_input").val(dd+'-'+mm+'-'+yyyy);
          $("#keterangan").val('');
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
      $('#id_item_masuk').val(data.id_item_masuk);
      $('#kode_item_keluar').val(data.kode_item_keluar);
      $('#no_po').val(data.no_po);
      $('#tanggal_po').val(data.tanggal);
      $('#kode_item').html(data.kode_item);
      $('#nama_item').val(data.nama_item);
      $('#tipe').val(data.tipe);
      $('#total_item').val(data.total_item);
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
  var bilangan = separator_harga2(total);
  return bilangan;
}

function separator_harga2(ID){
  var bilangan  = ID;
  var reverse = bilangan.toString().split('').reverse().join(''),
  ribuan  = reverse.match(/\d{1,3}/g);id_item_masuk
  ribuan  = ribuan.join('.').split('').reverse().join('');
  return ribuan;
}

function hapusData(id){
  var r = confirm("Anda yakin ingin menghapus data ini?");
  if (r == true) {
  $.ajax({
    		type	: "POST",
    		url		: "<?php echo site_url(); ?>henkel_adm_item_keluar/hapus/"+id,
    		data	: "id_h="+id,
    		dataType: "json",
    		success	: function(){
          location.reload();
    		}
      });
    }
}

function search_nm_item(){
  var kode_item = $("#kode_item").val();

  $.ajax({
    type	: "POST",
    url		: "<?php echo site_url(); ?>henkel_adm_item_masuk/search_nm_item",
    data	: "kode_item="+kode_item,
    dataType: "json",
    success	: function(data){
      $('#nama_item').val(data.nama_item);
      $('#tipe').val(data.tipe);
    }
  });
}

function beritaAcara(ID){
    var cari  = ID;
    console.log(cari);
  $.ajax({
    type  : "GET",
    url   : "<?php echo site_url(); ?>henkel_adm_item_keluar/cari_berita_acara",
    data  : "cari="+cari,
    dataType: "json",
    success : function(data){
       window.open("<?php echo site_url(); ?>henkel_adm_item_keluar/berita_acara?id_item_keluar="+btoa(data.id_item_keluar)+"&kode_item_keluar="+btoa(data.kode_item_keluar)+"&kode_gudang="+btoa(data.kode_gudang)+"&kode_item="+btoa(data.kode_item)+"&nama_item="+data.nama_item+"&jumlah="+data.jumlah+"&satuan="+data.satuan+"&tanggal_item_keluar="+btoa(data.tanggal_item_keluar)+"&tanggal_input="+data.tanggal_input+"&keterangan="+data.keterangan);
    }
  });
}
</script>
<form class="form-horizontal" name="form_pembelian" id="form_pembelian">
<div class="row-fluid">
</br>
<?php
error_reporting(E_ALL ^ E_NOTICE);
?>
<div class="table-header">
 Tabel Item Keluar
 <div class="widget-toolbar no-border pull-right">
   <a href="#modal-table" data-toggle="modal" name="tambah" id="tambah" class="btn btn-small btn-success">
       <i class="icon-plus"></i>
       Tambah Item
   </a>
 </div>
</div>
<table class="table fpTable lcnp table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">No</th>
            <th class="center">Tanggal Item Keluar</th>
            <th class="center">Kode Gudang</th>
            <th class="center">Nama Gudang</th>
            <th class="center">Kode Item</th>
            <th class="center">Nama item</th>
            <th class="center">Tipe</th>
            <th class="center">Jumlah</th>
            <th class="center">Satuan</th>
            <th class="center">Keterangan</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=1;
        $total_transaksi=0;
        $jml = 0;
        foreach($data->result() as $dt){ ?>
        <tr>
          <?php
            $harga_item= $dt->harga_item;
            $jumlah= $dt->jumlah;
            $diskon= $dt->diskon;
            $harga = $harga_item * $jumlah;
            $persen = ($harga * $diskon)/100;
            $total = $harga-$persen;
            $total_transaksi += $total;
            $jml += $jumlah;
          ?>
            <td class="center span1"><?php echo $i++?></td>
            <td class="center"><?php echo tgl_sql($dt->tanggal_item_keluar);?></td>
            <td class="center"><?php echo $dt->kode_gudang;?></td>
            <td class="center"><?php echo $dt->nama_gudang;?></td>
            <td class="center"><?php echo $dt->kode_item;?></td>
            <td class="center"><?php echo $dt->nama_item;?></td>
            <td class="center"><?php echo $dt->tipe;?></td>
            <td class="center"><?php echo $dt->jumlah;?></td>
            <td class="center"><?php echo $dt->kode_satuan;?></td>
            <td class="center"><?php echo $dt->keterangan;?></td>
            <td class="td-actions"><center>
                <div class="hidden-phone visible-desktop action-buttons">
                    <!--<a class="green" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_item_masuk;?>')" data-toggle="modal">
                        <i class="icon-pencil bigger-130"></i>
                    </a>

                    <a class="red" href="#" onclick="javascript:hapusData('<?php echo $dt->id_item_keluar;?>')">
                        <i class="icon-trash bigger-130"></i>
                    </a>-->

                    <a href="#" onclick="javascript:beritaAcara('<?php echo $dt->id_item_keluar;?>')">
                      <i class="icon-print" data-toggle="tooltip" data-placement="top" title="Print"></i>
                    </a>

                    <!--<button type="button" name="beritaAcara" id="beritaAcara" class="btn btn-small btn-primary">-->
                    <!--<i class="icon-print"></i> Berita Acara-->
                    <!--</button>-->
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
</form>

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
            <input type="hidden" name="id_item_keluar" id="id_item_keluar">
            <input type="hidden" name="kode_item_keluar" id="kode_item_keluar">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Tanggal Item Keluar</label>
                    <div class="controls">
                      <div class="input-append">
                        <input type="text" name="tanggal_item_keluar" id="tanggal_item_keluar" class="date-picker"  data-date-format="dd-mm-yyyy" placeholder="Tanggal Item Keluar"/>
                      </div>
                    </div>
                </div>
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
                    <label class="control-label" for="form-field-1">Stok</label>
                    <div class="controls">
                        <input type="text" name="stok" id="stok" placeholder="0" readonly="readonly"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Jumlah</label>

                    <div class="controls">
                        <input type="text" value="0" onkeydown="return justAngka(event)" min="0" name="jumlah" id="jumlah" placeholder="Jumlah" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Satuan</label>
                    <div class="controls">
                      <?php ?>
                      <select name="kode_satuan" id="kode_satuan">
                        <option value="" selected="selected">--Pilih Satuan--</option>
                        <?php
                          $data = $this->db_kpp->get('satuan');
                          foreach($data->result() as $dt){
                        ?>
                         <option value="<?php echo $dt->kode_satuan;?>"><?php echo $dt->satuan;?></option>
                        <?php
                          }
                        ?>
                       </select>
                    </div>
                </div>

                <input type="hidden" name="tanggal_input" id="tanggal_input" placeholder="Tanggal Input" readonly="readonly" />

                <div class="control-group">
                   <label class="control-label" for="form-field-1">Keterangan</label>
                   <div class="controls total_harga">
                     <?php echo '<textarea name="keterangan" id="keterangan" style="resize: none;" rows="5" placeholder="Keterangan">'.$keterangan.'</textarea>'; ?>
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
