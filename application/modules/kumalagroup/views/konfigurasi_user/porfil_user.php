<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_profil">Tambah Profil</h5>
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
                                            <input type="text" id="nama_level" name="nama_level" value="<?= $edit_data_profil['nama_level'] ?>" class="form-control" placeholder="Nama Profil" required>
                                        </div>
                                        <div class="form-group mb-1">
                                            <input type="text" id="level" name="level" value="<?= $edit_data_profil['level'] ?>" class="form-control" placeholder="Kode Profil" required>
                                        </div>
                                        <div class="form-group mb-1">
                                            <textarea id="deskripsi" name="deskripsi" rows="2" class="form-control" placeholder="Deskripsi"><?= $edit_data_profil['deskripsi'] ?> </textarea>
                                        </div>

                                        <input type="hidden" id="id_profil" name="id_profil" value="<?= $edit_data_profil['id_profil'] ?>">
                                        <input type="hidden" id="akses_menu" name="akses_menu">
                                        <div class="form-actions right">
                                            <a href="" class="btn btn-warning mr-1">
                                                <i class="icon-reload"></i> Reset
                                            </a>
                                            <button id="submit" class="btn btn-primary">
                                                <i class="icon-check2"></i> Simpan
                                            </button>
                                        </div>

                                    </div>
                                    <div class="col-md-9">
                                        <div class="table-responsive">
                                            <table class="table table-sm table_aplikasi">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Profil</th>
                                                        <th>Kode Profil</th>
                                                        <th>Deskripsi</th>
                                                        <th>Akses URL</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($data_profil as $dt) { ?>
                                                        <tr>
                                                            <td><?= $dt->nama_level ?></td>
                                                            <td><?= $dt->level ?></td>
                                                            <td><?= $dt->deskripsi ?></td>
                                                            <td><?= $dt->url ?></td>
                                                            <td>
                                                                <div class="form-group mb-0">
                                                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                        <a href="<?= base_url(); ?>kumalagroup_user_profil/edit?id=<?= $dt->id ?>" class="btn btn-info"><i class="icon-ios-compose-outline"></i></a>
                                                                        <!-- <button type="button" onclick="edit_data('< ?= $dt->id ?>', ' < ?= $dt->nama_level ?>','< ?= $dt->level ?>','< ?= $dt->deskripsi ?>', );" class="btn btn-info"><i class="icon-ios-compose-outline"></i></button> -->

                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="card-header">
                                    </div>
                                    <br>
                                    <h5 class="card-title" style="text-align: center;">Hak Akses Menu</h5>
                                    <div class="col-md-4">
                                        <h6 class="card-title m-0">Manajemen Aplikasi</h6>
                                        <div id="m_a">
                                            <ul>
                                                <?php
                                                // foreach ($data_profil as $row) {
                                                $akses_menu = explode(",", $edit_data_profil['url']);
                                                // }

                                                echo open_parent_head_edit('', 'Manajemen Sistem');
                                                echo child_edit($akses_menu, 'Konfigurasi User', 'konfigurasi_user', '', '');
                                                echo child_edit($akses_menu, 'User Profil', 'user_profil', '', '');
                                                echo close_parent_head_edit();
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="card-title m-0">Audit</h6>
                                        <div id="audit">
                                            <ul>
                                                <?php
                                                // echo child_edit($akses_menu, "<strong>HINO (Header)</strong>", "hino", "");
                                                echo open_parent_head_edit('', 'Kasir');

                                                echo open_parent_head_edit_1('Bank Penerimaan');
                                                echo child_edit($akses_menu, "Unit", "bank_penerimaan_unit", "");
                                                echo child_edit($akses_menu, "After Sale", "bank_penerimaan_after_sales", "");
                                                echo child_edit($akses_menu, "Operational", "bank_penerimaan_operational", "");
                                                echo close_parent_head_edit_1();

                                                echo open_parent_head_edit_1('Bank Pengerluaran');
                                                echo child_edit($akses_menu, "Unit", "bank_pengeluaran_unit", "");
                                                echo child_edit($akses_menu, "After Sale", "bank_pengeluaran_after_sales", "");
                                                echo child_edit($akses_menu, "Operational", "bank_pengeluaran_operational", "");
                                                echo close_parent_head_edit_1();

                                                echo open_parent_head_edit_1('Kas Penerimaan');
                                                echo child_edit($akses_menu, "Unit", "kas_penerimaan_unit", "");
                                                echo child_edit($akses_menu, "After Sale", "kas_penerimaan_after_sales", "");

                                                echo close_parent_head_edit_1();

                                                echo open_parent_head_edit_1('Kas Pengerluaran');
                                                echo child_edit($akses_menu, "Unit", "kas_pengeluaran_unit", "");
                                                echo child_edit($akses_menu, "After Sale", "kas_pengeluaran_after_sales", "");
                                                echo close_parent_head_edit_1();
                                                echo open_parent_head_edit_1('Piutang & Aging');
                                                echo child_edit($akses_menu, "Detail Pembayaran SPK", "detail_pembayaran_spk", "");
                                                echo child_edit($akses_menu, "Kartu piutang Invoice", "kartu_piutang_invoice", "");
                                                echo child_edit($akses_menu, "Aging Schedule", "aging_schedule", "");
                                                echo close_parent_head_edit_1();

                                                echo close_parent_head_edit();

                                                echo child_edit($akses_menu, "Data SPK", "kumalagroup_audit_data_spk", "");
                                                echo child_edit($akses_menu, "Data DO", "kumalagroup_audit_data_do", "");
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="card-title m-0">Probid</h6>
                                        <div id="probid">
                                            <ul>
                                                <?php
                                                // echo child_edit($akses_menu, "<strong>HINO (Header)</strong>", "hino", "");
                                                echo open_parent_head_edit('', 'Probid');
                                                echo child_edit($akses_menu, "Dashboard Biaya", "dashboard_biaya", "");
                                                echo child_edit($akses_menu, "Master Biaya", "master_biaya", "");
                                                echo child_edit($akses_menu, "Daftar Biaya", "daftar_biaya", "");
                                                echo child_edit($akses_menu, "Laporan Biaya", "laporan_biaya", "");
                                                echo close_parent_head_edit();
                                                ?>
                                            </ul>
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
    $("#nama_level").keyup(function() {
        $('#submit').removeAttr('disabled');
    });

    var akses = [];
    $('#submit').click(function(e) {
        var data = $('#form').serialize();
        e.preventDefault();
        loading();
        $.post("<?= base_url(); ?>kumalagroup_user_profil/simpan", data,
            function(data) {
                if (data == 'data_update') {
                    swal("", "Data berhasil diupdate!", "success").then(function() {
                        location.reload();
                    });;
                }
                if (data == 'data_insert') {
                    swal("", "Data berhasil disimpan!", "success").then(function() {
                        location.reload();
                    });;
                }
            },

        );
    });


    // function edit_data(id) {
    //     console.log(id);
    //     $('#submit').removeAttr('disabled');
    //     // $('#id_profil').val(id);
    //     // $('#nama_level').val(nama_level);
    //     // $('#level').val(level);
    //     // $('#deskripsi').val(deskripsi);
    //     // $.post("url", id,
    //     //     function(data, textStatus, jqXHR) {

    //     //     },
    //     //     "dataType"
    //     // );

    // }


    //pemanggilan js tree
    $('#m_a').jstree({
        "checkbox": {
            "keep_selected_style": false
        },
        "plugins": ["checkbox"],
        "core": {
            "themes": {
                "icons": false
            }
        }
    });
    $('#audit').jstree({
        "checkbox": {
            "keep_selected_style": false
        },
        "plugins": ["checkbox"],
        "core": {
            "themes": {
                "icons": false
            }
        }
    });
    $('#probid').jstree({
        "checkbox": {
            "keep_selected_style": false
        },
        "plugins": ["checkbox"],
        "core": {
            "themes": {
                "icons": false
            }
        }
    });

    //function val change
    $('#m_a').on('changed.jstree', function(e, data) {
        nodesOnSelectedPath = [...data.selected.reduce(function(acc, nodeId) {
            var node = data.instance.get_node(nodeId);
            return new Set([...acc, ...node.parents, node.id]);
        }, new Set)];
        akses[0] = nodesOnSelectedPath.join(',');
        $('#akses_menu').val(akses.toString());

    });

    $('#audit').on('changed.jstree', function(e, data) {
        nodesOnSelectedPath = [...data.selected.reduce(function(acc, nodeId) {
            var node = data.instance.get_node(nodeId);
            return new Set([...acc, ...node.parents, node.id]);
        }, new Set)];
        akses[1] = nodesOnSelectedPath.join(',');
        $('#akses_menu').val(akses.toString());

    });

    $('#probid').on('changed.jstree', function(e, data) {
        nodesOnSelectedPath = [...data.selected.reduce(function(acc, nodeId) {
            var node = data.instance.get_node(nodeId);
            return new Set([...acc, ...node.parents, node.id]);
        }, new Set)];
        akses[2] = nodesOnSelectedPath.join(',');
        $('#akses_menu').val(akses.toString());

    });

    // function edit
    $('#m_a').jstree(true).open_all();
    $('li[data-checkstate="checked"]').each(function() {
        $('#m_a').jstree('check_node', $(this));
    });
    $('#m_a').jstree(true).close_all();

    $('#audit').jstree(true).open_all();
    $('li[data-checkstate="checked"]').each(function() {
        $('#audit').jstree('check_node', $(this));
    });
    $('#audit').jstree(true).close_all();

    $('#probid').jstree(true).open_all();
    $('li[data-checkstate="checked"]').each(function() {
        $('#probid').jstree('check_node', $(this));
    });
    $('#probid').jstree(true).close_all();
</script>