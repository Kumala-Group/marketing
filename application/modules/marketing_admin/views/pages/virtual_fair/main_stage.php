<?php
$date = explode(" ", $data->waktu);
?><section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_profil">Main Stage Virtual Fair</h5>
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
                                <div class="offset-md-3 col-md-6">
                                    <form id="form" class="form">
                                        <div class="form-group row mb-1">
                                            <label class="col-sm-3">Youtube Live</label>
                                            <div class="col-sm-9">
                                                <textarea id="live" name="live" class="form-control" placeholder="Link Youtube Live e.g https://www.youtube.com/embed/MSQhwpYQbtQ" required><?= $data->live ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-1">
                                            <label class="col-sm-3"></label>
                                            <div class="col-sm-9">
                                                <input type="checkbox" name="is_live" id="is_live" <?= $data->is_live == 0 ? '' : 'checked' ?>>
                                                <label> Publish Live</label>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-1">
                                            <label class="col-sm-3">Youtube Playlist</label>
                                            <div class="col-sm-9">
                                                <textarea id="playlist" name="playlist" class="form-control" placeholder="Link Youtube Playlist e.g https://www.youtube.com/embed/videoseries?list=OLAK5uy_kV6avNF4vnzPvVHXaWRjY9M40lGcwvZPc" rows="4" required><?= $data->playlist ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-1">
                                            <label class="col-sm-3">Link Invitation Zoom</label>
                                            <div class="col-sm-9">
                                                <textarea id="link_zoom" name="link_zoom" class="form-control" placeholder="Link Zoom e.g https://us02web.zoom.us/j/8246320399?pwd=WTRHUklCVHNFZ2p2bHpjb0JBOWRhdz09" rows="4" required><?= $data->link_zoom ?></textarea>
                                                <input type="text" id="meeting_id" name="meeting_id" class="form-control mt-1" placeholder="Meeting ID" required value="<?= $data->meeting_id ?>">
                                                <input type="text" id="passcode" name="passcode" class="form-control mt-1" placeholder="Passcode" required value="<?= $data->passcode ?>">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control mt-1" name="tanggal" id="tanggal" placeholder="Tanggal" autocomplete="off" required readonly value="<?= tgl_sql($date[0]) ?>" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="time" name="waktu" id="waktu" class="form-control mt-1" placeholder="Waktu" required style="padding: 5px;" value="<?= $date[1] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-1">
                                            <label class="col-sm-3"></label>
                                            <div class="col-sm-9">
                                                <input type="checkbox" name="is_zoom" id="is_zoom" <?= $data->is_zoom == 0 ? '' : 'checked' ?>>
                                                <label> Publish Link</label>
                                            </div>
                                        </div>
                                        <input type="hidden" name="main_stage" value="true">
                                        <div class="form-actions center">
                                            <button id="submit" class="btn btn-primary">
                                                <i class="icon-check2"></i> Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="card-title">Rundown</h5>
                                    <form id="formRundown" class="form">
                                        <div class="form-group mb-1"><button class="btn btn-success btn-sm" id="tambah">Tambah</button></div>
                                        <div id="rundown" class="row"></div>
                                        <div class="form-actions center">
                                            <button id="submitRundown" class="btn btn-primary">
                                                <i class="icon-check2"></i> Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $('#submit').click(function(e) {
        var form = $('#form');
        e.preventDefault();
        var data = form.serialize();
        if (form.valid()) {
            $(this).attr('disabled', true);
            $.post(location, data, function(r) {
                $('#submit').attr('disabled', false);
                alert(r.msg);
            }, 'json');
        }
    });

    $('#is_live').click(function() {
        var data = $(this).is(':checked') ? 1 : 0;
        $(this).attr('disabled', true);
        $.post(location, {
            publish: true,
            data: data
        }, function(r) {
            $('#is_live').attr('disabled', false);
            alert(r.msg);
        }, 'json');
    });

    $('#is_zoom').click(function() {
        var data = $(this).is(':checked') ? 1 : 0;
        $(this).attr('disabled', true);
        $.post(location, {
            zoom: true,
            data: data
        }, function(r) {
            $('#is_zoom').attr('disabled', false);
            alert(r.msg);
        }, 'json');
    });

    var i = 0;
    $('#tambah').click(function(e) {
        e.preventDefault();
        html = `<div class="col-md-6 col-lg-4">
            <div class="form-group mb-1">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form-control tanggal mt-1" name="tanggal` + i + `" placeholder="Tanggal" autocomplete="off" required readonly />
                    </div>
                    <div class="col-md-6">
                        <input type="time" name="waktu` + i + `" class="form-control waktu mt-1" placeholder="Waktu" required style="padding: 5px;">
                    </div>
                </div>
            </div>
            <div class="form-group mb-1">
                <input type="text" name="judul` + i + `" class="form-control judul" placeholder="Judul" required>
            </div>
            <input type="hidden" name="id" class="id">
            <div class="form-actions m-0 right"><button class="btn btn-danger btn-sm hapus">Hapus</button></div>
        </div>`;
        $('#rundown').append(html);
        $('.tanggal').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        });
        i++;
    });
    $('#rundown').on('click', '.hapus', function(e) {
        e.preventDefault();
        var id = $(this).closest('.col-lg-4').find('.id').val();
        if (id.length != 0) $.post(location, {
            'hapus': true,
            'id': id
        }, function(r) {
            alert(r.msg);
        }, "json");
        $(this).closest('.col-lg-4').remove();
        i--;
    });
    $('#submitRundown').click(function(e) {
        var formData = new FormData();
        var form = $('#formRundown');
        e.preventDefault();
        formData.append('rundown', true);
        $.each(form.find('.tanggal'), function(indexInArray, valueOfElement) {
            var id = $(this).closest('.col-lg-4').find('.id').val();
            var tanggal = $(this).val();
            var waktu = $(this).closest('.col-lg-4').find('.waktu').val();
            var judul = $(this).closest('.col-lg-4').find('.judul').val();
            formData.append('id[]', id);
            formData.append('tanggal[]', tanggal);
            formData.append('waktu[]', waktu);
            formData.append('judul[]', judul);
        });
        if (form.valid()) {
            $(this).attr('disabled', false);
            $.ajax({
                type: "post",
                url: location,
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(response) {
                    $('#submitRundown').attr('disabled', false);
                    alert(response.msg);
                    location.reload()
                }
            });
        }
    });
    $.post(location, {
            'getrundown': true
        },
        function(data, textStatus, jqXHR) {
            i = 0;
            $.each(data, function(indexInArray, valueOfElement) {
                html = `<div class="col-md-6 col-lg-4">
                    <div class="form-group mb-1">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control tanggal mt-1" name="tanggal` + i + `" placeholder="Tanggal" autocomplete="off" required readonly />
                            </div>
                            <div class="col-md-6">
                                <input type="time" name="waktu` + i + `" class="form-control waktu mt-1" placeholder="Waktu" required style="padding: 5px;">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-1">
                        <input type="text" name="judul` + i + `" class="form-control judul" placeholder="Judul" required>
                    </div>
                    <input type="hidden" name="id" class="id" value="` + valueOfElement.id + `">
                    <div class="form-actions m-0 right"><button class="btn btn-danger btn-sm hapus">Hapus</button></div>
                </div>`;
                $('#rundown').append(html);
                $('.tanggal').datepicker({
                    format: 'dd-mm-yyyy',
                    autoclose: true
                });
                $(`input[name="tanggal` + i + `"]`).datepicker(`update`, valueOfElement.tanggal);
                $(`input[name="waktu` + i + `"]`).val(valueOfElement.waktu);
                $(`input[name="judul` + i + `"]`).val(valueOfElement.judul);
                i++;
            });
        }, "json");
</script>