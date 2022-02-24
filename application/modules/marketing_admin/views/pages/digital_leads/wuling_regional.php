<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" id="title_profil"><?= $judul ?></h5>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                        <button type="button" id="tambah_data" class="btn btn-sm btn-success" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#view_modal_upload">
                            <i class="icon-plus" style="color: #fff;"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block pt-1">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="center span2">No</th>
                                    <th class="center span6">Regional</th>
                                    <th class="center span6">Nama Cabang</th>
                                    <th class="center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $data = $this->db_wuling->query("SELECT * FROM regional GROUP BY regional ORDER BY regional ASC");
                                $no = 1;
                                foreach ($data->result() as $dt) {
                                    $data2 = $this->db_wuling->query("SELECT * FROM regional WHERE regional = '$dt->regional'");
                                    $num_rows = $data2->num_rows();
                                ?>
                                    <tr>
                                        <td style="vertical-align:middle; text-align:center; width:5%;" rowspan="<?php echo $num_rows; ?>"><?php echo $no++; ?></td>
                                        <td style="vertical-align:middle; text-align:center" rowspan="<?php echo $num_rows; ?>"><?php echo $dt->regional; ?></td>
                                        <?php
                                        foreach ($data2->result() as $dt2) {
                                            $id_pe['id_perusahaan'] = $dt2->id_perusahaan;
                                            $perusahaan = $this->db->select('lokasi')->get_where('perusahaan', $id_pe)->row()->lokasi;
                                        ?>
                                            <td><?php echo $perusahaan; ?></td>
                                            <td style="vertical-align:middle; text-align:center">
                                                <button type="button" id="ubah_data" data-id="<?= $dt2->id ?>" class="btn btn-sm btn-info" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#view_modal_upload">
                                                    <i class="icon-pencil icon-large icon-border"></i>
                                                </button>
                                                <button type="button" id="hapus_data" data-id="<?= $dt2->id ?>" class="btn btn-sm btn-danger" data-keyboard="false">
                                                    <i class="icon-trash icon-large icon-border"></i>
                                                </button>
                                            </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($num_rows == 0) { ?>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</section>

<!-- begin:: modal -->
<div class="modal fade text-xs-left" id="view_modal_upload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <label class="modal-title text-text-bold-600" id="judul_modal">Tambah Data Regional</label>
            </div>
            <div style="margin-top: 10px; text-align: center" id='load-modal'>
                <h4>... Load Data ...</h4>
            </div>
            <form action="<?php echo base_url(); ?>digital_leads/wuling_digital_leads/simpan_regional" id="tambah-data">

                <input type="hidden" name="inp_id" id="inp_id" class="my-form">

                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Regional</label>
                        <input type="text" name="nama_regional" id="nama_regional" class="form-control" placeholder="Masukkan Nama Regional">
                    </div>
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="center span1">No</th>
                                <th class="center">Nama Cabang</th>
                                <th class="center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="show_data_tambah">
                            <?php
                            $data = $this->db->query("SELECT * FROM kmg.perusahaan a WHERE NOT EXISTS (SELECT * FROM db_wuling.regional b WHERE a.id_perusahaan = b.id_perusahaan) AND a.id_brand = '5'");
                            $no = 1;
                            foreach ($data->result() as $dt) {
                            ?>
                                <tr>
                                    <td class="center"><?php echo  $no++; ?></td>
                                    <td class="center"><?php echo  $dt->lokasi; ?></td>
                                    <td class="center"><input type="checkbox" class="my-form" name="pilih_cabang[]" id="pilih_cabang" value="<?php echo $dt->id_perusahaan; ?>"><span class="lbl"></span></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                        <tbody id="show_data_ubah">
                            <?php
                            $data = $this->db->select("id_perusahaan, lokasi")->get_where("perusahaan", "id_brand = '5'");
                            $no = 1;
                            foreach ($data->result() as $dt) {
                            ?>
                                <tr>
                                    <td class="center"><?php echo  $no++; ?></td>
                                    <td class="center"><?php echo  $dt->lokasi; ?></td>
                                    <td class="center"><input type="checkbox" class="my-form" name="pilih_cabang[]" id="pilih_cabang" value="<?php echo $dt->id_perusahaan; ?>"><span class="lbl"></span></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
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
            </form>
        </div>
    </div>
</div>
<!-- end:: modal -->

<script>
    // untuk tambah data
    var untukTambahData = function() {
        $("#tambah_data").click(function() {

            $('#judul_modal').html('Tambah Data Regional');
            $("#id").val('');
            $("#nama_regional").val('');
            $('input[name="pilih_cabang[]"]').prop('checked', false);
            $('#show_data_ubah').attr('style', 'display: none;');
            $('#show_data_tambah').removeAttr('style');

            $.ajax({
                beforeSend: function() {
                    $('#load-modal').show();
                    $('.modal-body').hide();
                },
                success: function(data) {
                    $('#load-modal').hide();
                    $('.modal-body').show();
                }
            })
        })
    }();

    // untuk proses simpan data
    var untukSimpanData = function() {
        $(document).on('submit', '#tambah-data', function(e) {
            e.preventDefault();

            var ini = $(this);

            var regional = $('#nama_regional').val();
            var cek_list = [];
            $(':checkbox:checked').each(function(i) {
                cek_list[i] = $(this).val()
            });

            if (regional.length == 0) {
                $('#nama_regional').attr('style', 'border: 1px solid red');
                return false;
            }
            if (cek_list.length === 0) {
                alert('Anda Belum Memilih Cabang');
                return false;
            }

            $.ajax({
                method: 'POST',
                url: ini.attr('action'),
                data: ini.serialize(),
                dataType: 'text',
                beforeSend: function() {
                    $('#batal').attr('disabled', 'disabled');
                    $('#batal').html('<i class="icon-repeat2"></i> Tunggu...');

                    $('#simpan').attr('disabled', 'disabled');
                    $('#simpan').html('<i class="icon-repeat2"></i> Tunggu...');
                },
                success: function(data) {
                    alert(data);
                    location.reload();
                }
            })
        });
    }();

    // untuk ubah data
    var untukUbahData = function() {
        $(document).on('click', '#ubah_data', function() {
            var ini = $(this);

            $('#judul_modal').html('Ubah Data Regional');
            $('input[name="pilih_cabang[]"]').prop('checked', false);
            $('#show_data_tambah').attr('style', 'display: none;');
            $('#show_data_ubah').removeAttr('style');

            $.ajax({
                type: "GET",
                url: "<?php echo site_url(); ?>digital_leads/wuling_digital_leads/cek_regional",
                dataType: 'json',
                data: {
                    id: ini.data('id')
                },
                beforeSend: function() {
                    $('#load-modal').show();
                    $('.modal-body').hide();
                },
                success: function(data) {
                    $('#load-modal').hide();
                    $('.modal-body').show();
                    $('#inp_id').val(data.id);
                    $('#nama_regional').val(data.regional);
                    $("input[name='pilih_cabang[]'][value='" + data.id_perusahaan + "']").prop('checked', true);
                }
            });
        });
    }();

    // untuk hapus data
    var untukHapusData = function() {
        $(document).on('click', '#hapus_data', function() {
            var ini = $(this);

            if (confirm("Apakah Anda yakin ingin menghapusnya?")) {
                $.ajax({
                    type: "post",
                    url: "<?= base_url() ?>digital_leads/wuling_digital_leads/hapus_regional",
                    dataType: 'text',
                    data: {
                        id: ini.data('id')
                    },
                    beforeSend: function() {
                        ini.html('<i class="icon-repeat2"></i>');
                    },
                    success: function(data) {
                        alert(data);
                        location.reload();
                    }
                });
            } else {
                return false;
            }
        });
    }();
</script>