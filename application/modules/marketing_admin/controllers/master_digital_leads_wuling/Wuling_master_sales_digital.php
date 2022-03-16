<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wuling_master_sales_digital extends CI_Controller
{
    private $list_column = [
        ['', 'id', 'hidden'],
        ['Cabang', 'id_perusahaan', 'select'],
        ['Sales Digital', 'id_sales', 'select'],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->library('PHPExcel');
        $this->load->model('m_marketing');
    }

    public function index()
    {
        $index = 'wuling_master_sales_digital';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $d['judul'] = "Sales Digital";
            $d['content'] = "pages/master_digital_leads/wuling/master_sales_digital";
            $d['list_column'] = $this->list_column;
            $d['index'] = $index;
            $this->load->view('index', $d);
        }
    }

    public function daftar_cabang()
    {
        echo json_encode($this->db->query(
            "SELECT id_perusahaan, lokasi FROM perusahaan WHERE id_brand='5'
            AND kode_perusahaan NOT IN ('0','HO') ORDER BY lokasi ASC"
        )->result());
    }

    public function daftar_sales()
    {
        echo json_encode($this->kumalagroup->query(
            "SELECT id, nama_lengkap FROM users WHERE id_jabatan='171'
            ORDER BY nama_lengkap ASC"
        )->result());
    }

    public function semua_data()
    {
        $index = 'wuling_master_sales_digital';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $this->load->library('datatables');
            $this->datatables->select("
                d.id,
                d.id_perusahaan,
                d.id_sales,
                p.lokasi,
                k.nama_lengkap,
            ");
            $this->datatables->from('db_wuling.dl_sales d');
            $this->datatables->join('kumk6797_kmg.perusahaan p', 'd.id_perusahaan = p.id_perusahaan', 'LEFT');
            $this->datatables->join('kumk6797_kumalagroup.users k', 'd.id_sales = k.id', 'LEFT');
            echo $this->datatables->generate();
        }
    }

    public function ambil()
    {
        $index = 'wuling_master_sales_digital';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $id = $this->input->post('id');
            $this->db_wuling->select('
                d.id,
                d.id_perusahaan,
                d.id_sales,
            ');
            $this->db_wuling->from('dl_sales d');
            $this->db_wuling->where('d.id', $id);
            $data =  $this->db_wuling->get()->result()[0];
            echo json_encode($data);
        }
    }

    public function simpan()
    {
        $index = 'wuling_master_sales_digital';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $data = [];
            foreach ($this->list_column as $kolom) {
                $data[$kolom[1]] = $this->input->post($kolom[1]);
            }

            $result = null;
            $cek_duplikat = $this->db_wuling->select('d.id, d.id_perusahaan')
                ->from('dl_sales d')->get()->result();
            foreach ($cek_duplikat as $duplikat) {
                if (
                    $data['id_perusahaan'] == $duplikat->id_perusahaan
                    &&
                    $data['id'] != $duplikat->id
                ) {
                    $result = 'duplikat_data';
                }
            }

            if ($result != 'duplikat_data') {
                if (!empty($data['id'])) {
                    $result = $this->db_wuling->update("dl_sales", $data, ['id' => $data['id']]);
                } else {
                    $result = $this->db_wuling->insert('dl_sales', $data);
                }
            }

            if ($result === 'duplikat_data') {
                $response = ['status' => false, 'message' => 'Cabang sudah digunakan. Silahkan pilih cabang lain.'];
            } elseif ($result === true) {
                $response = ['status' => true, 'message' => 'Data berhasil disimpan'];
            } else {
                $response = ['status' => false, 'message' => 'Ada masalah menyimpan data'];
            }
            echo json_encode($response);
        }
    }
}
