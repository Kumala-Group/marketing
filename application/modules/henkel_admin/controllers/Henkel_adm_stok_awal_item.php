<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_stok_awal_item extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_stok_awal_item');
			$this->load->model('model_item');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Data Stok Awal Item";
			$d['class'] = "persediaan";
			$d['data'] = $this->model_stok_awal_item->all();
			$d['kode_item'] = $this->kode_item();
			$d['content'] = 'stok_awal_item/view';
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function kode_item()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){

			$last_kd = $this->model_item->last_kode();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = "HNKL".sprintf("%03s", $no_akhir);
				//echo json_encode($d);
			}else{
				$kd = 'HNKL001';
				//echo json_encode($d);
			}
			return $kd;
		}else{
			redirect('henkel','refresh');
		}

	}

	public function cetak()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Cetak Stok Awal Item";
			$d['class'] = "persediaan";
			$d['content'] = 'stok_awal_item/cetak';
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function simpan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_stok_awal_item']= $this->input->post('id_stok_awal_item');

			$dt['tanggal'] 			= tgl_sql($this->input->post('tanggal'));
			$dt['kode_gudang'] 			= $this->input->post('kode_gudang');
			$dt['kode_item'] 			= $this->input->post('kode_item');
			$dt['nama_item'] 			= $this->input->post('nama_item');
			$dt['tipe'] 			= $this->input->post('tipe');
			$dt['harga_perkiraan'] 			= remove_separator2($this->input->post('harga_perkiraan'));
			$dt['tambah_stok'] 			= $this->input->post('tambah_stok');
			$dt['admin'] = $this->session->userdata('nama_lengkap');
			if($this->model_stok_awal_item->ada($id)){
				$dt['w_update'] = date('Y-m-d H:i:s');
				$this->model_stok_awal_item->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_stok_awal_item'] 	= $this->model_stok_awal_item->cari_max_stok_awal_item();
				$dt['w_insert'] = date('Y-m-d H:i:s');
				$this->model_stok_awal_item->insert($dt);
				echo "Data Sukses diSimpan";
			}
		}else{
			redirect('henkel','refresh');
		}

	}

	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_stok_awal_item']	= $this->uri->segment(3);

			if($this->model_stok_awal_item->ada($id))
			{
				$this->model_stok_awal_item->delete($id);
			}
			redirect('henkel_adm_stok_awal_item','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}

	}

	public function cari_data()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){

			$tgl_awal  = $this->input->post('tgl_awal');
			$tgl_akhir = $this->input->post('tgl_akhir');

			$q = $this->model_stok_awal_item->data_laporan_stok_awal_item($tgl_awal, $tgl_akhir)->num_rows();
			if ($q<1) {
				echo $this->load->view('stok_awal_item/view_kosong');
			}

		}else{
			redirect('henkel','refresh');
		}
	}

	public function create_kd()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){

			$last_kd = $this->model_stok_awal_item->last_kode();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = "SAO".sprintf("%03s", $no_akhir);
				//echo json_encode($d);
			}else{
				$kd = 'SAO001';
				//echo json_encode($d);
			}
			return $kd;
		}else{
			redirect('henkel','refresh');
		}
	}

	public function search_kd_item()
	{
		$keyword = $this->uri->segment(3);
		$data = $this->db_kpp->from('item')->like('kode_item',$keyword)->get();
		// format keluaran di dalam array
		foreach($data->result() as $dt)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$dt->kode_item,
				'nama_item'	=>$dt->nama_item,
				'tipe'	=>$dt->tipe
			);
		}
		echo json_encode($arr);
	}

	public function cari()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_stok_awal_item']	= $this->input->get('cari');

			if($this->model_stok_awal_item->ada($id)) {
				$dt = $this->model_stok_awal_item->get($id);
				//$dt = $this->model_prodi->get2($id);

				$d['id_stok_awal_item']	= $dt->id_stok_awal_item;
				$d['tanggal']	= tgl_sql($dt->tanggal);
				$d['harga_perkiraan']	= separator_harga2($dt->harga_perkiraan);
				$d['tambah_stok']	= $dt->tambah_stok;
				$kode_gudang=$this->model_stok_awal_item->getKd_gudang($dt->kode_gudang);
				$data_gudang = $this->db_kpp->from('gudang')->where('kode_gudang',$dt->kode_gudang)->get();
				if(count($kode_gudang)>0){
					foreach($data_gudang->result() as $dt_gudang) {

					$d['kode_gudang']='';
					$d['kode_gudang'].='<option value="'.$dt->kode_gudang.'">'.$dt_gudang->nama_gudang.'</option>';
					$d['kode_gudang'].='<option value="">-- Pilih Kode Gudang --</option>';

					foreach ($kode_gudang as $row) {
						$d['kode_gudang'].='<option value="'.$row->kode_gudang.'">'.$dt_gudang->nama_gudang.'</option>';
					}
				}
				}
				$d['kode_item']	= $dt->kode_item;
				$data_item = $this->db_kpp->from('item')->where('kode_item',$dt->kode_item)->get();
				foreach($data_item->result() as $dt)
				{
					$d['nama_item'] = $dt->nama_item;
					$d['tipe'] = $dt->tipe;
				}
				echo json_encode($d);
				} else {
				$d['id_stok_awal_item']		= '';
				$d['tanggal']		= '';
				$d['kode_gudang'] = '';
				$d['kode_item']	= '';
				$d['nama_item']	= '';
				$d['harga_perkiraan']	= '';
				$d['tipe']	= '';
				$d['tambah_stok']	= '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function cetak_pdf()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){

			$tgl_awal  = tgl_sql($this->input->post('tgl_awal'));
			$tgl_akhir = tgl_sql($this->input->post('tgl_akhir'));

			$q = $this->model_stok_awal_item->data_laporan_stok_awal_item($tgl_awal, $tgl_akhir);

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
					$pdf->SetTitle('Laporan Stok Awal Item');
					//$pdf->SetCreator('Programmer IT with fpdf');

					$h = 7;
					$pdf->SetFont('Times','B', 14);
					$pdf->Image('assets/img/kumala.png',10,6,20);
					$pdf->SetX(33);

					$pdf->Cell(198,4,$this->config->item('nama_instansi'),0,1,'L');
					$pdf->Ln(2);
					$pdf->SetX(33);
					$pdf->SetFont('Times','',10);
					$pdf->Cell(198,4,$this->config->item('alamat_instansi'),0,1,'L');
					$pdf->SetX(33);
					$pdf->Cell(198,4,$this->config->item('phone'),0,1,'L');
					$pdf->SetX(33);
					$pdf->Cell(198,4,$this->config->item('fax'),0,1,'L');
					$pdf->Line(10, 33, 297-20, 33);

					$pdf->Ln(10);

					//Column widths
					$pdf->SetFont('Times','B',14);
					$pdf->SetX(6);
					$pdf->Cell(290,4,'Laporan Stok Awal Item',0,1,'C');
					$pdf->Ln(2);
					$pdf->SetFont('Times','',12);
					$pdf->SetX(6);
					$pdf->Cell(290,4,'Dari Tanggal '.tgl_indo($tgl_awal).' s/d Tanggal '.tgl_indo($tgl_akhir).'',0,1,'C');
					$pdf->Ln(5);

					$w = array(8,25,35,45,25,45,45,30,10);

					//Header
					$pdf->SetFont('Times','B',13);
					$pdf->Cell($w[0],$h,'No',1,0,'C');
					$pdf->Cell($w[1],$h,'Tanggal',1,0,'C');
					$pdf->Cell($w[2],$h,'Kode Gudang',1,0,'C');
					$pdf->Cell($w[3],$h,'Gudang',1,0,'C');
					$pdf->Cell($w[4],$h,'Kode Item',1,0,'C');
					$pdf->Cell($w[5],$h,'Nama Item',1,0,'C');
					$pdf->Cell($w[6],$h,'Tipe',1,0,'C');
					$pdf->Cell($w[7],$h,'Harga Perkiraan',1,0,'C');
					$pdf->Cell($w[8],$h,'Stok',1,0,'C');
					$pdf->Ln();

					//data
					//$pdf->SetFillColor(224,235,255);
					$pdf->SetFont('Times','',11);
					$pdf->SetFillColor(204,204,204);
    			$pdf->SetTextColor(0);
					$fill = false;
					$no=1;
					foreach($q->result() as $row)
					{
						$gudang=$this->model_stok_awal_item->nama_gudang($row->kode_gudang);
						$nama_item = $this->model_stok_awal_item->nama_item($row->kode_item);
           	$tipe = $this->model_stok_awal_item->tipe($row->kode_item);

						$pdf->Cell($w[0],$h,$no,'LR',0,'C',$fill);
						$pdf->Cell($w[1],$h,$row->tanggal,'LR',0,'C',$fill);
						$pdf->Cell($w[2],$h,$row->kode_gudang,'LR',0,'C',$fill);
						$pdf->Cell($w[3],$h,$gudang,'LR',0,'C',$fill);
						$pdf->Cell($w[4],$h,$row->kode_item,'LR',0,'C',$fill);
						$pdf->Cell($w[5],$h,$nama_item,'LR',0,'C',$fill);
						$pdf->Cell($w[6],$h,$tipe,'LR',0,'C',$fill);
						$pdf->Cell($w[7],$h,$row->harga_perkiraan,'LR',0,'C',$fill);
						$pdf->Cell($w[8],$h,$row->tambah_stok,'LR',0,'C',$fill);
						$pdf->Ln();
						$fill = !$fill;
						$no++;
					}
					// Closing line
					$pdf->Cell(array_sum($w),0,'','T');
					$pdf->Ln(10);
					$pdf->SetX(200);
					$pdf->Cell(100,$h,'Makassar, '. tgl_indo(date('Y-m-d')),'C');
					$pdf->Ln(20);
					$pdf->SetX(200);
					$pdf->Cell(100,$h,'______________________','C');
				//}

				//}
				$pdf->Output('Laporan Stok Awal Item - '.date('d-m-Y').'.pdf','I');
			}else{
				redirect('henkel_adm_stok_awal_item/cetak');
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function cetak_excel(){
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
				$tgl_awal  = tgl_sql($this->input->post('tgl_awal'));
				$tgl_akhir = tgl_sql($this->input->post('tgl_akhir'));
				$ambildata = $this->model_stok_awal_item->export_excel($tgl_awal, $tgl_akhir);

				if(count($ambildata)>0){
						$objPHPExcel = new PHPExcel();
						// Set properties
						$objPHPExcel->getProperties()
												->setCreator("IT Kumala Motor Group") //creator
												->setTitle("Export Excel Data Stok Opname");  //file title

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
						$cols = array("A","B","C","D","E","F","G","H","I","J");

						$val = array("NO","Tanggal","Kode Gudang","Gudang","Kode Item","Nama Item","Tipe","Stok");

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
						foreach ($ambildata as $dt){
								$gudang=$this->model_stok_awal_item->nama_gudang($dt->kode_gudang);
								$nama_item = $this->model_stok_awal_item->nama_item($dt->kode_item);
		           	$tipe = $this->model_stok_awal_item->tipe($dt->kode_item);

								//$objset->setCellValue("A".$baris, $kode_stok_opname);
								$objset->setCellValue("A".$baris, $i++);
								$objset->setCellValue("B".$baris, tgl_sql($dt->tanggal));
								$objset->setCellValue("C".$baris, $dt->kode_gudang);
								$objset->setCellValue("D".$baris, $gudang);
								$objset->setCellValue("E".$baris, $dt->kode_item);
								$objset->setCellValue("F".$baris, $nama_item);
								$objset->setCellValue("G".$baris, $tipe);
								$objset->setCellValue("H".$baris, $dt->tambah_stok);

								//Set number value
								$objPHPExcel->getActiveSheet()->getStyle('C1:C'.$baris)->getNumberFormat()->setFormatCode('0');

								$baris++;
						}

						$objPHPExcel->getActiveSheet()->setTitle('Data Export');

						$objPHPExcel->setActiveSheetIndex(0);
						$filename = urlencode("Laporan Stok Awal Item".date("Y-m-d H:i:s").".xls");

							header('Content-Type: application/vnd.ms-excel'); //mime type
							header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
							header('Cache-Control: max-age=0'); //no cache

						$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
						$objWriter->save('php://output');
				}else{
						redirect('henkel_adm_stok_awal_item', 'refresh');
				}
			}else{
				redirect('henkel','refresh');
			}
	}



}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
