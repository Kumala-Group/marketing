<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Master_customer extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');
        $this->load->model('m_wuling_marketing_support');
    }
    public function index()
    {
        $index = "wuling_master_cust";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
            $post = $this->input->post();
            if ($post) {
                if (!empty($post['datatable'])) echo $this->m_wuling_marketing_support->master_customer($post['perusahaan']);
            } else {
                $d['content'] = "pages/marketing_support/wuling/master_customer";
                $d['index'] = $index;
                $d['lokasi'] = q_data("*", 'kumk6797_kmg.perusahaan', ['id_brand' => 5])->result();
                $this->load->view('index', $d);
            }
        }
    }
    public function export()
    {
        $id_perusahaan = $this->input->post('perusahaan');
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()
            ->setCreator("IT Kumala Group")
            ->setTitle("Master Data Customer");
        $objset = $objPHPExcel->setActiveSheetIndex(0);
        $objget = $objPHPExcel->getActiveSheet();

        $list = $this->m_wuling_marketing_support->master_customer_export(empty($id_perusahaan) ? [] : $id_perusahaan);
        //begin Data
        foreach ($list as $i => $v) {
            $data['A'][] = $i + 1;
            $data['B'][] = $v->nama;
            $data['C'][] = $v->jenis_kelamin;
            $data['D'][] = $v->no_ktp;
            $data['E'][] = $v->no_rangka;
            $data['F'][] = $v->no_mesin;
            $data['G'][] = $v->varian;
            $data['H'][] = $v->model;
            $data['I'][] = $v->warna;
            $data['J'][] = tgl_sql($v->tgl_do);
            $data['K'][] = $v->agama;
            $data['L'][] = $v->pekerjaan;
            $data['M'][] = tgl_sql($v->tgl_lahir);
            $data['N'][] = $v->usia;
            $data['O'][] = $v->alamat;
            $data['P'][] = $v->provinsi;
            $data['Q'][] = $v->kabupaten;
            $data['R'][] = $v->kecamatan;
            $data['R'][] = $v->kelurahan;
            $data['T'][] = $v->telepone;
            $data['U'][] = $v->email;
            $data['V'][] = $v->lokasi;
        }
        foreach ($data as $kolom => $value) {
            $baris = 2;
            for ($j = 0; $j < count($value); $j++) {
                $objget->setCellValue($kolom . $baris, $data[$kolom][$j]);
                $baris++;
            }
        }
        $objget->getStyle("A1:V$baris")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $this->_format_excel($objget);
        $objget->setTitle("Master");
        $objset;
        $nama_perusahaan = empty($id_perusahaan) ? "_(ALL)" : "_(" . q_data("lokasi", 'kumk6797_kmg.perusahaan', ['id_perusahaan' => $id_perusahaan])->row('lokasi') . ")";
        $filename = "Master-Data-Customer$nama_perusahaan" . "_" . date("Y-m-d") . ".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
    function _format_excel($objget)
    {
        $column_header = [
            'fill' => ['type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => ['rgb' => '2, 218, 240']],
            'font' => ['color' => ['rgb' => 'FFFFFF']]
        ];
        foreach (range('A', 'V') as $kolom) {
            $objget->getColumnDimension($kolom)->setAutoSize(true);
        }

        $title_header = ["No", "Nama Customer", "Jenis Kelamin", "No KTP", "No Rangka", "No Mesin", "Varian", "Model", "Warna", "Tgl Delivery", "Agama", "Pekerjaan", "Tgl Lahir", "Usia", "Alamat", "Provinsi", "Kabupaten", "Kecamatan", "Kelurahan", "Telepone", "Email", "Dealer"];
        $baris = 1;
        foreach (range('A', 'V') as $i => $kolom) {
            $objget->setCellValue($kolom . $baris, $title_header[$i])
                ->getStyle($kolom . $baris)->applyFromArray($column_header);
        }
    }
}
