<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kumalagroup_laporan_biaya extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_konfigurasi_user');
        $this->load->model('model_probid_laporan_biaya');

        $id_level   = $this->session->userdata('id_profil');
        $status     = $this->session->userdata('status_aktif');

        if (empty($this->session->userdata()) || $status == 'off' || $id_level != $this->model_konfigurasi_user->profil($id_level)) {
            redirect('kumalagroup', 'refresh');
        }
    }


    public function index()
    {
        $d['judul']     = 'Pengeluran External';
        $d['content']   = 'probid/laporan/laporan_biaya';
        $d['cabang'] = $this->model_probid_laporan_biaya->cabang();
        $d['jenis_biaya'] = $this->model_probid_laporan_biaya->jenis_biaya();
        $this->load->view('home', $d);
    }

    public function get_laporan_biaya()
    {
        echo $this->model_probid_laporan_biaya->get_laporan_biaya();
    }

    public function export_excel()
    {
        $data = $this->model_probid_laporan_biaya->get_export_excel();
        $this->export_to_excel("Biaya", "Laporan Biaya", $data, array(6, 7, 8, 9), array(6, 7, 8), array(12), array(23, 26, 27, 29));
    }

    public function export_to_excel($sheet_title, $file_name, $data_set, $center = null, $date = null, $numeric = null, $accounting = null)
    {
        function nomor_ke_kolom($num)
        {
            $column_name = array();
            for ($i = 0; $i <= $num; $i++) {
                $numeric = $i % 26;
                $letter = chr(65 + $numeric);
                $num2 = intval($num / 26);
                if ($num2 > 0) {
                    if ($i < 26) {
                        $v_column = $letter; //.getNameFromNumber($num2 - 1);
                    } else {
                        $v_column = 'A' . $letter; //.getNameFromNumber($num2 - 1);
                    }
                    $column_name[] = $v_column;
                } else {
                    $v_column = $letter;
                    $column_name[] = $v_column;
                }
            }
            return $column_name;
        }

        if (!empty($data_set)) {
            //cek ada datanya tidak?
            if (count($data_set) > 0) {
                // echo 'UNDER DEVELOPMENT !!!';
                // echo '<pre>';
                // print_r($data_set);
                // die();
                $column_name = array();
                $column_title = array();

                $objPHPExcel = new PHPExcel();
                $objPHPExcel->getProperties()
                    ->setCreator("KumalaGroup IT Development") //creator
                    ->setTitle("KumalaConnect Export");  //file title

                $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object

                $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
                $objget->setTitle($sheet_title); //sheet title
                $objget->getDefaultRowDimension()->setRowHeight(-1);

                // TABEL HEADER					
                foreach ($data_set[0] as $key => $value) {
                    $column_title[] = strtoupper(str_replace('_', ' ', $key));
                }

                //$column_name = array("A" .. "N");				
                //membuat column name by number
                $column_name = nomor_ke_kolom(count($column_title) - 1);

                // styling column
                // Beri Warna Title Column
                $v_column_name     = $column_name[count($column_title) - 1];
                $warna_header     =  array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '2, 218, 240')
                    ),
                    'font' => array(
                        'color' => array('rgb' => 'FFFFFF')
                    )
                );
                $rata_tengah = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    )
                );
                $tengah_tengah = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
                $kiri_tengah = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );

                //alignment
                // $objPHPExcel->getActiveSheet()->getStyle('X')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                //wrap text
                // $objPHPExcel->getActiveSheet()->getStyle('X')->getAlignment()->setWrapText(true);

                //numeric format
                //$objPHPExcel->getActiveSheet()->getStyle('X')->getNumberFormat()->setFormatCode('Rp #,##0');

                //accounting format
                //$objPHPExcel->getActiveSheet()->getStyle('X')->getNumberFormat()->setFormatCode('_("Rp"* #,##0.00_);_("Rp"* \(#,##0.00\);_("Rp"* "-"??_);_(@_)');	

                //isi header column dengan array
                for ($a = 0; $a < count($column_title); $a++) {
                    $objset->setCellValue("$column_name[$a]" . "1", "$column_title[$a]");
                    //ndak perlu lagi setwidth tiap column, cukup setAutoSize saja
                    $objPHPExcel->getActiveSheet()->getColumnDimension("$column_name[$a]")->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
                }

                // beri warna header dan rata tengah	
                $objPHPExcel->setActiveSheetIndex()->getStyle("A1:$v_column_name" . "1")->applyFromArray($tengah_tengah);
                $objPHPExcel->setActiveSheetIndex()->getStyle("A1:$v_column_name" . "1")->applyFromArray($warna_header);
                $objPHPExcel->setActiveSheetIndex()->getStyle("A1:$v_column_name" . "1")->getFont()->setBold(true)->setSize(12);

                $baris = 2;
                $no_spk = '';
                foreach ($data_set as $data_item) {
                    $col = 0;
                    foreach ($data_item as $value) {
                        //echo "$column_name[$col]$baris" . "<br>";
                        //echo "$column_title[$col]";
                        $objset->setCellValue("$column_name[$col]" . $baris, $value);
                        //$objset->setCellValue("$column_name[$b]" . $baris, $data_item["$column_title[$b]"]);
                        if ($center) {
                            //foreach ($center as $c){
                            $objPHPExcel->setActiveSheetIndex()->getStyle("$column_name[$col]")->applyFromArray($tengah_tengah);
                            //}
                        }
                        // if($date){
                        // 	//foreach ($date as $d){								
                        // 		$objPHPExcel->getActiveSheet()->getStyle("$column_name[$col]")->getNumberFormat()->setFormatCode('DD-MM-YYYY');
                        // 	//}
                        // }
                        // if($numeric){
                        // 	//foreach ($numeric as $n){																
                        // 		$objPHPExcel->getActiveSheet()->getStyle("$column_name[$col]")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);	
                        // 	//}
                        // }
                        // if($accounting){
                        // 	//foreach ($accounting as $a){																
                        // 		//$objPHPExcel->getActiveSheet()->getStyle("$column_name[$c]")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);	
                        // 		$objPHPExcel->getActiveSheet()->getStyle("$column_name[$col]")->getNumberFormat()->setFormatCode('_("Rp"* #,##0.00_);_("Rp"* \(#,##0.00\);_("Rp"* "-"??_);_(@_)');
                        // 	//}
                        // }

                        $col++;
                    }
                    //echo "<br>";					
                    $baris++;
                }
                //echo "<hr><br><br>";
                //exit;
                header('Content-Type: application/vnd.ms-excel'); //mime type
                header('Content-Disposition: attachment;filename="' . $file_name . '.xls"'); //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                ob_end_clean();
                $objWriter->save('php://output');
            }
        } else {
            redirect('kumalagroup', 'refresh');
        }
    }
}
