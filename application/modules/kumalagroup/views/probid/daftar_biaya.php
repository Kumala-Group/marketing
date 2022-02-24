<style>
    .table1,
    td {
        padding: 5px 10px;
        /* text-align: center; */
    }

    .modal-lg {
        max-width: 65% !important;
    }
</style>
<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Daftar Biaya</h5>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block pt-1">
                        <form name="form" id="form" class="form-horizontal" action="">
                            <div class="form-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered" id="detail_biaya">
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade text-xs-left modal-lg" id="modal_tagihan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <label class="modal-title text-text-bold-600" id="myModalLabel33">Tagihan Biaya</label>
            </div>
            <form action="" name="tagihan_biaya" id="tagihan_biaya">
                <div class="modal-body">
                    <div class="form-group md-1">
                        <label for="id_pelanggan">ID Pelanggan</label>
                        <input type="text" id="id_pelanggan" name="id_pelanggan" class="form-control" readonly required>
                    </div>
                    <div class="form-group md-1">
                        <label for="cabang">Cabang</label>
                        <input type="text" id="cabang" name="cabang" class="form-control" readonly required>
                    </div>
                    <div class="form-group mb-1">
                        <label for="cabang">Type Biaya</label>
                        <select name="type_biaya" id="type_biaya" class="select2 form-control" disabled>
                            <option value="1">Biaya Internal</option>
                            <option value="2">Biaya External</option>
                        </select>
                    </div>
                    <div class="form-group md-1">
                        <label for="tagihan">Tagihan</label>
                        <input type="text" id="tagihan" name="tagihan" class="form-control" placeholder="Tagihan" onkeyup="this.value=autoseparator(this.value)" required>
                    </div>
                    <div class="form-group md-1">
                        <label for="">Tanggal Tagihan</label>
                        <div class="datepicker input-group date" data-provide="datepicker">
                            <input type="text" name="tgl_tagihan" id="tgl_tagihan" class="form-control" value="<?= Date('d-m-Y') ?>" required>
                            <div class="input-group-addon">
                                <i class="icon-calendar5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" id="simpan_detail" name="simpan_detail" class="btn btn-sm btn-primary">
                    <i class="icon-save"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-xs-left modal_large " id="modal_list" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <label class="modal-title text-text-bold-600" id="myModalLabel33">List Detail Tagihan Biaya</label>
            </div>
            <div class="modal-body modal_large_body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered" id="table_list">

                    </table>
                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        var UntukDatePicker = function() {
            $('.datepicker').datepicker({
                autoclose: true,
                format: "dd-mm-yyyy",
                todayBtn: "linked",
                todayHighlight: true,
                language: 'id',
            });
        }();

        var datatables = $('#detail_biaya').DataTable({
            serverSide: true,
            processing: true,
            // info: true,
            order: [],
            responsive: true,
            ajax: {
                type: 'POST',
                url: "<?= base_url() ?>probid/kumalagroup_daftar_biaya/get_detail_biaya",
            },
            columns: [{
                    data: null,
                    title: 'No',
                    width: 35,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    data: 'nama_biaya',
                    title: 'Nama Biaya',
                },
                {
                    data: null,
                    title: 'ID Pelanggan',
                    render: function(data, type, full, meta) {
                        return `<a href="#modal_list" id="a" type="button" data-toggle="modal" data-id_pelanggan=` + full.id_pelanggan + `  title="Detail Tagihan Biaya">` + full.id_pelanggan + `</a>`
                    }
                },
                {
                    data: null,
                    title: 'Type Biaya',
                    render: function(data, type, full, meta) {
                        return full.type_biaya == '1' ? 'Biaya Internal' : ' Biaya External';
                    }
                },
                {
                    data: null,
                    title: 'Tagihan',
                    render: function(data, type, full, meta) {
                        var tagihan = full.tagihan == null || full.tagihan == '' ? '' : full.tagihan;
                        return autoseparator(tagihan);
                    }
                },
                {
                    data: 'tgl_tagihan',
                    title: 'Tanggal Tagihan',
                },
                {
                    data: 'lokasi',
                    title: 'Cabang',
                },

                {
                    data: null,
                    title: 'Aksi',
                    render: function(data, type, full, meta) {
                        return `<a href="#modal_tagihan" type="button" data-toggle="modal" data-id_pelanggan=` + full.id_pelanggan + ` data-lokasi=` + full.lokasi + ` data-type_biaya=` + full.type_biaya + ` class="btn btn-sm btn-primary" title="Tagihan Biaya"><i class="icon-edit"></i></a>`
                    }
                },
            ],
        });


        var UntukModalTagihan = function() {
            $('#modal_tagihan').on('show.bs.modal', function(e) {
                var id_pelanggan = $(e.relatedTarget).data('id_pelanggan');
                var lokasi = $(e.relatedTarget).data('lokasi');
                var type_biaya = $(e.relatedTarget).data('type_biaya');
                $('#id_pelanggan').attr('value', id_pelanggan);
                $('#cabang').attr('value', lokasi);
                $('#type_biaya').prop('value', type_biaya);

            });
        }();

        var UntukSimpanData = function() {
            $('#simpan_detail').click(function(e) {
                var today = new Date();
                var date = today.getDate() + '-' + (today.getMonth() + 1) + '-' + today.getFullYear();
                var form = $('#tagihan_biaya');
                var xx = form.serialize();
                e.preventDefault();
                if (form.valid()) {
                    modal_loading();
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url() ?>probid/kumalagroup_daftar_biaya/simpan",
                        data: xx,
                        dataType: "json",
                        success: function(data) {
                            swal(data, "", "success").then(function() {
                                datatables.draw();
                                modal_unload();
                                $('#modal_tagihan').modal('hide');
                                $('#tagihan').val('');
                                $('#tgl_tagihan').val(date);
                            });

                        }
                    });
                }
            });
        }();

        var id = null;
        var tablelist = $('#table_list').DataTable({
            serverSide: true,
            processing: true,
            order: [],
            responsive: true,
            ajax: {
                type: 'POST',
                url: "<?= base_url() ?>probid/kumalagroup_daftar_biaya/get_list_detail_biaya",
                data: function(data) {
                    data.id_pelanggan = id;
                }
            },
            columns: [{
                    data: null,
                    title: 'No',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'id_pelanggan',
                    title: 'ID Pelanggan',
                },
                {
                    data: 'tgl_tagihan',
                    title: 'Tanggal Tagihan',
                },
                {
                    data: 'no_transaksi',
                    title: 'No Transaksi',
                },
                {
                    data: 'tgl_transaksi',
                    title: 'Tanggal Transaksi',
                },
                {
                    data: 'no_bku',
                    title: 'NO BKU',
                },
                {
                    data: 'tgl_approve',
                    title: 'Tanggal Approve',
                },
                {
                    data: 'tagihan',
                    title: 'Tagihan',
                },
            ],
        });

        var UntukModalListTagihan = function() {
            $('#modal_list').on('show.bs.modal', function(e) {
                id = $(e.relatedTarget).data('id_pelanggan')
                tablelist.draw();
            });

        }();


    });

    function autoseparator(Num) {
        Num += '';
        Num = Num.replace('.', '');
        Num = Num.replace('.', '');
        Num = Num.replace('.', '');
        Num = Num.replace('.', '');
        Num = Num.replace('.', '');
        Num = Num.replace('.', '');
        x = Num.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        return x1 + x2;
    }
</script>