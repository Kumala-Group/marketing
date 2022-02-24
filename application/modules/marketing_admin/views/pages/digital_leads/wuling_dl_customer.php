<style>
    input[type=checkbox],
    input[type=radio] {
        opacity: 1;
        position: relative;
    }
</style>

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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="pilih_tanggal">Tanggal Pemilihan Customer</label>
                                    <input type="date" id="pilih_tanggal" class="form-control" name="dateopened" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Date Opened" data-original-title="" title="" aria-describedby="tooltip198912">
                                    <span class="red">* <h10>(wajib di isi)</h10></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-sm" id="table_customer_dt">
                                    </table>
                                </div>
                            </div>
                            <div align="center">
                                <button type="button" class="btn btn-sm btn-success" name="simpan_list" id="simpan_list">
                                    <i class="icon-save"></i>
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<script>
    var untukTabelDatatable = function() {
        $('#table_customer_dt').DataTable({
            responsive: true,
            serverSide: true,
            processing: true,
            order: [],
            ajax: {
                url: "<?= base_url() ?>digital_leads/wuling_digital_leads/customer/customer_dt",
                type: 'POST',
            },
            columns: [{
                    data: null,
                    title: 'No',
                    width: 35,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    data: 'komunikasi',
                    title: 'Komunikasi',
                },
                {
                    data: 'nama_leads',
                    title: 'Nama',
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
                    data: 'kontak',
                    title: 'No. Telepon',
                },
                {
                    data: null,
                    title: 'Status',
                    searchable: false,
                    render: function(data, type, full, meta) {
                        var status_k = ['', '', 'Lost'];
                        return (full.status == null) ? '' : status_k[full.status];
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
                            <input class="checkbox_pilih" type="checkbox" name="cek_list" id="cek_list" value="` + full.id_digital_leads + `">
                        `;
                    },
                }
            ]
        });
    }();

    var untukSimpanList = function() {
        $('#simpan_list').click(function(e) {
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
                alert('Anda Belum Memilih Costumer');
                return false;
            }

            if (confirm("Anda Yakin")) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>digital_leads/wuling_digital_leads/customer/simpan",
                    data: {
                        cek_list: cek_list,
                        'tanggal': tanggal,
                    },
                    beforeSend: function() {
                        $("#simpan_list").html("Loading...");
                        $("#simpan_list").prop('disabled', true);
                    },
                    success: function(response) {
                        $("#simpan_list").html("<i class='icon-save'></i>Simpan");
                        $("#simpan_list").prop('disabled', false);
                        alert("Data berhasil disimpan");
                        location.reload();
                    },
                });
            } else {
                return false;
            }
        });
    }();
</script>