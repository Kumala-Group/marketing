<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wuling_dl_tambah_satuan extends CI_Controller
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
    }

    public function datetime_sekarang()
    {
        $date = new \DateTime(date('Y-m-d H:i:s'));
        $date->setTimezone(new \DateTimeZone('Asia/Makassar'));
        return $date->format('Y-m-d H:i:s');
    }

    public function index()
    {
        $index = 'wuling_dl_tambah_satuan';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $d['judul'] = "Tambah Customer Digital";
            $d['content'] = "pages/digital_leads_wuling/wuling_dl_tambah_satuan";
            $d['list_column'] = $this->list_column;
            $d['index'] = $index;
            $this->load->view('index', $d);
        }
    }

    public function simpan_customer()
    {
        $index = 'wuling_dl_tambah_satuan';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            // cek no telp
            $telp_error = false;
            $no_telp        = $this->input->post('no_telp');
            $data_telp      = $this->db_wuling->query(
                "SELECT no_telp FROM digital_leads_customer WHERE no_telp='$no_telp'"
            )->result_array();
            if (!empty($data_telp[0]['no_telp'])) {
                $telp_error = true;
            }

            if ($telp_error) {
                $response = [
                    'status' => false,
                    'message' => 'Ada kesalahan ketika memasukkan data: Ada duplikat no. telp.'
                ];
                echo json_encode($response);
                return;
            }

            $data = [];
            foreach ($this->list_column as $kolom) {
                $data[$kolom[1]] = $this->input->post($kolom[1]);
            }

            $cabang_upper  = strtoupper($this->input->post('dealer'));
            $data['id_perusahaan']        = $this->db->query(
                "SELECT id_perusahaan FROM perusahaan WHERE lokasi='$cabang_upper' 
                AND id_brand='5' AND kode_perusahaan NOT IN ('0','HO')"
            )->result_array()[0]['id_perusahaan'];

            $data['no_telp']              = ltrim($data['no_telp'], '0');
            $data['bulan']                = getBulan(date('m', strtotime($this->input->post('tgl_bagi_leads'))));
            $data['id_status_customer']   = '1';
            $data['w_insert']             = $this->datetime_sekarang();
            $data['w_update']             = $this->datetime_sekarang();

            if ($this->db_wuling->insert('digital_leads_customer', $data)) {
                $insert_id   = $this->db_wuling->insert_id();
                $nol         = str_repeat("0", 6 - strlen($insert_id));
                $kd_customer = 'DLC-WUL-' . $nol . $insert_id;
                if ($this->db_wuling->update(
                    'digital_leads_customer',
                    ['id_customer_digital' => $kd_customer],
                    ['id_dl_customer' => $insert_id]
                )) {
                    echo json_encode(['status' => true,  'message' => 'Data berhasil diproses!']);
                } else {
                    echo json_encode(['status' => false, 'message' => 'Ada masalah dalam menyimpan data!']);
                }
            } else {
                echo json_encode(['status' => false, 'message' => 'Ada masalah dalam menyimpan data!']);
            }
        }
    }

    public function daftar_cabang()
    {
        echo json_encode($this->db->query(
            "SELECT id_perusahaan, lokasi FROM perusahaan WHERE id_brand='5'
            AND kode_perusahaan NOT IN ('0','HO') ORDER BY lokasi ASC"
        )->result());
    }
}
