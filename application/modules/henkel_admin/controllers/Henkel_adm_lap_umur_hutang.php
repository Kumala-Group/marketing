<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_lap_umur_hutang extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_lap_hutang');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$d['judul']="Laporan Umur Hutang";
			$d['class'] = "laporan";
			$d['data_perusahaan'] = '';
			$d['data_status'] = '';
			$d['content']= 'laporan/hutang/lap_umur_hutang';
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function cari_data()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){

			$tgl_awal  = $this->input->post('tgl_awal');
			$tgl_akhir = $this->input->post('tgl_akhir');

			$q = $this->model_lap_hutang->data_laporan_umur_hutang($tgl_awal, $tgl_akhir);
			$r = $q->num_rows();
			if ($r<1) {
				echo $this->load->view('laporan/view_kosong');
			} else {
				$dt['data'] = $q;
				echo $this->load->view('laporan/hutang/view_lap_umur_hutang',$dt);
			}

		}else{
			redirect('henkel','refresh');
		}
	}

	public function cetak_pdf_hutang()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){

			$tgl_awal  = $this->input->get('tgl_awal');
			$tgl_akhir = $this->input->get('tgl_akhir');
			$q = $this->model_lap_hutang->data_laporan_umur_hutang($tgl_awal, $tgl_akhir);

			$r = $q->num_rows();
			if($r>0){
				define('FPDF_FONTPATH', $this->config->item('fonts_path'));
				require(APPPATH.'plugins/fpdf.php');


			  $pdf=new FPDF();
			  $pdf->AddPage("L","A4");
				//foreach($data->result() as $t){
					$A4[0]=210;
					$A4[1]=297;
					$Q[0]=216;
					$Q[1]=279;
					$pdf->SetTitle('Laporan Umur Hutang');
					$pdf->SetCreator('Programmer IT with fpdf');

					$h = 7;
					$pdf->SetFont('Times','B', 14);
					$pdf->Image('assets/img/kumala.png',10,6,20);
					$pdf->SetX(33);

					$pdf->Cell(198,4,'PT. KUMALA MOTOR GROUP',0,1,'L');
					$pdf->Ln(2);
					$pdf->SetX(33);
					$pdf->SetFont('Times','',12);
					$pdf->Cell(198,4,$this->config->item('alamat_instansi'),0,1,'L');
					$pdf->SetX(33);
					$pdf->Cell(198,4,$this->config->item('phone'),0,1,'L');
					$pdf->SetX(33);
					$pdf->Cell(198,4,$this->config->item('fax'),0,1,'L');
					$pdf->Line(10, 33, 300-10, 33);

					$pdf->Ln(10);

					//Column widths
					$pdf->SetFont('Times','B',10);
					$pdf->SetX(50);
					$pdf->Cell(190,4,'Laporan Umur Hutang',0,1,'C');
					$pdf->Ln(2);
					$pdf->SetFont('Times','',10);
					$pdf->SetX(50);
					$pdf->Cell(190,4,'Dari Tanggal '.tgl_indo($tgl_awal).' s/d Tanggal '.tgl_indo($tgl_akhir).'',0,1,'C');
					$pdf->Ln(5);

					$w = array(10,22,20,25,22,15,28,28,28,28,28,28);

					//Header
					$pdf->SetFont('Times','B',9);
					$pdf->Cell($w[0],$h,'No',1,0,'C');
					$pdf->Cell($w[1],$h,'Tgl Invoice',1,0,'C');
					$pdf->Cell($w[2],$h,'No. Invoice',1,0,'C');
					$pdf->Cell($w[3],$h,'Kode Supplier',1,0,'C');
					$pdf->Cell($w[4],$h,'JT',1,0,'C');
					$pdf->Cell($w[5],$h,'UH',1,0,'C');
					$pdf->Cell($w[6],$h,'1-15 Hari',1,0,'C');
					$pdf->Cell($w[7],$h,'16-30 Hari',1,0,'C');
					$pdf->Cell($w[8],$h,'31-45 Hari',1,0,'C');
					$pdf->Cell($w[9],$h,'46-60 Hari',1,0,'C');
					$pdf->Cell($w[10],$h,'61-90 Hari',1,0,'C');
					$pdf->Cell($w[11],$h,'> 90 Hari',1,0,'C');
					$pdf->Ln();
					$pdf->SetFont('Times','',9);
					$pdf->SetFillColor(204,204,204);
    			$pdf->SetTextColor(0);
					$fill = false;
					$no=1;
					$total_akhir_f=1;
					$_15=0;
			    $_30=0;
			    $_45=0;
			    $_60=0;
			    $_90=0;
			    $__90=0;
					foreach($q->result() as $row){
						$jt=$row->jt;
	          $tgl_jt = strtotime($row->tanggal_invoice);
	    			$date = date('Y-m-d', strtotime('+'.$jt.' day', $tgl_jt));
	          $datetime1 = new DateTime($date);
	          $datetime2 = new DateTime(date('Y-m-d'));
	          $interval = $datetime1->diff($datetime2);
						$umur_hutang_total = $interval->format('%a Hari');
	          $hitung_umur = $interval->format('%a');
						$total_akhir_o = $row->total_akhir_o;
						$total_akhir_f += $row->total_akhir_o;
						$terbayar=$row->total_akhir-$row->total_akhir_o;
						$pdf->Cell($w[0],$h,$no,'LR',0,'C',$fill);
						$pdf->Cell($w[1],$h,tgl_sql($row->tanggal_invoice),'LR',0,'C',$fill);
						$pdf->Cell($w[2],$h,$row->no_invoice,'LR',0,'C',$fill);
						$pdf->Cell($w[3],$h,$row->kode_supplier,'LR',0,'C',$fill);
						$pdf->Cell($w[4],$h,tgl_sql($date),'LR',0,'C',$fill);
						$pdf->Cell($w[5],$h,$umur_hutang_total,'LR',0,'C',$fill);
						if ($hitung_umur<=15) {
							$_15+=$total_akhir_o;
							$pdf->Cell($w[6],$h,'Rp. '.separator_harga2($row->total_akhir_o),'LR',0,'C',$fill);
            } else {
							$pdf->Cell($w[6],$h,'Rp. 0','LR',0,'C',$fill);
						}
						if ($hitung_umur>15 && $hitung_umur<=30) {
							$_30+=$total_akhir_o;
							$pdf->Cell($w[7],$h,'Rp. '.separator_harga2($row->total_akhir_o),'LR',0,'C',$fill);
            } else {
							$pdf->Cell($w[7],$h,'Rp. 0','LR',0,'C',$fill);
						}
						if ($hitung_umur>31 && $hitung_umur<=45) {
							$_45+=$total_akhir_o;
							$pdf->Cell($w[8],$h,'Rp. '.separator_harga2($row->total_akhir_o),'LR',0,'C',$fill);
            } else {
							$pdf->Cell($w[8],$h,'Rp. 0','LR',0,'C',$fill);
						}
						if ($hitung_umur>46 && $hitung_umur<=60) {
							$_60+=$total_akhir_o;
							$pdf->Cell($w[9],$h,'Rp. '.separator_harga2($row->total_akhir_o),'LR',0,'C',$fill);
            } else {
							$pdf->Cell($w[9],$h,'Rp. 0','LR',0,'C',$fill);
						}
						if ($hitung_umur>61 && $hitung_umur<=90) {
							$_90+=$total_akhir_o;
							$pdf->Cell($w[10],$h,'Rp. '.separator_harga2($row->total_akhir_o),'LR',0,'C',$fill);
            } else {
							$pdf->Cell($w[10],$h,'Rp. 0','LR',0,'C',$fill);
						}
						if ($hitung_umur>90) {
							$__90+=$total_akhir_o;
							$pdf->Cell($w[11],$h,'Rp. '.separator_harga2($row->total_akhir_o),'LR',0,'C',$fill);
            } else {
							$pdf->Cell($w[11],$h,'Rp. 0','LR',0,'C',$fill);
						}
						$pdf->Ln();
						$fill = !$fill;
						$no++;
					}
					// Closing line
					$pdf->Cell(array_sum($w),0,'','T');
					$pdf->Ln(5);
					$c = array(50,30);
					$pdf->SetFont('Times','',9);
					$pdf->Cell($c[0],$h,'Total Umur Hutang 1-15 hari',1,0,'C');
					$pdf->Cell($c[1],$h,'Rp. '.separator_harga2($_15),1,0,'C');
					$pdf->Ln(7);
					$pdf->Cell($c[0],$h,'Total Umur Hutang 16-30 hari',1,0,'C');
					$pdf->Cell($c[1],$h,'Rp. '.separator_harga2($_30),1,0,'C');
					$pdf->Ln(7);
					$pdf->Cell($c[0],$h,'Total Umur Hutang 31-45 hari',1,0,'C');
					$pdf->Cell($c[1],$h,'Rp. '.separator_harga2($_45),1,0,'C');
					$pdf->Ln(7);
					$pdf->Cell($c[0],$h,'Total Umur Hutang 46-60 hari',1,0,'C');
					$pdf->Cell($c[1],$h,'Rp. '.separator_harga2($_60),1,0,'C');
					$pdf->Ln(7);
					$pdf->Cell($c[0],$h,'Total Umur Hutang 61-90 hari',1,0,'C');
					$pdf->Cell($c[1],$h,'Rp. '.separator_harga2($_90),1,0,'C');
					$pdf->Ln(7);
					$pdf->Cell($c[0],$h,'Total Umur Hutang > 90 hari',1,0,'C');
					$pdf->Cell($c[1],$h,'Rp. '.separator_harga2($__90),1,0,'C');
					$pdf->Ln(7);
					$pdf->Cell($c[0],$h,'Total Hutang ',1,0,'C');
					$pdf->Cell($c[1],$h,'Rp. '.separator_harga2($total_akhir_f),1,0,'C');
					$pdf->Ln(3);
					$pdf->SetFont('Times','B',10);
					$pdf->Ln(10);
					$pdf->SetFont('Times','',8);
					$pdf->SetX(150);
					$pdf->Cell(100,$h,'Makassar, '. tgl_indo(date('Y-m-d')),'C');
					$pdf->Ln(20);
					$pdf->SetX(150);
					$pdf->Cell(100,$h,'______________________','C');
				//}

				//}
				$pdf->Output('Lap_Umur_Hutang - '.date('d-m-Y').'.pdf','I');
			}else{
				redirect('henkel_adm_lap_Umur_hutang');
			}

		}else{
			redirect('henkel','refresh');
		}
	}

	public function cetak_excel_hutang(){
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
				$tgl_awal  = $this->input->get('tgl_awal');
				$tgl_akhir = $this->input->get('tgl_akhir');
        $ambildata = $this->model_lap_hutang->data_laporan_umur_hutang($tgl_awal, $tgl_akhir);

				$r = $ambildata->num_rows();
        if($r>0){
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()
                  			->setCreator("IT Kumala Motor Group") //creator
                    		->setTitle("Export Excel Data Umur Hutang");  //file title

            $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
            $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object

            $objget->setTitle('Laporan Umur Hutang');

            //table header
            $cols = array("A","B","C","D","E","F","G","H","I","J","K","L");
            $val = array("NO","Tanggal Invoice","No. Invoice","Kode Supplier","Jatuh Tempo","Umur Hutang","1-15 Hari","16-30 Hari","31-45 Hari","46-60 Hari","61-90 Hari","> 90 Hari");


						for ($a=0;$a<12; $a++)
            {
                $objset->setCellValue($cols[$a].'1', $val[$a]);

                //Setting lebar cell
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
								$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
								$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
								$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
								$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
								$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
								$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
								$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
								$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
								$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);

                $style = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
                $objPHPExcel->getActiveSheet()->getStyle($cols[$a].'1')->applyFromArray($style);
            }


						$baris=2;
						$i=1;
						$_15=0;
				    $_30=0;
				    $_45=0;
				    $_60=0;
				    $_90=0;
				    $__90=0;


						foreach ($ambildata->result() as $dt){
							$total_akhir_o = $dt->total_akhir_o;

							$jt=$dt->jt;
							$tgl_jt = strtotime($dt->tanggal_invoice);
							$date = date('Y-m-d', strtotime('+'.$jt.' day', $tgl_jt));

							$datetime1 = new DateTime($date);
		          $datetime2 = new DateTime(date('Y-m-d'));
		          $interval = $datetime1->diff($datetime2);
		          $umur_hutang_total = $interval->format('%a Hari');
		          $hitung_umur = $interval->format('%a');

								$objset->setCellValue("A".$baris, $i++);
								$objset->setCellValue("B".$baris, $dt->tanggal_invoice);
								$objset->setCellValue("C".$baris, $dt->no_invoice);
								$objset->setCellValue("D".$baris, $dt->kode_supplier);
								$objset->setCellValue("E".$baris, tgl_sql($date));
								$objset->setCellValue("F".$baris, $umur_hutang_total);
								if ($hitung_umur<=15) {
									$_15+=$total_akhir_o;
									$objset->setCellValue("G".$baris, $dt->total_akhir_o);
		            } else {
									$objset->setCellValue("G".$baris, '0');
								}
								if ($hitung_umur>15 && $hitung_umur<=30) {
									$_30+=$total_akhir_o;
									$objset->setCellValue("H".$baris, $dt->total_akhir_o);
		            } else {
									$objset->setCellValue("H".$baris, '0');
								}
								if ($hitung_umur>31 && $hitung_umur<=45) {
									$_45+=$total_akhir_o;
									$objset->setCellValue("I".$baris, $dt->total_akhir_o);
		            } else {
									$objset->setCellValue("I".$baris, '0');
								}
								if ($hitung_umur>46 && $hitung_umur<=60) {
									$_60+=$total_akhir_o;
									$objset->setCellValue("J".$baris, $dt->total_akhir_o);
		            } else {
									$objset->setCellValue("J".$baris, '0');
								}
								if ($hitung_umur>61 && $hitung_umur<=90) {
									$_90+=$total_akhir_o;
									$objset->setCellValue("K".$baris, $dt->total_akhir_o);
		            } else {
									$objset->setCellValue("K".$baris, '0');
								}
								if ($hitung_umur>90) {
									$__90+=$total_akhir_o;
									$objset->setCellValue("L".$baris, $dt->total_akhir_o);
		            } else {
									$objset->setCellValue("L".$baris, '0');
								}

                //Set number value
                $objPHPExcel->getActiveSheet()->getStyle('C1:C'.$baris)->getNumberFormat()->setFormatCode('0');

                $baris++;
            }

						$ket_umur = array("Total Umur Hutang 1-15 Hari","Total Umur Hutang 16-30 Hari","Total Umur Hutang 31-45 Hari","Total Umur Hutang 46-60 Hari","Total Umur Hutang 61-90 Hari","Total Umur Hutang > 90 Hari");
						$ket_val_umur = array($_15,$_30,$_45,$_60,$_90,$__90);
						$baris_detail = $ambildata->num_rows()+4;


						for ($det=0;$det<5;$det++) {
							$objset->setCellValue("B".$baris_detail, $ket_umur[$det]);
							$objset->setCellValue("C".$baris_detail, $ket_val_umur[$det]);
							$baris_detail++;
						}

            $objPHPExcel->getActiveSheet()->setTitle('Data Export');

            $objPHPExcel->setActiveSheetIndex(0);
            $filename = urlencode("Data Laporan Umur Hutang".date("Y-m-d H:i:s").".xls");

              header('Content-Type: application/vnd.ms-excel'); //mime type
              header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
              header('Cache-Control: max-age=0'); //no cache

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }else{
					redirect('henkel_adm_lap_umur_hutang', 'refresh');
        }
			}else{
				redirect('henkel','refresh');
			}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
