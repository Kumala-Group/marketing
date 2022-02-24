<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_profil">Tambah Area Event</h5>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block pt-1">
                        <form id="form" class="form">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group mb-1">
                                            <input type="text" id="event_area" name="event_area" class="form-control" placeholder="Area Event" required>
                                        </div>
                                        <input type="hidden" id="id" name="id">
                                        <input type="hidden" name="simpan" value="true">
                                        <div class="form-actions right">
                                            <a href="" class="btn btn-warning mr-1">
                                                <i class="icon-reload"></i> Reset
                                            </a>
                                            <button id="submit" class="btn btn-primary" disabled>
                                                <i class="icon-check2"></i> Simpan
                                            </button>
                                        </div>

                                    </div>
                                    <div class="col-md-9">
                                        <div class="table-responsive">
                                            <table class="table table-sm" id="datatable" width="100%"></table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    var datatable = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        order: [],
        responsive: true,
        ajax: {
            type: 'post',
            url: location,
            data: {
                'datatable': true
            }
        },
        columns: [{
            data: 'event_area',
            title: 'Area',
        }, {
            data: null,
            title: 'Aksi',
            orderable: false,
            searchable: false,
            render: function(r) {
                return `<div class="form-group mb-0">
                                    <div class="btn-group btn-group-sm">
                                    <button type="button" onclick="edit_data(` + r.id_event_area + `);" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button>
                                    <button type="button" onclick="hapus_data(` + r.id_event_area + `,'` + r.event_area + `');" class="btn btn-danger"><i class="icon-ios-trash-outline"></i></button>
                                    </div></div>`;
            },
        }],
    });
    $("#event_area").keyup(function() {
        $('#submit').removeAttr('disabled');
    });
    var form = $('#form');
    $('#submit').click(function(e) {
        e.preventDefault();
        var data = form.serialize();
        if (form.valid()) {
            loading();
            $.post(location, data, function(r) {
                if (r == 1) swal("", "Data berhasil disimpan!", "success").then(function() {
                    reload();
                    datatable.draw(false);
                });
                else if (r == 2) swal("", "Data berhasil diupdate!", "success").then(function() {
                    reload();
                    datatable.draw(false);
                });
                else swal("", "Data gagal disimpan!", "error").then(function() {
                    unload();
                });
            });
        }
    });

    function edit_data(id) {
        $('#form').trigger('reset');
        $('#title_profil').html("Edit Area Event");
        $('#id').val(id);
        $('#submit').removeAttr('disabled');
        $('#submit').html('<i class="icon-check2"></i> Update');
        $('input').eq(0).focus();
        $.post(location, {
                'edit': true,
                'id': id
            }, function(r) {
                $('#event_area').val(r.event_area);
            },
            "json"
        );
    }

    function hapus_data(id, data) {
        swal({
            title: "Apakah anda yakin?",
            text: "Anda akan menghapus data " + data + "!",
            icon: "warning",
            buttons: true
        }).then((ok) => {
            if (ok) {
                $.post(location, {
                    'hapus': true,
                    'id': id
                }, function(r) {
                    if (r == 1) swal("", "Data berhasil dihapus!", "success").then(function() {
                        reload();
                        datatable.draw(false);
                    });
                    else swal("", "Data sedang digunakan!", "error");
                });
            }
        });
    }
</script>