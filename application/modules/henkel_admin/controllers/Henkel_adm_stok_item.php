
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_stok_item extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_stok_item');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Data Stok Item";
			$d['class'] = "persediaan";
			$d['data'] = $this->db_kpp->query("SELECT s.*, o.kode_item,o.nama_item,o.tipe,g.kode_gudang,g.nama_gudang
																				 FROM stok_item s
																				 INNER JOIN item o
																				 ON s.kode_item=o.kode_item
																				 INNER JOIN gudang g
																				 ON s.kode_gudang=g.kode_gudang");
			$d['content'] = 'stok_item/view';
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function cetak_kartu_stok_index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Cetak Kartu Stok";
			$d['class'] = "persediaan";
			$d['content'] = 'stok_item/cetak';
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function cetak_data_stok()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$id_c = $this->input->get('stok_item');
			$q = $this->db_kpp->query("SELECT si.kode_item, i.nama_item, i.tipe, si.kode_gudang, g.nama_gudang, i.kode_satuan, si.stok
									   FROM stok_item si
									   JOIN item i ON si.kode_item=i.kode_item
									   JOIN gudang g ON si.kode_gudang=g.kode_gudang
									   WHERE si.kode_item LIKE '$id_c%'");

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
					$pdf->SetTitle('Laporan Stok Item');
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
					$pdf->Cell(190,4,'Data Stok Item',0,1,'C');
					$pdf->Ln(2);
					$pdf->SetFont('Times','',10);
					$pdf->Ln(5);

					$w = array(8,18,55,28,20,35,15,10);

					//Header
					$pdf->SetFont('Times','B',8);
					$pdf->Cell($w[0],$h,'No',1,0,'C');
					$pdf->Cell($w[1],$h,'Kode Item',1,0,'C');
					$pdf->Cell($w[2],$h,'Nama Item',1,0,'C');
					$pdf->Cell($w[3],$h,'Tipe',1,0,'C');
					$pdf->Cell($w[4],$h,'Kode Gudang',1,0,'C');
					$pdf->Cell($w[5],$h,'Nama Gudang',1,0,'C');
					$pdf->Cell($w[6],$h,'Satuan',1,0,'C');
					$pdf->Cell($w[7],$h,'Stok',1,0,'C');
					$pdf->Ln();
					$pdf->SetFont('Times','',7);
					$pdf->SetFillColor(204,204,204);
    			$pdf->SetTextColor(0);
					$fill = false;
					$no=1;
					$total_akhir_f=1;
					$total_drum=0;
					$total_ibc=0;
					foreach($q->result() as $row){
						//$total_akhir_f += $row->total_akhir;
						//$terbayar=$row->total_akhir-$row->total_akhir_o;
						$pdf->Cell($w[0],$h,$no,'LR',0,'C',$fill);
						$pdf->Cell($w[1],$h,$row->kode_item,'LR',0,'C',$fill);
						$pdf->Cell($w[2],$h,$row->nama_item,'LR',0,'C',$fill);
						$pdf->Cell($w[3],$h,$row->tipe,'LR',0,'C',$fill);
						$pdf->Cell($w[4],$h,$row->kode_gudang,'LR',0,'C',$fill);
						$pdf->Cell($w[5],$h,$row->nama_gudang,'LR',0,'C',$fill);
						$pdf->Cell($w[6],$h,$row->kode_satuan,'LR',0,'C',$fill);
						$pdf->Cell($w[7],$h,$row->stok,'LR',0,'C',$fill);
						$pdf->Ln();
						$fill = !$fill;
						$no++;
						if ($row->kode_satuan=='Drm') {
							$total_drum+=$row->stok;
						} elseif ($row->kode_satuan=='IBC'){
							$total_ibc+=$row->stok;
						}
					}
					// Closing line
					$pdf->Cell(array_sum($w),0,'','T');
					$pdf->Ln(5);
					//$pdf->Cell(100,$h,'Total Drum : '.$total_drum,'C');
					$pdf->Ln(3);
					//$pdf->Cell(100,$h,'Total IBC : '.$total_ibc,'C');
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
				$pdf->Output('Lap_Stok - '.date('d-m-Y').'.pdf','I');
			}else{
				redirect('henkel_adm_stok_item');
			}

		}else{
			redirect('henkel','refresh');
		}
	}

	public function cetak_kartu_stok()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){

			$kode_item = $this->input->post('kode_item');
			$kode_gudang = $this->input->post('kode_gudang');
			$tgl_awal  = $this->input->post('tgl_awal');
			$tgl_akhir = $this->input->post('tgl_akhir');

			$q_stok_awal = $this->model_stok_item->data_stok_awal($kode_item);
			$q_stok_masuk = $this->model_stok_item->data_stok_masuk($kode_item, $tgl_awal, $tgl_akhir);
			$q_stok_keluar = $this->model_stok_item->data_stok_keluar($kode_item, $tgl_awal, $tgl_akhir);

			$q_sum = $q_stok_awal->num_rows()+$q_stok_masuk->num_rows()+$q_stok_keluar->num_rows();

			$r = $q_sum;
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
					$pdf->SetTitle('Laporan Stok Item');
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
					$pdf->Cell(190,4,'Kartu Stok Item',0,1,'C');
					$pdf->Ln(2);
					$pdf->SetFont('Times','',10);
					$nama_item = $this->model_stok_item->nama_item($kode_item);
					$pdf->Cell(180,4,$kode_item.' - '.$nama_item,0,1,'C');
					$pdf->Ln(2);
					$pdf->SetFont('Times','',10);
					$pdf->Ln(5);

					$w = array(8,25,20,15,25);

					//Header
					$pdf->SetFont('Times','B',8);
					$pdf->Cell($w[0],$h,'No',1,0,'C');
					$pdf->Cell($w[1],$h,'No Transaksi',1,0,'C');
					$pdf->Cell($w[2],$h,'Tanggal',1,0,'C');
					$pdf->Cell($w[3],$h,'Jumlah',1,0,'C');
					$pdf->Cell($w[4],$h,'Keterangan',1,0,'C');
					$pdf->Ln();
					$pdf->SetFont('Times','',7);
					$pdf->SetFillColor(204,204,204);
    				$pdf->SetTextColor(0);
					$fill = false;
					$no=1;
					$awal=0;
					$tambah=0;
					$kurang=0;
					foreach($q_stok_awal->result() as $row_awal){
						//$total_akhir_f += $row->total_akhir;
						//$terbayar=$row->total_akhir-$row->total_akhir_o;
						$pdf->Cell($w[0],$h,$no,'LR',0,'C',$fill);
						$pdf->Cell($w[1],$h,'-','LR',0,'C',$fill);
						$pdf->Cell($w[2],$h,tgl_sql($row_awal->tanggal),'LR',0,'C',$fill);
						$pdf->Cell($w[3],$h,$row_awal->qty,'LR',0,'C',$fill);
						$pdf->Cell($w[4],$h,'Stok Awal','LR',0,'C',$fill);
						$pdf->Ln();
						$fill = !$fill;
						$no++;
						$awal+=$row_awal->qty;
					}
					foreach($q_stok_masuk->result() as $row_masuk){
						//$total_akhir_f += $row->total_akhir;
						//$terbayar=$row->total_akhir-$row->total_akhir_o;
						$pdf->Cell($w[0],$h,$no,'LR',0,'C',$fill);
						$pdf->Cell($w[1],$h,$row_masuk->no_transaksi,'LR',0,'C',$fill);
						$pdf->Cell($w[2],$h,tgl_sql($row_masuk->tanggal),'LR',0,'C',$fill);
						$pdf->Cell($w[3],$h,$row_masuk->qty,'LR',0,'C',$fill);
						$pdf->Cell($w[4],$h,'Stok Masuk','LR',0,'C',$fill);
						$pdf->Ln();
						$fill = !$fill;
						$no++;
						$tambah+=$row_masuk->qty;
					}
					foreach($q_stok_keluar->result() as $row_keluar){
						//$total_akhir_f += $row->total_akhir;
						//$terbayar=$row->total_akhir-$row->total_akhir_o;
						$pdf->Cell($w[0],$h,$no,'LR',0,'C',$fill);
						$pdf->Cell($w[1],$h,$row_keluar->no_transaksi,'LR',0,'C',$fill);
						$pdf->Cell($w[2],$h,tgl_sql($row_keluar->tanggal),'LR',0,'C',$fill);
						$pdf->Cell($w[3],$h,$row_keluar->qty,'LR',0,'C',$fill);
						$pdf->Cell($w[4],$h,'Stok Keluar','LR',0,'C',$fill);
						$pdf->Ln();
						$fill = !$fill;
						$no++;
						$kurang+=$row_keluar->qty;
					}
					// Closing line
					$pdf->Cell(array_sum($w),0,'','T');
					$pdf->Ln(5);
					$jum_stok = ($awal+$tambah)-$kurang;
					$pdf->Cell(100,$h,"Stok : $jum_stok",'C');
					$pdf->Ln(3);
					//$pdf->Cell(100,$h,'Total IBC : '.$total_ibc,'C');
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
				$pdf->Output('Kartu_Stok - '.date('d-m-Y').'.pdf','I');
			}else{
				redirect('henkel_adm_stok_item/cetak_kartu_stok_index');
			}

		}else{
			redirect('henkel','refresh');
		}
	}



}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
