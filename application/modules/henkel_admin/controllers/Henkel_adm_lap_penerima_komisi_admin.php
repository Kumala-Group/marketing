<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_lap_penerima_komisi_admin extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
      $this->load->model('model_lap_komisi');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$d['judul']="Laporan Komisi (Admin/Gudang)";
			$d['class'] = "penjualan";
			$d['data_perusahaan'] = '';
			$d['data'] = $this->model_lap_komisi->all_admin();
			$d['content']= 'komisi_penjualan/rekap_komisi/view_komisi_admin';
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function cari_komisi_admin(){
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_penerima_komisi_admin']	= $this->input->get('cari');

			if($this->model_lap_komisi->ada_admin($id)) {
				$dt = $this->model_lap_komisi->get_admin($id);

				$d['id_penerima_komisi_admin']	= $dt->id_penerima_komisi_admin;
				$d['tgl_awal']	= $dt->tgl_awal;
				$d['tgl_akhir']	= $dt->tgl_akhir;
				echo json_encode($d);
			} else {
				$d['id_penerima_komisi_admin']		= '';
				$d['tgl_awal']  	= '';
				$d['tgl_akhir']  	= '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function cetak_pdf_komisi_admin()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){

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
				define('FPDF_FONTPATH', $this->config->item('fonts_path'));
				require(APPPATH.'plugins/fpdf.php');


			  $pdf=new FPDF();
			  $pdf->AddPage("P","A4");
				//foreach($data->result() as $t){
					$A4[0]=210;
					$A4[1]=297;
					$Q[0]=216;
					$Q[1]=279;
					$pdf->SetTitle('Laporan Komisi Admin/Gudang');
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
					$pdf->Cell(190,4,'Laporan Komisi Admin/Gudang',0,1,'C');
					$pdf->Ln(2);
					$pdf->SetFont('Times','',10);
					$pdf->SetX(6);
					$pdf->Cell(190,4,'Dari Tanggal '.tgl_indo($tgl_awal).' s/d Tanggal '.tgl_indo($tgl_akhir).'',0,1,'C');

					$pdf->Ln(5);

					$w = array(8,15,35,22,20,30,40);

					//Header
					$pdf->SetFont('Times','B',8);
					$pdf->Cell($w[0],$h,'No',1,0,'C');
					$pdf->Cell($w[1],$h,'NIK',1,0,'C');
					$pdf->Cell($w[2],$h,'Nama Karyawan',1,0,'C');
					$pdf->Cell($w[3],$h,'Komisi',1,0,'C');
					$pdf->Cell($w[4],$h,'Persentase 1',1,0,'C');
					$pdf->Cell($w[5],$h,'Persentase 2 (Admin)',1,0,'C');
					$pdf->Cell($w[6],$h,'Jumlah Insentif',1,0,'C');
					$pdf->Ln();
					$pdf->SetFont('Times','',7);
					$pdf->SetFillColor(204,204,204);
    			$pdf->SetTextColor(0);
					$fill = false;
					$no=1;
					foreach($q->result() as $row){
						$jumlah_insentif1=0;
		        $jumlah_insentif2=0;
		        $take2=0;
						$pdf->Cell($w[0],$h,$no,'LR',0,'C',$fill);
						$pdf->Cell($w[1],$h,$row->nik,'LR',0,'C',$fill);
						$pdf->Cell($w[2],$h,$row->nama_karyawan,'LR',0,'C',$fill);
						foreach ($data_status_komisi->result() as $dsk) {
							$nama_komisi = $dsk->nama_komisi;
						}
						$pdf->Cell($w[3],$h,$nama_komisi,'LR',0,'C',$fill);
						$pdf->Cell($w[4],$h,$row->persentase1.' %','LR',0,'C',$fill);
						$pdf->Cell($w[5],$h,$row->persentase2.' %','LR',0,'C',$fill);
						foreach ($data_satuan->result() as $ds) {
								if ($row->persentase2!=0) {
									$take2 += (($ds->total*$ds->insentif_pcs)*$row->persentase1)/100;
									$jumlah_insentif2 = ($take2*$row->persentase2)/100;
								} elseif ($row->persentase2==0) {
									$jumlah_insentif1 += (($ds->total*$ds->insentif_pcs)*$row->persentase1)/100;
								}
						}
						 if ($row->persentase2!=0) {
							 $pdf->Cell($w[6],$h,'Rp. '.separator_harga2($jumlah_insentif2),'LR',0,'C',$fill);
						} else {
							 $pdf->Cell($w[6],$h,'Rp. '.separator_harga2($jumlah_insentif1),'LR',0,'C',$fill);
						}
						$pdf->Ln();
						$fill = !$fill;
						$no++;
					}
					// Closing line
					$pdf->Cell(array_sum($w),0,'','T');
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
												->where('pka.id_penerima_komisi_admin', $id_penerima_komisi_admin)
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
