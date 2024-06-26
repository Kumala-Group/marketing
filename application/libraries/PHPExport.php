<?php

/**
 * PHPExport for CodeIgniter
 * 
 * dependencies : PHPExcel
 * 
 * @author zdienos <mail@zdienos.com>
 * @link https://www.zdienos.com 
 * 
 * 
 * 
 * Cara Penggunaan 
 * 1. Load dulu Librarynya :	$this->load->library('PHPExport');
 * 2. Tampung data yang akan dieksport ke array
 * 3. $exportExcel= new PHPExport; 			
 *		$exportExcel
 *			->dataSet($data_set)						: mandatory
 *			->rataTengah('4,5')							: optional (untuk rata tengah field, isikan nomor kolom)
 *			->rataKanan('13')							: optional (untuk rata kanan field, isikan nomor kolom)
 *			->warnaHeader('2,218,240','FFFFFF')			: optional (untuk warna header dan warna font, RBG value)
 *			->excel2003('Laporan-SPK_'.date('YmdHis'));	: mandatory (excel2003/excel2007, isikan nama filenya)
 */


class PHPExport extends PHPExcel
{

	public $dataSet;
	public $judulSheet;
	public $warnaHeader;
	public $warnaFontHeader;
	public $rataTengah;
	public $rataKanan;
	public $fieldAccounting;


	private function _nomor_ke_kolom($num)
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

	public function dataSet($dataset)
	{
		$this->dataSet = $dataset;
		return $this;
	}

	public function judulSheet($judulSheet = 'sheet')
	{
		$this->judulSheet = $judulSheet;
		return $this;
	}

	public function warnaHeader($bgColor, $fontColor)
	{
		$this->warnaHeader = $bgColor;
		$this->warnaFontHeader = $fontColor;
		return $this;
	}

	public function rataTengah($arrTengah)
	{
		$this->rataTengah = explode(',', $arrTengah);
		return $this;
	}

	public function rataKanan($arrKanan)
	{
		$this->rataKanan = explode(',', $arrKanan);
		return $this;
	}

	public function fieldAccounting($arrAccounting)
	{
		$this->fieldAccounting = explode(',', $arrAccounting);
		return $this;
	}

	public function generate()
	{
		$data_set  	= $this->dataSet;
		if (isset($this->judulSheet)) {
			$sheet_title = $this->judulSheet;
		} else {
			$sheet_title = 'sheet';
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

				//$objPHPExcel = new PHPExcel();
				$this
					->getProperties()
					->setCreator("KumalaGroup IT Development")
					->setTitle("KumalaConnect Export");

				$objset = $this->setActiveSheetIndex(0); //inisiasi set object

				$objget = $this->getActiveSheet();  //inisiasi get object
				$objget->setTitle($sheet_title); //sheet title
				$objget->getDefaultRowDimension()->setRowHeight(-1);

				// TABEL HEADER					
				foreach ($data_set[0] as $key => $value) {
					$column_title[] = strtoupper(str_replace('_', ' ', $key));
				}

				//$column_name = array("A" .. "N");				
				//membuat column name by number
				$column_name = $this->_nomor_ke_kolom(count($column_title) - 1);

				// styling column
				// Beri Warna Title Column
				$v_column_name 	= $column_name[count($column_title) - 1];

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
				$kanan_tengah = array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					)
				);

				//isi header column dengan array
				for ($a = 0; $a < count($column_title); $a++) {
					$objset->setCellValue("$column_name[$a]" . "1", "$column_title[$a]");
					//ndak perlu lagi setwidth tiap column, cukup setAutoSize saja
					$this->getActiveSheet()->getColumnDimension("$column_name[$a]")->setAutoSize(true);
					$this->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
				}

				// beri warna header dan rata tengah	
				$this->setActiveSheetIndex()->getStyle("A1:$v_column_name" . "1")->applyFromArray($tengah_tengah);
				$this->setActiveSheetIndex()->getStyle("A1:$v_column_name" . "1")->getFont()->setBold(true)->setSize(12);
				if ((null !== $this->warnaHeader) && (null !== $this->warnaFontHeader)) {
					$warna_header 	=  array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => $this->warnaHeader) //'2,218,240'
						),
						'font' => array(
							'color' => array('rgb' => $this->warnaFontHeader) //'FFFFFF
						)
					);
					$this->setActiveSheetIndex()->getStyle("A1:$v_column_name" . "1")->applyFromArray($warna_header);
				}

				$baris = 2;
				foreach ($data_set as $data_item) {
					$col = 0;
					foreach ($data_item as $value) {
						$objset->setCellValue("$column_name[$col]" . $baris, $value);
						//rata Kiri
						if (null !== $this->rataTengah) {
							foreach ($this->rataTengah as $c) {
								if ($c == $col) {
									$this->setActiveSheetIndex()->getStyle("$column_name[$c]" . $baris)->applyFromArray($tengah_tengah);
								}
							}
						}
						//rata Kanan			
						if (null !== $this->rataKanan) {
							foreach ($this->rataKanan as $c) {
								if ($c == $col) {
									$this->setActiveSheetIndex()->getStyle("$column_name[$c]" . $baris)->applyFromArray($kanan_tengah);
								}
							}
						}
						//accounting Format		
						if (null !== $this->fieldAccounting) {
							foreach ($this->fieldAccounting as $c) {
								if ($c == $col) {
									$this->setActiveSheetIndex()->getStyle("$column_name[$c]" . $baris)->getNumberFormat()->setFormatCode('_("Rp"* #,##0.00_);_("Rp"* \(#,##0.00\);_("Rp"* "-"??_);_(@_)');
								}
							}
						}
						$col++;
					}
					$baris++;
				}
				return $this;
			}
		}
	}

	private function writeToFile($filename, $writerType = 'Excel5', $mimes = 'application/vnd.ms-excel')
	{
		header("Content-Type: $mimes");
		header("Content-Disposition: attachment;filename=\"$filename\"");
		header("Cache-Control: max-age=0");
		$objWriter = PHPExcel_IOFactory::createWriter($this->generate(), $writerType);
		ob_end_clean();
		$objWriter->save('php://output');
	}

	public function excel2003($namafile = 'noname')
	{
		$this->writeToFile($namafile . '.xls');
	}

	public function excel2007($namafile = 'noname')
	{
		$this->writeToFile($namafile . '.xlsx', 'Excel2007', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}

	public function csv($namafile = 'noname', $delimiter = ',')
	{
		header("Content-Type: text/csv");
		header("Content-Disposition: attachment;filename=\"$namafile\".csv");
		header("Cache-Control: max-age=0");
		$objWriter = PHPExcel_IOFactory::createWriter($this->generate(), 'CSV');
		$objWriter->setDelimiter($delimiter);
		$objWriter->save('php://output');
	}

	public function saveToPath($path)
	{
		$objWriter = PHPExcel_IOFactory::createWriter($this->generate(), 'Excel5');
		$objWriter->save($path);
	}
}
