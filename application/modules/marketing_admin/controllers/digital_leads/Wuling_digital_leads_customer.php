<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// wuling_digital_leads_customer

class Wuling_digital_leads_customer extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
        $this->load->model('m_wuling_digital_leads');
    }

    public function index()
    {
        $index = 'wuling_customer';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $d = [
                'judul'    => "Customer Digital Leads",
                'content'  => "pages/digital_leads/wuling_dl_customer",
                'index'    => $index,
            ];
            $this->load->view('index', $d);
        }
    }

    public function customer_dt()
    {
        $this->m_wuling_digital_leads->customer_leads();
    }

    public function simpan_data()
    {
        $user             = $this->session->userdata('nik');
        $id_perusahaan    = $this->session->userdata('id_perusahaan');
        $id_digital_leads = $this->input->post('cek_list');
        $tanggal          = $this->input->post('tanggal');
        $status           = '1';
        for ($i = 0; $i < count($id_digital_leads); $i++) {
            $cek = cek_duplikat('db_wuling', 'digital_leads', 'id_digital_leads', 'id_digital_leads', $id_digital_leads[$i]);
            if ($cek > 0) {
                $update_data1 = array(
                    'status' => $status,
                );
                $update_data2 = array(
                    'user' => $user,
                );
                $this->db_wuling->where_in('id_digital_leads', $id_digital_leads[$i]);
                $this->db_wuling->update('digital_leads', $update_data1);

                $this->db_wuling->where_in('id_digital_leads', $id_digital_leads[$i]);
                $this->db_wuling->update('followup_digital_leads', $update_data2);
            }
            $cek_data = cek_duplikat('db_wuling',
                'followup_digital_leads',
                'id_digital_leads',
                'id_digital_leads',
                $id_digital_leads[$i]
            );
            if ($cek_data == 0) {
                $insert_data = [
                    'id_perusahaan'    => $id_perusahaan,
                    'user'             => $user,
                    'id_digital_leads' => $id_digital_leads[$i],
                    'tanggal'          => $tanggal,
                    'status'           => $status,
                ];
                $this->db_wuling->insert('followup_digital_leads', $insert_data);
            }
        }
    }
}
