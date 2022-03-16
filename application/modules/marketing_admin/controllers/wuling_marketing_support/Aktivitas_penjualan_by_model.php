<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Aktivitas_penjualan_by_model extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "wuling_aktivitas_penjualan_by_model";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['load_perusahaan'])) $this->load_perusahaan($post);
                elseif (!empty($post['load_linechart_type'])) $this->linechart_type();
                elseif (!empty($post['load_chart_type'])) $this->chart_type();
            } else {
                $d['content'] = "pages/marketing_support/wuling/aktivitas_penjualan_by_model";
                $d['index'] = $index;
                $d['lokasi'] = q_data("*", 'kumk6797_kmg.perusahaan', ['id_brand' => 5])->result();
                $this->load->view('index', $d);
            }
        }
    }
    function load_perusahaan($post)
    {
        $id_perusahaan = $post['perusahaan'];
        $month = $post['bulan'];
        $year = $post['tahun'];
        $output = '';
        $output .= '<div class="row-fluid"><div class="span12"><table class="table table-striped table-bordered table-hover" id="show_spk" width="100%">';
        $output .= '<thead><tr><th></th>';
        $list = array();
        $jml_hari = 0;
        for ($d = 1; $d <= 31; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month) {
                $tgl_param = date('Y-m-d', $time);
                $jml_hari++;
                $output .= '<th class="center span3">' . date('d', $time) . '</th>';
            }
        }
        $output .= '<th class="center"><b>Tot</b></th><th class="center"><b>Rata2/hr</b></th><th class="center"><b>Test Drive</b></th><th class="center"><b>DO</b></th>';
        $output .= '</tr></thead><tbody><tr>';

        $q_t = q_data("*", 'db_wuling.p_type', [])->result();

        $select = "count(p.id_prospek) as total";
        $table  = 'db_wuling.s_prospek p';
        $join   = [
            'db_wuling.s_customer c' => "c.id_prospek=p.id_prospek",
            'db_wuling.unit u'       => "p.kode_unit=u.kode_unit",
            'db_wuling.adm_sales sl' => "sl.id_sales=c.sales",
        ];

        foreach ($q_t as $t) {
            $output .= '<td class="center">' . ucwords(strtolower($t->type)) . '</td>';
            $list = array();
            $jml_hari = 0;
            $total_all = 0;
            for ($d = 1; $d <= 31; $d++) {
                $time = mktime(12, 0, 0, $month, $d, $year);
                if (date('m', $time) == $month) {
                    $tgl_param = date('Y-m-d', $time);
                    $jml_hari++;
                    $where = [
                        'p.tgl_prospek' => $tgl_param,
                        'u.id_type' => $t->id_type,
                        'sl.id_perusahaan' => $id_perusahaan,
                    ];
                    $tot = q_data_join($select, $table, $join, $where)->row('total');
                    $total_all += $tot;
                    if ($tot == 0) {
                        $tot = ' ';
                    }
                    $output .=  '<td class="center">' . $tot . '</td>';
                }
            }
            $output .= '<td class="center"><b>' . $total_all . '</b></td>';
            $rata_per_hari = $total_all / $jml_hari;
            $output .=  '<td class="center"><b>' . number_format($rata_per_hari, 2, ',', '.') . '</b></td>';
            $where = [
                'MONTH(p.tgl_prospek)' => $month,
                'YEAR(p.tgl_prospek)'  => $year,
                'u.id_type'            => "$t->id_type",
                'c.test_drive'         => "y",
                'sl.id_perusahaan'     => $id_perusahaan
            ];
            $total_td = q_data_join($select, $table, $join, $where)->row('total');
            $output .= '<td class="center"><b>' . $total_td . '</b></td>';
            $where = [
                'MONTH(p.tgl_prospek)' => $month,
                'YEAR(p.tgl_prospek)'  => $year,
                'u.id_type'            => "$t->id_type",
                'c.status'             => "do",
                'sl.id_perusahaan'     => $id_perusahaan
            ];
            $total_do = q_data_join($select, $table, $join, $where)->row('total');
            $output .= '<td class="center"><b>' . $total_do . '</b></td>';

            $output .= '</tr>';
        }
        $output .= '</tbody></table></div></div></table></div></div>';
        $data = array('view' => $output);

        echo json_encode($data);
    }
    function linechart_type()
    {
        $id_perusahaan = $this->input->post('perusahaan');
        $month = $this->input->post('bln');
        $year = $this->input->post('thn');
        $responce->cols[] = array(
            "id" => "",
            "label" => "Day",
            "pattern" => "",
            "type" => "number"
        );
        $q_t = $this->db_wuling->select('*')->get('p_type');
        foreach ($q_t->result() as $t) {
            $responce->cols[] = array(
                "id" => "",
                "label" => "$t->type",
                "pattern" => "",
                "type" => "number"
            );
        }

        $baris = array();
        $jml_hari = 0;
        $total_all = 0;
        for ($d = 1; $d <= 31; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month) {
                $tgl_param = date('Y-m-d', $time);
                $hr = date('d', $time);
                $baris[] = array(
                    "v" => $hr,
                    "f" => null
                );

                foreach ($q_t->result() as $t2) {
                    $tot = q_data_join(
                        "COUNT(p.id_prospek) as total",
                        'db_wuling.s_prospek p',
                        [
                            'db_wuling.s_customer c' => "c.id_prospek=p.id_prospek",
                            'db_wuling.unit u' => "p.kode_unit=u.kode_unit",
                            'db_wuling.adm_sales sl' => "sl.id_sales=c.sales"
                        ],
                        ['p.tgl_prospek' => $tgl_param, 'u.id_type' => $t2->id_type, 'sl.id_perusahaan' => $id_perusahaan]
                    )->row('total');
                    $baris[] = array(
                        "v" => (int) $tot,
                        "f" => null
                    );
                }
                $responce->rows[]["c"] = $baris;
            }
            unset($baris);
        }

        echo json_encode($responce);
    }

    function chart_type()
    {
        $id_perusahaan = $this->input->post('perusahaan');
        $month = $this->input->post('bln');
        $year = $this->input->post('thn');
        $responce->cols[] = array(
            "id" => "",
            "label" => "Topping",
            "pattern" => "",
            "type" => "string"
        );
        $responce->cols[] = array(
            "id" => "",
            "label" => "Total",
            "pattern" => "",
            "type" => "number"
        );
        $q_t = $this->db_wuling->select('*')->get('p_type');
        foreach ($q_t->result() as $t) {
            $tot = q_data_join(
                "COUNT(p.id_prospek) as total",
                'db_wuling.s_prospek p',
                [
                    'db_wuling.s_customer c' => "c.id_prospek=p.id_prospek",
                    'db_wuling.unit u' => "p.kode_unit=u.kode_unit",
                    'db_wuling.adm_sales sl' => "sl.id_sales=c.sales"
                ],
                "EXTRACT(YEAR_MONTH FROM p.tgl_prospek)='$year$month' AND u.id_type='$t->id_type' and sl.id_perusahaan='$id_perusahaan'"
            )->row('total');
            $responce->rows[]["c"] = array(
                array(
                    "v" => "$t->type",
                    "f" => null
                ),
                array(
                    "v" => (int) $tot,
                    "f" => null
                )
            );
        }
        echo json_encode($responce);
    }
}
