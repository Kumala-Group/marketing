<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_lap_penjualan_detail extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_lap_penjualan');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$d['judul']="Laporan Penjualan Detail";
			$d['class'] = "laporan";
			$d['data_perusahaan'] = '';
			$d['data_status'] = '';
			$d['content']= 'laporan/penjualan/lap_penjualan_detail';
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
			$kode_pelanggan = $this->input->post('kode_pelanggan');

			$q = $this->model_lap_penjualan->data_disp_laporan_penjualan_detail($tgl_awal, $tgl_akhir, $kode_pelanggan);
			$r = $q->num_rows();
			if ($r<1) {
				echo $this->load->view('laporan/view_kosong');
			} else {
				$dt['data'] = $q;
				echo $this->load->view('laporan/penjualan/view_lap_penjualan_detail',$dt);
			}

		}else{
			redirect('henkel','refresh');
		}
	}

	public function cetak_pdf_penjualan()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){

			$tgl_awal  = $this->input->get('tgl_awal');
			$tgl_akhir = $this->input->get('tgl_akhir');
			$kode_pelanggan = $this->input->get('kode_pelanggan');
			$q = $this->model_lap_penjualan->data_laporan_penjualan_detail($tgl_awal, $tgl_akhir, $kode_pelanggan);

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
					$pdf->SetTitle('Laporan Penjualan Detail');
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
					$pdf->Cell(190,4,'Laporan Penjualan Detail',0,1,'C');
					$pdf->Ln(2);
					$pdf->SetFont('Times','',10);
					$pdf->SetX(6);
					$pdf->Cell(190,4,'Dari Tanggal '.tgl_indo($tgl_awal).' s/d Tanggal '.tgl_indo($tgl_akhir).'',0,1,'C');
					$pdf->Ln(5);

					$w = array(8,28,50,30,34,32,32);

					//Header
					$pdf->SetFont('Times','B',8);
					$pdf->Cell($w[0],$h,'No',1,0,'C');
					$pdf->Cell($w[1],$h,'Tanggal Transaksi',1,0,'C');
					$pdf->Cell($w[2],$h,'No. Transaksi',1,0,'C');
					$pdf->Cell($w[3],$h,'Kode Pelanggan',1,0,'C');
					$pdf->Ln();
					$pdf->SetFont('Times','',7);
					$pdf->SetFillColor(204,204,204);
    			$pdf->SetTextColor(0);
					$fill = false;
					$no=1;
					$total_akhir_ppn_f=0;
					foreach($q->result() as $row){
						$id_pesanan_penjualan = $row->id_pesanan_penjualan;
						$kode_item = $this->db_kpp->query("SELECT p.*,o.nama_item,p.harga_jual
																							FROM penjualan p
																							JOIN item o ON p.kode_item=o.kode_item
																							WHERE id_pesanan_penjualan='$id_pesanan_penjualan'");
						$terbayar=$row->total_akhir-$row->sisa_o;
						$hi = $w[0]+$w[1]+$w[2]+$w[3];
						$pdf->Cell($w[0],$h,$no,'',0,'C',true);
						$pdf->Cell($w[1],$h,tgl_sql($row->tgl),'',0,'C',true);
						$pdf->Cell($w[2],$h,$row->no_transaksi,'',0,'C',true);
						$pdf->Cell($w[3],$h,$row->kode_pelanggan,'',0,'C',true);
						$pdf->Ln();
						$pdf->MultiCell($hi,5,'Kode Item','','',0,'',$fill);
						$pdf->SetX(25);
						$pdf->MultiCell($hi,-5,'Nama Item','','',0,'',$fill);
						$pdf->SetX(65);
						$pdf->MultiCell($hi,5,'Jumlah','','',0,'',$fill);
						$pdf->SetX(78);
						$pdf->MultiCell($hi,-5,'Harga','','',0,'',$fill);
						$pdf->SetX(97);
						$pdf->MultiCell($hi,5,'Diskon','','',0,'',$fill);
						$pdf->SetX(108);
						$pdf->MultiCell($hi,-5,'Total','','',0,'',$fill);
						$pdf->Ln(7);
						$total_akhir=0;
						$total_akhir_ppn=0;
						foreach($kode_item->result() as $rowb){
							$harga_item= $rowb->harga_jual;
	            $jumlah= $rowb->qty;
	            $harga = $harga_item * $jumlah;
	            $diskon = $rowb->diskon;
	            $persen = ($harga * $diskon)/100;
	            $total = $harga-$persen;
	            $total_akhir += $total;
	            $ppn = ($total_akhir * 10)/100;
	    				$total_akhir_ppn = $total_akhir+$ppn;
							$pdf->MultiCell($hi,0,$rowb->kode_item,'','',0,'',$fill);
							$pdf->SetX(25);
							$pdf->MultiCell($hi,0,$rowb->nama_item,'','',0,'',$fill);
							$pdf->SetX(65);
							$pdf->MultiCell($hi,0,$rowb->qty,'','',0,'',$fill);
							$pdf->SetX(78);
							$pdf->MultiCell($hi,0,'Rp. '.separator_harga2($harga),'','',0,'',$fill);
							$pdf->SetX(97);
							$pdf->MultiCell($hi,0,$diskon.'%','','',0,'',$fill);
							$pdf->SetX(108);
							$pdf->MultiCell($hi,0,'Rp. '.separator_harga2($total),'','',0,'',$fill);
							$pdf->Ln(3);
						}
						$pdf->SetX(108);
						$pdf->Cell($hi,0,'_____________','',0,'');
						$pdf->Ln(3);
						$pdf->SetX(108);
						$pdf->MultiCell($hi,0,'Rp. '.separator_harga2($total_akhir),'','',0,'',$fill);
						$total_akhir_ppn_f+=$total_akhir;
						$pdf->Ln(3);
						$fill = !$fill;
						$no++;
					}
					// Closing line
					$pdf->Cell(array_sum($w),0,'','T');
					$pdf->Ln(5);
					$pdf->Cell(100,$h,'Total Akhir','C');
					$pdf->Ln(3);
					$pdf->Cell(100,$h,'Rp. '. separator_harga2($total_akhir_ppn_f),'C');
					$pdf->Ln(5);
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
				$pdf->Output('Lap_Penjualan_Detail - '.date('d-m-Y').'.pdf','I');
			}else{
				redirect('henkel_adm_lap_penjualan_detail');
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
        $ambildata = $this->model_lap_pembelian->data_laporan_pembelian($tgl_awal, $tgl_akhir);

				$r = $ambildata->num_rows();
        if($r>0){
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()
                  			->setCreator("IT Kumala Motor Group") //creator
                    		->setTitle("Export Excel Data Pembelian");  //file title

            $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
            $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object

            $objget->setTitle('Laporan Penjualan Detail'); //sheet title

            //table header
            $cols = array("A","B","C","D","E","F","G","H");

            $val = array("NO","Tanggal Invoice","No. Invoice","Kode Supplier","Jumlah Item","Total Akhir","Terbayar","Sisa");

            for ($a=0;$a<8; $a++)
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
							$terbayar = $dt->total_akhir-$dt->total_akhir_o;
								$objset->setCellValue("A".$baris, $i++);
								$objset->setCellValue("B".$baris, $dt->tanggal_invoice);
								$objset->setCellValue("C".$baris, $dt->no_invoice);
								$objset->setCellValue("D".$baris, $dt->kode_supplier);
								$objset->setCellValue("E".$baris, $dt->jumlah_item);
								$objset->setCellValue("F".$baris, $dt->total_akhir);
								$objset->setCellValue("G".$baris, $terbayar);
                $objset->setCellValue("H".$baris, $dt->total_akhir_o);

                //Set number value
                $objPHPExcel->getActiveSheet()->getStyle('C1:C'.$baris)->getNumberFormat()->setFormatCode('0');

                $baris++;
            }

            $objPHPExcel->getActiveSheet()->setTitle('Data Export');

            $objPHPExcel->setActiveSheetIndex(0);
            $filename = urlencode("Data Laporan Penjualan Detail".date("Y-m-d H:i:s").".xls");

              header('Content-Type: application/vnd.ms-excel'); //mime type
              header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
              header('Cache-Control: max-age=0'); //no cache

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }else{
					redirect('henkel_adm_lap_penjualan_detail', 'refresh');
        }
			}else{
				redirect('henkel','refresh');
			}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
