<?php

function simple_export_excel($array, $name = "Export-Excel.xls")
{
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("IT Kumala Motor Group")->setTitle($name);
	$sheet_length = count($array);
	$sheet_length == 0 ? die("Sheet kosong") : $sheet_length;
	$sheet = 0;
	$sheet_length > 1 ? $objPHPExcel->createSheet($sheet_length) : '';
	foreach ($array as $key => $sheet_values) {
		$objget = $objPHPExcel->getSheet($sheet); //inisiasi get object
		$objget->setTitle($key); //sheet title

		//table header
		$cols = [];
		$col = 'A';
		$vals = [];
		foreach ($sheet_values[0] as $k => $v) {
			$cols[] = $col++;
			$vals[] = $k;
		}
		$objget->getStyle("A1:" . end($cols) . "1")->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '2, 218, 240')
				),
				'font' => array(
					'color' => array('rgb' => 'FFFFFF')
				)
			)
		);
		$style = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		for ($a = 0; $a < count($sheet_values[0]); $a++) {
			$objget->setCellValue($cols[$a] . '1', $vals[$a]);
			$objget->getColumnDimension($cols[$a])->setAutoSize(true);
			$objget->getStyle($cols[$a] . '1')->applyFromArray($style);
		}
		$baris  = 2;
		foreach ($sheet_values as $dt) {
			$i = 0;
			foreach ($dt as $v) {
				$objget->setCellValue($cols[$i] . $baris, $v);
				$i++;
			}
			$baris++;
		}
		$sheet++;
	}
	$filename = $name;
	header('Content-Type: application/vnd.ms-excel'); //mime type
	header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
	header('Cache-Control: max-age=0'); //no cache
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
}
