<div class="modal fade text-xs-left" id="modal-edit-followup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <label class="modal-title text-text-bold-600 label-modal-tambah-edit-followup" id="myModalLabel35">Tambah/Edit Data Follow Up</label>
            </div>
            <form id="edit-followup" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <?php foreach ($list_followup as $kolom) : ?>
                            <?php if ($kolom[2] == 'hidden') : ?>
                                <input type="<?= $kolom[2] ?>" class="form-control" name="<?= $kolom[1] ?>" id="<?= $kolom[1] ?>_input_fu">
                            <?php else : ?>
                                <div class="form-group row">
                                    <label for="<?= $kolom[1] ?>_input_fu" class="col-md-4 offset-md-1 col-form-label"><?= $kolom[0] ?></label>
                                    <div class="col-md-6">
                                        <?php if ($kolom[2] == 'select') : ?>
                                            <select class="custom-select" name="<?= $kolom[1] ?>" id="<?= $kolom[1] ?>_input_fu">
                                                <?php if ($kolom[1] == 'id_status_customer') : ?>
                                                    <option>Pilih Status Customer</option>
                                                <?php elseif ($kolom[1] == 'id_status_fu') : ?>
                                                    <option>Pilih Status Follow Up</option>
                                                <?php endif ?>
                                            </select>
                                        <?php else : ?>
                                            <input type="<?= $kolom[2] ?>" class="form-control" name="<?= $kolom[1] ?>" id="<?= $kolom[1] ?>_input_fu">
                                        <?php endif ?>
                                    </div>
                                </div>
                            <?php endif ?>
                        <?php endforeach ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">
                            <i class="icon-close"></i>
                            Batal
                        </button>
                        <button type="submit" id="simpan" class="btn btn-sm btn-success">
                            <i class="icon-save"></i>
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function ambilStatusCustomer(idStatusCustomer = '') {
        var input_container = document.getElementById('id_status_customer_input_fu')
        input_container.innerHTML = '<option>Pilih Status Customer</option>'
        $.ajax({
            method: 'POST',
            url: '<?= base_url() ?>digital_leads/wuling_dl_followup/daftar_status_customer',
            dataType: "json",
            success: function(data) {
                data.forEach(status => {
                    var opsi = document.createElement('option')
                    opsi.textContent = status.nama_status_customer;
                    opsi.setAttribute('value', status.id_status_customer)
                    if (idStatusCustomer == status.id_status_customer) opsi.setAttribute('selected', 'selected')
                    input_container.appendChild(opsi);
                });
            }
        })
    }

    function ambilStatusFollowup(idStatusFu = '') {
        var input_container = document.getElementById('id_status_fu_input_fu')
        input_container.innerHTML = '<option>Pilih Status Follow Up</option>'
        $.ajax({
            method: 'POST',
            url: '<?= base_url() ?>digital_leads/wuling_dl_followup/daftar_status_fu',
            dataType: "json",
            success: function(data) {
                data.forEach(status => {
                    var opsi = document.createElement('option')
                    opsi.textContent = status.nama_status_fu;
                    opsi.setAttribute('value', status.id_status_fu)
                    if (idStatusFu == status.id_status_fu) opsi.setAttribute('selected', 'selected')
                    input_container.appendChild(opsi);
                });
            }
        })
    }

    function ambilKeteranganFollowup(idKeteranganFu = '') {
        var input_container = document.getElementById('id_keterangan_fu_input_fu')
        input_container.innerHTML = '<option>Pilih Keterangan Follow Up</option>'
        $.ajax({
            method: 'POST',
            url: '<?= base_url() ?>digital_leads/wuling_dl_followup/daftar_keterangan_fu',
            dataType: "json",
            success: function(data) {
                data.forEach(keterangan => {
                    var opsi = document.createElement('option')
                    opsi.textContent = keterangan.nama_keterangan_fu;
                    opsi.setAttribute('value', keterangan.id_keterangan_fu)
                    if (idKeteranganFu == keterangan.id_keterangan_fu) opsi.setAttribute('selected', 'selected')
                    input_container.appendChild(opsi);
                });
            }
        })
    }

    function cek_input(item, teks, itemId) {
        if (!item) {
            alert(`Maaf, ${teks} Tidak boleh kosong`)
            $(`#${itemId}`).focus();
            return false;
        }
        return true;
    }

    function cek_isian_fu() {
        var hasil = false
        var tgl_fu = $('#tgl_fu_input_fu').val()
        var status_customer = $('#id_status_customer_input_fu').val() !== "Pilih Status Customer" ? $('#id_status_customer_input_fu').val() : ''
        var status_fu = $('#id_status_fu_input_fu').val() !== "Pilih Status Follow Up" ? $('#id_status_fu_input_fu').val() : ''
        if (
            (
                cek_input(tgl_fu, 'Tanggal Follow Up', 'tgl_fu_input_fu') &&
                cek_input(status_customer, 'Status Customer', 'id_status_customer_input_fu') &&
                cek_input(status_fu, 'Status Follow Up', 'id_status_fu_input_fu')
            )
        ) {
            hasil = true
        }

        return hasil
    }

    $('#simpan').click(function(e) {
        e.preventDefault();
        var string = $("#edit-followup").serialize();

        if (cek_isian_fu()) {
            if (confirm("Anda yakin ingin menyimpan data ini?")) {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url(); ?>digital_leads/wuling_dl_followup/simpan_customer",
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
</script>