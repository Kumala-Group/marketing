<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Aktivitas_penjualan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "wuling_aktivitas_penjualan";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['load_regional'])) $this->load_regional($post);
                elseif (!empty($post['load_perusahaan'])) $this->load_perusahaan($post);
                elseif (!empty($post['load_chart_sumber_prospek'])) $this->chart_sumber_prospek();
                elseif (!empty($post['load_chart_media'])) $this->chart_media();
            } else {
                $d['content'] = "pages/marketing_support/wuling/aktivitas_penjualan";
                $d['index'] = $index;
                $d['regional'] = $this->db_wuling->query("SELECT id_team_sm,region,coverage FROM adm_team_sm ORDER BY region DESC")->result();
                $this->load->view('index', $d);
            }
        }
    }
    function load_regional($post)
    {
        $id_team_sm = $post['regional'];
        $month = $post['bulan'];
        $year = $post['tahun'];
        $coverage = $this->db_wuling->select('coverage')->where('id_team_sm', $id_team_sm)->get('adm_team_sm')->row()->coverage;
        $sumber_prospek = $this->sumber_prospek($month, $year, $coverage);
        $media_motivator = $this->media_motivator($month, $year, $coverage);
        $cabang = $this->cabang($coverage);
        $data = array('sumber_prospek' => $sumber_prospek, 'media' => $media_motivator, 'cabang' => $cabang);
        echo json_encode($data);
    }

    function load_perusahaan($post)
    {
        $id_cabang = $post['perusahaan'];
        $month = $post['bulan'];
        $year = $post['tahun'];
        $sumber_prospek = $this->sumber_prospek($month, $year, $id_cabang);
        $media_motivator = $this->media_motivator($month, $year, $id_cabang);
        $data = array('sumber_prospek' => $sumber_prospek, 'media' => $media_motivator);
        echo json_encode($data);
    }

    public function cabang($coverage)
    {
        $output = '';
        $f = explode(',', $coverage);
        for ($x = 0; $x < count($f); $x++) {
            $singkat = $this->db->select('lokasi')->where('id_perusahaan', $f[$x])->get('perusahaan')->row()->lokasi;
            $output .= '<option value="' . $f[$x] . '">' . $singkat . '</option>';
        }
        return $output;
    }

    public function sumber_prospek($month, $year, $coverage)
    {
        $output = '';
        $output .= '<div class="row-fluid"><div class="span12"><table class="table table-striped table-bordered table-hover" id="" width="100%"><thead><tr><th></th>';
        $list = array();
        $jml_hari = 0;
        $last_month = ((int) $month) - 1;
        for ($d = 1; $d <= 31; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month) {
                $tgl_param = date('Y-m-d', $time);
                $jml_hari++;
                $output .= '<td class="center">' . date('d', $time) . '</td>';
            }
        }
        $output .= '<td class="center"><b>Tot</b></td><td class="center"><b>Rata2/Hr</b></td><td class="center"><b>Rata2/Hr bln lalu</b></td><td class="center"><b>SPK</b></td><td class="center"><b>SPK bln lalu</b></td><td class="center"><b>DO</b></td><td class="center"><b>DO bln lalu</b></td></tr></thead><tbody>';
        $q_t = $this->db_wuling->select('*')->get('p_sumber_prospek');
        foreach ($q_t->result() as $t) {
            $output .= '<tr><td class="center">' . ucwords(strtolower($t->sumber_prospek)) . '</td>';
            $list = array();
            $jml_hari = 0;
            $total_all = 0;
            for ($d = 1; $d <= 31; $d++) {
                $time = mktime(12, 0, 0, $month, $d, $year);
                if (date('m', $time) == $month) {
                    $tgl_param = date('Y-m-d', $time);
                    $jml_hari++;
                    $tot = $this->db_wuling->query("SELECT COUNT(p.id_prospek) as total FROM s_suspect p JOIN s_customer c ON c.id_prospek=p.id_prospek JOIN adm_sales sl ON sl.id_sales=c.sales WHERE p.tgl_suspect='$tgl_param' AND c.id_sumber_prospek='$t->id_sumber_prospek' AND sl.id_perusahaan IN ($coverage)")->row()->total;
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

            $total_bln_lalu = $this->db_wuling->query("SELECT COUNT(p.id_prospek) as total FROM s_suspect p JOIN s_customer c ON c.id_prospek=p.id_prospek JOIN adm_sales sl ON sl.id_sales=c.sales WHERE MONTH(p.tgl_suspect)='$last_month' AND YEAR(p.tgl_suspect)='$year' AND c.id_sumber_prospek='$t->id_sumber_prospek' AND sl.id_perusahaan IN ($coverage)")->row()->total;
            $rata_bln_lalu = $total_bln_lalu / $jml_hari;
            $total_do = $this->db_wuling->query("SELECT COUNT(p.id_prospek) as total FROM s_suspect p JOIN s_customer c ON c.id_prospek=p.id_prospek JOIN adm_sales sl ON sl.id_sales=c.sales WHERE MONTH(p.tgl_suspect)='$month' AND YEAR(p.tgl_suspect)='$year' AND c.id_sumber_prospek='$t->id_sumber_prospek' AND c.status='do' AND sl.id_perusahaan IN ($coverage)")->row()->total;
            $total_bln_lalu = $this->db_wuling->query("SELECT COUNT(p.id_prospek) as total FROM s_suspect p JOIN s_customer c ON c.id_prospek=p.id_prospek JOIN adm_sales sl ON sl.id_sales=c.sales WHERE MONTH(p.tgl_suspect)='$last_month' AND YEAR(p.tgl_suspect)='$year' AND c.id_sumber_prospek='$t->id_sumber_prospek' AND c.status='do' AND sl.id_perusahaan IN ($coverage)")->row()->total;
            $total_spk = ((int) $this->db_wuling->query("SELECT COUNT(p.id_prospek) as total FROM s_suspect p JOIN s_customer c ON c.id_prospek=p.id_prospek JOIN adm_sales sl ON sl.id_sales=c.sales WHERE MONTH(p.tgl_suspect)='$month' AND YEAR(p.tgl_suspect)='$year' AND c.id_sumber_prospek='$t->id_sumber_prospek' AND c.status='spk' AND sl.id_perusahaan IN ($coverage)")->row()->total) + $total_do;
            $total_spk_lalu = ((int) $this->db_wuling->query("SELECT COUNT(p.id_prospek) as total FROM s_suspect p JOIN s_customer c ON c.id_prospek=p.id_prospek JOIN adm_sales sl ON sl.id_sales=c.sales WHERE MONTH(p.tgl_suspect)='$last_month' AND YEAR(p.tgl_suspect)='$year' AND c.id_sumber_prospek='$t->id_sumber_prospek' AND c.status='spk' AND sl.id_perusahaan IN ($coverage)")->row()->total) + $total_bln_lalu;

            $output .=  '<td class="center"><b>' . number_format($rata_bln_lalu, 2, ',', '.') . '</b></td>';
            $output .= '<td class="center"><b>' . $total_spk . '</b></td>';
            $output .= '<td class="center"><b>' . $total_spk_lalu . '</b></td>';
            $output .= '<td class="center"><b>' . $total_do . '</b></td>';
            $output .= '<td class="center"><b>' . $total_bln_lalu . '</b></td>';
            $output .=  '</tr>';
        }
        $output .= '</tbody></table></div></div>';
        return $output;
    }

    public function media_motivator($month, $year, $coverage)
    {
        $output = '';
        $output .= '<div class="row-fluid"><div class="span12"><table class="table table-striped table-bordered table-hover" id="" width="100%"><thead><tr><th></th>';
        $list = array();
        $jml_hari = 0;
        $last_month = ((int) $month) - 1;
        for ($d = 1; $d <= 31; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month) {
                $tgl_param = date('Y-m-d', $time);
                $jml_hari++;
                $output .= '<td class="center">' . date('d', $time) . '</td>';
            }
        }
        $output .= '<td class="center"><b>Tot</b></td><td class="center"><b>Rata2/Hr</b></td><td class="center"><b>Rata2/Hr bln lalu</b></td><td class="center"><b>SPK</b></td><td class="center"><b>SPK bln lalu</b></td><td class="center"><b>DO</b></td><td class="center"><b>DO bln lalu</b></td></tr></thead><tbody>';
        $q_t = $this->db_wuling->select('*')->get('p_media');
        foreach ($q_t->result() as $t) {
            $output .= '<tr><td class="center">' . ucwords(strtolower($t->media)) . '</td>';
            $list = array();
            $jml_hari = 0;
            $total_all = 0;
            for ($d = 1; $d <= 31; $d++) {
                $time = mktime(12, 0, 0, $month, $d, $year);
                if (date('m', $time) == $month) {
                    $tgl_param = date('Y-m-d', $time);
                    $jml_hari++;
                    $tot = $this->db_wuling->query("SELECT COUNT(p.id_prospek) as total FROM s_prospek p JOIN s_customer c ON c.id_prospek=p.id_prospek JOIN adm_sales sl ON sl.id_sales=c.sales WHERE p.tgl_prospek='$tgl_param' AND p.id_media='$t->id_media' AND sl.id_perusahaan IN ($coverage)")->row()->total;
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

            $total_bln_lalu = $this->db_wuling->query("SELECT COUNT(p.id_prospek) as total FROM s_prospek p JOIN s_customer c ON c.id_prospek=p.id_prospek JOIN adm_sales sl ON sl.id_sales=c.sales WHERE MONTH(p.tgl_prospek)='$last_month' AND p.id_media='$t->id_media' AND sl.id_perusahaan IN ($coverage)")->row()->total;
            $rata_bln_lalu = $total_bln_lalu / $jml_hari;
            $output .=  '<td class="center"><b>' . number_format($rata_bln_lalu, 2, ',', '.') . '</b></td>';
            $total_do = $this->db_wuling->query("SELECT COUNT(p.id_prospek) as total FROM s_prospek p JOIN s_customer c ON c.id_prospek=p.id_prospek JOIN adm_sales sl ON sl.id_sales=c.sales WHERE MONTH(p.tgl_prospek)='$month' AND YEAR(p.tgl_prospek)='$year' AND p.id_media='$t->id_media' AND c.status='do' AND sl.id_perusahaan IN ($coverage)")->row()->total;
            $total_bln_lalu = $this->db_wuling->query("SELECT COUNT(p.id_prospek) as total FROM s_prospek p JOIN s_customer c ON c.id_prospek=p.id_prospek JOIN adm_sales sl ON sl.id_sales=c.sales WHERE MONTH(p.tgl_prospek)='$last_month' AND YEAR(p.tgl_prospek)='$year' AND p.id_media='$t->id_media' AND c.status='do' AND sl.id_perusahaan IN ($coverage)")->row()->total;
            $total_spk = ((int) $this->db_wuling->query("SELECT COUNT(p.id_prospek) as total FROM s_prospek p JOIN s_customer c ON c.id_prospek=p.id_prospek JOIN adm_sales sl ON sl.id_sales=c.sales WHERE MONTH(p.tgl_prospek)='$month' AND YEAR(p.tgl_prospek)='$year' AND p.id_media='$t->id_media' AND c.status='do' AND sl.id_perusahaan IN ($coverage)")->row()->total) + $total_do;
            $total_spk_lalu = ((int) $this->db_wuling->query("SELECT COUNT(p.id_prospek) as total FROM s_prospek p JOIN s_customer c ON c.id_prospek=p.id_prospek JOIN adm_sales sl ON sl.id_sales=c.sales WHERE MONTH(p.tgl_prospek)='$last_month' AND YEAR(p.tgl_prospek)='$year' AND p.id_media='$t->id_media' AND c.status='do' AND sl.id_perusahaan IN ($coverage)")->row()->total) + $total_bln_lalu;

            $output .= '<td class="center"><b>' . $total_spk . '</b></td>';
            $output .= '<td class="center"><b>' . $total_spk_lalu . '</b></td>';
            $output .= '<td class="center"><b>' . $total_do . '</b></td>';
            $output .= '<td class="center"><b>' . $total_bln_lalu . '</b></td>';
            $output .=  '</tr>';
        }
        $output .= '</tbody></table></div></div>';
        return $output;
    }

    public function chart_sumber_prospek()
    {
        $id_team_sm = $this->input->post('region');
        $month = $this->input->post('bln');
        $year = $this->input->post('thn');
        $param = $this->input->post('param');
        if ($param == 'r') {
            $coverage = $this->db_wuling->select('coverage')->where('id_team_sm', $id_team_sm)->get('adm_team_sm')->row()->coverage;
        } else {
            $coverage = $id_team_sm;
        }
        $data = $this->db_wuling->get('p_sumber_prospek')->result();
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
        foreach ($data as $cd) {
            $tot = $this->db_wuling->query("SELECT COUNT(p.id_prospek) as total FROM s_suspect p JOIN s_customer c ON c.id_prospek=p.id_prospek JOIN adm_sales sl ON sl.id_sales=c.sales WHERE EXTRACT(YEAR_MONTH FROM p.tgl_suspect)='$year$month' AND c.id_sumber_prospek='$cd->id_sumber_prospek' AND sl.id_perusahaan IN ($coverage)")->row()->total;
            $responce->rows[]["c"] = array(
                array(
                    "v" => "$cd->sumber_prospek",
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

    public function chart_media()
    {
        $id_team_sm = $this->input->post('region');
        $month = $this->input->post('bln');
        $year = $this->input->post('thn');
        $param = $this->input->post('param');
        if ($param == 'r') {
            $coverage = $this->db_wuling->select('coverage')->where('id_team_sm', $id_team_sm)->get('adm_team_sm')->row()->coverage;
        } else {
            $coverage = $id_team_sm;
        }
        $data = $this->db_wuling->get('p_media')->result();
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
        foreach ($data as $cd) {
            $tot = $this->db_wuling->query("SELECT COUNT(p.id_prospek) as total FROM s_prospek p JOIN s_customer c ON c.id_prospek=p.id_prospek JOIN adm_sales sl ON sl.id_sales=c.sales WHERE EXTRACT(YEAR_MONTH FROM p.tgl_prospek)='$year$month' AND p.id_media='$cd->id_media' AND sl.id_perusahaan IN ($coverage)")->row()->total;
            $responce->rows[]["c"] = array(
                array(
                    "v" => "$cd->media",
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
