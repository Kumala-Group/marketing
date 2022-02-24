<!-- begin:: modal-edit-baris -->
<div class="modal fade text-xs-left" id="modal-edit-baris" tabindex="-1" role="dialog" aria-labelledby="myModalLabel34" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <label class="modal-title text-text-bold-600" id="myModalLabel34">Upload Format Digital Leads</label>
            </div>
            <form id="edit-baris" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <?php foreach ($list_column as $kolom) : ?>
                            <?php if ($kolom[2] == 'hidden') : ?>
                                <input type="<?= $kolom[2] ?>" class="form-control" name="<?= $kolom[1] ?>" id="<?= $kolom[1] ?>_input">
                            <?php else : ?>
                                <div class="form-group row">
                                    <label for="<?= $kolom[1] ?>_input" class="col-sm-4 col-form-label"><?= $kolom[0] ?></label>
                                    <div class="col-md-6">
                                        <?php if ($kolom[2] == 'select') : ?>
                                            <select class="custom-select" name="<?= $kolom[1] ?>" id="<?= $kolom[1] ?>_input">
                                            </select>
                                        <?php else : ?>
                                            <input type="<?= $kolom[2] ?>" class="form-control" name="<?= $kolom[1] ?>" id="<?= $kolom[1] ?>_input">
                                        <?php endif ?>
                                    </div>
                                </div>
                            <?php endif ?>
                        <?php endforeach ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="batal-edit" class="btn btn-sm btn-danger" data-dismiss="modal">
                            <i class="icon-close"></i>
                            Batal
                        </button>
                        <button type="submit" id="simpan-data-edit" class="btn btn-sm btn-success">
                            <i class="icon-save"></i>
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end:: modal -->

<script>
    function ambilDaftarCabang(id_cabang = '') {
        const input_container = document.getElementById('id_perusahaan_input')
        input_container.innerHTML = ''
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

    function edit_data(dataId) {
        var id = dataId
        $.ajax({
            method: 'POST',
            url: '<?= base_url() ?>digital_leads/wuling_dl_customer/get_customer',
            data: 'id=' + id,
            dataType: "json",
            success: function(data) {
                <?php foreach ($list_column as $kolom) : ?>
                    $('#<?= $kolom[1] ?>_input').val(data.<?= $kolom[1] ?>);
                <?php endforeach ?>
                ambilDaftarCabang(data.id_perusahaan)
            }
        })
    }

    $('#simpan-data-edit').click(function(e) {
        e.preventDefault();
        var string = $("#edit-baris").serialize();
        if (confirm("Anda yakin ingin menyimpan data ini??")) {
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>digital_leads/wuling_dl_customer/simpan_customer",
                data: string,
                cache: false,
                beforeSend: function(data) {
                    $('#simpan-data-edit').prop('disabled', true)
                    $('#verifikasi-data-edit').prop('disabled', true)
                    $('#batal-edit').prop('disabled', true)
                },
                success: function(data) {
                    alert(data);
                    location.reload();
                }
            });
        }
    })
</script>