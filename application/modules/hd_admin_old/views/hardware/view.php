<script type="text/javascript">
    $(document).ready(function() {
        $('.date-picker').datepicker().next().on(ace.click_event, function() {
            $(this).prev().focus();
        });


        $("#simpan").click(function() {
            var id_hardware = $("#id_hardware").val();
            var id_perusahaan = $("#id_perusahaan").val();
            var nik = $("#nik").val();
            var jenis_hardware = $("#jenis_hardware").val();
            var noaset_hardware = $("#noaset_hardware").val();
            var merk_hardware = $("#merk_hardware").val();
            var type_hardware = $("#type_hardware").val();
            var sn_hardware = $("#sn_hardware").val();
            var kondisi_hardware = $("#kondisi_hardware").val();
            var harga_hardware = $("#harga_hardware").val();
            var tgl_hardware = $("#tgl_hardware").val();
            var status_hardware = $("#status_hardware").val();

            var string = $("#my-form").serialize();



            if (nik.length == 0) {
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'NIK tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#nik").focus();
                return false();
            }
            if (jenis_hardware.length == 0) {
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Jenis Hardware tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#jenis_hardware").focus();
                return false();
            }
            if (merk_hardware.length == 0) {
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Merk Hardware tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#merk_hardware").focus();
                return false();
            }
            if (type_hardware.length == 0) {
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Type Hardware tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#type_hardware").focus();
                return false();
            }
            if (sn_hardware.length == 0) {
                $.gritter.add({
                    title: 'Peringatan..!!',
                    text: 'Serial Number Hardware tidak boleh kosong',
                    class_name: 'gritter-error'
                });

                $("#sn_hardware").focus();
                return false();
            }


            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>hd_adm_hardware/simpan",
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
        $("#cari_karyawan").click(function() {
            $.ajax({
                type: "GET",
                url: "<?php echo site_url(); ?>hd_adm_datatable/nik_karyawan",
                dataType: "json",
                success: function(data) {
                    var table = $('#show_karyawan').DataTable({
                        "bProcessing": true,
                        "bDestroy": true,
                        "sAjaxSource": '<?php echo site_url(); ?>hd_adm_datatable/nik_karyawan',
                        "bSort": false,
                        "bAutoWidth": true,
                        "iDisplayLength": 10,
                        "aLengthMenu": [10, 20, 40, 80], // can be removed for basic 10 items per page
                        "sPaginationType": "full_numbers",
                        "aoColumnDefs": [{
                            "bSortable": false,
                            "aTargets": [-1, 0]
                        }], //Feature control DataTables' server-side processing mode.
                        "aoColumns": [{
                                "mData": "no"
                            },
                            {
                                "mData": "nik"
                            },
                            {
                                "mData": "nama_karyawan"
                            },
                            {
                                "mData": "handphone"
                            },
                            {
                                "mData": "email"
                            },
                            {
                                "mData": "jabatan"
                            }
                        ]
                    });
                    $('#modal-search').modal('show');
                }
            });
        });
        $('#show_karyawan tbody').on('click', 'tr', function() {
            var nik = $(this).find('td').eq(1).text();
            var nama_karyawan = $(this).find('td').eq(2).text();
            var handphone = $(this).find('td').eq(3).text();
            var email = $(this).find('td').eq(4).text();
            $("#nik").val(nik);
            $("#nama_karyawan").val(nama_karyawan);
            $("#handphone").val(handphone);
            $("#email").val(email);
            $('#modal-search').modal('hide');
        });
        $("#tambah").click(function() {
            $('#id_hardware').val('');
            $('#nik').val('');
            $('#jenis_hardware').val('');
            $('#noaset_hardware').val('<?php echo $noaset_hardware; ?>');
            $('#merk_hardware').val('');
            $('#type_hardware').val('');
            $('#sn_hardware').val('');
            $('#harga_hardware').val('');
            $('#tgl_hardware').val('');
            $('#jenis_hardware').focus();

        });
    });

    function editData(ID) {
        var cari = ID;
        console.log(cari);
        $.ajax({
            type: "GET",
            url: "<?php echo site_url(); ?>hd_adm_hardware/cari",
            data: "cari=" + cari,
            dataType: "json",
            success: function(data) {
                $("#simpan").html('<i class="icon-save"></i> Simpan');
                $('#id_hardware').val(data.id_hardware);
                $('#id_perusahaan').val(data.id_perusahaan);
                $('#nik').val(data.nik);
                $('#jenis_hardware').val(data.jenis_hardware);
                $('#noaset_hardware').val(data.noaset_hardware);
                $('#merk_hardware').val(data.merk_hardware);
                $('#type_hardware').val(data.type_hardware);
                $('#sn_hardware').val(data.sn_hardware);
                $('#harga_hardware').val(data.harga_hardware);
                $('#kondisi_hardware').val(data.kondisi_hardware);
                $('#tgl_hardware').val(data.tgl_hardware);
                $('#status_hardware').val(data.status_hardware);
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
        <?php echo $judul; ?><?php echo ' ';
                            echo $nama_perusahaan; ?>
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
                <th class="center">User</th>
                <th class="center">Contact</th>
                <th class="center">Email</th>
                <th class="center">Jenis Aset</th>
                <th class="center">No. Aset</th>
                <th class="center">Merk</th>
                <th class="center">Type</th>
                <th class="center">SN Aset</th>
                <th class="center">Harga</th>
                <th class="center">Kondisi</th>
                <th class="center">Tanggal</th>
                <th class="center">Status</th>
                <th class="center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php

            $i = 1;
            foreach ($data->result() as $dt) { ?>
                <tr>
                    <td class="center span1"><?php echo $i++ ?></td>
                    <td><?php echo $dt->nama_karyawan; ?></td>
                    <td><?php echo $dt->handphone; ?></td>
                    <td><?php echo $dt->email; ?></td>
                    <td><?php echo $dt->jenis_hardware; ?></td>
                    <td><?php echo $dt->noaset_hardware; ?></td>
                    <td><?php echo $dt->merk_hardware; ?></td>
                    <td><?php echo $dt->type_hardware; ?></td>
                    <td><?php echo $dt->sn_hardware; ?></td>
                    <td><?php echo 'Rp. ' . separator_harga($dt->harga_hardware); ?></td>
                    <td><?php echo $dt->kondisi_hardware; ?></td>
                    <td><?php echo tgl_sql($dt->tgl_hardware); ?></td>
                    <td><?php echo $dt->status_hardware; ?></td>

                    <td class="td-actions">
                        <center>
                            <div class="hidden-phone visible-desktop action-buttons">
                                <a class="green" id="a" href="#modal-table" onclick="javascript:editData('<?php echo $dt->id_hardware; ?>')" data-toggle="modal">
                                    <i class="icon-pencil bigger-130"></i>
                                </a>

                                <a class="red" href="<?php echo site_url(); ?>hd_adm_hardware/hapus/<?php echo $dt->id_hardware; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
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
            Hardware
        </div>
    </div>

    <div class="modal-body no-padding">
        <div class="row-fluid">
            <form class="form-horizontal" name="my-form" id="my-form">
                <input type="hidden" name="id_hardware" id="id_hardware" />
                <input type="hidden" name="id_perusahaan" id="id_perusahaan" />
                <br>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">NIK</label>

                    <div class="controls">
                        <input type="text" name="nik" id="nik" placeholder="NIK" /><span class="required"> *</span>
                        <button type="button" name="cari_karyawan" id="cari_karyawan" class="btn btn-small btn-info">
                            <i class="icon-search"></i>
                        </button>
                    </div>

                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Nama Karyawan</label>

                    <div class="controls">
                        <input type="text" name="nama_karyawan" id="nama_karyawan" readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Contact HP</label>

                    <div class="controls">
                        <input type="text" name="handphone" id="handphone" readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Email</label>

                    <div class="controls">
                        <input type="text" name="email" id="email" readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Jenis Hardware</label>
                    <div class="controls">
                        <select name="jenis_hardware" id="jenis_hardware">
                            <option value="" selected="selected">--Pilih Jenis Hardware--</option>
                            <?php
                            $jenis = $this->db_helpdesk->get('jenis_hardware');
                            foreach ($jenis->result() as $dt) {
                                ?>
                                <option value="<?php echo $dt->nama; ?>"><?php echo $dt->nama; ?></option>
                            <?php
                        }
                        ?>
                        </select>
                        <span class="required"> *</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">No. Aset Hardware</label>

                    <div class="controls">
                        <input type="text" name="noaset_hardware" id="noaset_hardware" readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Merk Hardware</label>

                    <div class="controls">
                        <input type="text" name="merk_hardware" id="merk_hardware" placeholder="Merk Hardware" /><span class="required"> *</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Type Hardware</label>

                    <div class="controls">
                        <input type="text" name="type_hardware" id="type_hardware" placeholder="Type Hardware" /><span class="required"> *</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">SN. Hardware</label>

                    <div class="controls">
                        <input type="text" name="sn_hardware" id="sn_hardware" placeholder="Serial Number Hardware" /><span class="required"> *</span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-field-1">Tanggal Pembelian</label>
                    <div class="controls">
                        <div class="input-append">
                            <input type="text" name="tgl_hardware" id="tgl_hardware" class="span6 date-picker" data-date-format="dd-mm-yyyy" />
                            <span class="add-on">
                                <span class="required"> *</span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-field-1">Harga Beli</label>

                    <div class="controls">
                        <input type="text" name="harga_hardware" id="harga_hardware" onkeyup="javascript:this.value=autoseparator(this.value);" placeholder="Harga Beli" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Kondisi</label>
                    <div class="controls">
                        <select name="kondisi_hardware" id="kondisi_hardware">
                            <option value="" selected="selected">--Pilih Kondisi Hardware--</option>
                            <option value="Baik">Baik</option>
                            <option value="Hilang">Hilang</option>
                            <option value="Rusak">Rusak</option>
                        </select>
                        <span class="required"> *</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Status</label>
                    <div class="controls">
                        <select name="status_hardware" id="status_hardware">
                            <option value="" selected="selected">--Pilih Status Hardware--</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                        <span class="required"> *</span>
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
<div id="modal-search" class="modal hide fade" style="width:80%;max-height:80%;left:30%;" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header no-padding">
        <div class="table-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            Cari NIK
        </div>
    </div>

    <div class="no-padding">
        <div class="row-fluid">
            <table class="table lcnp table-striped table-bordered table-hover" style="width: 100%;" id="show_karyawan">
                <thead>
                    <tr>
                        <th class="center">No</th>
                        <th class="center">NIK</th>
                        <th class="center">Nama Karyawan</th>
                        <th class="center">No. Handphone</th>
                        <th class="center">Email</th>
                        <th class="center">Jabatan</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal-footer">
        <div class="pagination pull-right no-margin">
            <button type="button" class="btn btn-small btn-danger pull-left" data-dismiss="modal">
                <i class="icon-remove"></i>
                Close
            </button>
        </div>
    </div>
</div>