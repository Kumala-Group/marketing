<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wuling_master_keterangan_followup extends CI_Controller
{
    private $list_column = [
        ['', 'id_keterangan_fu', 'hidden'],
        ['Nama keterangan', 'nama_keterangan_fu', 'text'],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->library('PHPExcel');
        $this->load->model('m_marketing');
    }

    public function index()
    {
        $index = 'wuling_master_keterangan_followup';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $d['judul'] = "Data Keterangan Follow Up";
            $d['content'] = "pages/master_digital_leads/wuling/master_keterangan_followup";
            $d['list_column'] = $this->list_column;
            $d['index'] = $index;
            $this->load->view('index', $d);
        }
    }

    public function semua_data()
    {
        $index = 'wuling_master_keterangan_followup';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $this->load->library('datatables');
            $this->datatables->select("d.id_keterangan_fu, d.nama_keterangan_fu,");
            $this->datatables->from('db_wuling.dl_keterangan_fu d');
            echo $this->datatables->generate();
        }
    }

    public function ambil()
    {
        $index = 'wuling_master_keterangan_followup';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $id = $this->input->post('id');
            $this->db_wuling->select('d.id_keterangan_fu, d.nama_keterangan_fu,');
            $this->db_wuling->from('dl_keterangan_fu d');
            $this->db_wuling->where('d.id_keterangan_fu', $id);
            $data = $this->db_wuling->get()->result()[0];
            echo json_encode($data);
        }
    }

    public function hapus()
    {
        $index = 'wuling_master_keterangan_followup';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $id = $this->input->post('id');
            $result = $this->db_wuling->delete('dl_keterangan_fu', ['id_keterangan_fu' => $id]);
            $response = $result ? 'Data berhasil dihapus' : 'Ada masalah menghapus data';
            echo json_encode($response);
        }
    }

    public function simpan()
    {
        $index = 'wuling_master_keterangan_followup';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $data = [];
            foreach ($this->list_column as $kolom) {
                $data[$kolom[1]] = $this->input->post($kolom[1]);
            }

            $result = null;
            $cek_duplikat = $this->db_wuling->select('d.id_keterangan_fu, d.nama_keterangan_fu,')
                ->from('dl_keterangan_fu d')->get()->result();
            foreach ($cek_duplikat as $duplikat) {
                if ($data['nama_keterangan_fu'] == $duplikat->nama_keterangan_fu) $result = 'duplikat_data';
            }

            if ($result != 'duplikat_data') {
                if (!empty($data['id_keterangan_fu'])) {
                    $result = $this->db_wuling->update("dl_keterangan_fu", $data, ['id_keterangan_fu' => $data['id_keterangan_fu']]);
                } else {
                    $result = $this->db_wuling->insert('dl_keterangan_fu', $data);
                }
            }

            if ($result === 'duplikat_data') {
                $response = ['status' => false, 'message' => 'Keterangan sudah digunakan. Silahkan pilih keterangan lain.'];
            } elseif ($result === true) {
                $response = ['status' => true, 'message' => 'Data berhasil disimpan'];
            } else {
                $response = ['status' => false, 'message' => 'Ada masalah menyimpan data'];
            }
            echo json_encode($response);
        }
    }
}
