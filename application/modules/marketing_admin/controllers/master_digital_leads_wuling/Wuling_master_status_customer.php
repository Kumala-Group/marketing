<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wuling_master_status_customer extends CI_Controller
{
    private $list_column = [
        ['', 'id_status_customer', 'hidden'],
        ['Nama Status', 'nama_status_customer', 'text'],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->library('PHPExcel');
        $this->load->model('m_marketing');
    }

    public function index()
    {
        $index = 'wuling_master_status_customer';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $d['judul'] = "Data Status Customer";
            $d['content'] = "pages/master_digital_leads/wuling/master_status_customer";
            $d['list_column'] = $this->list_column;
            $d['index'] = $index;
            $this->load->view('index', $d);
        }
    }

    public function semua_data()
    {
        $index = 'wuling_master_status_customer';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $this->load->library('datatables');
            $this->datatables->select("d.id_status_customer,d.nama_status_customer");
            $this->datatables->from('db_wuling.dl_status_customer d');
            echo $this->datatables->generate();
        }
    }

    public function ambil()
    {
        $index = 'wuling_master_status_customer';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $id = $this->input->post('id');
            $this->db_wuling->select('d.id_status_customer, d.nama_status_customer');
            $this->db_wuling->from('dl_status_customer d');
            $this->db_wuling->where('d.id_status_customer', $id);
            $data =  $this->db_wuling->get()->result()[0];
            echo json_encode($data);
        }
    }

    public function hapus()
    {
        $index = 'wuling_master_status_customer';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $id = $this->input->post('id');
            $result = $this->db_wuling->delete('dl_status_customer', ['id_status_customer' => $id]);
            $response = $result ? 'Data berhasil dihapus' : 'Ada masalah menghapus data';
            echo json_encode($response);
        }
    }

    public function simpan()
    {
        $index = 'wuling_master_status_customer';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $data = [];
            foreach ($this->list_column as $kolom) {
                $data[$kolom[1]] = $this->input->post($kolom[1]);
            }

            $result = null;
            $cek_duplikat = $this->db_wuling->select('d.id_status_customer, d.nama_status_customer')
                ->from('dl_status_customer d')->get()->result();
            foreach ($cek_duplikat as $duplikat) {
                if ($data['nama_status_customer'] == $duplikat->nama_status_customer) $result = 'duplikat_data';
            }

            if ($result != 'duplikat_data') {
                if (!empty($data['id_status_customer'])) {
                    $result = $this->db_wuling->update("dl_status_customer", $data, ['id_status_customer' => $data['id_status_customer']]);
                } else {
                    $result = $this->db_wuling->insert('dl_status_customer', $data);
                }
            }

            if ($result === 'duplikat_data') {
                $response = ['status' => false, 'message' => 'Nama sudah digunakan. Silahkan pilih nama lain.'];
            } elseif ($result === true) {
                $response = ['status' => true, 'message' => 'Data berhasil disimpan'];
            } else {
                $response = ['status' => false, 'message' => 'Ada masalah menyimpan data'];
            }
            echo json_encode($response);
        }
    }
}
