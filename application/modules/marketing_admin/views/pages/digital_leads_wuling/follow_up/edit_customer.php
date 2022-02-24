<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_profil"><?= $judul ?></h5>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                        <a class="btn btn-danger" style="padding: 0.25rem 0.5rem;" href="<?php echo base_url(); ?>digital_leads/wuling_dl_followup">
                            <i class="icon-close" style="color: white;"></i> Tutup
                        </a>
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block p-1">
                        <form id="form" enctype="multipart/form-data" class="form">
                            <div class="row">
                                <input type="hidden" name="id_customer" value="<?= $customer[0]->id_dl_customer ?>">
                                <div class="col-md-6">
                                    <label for="nama" class="col-form-label">Nama Customer</label>
                                    <input type="text" class="form-control" placeholder="Nama Customer" value="<?= $customer[0]->nama ?>" disabled>
                                </div>
                                <div class="col-md-3">
                                    <label for="no_telp" class="col-form-label">No. Telp</label>
                                    <input type="text" class="form-control" placeholder="No. Telp" value="<?= $customer[0]->no_telp ?>" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label for="alamat" class="col-form-label">Alamat</label>
                                    <input type="text" class="form-control" placeholder="Alamat" value="<?= $customer[0]->alamat ?>" disabled>
                                </div>
                                <div class="col-md-3">
                                    <label for="dealer" class="col-form-label">Dealer</label>
                                    <br>
                                    <select class="custom-select" name="dealer" id="dealer" required>
                                        <option value="">-Pilih Cabang-</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="sales-force" class="col-form-label">Sales Force</label>
                                    <br>
                                    <select class="custom-select" name="sales_force" id="sales-force" required>
                                        <option value="">-Pilih Sales Force-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 pt-3">
                                    <center>
                                        <button type="submit" id="simpan-cabang" class="btn btn-success">
                                            <i class="icon-save"></i>
                                            Simpan
                                        </button>
                                    </center>
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <div class="card-block p-1">
                        <div class="row">
                            <div class="col-sm-6">
                                <h5>History Follow Up</h5>
                            </div>
                            <div class="col-sm-6">
                                <button type="button" id="tambah-fu" id-user="<?= $customer[0]->id_dl_customer ?>" id-cabang="<?= $customer[0]->id_perusahaan ?>" class="btn btn-success" style="float: right;margin-bottom:1.7em;" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#modal-edit-followup">
                                    <i class="icon-plus" style="color: #fff;"></i>
                                    Tambah Data
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm" id="tabel-data"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('modal_edit_detail_fu'); ?>

<script>
    function ambilDaftarCabang(id_cabang = '') {
        const input_container = document.getElementById('dealer')
        input_container.innerHTML = '<option value="">-Pilih Cabang-</option>'
        $.ajax({
            method: 'POST',
            url: '<?= base_url() ?>digital_leads/wuling_dl_tambah_satuan/daftar_cabang',
            dataType: "json",
            success: function(data) {
                data.forEach(cabang => {
                    let opsi = document.createElement('option')
                    opsi.textContent = cabang.lokasi;
                    opsi.setAttribute('value', cabang.id_perusahaan)
                    if (id_cabang && id_cabang === cabang.id_perusahaan) opsi.setAttribute('selected', 'selected')
                    input_container.appendChild(opsi);
                });
            }
        })
    }

    function ambilDaftarSalesForce(id_sales = '', id_cabang = '') {
        const input_container = document.getElementById('sales-force')
        input_container.innerHTML = '<option value="">-Pilih Sales Force-</option>'
        $.ajax({
            method: 'POST',
            url: '<?= base_url() ?>digital_leads/wuling_dl_followup/daftar_sales_force',
            dataType: "json",
            data: `id_cabang=${id_cabang}`,
            success: function(data) {
                data.forEach(sales => {
                    let opsi = document.createElement('option')
                    opsi.textContent = sales.nik + ' - ' + sales.nama_karyawan;
                    opsi.setAttribute('value', sales.id_sales)
                    if (id_sales && id_sales == sales.id_sales) opsi.setAttribute('selected', 'selected')
                    input_container.appendChild(opsi);
                });
            }
        })
    }

    $('#dealer').change(function() {
        ambilDaftarSalesForce('', $('#dealer').val())
    })

    $('#simpan-cabang').click(function(e) {
        e.preventDefault()
        if ($('#form').valid()) {
            const string = $('#form').serialize()
            if (confirm("Anda yakin ingin mengubah data customer?")) {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url(); ?>digital_leads/wuling_dl_followup/simpan_cabang_customer",
                    data: string,
                    cache: false,
                    beforeSend: function(data) {
                        $('#simpan-data-followup').prop('disabled', true)
                        $('#batal-followup').prop('disabled', true)
                    },
                    success: function(data) {
                        alert(data);
                        location.reload();
                    }
                });
            }
        }
    })

    $('#tambah-fu').click(function() {
        $('.label-modal-tambah-edit-followup').text(`Tambah Data Follow Up`)
        $('#id_dl_customer_input_fu').val($('#tambah-fu').attr('id-user'))
        $('#tgl_fu_input_fu').val('')
        $('#id_perusahaan_input_fu').val('')
        $('#id_status_fu_input_fu').val('')
        $('#keterangan_fu_input_fu').val('')
        ambilStatusCustomer()
        ambilStatusFollowup()
        ambilKeteranganFollowup()
    })

    function edit_data_followup(idFollowUp) {
        $('.label-modal-tambah-edit-followup').text(`Edit Data Follow Up`)
        $('#id_status_fu_input_fu').val('')
        $('#id_dl_customer_input_fu').val('')
        $('#tgl_fu_input_fu').val('')
        $('#keterangan_fu_input_fu').val('')
        var id = idFollowUp
        $.ajax({
            method: 'POST',
            url: '<?= base_url() ?>digital_leads/wuling_dl_followup/get_detail_fu',
            data: 'id=' + id,
            dataType: "json",
            success: function(data) {
                <?php foreach ($list_followup as $kolom) : ?>
                    $('#<?= $kolom[1] ?>_input_fu').val(data.<?= $kolom[1] ?>);
                <?php endforeach ?>
                ambilStatusCustomer(data.id_status_customer)
                ambilStatusFollowup(data.id_status_fu)
                ambilKeteranganFollowup(data.id_keterangan_fu)
            }
        })
    }

    $(document).ready(function() {
        ambilDaftarCabang('<?= $customer[0]->id_perusahaan ?>')
        ambilDaftarSalesForce('<?= $customer[0]->id_sales_force ?>', '<?= $customer[0]->id_perusahaan ?>')

        $('#tabel-data').DataTable({
            responsive: false,
            serverSide: true,
            processing: true,
            ajax: {
                url: "<?= base_url() ?>digital_leads/wuling_dl_followup/data_followup/<?= $customer[0]->id_dl_customer ?>",
                type: 'POST',
            },
            columns: [{
                    data: "id_followup",
                    title: "No.",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'tgl_fu',
                    title: 'Tgl. Follow Up',
                    responsivePriority: -1,
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
                },
                {
                    data: 'nama_keterangan_fu',
                    title: 'Keterangan Follow Up',
                },
                {
                    data: null,
                    title: 'Aksi',
                    orderable: false,
                    searchable: false,
                    responsivePriority: -1,
                    render: function(data) {
                        return `<div class="form-group mb-0">
                    <button type="button" onclick="edit_data_followup(${data.id_followup});" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-edit-followup"><i class="icon-ios-compose-outline"></i> Edit Status FU</button>
                    </div>`;
                    },
                }
            ]
        });
    });
</script>