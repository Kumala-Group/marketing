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
                        <table class="table table-sm" id="tabel_customer_alokasi">
                        </table>
                    </div>
                </div>
            </div>
        </div>
</section>

<!-- begin:: modal -->
<div class="modal fade text-xs-left" id="modal_history" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <label class="modal-title text-text-bold-600" id="myModalLabel33">History FollowUp Customer</label>
            </div>
            <div class="modal-body">
                <table class="table table-sm" id="tabel_customer_history_followup">
                    <thead>
                        <tr>
                            <th class="center">No</th>
                            <th class="center">Tanggal Follow Up</th>
                            <th class="center">Hasil Follow Up</th>
                            <th class="center">Keterangan Follow Up</th>
                            <th class="center">Status</th>
                        </tr>
                    </thead>
                    <tbody id="history_fu">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" id="alokasi_to_sales" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_sales">
                    <i class="icon-save"></i> Alokasi to Sales
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-xs-left" id="modal_sales" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <label class="modal-title text-text-bold-600" id="myModalLabel33">History FollowUp Customer</label>
            </div>
            <form action="#">

                <input type="hidden" name="id_digital_leads" id="id_digital_leads">

                <div class="modal-body">
                    <label for="">Status</label>
                    <div class="form-group">
                        <select class="form-control" name="sales" id="sales" style="width: 100%;">
                            <option value="">Pilih Sales</option>
                            <?php foreach ($sales as $dt) : ?>
                                <option value="<?= $dt->id_sales; ?>"><?= $dt->nama_karyawan; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">
                        <i class="icon-close"></i>
                        Batal
                    </button>
                    <button type="button" name="simpan_alokasi" id="simpan_alokasi" class="btn btn-sm btn-success">
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
    var id_digital_leads = null;

    $('#sales').select2({
        dropdownParent: $('#modal_sales')
    });

    var untukTabelDatatable = function() {
        $('#tabel_customer_alokasi').DataTable({
            order: [],
            info: true,
            paging: true,
            lengthChange: true,
            searching: true,
            responsive: true,
            ajax: {
                url: '<?= base_url() ?>digital_leads/wuling_digital_leads/get_data_dt_alokasi',
                type: 'POST',
            },
            columns: [{
                    data: null,
                    title: 'No',
                    width: 35,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
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
                    data: 'tanggal',
                    title: 'Last Tanggal FU',
                },
                {
                    data: null,
                    title: 'Last Status',
                    render: function(data, type, full, meta) {
                        var status = ['', 'Suspect', 'Prospek', 'Hot Prospek', 'Lost'];
                        return (full.status != null) ? status[full.status] : '';
                    },
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
                            <a href="#modal_history" class="btn btn-sm btn-success" data-toggle="modal" data-id="` + full.id_digital_leads + `"><i class="icon-pencil"></i></a>
                        `;
                    },
                }
            ],
        });
    }();

    var untukModalHistory = function() {
        $('#modal_history').on('show.bs.modal', function(e) {
            id_digital_leads = $(e.relatedTarget).data('id');

            $('#tabel_customer_history_followup').DataTable();

            $.ajax({
                type: "GET",
                url: "<?= base_url() ?>digital_leads/wuling_digital_leads/get_data_dt_history",
                dataType: "json",
                data: {
                    'id_digital_leads': id_digital_leads,
                },
                beforeSend: function() {
                    $('#history_fu').html('');
                },
                success: function(data) {
                    var no = [];
                    for (var index = 0; index < data.length; index++) {
                        no.push(index + 1);
                        $('#history_fu').append(
                            "<tr>" +
                            "<td class='center'>" + no[index] + "</td>" +
                            "<td class='center'>" + data[index]['tanggal'] + "</td>" +
                            "<td class='center'>" + data[index]['hasil_followup'] + "</td>" +
                            "<td class='center'>" + data[index]['keterangan'] + "</td>" +
                            "<td class='center'>" + data[index]['status_leads'] + "</td>" +
                            "</tr>"
                        );
                    }
                },
            });
        });
    }();

    var untukModalSales = function() {
        $('#alokasi_to_sales').click(function() {
            $('#modal_history').modal('hide');
            $('#id_digital_leads').val(id_digital_leads);
        });
    }();

    var untukSimpanData = function() {
        $('#simpan_alokasi').click(function() {
            var sales = $('#sales').val();

            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>digital_leads/wuling_digital_leads/simpan",
                data: {
                    'id_digital_leads': id_digital_leads,
                    'sales': sales,
                },
                beforeSend: function() {
                    $("#simpan_alokasi").html("Loading...");
                    $("#simpan_alokasi").prop('disabled', true);
                },
                success: function() {
                    alert("Data berhasil disimpan");
                    location.reload();
                },
            });
        });
    }();
</script>