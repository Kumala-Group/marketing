<script type="text/javascript">
    $(document).ready(function() {
        $('.date-picker').datepicker({
            autoclose: true,
        }).next().on(ace.click_event, function() {
            $(this).prev().focus();
        });
        $("#tambah_detail").click(function() {
            var html = '';
            html += '<div class="controls" style="padding-top:5px;">';
            html +=
                '<input type="text" name="detail_versi_double[]" id="detail_versi_double[]" placeholder="Detail update" />';
            html +=
                '<a role="button" name="remove_detail" class="btn btn-small btn-danger remove_detail" style="margin-left:3px;"><center><i class="icon-remove icon-large"></i></center></a>';
            html += '</div>';
            $('#tambah_input_detail').append(html);
        });
        $(document).on('click', '.remove_detail', function() {
            $(this).closest('div').remove();
        });

        // EDIT DATA DETAIL
        $("#tambah_detail_edit").click(function() {
            var html = '';
            html += '<div class="controls" style="padding-top:5px;">';
            html +=
                '<input type="text" name="tambah_detail[]" id="tambah_detail[]" placeholder="Detail update" />';
            html +=
                '<a role="button" name="remove_detail_update" class="btn btn-small btn-danger remove_detail_update" style="margin-left:3px;"><center><i class="icon-remove icon-large"></i></center></a>';
            html += '</div>';
            $('#edit_input_detail').append(html);
        });

        $(document).on('click', '.remove_detail_update', function() {
            $(this).closest('div').remove();
        });

        // VALIDASI DATA
        function validasidata() {
            var tgl_update = $("#tgl_update").val();
            var update_versi = $("#update_versi").val();
            var detail_versi = $("#detail_versi").val();

            if (tgl_update.length == 0) {
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Tanggal update tidak boleh kosong.',
                    class_name: 'gritter-error'
                });

                $("#tgl_update").focus();
                return false();
            }

            if (update_versi.length == 0) {
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Versi update tidak boleh kosong.',
                    class_name: 'gritter-error'
                });

                $("#update_versi").focus();
                return false();
            }

            // if (detail_versi.length == 0) {
            //     $.gritter.add({
            //         title: 'Peringatan..!!',
            //         text: 'Detail Versi update tidak boleh kosong.',
            //         class_name: 'gritter-error'
            //     });
            //     $("#detail_versi").focus();
            //     return false();
            // }
        }

        $("#simpan").click(function() {
            validasidata();
            var string = $("#my-form").serialize();
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>hd_adm_update_cps/simpan",
                data: string,
                cache: false,
                start: $("#simpan").html('...Sedang diproses...'),
                success: function(data) {
                    $("#simpan").html('<i class="icon-save"></i> Simpan');
                    alert(data);
                    location.reload();
                }
            });
        })
        $("#tambah").click(function() {
            $("#tgl_update").val('');
            $("#update_versi").val('');
            $("#detail_versi").val('');
        })

        $("#simpan_detail").click(function() {
            var string = $("#my-form-detail").serialize();
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>hd_adm_update_cps/simpan_detail_update",
                data: string,
                cache: false,
                start: $("#simpan_detail").html('...Sedang diproses...'),
                success: function(data) {
                    $("#simpan_detail").html('<i class="icon-save"></i> Simpan');
                    alert(data);
                    location.reload();
                }
            });
        })

    })

    function hapus_data(ID, ID_VERSI, NO_URUT) {
        var id = ID;
        var id_versi = ID_VERSI;
        var no_urut = NO_URUT;
        var validasi_hapus = confirm("Yakin ingin menghapus data...?");
        if (validasi_hapus == true) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(); ?>hd_adm_update_cps/hapus_data",
                data: {
                    id: id,
                    id_versi: id_versi,
                    no_urut: no_urut
                },
                success: function(data) {

                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url(); ?>hd_adm_update_cps/delete_update",
                        data: {
                            id: id,
                            id_versi: id_versi,
                            no_urut: no_urut
                        },
                        success: function(data) {
                            alert(data);
                            location.reload();
                        }
                    });
                }
            });
        } else {
            location.reload();
        }
    }

    function edit_data(id, id_versi) {
        var id = id;
        var id_versi = id_versi;

        $.ajax({
            type: "get",
            url: "<?php echo site_url(); ?>hd_adm_update_cps/cari_data",
            data: {
                id: id,
                id_versi: id_versi
            },
            dataType: 'json',
            success: function(data) {
                $("#tgl_update_edit").val(data.tgl_update);
                $('#update_versi_edit').val(data.versi_update);
                $('#edit_input_detail').html(data.detail_versi);
                $('#id').val(data.id);
                $('#id_versi').val(data.id_versi);
                $('#no_urut').val(data.no_urut);
            }
        });
    }
</script>
<div class="row-fluid">
    <div class="table-header">
        <?php echo $judul; ?>
        <div class="widget-toolbar no-border pull-right">
            <a href="#modal-tambah" class="btn btn-small btn-success" role="button" data-toggle="modal" name="tambah" id="tambah">
                <i class="icon-check"></i>
                Tambah Data
            </a>
        </div>
    </div>
    <table class="table lcnp table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="center span1">No</th>
                <th class="center span2">Tgl Update</th>
                <th class="center span2">Update Versi</th>
                <th class="center">Detail Update</th>
                <th class="center span2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($data->result() as $dt) {
                $detail_data = $this->db_helpdesk->query("SELECT * FROM update_versi_detail WHERE id_versi = '$dt->id_versi'");
                $count = $detail_data->num_rows();
                $rowspan = $count + 1;
                ?>
                <tr>
                    <td style="vertical-align:middle; text-align:center" rowspan="<?php echo $rowspan; ?>"><?php echo $no++ ?></td>
                    <td style="vertical-align:middle; text-align:center" rowspan="<?php echo $rowspan; ?>"><?php echo tgl_sql($dt->tgl_update); ?></td>
                    <td style="vertical-align:middle; text-align:center" rowspan="<?php echo $rowspan; ?>"><?php echo $dt->versi_update; ?></td>
                </tr>
                <?php
                    for ($i = 0; $i < $count; $i++) {
                        $detail = $this->db_helpdesk->query("SELECT * FROM update_versi_detail WHERE id_versi = '$dt->id_versi' AND no_urut = '$i'");
                        ?>
                    <tr>
                        <?php
                                foreach ($detail->result() as $td) {
                                    ?>
                            <td><?php echo $td->detail_versi; ?></td>
                            <td style="vertical-align:middle; text-align:center">
                                <a style="text-decoration:none; margin-right:5px;" class="green" title="Edit data" href="#edit_data" onclick="javascript:edit_data('<?php echo $td->id; ?>','<?php echo $dt->id_versi; ?>')" data-toggle="modal"><i class="icon-pencil icon-large icon-border"></i></a>
                                <a style="text-decoration:none;" class="red" title="Hapus No. SPK" href="#" onclick="javascript:hapus_data('<?php echo $td->id; ?>','<?php echo $td->id_versi; ?>','<?php echo $td->no_urut; ?>')"><i class="icon-trash icon-large icon-border"></i></a>
                            </td>
                        <?php
                                }
                                ?>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>

<div id="modal-tambah" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Tambah data versi update
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
                <input type="hidden" name="id_update_versi" id="id_update_versi">
                <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Tanggal Update</label>
                    <div class="controls">
                        <span class="input-append">
                            <input type="text" name="tgl_update" id="tgl_update" class="date-picker" placeholder="Tanggal update" data-date-format="dd-mm-yyyy" />
                            <span class="add-on"><i class="icon-calendar"></i></span>
                        </span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-field-1">Update Version</label>
                    <div class="controls">
                        <input type="text" name="update_versi" id="update_versi" placeholder="Versi update" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Detail Update</label>
                    <div class="controls">
                        <a class="btn btn-small btn-success" role="button" name="tambah_detail" id="tambah_detail">
                            <center><i class="icon-plus icon-large"></i></center>
                        </a>
                    </div>
                    <div id="tambah_input_detail"></div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-footer">
        <div class="pagination pull-right no-margin">
            <button type="button" class="btn btn-small btn-danger pull-left" data-dismiss="modal">
                <i class="icon-remove"></i>
                Close
            </button>
            <button type="button" name="simpan" id="simpan" class="btn btn-small btn-success pull-left">
                <i class="icon-save"></i>
                Simpan
            </button>
        </div>
    </div>
</div>

<!-- MODAL EDIT DATA -->
<div id="edit_data" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Edit/Hapus/Tambah data update versi
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form-detail" id="my-form-detail">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="id_versi" id="id_versi">
                <input type="hidden" name="no_urut" id="no_urut">
                <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Tanggal Update</label>
                    <div class="controls">
                        <span class="input-append">
                            <input type="text" name="tgl_update_edit" id="tgl_update_edit" class="date-picker" placeholder="Tanggal update" data-date-format="dd-mm-yyyy" />
                            <span class="add-on"><i class="icon-calendar"></i></span>
                        </span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-field-1">Update Version</label>
                    <div class="controls">
                        <input type="text" name="update_versi_edit" id="update_versi_edit" placeholder="Versi update" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Detail Update</label>
                    <div class="controls">
                        <a class="btn btn-small btn-success" role="button" name="tambah_detail_edit" id="tambah_detail_edit">
                            <center><i class="icon-plus icon-large"></i></center>
                        </a>
                    </div>
                    <div id="edit_input_detail"></div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-footer">
        <div class="pagination pull-right no-margin">
            <button type="button" class="btn btn-small btn-danger pull-left" data-dismiss="modal">
                <i class="icon-remove"></i>
                Close
            </button>
            <button type="button" name="simpan_detail" id="simpan_detail" class="btn btn-small btn-success pull-left">
                <i class="icon-save"></i>
                Simpan
            </button>
        </div>
    </div>
</div>