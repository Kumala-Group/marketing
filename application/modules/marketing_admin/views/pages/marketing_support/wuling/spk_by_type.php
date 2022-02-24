<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card" style="border: 0;box-shadow: none;">
                <div class="card-header">
                    <h5 class="card-title mb-1">Data SPK by Type</h5>
                    <form id="form" class="form-inline">
                        <div class="form-group mb-1">
                            <select id="perusahaan" name="perusahaan" class="form-control" required>
                                <option value="" selected disabled>-- Silahkan Pilih Cabang --</option>
                                <?php foreach ($lokasi as $v) : ?>
                                    <option value="<?= $v->id_perusahaan ?>"><?= "$v->singkat - $v->lokasi" ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group mb-1">
                            <select id="bulan" name="bulan" class="form-control" required>
                                <option value="" selected disabled>-- Silahkan Pilih Bulan --</option>
                                <?php $bulan = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                                foreach ($bulan as $i => $v) : ?>
                                    <option value="<?= $i < 10 ? "0$i" : $i ?>"><?= $v ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group mb-1">
                            <select id="tahun" name="tahun" class="form-control" required>
                                <option value="" selected disabled>-- Silahkan Pilih Tahun --</option>
                                <?php for ($i = date('Y'); $i >= 2017; $i--) : ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor ?>
                            </select>
                        </div>
                        <input type="hidden" name="load" value="true">
                        <div class="form-group mb-1">
                            <button id="submit" name="submit" class="btn btn-info">
                                <i class="icon-ios-eye"></i> Lihat
                            </button>
                        </div>
                    </form>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block p-0">
                        <div class="form-body">
                            <div id="load" class="pt-1"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $('body').addClass('bg-white');
    var form = $('#form');
    $('#submit').click(function(e) {
        e.preventDefault();
        var data = form.serialize();
        if (form.valid()) {
            $('#load').children().remove();
            loading();
            $.post(location, data, function(r) {
                $('.card').addClass('card-fullscreen');
                $('#load').html(r);
                reload();
            });
        }
    });
</script>