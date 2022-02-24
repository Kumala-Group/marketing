<script type="text/javascript">
    $(document).ready(function() {
        $('.date-picker').datepicker().next().on(ace.click_event, function() {
            $(this).prev().focus();
        });
        $("#simpan").click(function() {

            var string = $("#my-form").serialize();




            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>hd_adm_kontrak/simpan",
                data: string,
                cache: false,
                start: $("#simpan").html('...Sedang diproses...'),
                success: function(data) {
                    $("#simpan").html('<i class="icon-save"></i> Simpan');
                    alert(data);
                    location.reload();
                }
            });

        });

        $("#tambah").click(function() {
            $('#id_kontrak').val('');
            $('#nama').val('');
        });
    });

    function editData(ID) {
        var cari = ID;
        console.log(cari);
        $.ajax({
            type: "GET",
            url: "<?php echo site_url(); ?>hd_adm_kontrak/cari",
            data: "cari=" + cari,
            dataType: "json",
            success: function(data) {
                $('#id_kontrak').val(data.id_kontrak);
                $('#cabang').val(data.id_perusahaan);
                $('#pic').val(data.pic);
                $('#jenis_kontrak').val(data.jenis_kontrak);
                $('#nama_kontrak').val(data.nama_kontrak);
                $('#tarif').val(data.tarif);
                $('#awal').val(data.awal);
                $('#akhir').val(data.akhir);
                $('#keterangan').val(data.keterangan);
            }
        });
    }

    function autoseparator(Num) { //function to add commas to textboxes
        Num += '';
        Num = Num.replace('.', '');
        Num = Num.replace('.', '');
        Num = Num.replace('.', '');
        Num = Num.replace('.', '');
        Num = Num.replace('.', '');
        Num = Num.replace('.', '');
        x = Num.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        return x1 + x2;
    }
</script>
<div class="row-fluid">
    <div class="table-header">
        <?php echo $judul; ?>
        <div class="widget-toolbar no-border pull-right">
            <a href="#modal-table" class="btn btn-small btn-success" role="button" data-toggle="modal" name="tambah" id="tambah">
                <i class="icon-check"></i>
                Tambah Data
            </a>
        </div>
    </div>
    <table class="table fpTable lcnp table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="center">No</th>
                <th class="center">Cabang</th>
                <th class="center">PIC</th>
                <th class="center">Jenis</th>
                <th class="center">Kontrak</th>
                <th class="center">Tarif</th>
                <th class="center">Awal</th>
                <th class="center">Akhir</th>
                <th class="center">Status</th>
                <th class="center">Keterangan</th>
                <th class="center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php

            $i = 1;
            foreach ($data->result() as $dt) { ?>
                <tr>
                    <td class="center span1"><?php echo $i++ ?></td>
                    <td class="center"><?php $idp = $dt->id_perusahaan;

                                        foreach ($this->db->select('singkat,lokasi')->from('perusahaan')->where('id_perusahaan="' . $idp . '"')->get()->result() as $c) {
                                            $nama = $c->singkat . ' - ' . $c->lokasi;
                                        }
                                        echo $nama;
                                        ?>

                    </td>
                    <td class="center"><?php echo $dt->pic; ?></td>
                    <td class="center"><?php $ijk = $dt->jenis_kontrak;
                                        $jk = '';
                                        foreach ($this->db_helpdesk->select('nama')->from('jenis_kontrak')->where('id_jenis_kontrak="' . $ijk . '"')->get()->result() as $c) {
                                            $jk = $c->nama;
                                        }
                                        echo $jk;
                                        ?></td>
                    <td class="center"><?php echo $dt->nama_kontrak; ?></td>
                    <td class="center"><?php echo 'Rp ' . separator_harga($dt->tarif); ?></td>
                    <td class="center"><?php echo tgl_sql($dt->awal); ?></td>
                    <td class="center"><?php echo tgl_sql($dt->akhir); ?></td>
                    <td class="center"><?php
                                        $paymentDate = date('Y-m-d');
                                        $paymentDate = date('Y-m-d', strtotime($paymentDate));
                                        $contractDateBegin = date('Y-m-d', strtotime($dt->awal));
                                        $contractDateEnd = date('Y-m-d',  strtotime($dt->akhir));
                                        if ($paymentDate >= $contractDateBegin && $paymentDate <= $contractDateEnd) {
                                            echo "Aktif";
                                        } else {
                                            echo "Expire";
                                        }

                                        ?></td>
                    <td class="center"><?php echo $dt->keterangan; ?></td>
                    <td class="td-actions">
                        <center>
                            <div class="hidden-phone visible-desktop action-buttons">
                                <a class="green" href="#modal-table" data-toggle="modal" onclick="javascript:editData('<?php echo $dt->id_kontrak; ?>')">
                                    <i class="icon-pencil bigger-130"></i>
                                </a>

                                <a class="red" href="<?php echo site_url(); ?>hd_adm_kontrak/hapus/<?php echo $dt->id_kontrak; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
                                    <i class="icon-trash bigger-130"></i>
                                </a>
                            </div>

                            <div class="hidden-desktop visible-phone">
                                <div class="inline position-relative">
                                    <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
                                        <i class="icon-caret-down icon-only bigger-120"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-icon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
                                        <li>
                                            <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
                                                <span class="green">
                                                    <i class="icon-edit bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                                                <span class="red">
                                                    <i class="icon-trash bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </center>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div id="modal-table" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Kontrak
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
                <input type="hidden" name="id_kontrak" id="id_kontrak">
                <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Cabang</label>

                    <div class="controls">
                        <select name="cabang" id="cabang">
                            <option value="" selected="selected">--Pilih Cabang--</option>
                            <?php
                            $jenis = $this->db->get('perusahaan');
                            foreach ($jenis->result() as $dt) {
                                ?>
                                <option value="<?php echo $dt->id_perusahaan; ?>"><?php echo $dt->singkat . ' - ' . $dt->lokasi; ?></option>
                            <?php
                        }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">PIC</label>

                    <div class="controls">
                        <input type="text" name="pic" id="pic" placeholder="PIC" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Jenis Kontrak</label>

                    <div class="controls">
                        <select name="jenis_kontrak" id="jenis_kontrak">
                            <option value="" selected="selected">--Pilih Jenis Kontrak--</option>
                            <?php
                            $jenis = $this->db_helpdesk->get('jenis_kontrak');
                            foreach ($jenis->result() as $dt) {
                                ?>
                                <option value="<?php echo $dt->id_jenis_kontrak; ?>"><?php echo $dt->nama; ?></option>
                            <?php
                        }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Kontrak</label>

                    <div class="controls">
                        <input type="text" name="nama_kontrak" id="nama_kontrak" placeholder="Nama Kontrak" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Tarif</label>

                    <div class="controls">
                        <input type="text" name="tarif" id="tarif" onkeyup="javascript:this.value=autoseparator(this.value);" placeholder="Tarif" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Awal Kontrak</label>
                    <div class="controls">
                        <input type="text" name="awal" id="awal" class="date-picker" placeholder="Awal Kontrak" data-date-format="dd-mm-yyyy" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Akhir Kontrak</label>
                    <div class="controls">
                        <input type="text" name="akhir" id="akhir" placeholder="Akhir Kontrak" class="date-picker" data-date-format="dd-mm-yyyy" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Keterangan</label>
                    <div class="controls">
                        <textarea name="keterangan" id="keterangan" class="" placeholder="Keterangan"></textarea>
                    </div>
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