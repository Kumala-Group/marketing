<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Spk_by_type extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
        $this->load->model('wuling_marksup/modal_spk_by_type');
    }
    public function index()
    {
        $index = "wuling_spk_by_type";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['load'])) $this->load($post);
            } else {
                $d['content'] = "pages/marketing_support/wuling/spk_by_type";
                $d['index'] = $index;
                $d['lokasi'] = q_data("*", 'kmg.perusahaan', ['id_brand' => 5])->result();
                $this->load->view('index', $d);
            }
        }
    }
    function load($post)
    {
        $data = $this->modal_spk_by_type->DataUnit();
        $data1 = $this->modal_spk_by_type->warna();

        if ($post['bulan'] == 01) {
            $idperusahaan = $post['perusahaan'];
            $year = $post['tahun'];
            $month = $post['bulan'];
            $yearprevious = $year - 1;
            $previous = "12";
        } else {
            $idperusahaan = $post['perusahaan'];
            $year = $post['tahun'];
            $month = $post['bulan'];
            $yearprevious = $post['tahun'];
            $previous = "0" . ($month - 1);
        }

        $hitunghari = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        for ($i = 1; $i < $hitunghari + 1; $i++) {
            if (strlen((string)$i) == 1) {
                $days[] = "0" . $i;
            } else {
                $days[] = $i;
            }
        }

        foreach ($data as $row) {
            $dataunit[] = $row->varian;
            $unitid[] = $row->id_type;
            // $previous[] = $this->modal_spk_by_type->previous("2019", "05", $row->id_type);
        }

        for ($i = 0; $i < count($dataunit); $i++) {
            for ($xc = 0; $xc < count($days); $xc++) {
                $penjualan[$dataunit[$i]][$xc] = $this->modal_spk_by_type->LoadPenjualan($days[$xc], $month, $year, $dataunit[$i], $idperusahaan);
                $sumbydate[$xc][] = $penjualan[$dataunit[$i]][$xc];
                $sumbydate1[$xc] = array_sum($sumbydate[$xc]);
            }
            $average[] = array_sum($penjualan[$dataunit[$i]]) / count($penjualan[$dataunit[$i]]);
            $sumbyunit[] = array_sum($penjualan[$dataunit[$i]]);
        }

        // Data pendukung
        $singletidtype = array_count_values($unitid);
        $keysidtipe = array_keys($singletidtype);
        $valuesidtipe = array_values($singletidtype);

        // Buat rowspan dinamis table
        for ($i = 0; $i < count($valuesidtipe); $i++) {
            for ($b = 0; $b < $valuesidtipe[$i]; $b++) {
                $rowspan[] = $valuesidtipe[$i];
                $rowidunit[] = $keysidtipe[$i];
            }
        }
        for ($n = 0; $n < count($rowspan); $n++) {
            if ($rowspan[$n] == $rowspan[$n - 1] && $rowidunit[$n] == $rowidunit[$n - 1]) {
                $rowspantrue[] = null;
            } else {
                $rowspantrue[] = $rowspan[$n];
            }
        }
        // Hitung penjualan previous by type id
        for ($i = 0; $i < count($rowspantrue); $i++) {
            if ($rowspantrue[$i] > 0) {
                $getkeys[$i] = "ada";
            }
        }
        $keyforprevious = array_keys($getkeys);
        for ($x = 0; $x < count($keysidtipe); $x++) {
            $sumselbytipe[] = $this->modal_spk_by_type->previous($yearprevious, $previous, $keysidtipe[$x], $idperusahaan);
            $sumnowbytipe[] = $this->modal_spk_by_type->previous($year, $month, $keysidtipe[$x], $idperusahaan);
        }
        for ($i = 0; $i < count($keyforprevious); $i++) {
            $dataprevoius[$keyforprevious[$i]] = $sumselbytipe[$i];
            $dataselltipe[$keyforprevious[$i]] = $sumnowbytipe[$i];
        }
        $sumprevious = array_sum($dataprevoius);
?>
        <style>
            td.center.rowspan {
                vertical-align: middle;
            }
        </style>
        <div>
            <?php $titletable = $this->modal_spk_by_type->headcabang($idperusahaan); ?>
            <?php echo "" . $titletable['lokasi'] . " " . $titletable['alamat'] . ""  ?>
        </div>
        <br><br>
        <table class="table table-striped table-bordered table-hover table-sm" id="mytable">
            <thead>
                <tr>
                    <th class="center" rowspan="2" id="th1">No</th>
                    <th class="center" rowspan="2" id="th2">Type</th>
                    <th class="center" rowspan="2" id="th3">Previous<br><?php echo "" . $previous . "-" . $yearprevious . "" ?></th>
                    <th class="center" colspan="<?php echo count($days) ?>">Tanggal</th>
                    <th class="center" rowspan="2" id="th4">Average</th>
                    <th class="center" rowspan="2" colspan="2">Total</th>
                </tr>
                <tr>
                    <?php for ($m = 1; $m < count($days) + 1; $m++) : ?>
                        <th class="center tanggalhari" id=<?php echo "bulan" . $m . "" ?>><?php echo $m ?></th>
                    <?php endfor; ?>
                </tr>
            </thead>
            <tbody>

                <?php for ($i = 0; $i < count($dataunit); $i++) : ?>
                    <tr>
                        <td class="center td1"><?php echo $i + 1 ?></td>
                        <td class="center td2"><?php echo "" . $dataunit[$i] . "" ?></td>
                        <?php if ($rowspantrue[$i] > 0) : ?>
                            <td class="center rowspan td3" rowspan="<?php echo $rowspantrue[$i] ?>"><?php echo "" . $dataprevoius[$i] . "" ?></td>
                        <?php endif; ?>
                        <?php for ($v = 0; $v < count($days); $v++) : ?>
                            <td class="center">
                                <?php
                                if ($penjualan[$dataunit[$i]][$v] == 0) {
                                    echo "";
                                } else {
                                    echo $penjualan[$dataunit[$i]][$v];
                                }
                                ?>
                            </td>
                        <?php endfor; ?>
                        <td class=" center td4"><?php echo round($average[$i]) ?></td>
                        <td class="center"><?php echo $sumbyunit[$i] ?></td>
                        <?php if ($rowspantrue[$i] > 0) : ?>
                            <td class="center rowspan" rowspan="<?php echo $rowspantrue[$i] ?>"><?php echo "" . $dataselltipe[$i] . "" ?></td>
                        <?php endif; ?>

                    </tr>
                <?php endfor; ?>
                <tr>
                    <td class="center" colspan="2">Total</td>
                    <td class="center"><?php echo "" . $sumprevious . "" ?></td>
                    <?php for ($i = 0; $i < count($sumbydate1); $i++) : ?>
                        <td class="center"><?php echo $sumbydate1[$i] ?></td>
                    <?php endfor; ?>
                    <td class="center"></td>
                    <td class="center" colspan="2"><?php echo array_sum($sumbydate1) ?></td>
                </tr>
            </tbody>
        </table>
        <?php
        foreach ($data1 as $row) {
            $color[] = $row->warna;
            $id_color[] = $row->id_warna;
        }
        for ($i = 0; $i < count($dataunit); $i++) {
            for ($x = 0; $x < count($id_color); $x++) {
                $amount[$i][] = $this->modal_spk_by_type->sellbycolor($id_color[$x], $month, $year, $dataunit[$i], $idperusahaan);
            }
        }

        for ($x = 0; $x < count($id_color); $x++) {
            for ($i = 0; $i < count($dataunit); $i++) {
                $datasellcol[$x][$i] = $amount[$i][$x];
            }
            $cellbycol[$x] = array_sum($datasellcol[$x]);
        }
        $bagi = array_sum($sumbydate1);
        // echo "<pre>";
        // print_r($amount);
        // echo "</pre>";
        ?>
        <table class="table table-striped table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th class="center" rowspan="3">No</th>
                    <th class="center" rowspan="3">Type</th>
                    <th class="center" rowspan="3">Previous<br><?php echo "" . $previous . "-" . $yearprevious . "" ?></th>
                    <th class="center" colspan="<?php echo count($color) ?>">Color</th>
                    <th class="center" rowspan="3">Total</th>
                </tr>
                <tr>
                    <th class="center" colspan="<?php echo count($color) ?>">Amount ( %tage )</th>
                </tr>
                <tr>
                    <?php for ($i = 0; $i < count($color); $i++) : ?>
                        <th class="center"><?php echo "" . $color[$i] . "" ?></th>
                    <?php endfor; ?>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($dataunit); $i++) : ?>
                    <tr>
                        <td class="center"><?php echo $i + 1 ?></td>
                        <td class="center"><?php echo "" . $dataunit[$i] . "" ?></td>
                        <?php if ($i == 0) : ?>
                            <td class="center" rowspan="<?php echo count($dataunit) ?>"><?php echo $sumprevious ?></td>
                        <?php endif; ?>
                        <?php for ($x = 0; $x < count($color); $x++) : ?>
                            <?php if ($amount[$i][$x] > 0) {

                                echo "<td class='center'>
                                " . $amount[$i][$x] . " (" . round(($amount[$i][$x] / $bagi) * 100), "%)
                                </td>";
                            } else {
                                echo "<td class='center'></td>";
                            }
                            ?>
                        <?php endfor; ?>
                        <td class="center" class="center"><?php echo $sumbyunit[$i] ?></td>
                    </tr>
                <?php endfor; ?>
                <tr>
                    <td class="center" colspan="2">Total</td>
                    <td class="center"><?php echo $sumprevious ?></td>
                    <?php for ($i = 0; $i < count($cellbycol); $i++) : ?>
                        <td class="center"><?php echo "" . $cellbycol[$i] . "" ?></td>
                    <?php endfor; ?>
                    <td class="center"><?php echo array_sum($sumbydate1) ?></td>
                </tr>
            </tbody>
        </table>
<?php }
}
