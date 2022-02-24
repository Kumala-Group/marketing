<input type="hidden" name="full_path" id="full_path" value="<?= $full_path ?>">
<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th class="center">Tgl Masuk Leads</th>
                <th class="center">Tgl Bagi Leads</th>
                <th class="center">Bulan</th>
                <th class="center">Lead Source</th>
                <th class="center">Komunikasi</th>
                <th class="center">Nama</th>
                <th class="center">No. Telp.</th>
                <th class="center">Keterangan</th>
                <th class="center">Alamat</th>
                <th class="center">Kota/Kabupaten</th>
                <th class="center">Dealer</th>
                <th class="center">Region</th>
                <th class="center">Email</th>
                <th class="center">Pekerjaan</th>
                <th class="center">Rencana Pembelian Mobil</th>
                <th class="center">Info Yang Dibutuhkan</th>
                <th class="center">Tipe Mobil</th>
                <th class="center">Brand Lain/Model</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($error_msg) echo $error_msg;
            // untuk hapus baris yang kosong
            function isEmptyRow($row)
            {
                foreach ($row as $cell) {
                    if (null !== $cell) return false;
                }
                return true;
            }

            for ($row = 2; $row <= $baris; $row++) {
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $kolom . $row, NULL, TRUE, FALSE);

                if (isEmptyRow(reset($rowData))) {
                    continue;
                }
                $tgl_masuk_leads    = gmdate("Y-m-d", ($rowData[0][0] - 25569) * 86400);
                $tgl_bagi_leads     = gmdate("Y-m-d", ($rowData[0][1] - 25569) * 86400);
                $bulan              = gmdate("M", ($rowData[0][1] - 25569) * 86400);
                $lead_source        = $rowData[0][3];
                $komunikasi         = $rowData[0][4];
                $nama               = $rowData[0][5];
                $no_telp            = $rowData[0][6];
                $keterangan         = $rowData[0][7];
                $alamat             = $rowData[0][8];
                $kota               = $rowData[0][9];
                $dealer             = $rowData[0][10];
                $region             = $rowData[0][11];
                $email              = $rowData[0][12];
                $pekerjaan          = $rowData[0][13];
                $rencana_pembelian  = $rowData[0][14];
                $info_yg_dibutuhkan = $rowData[0][15];
                $tipe_mobil         = $rowData[0][17];
                $brand_lain         = $rowData[0][18];
            ?>
                <tr>
                    <td class="center"><?= $tgl_masuk_leads; ?></td>
                    <td class="center"><?= $tgl_bagi_leads; ?></td>
                    <td class="center"><?= $bulan; ?></td>
                    <td class="center"><?= $lead_source; ?></td>
                    <td class="center"><?= $komunikasi; ?></td>
                    <td class="center"><?= $nama; ?></td>
                    <td class="center"><?= $no_telp; ?></td>
                    <td class="center"><?= $keterangan; ?></td>
                    <td class="center"><?= $alamat; ?></td>
                    <td class="center"><?= $kota; ?></td>
                    <td class="center"><?= $dealer; ?></td>
                    <td class="center"><?= $region; ?></td>
                    <td class="center"><?= $email; ?></td>
                    <td class="center"><?= $pekerjaan; ?></td>
                    <td class="center"><?= $rencana_pembelian; ?></td>
                    <td class="center"><?= $info_yg_dibutuhkan; ?></td>
                    <td class="center"><?= $tipe_mobil; ?></td>
                    <td class="center"><?= $brand_lain; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div align="center">
    <button type="submit" name="simpan_data" id="simpan_data" class="btn btn-sm btn-success">
        <i class="icon-save"></i>
        Simpan
    </button>
</div>