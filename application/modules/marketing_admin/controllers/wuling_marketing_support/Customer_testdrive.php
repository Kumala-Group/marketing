<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customer_testdrive extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_marketing');		
		$this->load->model('m_wuling_cust_testdrive');		
		$this->load->model('m_wuling_marketing_support');		
    }
    
    public function index()
    {
        $index = "wuling_cust_testdrive";
        if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
            $post = $this->input->post();
            if ($post) {
               if (!empty($post['datatable'])) echo $this->m_wuling_cust_testdrive->get_data_test_drive($post['cabang'],$post['tahun'],$post['bulan']);               
            } else {
                $d['content'] = "pages/marketing_support/wuling/customer_testdrive";
                $d['index'] = $index;
                $this->load->view('index', $d);
            }
        }
	}
	
	public function select2_cabang() {		
		$data = $this->m_wuling_cust_testdrive->select2_cabang();
		header('Content-Type: application/json');
		echo json_encode($data);		
	}

	public function select2_tahun()	{	
		$data           = $this->m_wuling_cust_testdrive->select2_tahun();			
		header('Content-Type: application/json');
		echo json_encode($data);		
	}

	public function select2_bulan()	{	
		$data           = $this->m_wuling_cust_testdrive->select2_bulan();			
		header('Content-Type: application/json');
		echo json_encode($data);		
	}

	private function _nomor_ke_kolom($num) {
		$column_name = array();			
		for($i=0;$i<=$num;$i++) {
			$numeric = $i % 26;
			$letter = chr(65 + $numeric);
			$num2 = intval($num / 26);
			if ($num2 > 0) {
				if($i<26) {
					$v_column = $letter;//.getNameFromNumber($num2 - 1);
				} else {
					$v_column = 'A'.$letter;//.getNameFromNumber($num2 - 1);
				}
				$column_name[] = $v_column;
			} else {
				$v_column = $letter;
				$column_name[] = $v_column;
			}
		}
		return $column_name;
	}

	public function export()	{		       
		$id_perusahaan = $this->input->post('opt-cabang');
		$tahun 		= $this->input->post('opt-tahun');
		$bulan 		= $this->input->post('opt-bulan');
		$data_set  	= $this->m_wuling_cust_testdrive->get_data_test_drive_export($id_perusahaan, $tahun, $bulan); 
		$file_name  = 'data-test-drive';
		$sheet_title= 'sheet';
		$center 	= array(0,1,2,3,4,5,6,7,8,9,10);
		$date 		= array(2,3,4,8,9);
		//$this->export_to_excel("Ini judulnya","nama file",$data,array(6,7,8,9),array(6,7,8),array(12),array(23,26,27,29));
		//PHPExcelExport 
		if(!empty($data_set) ){            			
			//cek ada datanya tidak?
			if (count($data_set) > 0) {
				// echo 'UNDER DEVELOPMENT !!!';
				// echo '<pre>';
				// print_r($data_set);
				// die();
				$column_name = array();
				$column_title= array();			

				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getProperties()
					->setCreator("KumalaGroup IT Development") //creator
					->setTitle("KumalaConnect Export");  //file title

				$objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
				
				$objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
				$objget->setTitle($sheet_title); //sheet title
				$objget->getDefaultRowDimension()->setRowHeight(-1); 

				// TABEL HEADER					
				foreach($data_set[0] as $key=>$value){
					$column_title[] = strtoupper(str_replace('_',' ',$key));
				}
							
				//$column_name = array("A" .. "N");				
				//membuat column name by number
				$column_name = $this->_nomor_ke_kolom(count($column_title)-1);								

				// styling column
				// Beri Warna Title Column
				$v_column_name 	= $column_name[count($column_title)-1];
				$warna_header 	=  array(
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
											
				//isi header column dengan array
				for ($a=0;$a<count($column_title);$a++) {					
					$objset->setCellValue("$column_name[$a]" . "1", "$column_title[$a]");	
					//ndak perlu lagi setwidth tiap column, cukup setAutoSize saja
					$objPHPExcel->getActiveSheet()->getColumnDimension("$column_name[$a]")->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
				}				
	
				// beri warna header dan rata tengah	
				$objPHPExcel->setActiveSheetIndex()->getStyle("A1:$v_column_name"."1")->applyFromArray($tengah_tengah);
				$objPHPExcel->setActiveSheetIndex()->getStyle("A1:$v_column_name"."1")->applyFromArray($warna_header);
				$objPHPExcel->setActiveSheetIndex()->getStyle("A1:$v_column_name"."1")->getFont()->setBold(true)->setSize(12);

				$baris = 2;
				$no_spk= '';
				foreach ($data_set as $data_item) {
					$col=0;
					foreach ($data_item as $value) {	
						//echo "$column_name[$col]$baris" . "<br>";
						//echo "$column_title[$col]";
						$objset->setCellValue("$column_name[$col]".$baris, $value);
						//$objset->setCellValue("$column_name[$b]" . $baris, $data_item["$column_title[$b]"]);
						if($center){
							foreach ($center as $c){
								if($c==$col){
									//$objPHPExcel->setActiveSheetIndex()->getStyle("$column_name[$col]")->applyFromArray($tengah_tengah);		
									$objPHPExcel->setActiveSheetIndex()->getStyle("$column_name[$c]".$baris)->applyFromArray($tengah_tengah);		
								}
							}
						}						
						$col++;
					}
					//echo "<br>";					
					$baris++;
				}
				//echo "<hr><br><br>";
				//exit;
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$file_name.'.xls"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				ob_end_clean();
				$objWriter->save('php://output');							
			}
		} 	
	}

}
