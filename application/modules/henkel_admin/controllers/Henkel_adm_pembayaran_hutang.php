<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_pembayaran_hutang extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_pembayaran_hutang');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Data Pembayaran Hutang";
			$d['class'] = "pembelian";
			$d['data'] = $this->model_pembayaran_hutang->all();
			$d['id_hutang'] = $this->model_pembayaran_hutang->cari_max_pembayaran_hutang();
			$d['content'] = 'pembayaran_hutang/view';
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function tambah()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id_pembayaran_hutang = $this->model_pembayaran_hutang->cari_max_pembayaran_hutang();
			$d = array('judul' 			=> 'Tambah Pembayaran Hutang',
						'class' 		=> 'pembelian',
						'id_pembayaran_hutang'=> $id_pembayaran_hutang,
						'tanggal'=> date("Y-m-d"),
						'no_transaksi'=> $this->create_kd(),
						'kode_supplier'	=> '',
						'nama_supplier'	=> '',
						'alamat'	=> '',
						'status'	=> 'Lunas/Kredit',
						'sisa'	=> '0',
						'keterangan'	=> '',
						'content' 		=> 'pembayaran_hutang/add',
						'data'		=>  $this->db_kpp->query("SELECT th.*, om.tanggal_invoice, om.jt, sum(omd.total_item_item_masuk) AS total_item_item_masuk
																								FROM t_hutang th
																								JOIN item_masuk om ON th.no_invoice=om.no_invoice
																								JOIN item_masuk_detail omd ON om.id_item_masuk=omd.id_item_masuk
																								GROUP by no_invoice
																							 ")
						);
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function create_kd()
	{
		$tanggal = date("y-m");
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){

			$last_kd = $this->model_pembayaran_hutang->last_kode();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = $tanggal.'/PHT/'.sprintf("%03s", $no_akhir);
				//echo json_encode($d);
			}else{
				$kd = $tanggal.'/PHT/'.'001';
				//echo json_encode($d);
			}
			return $kd;
		}else{
			redirect('henkel','refresh');
		}

	}

	public function edit()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){

			$id_pembayaran_hutang 		= $this->uri->segment(3);
			$dt 	= $this->model_pembayaran_hutang->getByIdHutang($id_pembayaran_hutang);
			$no_hutang	= $dt->no_hutang;
			$tgl 		= $dt->tanggal;
			$kode_supplier  = $dt->kode_supplier;
			$data_pl = $this->db_kpp->query("SELECT nama_supplier, alamat FROM supplier WHERE kode_supplier='$kode_supplier'");
			foreach($data_pl->result() as $dt_pl)
			{
				$nama_supplier = $dt_pl->nama_supplier;
				$alamat = $dt_pl->alamat;
			}
			$data_kredit = $this->db_kpp->query("SELECT SUM(total_akhir_o) as total_kredit FROM item_masuk WHERE kode_supplier='$kode_supplier' AND status_bayar='kredit'");
			foreach($data_kredit->result() as $dt_k)
			{
			   $total_kredit=(int)$dt_k->total_kredit;
			}
			$sisa  = $dt->sisa;
			$keterangan  = $dt->keterangan;
			$admin  = $dt->admin;
			$d = array('judul' 			=> 'Edit Pembayaran Hutang ',
						'class' 		=> 'pembelian',
						'id_pembayaran_hutang'	=> $id_pembayaran_hutang,
						'no_transaksi' => $no_hutang,
						'tanggal'	=> $tgl,
						'kode_supplier'	=> $kode_supplier,
						'nama_supplier'	=> $nama_supplier,
						'alamat'	=> $alamat,
						'sisa'	=> $sisa,
						'keterangan'	=> $keterangan,
						'admin'	=> $admin,
						'content'	=> 'pembayaran_hutang/edit',
						'sisa_kredit' => $total_kredit,
						'data' => $this->db_kpp->query("SELECT h.*,om.no_invoice, sum(omd.total_item_item_masuk) AS total_item,om.jt,om.total_akhir_o
																						FROM hutang h
																						JOIN item_masuk om ON h.no_invoice=om.no_invoice
																						JOIN item_masuk_detail omd ON om.id_item_masuk=omd.id_item_masuk
																						WHERE h.id_pembayaran_hutang='$id_pembayaran_hutang'
																						GROUP BY om.no_invoice
																						")
						);
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function cek_table(){
		$id['id_pembayaran_hutang']=$this->input->post('id_cek');
		$q 	 = $this->db_kpp->get("t_hutang");
		$row = $q->num_rows();
		echo $row;
	}

	public function cek_bayar(){
		$id['id_pembayaran_piutang']=$this->input->post('id_cek');
		$q 	 = $this->db_kpp->query("SELECT SUM(bayar) as total_bayar FROM t_piutang");
		foreach ($q->result() as $dt) {
			$cek=(int)$dt->total_bayar;
		}
		echo $cek;
	}

	public function baru(){
		$id['id_pembayaran_hutang']=$this->input->post('id_new');
		$this->db_kpp->empty_table("t_hutang");
	}

	public function cek(){
		$id=$this->input->post('kode_supplier');
		if($this->model_pembayaran_hutang->ada_hutang($id))
		{
			$this->db_kpp->empty_table('t_hutang');
			$id_t=$this->input->post('kode_supplier');
			$this->db_kpp->query("INSERT INTO t_hutang (no_invoice,sisa,total_sisa)
														SELECT no_invoice,total_akhir_o,total_akhir_o
														FROM item_masuk
														WHERE kode_supplier='$id_t' AND status_bayar='Kredit'");
			echo "1";
		}else {
			$this->db_kpp->empty_table('t_hutang');
			echo "0";
		}
	}

	public function simpan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_pembayaran_hutang']= $this->input->post('id');
			$sisa = $this->input->post('total_kredit');
			$dt['no_hutang'] = $this->input->post('no_transaksi');
			$dt['tanggal'] = tgl_sql($this->input->post('tanggal'));
			$dt['kode_supplier'] = $this->input->post('kode_supplier');
			$dt['sisa'] = remove_separator2($sisa);
			$dt['keterangan'] = $this->input->post('keterangan');
			$dt['admin'] = $this->session->userdata('nama_lengkap');
				if($this->model_pembayaran_hutang->ada($id)){
					$this->model_pembayaran_hutang->update($id, $dt);
					echo "Data Sukses diUpdate";
				}

		}else{
			redirect('henkel','refresh');
		}

	}

	public function t_simpan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_pembayaran_hutang']= $this->input->post('id');
			$id2=$this->input->post('id');
			$dt['no_hutang'] = $this->input->post('no_transaksi');
			$dt['tanggal'] = tgl_sql($this->input->post('tanggal'));
			$dt['kode_supplier'] = $this->input->post('kode_supplier');
			$dt['keterangan'] = $this->input->post('keterangan');
			$dt['admin'] = $this->session->userdata('nama_lengkap');
				if($this->model_pembayaran_hutang->ada($id)){
					$this->model_pembayaran_hutang->update($id, $dt);
					echo "Data Sukses diUpdate";
				}else{
					$dt['id_pembayaran_hutang'] = $this->input->post('id');
					$id_t=$this->input->post('id');
					$this->db_kpp->query("INSERT INTO hutang (id_pembayaran_hutang, tanggal_bayar, no_invoice, sisa, diskon, bayar,total_sisa)
																SELECT id_pembayaran_hutang, tanggal_bayar, no_invoice, sisa, diskon, bayar, total_sisa
																FROM t_hutang WHERE id_pembayaran_hutang='$id2'");
					$this->db_kpp->empty_table('t_hutang');
					$this->model_pembayaran_hutang->insert($dt);
					echo "Data Sukses diSimpan";
				}
		}else{
			redirect('henkel','refresh');
		}

	}

	public function cetak()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){

			$id_c = $this->input->get('id');
			$admin = $this->session->userdata('nama_lengkap');
			$no_transaksi = $this->input->get('no_transaksi');
			$kode_supplier = $this->input->get('kode_supplier');
			$nama_supplier = $this->input->get('nama_supplier');
			$keterangan = $this->input->get('keterangan');
			$tgl=$this->input->get('tanggal');
			$tanggal = date("Y-m-d");
			$alamat = $this->input->get('alamat');
			$sub_total = $this->input->get('total_transaksi');
			$sisa_kredit = $this->input->get('sisa_kredit');
			$q = $this->db_kpp->query("SELECT h.*,om.no_invoice,sum(omd.total_item_item_masuk) AS total_item,om.jt,om.total_akhir_o
																 FROM hutang h
																 JOIN item_masuk om ON h.no_invoice=om.no_invoice
																 JOIN item_masuk_detail omd ON omd.id_item_masuk=om.id_item_masuk
																 WHERE h.id_pembayaran_hutang='$id_c'
																 GROUP BY h.no_invoice");
			$cetak_hutang = $this->input->get('cetak_hutang');
			$number_of_hutang_clicked = $this->db_kpp->query("SELECT cetak FROM pembayaran_hutang WHERE id_pembayaran_hutang='$id_c'")->row();
			$hutang_recorded = $number_of_hutang_clicked->cetak;
			if($cetak_hutang>=$hutang_recorded){
				$this->db_kpp->query("UPDATE pembayaran_hutang
															SET cetak='$cetak_hutang'
															WHERE id_pembayaran_hutang='$id_c'");
			}

			$r = $q->num_rows();

			if($r>0){
				define('FPDF_FONTPATH', $this->config->item('fonts_path'));
				require(APPPATH.'plugins/fpdf.php');
			  $pdf=new FPDF();
			  $pdf->AddPage("P","A4");
				if ($hutang_recorded>0) {
					$pdf->Image("assets/img/copy.png", 65, 20);
				}
				//foreach($data->result() as $t){
					$A4[0]=210;
					$A4[1]=297;
					$Q[0]=216;
					$Q[1]=279;
					$pdf->SetTitle('FAKTUR PEMBAYARAN DEBET');
					$pdf->SetCreator('IT Kumala');

					$h = 7;
					$pdf->SetFont('Times','B', 14);
					$pdf->Image('assets/img/kumala.png',10,6,20);
					$w = array(50,22,3,50,10,3,10);
					//Cop
					$pdf->SetY(5);
					$pdf->SetX(33);
					$pdf->SetFont('Times','B',8);
					$pdf->Cell($w[0],$h,'PERMINTAAN PEMBAYARAN',0,0,'L');
					$pdf->Cell($w[1],$h,'No. Transaksi',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($w[3],$h,$no_transaksi,0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'L');
					$pdf->Cell($w[6],$h,'',0,0,'L');
					$pdf->Ln(5);
					$pdf->SetX(33);
					$pdf->Cell($w[0],$h,'PT.KUMALA MOTOR SEJAHTERA',0,0,'L');
					$pdf->Cell($w[1],$h,'Tanggal',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($w[3],$h,tgl_sql_gm($tgl),0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'L');
					$pdf->Cell($w[6],$h,'',0,0,'L');
					$pdf->Ln(5);
					$pdf->SetX(33);
					$pdf->Cell($w[0],$h,'Jl. A. Mappanyukki No.2',0,0,'L');
					$pdf->Cell($w[1],$h,'Supplier',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($w[3],$h,$kode_supplier.' - '.$nama_supplier,0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'L');
					$pdf->Cell($w[6],$h,'',0,0,'L');
					$pdf->Ln(5);
					$pdf->SetX(33);
					$pdf->Cell($w[0],$h,'0411 - 871408',0,0,'L');
					$pdf->Cell($w[1],$h,'Alamat ',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($pdf->GetStringWidth($w[3]),$h,$alamat,0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'L');
					$pdf->Cell($w[6],$h,'',0,0,'L');
					$pdf->Ln(5);
					$pdf->SetX(33);
					$pdf->Cell($w[0],$h,'0411 - 856555',0,0,'L');
					$pdf->Cell($w[1],$h,'Admin',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($w[2],$h,$admin,0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'L');
					$pdf->Cell($w[6],$h,'',0,0,'L');

					$pdf->Line(10, 33, 210-10, 33);

					$pdf->Ln(15);

					$pdf->SetFont('Times','',8);
					$pdf->Cell(0,0,'To         : Ibu Rita');
					$pdf->Ln(4);
					$pdf->Cell(0,0,'Bagian  : Keuangan');
					$pdf->Ln(5);
					$pdf->SetFont('Times','U',8);
					$pdf->Ln(5);
					$pdf->Cell(0,0,'Harap di sediakan Uang Tunai/Cek/BG** Sebagai Berikut');
					$pdf->Ln(5);
					//Column widths

					$w = array(8,25,20,15,20,30,12,30,30);

					//Header
					$pdf->SetFont('Times','B',8);
					$pdf->Cell($w[0],$h,'No',1,0,'C');
					$pdf->Cell($w[1],$h,'No. Invoice',1,0,'C');
					$pdf->Cell($w[2],$h,'Tanggal',1,0,'C');
					$pdf->Cell($w[3],$h,'Total Item',1,0,'C');
					$pdf->Cell($w[4],$h,'JT',1,0,'C');
					$pdf->Cell($w[5],$h,'Debet',1,0,'C');
					$pdf->Cell($w[6],$h,'Diskon',1,0,'C');
					$pdf->Cell($w[7],$h,'Bayar',1,0,'C');
					$pdf->Cell($w[8],$h,'Sisa',1,0,'C');
					$pdf->Ln();

					//data
					//$pdf->SetFillColor(224,235,255);
					$pdf->SetFont('Times','',8);
					$pdf->SetFillColor(204,204,204);
    			$pdf->SetTextColor(0);
					$total_kredit=0;
					$total_bayar=0;
					$total_sisa=0;
					$no=1;
					foreach($q->result() as $row)
					{
						$jt = $row->jt;
	    			$tgl_jt = strtotime($tanggal);
	    			$date = date('Y-m-j', strtotime('+'.$jt.' day', $tgl_jt));
	          $diskon=((($row->sisa)-($row->bayar))*$row->diskon)/100;
	          $sisa=(($row->sisa)-($row->bayar))-$diskon;
	          $total_kredit+=$row->total_akhir_o;
	          $total_bayar+=$row->bayar;
	          $total_sisa+=$sisa;
						$pdf->Cell($w[0],$h,$no,'LR',0,'C');
						$pdf->Cell($w[1],$h,$row->no_invoice,'LR',0,'C');
						$pdf->Cell($w[2],$h,tgl_sql($tanggal),'LR',0,'C');
						$pdf->Cell($w[3],$h,$row->total_item,'LR',0,'C');
						$pdf->Cell($w[4],$h,tgl_sql($date),'LR',0,'C');
						$pdf->Cell($w[5],$h,'Rp. '.separator_harga2($row->sisa),'LR',0,'C');
						$pdf->Cell($w[6],$h,$row->diskon.' %','LR',0,'C');
						$pdf->Cell($w[7],$h,'Rp. '.separator_harga2($row->bayar),'LR',0,'C');
						$pdf->Cell($w[8],$h,'Rp. '.separator_harga2($row->total_akhir_o),'LR',0,'C');
						$pdf->Ln();
						$no++;
					}
					// Closing line
					$pdf->Cell(array_sum($w),0,'','T');
					$pdf->Ln(1);
					$pdf->SetX(10);
					$pdf->Cell(100,$h,'Keterangan :','C');
					$pdf->SetX(30);
					$pdf->Cell(100,$h,$keterangan,'C');
					$pdf->Ln(10);
					$h = 5;
					$pdf->SetFont('Times','B',8);
					$pdf->SetX(10);
					$pdf->Cell(42,$h,'Diminta/dibuat Oleh,',0,0,'L');
					$pdf->Cell(20,$h,'Diperiksa Oleh',0,0,'L');
					$pdf->SetX(80);
					$pdf->Cell(20,$h,'Disetujui Oleh',0,0,'L');
					$pdf->SetX(20);
					$pdf->Ln(20);
					$pdf->SetFont('Times','B'.'U',8);
					$pdf->Cell(40,$h,'Ricky Tjan',0,0,'L');
					$pdf->Cell(30,$h,'(......................)',0,0,'L');
					$pdf->Cell(20,$h,'(......................)',0,0,'L');
					$pdf->Ln(3);
					$pdf->SetFont('Times','',8);
					$pdf->Cell(40,$h,'Operational Manager',0,0,'L');
					$w = array(20,3,20,18,3,38);
					$pdf->Ln(-15);
					$pdf->SetX(100);
					$pdf->SetFont('Times','',8);
					$pdf->Cell($w[0],$h,'',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'',0,0,'L');
					$pdf->Cell($w[3],$h,'Total Bayar',0,0,'L');
					$pdf->Cell($w[4],$h,' : ',0,0,'L');
					$pdf->Cell($w[5],$h,'Rp. '.separator_harga2($total_bayar),0,0,'R');
					$pdf->Ln(5);
					$pdf->SetX(100);
					$pdf->Cell($w[0],$h,'',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'',0,0,'L');
					$pdf->Cell($w[3],$h,'Sisa Kredit',0,0,'L');
					$pdf->Cell($w[4],$h,' : ',0,0,'L');
					$pdf->Cell($w[5],$h,'Rp. '.$sisa_kredit,0,0,'R');
					$pdf->Ln(5);
					$pdf->SetX(100);
					$pdf->Cell($w[0],$h,'',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'',0,0,'L');
					$pdf->Cell($w[3],$h,'',0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'R');
					$pdf->Ln(5);
					$pdf->SetX(100);
					$pdf->Cell($w[0],$h,'',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'',0,0,'L');
					$pdf->Cell($w[3],$h,'',0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'R');
					$pdf->Ln(5);
					$pdf->SetX(100);
					$pdf->Cell($w[0],$h,'',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'',0,0,'L');
					$pdf->Cell($w[3],$h,'',0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'R');
				//}

				//}
				$pdf->Output('Faktur Pembayaran Hutang - '.date('d-m-Y').'.pdf','I');
			}else{
				redirect($_SERVER['HTTP_REFERER']);

			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function cetak_permintaan_pembayaran()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){

			$id_c = $this->input->get('id');
			$admin = $this->session->userdata('nama_lengkap');
			$no_transaksi = $this->input->get('no_transaksi');
			$kode_supplier = $this->input->get('kode_supplier');
			$get_norek = $this->db_kpp->query("SELECT no_rekening FROM supplier WHERE kode_supplier='$kode_supplier'")->row();
			$no_rekening = $get_norek->no_rekening;
			$nama_supplier = $this->input->get('nama_supplier');
			$keterangan = $this->input->get('keterangan');
			$tgl=$this->input->get('tanggal');
			$tanggal = date("Y-m-d");
			$alamat = $this->input->get('alamat');
			$sub_total = $this->input->get('total_transaksi');
			$sisa_kredit = $this->input->get('sisa_kredit');
			$q = $this->db_kpp->query("SELECT h.*, om.no_invoice, omd.kode_item
																 FROM hutang h
																 JOIN item_masuk om
																 		ON h.no_invoice=om.no_invoice
																 JOIN item_masuk_detail omd
																 		ON om.id_item_masuk=omd.id_item_masuk

																 WHERE h.id_pembayaran_hutang='$id_c'");
			//$cetak_hutang = $this->input->get('cetak_hutang');
			//$number_of_hutang_clicked = $this->db_kpp->query("SELECT cetak FROM pembayaran_hutang WHERE id_pembayaran_hutang='$id_c'")->row();
			//$hutang_recorded = $number_of_hutang_clicked->cetak;

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
					$pdf->SetTitle('FAKTUR PEMBAYARAN DEBET');
					$pdf->SetCreator('IT Kumala');

					$h = 7;
					$pdf->SetFont('Times','B', 14);
					$pdf->Image('assets/img/kumala.png',10,6,20);
					$w = array(50,22,3,50,10,3,10);
					//Cop
					$pdf->SetY(5);
					$pdf->SetX(33);
					$pdf->SetFont('Times','B',8);
					$pdf->Cell($w[0],$h,'PERMINTAAN PEMBAYARAN',0,0,'L');
					$pdf->SetX(125);
					foreach($q->result() as $row) { $no_invoice = $row->no_invoice; }
					$pdf->Cell($w[1],$h,'No. Invoice',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($w[3],$h,$no_invoice,0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'L');
					$pdf->Cell($w[6],$h,'',0,0,'L');
					$pdf->Ln(5);
					$pdf->SetX(33);
					$pdf->Cell($w[0],$h,'PT.KUMALA MOTOR SEJAHTERA',0,0,'L');
					$pdf->SetX(125);
					$pdf->Cell($w[1],$h,'Tanggal',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($w[3],$h,date(" j F Y"),0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'L');
					$pdf->Cell($w[6],$h,'',0,0,'L');
					$pdf->Ln(5);
					$pdf->SetX(33);
					$pdf->Cell($w[0],$h,'Jl. A. Mappanyukki No.2',0,0,'L');
					$pdf->SetX(125);
					$pdf->Cell($w[1],$h,'No. Transaksi',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($w[3],$h,$no_transaksi,0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'L');
					$pdf->Cell($w[6],$h,'',0,0,'L');
					$pdf->Ln(5);
					$pdf->SetX(33);
					$pdf->Cell($w[0],$h,'0411 - 871408',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'',0,0,'L');
					$pdf->Cell($w[3],$h,'',0,0,'L');
					$pdf->Ln(5);
					$pdf->SetX(33);
					$pdf->Cell($w[0],$h,'0411 - 856555',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'',0,0,'L');
					$pdf->Cell($w[3],$h,'',0,0,'L');

					$pdf->Line(10, 36, 210-10, 36);

					$pdf->Ln(15);
					$total_bayar=0;
					foreach($q->result() as $row) { $total_bayar=$row->bayar; }

					//Column widths
					$pdf->SetFont('Times','',8);
					$pdf->Cell(0,0,'To         : Ibu Rita');
					$pdf->Ln(4);
					$pdf->Cell(0,0,'Bagian  : Keuangan');
					$pdf->Ln(5);
					$pdf->SetFont('Times','U',8);
					$pdf->Ln(5);
					$pdf->Cell(0,0,'Harap di sediakan Uang Tunai/Cek/BG** Sebagai Berikut');
					$w = array(30,70,50);
					$pdf->Ln(6);
					//Header
					$pdf->SetFont('Times','B',8);
					$pdf->Cell($w[0],$h,'Rp. '.separator_harga2($total_bayar).'.-',0,0,'C');
					$pdf->Cell($w[1],$h,'Tanggal'.date(" j F Y"),0,0,'C');
					$pdf->Cell($w[2],$h,'Transfer Ke Rekening :',0,0,'C');
					$pdf->Ln(5);
					$pdf->SetX(112);
					$pdf->Cell($w[2],$h,$nama_supplier,0,0,'C');
					$pdf->Ln(5);
					$pdf->SetX(108);
					$pdf->Cell($w[2],$h,'Acc No. '.$no_rekening,0,0,'C');
					$pdf->Ln(20);
					$pdf->SetFont('Times','U',8);
					$pdf->Ln(5);
					$pdf->Cell(0,0,'Untuk Pembayaran');
					$w = array(8,30,30,60,10,30,20);
					$pdf->Ln(5);
					//Header
					$pdf->SetFont('Times','B',8);
					$pdf->Cell($w[0],$h,'No',1,0,'C');
					$pdf->Cell($w[1],$h,'No. Invoice',1,0,'C');
					$pdf->Cell($w[2],$h,'Tanggal Invoice',1,0,'C');
					$pdf->Cell($w[3],$h,'Nama Item',1,0,'C');
					$pdf->Cell($w[4],$h,'Qty',1,0,'C');
					$pdf->Cell($w[5],$h,'Keterangan',1,0,'C');
					$pdf->Cell($w[6],$h,'Total',1,0,'C');
					$pdf->Ln();

					//data
					//$pdf->SetFillColor(224,235,255);
					$pdf->SetFont('Times','',8);
					$pdf->SetFillColor(204,204,204);
    			$pdf->SetTextColor(0);
					$no=1;
					foreach($q->result() as $row)
					{
						$harga_item = $row->harga_tebus_dpp;
						$total_item_item_masuk = $row->total_item_item_masuk;
						$total_harga = $total_item_item_masuk*$harga_item;
						$pdf->Cell($w[0],$h,$no++,'LR',0,'C');
						$pdf->Cell($w[1],$h,$row->no_invoice,'LR',0,'C');
						$pdf->Cell($w[2],$h,tgl_sql($row->tanggal_invoice),'LR',0,'C');
						$pdf->Cell($w[3],$h,$row->nama_item,'LR',0,'C');
						$pdf->Cell($w[4],$h,$row->total_item_item_masuk,'LR',0,'C');
						$pdf->Cell($w[5],$h,$row->keterangan,'LR',0,'C');
						$pdf->Cell($w[6],$h,separator_harga2($total_harga),'LR',0,'C');
						$pdf->Ln();
					}
					// Closing line
					$pdf->Cell(array_sum($w),0,'','T');
					$pdf->Ln(1);
					$pdf->SetX(10);
					//$pdf->Cell(100,$h,'Keterangan :','C');
					$pdf->SetX(30);
					//$pdf->Cell(100,$h,$keterangan,'C');
					$pdf->Ln(10);
					$h = 5;
					$pdf->SetX(10);
					$pdf->Cell(42,$h,'Diminta/dibuat Oleh',0,0,'L');
					$pdf->SetFont('Times','B',8);
					//$pdf->Cell(20,$h,'Penerima',0,0,'L');
					$pdf->SetX(20);
					$pdf->Ln(20);
					$pdf->Cell(40,$h,'(Ricky Tjan)',0,0,'L');
					//$pdf->Cell(30,$h,'(......................)',0,0,'L');
					$w = array(20,3,20,18,3,38);
					$pdf->Ln(-15);
					$pdf->SetX(100);
					$pdf->SetFont('Times','',8);
					$pdf->Cell($w[0],$h,'',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'',0,0,'L');
					//$pdf->Cell($w[3],$h,'Total Bayar',0,0,'L');
					//$pdf->Cell($w[4],$h,' : ',0,0,'L');
					//$pdf->Cell($w[5],$h,'Rp. '.separator_harga2($total_bayar),0,0,'R');
					$pdf->Ln(5);
					$pdf->SetX(100);
					$pdf->Cell($w[0],$h,'',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'',0,0,'L');
					//$pdf->Cell($w[3],$h,'Sisa Kredit',0,0,'L');
					//$pdf->Cell($w[4],$h,' : ',0,0,'L');
					//$pdf->Cell($w[5],$h,'Rp. '.$sisa_kredit,0,0,'R');
					$pdf->Ln(5);
					$pdf->SetX(100);
					$pdf->Cell($w[0],$h,'',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'',0,0,'L');
					$pdf->Cell($w[3],$h,'',0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'R');
					$pdf->Ln(5);
					$pdf->SetX(100);
					$pdf->Cell($w[0],$h,'',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'',0,0,'L');
					$pdf->Cell($w[3],$h,'',0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'R');
					$pdf->Ln(5);
					$pdf->SetX(100);
					$pdf->Cell($w[0],$h,'',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'',0,0,'L');
					$pdf->Cell($w[3],$h,'',0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'R');
				//}

				//}
				$pdf->Output('Faktur Pembayaran Hutang - '.date('d-m-Y').'.pdf','I');
			}else{
				redirect($_SERVER['HTTP_REFERER']);

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
			$id['id_pembayaran_hutang']	= $this->uri->segment(3);

			if($this->model_pembayaran_hutang->ada($id))
			{
				$this->model_pembayaran_hutang->delete($id);
			}
			redirect('henkel_adm_pembayaran_hutang','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
