<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// wuling_marksup_digital_leads

class Wuling_digital_leads_marksup extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('PHPExcel');
        $this->load->model('m_marketing');
        $this->load->model('m_wuling_digital_leads');
    }

    // untuk fungsi default
    public function index()
    {
        $index = 'wuling_marksup';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
            $d['judul'] = "Digital Leads Customer";
            $d['content'] = "pages/digital_leads/wuling_dl_marksup";
            $d['index'] = $index;
            $this->load->view('index', $d);
        }
    }

    // untuk upload po
    public function proses_upload()
    {
        $this->load->library('upload');

        $inputFileName           = $_FILES['excel']['name'];
        $config['upload_path']   = './assets/upload_excel/';
        $config['allowed_types'] = 'xls|xlsx|csv|ods|ots';
        $config['max_size']      = '2048';
        $config['file_name']     = $inputFileName;

        $this->upload->initialize($config);

        $this->upload->do_upload('excel');

        $path = $this->upload->data();

        // $fullPath = $this->upload->data('full_path');
        $fullPath = 'assets/upload_excel/' . $path['file_name'];

        if (!$inputFileName) {
            // apabila terjadi kesalahan
            $data['error'] = "Error loading file " . pathinfo($fullPath, PATHINFO_BASENAME);
        } else {
            // apabila tidak terjadi kesalahan
            $inputFileType = PHPExcel_IOFactory::identify($fullPath);
            $objReader     = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel   = $objReader->load($fullPath);
            $sheet         = $objPHPExcel->getSheet(0);
            $highestRow    = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $data['sheet'] = $sheet;
            $data['baris'] = $highestRow;
            $data['kolom'] = $highestColumn;
            $data['full_path'] = $fullPath;
        }

        $this->load->view('pages/digital_leads/wuling_dl_marksup_view', $data);
    }

    // untuk proses simpan po
    public function simpan_data_leads_digital()
    {
        $id_perusahaan = $this->session->userdata('id_perusahaan');
        $user          = $this->session->userdata('nik');
        $tgl_bagi      = $this->input->post('tanggal_bagi_leads');
        $tgl_masuk     = $this->input->post('tanggal_masuk_leads');
        $fullPath      = $this->input->post('full_path');

        $inputFileType = PHPExcel_IOFactory::identify($fullPath);
        $objReader     = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel   = $objReader->load($fullPath);
        $sheet         = $objPHPExcel->getSheet(0);
        $highestRow    = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        // proses import data
        for ($row = 2; $row <= $highestRow; $row++) {
            $rowData           = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

            if ($this->isEmptyRow(reset($rowData))) {
                continue;
            }

            $leads             = $rowData[0][1];
            $komunikasi        = $rowData[0][2];
            $nama              = $rowData[0][3];
            $keterangan        = $rowData[0][4];
            $kontak            = $rowData[0][5];
            $alamat            = $rowData[0][6];
            $kota              = $rowData[0][7];
            $dealer            = $rowData[0][8];
            $region            = $rowData[0][9];
            $email             = $rowData[0][10];
            $pekerjaan         = $rowData[0][11];
            $rencana_pembelian = $rowData[0][12];
            $info              = $rowData[0][13];

            $data_leads  = array(
                'tgl_bagi'          => $tgl_bagi,
                'tgl_masuk'         => $tgl_masuk,
                'leads'             => $leads,
                'komunikasi'        => $komunikasi,
                'nama_leads'        => $nama,
                'keterangan'        => $keterangan,
                'kontak'            => $kontak,
                'alamat'            => $alamat,
                'kota'              => $kota,
                'dealer'            => $dealer,
                'region'            => $region,
                'email'             => $email,
                'pekerjaan'         => $pekerjaan,
                'rencana_pembelian' => $rencana_pembelian,
                'info'              => $info,
                'id_perusahaan'     => $id_perusahaan,
                'user'              => $user,
            );

            // untuk memilih fungsi insert
            $this->db_wuling->insert('digital_leads', $data_leads);
        }

        unlink($fullPath);

        $response = ['status' => true, 'message' => 'Data berhasil diproses!'];
        echo json_encode($response);
    }

    // untuk hapus baris yang kosong
    public function isEmptyRow($row)
    {
        foreach ($row as $cell) {
            if (null !== $cell) return false;
        }
        return true;
    }
}
