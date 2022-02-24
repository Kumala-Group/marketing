<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wuling_dl_cust_lost extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('PHPExcel');
        $this->load->model('m_marketing');
        $this->load->model('m_wuling_dl_followup');
    }

    public function index()
    {
        $index = 'wuling_dl_cust_lost';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,SDIGM,tm_w', $index)) {
            $d['judul'] = "Daftar Customer Lost";
            $d['content'] = "pages/digital_leads_wuling/wuling_dl_cust_lost";
            $d['index'] = $index;
            $this->load->view('index', $d);
        }
    }

    public function _query_awal()
    {
        return
            "SELECT
                sfc.id_dl_customer,
                sfc.tgl_fu,
                dlc.id_customer_digital,
                dlc.nama,
                dlc.alamat,
                dlc.kota,
                dlc.no_telp,
                p.lokasi,
                u.nama_lengkap,
                dls.id_sales,
                dls.id,
                dlc.id_perusahaan
            FROM
                db_wuling.digital_leads_followup AS sfc
            LEFT JOIN db_wuling.digital_leads_customer AS dlc ON sfc.id_dl_customer = dlc.id_dl_customer
            LEFT JOIN kmg.perusahaan AS p ON dlc.id_perusahaan = p.id_perusahaan
            LEFT JOIN db_wuling.dl_sales AS dls ON dlc.id_perusahaan = dls.id_perusahaan
            LEFT JOIN kumalagroup.users AS u ON dls.id_sales = u.id
            LEFT JOIN db_wuling.dl_status_customer AS sc ON sfc.id_status_customer = sc.id_status_customer
            LEFT JOIN db_wuling.dl_status_fu AS sfu ON sfc.id_status_fu = sfu.id_status_fu
            INNER JOIN (
                SELECT
                    sfc.id_dl_customer,
                    max( sfc.tgl_fu ) AS tgl_max 
                FROM
                    db_wuling.digital_leads_followup AS sfc
                GROUP BY
                    sfc.id_dl_customer
                ) AS fu_join ON sfc.id_dl_customer = fu_join.id_dl_customer 
            WHERE sfc.tgl_fu = fu_join.tgl_max
            AND dlc.id_status_customer=6 ";
    }

    public function _query_search($search)
    {
        return
            "dlc.nama LIKE '%$search%' ESCAPE '!' 
            OR dlc.id_customer_digital LIKE '%$search%' ESCAPE '!' 
            OR fu_join.tgl_max LIKE '%$search%' ESCAPE '!' 
            OR dlc.no_telp LIKE '%$search%' ESCAPE '!' 
            OR dlc.alamat LIKE '%$search%' ESCAPE '!' 
            OR dlc.kota LIKE '%$search%' ESCAPE '!' 
            OR p.lokasi LIKE '%$search%' ESCAPE '!' ";
    }

    public function _query_tgl()
    {
        $tgl_awal = $this->input->post('tgl_awal') ?? $this->input->get('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir') ?? $this->input->get('tgl_akhir');
        if ($tgl_awal && $tgl_akhir) {
            return " AND fu_join.tgl_max BETWEEN '"
                . $tgl_awal . "' AND '" . $tgl_akhir . "' ";
        }
    }

    public function _filter($search, $limit, $start, $order_field, $order_ascdesc)
    {
        return $this->db_wuling->query(
            $this->_query_awal() .
                "AND(" . $this->_query_search($search)  . ")" . $this->_query_tgl() . "
                ORDER BY $order_field $order_ascdesc 
                LIMIT $start, $limit"
        )->result_array();
    }

    public function _count_all()
    {
        return $this->db_wuling->query($this->_query_awal())->num_rows();
    }

    public function _count_filter($search)
    {
        return $this->db_wuling->query(
            $this->_query_awal() .
                "AND(" . $this->_query_search($search) . ")"
        )->num_rows();
    }

    public function query_cetak()
    {
        return $this->db_wuling->query(
            $this->_query_awal() .
                "AND(" . $this->_query_search('')  . ")" . $this->_query_tgl()
        );
    }

    public function daftar_customer_lost()
    {
        $index = 'wuling_dl_cust_lost';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,SDIGM,tm_w', $index)) {
            $search         = $this->input->post('search')['value'];
            $limit          = $this->input->post('length');
            $start          = $this->input->post('start');
            $order_index    = $this->input->post('order')[0]['column'];
            $order_field    = $this->input->post('columns')[$order_index]['data'];
            $order_ascdesc  = $this->input->post('order')[0]['dir'];
            $sql_total      = $this->_count_all();
            $sql_data       = $this->_filter($search, $limit, $start, $order_field, $order_ascdesc);
            $sql_filter     = $this->_count_filter($search);
            $callback       = [
                'draw' => $this->input->post('draw'),
                'recordsTotal' => $sql_total,
                'recordsFiltered' => $sql_filter,
                'data' => $sql_data
            ];
            header('Content-Type: application/json');
            echo json_encode($callback);
        }
    }

    public function export_excel()
    {

        $dta = $this->query_cetak();
        $num = $dta->num_rows();
        $no  = 1;

        if ($num > 0) {
            foreach ($dta->result() as $row) {

                $result[] = [
                    'no'                     => $no++,
                    'id_customer_digital'    => $row->id_customer_digital,
                    'tgl_follow_up_terakhir' => tgl_sql($row->tgl_fu),
                    'nama'                   => $row->nama,
                    'no_telp'                => $row->no_telp,
                    'alamat'                 => $row->alamat,
                    'kota'                   => $row->kota,
                    'cabang'                 => $row->lokasi
                ];
            }
        } else {
            $result[] = array(
                'no'                     => $no++,
                'id_customer_digital'    => 'Data Kosong!',
                'tgl_follow_up_terakhir' => 'Data Kosong!',
                'nama'                   => 'Data Kosong!',
                'no_telp'                => 'Data Kosong!',
                'alamat'                 => 'Data Kosong!',
                'kota'                   => 'Data Kosong!',
                'cabang'                 => 'Data Kosong!',
            );
        }

        $exportExcel = new PHPExport;
        $exportExcel->dataSet($result)
            ->rataTengah('0,1,2,3,4,5,6,7')
            ->warnaHeader('2,218,240', 'FFFFFF')
            ->excel2003('History Follow Up Customer - ' . date('YmdHis'));
    }
}
