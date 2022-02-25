<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_lap_pembelian_supplier extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_lap_pembelian');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$d['judul']="Laporan Pembelian Per Supplier";
			$d['class'] = "laporan";
			$d['data_perusahaan'] = '';
			$d['data_status'] = '';
			$d['content']= 'laporan/pembelian/lap_pembelian_supplier';
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

			$q = $this->model_lap_pembelian->data_laporan_pembelian_supplier($tgl_awal, $tgl_akhir);
			$r = $q->num_rows();
			if ($r<1) {
				echo $this->load->view('laporan/view_kosong');
			} else {
				$dt['data'] = $q;
				echo $this->load->view('laporan/pembelian/view_lap_pembelian_supplier',$dt);
			}

		}else{
			redirect('henkel','refresh');
		}
	}

	public function cetak_pdf_pembelian()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){

			$tgl_awal  = $this->input->get('tgl_awal');
			$tgl_akhir = $this->input->get('tgl_akhir');
			$q = $this->model_lap_pembelian->data_laporan_pembelian_supplier($tgl_awal, $tgl_akhir);
			$q_supp = $this->model_lap_pembelian->kode_supplier($tgl_awal, $tgl_akhir);
			$r = $q->num_rows();
			if($r>0){
				define('FPDF_FONTPATH', $this->config->item('fonts_path'));
				require(APPPATH.'plugins/fpdf.php');


			  $pdf=new FPDF();
			  $pdf->AddPage("P","A4");
				//foreach($data->result() as $t){
					$A4[0]=210;
					$A4[1]=297;
					$Q[0]=216;
					$Q[1]=279;
					$pdf->SetTitle('Laporan Pembelian Supplier');
					$pdf->SetCreator('Programmer IT with fpdf');

					$h = 7;
					$pdf->SetFont('Times','B', 14);
					$pdf->Image('assets/img/kumala.png',10,6,20);
					$pdf->SetX(33);

					$pdf->Cell(198,4,'PT. KUMALA MOTOR GROUP',0,1,'L');
					$pdf->Ln(2);
					$pdf->SetX(33);
					$pdf->SetFont('Times','',10);
					$pdf->Cell(198,4,$this->config->item('alamat_instansi'),0,1,'L');
					$pdf->SetX(33);
					$pdf->Cell(198,4,$this->config->item('phone'),0,1,'L');
					$pdf->SetX(33);
					$pdf->Cell(198,4,$this->config->item('fax'),0,1,'L');
					$pdf->Line(10, 33, 210-10, 33);

					$pdf->Ln(10);

					//Column widths
					$pdf->SetFont('Times','B',11);
					$pdf->SetX(6);
					$pdf->Cell(190,4,'Laporan Pembelian Per Supplier',0,1,'C');
					$pdf->Ln(2);
					$pdf->SetFont('Times','',10);
					$pdf->SetX(6);
					$pdf->Cell(190,4,'Dari Tanggal '.tgl_indo($tgl_awal).' s/d Tanggal '.tgl_indo($tgl_akhir).'',0,1,'C');
					$pdf->Ln(5);

					$w = array(20,23,50,40,20,35);

					//Header
					$pdf->SetFont('Times','B',8);
					$pdf->Cell($w[0],$h,'Kode Supplier',1,0,'C');
					$pdf->Cell($w[1],$h,'Kode Item',1,0,'C');
					$pdf->Cell($w[2],$h,'Nama Item',1,0,'C');
					$pdf->Cell($w[3],$h,'Tipe',1,0,'C');
					$pdf->Cell($w[4],$h,'Jumlah',1,0,'C');
					$pdf->Cell($w[5],$h,'Harga',1,0,'C');
					$pdf->Ln();
					$pdf->SetFont('Times','',7);
					$pdf->SetFillColor(204,204,204);
    			$pdf->SetTextColor(0);
					$fill = false;
					$no=1;
					$total_akhir_f=0;
					$kode_supplier= array();
					$hi=$w[1]+$w[2]+$w[3]+$w[4]+$w[5];
					$kode_supplier='';
					$supp_num_rows = $q_supp->num_rows();

					/*for ($i=0;$i<$supp_num_rows;$i++) {
						$pdf->Cell($hi,$h,$kode_supplier,'LR',0,'C',$fill);
						$pdf->Ln(5);
					foreach($q->result() as $row){
						$harga = $row->total_item_item_masuk*$row->harga_tebus_dpp;
						$total_akhir_f+=$harga;
						$pdf->Cell($w[1],$h,$row->kode_item,'LR',0,'C',$fill);
						$pdf->Cell($w[2],$h,$row->nama_item,'LR',0,'C',$fill);
						$pdf->Cell($w[3],$h,$row->tipe,'LR',0,'C',$fill);
						$pdf->Cell($w[4],$h,$row->total_item_item_masuk,'LR',0,'C',$fill);
						$pdf->Cell($w[5],$h,'Rp. '.separator_harga2($harga),'LR',0,'C',$fill);
						$no++;
						$pdf->Ln();
						$fill = !$fill;
					}
				}*/
				foreach($q->result() as $row){
					$harga = $row->total_item_item_masuk*$row->harga_tebus_dpp;
					$total_akhir_f+=$harga;
					$pdf->Cell($w[0],$h,$row->kode_supplier,'LR',0,'C',$fill);
					$pdf->Cell($w[1],$h,$row->kode_item,'LR',0,'C',$fill);
					$pdf->Cell($w[2],$h,$row->nama_item,'LR',0,'C',$fill);
					$pdf->Cell($w[3],$h,$row->tipe,'LR',0,'C',$fill);
					$pdf->Cell($w[4],$h,$row->total_item_item_masuk,'LR',0,'C',$fill);
					$pdf->Cell($w[5],$h,'Rp. '.separator_harga2($harga),'LR',0,'C',$fill);
					$no++;
					$pdf->Ln();
					$fill = !$fill;
				}


					// Closing line
					$pdf->Cell(array_sum($w),0,'','T');
					$pdf->Ln(5);
					$pdf->Cell(100,$h,'Total Akhir','C');
					$pdf->Ln(3);
					$pdf->Cell(100,$h,'Rp. '. separator_harga2($total_akhir_f),'C');
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
				$pdf->Output('Lap_Pembelian_Supplier - '.date('d-m-Y').'.pdf','I');
			}else{
				redirect('henkel_adm_lap_pembelian_supplier');
			}

		}else{
			redirect('henkel','refresh');
		}
	}

	public function cetak_excel_pembelian(){
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
				$tgl_awal  = $this->input->get('tgl_awal');
				$tgl_akhir = $this->input->get('tgl_akhir');
        $ambildata = $this->model_lap_pembelian->data_laporan_pembelian_supplier($tgl_awal, $tgl_akhir);

				$r = $ambildata->num_rows();
        if($r>0){
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()
                  			->setCreator("IT Kumala Motor Group") //creator
                    		->setTitle("Export Excel Data Pembelian");  //file title

            $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
            $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object

            $objget->setTitle('Sample Sheet'); //sheet title
            //Warna header tabel
            /*$objget->getStyle("A1:Y1")->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLD,
                        'color' => array('rgb' => '92d050')
                    ),
                    'font' => array(
                        'color' => array('rgb' => '000000')
                    )
                )
            );*/

            //table header
            $cols = array("A","B","C","D","E","F");

            $val = array("NO","Kode Supplier","Kode Item","Nama Item","Tipe","Jumlah","Harga");

            for ($a=0;$a<6; $a++)
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

                $style = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
                $objPHPExcel->getActiveSheet()->getStyle($cols[$a].'1')->applyFromArray($style);
            }

            $baris=2;
						$i=1;
            foreach ($ambildata->result() as $dt){
							  $harga = $dt->total_item_item_masuk*$dt->harga_tebus_dpp;
								$objset->setCellValue("A".$baris, $i++);
								$objset->setCellValue("B".$baris, $dt->kode_supplier);
								$objset->setCellValue("C".$baris, $dt->kode_item);
								$objset->setCellValue("D".$baris, $dt->nama_item);
								$objset->setCellValue("E".$baris, $dt->tipe);
								$objset->setCellValue("F".$baris, $dt->total_item_item_masuk);
								$objset->setCellValue("G".$baris, $harga);

                //Set number value
                $objPHPExcel->getActiveSheet()->getStyle('C1:C'.$baris)->getNumberFormat()->setFormatCode('0');

                $baris++;
            }

            $objPHPExcel->getActiveSheet()->setTitle('Data Export');

            $objPHPExcel->setActiveSheetIndex(0);
            $filename = urlencode("Data Laporan Pembelian".date("Y-m-d H:i:s").".xls");

              header('Content-Type: application/vnd.ms-excel'); //mime type
              header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
              header('Cache-Control: max-age=0'); //no cache

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }else{
					redirect('henkel_adm_lap_pembelian', 'refresh');
        }
			}else{
				redirect('henkel','refresh');
			}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */