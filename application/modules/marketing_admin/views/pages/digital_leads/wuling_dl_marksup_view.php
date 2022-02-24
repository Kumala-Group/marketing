<input type="hidden" name="full_path" id="full_path" value="<?= $full_path ?>">

<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th class="center">No</th>
                <th class="center">Lead Source</th>
                <th class="center">Komunikasi</th>
                <th class="center">Nama</th>
                <th class="center">Keterangan</th>
                <th class="center">Kontak</th>
                <th class="center">Alamat</th>
                <th class="center">Kota</th>
                <th class="center">Dealer</th>
                <th class="center">Region</th>
                <th class="center">Email</th>
                <th class="center">Pekerjaan</th>
                <th class="center">Rencana Pembelian Mobil</th>
                <th class="center">Info yang Dibutuhkan</th>
            </tr>
        </thead>
        <tbody>
            <?php
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

                $no                = $rowData[0][0];
                $leads             = $rowData[0][1];
                $komunikasi        = $rowData[0][2];
                $nama              = $rowData[0][3];
                $keterangan        = $rowData[0][4];
                $kontak            = $rowData[0][5];
                $alamat            = $rowData[0][6];
                $kota              = $rowData[0][7];
                $dealer            = $rowData[0][8];
                $region            = $rowData[0][9];
                $email             = $rowData[0][10];
                $pekerjaan         = $rowData[0][11];
                $rencana_pembelian = $rowData[0][12];
                $info              = $rowData[0][13];
            ?>
                <tr>
                    <td class="center"><?= $no; ?></td>
                    <td class="center"><?= $leads; ?></td>
                    <td class="center"><?= $komunikasi; ?></td>
                    <td class="center"><?= $nama; ?></td>
                    <td class="center"><?= $keterangan; ?></td>
                    <td class="center"><?= $kontak; ?></td>
                    <td class="center"><?= $alamat; ?></td>
                    <td class="center"><?= $kota; ?></td>
                    <td class="center"><?= $dealer; ?></td>
                    <td class="center"><?= $region; ?></td>
                    <td class="center"><?= $email; ?></td>
                    <td class="center"><?= $pekerjaan; ?></td>
                    <td class="center"><?= $rencana_pembelian; ?></td>
                    <td class="center"><?= $info; ?></td>
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