<section>
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_profil"><?= $judul ?></h5>
                    <div class="heading-elements">
                        <button type="button" id="tambah" class="btn btn-sm btn-success" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#modal">
                            <i class="icon-plus" style="color: #fff;"></i>
                            Tambah Data
                        </button>
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block pt-1">
                        <div class="table-responsive">
                            <table class="table table-sm" id="tabel-data"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- begin:: modal -->
<div class="modal fade text-xs-left" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel34" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <label class="modal-title text-text-bold-600" id="myModalLabel34">Tambah/Edit Data</label>
            </div>
            <form id="edit-data" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <?php foreach ($list_column as $kolom) : ?>
                            <?php if ($kolom[2] == 'hidden') : ?>
                                <input type="<?= $kolom[2] ?>" class="form-control" name="<?= $kolom[1] ?>" id="<?= $kolom[1] ?>_input">
                            <?php else : ?>
                                <div class="form-group row">
                                    <label for="<?= $kolom[1] ?>_input" class="col-sm-4 col-form-label"><?= $kolom[0] ?></label>
                                    <div class="col-sm-7">
                                        <?php if ($kolom[2] == 'select') : ?>
                                            <select class="custom-select" name="<?= $kolom[1] ?>" id="<?= $kolom[1] ?>_input">
                                                <?php if ($kolom[1] == 'id_brand') : ?>
                                                    <option>Pilih Brand</option>
                                                <?php endif ?>
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
                        <button type="button" id="batal" class="btn btn-sm btn-danger" data-dismiss="modal">
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
<!-- end:: modal -->

<script>
    function cek_input(item, teks, itemId) {
        if (!item) {
            alert(`Maaf, ${teks} Tidak boleh kosong`)
            $(`#${itemId}_input`).focus();
            return false;
        }
        return true;
    }

    function edit_data(dataId) {
        var id = dataId
        $.ajax({
            method: 'POST',
            url: '<?= base_url() ?>digital_leads/wuling_master_status_followup/ambil',
            data: 'id=' + id,
            dataType: "json",
            success: function(data) {
                <?php foreach ($list_column as $kolom) : ?>
                    $('#<?= $kolom[1] ?>_input').val(data.<?= $kolom[1] ?>);
                <?php endforeach ?>
            }
        })
    }

    function hapus_data(dataId) {
        var id = dataId

        if (confirm("Anda yakin ingin menghapus data ini??")) {
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>digital_leads/wuling_master_status_followup/hapus",
                data: 'id=' + id,
                cache: false,
                success: function(data) {
                    result = JSON.parse(data)
                    alert(result);
                    location.reload();
                }
            });
        }
    }

    $('#simpan').click(function(e) {
        e.preventDefault();
        var string = $("#edit-data").serialize();

        var nama_status_fu = $('#nama_status_fu_input').val()
        if (cek_input(nama_status_fu, 'status_customer', 'nama_status_fu')) {
            if (confirm("Anda yakin ingin menyimpan data ini??")) {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url(); ?>digital_leads/wuling_master_status_followup/simpan",
                    data: string,
                    cache: false,
                    beforeSend: function(data) {
                        $('#simpan').prop('disabled', true)
                        $('#batal').prop('disabled', true)
                    },
                    success: function(data) {
                        result = JSON.parse(data)
                        if (result.status === true) {
                            alert(result.message);
                            location.reload();
                        } else {
                            alert(result.message);
                            $('#simpan').prop('disabled', false)
                            $('#batal').prop('disabled', false)
                        }
                    }
                });
            }
        }
    })

    $('#tambah').click(function() {
        $('#id_status_fu_input').val('')
        $('#nama_status_fu_input').val('')
    })

    $(document).ready(function() {
        $('#tabel-data').DataTable({
            responsive: true,
            serverSide: true,
            processing: true,
            order: [],
            ajax: {
                url: "<?= base_url() ?>digital_leads/wuling_master_status_followup/semua_data",
                type: 'POST',
            },
            columns: [{
                    data: "id_status_fu",
                    title: "No.",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'nama_status_fu',
                    title: 'Status',
                },
                {
                    data: null,
                    title: 'Aksi',
                    orderable: false,
                    searchable: false,
                    responsivePriority: -1,
                    render: function(data) {
                        const id_status = ['1', '6']
                        let btn_edit = ''
                        let btn_del = ''
                        if (!id_status.includes(data.id_status_fu)) {
                            btn_edit = `<button type="button" onclick="edit_data(${data.id_status_fu});" class="btn btn-info" data-toggle="modal" data-target="#modal"><i class="icon-ios-compose-outline"></i> Edit</button>`
                            btn_del = `<button type="button" onclick="hapus_data(${data.id_status_fu});" class="btn btn-danger"> Hapus</button>`
                        }

                        return `<div class="form-group mb-0">
                        <div class="btn-group btn-group-sm">
                        ${btn_edit}
                        ${btn_del}
                        </div></div>`;
                    },
                }
            ]
        });
    });
</script>