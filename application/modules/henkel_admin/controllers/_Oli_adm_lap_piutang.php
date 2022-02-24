<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class henkel_adm_lap_piutang extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_pesanan_penjualan');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$d['judul']="Laporan Piutang";
			$d['class'] = "laporan";
			$d['data_perusahaan'] = '';
			$d['data_status'] = '';
			$d['content']= 'laporan/lap_piutang';
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function cari_data()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){

			$tgl_awal  = tgl_sql($this->input->post('tgl_awal'));
			$tgl_akhir = tgl_sql($this->input->post('tgl_akhir'));
			$kode_pelanggan = $this->input->post('kode_pelanggan');
			$q = $this->model_pesanan_penjualan->data_laporan_piutang($tgl_awal, $tgl_akhir, $kode_pelanggan);
			$dt['data'] = $q;

			echo $this->load->view('laporan/view_lap_piutang',$dt);

		}else{
			redirect('henkel','refresh');
		}
	}

	public function cetak()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){

			$tgl_awal  = tgl_sql($this->input->get('tgl_awal'));
			$tgl_akhir = tgl_sql($this->input->get('tgl_akhir'));
			$kode_pelanggan = $this->input->get('kode_pelanggan');
			$q = $this->model_pesanan_penjualan->data_laporan_piutang($tgl_awal, $tgl_akhir, $kode_pelanggan);

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
					$pdf->SetTitle('Laporan Piutang');
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
					$pdf->Cell(190,4,'Laporan Piutang',0,1,'C');
					$pdf->Ln(2);
					$pdf->SetFont('Times','',10);
					$pdf->SetX(6);
					$pdf->Cell(190,4,'Dari Tanggal '.tgl_indo($tgl_awal).' s/d Tanggal '.tgl_indo($tgl_akhir).'',0,1,'C');
					$pdf->Ln(5);

					$w = array(8,23,23,28,40,25,10,33);

					//Header
					$pdf->SetFont('Times','B',8);
					$pdf->Cell($w[0],$h,'No',1,0,'C');
					$pdf->Cell($w[1],$h,'Tanggal',1,0,'C');
					$pdf->Cell($w[2],$h,'No. Transaksi',1,0,'C');
					$pdf->Cell($w[3],$h,'Kode Pelanggan',1,0,'C');
					$pdf->Cell($w[4],$h,'Nama Pelanggan',1,0,'C');
					$pdf->Cell($w[5],$h,'Sisa',1,0,'C');
					$pdf->Cell($w[6],$h,'Status',1,0,'C');
					$pdf->Cell($w[7],$h,'Keterangan',1,0,'C');
					$pdf->Ln();

					//data
					//$pdf->SetFillColor(224,235,255);
					$pdf->SetFont('Times','',7);
					$pdf->SetFillColor(204,204,204);
    				$pdf->SetTextColor(0);
					$fill = false;
					$no=1;
					$total_sisa=0;
					foreach($q->result() as $row){
						$total_sisa+=$row->sisa_o;
						$pdf->Cell($w[0],$h,$no,'LR',0,'C',$fill);
						$pdf->Cell($w[1],$h,tgl_sql($row->tgl),'LR',0,'C',$fill);
						$pdf->Cell($w[2],$h,$row->no_transaksi,'LR',0,'C',$fill);
						$pdf->Cell($w[3],$h,$row->kode_pelanggan,'LR',0,'C',$fill);
						$pdf->Cell($w[4],$h,$row->nama_pelanggan,'LR',0,'C',$fill);
						$pdf->Cell($w[5],$h,'Rp. '.separator_harga2($row->sisa_o),'LR',0,'C',$fill);
						$pdf->Cell($w[6],$h,$row->status,'LR',0,'C',$fill);
						$pdf->Cell($w[7],$h,$row->keterangan,'LR',0,'L',$fill);
						$pdf->Ln();
						$fill = !$fill;
						$no++;
					}
					// Closing line
					$pdf->Cell(array_sum($w),0,'','T');
					$pdf->Ln(5);
					$pdf->SetFont('Times','B',10);
					$pdf->SetX(10);
					$pdf->Cell(34,$h,'Total Sisa  :   Rp. '.separator_harga2($total_sisa),'C');
					$pdf->Ln(10);
					$pdf->SetFont('Times','',8);
					$pdf->SetX(150);
					$pdf->Cell(100,$h,'Makassar, '. tgl_indo(date('Y-m-d')),'C');
					$pdf->Ln(20);
					$pdf->SetX(150);
					$pdf->Cell(100,$h,'______________________','C');
				//}

				//}
				$pdf->Output('Lap_Piutang_Karyawan - '.date('d-m-Y').'.pdf','I');
			}else{
				redirect('henkel_adm_lap_piutang');
			}

		}else{
			redirect('henkel','refresh');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
