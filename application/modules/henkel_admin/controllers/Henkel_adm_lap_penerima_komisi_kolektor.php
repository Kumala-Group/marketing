<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_lap_penerima_komisi_kolektor extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
      $this->load->model('model_lap_komisi');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$d['judul']="Laporan Komisi (Kolektor)";
			$d['class'] = "penjualan";
			$d['data_perusahaan'] = '';
			$d['data'] = $this->model_lap_komisi->all_kolektor();
			$d['content']= 'komisi_penjualan/rekap_komisi/view_komisi_kolektor';
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function cari_komisi_kolektor(){
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_penerima_komisi_kolektor']	= $this->input->get('cari');

			if($this->model_lap_komisi->ada_kolektor($id)) {
				$dt = $this->model_lap_komisi->get_kolektor($id);

				$d['id_penerima_komisi_kolektor']	= $dt->id_penerima_komisi_kolektor;
				$d['tgl_awal']	= $dt->tgl_awal;
				$d['tgl_akhir']	= $dt->tgl_akhir;
				echo json_encode($d);
			} else {
				$d['id_penerima_komisi_kolektor']		= '';
				$d['tgl_awal']  	= '';
				$d['tgl_akhir']  	= '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function cetak_pdf_komisi_kolektor()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$id_penerima_komisi_kolektor  = $this->input->get('id_penerima_komisi_kolektor');
			$tgl_awal  = $this->input->get('tgl_awal');
			$tgl_akhir  = $this->input->get('tgl_akhir');
			$q = $this->db_kpp->select('pkkd.nik, pkkd.nama_karyawan, pkk.tgl_awal, pkk.tgl_akhir')
												->from('penerima_komisi_kolektor_detail pkkd')
												->join('penerima_komisi_kolektor pkk', 'pkk.id_penerima_komisi_kolektor = pkkd.id_penerima_komisi_kolektor')
												->where('pkk.id_penerima_komisi_kolektor', $id_penerima_komisi_kolektor)
												->group_by('pkkd.nama_karyawan')
												->get();

		$data_piutang = $this->db_kpp->query("SELECT pp.tgl, pp.no_transaksi, pp.total_akhir, p.bayar
		                                                FROM pesanan_penjualan pp
		                                                JOIN piutang p ON p.no_transaksi=pp.no_transaksi
		                                                WHERE p.tanggal_bayar BETWEEN '$tgl_awal' AND '$tgl_akhir'
		                                               ");
   $data_piutang_exception = $this->db_kpp->query("SELECT pp.tgl, pp.no_transaksi, pp.total_akhir, pe.bayar
                                                   FROM pesanan_penjualan pp
	                                                 JOIN piutang_exception pe ON pe.no_transaksi=pp.no_transaksi
	                                                 WHERE pe.tgl_bayar BETWEEN '$tgl_awal' AND '$tgl_akhir'
	                                                ");
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
					$pdf->SetTitle('Laporan Komisi Kolektor');
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
					$pdf->Cell(190,4,'Laporan Komisi Kolektor',0,1,'C');
					$pdf->Ln(2);
					$pdf->SetFont('Times','',10);
					$pdf->SetX(6);
					$pdf->Cell(190,4,'Dari Tanggal '.tgl_indo($tgl_awal).' s/d Tanggal '.tgl_indo($tgl_akhir).'',0,1,'C');

					$pdf->Ln(5);

					$w = array(8,12,35,30,30,25,20,30);
					$pdf->SetFont('Times','B',10);
					$pdf->Ln(2);
					//Header
					$pdf->SetFont('Times','B',8);
					$pdf->Cell($w[0],$h,'No',1,0,'C');
					$pdf->Cell($w[1],$h,'NIK',1,0,'C');
					$pdf->Cell($w[2],$h,'Nama Karyawan',1,0,'C');
					$pdf->Cell($w[3],$h,'Total Ar (Piutang)',1,0,'C');
					$pdf->Cell($w[4],$h,'Total Bayar',1,0,'C');
					$pdf->Cell($w[5],$h,'Sisa',1,0,'C');
					$pdf->Cell($w[6],$h,'Pencapaian',1,0,'C');
					$pdf->Cell($w[7],$h,'Jumlah Insentif',1,0,'C');
					$pdf->Ln();
					$pdf->SetFont('Times','',8);
					$pdf->SetFillColor(204,204,204);
    			$pdf->SetTextColor(0);
					$fill = false;
					$no=1;
					foreach($q->result() as $row){
						$total_ar=0;
		        $total_ar1=0;
		        $total_ar2=0;

		        $total_bayar=0;
		        $total_p_bayar=0;
		        $total_pe_bayar=0;

		        $sisa=0;

		        $tp=0;
		        $tpe=0;
						foreach($data_piutang->result() as $dt_piutang) {
              $total_ar1+=$dt_piutang->total_akhir;
              $total_p_bayar+=$dt_piutang->bayar;

              $datetimetp1 = new DateTime($dt_piutang->tgl);
              $datetimetp2 = new DateTime(date('Y-m-d'));
              $interval1 = $datetimetp1->diff($datetimetp2);
              $hitung_umur1 = $interval1->format('%a');
              if ($hitung_umur1>120) {
                $tp+=$dt_piutang->bayar;
              }
            }

            foreach($data_piutang_exception->result() as $dt_piutang_exception) {
              $total_ar2+=$dt_piutang_exception->total_akhir;
              $total_pe_bayar=$dt_piutang_exception->bayar;

              $datetimetp3 = new DateTime($dt_piutang_exception->tgl);
              $datetimetp4 = new DateTime(date('Y-m-d'));
              $interval2 = $datetimetp3->diff($datetimetp4);
              $hitung_umur2 = $interval2->format('%a');
              if ($hitung_umur2>120) {
                $tpe+=$dt_piutang_exception->bayar;
              }
            }

						$pdf->Cell($w[0],$h,$no,'LR',0,'C',$fill);
						$pdf->Cell($w[1],$h,$row->nik,'LR',0,'C',$fill);
						$pdf->Cell($w[2],$h,$row->nama_karyawan,'LR',0,'C',$fill);
						$total_bayar=$total_p_bayar+$total_pe_bayar;
            $total_ar=$total_ar1+$total_ar2;
            $_120=$tp+$tpe;
            $jumlah_insentif=0;
            $sisa=$total_ar-$total_bayar;
            if ($total_bayar && $total_ar==0) {
              $persentase_pencapaian=0;
            } else {
              $persentase_pencapaian=($total_bayar/$total_ar)*100;
            }


            if ($persentase_pencapaian>=0 && $persentase_pencapaian<=59) {
              $jumlah_insentif = (($total_bayar-$_120)*0.15)/100;
            } elseif ($persentase_pencapaian>=60 && $persentase_pencapaian<=79) {
              $jumlah_insentif = (($total_bayar-$_120)*0.25)/100;
            } elseif ($persentase_pencapaian>=80) {
              $jumlah_insentif = (($total_bayar-$_120)*0.3)/100;
            }
						$pdf->Cell($w[3],$h,'Rp. '.separator_harga2($total_ar),'LR',0,'C',$fill);
						$pdf->Cell($w[4],$h,'Rp. '.separator_harga2($total_bayar),'LR',0,'C',$fill);
						$pdf->Cell($w[5],$h,'Rp. '.separator_harga2($sisa),'LR',0,'C',$fill);
						$pdf->Cell($w[6],$h,number_format($persentase_pencapaian, 2).' %','LR',0,'C',$fill);
						$pdf->Cell($w[7],$h,'Rp. '.separator_harga2($jumlah_insentif),'LR',0,'C',$fill);
						$pdf->Ln();
						$fill = !$fill;
						$no++;
					}
					// Closing line
					$pdf->Cell(array_sum($w),0,'','T');
					$pdf->Ln(5);
					$pdf->Ln(2);
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
				$pdf->Output('Lap_Pembelian - '.date('d-m-Y').'.pdf','I');
			}else{
				redirect('henkel_adm_lap_pembelian');
			}

		}else{
			redirect('henkel','refresh');
		}
	}

	public function cetak_excel_komisi_admin(){
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id_penerima_komisi_admin  = $this->input->get('id_penerima_komisi_admin');
			$q = $this->db_kpp->select('pka.tgl_awal, pka.tgl_akhir, pkad.nik, pkad.nama_karyawan, pkad.status_komisi, pkad.persentase1, pkad.persentase2')
												->from('penerima_komisi_admin pka')
												->join('penerima_komisi_admin_detail pkad', 'pka.id_penerima_komisi_admin = pkad.id_penerima_komisi_admin')
												->get();
			foreach($q->result() as $row_ket){
				$tgl_awal = $row_ket->tgl_awal;
				$tgl_akhir = $row_ket->tgl_akhir;
				$status_komisi = $row_ket->status_komisi;
				$data_status_komisi = $this->db_kpp->select('nama_komisi')
				   																 ->from('komisi')
										 											 ->where('id_komisi', $status_komisi)
										 											 ->get();
				$data_satuan = $this->db_kpp->query("SELECT s.id_satuan, COUNT(s.id_satuan) AS total, ka.insentif_pcs
																			       FROM pesanan_penjualan pp
																			       JOIN penjualan p ON p.id_pesanan_penjualan=pp.id_pesanan_penjualan
																			       JOIN item o ON o.kode_item=p.kode_item
																			       JOIN satuan s ON s.kode_satuan=o.kode_satuan
																			       JOIN komisi_admin ka ON ka.id_satuan=s.id_satuan
																			       WHERE (pp.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir') AND ka.id_komisi='$status_komisi'
																			       GROUP BY s.id_satuan
																			      ");
									      }
				$r = $q->num_rows();
        if($r>0){
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()
                  			->setCreator("IT Kumala Motor Group") //creator
                    		->setTitle("Export Excel Data Komisi Admin/Gudang");  //file title

            $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
            $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object

            $objget->setTitle('Laporan Komisi Admin & Gudang'); //sheet title

            //table header
            $cols = array("A","B","C","D","E","F","G");

            $val = array("NO","NIK","Nama Karyawan","Komisi","Persentase 1","Persentase 2 (Admin)","Jumlah Insentif");

            for ($a=0;$a<7; $a++)
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
            foreach ($q->result() as $row){
							$jumlah_insentif1=0;
			        $jumlah_insentif2=0;
			        $take2=0;
							$objset->setCellValue("A".$baris, $i++);
							$objset->setCellValue("B".$baris, $row->nik);
							$objset->setCellValue("C".$baris, $row->nama_karyawan);
							foreach ($data_status_komisi->result() as $dsk) {
								$nama_komisi = $dsk->nama_komisi;
							}
							$objset->setCellValue("D".$baris, $nama_komisi);
							$objset->setCellValue("E".$baris, $row->persentase1);
							$objset->setCellValue("F".$baris, $row->persentase2);
							foreach ($data_satuan->result() as $ds) {
									if ($row->persentase2!=0) {
										$take2 += (($ds->total*$ds->insentif_pcs)*$row->persentase1)/100;
										$jumlah_insentif2 = ($take2*$row->persentase2)/100;
									} elseif ($row->persentase2==0) {
										$jumlah_insentif1 += (($ds->total*$ds->insentif_pcs)*$row->persentase1)/100;
									}
							}
							if ($row->persentase2!=0) {
								$objset->setCellValue("G".$baris, 'Rp. '.separator_harga2($jumlah_insentif2));
						  } else {
								$objset->setCellValue("G".$baris, 'Rp. '.separator_harga2($jumlah_insentif1));
						  }
                //Set number value
                $objPHPExcel->getActiveSheet()->getStyle('C1:C'.$baris)->getNumberFormat()->setFormatCode('0');

                $baris++;
            }

            $objPHPExcel->getActiveSheet()->setTitle('Data Export');

            $objPHPExcel->setActiveSheetIndex(0);
            $filename = urlencode("Data Laporan Komisi Admin/Gudang".date("Y-m-d H:i:s").".xls");

              header('Content-Type: application/vnd.ms-excel'); //mime type
              header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
              header('Cache-Control: max-age=0'); //no cache

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }else{
					redirect('henkel_adm_lap_penerima_komisi_admin', 'refresh');
        }
			}else{
				redirect('henkel','refresh');
			}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
