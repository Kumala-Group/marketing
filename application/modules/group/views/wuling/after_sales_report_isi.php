<div style="overflow-x:auto;">
    <table class="table table-bordered table-hover font-small-3">
        <thead class="bg-grey bg-lighten-2">
            <tr class="font-small-3">
                <th class="center">Detail</th>
                <?php for ($i = 0; $i < 12; $i++) : ?>
                    <th style="text-align:center;"><?= $nama_bln[$i] ?></th>
                <?php endfor ?>
                <th style="text-align:center;">Total</th>
            </tr>
        </thead>
        <tbody class="font-small-3">
            <tr>
                <td>Total Invoice Part Counter</td>
                <?php for ($i = 1; $i <= 12; $i++) : ?>
                    <th style="text-align:center;"><?= separator_harga($part_counter[$i]) ?></th>
                <?php endfor ?>
                <th style="text-align:center;"><?= separator_harga(array_sum($part_counter)) ?></th>
            </tr>
            <tr>
                <td>Total Invoice Service</td>
                <?php for ($i = 1; $i <= 12; $i++) : ?>
                    <th style="text-align:center;"><?= separator_harga($service[$i]) ?></th>
                <?php endfor ?>
                <th style="text-align:center;"><?= separator_harga(array_sum($service)) ?></th>
            </tr>
            <!-- <tr>
                <td class="center">Total Piutang Part Counter</td>
            </tr>
            <tr>
                <td class="center">Total Piutang Service</td>
            </tr> -->
        </tbody>
        <tfoot class="bg-grey bg-lighten-4 text-bold-700">

        </tfoot>
    </table>
</div>