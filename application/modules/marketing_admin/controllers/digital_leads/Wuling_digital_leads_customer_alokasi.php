<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// wuling_digital_leads_alokasi_customer

class Wuling_digital_leads_customer_alokasi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
        $this->load->model('m_wuling_digital_leads');
    }

    // fungsi default
    public function index()
    {
        $index = 'wuling_customer_alokasi';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $d = [
                'judul'   => "Alokasi Customer Digital Leads",
                'content' => "pages/digital_leads/wuling_dl_customer_alokasi",
                'index'   => $index,
                'sales'   => $this->m_wuling_digital_leads->data_sales()
            ];
            $this->load->view('index', $d);
        }
    }

    // untuk menampilkan data dalam format datatable
    public function get_data_dt_alokasi()
    {
        $user = $this->session->userdata('nik');
        $data = $this->m_wuling_digital_leads->customer_leads_alokasi_dt($user);
        $total = count($data);
        if ($total != 0) {
            $response = ['success' => TRUE, 'recordsTotal' => $total, 'data' => $data];
        } else {
            $response = ['success' => TRUE, 'recordsTotal' => '0', 'data' => ''];
        }
        echo json_encode($response);
    }

    // untuk menampilkan data history customer
    public function get_data_dt_history()
    {
        $id_digital_leads = $this->input->get('id_digital_leads');
        $data = $this->m_wuling_digital_leads->customer_leads_history_dt($id_digital_leads);
        echo json_encode($data);
    }

    // untuk simpan data
    public function simpan()
    {
        $id_perusahaan = $this->session->userdata('id_perusahaan');
        $user = $this->session->userdata('nik');
        $id_digital_leads = $this->input->post('id_digital_leads');
        $id_sales         = $this->input->post('sales');

        $data = $this->db_wuling
            ->select('*')
            ->from('followup_digital_leads')
            ->where('id_digital_leads', $id_digital_leads)
            ->get()
            ->row();

        $data_alokasi = array(
            'id_digital_leads' => $id_digital_leads,
            'id_sales'         => $id_sales,
            'status_customer'  => $data->status,
            'id_perusahaan'    => $id_perusahaan,
            'user'             => $user,
        );

        $this->db_wuling->insert('sales_alokasi', $data_alokasi);
    }
}
