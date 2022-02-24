<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wuling_dl_tambah_excel extends CI_Controller
{
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
        $index = 'wuling_dl_tambah_excel';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $d['judul'] = "Tambah Data Customer";
            $d['content'] = "pages/digital_leads_wuling/wuling_dl_tambah_excel";
            $d['index'] = $index;
            $this->load->view('index', $d);
        }
    }

    public function buat_history_file($nama_file)
    {
        $data['nama_file'] = $nama_file;
        $data['waktu_upload'] = $this->datetime_sekarang();
        $this->db_wuling->insert('digital_leads_files', $data);
    }

    public function proses_upload()
    {
        $index = 'wuling_dl_tambah_excel';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $this->load->library('upload');

            $inputFileName           = $_FILES['excel']['name'];
            $config['upload_path']   = './assets/upload_excel/dl_wuling';
            $config['allowed_types'] = 'xls|xlsx|csv|ods|ots';
            $config['max_size']      = '2048';
            $config['file_name']     = $inputFileName;

            $this->upload->initialize($config);

            $cek_upload = $this->upload->do_upload('excel');
            // $cek_error = $this->upload->display_errors('<p>', '</p>');

            $path = $this->upload->data();
            $fullPath = 'assets/upload_excel/dl_wuling/' . $path['file_name'];

            if (!$cek_upload) {
                // apabila terjadi kesalahan
                $data['sheet'] = '';
                $data['baris'] = '';
                $data['kolom'] = '';
                $data['full_path'] = $fullPath;
                $data['error_msg'] = "Error loading file " . pathinfo($fullPath, PATHINFO_BASENAME);
            } else {
                // apabila tidak terjadi kesalahan
                $this->buat_history_file($path['file_name']);
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
                $data['error_msg'] = '';
            }
            $this->load->view('pages/digital_leads_wuling/wuling_dl_tambah_excel_view', $data);
        }
    }

    public function simpan_data_leads_digital()
    {
        $index = 'wuling_dl_tambah_excel';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $fullPath      = $this->input->post('full_path');

            $inputFileType = PHPExcel_IOFactory::identify($fullPath);
            $objReader     = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel   = $objReader->load($fullPath);
            $sheet         = $objPHPExcel->getSheet(0);
            $highestRow    = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $cabang_error = false;
            $cabang_text = '';
            $telp_error = false;
            $telp_text = '';

            for ($row = 2; $row <= $highestRow; $row++) {
                $rowData       = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                if ($this->isEmptyRow(reset($rowData))) {
                    continue;
                }

                // cek input dealer
                $cabang_upper  = strtoupper($rowData[0][10]);
                $id_cabang     = $this->db->query(
                    "SELECT id_perusahaan FROM perusahaan WHERE lokasi='$cabang_upper' AND id_brand='5' AND kode_perusahaan != '0'"
                )->result_array();
                if (empty($id_cabang[0]['id_perusahaan'])) {
                    if (!$cabang_error) $cabang_text .= ' Ada input dealer yang salah di baris: ';
                    $cabang_text .= $row . ', ';
                    $cabang_error = true;
                }

                // cek no telp
                $no_telp        = $rowData[0][6];
                $data_telp      = $this->db_wuling->query(
                    "SELECT nama, no_telp FROM digital_leads_customer WHERE no_telp='$no_telp'"
                )->result_array();
                if (!empty($data_telp[0]['no_telp'])) {
                    if (!$telp_error) $telp_text .= ' Ada duplikat no. telp. di baris: ';
                    $telp_text .= $row . ', ';
                    $telp_error = true;
                }
            }

            if ($cabang_error) {
                $cabang_text = rtrim($cabang_text, ', ');
                $cabang_text .= ';';
            }
            if ($telp_error) {
                $telp_text = rtrim($telp_text, ', ');
                $telp_text .= '.';
            }

            if ($cabang_error || $telp_error) {
                $response = [
                    'status' => false, 'message' => 'Ada kesalahan ketika memasukkan data:'
                        . $cabang_text
                        . $telp_text
                ];
                echo json_encode($response);
                return;
            }

            // proses import data
            for ($row = 2; $row <= $highestRow; $row++) {
                $rowData           = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                if ($this->isEmptyRow(reset($rowData))) {
                    continue;
                }

                $tgl_masuk_leads    = gmdate("Y-m-d", ($rowData[0][0] - 25569) * 86400);
                $tgl_bagi_leads     = gmdate("Y-m-d", ($rowData[0][1] - 25569) * 86400);
                $bulan              = gmdate("M", ($rowData[0][1] - 25569) * 86400);
                $lead_source        = $rowData[0][3];
                $komunikasi         = $rowData[0][4];
                $nama               = $rowData[0][5];
                $no_telp            = $rowData[0][6];
                $keterangan         = $rowData[0][7];
                $alamat             = $rowData[0][8];
                $kota               = $rowData[0][9];
                $dealer             = $rowData[0][10];
                $email              = $rowData[0][12];
                $pekerjaan          = $rowData[0][13];
                $rencana_pembelian  = $rowData[0][14];
                $info_yg_dibutuhkan = $rowData[0][15];
                $tipe_mobil         = $rowData[0][17];
                $brand_lain         = $rowData[0][18];
                $id_status_customer = '1'; // Belum Follow Up
                $cabang_upper       = strtoupper($dealer);
                $id_cabang          = $this->db->query(
                    "SELECT id_perusahaan FROM perusahaan WHERE lokasi='$cabang_upper' AND id_brand='5' AND kode_perusahaan != '0'"
                )->result_array()[0]['id_perusahaan'];

                $data_leads  = array(
                    'id_perusahaan '     => $id_cabang,
                    'tgl_masuk_leads'    => $tgl_masuk_leads,
                    'tgl_bagi_leads'     => $tgl_bagi_leads,
                    'bulan'              => $bulan,
                    'lead_source'        => $lead_source,
                    'komunikasi'         => $komunikasi,
                    'nama'               => $nama,
                    'no_telp'            => ltrim($no_telp, '0'),
                    'keterangan'         => $keterangan,
                    'alamat'             => $alamat,
                    'kota'               => $kota,
                    'email'              => $email,
                    'pekerjaan'          => $pekerjaan,
                    'rencana_pembelian'  => $rencana_pembelian,
                    'info_yg_dibutuhkan' => $info_yg_dibutuhkan,
                    'tipe_mobil'         => $tipe_mobil,
                    'brand_lain'         => $brand_lain,
                    'id_status_customer' => $id_status_customer,
                    'w_insert'           => $this->datetime_sekarang(),
                    'w_update'           => $this->datetime_sekarang()
                );

                // untuk memilih fungsi insert
                $this->db_wuling->insert('digital_leads_customer', $data_leads);
                $insert_id   = $this->db_wuling->insert_id();
                $nol         = str_repeat("0", 6 - strlen($insert_id));
                $kd_customer = 'DLC-WUL-' . $nol . $insert_id;
                $this->db_wuling->update(
                    'digital_leads_customer',
                    ['id_customer_digital' => $kd_customer],
                    ['id_dl_customer' => $insert_id]
                );
            }

            // unlink($fullPath); 

            $response = ['status' => true, 'message' => 'Data berhasil diproses!'];
            echo json_encode($response);
        }
    }

    // untuk hapus baris yang kosong
    public function isEmptyRow($row)
    {
        foreach ($row as $cell) {
            if (null !== $cell) return false;
        }
        return true;
    }

    public function history_file()
    {
        $index = 'wuling_dl_tambah_excel';
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng', $index)) {
            $this->load->library('datatables');
            $this->datatables->select('dl.id_file,
                                    dl.nama_file,
                                    dl.waktu_upload');
            $this->datatables->from('db_wuling.digital_leads_files as dl');
            echo $this->datatables->generate();
        }
    }
}
