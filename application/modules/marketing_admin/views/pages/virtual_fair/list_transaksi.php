<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_profil">List Transaksi</h5>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block pt-1">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form class="form-inline">
                                        <div class="form-group mb-1">
                                            <label for="">Brand : &nbsp;</label>
                                            <select id="brand" name="brand" class="form-control" required>
                                                <option value="" selected>-- Semua Brand --</option>
                                                <?php
                                                foreach ($brands as $key => $value) { ?>
                                                    <option value="<?= $value->id ?>"><?= ucwords($value->jenis) ?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </div>
                                        &nbsp;
                                        <div class="form-group mb-1">
                                            <label for="">Cabang : &nbsp;</label>
                                            <select id="cabang" name="cabang" class="form-control" required style="width:200px">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-1">
                                            <button class="btn btn-primary" id="filter">Filter</button>
                                        </div>
                                    </form>
                                    <div class="table-responsive">
                                        <table class="table table-sm" id="datatable" width="100%"></table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Detail Pembelian Unit</strong></h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-condensed text-center">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Brand</th>
                                <th>Model</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody id="bodyTableDetail"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var datatable = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        order: [],
        pageLength: 25,
        language: {
            search: 'No. Transaksi :'
        },
        ajax: {
            type: 'post',
            url: location,
            data: function(data) {
                data.getDatatable = true;
                data.brand = $('#brand').val();
                data.cabang = $('#cabang').val();
            }
        },
        columns: [{
            data: 'tanggal',
            title: 'Tanggal',
            orderable: false,
            searchable: false,
        }, {
            data: 'kodeCheckout',
            title: 'No. Transaksi',
            orderable: false,
        }, {
            data: 'nama',
            title: 'Customer',
            orderable: false,
            searchable: false,
        }, {
            data: 'detailRekening',
            title: 'Detail Rekening',
            orderable: false,
            searchable: false,
        }, {
            data: null,
            title: 'Uang Tanda Jadi',
            orderable: false,
            searchable: false,
            render: function(r) {
                var uangMuka = '';
                if (r.uangMuka != r.potongan) {
                    uangMuka = `<strike class="text-danger">` + r.uangMuka + `</strike> `
                }
                return uangMuka + r.potongan;
            },
        }, {
            data: 'cabangTujuan',
            title: 'Cabang Tujuan',
            orderable: false,
            searchable: false,
        }, {
            data: null,
            title: 'Bukti Bayar',
            orderable: false,
            searchable: false,
            render: function(r) {
                return `<a href="<?= $imgServer ?>assets/img_marketing/checkout/bukti/` + r.buktiBayar + `" target="_blank"
                class="btn btn-blue-grey btn-sm" style="color: #fff;">Lihat</a>`;
            },
        }, {
            data: null,
            title: 'Status',
            orderable: false,
            searchable: false,
            render: function(r) {
                var keterangan;
                if (r.status == 1) {
                    keterangan = `<a class="btn btn-warning btn-sm btn-block" style="color: #fff;">Belum diverifikasi</a>`;
                } else if (r.status == 2) {
                    keterangan = `<a class="btn btn-info btn-sm btn-block" style="color: #fff;">Terverifikasi</a>`;
                } else {
                    keterangan = `<a class="btn btn-danger btn-sm btn-block" style="color: #fff;">Tidak valid</a>`;
                }
                return `<div class="status" data-id="` + r.id + `" data-status="` + r.status + `">` + keterangan + `</div>`;
            },
        }, {
            data: null,
            title: '',
            orderable: false,
            searchable: false,
            render: function(r) {
                return `<button class="btn btn-primary btn-sm btn-block detail">Detail</button>`;
            },
        }, ],
    });
    $('#cabang').select2({
        placeholder: "-- Pilih cabang --",
    });

    if (localStorage.getItem('selectedBrand')) {
        $('#brand').val(localStorage.getItem('selectedBrand'));
        $('#cabang').empty().append(`<option value=""></option>`);
        $.post(location, {
            getCabang: true,
            brand: $('#brand option:selected').text()
        }, function(response) {
            $('#cabang').select2({
                data: response,
                placeholder: "-- Pilih cabang --",
                allowClear: true
            });
            $('#cabang').val(localStorage.getItem('selectedCabang')).trigger('change');
            datatable.draw()
        }, 'json');
    }

    $('#brand').on('change', function() {
        $('#cabang').empty().append(`<option value=""></option>`);
        $.post(location, {
            getCabang: true,
            brand: $('#brand option:selected').text()
        }, function(response) {
            $('#cabang').select2({
                data: response,
                placeholder: "-- Pilih cabang --",
                allowClear: true
            });
        }, 'json');
    })

    $('#filter').on('click', function(e) {
        e.preventDefault();
        localStorage.setItem('selectedBrand', $('#brand').val());
        localStorage.setItem('selectedCabang', $('#cabang').val());
        datatable.draw();
    })

    $('#datatable').on('click', 'a', function() {
        var img = $(this).find('img').attr('src');
        $('#default').find('img').attr('src', img);
    });
    var temp = [];
    $('#datatable').on('click', '.status', function() {
        $(this).removeClass('status');
        var n = $(this).data('status') == 1 ? 'selected' : '';
        var y = $(this).data('status') == 2 ? 'selected' : '';
        var z = $(this).data('status') == 3 ? 'selected' : '';
        var index = $(this).closest('tr').index();
        temp[index] = $(this).html();
        $(this).html(`
            <select class="form-control ubah_status mb-1" data-id="` + $(this).data('id') + `">
                <option value="1" ` + n + `>Belum diverifikasi</option>
                <option value="2" ` + y + `>Terverifikasi</option>
                <option value="3" ` + z + `>Tidak valid</option>
            </select>
            <button class="btn btn-danger btn-sm batal">Batal</button>
        `);
    });

    $('#datatable').on('change', '.ubah_status', async function() {
        var response = await $.post(location, {
            changeStatus: true,
            id: $(this).data('id'),
            value: $(this).val()
        });
        if (response.status == 'success') {
            location.reload();
        } else {
            alert(response.msg);
        }
    });

    $('#datatable').on('click', '.batal', function() {
        var parent = $(this).closest('tr');
        var index = parent.index();
        var container = parent.find('div');
        container.html(temp[index]);
        container.addClass('status');
    });

    $('#datatable').on('click', '.detail', async function() {
        $(this).html(`<i class="fa fa-spinner fa-spin"></i>`)
        $(this).prop('disabled', true)
        var response = await $.post(location, {
            detailPembelian: true,
            value: $(this).closest('tr')
                .find('td').eq(1).html()
        });
        $('#bodyTableDetail').children().remove();
        $.each(response, function(index, value) {
            var html = ` <tr>
                <td>` + (index + 1) + `</td>
                <td>` + value.brand + `</td>
                <td>` + value.model + `</td>
                <td>` + value.jumlah + `</td>
            </tr>`;
            $('#bodyTableDetail').append(html);
        });
        $(this).html('Detail')
        $(this).prop('disabled', false)
        $('#modalDetail').modal('show')
    })
</script>