<script type="text/javascript">
    $(document).ready(function(){
      	$('.date-picker').datepicker().next().on(ace.click_event, function(){
      		$(this).prev().focus();
      	});
        $("body").on("click", ".delete", function (e) {
            $(this).parent("div").remove();
        });
        table_detail();

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

        $("#simpan").click(function(){
            var no_invoice = $("#no_invoice").val();
            var tgl_inv = $("#tgl_inv").val();
            var akun = $("#akun").val();
            var total = $("#total").val();

            var string = $("#my-form").serializeArray();

            if(no_invoice.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'No. Invoice tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#no_invoice").focus();
                return false();
            }

            if(tgl_inv.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Tgl. Invoice tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#tgl_inv").focus();
                return false();
            }

            if(akun.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Akun tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#akun").focus();
                return false();
            }

            if(total.length==0 || (parseInt(total)<=0)){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Total tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#total").focus();
                return false();
            }
                $.ajax({
                    type    : 'POST',
                    url     : "<?php echo site_url(); ?>henkel_adm_saldo_awal_hutang/t_simpan_detail",
                    data    : string,
                    cache   : false,
                    start   : $("#simpan").html('Sedang diproses...'),
                    success : function(data){
                        $("#simpan").html('<i class="icon-save"></i> Simpan');
                        table_detail();
                        $('#modal-table').modal('hide');

                    }
                });
    });

        $("#simpan_saldo_awal").click(function(){
            var kode_supplier = $("#kode_supplier").val();
            var count = $("#count").val();

            var string = $("#form_sa").serialize();

            if(kode_supplier.length==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Kode Supplier tidak boleh kosong',
                    class_name: 'gritter-error'
                });
                $("#kode_supplier").focus();
                return false();
            }

            if(count==0){
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Tidak ada Invoice yang bisa diSimpan',
                    class_name: 'gritter-error'
                });
                return false();
            }

            $.ajax({
                type    : 'POST',
                url     : "<?php echo site_url(); ?>henkel_adm_saldo_awal_hutang/t_simpan",
                data    : string,
                cache   : false,
                start   : $("#simpan_saldo_awal").html('Sedang diproses...'),
                success : function(data){
                  $("#simpan_saldo_awal").html('<i class="icon-save"></i> Simpan');
                  var id= $("#id").val();
                  alert(data);
                  location.replace("<?php echo site_url(); ?>henkel_adm_saldo_awal_hutang/edit/"+id)
                }
            });
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
          $('#load-modal').hide();
          $("#id_t").val('');
          $("#no_invoice").val('');
          $("#tgl_inv").val('');
          $("#jt").val('');
          $("#akun").val('');
          $("#total").val('0');
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


function editData(ID){
	var cari	= ID;
    console.log(cari);
	$.ajax({
		type	: "GET",
		url		: "<?php echo site_url(); ?>henkel_adm_saldo_awal_hutang/t_cari",
		data	: "cari="+cari,
		dataType: "json",
		beforeSend : function(){
			$('#load-modal').show();
			$('.modal-body').hide();
		},
		success	: function(data){
			$('#load-modal').hide();
			$('.modal-body').show();
      $('#id_t').val(data.id_t);
			$('#no_invoice').val(data.no_invoice);
			$('#tgl_inv').val(data.tgl_inv);
      $('#akun').val(data.akun);
			$('#jt').val(data.jt);
			$('#total').val(data.total);
		}
	});
}

function table_detail(){
	$.ajax({
		type	: "GET",
		url		: "<?php echo site_url(); ?>henkel_adm_saldo_awal_hutang/t_detail",
		data	: "user=<? echo $this->session->userdata('username');?>",
		dataType: "json",
		success	: function(data){
      $('#table_detail').html(data.table);
      $('#count').val(data.count);
		}
	});
}

function hapusData(id){
  $.ajax({
		type	: "POST",
		url		: "<?php echo site_url(); ?>henkel_adm_saldo_awal_hutang/t_hapus/"+id,
		data	: "id_h="+id,
		dataType: "json",
		success	: function(){
			table_detail();
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
<form class="form-horizontal" name="form_sa" id="form_sa" method="post">
<div class="row-fluid">
<div class="table-header">
    <?php echo 'Tanggal : '.tgl_indo($tanggal);?><input type="hidden" name="tanggal" id="tanggal" value="<?php echo $tanggal;?>">
    <input type="hidden" value="" name="id" id="id">
</div>
</br>
<?php
//error_reporting(E_ALL ^ E_NOTICE);
?>
   <div class="row-fluid">
        <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kode Supplier</label>
                    <div class="controls">
                        <input type="text" class="autocomplete" name="kode_supplier" id="kode_supplier" value="<?php echo $kode_supplier;?>" placeholder="Kode Supplier" readonly="readonly" />
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
                         <?php echo '<textarea name="alamat" id="alamat" readonly="readonly" style="background-color: #F5F5F5; resize: none;" rows="3" placeholder="Alamat">'.$alamat.'</textarea>'; ?>
                     </div>
                 </div>
          </div>
    </div>

<div class="table-header">
 Tabel Invoice
 <div class="widget-toolbar no-border pull-right">
   <a href="#modal-table" data-toggle="modal" name="tambah" id="tambah" class="btn btn-small btn-success">
       <i class="icon-plus"></i>
       Tambah Item
   </a>
 </div>
</div>
<table class="table table-striped table-bordered table-hover" >
    <thead>
        <tr>
            <th class="center">No. Invoice</th>
            <th class="center">Tgl. Inv</th>
            <th class="center">Tgl. JT</th>
            <th class="center">Akun</th>
            <th class="center">Total</th>
            <th class="center">Aksi</th>
        </tr>
    </thead>
    <tbody id="table_detail">
    </tbody>
</table>
</br>
   <div class="row-fluid">
       <input type="hidden" name="count" id="count"  />
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
          <button type="button" name="simpan_saldo_awal" id="simpan_saldo_awal" class="btn btn-small btn-warning">
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
    <div class="center" style="margin-top:10px;" id='load-modal'>
						<h4>... Load Data ...</h4>
		</div>
    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
            <input type="hidden" name="id_t" id="id_t">
            <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">No. Invoice</label>

                    <div class="controls">
                        <input type="text" name="no_invoice" id="no_invoice" placeholder="No. Invoice" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Tgl. Inv</label>
                    <div class="controls">
            					<div class="input-append">
            									<input type="text" name="tgl_inv" id="tgl_inv" class="span6 date-picker"  data-date-format="dd-mm-yyyy" />
            							<span class="add-on">
            									<i class="icon-calendar"></i>
            							</span>
            						</div>
            				</div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">JT</label>
                    <div class="controls">
                        <input type="number" min="0" maxlength="2" name="jt" id="jt" placeholder="0" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Akun</label>

                    <div class="controls">
                      <select name="akun" id="akun">
                        <option value="" selected="selected">--Pilih Kode Akun--</option>
                        <?php
                          $akun = $this->db_kpp->query("SELECT kode_akun,nama_akun FROM akun ");
                          foreach($akun->result() as $dt){
                        ?>
                         <option value="<?php echo $dt->kode_akun;?>"><?php echo $dt->nama_akun;?></option>
                        <?php
                          }
                        ?>
                       </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Total</label>

                    <div class="controls">
                        <input type="number"  min="0" name="total" id="total" placeholder="Total" />
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
