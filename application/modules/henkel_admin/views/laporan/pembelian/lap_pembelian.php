<script type="text/javascript">
$(document).ready(function(){

  $('.date-picker').datepicker({
    format: 'yyyy-mm-dd'
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
        $("#kode_supplier").val(kode_supplier);
        $("#nama_supplier").val(nama_supplier);
        $('#modal-supplier').modal('hide');
    });

	$("#view").click(function(){
    var tgl_awal = $("#tgl_awal").val();
    var tgl_akhir = $("#tgl_akhir").val();
    var nama_supplier = $("#nama_supplier").val();

    if(tgl_awal.length==0 && tgl_akhir.length==0 && nama_supplier.length==0){
				$.gritter.add({
						title: 'Peringatan..!!',
						text: 'Silakan isi Tanggal Awal & Tanggal Akhir / Nama Supplier',
						class_name: 'gritter-error'
				});
				return false();
		}

    if(tgl_awal.length>0 && tgl_akhir.length==0){
				$.gritter.add({
						title: 'Peringatan..!!',
						text: 'Tanggal Akhir tidak boleh kosong',
						class_name: 'gritter-error'
				});

        $("#tgl_akhir").focus();
				return false();
		}

    if(tgl_awal.length==0 && tgl_akhir.length>0){
				$.gritter.add({
						title: 'Peringatan..!!',
						text: 'Tanggal Awal tidak boleh kosong',
						class_name: 'gritter-error'
				});

        $("#tgl_awal").focus();
				return false();
		}
		cari_data();
	});

  $("#cetak_pdf").click(function(){
    var tgl_awal = $("#tgl_awal").val();
    var tgl_akhir = $("#tgl_akhir").val();
    var nama_supplier = $("#nama_supplier").val();

    if(tgl_awal.length==0 && tgl_akhir.length==0 && nama_supplier.length==0){
				$.gritter.add({
						title: 'Peringatan..!!',
						text: 'Silakan isi Tanggal Awal & Tanggal Akhir / Nama Supplier',
						class_name: 'gritter-error'
				});
				return false();
		}

    if(tgl_awal.length>0 && tgl_akhir.length==0){
				$.gritter.add({
						title: 'Peringatan..!!',
						text: 'Tanggal Akhir tidak boleh kosong',
						class_name: 'gritter-error'
				});

        $("#tgl_akhir").focus();
				return false();
		}

    if(tgl_awal.length==0 && tgl_akhir.length>0){
				$.gritter.add({
						title: 'Peringatan..!!',
						text: 'Tanggal Awal tidak boleh kosong',
						class_name: 'gritter-error'
				});

        $("#tgl_awal").focus();
				return false();
		}
    cari_data();
	});

  $("#cetak_excel").click(function(){
    var tgl_awal = $("#tgl_awal").val();
    var tgl_akhir = $("#tgl_akhir").val();
    var nama_supplier = $("#nama_supplier").val();

    if(tgl_awal.length==0 && tgl_akhir.length==0 && nama_supplier.length==0){
				$.gritter.add({
						title: 'Peringatan..!!',
						text: 'Silakan isi Tanggal Awal & Tanggal Akhir / Nama Supplier',
						class_name: 'gritter-error'
				});
				return false();
		}

    if(tgl_awal.length>0 && tgl_akhir.length==0){
				$.gritter.add({
						title: 'Peringatan..!!',
						text: 'Tanggal Akhir tidak boleh kosong',
						class_name: 'gritter-error'
				});

        $("#tgl_akhir").focus();
				return false();
		}

    if(tgl_awal.length==0 && tgl_akhir.length>0){
				$.gritter.add({
						title: 'Peringatan..!!',
						text: 'Tanggal Awal tidak boleh kosong',
						class_name: 'gritter-error'
				});

        $("#tgl_awal").focus();
				return false();
		}
	});

});

function cari_data(){
  var tgl_awal = $("#tgl_awal").val();
  var tgl_akhir = $("#tgl_akhir").val();
  var kode_supplier = $("#kode_supplier").val();
  $.ajax({
    type	: 'POST',
    url		: "<?php echo site_url(); ?>henkel_adm_lap_pembelian/cari_data",
    data	: "tgl_awal="+tgl_awal+"&tgl_akhir="+tgl_akhir+"&kode_supplier="+kode_supplier,
    cache	: false,
    success	: function(data){
      $("#view_detail").html(data);
    }
  });
}

function cetak_data(data){
		var form = document.getElementById('my-form');
		form.action = data;
		form.submit();
}
</script>

<div class="widget-box ">
    <div class="widget-header">
        <h4 class="lighter smaller">
            <i class="icon-book blue"></i>
            <?php echo $judul;?>
        </h4>
    </div>

    <div class="widget-body">
    	<div class="widget-main">
            <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
              <div class="control-group">
                  <label class="control-label" for="form-field-1">Periode</label>
                   <div class="controls">
                      <div class="input-append">
                        <input type="text" name="tgl_awal" id="tgl_awal" class="date-picker"  data-date-format="dd-mm-yyyy" />
                            <span class="add-on">
                              <i class="icon-calendar"></i>
                            </span>
                      </div>
                      <b> s/d </b>
                      <div class="input-append">
                        <input type="text" name="tgl_akhir" id="tgl_akhir" class="date-picker" data-date-format="dd-mm-yyyy" />
                          <span class="add-on">
                            <i class="icon-calendar"></i>
                          </span>
                      </div>
                </div>
              </div>
              <div class="control-group">
                  <label class="control-label" for="form-field-1">Supplier</label>
                  <div class="controls">
                      <div class="input-append">
                        <input type="text" name="nama_supplier" id="nama_supplier" readonly/>
                        <input type="hidden" name="kode_supplier" id="kode_supplier" readonly/>
                            <span class="add-on">
                              <i class="icon-user"></i>
                            </span>
                        </div>
                      <button type="button" name="cari_kode_supplier" id="cari_kode_supplier" class="btn btn-small btn-info">
                        <i class="icon-search"></i>
                            Cari
                      </button>
                  </div>
              </div>
            <br />
            <div class="alert alert-success">
              <center>
                <button type="button" name="view" id="view" class="btn btn-mini btn-primary">
                	 <i class="icon-th"></i> Lihat Data
                </button>
                <button type="button" name="cetak_pdf" id="cetak_pdf" class="btn btn-mini btn-danger" onclick="cetak_data('<?php echo site_url();?>henkel_adm_lap_pembelian/cetak_pdf_pembelian')">
                	 <i class="fa fa-file-pdf-o"></i> Cetak PDF
                </button>
  							<button type="button" name="cetak_excel" id="cetak_excel" class="btn btn-mini btn-success" onclick="cetak_data('<?php echo site_url();?>henkel_adm_lap_pembelian/cetak_excel_pembelian')">
                	 <i class="fa fa-file-excel-o"></i> Cetak Excel
                </button>
             </center>
           </div>
           </form>
           </div>
           <?php
		  	echo  $this->session->flashdata('result_info');
		   ?>
        </div> <!-- wg body -->
    </div> <!--wg-main-->
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
<div id="view_detail"></div>
