<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Aktivitas_prospek extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
    }
    public function index()
    {
        $index = "wuling_aktivitas_prospek";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['load_perusahaan'])) $this->load_perusahaan($post);
                elseif (!empty($post['load_sales'])) $this->load_sales($post);
                elseif (!empty($post['load_linechart_prospek'])) $this->linechart_prospek();
                elseif (!empty($post['load_chart_prospek'])) $this->chart_prospek();
            } else {
                $d['content'] = "pages/marketing_support/wuling/aktivitas_prospek";
                $d['index'] = $index;
                $d['lokasi'] = q_data("*", 'kmg.perusahaan', ['id_brand' => 5])->result();
                $this->load->view('index', $d);
            }
        }
    }
    function load_perusahaan($post)
    {
        $id_perusahaan = $post['perusahaan'];
        $month = $post['bulan'];
        $year = $post['tahun'];
        $view = $this->view_prospek($month, $year, $id_perusahaan);
        $data = array('view' => $view);

        echo json_encode($data);
    }

    public function view_prospek($month, $year, $id_perusahaan)
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
        $output .= '<td class="center"><b>Tot</b></td><td class="center"><b>Rata2/Hr</b></td></tr></thead><tbody>';
        $status = array('Suspect' => 'suspect', 'Prospek' => 'prospek', 'Hot Prospek' => 'hot_prospek', 'SPK' => 'spk', 'DO' => 'do');
        foreach ($status as $nama => $value) {
            $output .= '<tr><td class="center">' . $nama . '</td>';
            $list = array();
            $jml_hari = 0;
            $total_all = 0;
            $prospek = 's_' . $value;
            $tgl = 'tgl_' . $value;
            if ($tgl == 'tgl_hot_prospek') {
                $tgl = 'tgl_h_prospek';
            }
            for ($d = 1; $d <= 31; $d++) {
                $time = mktime(12, 0, 0, $month, $d, $year);
                if (date('m', $time) == $month) {
                    $tgl_param = date('Y-m-d', $time);
                    $jml_hari++;
                    $tot = $this->db_wuling->query("SELECT COUNT(p.id_prospek) as total FROM $prospek p JOIN s_customer c ON c.id_prospek=p.id_prospek JOIN adm_sales sl ON sl.id_sales=c.sales WHERE p.$tgl='$tgl_param' AND sl.id_perusahaan='$id_perusahaan'")->row()->total;
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

            $output .=  '</tr>';
        }
        $output .= '</tbody></table></div></div>';
        return $output;
    }

    function load_sales($post)
    {
        $id_perusahaan = $post['perusahaan'];
        $month = $post['bulan'];
        $year = $post['tahun'];
        $view = $this->view_prospek_detail($month, $year, $id_perusahaan);
        $data = array('view_detail' => $view);

        echo json_encode($data);
    }

    public function view_prospek_detail($month, $year, $id_perusahaan)
    {
        $output = '';
        $output .= '<div class="row-fluid"><div class="span12"><table class="table table-striped table-bordered table-hover" id="" width="100%"><thead><tr><th class="center">Sales</th><th class="center">Supervisor</th>';
        $jml_hari = 0;
        $last_month = ((int) $month) - 1;
        $status = array('Suspect' => 'suspect', 'Prospek' => 'prospek', 'Hot Prospek' => 'hot_prospek', 'SPK' => 'spk', 'DO' => 'do');
        foreach ($status as $nama => $value) {
            $output .= '<td class="center">' . $nama . '</td>';
        }
        $output .= '</tr></thead><tbody>';
        $q_sales = $this->db->select('sl.id_sales,ats.nama_team,k.nama_karyawan')->from('db_wuling.adm_sales sl')->join('kmg.karyawan k', 'sl.id_sales = k.id_karyawan')->join('db_wuling.adm_team_supervisor ats', 'sl.id_leader = ats.id_team_supervisor')->where("sl.status_aktif='A' AND sl.id_perusahaan='$id_perusahaan' AND sl.status_leader='n'")->group_by('sl.id_sales')->order_by('sl.id_leader')->get();
        foreach ($q_sales->result() as $dt) {
            $output .= '<tr><td class="center">' . $dt->nama_karyawan . '</td>';
            $output .= '<td class="center">' . $dt->nama_team . '</td>';
            $total_all = 0;

            foreach ($status as $nama => $value) {
                $prospek = 's_' . $value;
                $tgl = 'tgl_' . $value;
                if ($tgl == 'tgl_hot_prospek') {
                    $tgl = 'tgl_h_prospek';
                }
                $tot = $this->db_wuling->query("SELECT COUNT(p.id_prospek) as total FROM $prospek p JOIN s_customer c ON c.id_prospek=p.id_prospek JOIN adm_sales sl ON sl.id_sales=c.sales WHERE EXTRACT(YEAR_MONTH FROM p.$tgl)='$year$month' AND sl.id_perusahaan='$id_perusahaan' AND sl.id_sales='$dt->id_sales'")->row()->total;
                $output .=  '<td class="center">' . $tot . '</td>';
            }

            $output .=  '</tr>';
        }
        $output .= '</tbody></table></div></div>';
        return $output;
    }

    function linechart_prospek()
    {
        $id_perusahaan = $this->input->post('perusahaan');
        $month = $this->input->post('bln');
        $year = $this->input->post('thn');
        $status = array('Suspect' => 'suspect', 'Prospek' => 'prospek', 'Hot Prospek' => 'hot_prospek', 'SPK' => 'spk', 'DO' => 'do');
        $responce->cols[] = array(
            "id" => "",
            "label" => "Day",
            "pattern" => "",
            "type" => "number"
        );
        foreach ($status as $nama => $value) {
            $responce->cols[] = array(
                "id" => "",
                "label" => "$nama",
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

                foreach ($status as $nama => $value) {

                    $prospek = 's_' . $value;
                    $tgl = 'tgl_' . $value;
                    if ($tgl == 'tgl_hot_prospek') {
                        $tgl = 'tgl_h_prospek';
                    }

                    $perusahaan = "";
                    if ($id_perusahaan != "") {
                        $perusahaan .= "AND sl.id_perusahaan='$id_perusahaan'";
                    }
                    $tot = $this->db_wuling->query("SELECT COUNT(p.id_prospek) as total FROM $prospek p JOIN s_customer c ON c.id_prospek=p.id_prospek JOIN adm_sales sl ON sl.id_sales=c.sales WHERE p.$tgl='$tgl_param' $perusahaan")->row()->total;
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

    function chart_prospek()
    {
        $id_perusahaan = $this->input->post('perusahaan');
        $month = $this->input->post('bln');
        $year = $this->input->post('thn');
        $status = array('Suspect' => 'suspect', 'Prospek' => 'prospek', 'Hot Prospek' => 'hot_prospek', 'SPK' => 'spk', 'DO' => 'do');
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
        foreach ($status as $nama => $value) {
            $prospek = 's_' . $value;
            $tgl = 'tgl_' . $value;
            if ($tgl == 'tgl_hot_prospek') {
                $tgl = 'tgl_h_prospek';
            }

            $perusahaan = "";
            if ($id_perusahaan != "") {
                $perusahaan .= "AND sl.id_perusahaan='$id_perusahaan'";
            }

            $tot = $this->db_wuling->query("SELECT COUNT(p.id_prospek) as total FROM $prospek p JOIN s_customer c ON c.id_prospek=p.id_prospek JOIN adm_sales sl ON sl.id_sales=c.sales WHERE EXTRACT(YEAR_MONTH FROM p.$tgl)='$year$month' $perusahaan")->row()->total;
            $responce->rows[]["c"] = array(
                array(
                    "v" => "$nama",
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
