<style>
    .form-check-input {
        margin-left: 0em;
        margin-top: .8em;
    }

    .form-check-label {
        margin-top: .5em;
    }
</style>
<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_profil"><?= $judul ?></h5>
                    <div class="heading-elements">
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block pt-1">
                        <div class="row">
                            <div class="col-md-8" style="border-right:1px solid #ddd;">
                                <div class=" row">
                                    <div class="col-md-12">
                                        <p>Tambah ke Daftar Follow Up</p>
                                    </div>
                                    <form id="input_followup">
                                        <div class="col-md-12 form-inline">
                                            <label for="tgl_followup" style="margin-right: 0.5em;">Pilih Tanggal: </label>
                                            <input type="date" name="tgl_followup" id="pilih_tanggal" class="form-control">
                                            <button id="simpan_list" class="btn btn-info"><i class="icon-ios-compose-outline" style="color:#fff;"></i> Tambah ke Daftar Follow Up</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input xylo" type="checkbox" name="xylo" value="xylo" id="filter-xylo">
                                        <label class="form-check-label" for="filter-xylo">
                                            Pilih Customer Xylo
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-block pt-1">
                    <div class="table-responsive">
                        <table class="table table-sm" id="tabel-unverified"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('modal_edit_data'); ?>

<script>
    $(document).ready(function() {
        $('#tabel-unverified').DataTable({
            responsive: false,
            serverSide: true,
            processing: true,
            order: [],
            ajax: {
                url: "<?= base_url() ?>digital_leads/wuling_dl_customer/data_customer",
                type: 'POST',
                data: function(d) {
                    if ($("#filter-xylo").is(':checked')) d.xylo = true
                }
            },
            columns: [{
                    data: "id_dl_customer",
                    title: "No.",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'id_customer_digital',
                    title: 'ID Customer Digital',
                },
                {
                    data: 'tgl_masuk_leads',
                    title: 'Tgl Masuk Leads',
                },
                {
                    data: 'tgl_bagi_leads',
                    title: 'Tgl Bagi Leads',
                },
                {
                    data: 'lead_source',
                    title: 'Lead Source',
                },
                {
                    data: 'komunikasi',
                    title: 'Komunikasi',
                },
                {
                    responsivePriority: -1,
                    data: 'nama',
                    title: 'Nama',
                },
                {
                    responsivePriority: -1,
                    data: 'no_telp',
                    title: 'No. Telp',
                },
                {
                    data: 'keterangan',
                    title: 'Keterangan',
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
                    responsivePriority: -1,
                    data: 'lokasi',
                    title: 'Dealer',
                },
                {
                    data: 'regional',
                    title: 'Region',
                },
                {
                    data: 'email',
                    title: 'Email',
                },
                {
                    data: 'pekerjaan',
                    title: 'Pekerjaan',
                },
                {
                    data: 'rencana_pembelian',
                    title: 'Rencana Pembelian Mobil',
                },
                {
                    data: 'info_yg_dibutuhkan',
                    title: 'Info Yang Dibutuhkan',
                },
                {
                    data: 'tipe_mobil',
                    title: 'Tipe Mobil',
                },
                {
                    data: 'brand_lain',
                    title: 'Brand Lain/Model',
                },
                {
                    data: null,
                    title: 'Aksi',
                    orderable: false,
                    searchable: false,
                    responsivePriority: -1,
                    render: function(data) {
                        return `<div class="form-group mb-0">
                            <button type="button" onclick="edit_data(` + data.id_dl_customer + `);" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-edit-baris" 
                                data-toggle="tooltip" title="Edit"><i class="icon-ios-compose-outline"></i></button>
                            <button type="button" onclick="hapus_data('` + data.id_dl_customer + `');" class="btn btn-sm btn-danger" 
                                data-toggle="tooltip" title="Hapus"><i class="icon-ios-trash-outline"></i></button>
                        </div>`;
                    },
                },
                {
                    data: null,
                    title: 'Pilih',
                    orderable: false,
                    searchable: false,
                    responsivePriority: -1,
                    render: function(data) {
                        return `<input type="checkbox" value="` + data.id_dl_customer + `">`;
                    },
                },
            ]
        });
    });

    function hapus_data(dataId) {
        var id = dataId
        if (confirm("Anda yakin ingin menghapus data ini??")) {
            $.ajax({
                method: 'POST',
                url: '<?= base_url() ?>digital_leads/wuling_dl_customer/hapus_customer',
                data: 'id=' + id,
                dataType: "json",
                success: function(data) {
                    alert(data.message);
                    location.reload();
                }
            })
        }
    }

    $("#filter-xylo").change(function() {
        $('#tabel-unverified').DataTable().ajax.reload()
    });

    $('#simpan_list').click(function(e) {
        e.preventDefault()
        var tanggal = $('#pilih_tanggal').val();
        var cek_list = [];
        $(':checkbox:checked').each(function(i) {
            cek_list[i] = $(this).val()
        });

        if (tanggal.length == 0) {
            $('#pilih_tanggal').attr('style', 'border: 1px solid red');
            return false;
        }
        if (cek_list.length === 0) {
            swal('Anda Belum Memilih Costumer');
            return false;
        }

        swal({
            title: "Simpan Data",
            text: "Apakah anda ingin menambahkan data ini ke daftar follow up?",
            icon: "warning",
            buttons: true,
        }).then((confirm) => {
            if (confirm) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>digital_leads/wuling_dl_customer/tambah_ke_followup",
                    data: {
                        'tanggal': tanggal,
                        'cek_list': cek_list,
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $("#simpan_list").html("Loading...");
                        $("#simpan_list").prop('disabled', true);
                    },
                    success: function(data) {
                        if (data.status) {
                            swal("Berhasil Menambahkan data", data.message, "success")
                                .then((confirm) => {
                                    if (confirm) location.reload()
                                });
                        } else {
                            swal("Gagal Menambahkan data", data.message, "error");
                        }
                        $("#simpan_list").html("<i class='icon-save'></i>Simpan");
                        $("#simpan_list").prop('disabled', false);
                    },
                });
            }
        })
    });
</script>