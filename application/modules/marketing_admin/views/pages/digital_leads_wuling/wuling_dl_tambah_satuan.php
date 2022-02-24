<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_profil"><?= $judul ?></h5>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block pt-1">
                        <form id="form" enctype="multipart/form-data" class="form">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="tgl_masuk_leads" class="col-form-label">Tgl. Masuk Leads</label>
                                    <input type="date" class="form-control" name="tgl_masuk_leads" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="tgl_bagi_leads" class="col-form-label">Tgl. Bagi Leads</label>
                                    <input type="date" class="form-control" name="tgl_bagi_leads" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="lead_source" class="col-form-label">Lead Source</label>
                                    <input type="text" class="form-control" name="lead_source" placeholder="Lead Source">
                                </div>
                                <div class="col-md-3">
                                    <label for="komunikasi" class="col-form-label">Visual Komunikasi</label>
                                    <input type="text" class="form-control" name="komunikasi" placeholder="Visual Komunikasi">
                                </div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-md-6">
                                    <label for="nama" class="col-form-label">Nama Customer</label>
                                    <input type="text" class="form-control" name="nama" placeholder="Nama Customer" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="no_telp" class="col-form-label">No. Telp</label>
                                    <input type="text" class="form-control" name="no_telp" placeholder="No. Telp" required>
                                </div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-md-6">
                                    <label for="keterangan" class="col-form-label">Keterangan</label>
                                    <input type="text" class="form-control" name="keterangan" placeholder="Keterangan">
                                </div>
                                <div class="col-md-6">
                                    <label for="alamat" class="col-form-label">Alamat</label>
                                    <input type="text" class="form-control" name="alamat" placeholder="Alamat" required>
                                </div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-md-3">
                                    <label for="kota" class="col-form-label">Kota/Kabupaten</label>
                                    <input type="text" class="form-control" name="kota" placeholder="Kota/Kabupaten">
                                </div>
                                <div class="col-md-3">
                                    <label for="dealer" class="col-form-label">Dealer</label>
                                    <br>
                                    <select class="custom-select" name="dealer" id="dealer" required>
                                        <option value="">-Pilih Cabang-</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="email" class="col-form-label">Email</label>
                                    <input type="text" class="form-control" name="email" placeholder="Email">
                                </div>
                                <div class="col-md-3">
                                    <label for="pekerjaan" class="col-form-label">Pekerjaan</label>
                                    <input type="text" class="form-control" name="pekerjaan" placeholder="Pekerjaan">
                                </div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-md-3">
                                    <label for="rencana_pembelian" class="col-form-label">Rencana Pembelian Mobil</label>
                                    <input type="text" class="form-control" name="rencana_pembelian" placeholder="Rencana Pembelian Mobil">
                                </div>
                                <div class="col-md-6">
                                    <label for="info_yg_dibutuhkan" class="col-form-label">Info yang Dibutuhkan</label>
                                    <input type="text" class="form-control" name="info_yg_dibutuhkan" placeholder="Info yang Dibutuhkan">
                                </div>
                                <div class="col-md-3">
                                    <label for="tipe_mobil" class="col-form-label">Tipe Mobil Wuling</label>
                                    <input type="text" class="form-control" name="tipe_mobil" placeholder="Tipe Mobil Wuling">
                                </div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-md-3">
                                    <label for="brand_lain" class="col-form-label">Brand Lain/Model</label>
                                    <input type="text" class="form-control" name="brand_lain" placeholder="Brand Lain/Model">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-footer">
                    <center>
                        <button type="submit" id="simpan-data-edit" class="btn btn-sm btn-success">
                            <i class="icon-save"></i>
                            Simpan
                        </button>
                    </center>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function ambilDaftarCabang() {
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
                    opsi.setAttribute('value', cabang.lokasi)
                    input_container.appendChild(opsi);
                });
            }
        })
    }

    $('#simpan-data-edit').click(function(e) {
        e.preventDefault();

        if ($('#form').valid()) {
            var string = $("#form").serialize();
            swal({
                    title: "Simpan Data",
                    text: "Apakah anda ingin menyimpan data ini?",
                    icon: "warning",
                    buttons: true,
                })
                .then((confirm) => {
                    if (confirm) {
                        $.ajax({
                            type: 'POST',
                            url: "<?php echo site_url(); ?>digital_leads/wuling_dl_tambah_satuan/simpan_customer",
                            data: string,
                            dataType: 'json',
                            cache: false,
                            beforeSend: function(data) {
                                $('#simpan-data-edit').prop('disabled', true)
                                $('#verifikasi-data-edit').prop('disabled', true)
                                $('#batal-edit').prop('disabled', true)
                            },
                            success: function(data) {
                                if (data.status) {
                                    swal("Berhasil Mengupload data", data.message, "success")
                                        .then((confirm) => {
                                            if (confirm) location.reload()
                                        });
                                } else {
                                    swal("Gagal Mengupload data", data.message, "error");
                                }
                                $('#simpan-data-edit').prop('disabled', false)
                                $('#verifikasi-data-edit').prop('disabled', false)
                                $('#batal-edit').prop('disabled', false)
                            }
                        });
                    }
                });
        }
    })

    $(document).ready(function() {
        ambilDaftarCabang()
    })
</script>