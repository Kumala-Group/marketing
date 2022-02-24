<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_profil">Detail Unit Virtual Fair</h5>
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
                                            <label class="col-sm-3">Brand</label>
                                            <div class="col-sm-9">
                                                <select id="brand" name="brand" class="form-control" required>
                                                    <option value="" selected disabled>-- Silahkan Pilih Brand --</option>
                                                    <?php foreach ($brand as $v) : ?>
                                                        <option value="<?= $v->id ?>"><?= ucwords($v->jenis) ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-1">
                                            <label class="col-sm-3">Model</label>
                                            <div class="col-sm-9">
                                                <select id="model" name="model" class="form-control" required>
                                                    <option value="" selected disabled>-- Silahkan Pilih Model --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-1">
                                            <label class="col-sm-3">Video Test Drive</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="test_drive" id="test_drive" class="form-control" placeholder="Video Test Drive" required>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-1">
                                            <label class="col-sm-3">Interior</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="interior" id="interior" class="form-control" placeholder="Link embedded momento" required>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-1">
                                            <label class="col-sm-3">Exterior <small class="text-danger">*Maks 300kB</small></label>
                                            <div class="col-sm-9">
                                                <input type="file" id="exterior" name="exterior" class="form-control-file" multiple>
                                            </div>
                                        </div>
                                        <input type="hidden" name="id" id="id" value="">
                                        <div class="form-actions center">
                                            <button id="submit" class="btn btn-primary">
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
    $('#brand').change(function() {
        $('#test_drive').val('');
        $('#interior').val('');
        $.post(location, {
            loadModel: true,
            brand: $(this).val()
        }, function(r) {
            $('#model').html(r);
            $('#model').change(function() {
                $.post(location, {
                    loadDetail: true,
                    model: $(this).val()
                }, function(s) {
                    $('#test_drive').val(s == null ? '' : s[0].deskripsi);
                    $('#interior').val(s == null ? '' : s[1].deskripsi);
                }, "json");
            });
        });
    });
    $('#submit').click(function(e) {
        var breakout = false;
        e.preventDefault();
        if ($('#form').valid()) {
            var formData = new FormData();
            formData.append('simpan', true);
            formData.append('id', $('#id').val());
            $.each($('.form-body').find('.form-control'), function() {
                formData.append($(this).attr('id'), $(this).val());
            });
            var exterior_length = $('#exterior')[0].files.length;
            if (exterior_length != 0) {
                var allowed_types = ["jpg", "jpeg", "png"];
                for (var i = 0; i < exterior_length; i++) {
                    var exterior = $('#exterior')[0].files[i];
                    var ext = exterior.name.split(".").pop().toLowerCase();
                    formData.append('exterior[]', exterior);
                    if ($.inArray(ext, allowed_types) == -1) {
                        swal("", "Silahkan pilih file gambar!", "warning");
                        breakout = true;
                    }
                    if ($('#exterior')[0].files[0].size / 1048576 > 0.3) {
                        swal("", "Ukuran file melebihi 300kB!", "warning");
                        breakout = true;
                    }
                }
            }
            if (breakout) return false;
            else {
                $(this).attr('disabled', true);
                $.ajax({
                    type: 'post',
                    url: location,
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function(r) {
                        $('#submit').attr('disabled', false);
                        $('#form').trigger('reset');
                        alert(r.msg);
                    }
                });
            }
        }
    });
</script>