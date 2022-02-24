<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_profil"><?= $judul ?></h5>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block pt-1">
                        <div class="table-responsive">
                            <table class="table table-sm" id="tabel_customer_followup">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<!-- begin:: modal -->
<div class="modal fade text-xs-left" id="modal_konfirmasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <label class="modal-title text-text-bold-600" id="myModalLabel33">Inline Login Form</label>
            </div>
            <form action="#">

                <input type="hidden" name="id_digital_leads" id="id_digital_leads" placeholder="" readonly>

                <div class="modal-body">
                    <label for="">Tanggal FollowUp</label>
                    <div class="form-group">
                        <input type="date" name="tgl_fu" id="tgl_fu" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Date Opened" data-original-title="" title="" aria-describedby="tooltip198912">
                    </div>

                    <label for="">Nama Customer</label>
                    <div class="form-group">
                        <input class="form-control" type="text" name="nama_leads" id="nama_leads" placeholder="Nama Customer" readonly>
                    </div>

                    <label for="">Hasil FollowUp</label>
                    <div class="form-group">
                        <input class="form-control" type="text" name="hasil_fu" id="hasil_fu" placeholder="Hasil FollowUp">
                    </div>

                    <label for="">Keterangan FollowUp</label>
                    <div class="form-group">
                        <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
                    </div>

                    <label for="">Status</label>
                    <div class="form-group">
                        <select class="form-control" name="status" id="status">
                            <option value="1">Suspect</option>
                            <option value="2">Prospek</option>
                            <option value="3">Hot Prospek</option>
                            <option value="4">Lost</option>
                        </select>
                    </div>

                    <label for="">No. SPK</label>
                    <div class="form-group">
                        <input class="form-control" type="text" name="no_spk" id="no_spk" placeholder="No SPK" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">
                        <i class="icon-close"></i>
                        Batal
                    </button>
                    <button type="button" name="simpan_konfirmasi" id="simpan_konfirmasi" class="btn btn-sm btn-success">
                        <i class="icon-save"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end:: modal -->

<script>
    var untukTabelDatatable = function() {
        $('#tabel_customer_followup').DataTable({
            order: [],
            info: true,
            paging: true,
            lengthChange: true,
            searching: true,
            responsive: true,
            ajax: {
                url: '<?= base_url() ?>digital_leads/wuling_digital_leads/get_data_dt_followup',
                type: 'POST',
            },
            columns: [
                {
                    data: null,
                    title: 'No',
                    width: 35,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    data: 'leads',
                    title: 'Leads',
                },
                {
                    data: 'nama_leads',
                    title: 'Nama Customer',
                },
                {
                    data: 'kontak',
                    title: 'Telepon',
                },
                {
                    data: 'alamat',
                    title: 'Alamat',
                },
                {
                    data: 'region',
                    title: 'Region',
                },
                {
                    data: 'pekerjaan',
                    title: 'Pekerjaan',
                },
                {
                    data: 'rencana_pembelian',
                    title: 'Plan Pembelian Mobil',
                },
                {
                    data: 'tanggal_fu',
                    title: 'Tanggal FU',
                    width: 100,
                },
                {
                    data: 'keterangan',
                    title: 'Keterangan',
                },
                {
                    data: 'status',
                    title: 'Status',
                },
                {
                    data: null,
                    title: 'Aksi',
                    responsivePriority: -1,
                    width: 175,
                    className: 'text-center',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return `
                            <a href="#modal_konfirmasi" class="btn btn-sm btn-success" data-toggle="modal" data-id="` + full.id_digital_leads + `">Konfirmasi</a>
                        `;
                    },
                }
            ],
        });
    }();

    var untukModalKonfirmasi = function() {
        $('#modal_konfirmasi').on('show.bs.modal', function(e) {
            var id_digital_leads = $(e.relatedTarget).data('id');

            $.ajax({
                type: "GET",
                url: "<?php echo base_url(); ?>digital_leads/wuling_digital_leads/update_data_followup",
                dataType: "json",
                data: {
                    'id_digital_leads': id_digital_leads,
                },
                beforeSend: function() {
                    $('#id_digital_leads').val('');
                    $('#tgl_fu').val('');
                    $('#nama_leads').val('');
                    $('#hasil_fu').val('');
                    $('#keterangan').val('');
                    $('#status').val('');
                    $('#no_spk').val('');
                },
                success: function(data) {
                    $('#id_digital_leads').val(data.id_digital_leads);
                    $('#tgl_fu').val(data.tanggal);
                    $('#nama_leads').val(data.nama_leads);
                    $('#hasil_fu').val(data.hasil_followup);
                    $('#keterangan').val(data.keterangan);
                    $('#status').val(data.status);
                    $('#no_spk').val(data.no_spk);
                },
            });
        });
    }();

    var untukSimpanData = function() {
        $('#simpan_konfirmasi').click(function() {
            var tgl_fu = $('#tgl_fu').val();
            var hasil_fu = $('#hasil_fu').val();
            var keterangan = $('#keterangan').val();
            var status = $('#status').val();
            var id_digital_leads = $('#id_digital_leads').val();

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>digital_leads/wuling_digital_leads/simpan_data_followup",
                data: {
                    'tgl_fu': tgl_fu,
                    'hasil_fu': hasil_fu,
                    'keterangan': keterangan,
                    'status': status,
                    'id_digital_leads': id_digital_leads,
                },
                beforeSend: function() {
                    $("#simpan_konfirmasi").html("Loading...");
                    $("#simpan_konfirmasi").prop('disabled', true);
                },
                success: function() {
                    $("#simpan_konfirmasi").html("<i class='icon-save'></i>Simpan");
                    $("#simpan_konfirmasi").prop('disabled', false);
                    alert("Data berhasil disimpan");
                    location.reload();
                },
            });
        });
    }();
</script>