<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_pembayaran_piutang extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_pembayaran_piutang');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Data Pembayaran Piutang";
			$d['class'] = "penjualan";
			$d['data'] = $this->model_pembayaran_piutang->all();
			//$d['bayar']=
			$d['id_piutang'] = $this->model_pembayaran_piutang->cari_max_pembayaran_piutang();
			$d['content'] = 'pembayaran_piutang/view';
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
			$id_pembayaran_piutang = $this->model_pembayaran_piutang->cari_max_pembayaran_piutang();
			$d = array('judul' 			=> 'Tambah Pembayaran Piutang',
						'class' 		=> 'penjualan',
						'id_pembayaran_piutang'=> $id_pembayaran_piutang,
						'tanggal'=> date("Y-m-d"),
						'no_transaksi'=> $this->create_kd(),
						'kode_pelanggan'	=> '',
						'nama_pelanggan'	=> '',
						'alamat'	=> '',
						'status'	=> 'Lunas/Kredit',
						'sisa'	=> '0',
						'keterangan'	=> '',
						'content' 		=> 'pembayaran_piutang/add',
						'data'		=>  $this->db_kpp->query("SELECT tp.*,pp.no_transaksi,pp.tgl,pp.total_item,pp.jt FROM t_piutang tp JOIN pesanan_penjualan pp ON tp.no_transaksi=pp.no_transaksi"),
						'data_exception'	=>  $this->db_kpp->query("SELECT tpep.*,pp_exception.no_transaksi,pp_exception.tgl,pp_exception.total_item,pp_exception.jt
															 FROM t_piutang_exception_pembayaran tpep
															 JOIN pesanan_penjualan pp_exception ON tpep.no_transaksi=pp_exception.no_transaksi")
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

			$last_kd = $this->model_pembayaran_piutang->last_kode();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = $tanggal.'/PPT/'.sprintf("%03s", $no_akhir);
				//echo json_encode($d);
			}else{
				$kd = $tanggal.'/PPT/'.'001';
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

			$id_pembayaran_piutang 		= $this->uri->segment(3);
			$dt 	= $this->model_pembayaran_piutang->getByIdPPiutang($id_pembayaran_piutang);
			$no_piutang	= $dt->no_piutang;
			$tgl 		= $dt->tanggal;
			$kode_pelanggan  = $dt->kode_pelanggan;
			$data_pl = $this->db_kpp->query("SELECT nama_pelanggan, alamat FROM pelanggan WHERE kode_pelanggan='$kode_pelanggan'");
			foreach($data_pl->result() as $dt_pl)
			{
				$nama_pelanggan = $dt_pl->nama_pelanggan;
				$alamat = $dt_pl->alamat;
			}
			$data_sisa = $this->db_kpp->query("SELECT SUM(sisa_o) as total_sisa FROM pesanan_penjualan WHERE kode_pelanggan='$kode_pelanggan' AND status='Kredit'");
			foreach($data_sisa->result() as $dt_s)
			{
			   $total_sisa=(int)$dt_s->total_sisa;
			}
			$sisa  = $dt->sisa;
			$keterangan  = $dt->keterangan;
			$admin  = $dt->admin;
			$d = array('judul' 			=> 'Edit Pembayaran Piutang ',
						'class' 		=> 'penjualan',
						'id_pembayaran_piutang'	=> $id_pembayaran_piutang,
						'no_transaksi' 			=> $no_piutang,
						'tanggal'	=> $tgl,
						'kode_pelanggan'	=> $kode_pelanggan,
						'nama_pelanggan'	=> $nama_pelanggan,
						'alamat'	=> $alamat,
						'sisa'	=> $sisa,
						'keterangan'	=> $keterangan,
						'admin'	=> $admin,
						'content'	=> 'pembayaran_piutang/edit',
						'sisa_kredit' => $total_sisa,
						'data' => $this->db_kpp->query("SELECT p.*,pp.no_transaksi,pp.tgl,pp.total_item,pp.jt,pp.sisa_o FROM piutang p JOIN pesanan_penjualan pp ON p.no_transaksi=pp.no_transaksi WHERE p.id_pembayaran_piutang='$id_pembayaran_piutang'"),
						'data_exception' => $this->db_kpp->query("SELECT pep.*,pp_exception.no_transaksi,pp_exception.tgl,pp_exception.total_item,pp_exception.jt
															FROM piutang_exception_pembayaran pep
															JOIN pesanan_penjualan pp_exception ON pep.no_transaksi=pp_exception.no_transaksi
															WHERE pep.id_pembayaran_piutang='$id_pembayaran_piutang'")
						);
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function cek_table(){
		$id['id_pembayaran_piutang']=$this->input->post('id_cek');
		$q 	 = $this->db_kpp->get("t_piutang");
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
		$id['id_pembayaran_piutang']=$this->input->post('id_new');
		$this->db_kpp->empty_table("t_piutang");
	}

	public function cek(){
		$id=$this->input->post('kode_pelanggan');
		if($this->model_pembayaran_piutang->ada_hutang($id))
		{
			$this->db_kpp->empty_table('t_piutang');
			$id_t=$this->input->post('kode_pelanggan');
			$this->db_kpp->query("INSERT INTO t_piutang (no_transaksi,sisa,total_sisa)
														SELECT no_transaksi,sisa_o,sisa_o
														FROM pesanan_penjualan
														WHERE kode_pelanggan='$id_t' AND status='Kredit'");
			echo "1";
		}else {
			$this->db_kpp->empty_table('t_piutang');
			echo "0";
		}
	}

	public function simpan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_pembayaran_piutang']= $this->input->post('id');
			//$sisa = $this->input->post('total_akhir');

			$dt['no_piutang'] = $this->input->post('no_transaksi');
			$dt['tanggal'] = $this->input->post('tanggal');
			$dt['kode_pelanggan'] = $this->input->post('kode_pelanggan');
			//$dt['sisa'] = remove_separator2($sisa);
			$dt['keterangan'] = $this->input->post('keterangan');
			$dt['admin'] = $this->session->userdata('nama_lengkap');
			$dt['w_update'] = date('Y-m-d H:i:s');
			if($this->model_pembayaran_piutang->ada($id)){
				$this->model_pembayaran_piutang->update($id, $dt);
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
			$id['id_pembayaran_piutang']= $this->input->post('id');
			$id2=$this->input->post('id');
			$dt['no_piutang'] = $this->input->post('no_transaksi');
			$dt['tanggal'] = tgl_sql($this->input->post('tanggal'));
			$dt['kode_pelanggan'] = $this->input->post('kode_pelanggan');
			$dt['keterangan'] = $this->input->post('keterangan');
			$dt['admin'] = $this->session->userdata('nama_lengkap');
			$dt['w_insert'] = date('Y-m-d H:i:s');
			$dt['id_pembayaran_piutang'] = $this->input->post('id');
			$id_t=$this->input->post('id');
			$this->db_kpp->query("INSERT INTO piutang (id_pembayaran_piutang, tanggal_bayar, no_transaksi, sisa, diskon, bayar,total_sisa)
														SELECT id_pembayaran_piutang, tanggal_bayar, no_transaksi, sisa, diskon, bayar, total_sisa
														FROM t_piutang WHERE id_pembayaran_piutang='$id2'");
			$this->db_kpp->query("INSERT INTO piutang_exception_pembayaran (id_pembayaran_piutang, tanggal_bayar, no_transaksi, sisa, diskon, bayar,total_sisa,jenis_pembayaran,keterangan_bayar)
														SELECT id_pembayaran_piutang, tanggal_bayar, no_transaksi, sisa, diskon, bayar, total_sisa, jenis_pembayaran,keterangan_bayar
														FROM  t_piutang_exception_pembayaran WHERE id_pembayaran_piutang='$id2'");
			$this->db_kpp->empty_table('t_piutang');
			$this->model_pembayaran_piutang->insert($dt);
			echo "Data Sukses diSimpan";

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
			$kode_pelanggan = $this->input->get('kode_pelanggan');
			$nama_pelanggan = $this->input->get('nama_pelanggan');
			$keterangan = $this->input->get('keterangan');
			$tgl=$this->input->get('tanggal');
			$alamat = $this->input->get('alamat');
			$sub_total = $this->input->get('total_transaksi');
			$sisa_kredit = $this->input->get('sisa_kredit');
			$q = $this->db_kpp->query("SELECT p.*,pp.no_transaksi,pp.tgl,pp.total_item,pp.jt,pp.sisa_o FROM piutang p JOIN pesanan_penjualan pp ON p.no_transaksi=pp.no_transaksi WHERE p.id_pembayaran_piutang='$id_c'");
			$cetak_piutang = $this->input->get('cetak_piutang');
			$number_of_piutang_clicked = $this->db_kpp->query("SELECT cetak FROM pembayaran_piutang WHERE id_pembayaran_piutang='$id_c'")->row();
			$piutang_recorded = $number_of_piutang_clicked->cetak;
			if($cetak_piutang>=$piutang_recorded){
				$this->db_kpp->query("UPDATE pembayaran_piutang
															SET cetak=$cetak_piutang
															WHERE id_pembayaran_piutang='$id_c'");
			}

			$r = $q->num_rows();

			if($r>0){
				define('FPDF_FONTPATH', $this->config->item('fonts_path'));
				require(APPPATH.'plugins/fpdf.php');
			  $pdf=new FPDF();
			  $pdf->AddPage('L',array(120,210));
				if ($piutang_recorded>0) {
					$pdf->Image("assets/img/copy.png", 65, 20);
				}
				//foreach($data->result() as $t){
					$A4[0]=210;
					$A4[1]=297;
					$Q[0]=216;
					$Q[1]=279;
					$pdf->SetTitle('FAKTUR PEMBAYARAN KREDIT');
					$pdf->SetCreator('IT Kumala');

					$h = 7;
					$pdf->SetFont('Times','B', 14);
					$pdf->Image('assets/img/kumala.png',10,6,20);
					$w = array(50,22,3,50,10,3,10);
					//Cop
					$pdf->SetY(5);
					$pdf->SetX(33);
					$pdf->SetFont('Times','B',8);
					$pdf->Cell($w[0],$h,'FAKTUR PEMBAYARAN KREDIT',0,0,'L');
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
					$pdf->Cell($w[1],$h,'Pelanggan',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($w[3],$h,$kode_pelanggan.' - '.$nama_pelanggan,0,0,'L');
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

					$pdf->Ln(10);

					//Column widths

					$w = array(8,25,20,15,20,30,12,30,30);

					//Header
					$pdf->SetFont('Times','B',8);
					$pdf->Cell($w[0],$h,'No',1,0,'C');
					$pdf->Cell($w[1],$h,'No. Transaki',1,0,'C');
					$pdf->Cell($w[2],$h,'Tanggal',1,0,'C');
					$pdf->Cell($w[3],$h,'Total Item',1,0,'C');
					$pdf->Cell($w[4],$h,'JT',1,0,'C');
					$pdf->Cell($w[5],$h,'Kredit',1,0,'C');
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
	    			$tgl_jt = strtotime($row->tgl);
	    			$date = date('Y-m-j', strtotime('+'.$jt.' day', $tgl_jt));
	          $diskon=((($row->sisa)-($row->bayar))*$row->diskon)/100;
	          $sisa=(($row->sisa)-($row->bayar))-$diskon;
	          $total_kredit+=$row->sisa_o;
	          $total_bayar+=$row->bayar;
	          $total_sisa+=$sisa;
						$pdf->Cell($w[0],$h,$no++,'LR',0,'C');
						$pdf->Cell($w[1],$h,$row->no_transaksi,'LR',0,'C');
						$pdf->Cell($w[2],$h,tgl_sql($row->tgl),'LR',0,'C');
						$pdf->Cell($w[3],$h,$row->total_item,'LR',0,'C');
						$pdf->Cell($w[4],$h,tgl_sql($date),'LR',0,'C');
						$pdf->Cell($w[5],$h,'Rp. '.separator_harga2($row->sisa),'LR',0,'C');
						$pdf->Cell($w[6],$h,$row->diskon.' %','LR',0,'C');
						$pdf->Cell($w[7],$h,'Rp. '.separator_harga2($row->bayar),'LR',0,'C');
						$pdf->Cell($w[8],$h,'Rp. '.separator_harga2($row->sisa_o),'LR',0,'C');
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
					$pdf->Cell(42,$h,'Hormat Kami',0,0,'L');
					$pdf->Cell(20,$h,'Penerima',0,0,'L');
					$pdf->SetX(20);
					$pdf->Ln(10);
					$pdf->Cell(40,$h,'(......................)',0,0,'L');
					$pdf->Cell(30,$h,'(......................)',0,0,'L');
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
				$pdf->Output('Faktur Penjualan Item - '.date('d-m-Y').'.pdf','I');
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
			$id['id_pembayaran_piutang']	= $this->uri->segment(3);

			if($this->model_pembayaran_piutang->ada($id))
			{
				$this->model_pembayaran_piutang->delete($id);
			}
			redirect('henkel_adm_pembayaran_piutang','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
