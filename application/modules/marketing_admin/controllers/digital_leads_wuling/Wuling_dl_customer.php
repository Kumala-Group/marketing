<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wuling_dl_customer extends CI_Controller
{
    private $list_column = [
        ['', 'id_dl_customer', 'hidden'],
        ['ID Customer', 'id_customer_digital', 'hidden'],
        ['Tgl Masuk Leads', 'tgl_masuk_leads', 'hidden'],
        ['Tgl Bagi Leads', 'tgl_bagi_leads', 'hidden'],
        ['Lead Source', 'lead_source', 'text'],
        ['Komunikasi', 'komunikasi', 'text'],
        ['Nama', 'nama', 'text'],
        ['No. Telp', 'no_telp', 'text'],
        ['Keterangan', 'keterangan', 'text'],
        ['Alamat', 'alamat', 'text'],
        ['Kota/Kabupaten', 'kota', 'text'],
        ['Dealer', 'id_perusahaan', 'select'],
        ['Email', 'email', 'text'],
        ['Pekerjaan', 'pekerjaan', 'text'],
        ['Rencana Pembelian Mobil', 'rencana_pembelian', 'text'],
        ['Info Yang Dibutuhkan', 'info_yg_dibutuhkan', 'text'],
        ['Tipe Mobil', 'tipe_mobil', 'text'],
        ['Brand Lain/Model', 'brand_lain', 'text'],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->library('PHPExcel');
        $this->load->model('m_marketing');
        $this->load->model('m_wuling_dl_customer');
        $this->load->model('m_wuling_dl_followup');
    }

    public function datetime_sekarang()
    {
        $date = new \DateTime(date('Y-m-d H:i:s'));
        $date->setTimezone(new \DateTimeZone('Asia/Makassar'));
        return $date->format('Y-m-d H:i:s');
    }

    public function index()
    {
        $index = 'wuling_dl_customer';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $d['judul'] = "Daftar Customer Digital Wuling";
            $d['content'] = "pages/digital_leads_wuling/customer_digital_leads/wuling_dl_customer";
            $d['list_column'] = $this->list_column;
            $d['index'] = $index;
            $this->load->view('index', $d);
        }
    }

    public function data_customer()
    {
        $index = 'wuling_dl_customer';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $this->m_wuling_dl_customer->data_customer();
        }
    }

    public function get_customer()
    {
        $index = 'wuling_dl_customer';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $id = $this->input->post('id');
            $data = $this->m_wuling_dl_customer->get_data_customer($id);
            echo json_encode($data);
        }
    }

    public function hapus_customer()
    {
        $index = 'wuling_dl_customer';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $id = $this->input->post('id');
            $this->m_wuling_dl_customer->hapus_data_customer($id);
            $response = ['status' => true, 'message' => 'Data berhasil dihapus!'];
            echo json_encode($response);
        }
    }

    public function simpan_customer()
    {
        $index = 'wuling_dl_customer';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $data = [];
            foreach ($this->list_column as $kolom) {
                $data[$kolom[1]] = $this->input->post($kolom[1]);
            }
            $data['w_update'] = $this->datetime_sekarang();

            $this->m_wuling_dl_customer->simpan_data_customer($data);
            echo 'Data Sukses diUpdate';
        }
    }

    public function tambah_ke_followup()
    {
        $index = 'wuling_dl_customer';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {

            $cek_list = $this->input->post('cek_list');
            $data['w_update'] = $this->datetime_sekarang();
            foreach ($cek_list as $list) {
                $data['id_dl_customer']         = $list;
                $data['id_status_customer']     = '3'; // 3 = Follow Up 1
                $this->m_wuling_dl_customer->simpan_data_customer($data);
                // tambah status follow up
                $data_fu['id_dl_customer']      = $list;
                $data_fu['id_perusahaan']       = $this->db_wuling->query(
                    "SELECT id_perusahaan FROM digital_leads_customer
                    WHERE digital_leads_customer.id_dl_customer = $list"
                )->result()[0]->id_perusahaan;
                $data_fu['id_status_customer']  = '3'; // Follow Up 1
                $data_fu['id_status_fu']        = '1'; // Hold Leads
                $data_fu['tgl_fu']              = $this->input->post('tanggal');
                $data_fu['w_insert']            = $data['w_update'];
                $data_fu['w_update']            = $data['w_update'];
                $this->m_wuling_dl_followup->simpan_status_fu_cutomer($data_fu);
            }

            $response = ['status' => true, 'message' => 'Data berhasil ditambahkan!'];
            echo json_encode($response);
        }
    }
}
