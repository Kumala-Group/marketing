<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_survei_do extends CI_Controller
{

	public $coverage;
	public $id_perusahaan;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_marketing');
		$this->load->model('m_honda_laporan_survei_do');
		
		$this->coverage = q_data("*", 'kumk6797_kumalagroup.users', ['nik'=>$this->session->userdata('nik')])->row('coverage');
		$this->id_perusahaan = q_data("*", 'kumk6797_kumalagroup.users', ['nik'=>$this->session->userdata('nik')])->row('id_perusahaan');
                
	}

	public function index()
	{
		$index = "honda_laporan_survei_do";
		if ($this->m_marketing->auth_login('admin_it,adm_mrktng,adm_marksup', $index)) {
			//$post = $this->input->post();
			//debug($post);
			//if ($post) {
			//	if (!empty($post['datatable'])) echo $this->m_honda_laporan_survei_do->get_survei_do($post['perusahaan'],$post['tahun'],$post['bulan']);
			//} else {
				$data = array(
					'content' 	=> "pages/marketing_support/honda/laporan/survei_do",
					'index'  	=> $index,
				);
				$this->load->view('index', $data);
			//}
		}
	}

	public function select2_cabang()
	{
        if ($this->id_perusahaan == $this->coverage) {            
            $data	= $this->m_honda_laporan_survei_do->select2_cabang($this->id_perusahaan);
        } 
		if ($this->id_perusahaan != $this->coverage) {
            $data	= $this->m_honda_laporan_survei_do->select2_cabang($this->coverage);            
        }		
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	public function select2_tahun()	{		
		$data  	= $this->m_honda_laporan_survei_do->select2_tahun();			
		header('Content-Type: application/json');
		echo json_encode($data);		
	}

	public function select2_bulan()	{		
		$data 	= $this->m_honda_laporan_survei_do->select2_bulan();			
		header('Content-Type: application/json');
		echo json_encode($data);	
	}

	public function get()
	{				
		$cabang	 	= $this->input->post('cabang');
		$tahun 		= $this->input->post('tahun');
		$bulan 		= $this->input->post('bulan');
		$id_sales 	= $this->_get_sales_from_coverage($cabang);		
		$data 		= $this->m_honda_laporan_survei_do->get_survei_do($id_sales,$tahun,$bulan);
		header('Content-Type: application/json');
		echo json_encode(['aaData' => $data]);
	}

	public function export()
	{
		$cabang 	= $this->input->post('opt-perusahaan');		
		$tahun 		= $this->input->post('opt-tahun');
		$bulan 		= $this->input->post('opt-bulan');
		$id_sales 	= $this->_get_sales_from_coverage($cabang);		
		$data 		= $this->m_honda_laporan_survei_do->get_survei_do($id_sales,$tahun,$bulan);		
		$exportExcel = new PHPExport;
		$exportExcel->dataSet($data)
			->rataTengah('0,2,3,4,8,18,19,22,23,26,31,32,34')			
			->warnaHeader('2,218,240', 'FFFFFF')
			->excel2003('Survei DO '. $this->m_honda_laporan_survei_do->get_nama_perusahaan($cabang) .'-'. date('YmdHis'));
	}

	
	private function _get_sales_from_coverage($v_coverage)
    {		
		$coverage = explode(',', $v_coverage);
		$arrSales = array();	
		$query_sales = $this->db_honda
			->select("ads.id_sales")
			->from("adm_sales ads")
			->where("ads.status_aktif","A")
			->where("ads.status_leader","n")
			->where_in("ads.id_perusahaan",$coverage)			
			->get();		
		foreach ($query_sales->result() as $dt) {
			$arrSales[] = $dt->id_sales;
		}
		return $arrSales;
	}




	//**** cek yang di bawah ****//

	public function xexport()
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
		$cek    = $this->session->userdata('logged_in');
		$level  = $this->session->userdata('level');
		if (!empty($cek) || $level == 'wuling_marksup') {
			//$id_perusahaan = $this->input->get('id_perusahaan');       
			$id_perusahaan = $this->input->post('perusahaan');
			$tahun = $this->input->post('tahun');
			$bulan = $this->input->post('bulan');
			$data_set = $this->m_wuling_marketing_support->get_survei_do_export($id_perusahaan,$tahun,$bulan);
			if (!empty($id_perusahaan)) {
				$n_perusahaan = "_(" . $this->m_wuling_marketing_support->get_nama_perusahaan($id_perusahaan) . ")";
			} else {
				$n_perusahaan = "_(ALL)";
			}
			$file_name = urlencode("Survei-DO" . $n_perusahaan . "_" . date("Y-m-d") . ".xls");
			$sheet_title = 'Survei DO';
			$center = array(0, 3, 4, 5);
			//$this->export_to_excel("Ini judulnya","nama file",$data,array(6,7,8,9),array(6,7,8),array(12),array(23,26,27,29));

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
					$v_column_name 	= $column_name[count($column_title) - 1];
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
							if (count($center)) {
								foreach ($center as $c) {
									if ($c == $col) {
										//$objPHPExcel->setActiveSheetIndex()->getStyle("$column_name[$col]")->applyFromArray($tengah_tengah);		
										$objPHPExcel->setActiveSheetIndex()->getStyle("$column_name[$c]" . $baris)->applyFromArray($tengah_tengah);
										//$objPHPExcel->setActiveSheetIndex()->getStyle("$column_name[$c]")->applyFromArray($tengah_tengah);		
									}
								}
							}
							// if($date){
							// foreach ($date as $d){								
							// 		$objPHPExcel->getActiveSheet()->getStyle("$column_name[$col]")->getNumberFormat()->setFormatCode('DD-MM-YYYY');
							// }
							// }
							// if($numeric){
							// foreach ($numeric as $n){																
							// 		$objPHPExcel->getActiveSheet()->getStyle("$column_name[$col]")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);	
							// 	}
							// }
							// if($accounting){
							// 	foreach ($accounting as $a){																
							// 		$objPHPExcel->getActiveSheet()->getStyle("$column_name[$c]")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);	
							// 		$objPHPExcel->getActiveSheet()->getStyle("$column_name[$col]")->getNumberFormat()->setFormatCode('_("Rp"* #,##0.00_);_("Rp"* \(#,##0.00\);_("Rp"* "-"??_);_(@_)');
							// 	}
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
				echo '<script>alert("Data Kosong"); history.back();</script>';
			}
		} else {
			redirect('wuling', 'refresh');
		}
	}

	public function xexport_old()
	{
		$id_perusahaan = $this->input->post('perusahaan');
		$this->load->library('PHPExcel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()
			->setCreator("IT Kumala Group")
			->setTitle("Survei DO");
		$objset = $objPHPExcel->setActiveSheetIndex(0);
		$objget = $objPHPExcel->getActiveSheet();

		$list = $this->m_wuling_marketing_support->master_survei_do_export(empty($id_perusahaan) ? [] : $id_perusahaan);
		//begin Data
		foreach ($list as $i => $v) {
			$data['A'][] = $i + 1;
			$data['B'][] = $v->nama;
			$data['C'][] = $v->jenis_kelamin;
			$data['D'][] = tgl_sql($v->tgl_lahir);
			$data['E'][] = $v->usia;
			$data['F'][] = $v->telepone;
			$data['G'][] = $v->email;
			$data['H'][] = $v->alamat;
			$data['I'][] = $v->provinsi;
			$data['J'][] = $v->kabupaten;
			$data['K'][] = $v->kecamatan;
			$data['L'][] = $v->kelurahan;
			$data['M'][] = $v->pekerjaan;
			$data['N'][] = $this->_pendapatan($v->pengeluaran);
			$data['O'][] = $this->_pendapatan($v->pendapatan);
			$data['P'][] = $this->_status_nikah($v->status_nikah);
			$data['Q'][] = $v->jml_keluarga;
			$data['R'][] = $v->cara_bayar;
			$data['R'][] = $v->merek_mobil_sebelumnya;
			$data['T'][] = $v->tipe_mobil_sebelumnya;
			$data['U'][] = $this->_status_mobil($v->status_mobil);
			$data['V'][] = $this->_alasan_beli($v->alasan_beli);
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
		$filename = "Master-Survei-DO$nama_perusahaan" . "_" . date("Y-m-d") . ".xls";
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

		$title_header = ["No", "Nama Customer", "Jenis Kelamin", "Tgl Lahir", "Usia", "Telepone", "Email", "Alamat", "Provinsi", "Kabupaten", "Kecamatan", "Kelurahan", "Pekerjaan", "Pengeluaran", "Pendapatan", "Status Nikah", "Anggota Keluarga", "Cara Bayar", "Merek Mobil Sebelumnya", "Tipe Mobil Sebelumnya", "Status Mobil", "Alasan Beli"];
		$baris = 1;
		foreach (range('A', 'V') as $i => $kolom) {
			$objget->setCellValue($kolom . $baris, $title_header[$i])
				->getStyle($kolom . $baris)->applyFromArray($column_header);
		}
	}

	function _pendapatan($id)
	{
		if (!empty($id)) {
			switch ($id) {
				case 'rp1':
					$p = 'Rp0 - Rp5.000.000';
					break;
				case 'rp2':
					$p = 'Rp5.000.001 - Rp10.000.000';
					break;
				case 'rp3':
					$p = 'Rp10.000.001 - Rp15.000.000';
					break;
				case 'rp4':
					$p = 'Rp15.000.001 - Rp20.000.000';
					break;
				case 'rp5':
					$p = 'Rp20.000.001 - Rp25.000.000';
					break;
				default:
					$p = '';
					break;
			}
			return $p;
		}
	}

	function _status_nikah($status)
	{
		if (!empty($status)) {
			switch ($status) {
				case 'l':
					$status_nikah = 'Lajang';
					break;
				case 'm':
					$status_nikah = 'Menikah';
					break;
				default:
					$status_nikah = '';
					break;
			}
			return $status_nikah;
		}
	}

	function _status_mobil($status)
	{
		if (!empty($status)) {
			switch ($status) {
				case 'pk':
					$status_mobil = 'Pertama Kali';
					break;
				case 'gm':
					$status_mobil = 'Ganti Mobil';
					break;
				case 'tm':
					$status_mobil = 'Tambah Mobil';
					break;
				default:
					$status_mobil = '';
					break;
			}
			return $status_mobil;
		}
	}

	function _alasan_beli($alasan)
	{
		if (!empty($alasan)) {
			switch ($alasan) {
				case 'h':
					$alasan_beli = 'Harga';
					break;
				case 'd':
					$alasan_beli = 'Desain';
					break;
				case 'f':
					$alasan_beli = 'Feature';
					break;
				default:
					$alasan_beli = '';
					break;
			}
			return $alasan_beli;
		}
	}

}
