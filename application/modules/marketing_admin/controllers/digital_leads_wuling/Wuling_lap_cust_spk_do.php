<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wuling_lap_cust_spk_do extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('PHPExcel');
        $this->load->model('m_marketing');
        $this->load->model('m_lap_wuling_cust_spk_do');
    }

    public function index()
    {
        $index = 'wuling_lap_cust_spk_do';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktg,SDIGM', $index)) {
            $d['judul'] = "Laporan Customer SPK & DO Wuling";
            $d['content'] = "pages/digital_leads_wuling/laporan/wuling_lap_cust_spk_do";
            $d['index'] = $index;
            $this->load->view('index', $d);
        }
    }

    public function ambil_data()
    {
        $index = 'wuling_lap_cust_spk_do';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktg,SDIGM', $index)) {
            $search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
            $limit = $_POST['length']; // Ambil data limit per page
            $start = $_POST['start']; // Ambil data start
            $order_index = $_POST['order'][0]['column']; // Untuk mengambil index yg menjadi acuan untuk sorting
            $order_field = $_POST['columns'][$order_index]['data']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
            $order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
            $sql_total = $this->m_lap_wuling_cust_spk_do->count_all(); // Panggil fungsi count_all pada m_lap_wuling_cust_spk_do
            $sql_data = $this->m_lap_wuling_cust_spk_do->filter($search, $limit, $start, $order_field, $order_ascdesc); // Panggil fungsi filter pada m_lap_wuling_cust_spk_do
            $sql_filter = $this->m_lap_wuling_cust_spk_do->count_filter($search); // Panggil fungsi count_filter pada m_lap_wuling_cust_spk_do
            $callback = array(
                'draw' => $_POST['draw'], // Ini dari datatablenya
                'recordsTotal' => $sql_total,
                'recordsFiltered' => $sql_filter,
                'data' => $sql_data
            );
            header('Content-Type: application/json');
            echo json_encode($callback); // Convert array $callback ke json
        }
    }

    public function export_excel()
    {
        $dta = $this->m_lap_wuling_cust_spk_do->query_cetak();
        $num = $dta->num_rows();
        $no  = 1;

        if ($num > 0) {
            foreach ($dta->result() as $row) {

                $result[] = [
                    'no'                      => $no++,
                    'id_customer_digital'     => $row->id_customer_digital,
                    'id_prospek'              => $row->id_prospek,
                    'nama_customer_digital'   => $row->nama_customer_digital,
                    'nama_customer_cabang'    => $row->nama_customer_cabang,
                    'cabang'                  => $row->lokasi,
                    'tgl_spk'                 => $row->tgl_spk,
                    'tgl_do'                  => $row->tgl_do,
                ];
            }
        } else {
            $result[] = array(
                'no'                      => $no++,
                'id_customer_digital'     => 'Data Kosong!',
                'id_prospek'              => 'Data Kosong!',
                'nama_customer_digital'   => 'Data Kosong!',
                'nama_customer_cabang'    => 'Data Kosong!',
                'cabang'                  => 'Data Kosong!',
                'tgl_spk'                 => 'Data Kosong!',
                'tgl_do'                  => 'Data Kosong!',
            );
        }

        $exportExcel = new PHPExport;
        $exportExcel->dataSet($result)
            ->rataTengah('0,1,2,3,4,5,6')
            ->warnaHeader('2,218,240', 'FFFFFF')
            ->excel2003('Laporan Customer SPK & DO - ' . date('Y-m-d H-i-s'));
    }
}
