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
                                                <?php if ($kolom[1] == 'id_perusahaan') : ?>
                                                    <option>Pilih Cabang</option>
                                                <?php endif ?>
                                                <?php if ($kolom[1] == 'id_sales') : ?>
                                                    <option>Pilih Sales</option>
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
            url: '<?= base_url() ?>digital_leads/wuling_master_sales_digital/ambil',
            data: 'id=' + id,
            dataType: "json",
            success: function(data) {
                <?php foreach ($list_column as $kolom) : ?>
                    $('#<?= $kolom[1] ?>_input').val(data.<?= $kolom[1] ?>);
                <?php endforeach ?>
                input_cabang(data.id_perusahaan)
                input_sales(data.id_sales)
            }
        })
    }

    var input_sales = function(dataSales = '') {
        var input_container = document.getElementById('id_sales_input')
        input_container.innerHTML = '<option>Pilih Sales</option>'
        $.ajax({
            method: 'POST',
            url: '<?= base_url() ?>digital_leads/wuling_master_sales_digital/daftar_sales',
            dataType: "json",
            success: function(data) {
                data.forEach(sales => {
                    var opsi = document.createElement('option')
                    opsi.textContent = sales.nama_lengkap;
                    opsi.setAttribute('value', sales.id)
                    if (dataSales == sales.id) opsi.setAttribute('selected', 'selected')
                    input_container.appendChild(opsi);
                });
            }
        })
    }

    function input_cabang(dataCabang = '') {
        $('#pilih_cabang').remove()
        var input_container = document.getElementById('id_perusahaan_input')
        input_container.setAttribute("name", "id_perusahaan");
        input_container.disabled = false
        input_container.innerHTML = '<option>Pilih Cabang</option>'
        $.ajax({
            method: 'POST',
            url: '<?= base_url() ?>digital_leads/wuling_master_sales_digital/daftar_cabang',
            dataType: "json",
            success: function(data) {
                data.forEach(cabang => {
                    var opsi = document.createElement('option')
                    opsi.textContent = cabang.lokasi;
                    opsi.setAttribute('value', cabang.id_perusahaan)
                    opsi.setAttribute('class', 'cabang')
                    if (dataCabang == cabang.id_perusahaan) opsi.setAttribute('selected', 'selected')
                    input_container.appendChild(opsi);
                });
                if (dataCabang) {
                    input_container.disabled = true
                    input_container.setAttribute("name", "");
                    let input = document.createElement("input");
                    input.setAttribute("type", "hidden");
                    input.setAttribute("id", "pilih_cabang");
                    input.setAttribute("name", "id_perusahaan");
                    input.setAttribute("value", dataCabang);
                    $(input).insertAfter("#id_perusahaan_input");
                }
            }
        })
    }

    $('#simpan').click(function(e) {
        e.preventDefault();
        var string = $("#edit-data").serialize();

        var cabang = $('#id_perusahaan_input').val() !== "Pilih Cabang" ? $('#id_perusahaan_input').val() : ''
        var sales = $('#id_sales_input').val() !== "Pilih Sales" ? $('#id_sales_input').val() : ''
        if (
            cek_input(cabang, 'Cabang', 'id_perusahaan') &&
            cek_input(sales, 'Sales', 'id_sales')
        ) {
            if (confirm("Anda yakin ingin menyimpan data ini??")) {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url(); ?>digital_leads/wuling_master_sales_digital/simpan",
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
        input_sales()
        input_cabang()
    })

    $(document).ready(function() {
        $('#tabel-data').DataTable({
            responsive: true,
            serverSide: true,
            processing: true,
            order: [],
            ajax: {
                url: "<?= base_url() ?>digital_leads/wuling_master_sales_digital/semua_data",
                type: 'POST',
            },
            columns: [{
                    data: "id",
                    title: "No.",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
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
                    data: null,
                    title: 'Ubah Coverage Cabang',
                    orderable: false,
                    searchable: false,
                    responsivePriority: -1,
                    render: function(data) {
                        return `<div class="form-group mb-0">
                    <div class="btn-group btn-group-sm">
                    <button type="button" onclick="edit_data(${data.id});" class="btn btn-info" data-toggle="modal" data-target="#modal"><i class="icon-ios-compose-outline"></i> Edit</button>
                    </div></div>`;
                    },
                }
            ]
        });
    });
</script>