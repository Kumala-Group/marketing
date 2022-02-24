<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// wuling_digital_leads_followup_customer

class Wuling_digital_leads_customer_followup extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
        $this->load->model('m_wuling_digital_leads');
    }

    // function default
    public function index()
    {
        $index = 'wuling_customer_followup';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $d = [
                'judul'         => "Followup Digital Leads",
                'content'       => "pages/digital_leads/wuling_dl_customer_followup",
                'index'         => $index,
            ];
            $this->load->view('index', $d);
        }
    }

    // untuk menampilkan data dalam format datatable
    public function get_data_dt_followup()
    {
        $user = $this->session->userdata('nik');
        $data = $this->m_wuling_digital_leads->customer_leads_followup_dt($user);
        $total = count($data);
        if ($total != 0) {
            $response = ['success' => TRUE, 'recordsTotal' => $total, 'data' => $data];
        } else {
            $response = ['success' => TRUE, 'recordsTotal' => '0', 'data' => ''];
        }
        echo json_encode($response);
    }

    // untuk get data berdasarkan id
    public function update_data_followup()
    {
        $id_digital_leads = $this->input->get('id_digital_leads');
        echo json_encode($this->m_wuling_digital_leads->update_followup($id_digital_leads));
    }

    // untuk simpan data
    public function simpan_data_followup()
    {
        $user = $this->session->userdata('nik');
        $id_perusahaan = $this->session->userdata('id_perusahaan');
        $tanggal          = $this->input->post('tgl_fu');
        $hasil_followup   = $this->input->post('hasil_fu');
        $keterangan       = $this->input->post('keterangan');
        $status           = $this->input->post('status');
        $id_digital_leads = $this->input->post('id_digital_leads');

        if ($status == 4) {
            $update_digital_leads = array(
                'status'     => '2',
                'keterangan' => $keterangan,
            );
            $this->db_wuling->where('id_digital_leads', $id_digital_leads);
            $this->db_wuling->update('digital_leads', $update_digital_leads);
        }
        $cek = cek_duplikat('db_wuling', 'followup_digital_leads', 'id_digital_leads', 'id_digital_leads', $id_digital_leads);
        if ($cek > 0) {
            $data_update_fu  = array(
                'tanggal'        => $tanggal,
                'hasil_followup' => $hasil_followup,
                'keterangan'     => $keterangan,
                'status'         => $status,
            );
            $this->db_wuling->where('id_digital_leads', $id_digital_leads);
            $this->db_wuling->update('followup_digital_leads', $data_update_fu);
        }
        if ($cek == 0) {
            $data_fu = array(
                'id_perusahaan'    => $id_perusahaan,
                'user'             => $user,
                'tanggal'          => $tanggal,
                'id_digital_leads' => $id_digital_leads,
                'hasil_followup'   => $hasil_followup,
                'keterangan'       => $keterangan,
                'status'           => $status,
            );
            $this->db_wuling->insert('followup_digital_leads', $data_fu);
        }
    }
}
