<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wuling_history_fu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('PHPExcel');
        $this->load->model('m_marketing');
        $this->load->model('m_wuling_history_fu');
    }

    public function index()
    {
        $index = 'wuling_history_fu';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktg,SDIGM', $index)) {
            $d['judul'] = "Laporan History Follow Up Customer Wuling";
            $d['content'] = "pages/digital_leads_wuling/laporan/wuling_history_fu";
            $d['index'] = $index;
            $this->load->view('index', $d);
        }
    }

    public function semua_data()
    {
        $index = 'wuling_history_fu';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktg,SDIGM', $index)) {
            $search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
            $limit = $_POST['length']; // Ambil data limit per page
            $start = $_POST['start']; // Ambil data start
            $order_index = $_POST['order'][0]['column']; // Untuk mengambil index yg menjadi acuan untuk sorting
            $order_field = $_POST['columns'][$order_index]['data']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
            $order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
            $sql_total = $this->m_wuling_history_fu->count_all(); // Panggil fungsi count_all pada m_wuling_history_fu
            $sql_data = $this->m_wuling_history_fu->filter($search, $limit, $start, $order_field, $order_ascdesc); // Panggil fungsi filter pada m_wuling_history_fu
            $sql_filter = $this->m_wuling_history_fu->count_filter($search); // Panggil fungsi count_filter pada m_wuling_history_fu
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

    public function data_sales_digital()
    {
        echo json_encode($this->kumalagroup->query(
            "SELECT DISTINCT
                kumalagroup.users.id,
                kumalagroup.users.nama_lengkap 
            FROM kumalagroup.users
            JOIN db_wuling.dl_sales ON kumalagroup.users.id = dl_sales.id_sales
        ")->result());
    }

    public function data_sales_force()
    {
        echo json_encode($this->db_wuling->distinct(
            "adms.id_sales,
            k.nama_karyawan"
        )
            ->from("adm_sales adms")
            ->join("s_customer scu", "adms.id_sales = scu.sales")
            ->join("kmg.karyawan k", "adms.id_sales = k.id_karyawan")
            ->join("digital_leads_customer dlc", "scu.id_cus_digital = dlc.id_customer_digital")
            ->get()->result());
    }

    // untuk export data ke excel
    public function export_excel()
    {

        $dta = $this->m_wuling_history_fu->query_cetak();
        $num = $dta->num_rows();
        $no  = 1;

        if ($num > 0) {
            foreach ($dta->result() as $row) {

                $result[] = [
                    'no'                  => $no++,
                    'nama_customer'       => $row->nama,
                    'no_telp'             => $row->no_telp,
                    'alamat'              => $row->alamat,
                    'id_customer_digital' => $row->id_customer_digital,
                    'status_customer'     => $row->nama_status_customer,
                    'status_follow_up'    => $row->nama_status_fu,
                    'cabang'              => $row->lokasi,
                    'tgl_follow_up'       => tgl_sql($row->tgl_fu),
                    'tgl_spk'             => $row->tgl_spk,
                    'tgl_do'              => $row->tgl_do,
                    'sales_digital'       => $row->sales_digital,
                    'sales_force'         => $row->sales_force,
                    'id_prospek'          => $row->id_prospek,
                ];
            }
        } else {
            $result[] = array(
                'no'                  => $no++,
                'nama_customer'       => 'Data Kosong!',
                'no_telp'             => 'Data Kosong!',
                'alamat'              => 'Data Kosong!',
                'id_customer_digital' => 'Data Kosong!',
                'status_customer'     => 'Data Kosong!',
                'status_follow_up'    => 'Data Kosong!',
                'cabang'              => 'Data Kosong!',
                'tgl_follow_up'       => 'Data Kosong!',
                'tgl_spk'             => 'Data Kosong!',
                'tgl_do'              => 'Data Kosong!',
                'sales_digital'       => 'Data Kosong!',
                'sales_force'         => 'Data Kosong!',
                'id_prospek'          => 'Data Kosong!',
            );
        }

        $exportExcel = new PHPExport;
        $exportExcel->dataSet($result)
            ->rataTengah('0,1,2,3')
            ->fieldAccounting('4,5,6')
            ->warnaHeader('2,218,240', 'FFFFFF')
            ->excel2003('History Follow Up Customer - ' . date('YmdHis'));
    }
}
