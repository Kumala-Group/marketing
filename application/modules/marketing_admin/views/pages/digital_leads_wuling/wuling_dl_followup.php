<style>
    .modal-lg {
        max-width: 90%;
    }
</style>

<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_profil"><?= $judul ?></h5>
                </div>
                <div class="card-body collapse in">
                    <div class="row">
                        <div class="card-block pt-1">
                            <div class="table-responsive">
                                <table class="table table-sm" id="tabel-data"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        const kolom = [{
                data: "id_dl_customer",
                title: "No.",
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: 'tgl_fu',
                title: 'Tgl. Follow Up Terakhir',
                responsivePriority: -1,
            },
            {
                data: 'id_customer_digital',
                title: 'ID Customer Digital',
                responsivePriority: -1,
            },
            {
                data: 'nama',
                title: 'Nama',
                responsivePriority: -1,
            },
            {
                data: 'lead_source',
                title: 'Lead Source',
            },
            {
                data: 'no_telp',
                title: 'No. Telp',
            },
            {
                data: 'alamat',
                title: 'Alamat',
            },
            {
                data: 'kota',
                title: 'Kota/Kabupaten',
            },
            {
                data: 'lokasi',
                title: 'Cabang',
            },
            {
                data: 'nama_lengkap',
                title: 'Sales Digital',
            },
            {
                data: 'nama_status_customer',
                title: 'Status',
                responsivePriority: -1,
            },
            {
                data: 'nama_status_fu',
                title: 'Status Follow Up',
                responsivePriority: -1,
            }
        ]
        <?php if ($is_sales_digital) : ?>
            kolom.push({
                data: null,
                title: 'Aksi',
                orderable: false,
                searchable: false,
                responsivePriority: -1,
                render: function(data) {
                    return `<div class="form-group mb-0">
                        <a href="<?= base_url() ?>digital_leads/wuling_dl_followup/edit_customer/${data.id_dl_customer}" type="button" class="btn btn-sm btn-info"><i class="icon-ios-compose-outline"></i> Edit</a>
                    </div>`;
                },
            })
        <?php endif ?>

        $('#tabel-data').DataTable({
            responsive: false,
            serverSide: true,
            processing: true,
            ajax: {
                url: "<?= base_url() ?>digital_leads/wuling_dl_followup/data_masuk",
                type: 'POST',
            },
            columns: kolom
        });
    });
</script>