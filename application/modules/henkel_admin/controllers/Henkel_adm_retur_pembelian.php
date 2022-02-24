<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_retur_pembelian extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_retur_pembelian');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Data Retur Pembelian";
			$d['class'] = "pembelian";
			$d['data'] = $this->model_retur_pembelian->all();
			$d['id_pes'] = $this->model_retur_pembelian->cari_max_retur_pembelian();
			$d['content'] = 'retur_pembelian/view';
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
			$id = $this->model_retur_pembelian->cari_max_retur_pembelian();
			$d = array('judul' 			=> 'Tambah Retur Pembelian',
						'class' 		=> 'pembelian',
						'id_retur_pembelian'=> $id,
						'tanggal'=> date("Y-m-d"),
						'no_transaksi'=> $this->create_kd(),
						'kode_supplier'	=> '',
						'nama_supplier'	=> '',
						'alamat'	=> '',
						'no_penjualan'	=> '',
						'kode_sales'	=> '',
						'nama_sales'	=> '',
						'keterangan'	=> '',
						'content' 		=> 'retur_pembelian/add',
						'data'		=>  $this->db_kpp->query("SELECT trp.*,o.nama_item,o.harga_tebus_dpp
																								FROM t_r_pembelian trp
																								JOIN item o
																								ON trp.kode_item=o.kode_item
																								WHERE trp.id_retur_pembelian='$id'")
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
			$last_kd = $this->model_retur_pembelian->last_kode();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = $tanggal.'/RPBL/'.sprintf("%04s", $no_akhir);
			}else{
				$kd = $tanggal.'/RPBL/'.'0001';
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

			$id_retur_pembelian 		= $this->uri->segment(3);
			$dt 	= $this->model_retur_pembelian->getByIdRPembelian($id_retur_pembelian);
			$no_retur	= $dt->no_retur;
			$no_po	= $dt->no_po;
			$tanggal 		= $dt->tanggal;
			$kode_supplier  = $dt->kode_supplier;
			$data_sp = $this->db_kpp->query("SELECT nama_supplier, alamat FROM supplier WHERE kode_supplier='$kode_supplier'");
			foreach($data_sp->result() as $dt_sp)
			{
				$nama_supplier = $dt_sp->nama_supplier;
				$alamat = $dt_sp->alamat;
			}
			$tunai  = $dt->tunai;
			$deposit  = $dt->deposit;
			$pot_hutang  = $dt->pot_hutang;
			$keterangan  = $dt->keterangan;
			$admin  = $dt->admin;
			$d = array('judul' 			=> 'Edit Retur Pembelian ',
						'class' 		=> 'pembelian',
						'id_retur_pembelian'	=> $id_retur_pembelian,
						'no_transaksi' 			=> $no_retur,
						'no_pembelian' 			=> $no_po,
						'tanggal'	=> $tanggal,
						'kode_supplier'	=> $kode_supplier,
						'nama_supplier'	=> $nama_supplier,
						'alamat'	=> $alamat,
						'tunai'	=> separator_harga2($tunai),
						'deposit'	=> separator_harga2($deposit),
						'pot_hutang'	=> separator_harga2($pot_hutang),
						'keterangan'	=> $keterangan,
						'admin'	=> $admin,
						'content'	=> 'retur_pembelian/edit',
						'data' => $this->db_kpp->query("SELECT rp.*,o.nama_item,o.harga_tebus_dpp
																						FROM r_pembelian rp
																						JOIN item o
																						ON rp.kode_item=o.kode_item
																						WHERE rp.id_retur_pembelian='$id_retur_pembelian'")
						);
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function cek_table(){
		$id['id_retur_pembelian']=$this->input->post('id_cek');
		$q 	 = $this->db_kpp->get_where("t_r_pembelian",$id);
		$row = $q->num_rows();
		echo $row;
	}

	public function get_total_transaksi(){
		$id=$this->input->get('no_pembelian');
		$total 	 = $this->model_retur_pembelian->get_data_pembelian($id);
			$d['total_akhir']	= separator_harga2($total->total_akhir);
			$d['diskon']	= $total->diskon;
			$status= $total->status;
			if($status=='Lunas'){
				$d['bayar']=0;
			}else {
				$d['bayar']=separator_harga2($total->bayar);
			}
			$d['total_hutang']=separator_harga2($total->sisa_o);
			$d['status']	= $status;
		echo json_encode($d);
	}

	public function baru(){
		$id['id_retur_pembelian']=$this->input->post('id_new');
		if($this->model_retur_pembelian->t_ada_id_pesanan($id))
		{
			$this->db_kpp->delete("t_r_pembelian",$id);
		}
	}

	public function cek(){
		$id=$this->input->post('no_pembelian');
		$id_r=$this->input->post('id_retur_pembelian');
		if($this->model_retur_pembelian->ada_transaksi($id))
		{
			$this->db_kpp->empty_table('t_r_pembelian');
			$id_t=$this->model_retur_pembelian->getIdItemMasuk($id);
			$this->db_kpp->query("INSERT INTO t_r_pembelian (id_retur_pembelian, kode_item, diskon, qty)
														SELECT '$id_r',kode_item, diskon, total_item_item_masuk
														FROM item_masuk_detail
														WHERE id_item_masuk='$id_t'");
			echo "1";
		}else {
			$this->db_kpp->empty_table('t_r_pembelian');
			echo "0";
		}
	}

	public function simpan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_retur_pembelian']= $this->input->post('id');
			$total_retur = $this->input->post('total_retur');
			$tunai = $this->input->post('tunai');
			$deposit = $this->input->post('deposit');
			$pot_hutang = $this->input->post('potong_hutang');
			$dt['no_retur'] = $this->input->post('no_transaksi');
			$dt['no_po'] = $this->input->post('no_pembelian');
			$dt['tanggal'] = $this->input->post('tanggal');
			$dt['kode_supplier'] = $this->input->post('kode_supplier');
			$dt['total_retur'] = remove_separator2($total_retur);
			$dt['tunai'] = remove_separator2($tunai);
			$dt['pot_hutang'] = remove_separator2($pot_hutang);
			$dt['deposit'] = remove_separator2($deposit);
			$dt['keterangan'] = $this->input->post('keterangan');
			$dt['admin'] = $this->session->userdata('nama_lengkap');
				if($this->model_retur_pembelian->ada($id)){
					$this->model_retur_pembelian->update($id, $dt);
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
			$id['id_retur_pembelian']= $this->input->post('id');
			$total_retur = $this->input->post('total_retur');
			$tunai = $this->input->post('tunai');
			$deposit = $this->input->post('deposit');
			$no_pembelian=$this->input->post('no_pembelian');
			$pot_hutang = $this->input->post('potong_hutang');
			$dt['no_retur'] = $this->input->post('no_transaksi');
			$dt['no_po'] = $no_pembelian;
			$dt['tanggal'] = $this->input->post('tanggal');
			$dt['kode_supplier'] = $this->input->post('kode_supplier');
			$dt['total_retur'] = remove_separator2($total_retur);
			$dt['tunai'] = remove_separator2($tunai);
			$dt['deposit'] = remove_separator2($deposit);
			$dt['pot_hutang'] = remove_separator2($pot_hutang);
			$dt['keterangan'] = $this->input->post('keterangan');
			$dt['admin'] = $this->session->userdata('nama_lengkap');
			$dt['id_retur_pembelian'] = $this->input->post('id');
			$id_t=$this->input->post('id');
			$this->db_kpp->query("INSERT INTO r_pembelian (id_retur_pembelian, kode_item,harga_retur, qty, qty_retur, diskon)
														SELECT id_retur_pembelian, kode_item,harga_retur, qty, qty_retur, diskon
														FROM t_r_pembelian
														WHERE id_retur_pembelian='$id_t'");
			$this->db_kpp->query("DELETE FROM t_r_pembelian WHERE id_retur_pembelian='$id_t'");
			$this->model_retur_pembelian->insert($dt);
			$this->db_kpp->query("UPDATE item_masuk SET status_retur='r' WHERE no_invoice='$no_pembelian'");
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
			/*$cetak_invoice = $this->input->get('cetak_invoice');
			$number_of_invoice_clicked = $this->db_kpp->query("SELECT cetak_invoice FROM retur_penjualan WHERE no_transaksi='$no_transaksi'")->row();
			$invoice_recorded = $number_of_invoice_clicked->cetak_invoice;
			if($cetak_invoice>=$invoice_recorded){
				$this->db_kpp->query("UPDATE retur_penjualan
															SET cetak_invoice=$cetak_invoice
															WHERE no_transaksi='$no_transaksi'");
			}*/
			$kode_supplier = $this->input->get('kode_supplier');
			$nama_supplier = $this->input->get('nama_supplier');
			$no_pembelian=$this->input->get('no_pembelian');
			$tgl=$this->input->get('tanggal');
			$keterangan = $this->input->get('keterangan');
			$alamat = $this->input->get('alamat');
			$tunai = $this->input->get('tunai');
			$deposit = $this->input->get('deposit');
			$pot_hutang = $this->input->get('pot_hutang');
			$total_pembelian = $this->input->get('total_pembelian');
			$total_dp = $this->input->get('total_dp');
			$total_retur = $this->input->get('total_retur');
			$q = $this->db_kpp->query("SELECT rp.*,o.nama_item,o.harga_tebus_dpp
																 FROM r_pembelian rp
																 JOIN item o
																 ON rp.kode_item=o.kode_item
																 WHERE rp.id_retur_pembelian='$id_c'");

			$r = $q->num_rows();

			if($r>0){
				define('FPDF_FONTPATH', $this->config->item('fonts_path'));
				require(APPPATH.'plugins/fpdf.php');

			  $pdf=new FPDF();
			  $pdf->AddPage('L',array(120,210));

				/*if ($invoice_recorded>0) {
					$pdf->Image("assets/img/copy.png", 65, 20);
				}*/
				//foreach($data->result() as $t){
					$A4[0]=210;
					$A4[1]=297;
					$Q[0]=216;
					$Q[1]=279;
					$pdf->SetTitle('FAKTUR RETUR PEMBELIAN ITEM');
					$pdf->SetCreator('IT Kumala');

					$h = 7;
					$pdf->SetFont('Times','B', 14);
					$pdf->Image('assets/img/kumala.png',10,6,20);
					$w = array(50,22,3,50,10,3,10);
					//Cop
					$pdf->SetY(5);
					$pdf->SetX(33);
					$pdf->SetFont('Times','B',8);
					$pdf->Cell($w[0],$h,'FAKTUR RETUR PEMBELIAN ITEM',0,0,'L');
					$pdf->Cell($w[1],$h,'No. Transaksi',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($w[3],$h,$no_transaksi,0,0,'L');
					$pdf->Cell($w[4],$h,'Admin',0,0,'L');
					$pdf->Cell($w[5],$h,' : ',0,0,'L');
					$pdf->Cell($w[6],$h,$admin,0,0,'L');
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
					$pdf->Cell($w[0],$h,'0411 - 871408',0,0,'L');
					$pdf->Cell($w[1],$h,'Supplier',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($w[3],$h,$kode_supplier.' - '.$nama_supplier,0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'L');
					$pdf->Cell($w[6],$h,'',0,0,'L');
					$pdf->Ln(5);
					$pdf->SetX(33);
					$pdf->Cell($w[0],$h,'0411 - 856555',0,0,'L');
					$pdf->Cell($w[1],$h,'Alamat',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					// cell width
					$pdf->MultiCell(40,$h,$alamat,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'L');
					$pdf->Cell($w[6],$h,'',0,0,'L');
					$pdf->Ln(2);
					$pdf->Line(10, $pdf->getY(), 210-10, $pdf->getY());
					$pdf->Ln(3);

					$pdf->SetX(10);
					$pdf->Cell(100,$h,'No. Invoice : '.$no_pembelian,'C');
					$pdf->Ln(10);

					//Column widths

					$w = array(8,15,45,20,18,17,15,22,30);

					//Header
					$pdf->SetFont('Times','B',8);
					$pdf->Cell($w[0],$h,'No',1,0,'C');
					$pdf->Cell($w[1],$h,'Kode Item',1,0,'C');
					$pdf->Cell($w[2],$h,'Nama Item',1,0,'C');
					$pdf->Cell($w[3],$h,'Harga Beli',1,0,'C');
					$pdf->Cell($w[4],$h,'Jml. Beli',1,0,'C');
					$pdf->Cell($w[5],$h,'Jml. Retur',1,0,'C');
					$pdf->Cell($w[6],$h,'Disk.',1,0,'C');
					$pdf->Cell($w[7],$h,'Sub. Total',1,0,'C');
					$pdf->Cell($w[8],$h,'Total',1,0,'C');
					$pdf->Ln();

					//data
					//$pdf->SetFillColor(224,235,255);
					$pdf->SetFont('Times','',8);
					$pdf->SetFillColor(204,204,204);
    			$pdf->SetTextColor(0);
					$total_transaksi=0;
					$total_item=0;
					$no=1;
					$total_retur_w=0;
					foreach($q->result() as $row)
					{
						$harga_retur= $row->harga_retur;
            $jumlah= $row->qty_retur;
						$sub_total = $row->harga_tebus_dpp*$jumlah;
            $diskon= $row->diskon;
            $harga = $harga_retur * $jumlah;
            $persen = ($row->harga_tebus_dpp * $diskon)/100;
						$persen_retur = ($sub_total * $diskon)/100;
            $total = $harga_retur-$persen;
						$total_transaksi_retur = $sub_total-$persen_retur;
            $total_transaksi += $total;
            $total_item += $jumlah;
						$total_retur_w += $total_transaksi_retur;
						$pdf->Cell($w[0],$h,$no++,'LR',0,'C');
						$pdf->Cell($w[1],$h,$row->kode_item,'LR',0,'C');
						$pdf->Cell($w[2],$h,$row->nama_item,'LR',0,'C');
						$pdf->Cell($w[3],$h,'Rp. '.separator_harga2($row->harga_tebus_dpp),'LR',0,'C');
						$pdf->Cell($w[4],$h,$row->qty,'LR',0,'C');
						$pdf->Cell($w[5],$h,$row->qty_retur,'LR',0,'C');
						$pdf->Cell($w[6],$h,$row->diskon.' %','LR',0,'C');
						$pdf->Cell($w[7],$h,'Rp. '.separator_harga2($sub_total),'LR',0,'C');
						$pdf->Cell($w[8],$h,'Rp. '.separator_harga2($total_transaksi_retur),'LR',0,'C');
						$pdf->Ln();
						$no++;
					}
					// Closing line
					$pdf->Cell(array_sum($w),0,'','T');
					$pdf->Ln(1);
					$pdf->SetX(10);
					$pdf->Cell(100,$h,'Keterangan : '.$keterangan,'C');
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
					$pdf->Cell($w[0],$h,'Tunai',0,0,'L');
					$pdf->Cell($w[1],$h,' : ',0,0,'L');
					$pdf->Cell($w[2],$h,$tunai,0,0,'L');
					$pdf->Cell($w[3],$h,'Total Transaksi',0,0,'L');
					$pdf->Cell($w[4],$h,' : ',0,0,'L');
					$pdf->Cell($w[5],$h,'Rp. '.$total_pembelian,0,0,'R');
					$pdf->Ln(5);
					$pdf->SetX(100);
					$pdf->Cell($w[0],$h,'Deposit',0,0,'L');
					$pdf->Cell($w[1],$h,' : ',0,0,'L');
					$pdf->Cell($w[2],$h,$deposit,0,0,'L');
					$pdf->Cell($w[3],$h,'Total DP',0,0,'L');
					$pdf->Cell($w[4],$h,' : ',0,0,'L');
					if ($total_dp==0) {
						$total_dp=0;
					}
					$pdf->Cell($w[5],$h,'Rp. '.$total_dp,0,0,'R');
					$pdf->Ln(5);
					$pdf->SetX(100);
					$pdf->Cell($w[0],$h,'Pot. Hutang',0,0,'L');
					$pdf->Cell($w[1],$h,' : ',0,0,'L');
					$pdf->Cell($w[2],$h,$pot_hutang,0,0,'L');
					$pdf->Cell($w[3],$h,'Total Retur',0,0,'L');
					$pdf->Cell($w[4],$h,' : ',0,0,'L');
					$pdf->Cell($w[5],$h,'Rp. '.separator_harga2($total_retur_w),0,0,'R');
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
				$pdf->Output('Faktur Retur Penjualan Item - '.date('d-m-Y').'.pdf','I');
			}else{
				redirect($_SERVER['HTTP_REFERER']);

			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function cetak_sj()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){

			$id_c = $this->input->get('id');
			$no_transaksi = $this->input->get('no_transaksi');
			$kode_pelanggan = $this->input->get('kode_pelanggan');
			$telepon = $this->model_retur_penjualan->getTelephonePel($kode_pelanggan);
			$nama_pelanggan = $this->input->get('nama_pelanggan');
			$tgl=$this->input->get('tanggal');
			$alamat = $this->input->get('alamat');
			$kode_sales = $this->input->get('kode_sales');
			$q = $this->db_kpp->query("SELECT *	FROM penjualan JOIN item ON penjualan.kode_item=item.kode_item WHERE penjualan.id_retur_penjualan='$id_c'");

			$r = $q->num_rows();

			if($r>0){
				define('FPDF_FONTPATH', $this->config->item('fonts_path'));
				require(APPPATH.'plugins/fpdf.php');

			  $pdf=new FPDF();
			  $pdf->AddPage("P","A4");
					$A4[0]=210;
					$A4[1]=297;
					$Q[0]=216;
					$Q[1]=279;
					$pdf->SetTitle('SURAT JALAN');
					$pdf->SetCreator('IT Kumala');

					$h = 7;
					$pdf->SetFont('Times','B', 14);
					$pdf->Image('assets/img/kumala.png',10,6,20);
					$w = array(50,60,22,3,50);
					//Cop
					$pdf->SetY(5);
					$pdf->SetX(33);
					$pdf->SetFont('Times','B',8);
					$pdf->Cell($w[0],$h,'SURAT JALAN',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'No. Transaksi',0,0,'L');
					$pdf->Cell($w[3],$h,' : ',0,0,'L');
					$pdf->Cell($w[4],$h,$no_transaksi,0,0,'L');
					$pdf->Ln(5);
					$pdf->SetX(33);
					$pdf->Cell($w[0],$h,'PT.KUMALA MOTOR SEJAHTERA',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'Tanggal',0,0,'L');
					$pdf->Cell($w[3],$h,' : ',0,0,'L');
					$pdf->Cell($w[4],$h,tgl_sql_gm($tgl),0,0,'L');
					$pdf->Ln(5);
					$pdf->SetX(33);
					$pdf->Cell($w[0],$h,'Jl. A. Mappanyukki No.2',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'',0,0,'L');
					$pdf->Cell($w[3],$h,' ',0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Ln(5);
					$pdf->SetX(33);
					$pdf->Cell($w[0],$h,'0411 - 871408',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'',0,0,'L');
					$pdf->Cell($w[3],$h,'  ',0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Ln(5);
					$pdf->SetX(33);
					$pdf->Cell($w[0],$h,'0411 - 856555',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'',0,0,'L');
					$pdf->Cell($w[3],$h,'  ',0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');

					$pdf->Line(10, 33, 210-10, 33);

					$pdf->Ln(10);

					$pdf->SetX(10);
					$pdf->Cell(100,$h,'Kepada Yth.','C');
					$pdf->Ln(5);
					$w = array(20,3,62);
					$pdf->SetX(10);
					$pdf->SetFont('Times','B',8);
					$pdf->Cell($w[0],$h,'Nama',0,0,'L');
					$pdf->Cell($w[1],$h,' : ',0,0,'L');
					$pdf->Cell($w[2],$h,$nama_pelanggan,0,0,'L');
					$pdf->Ln(5);
					$pdf->SetX(10);
					$pdf->Cell($w[0],$h,'Telephone',0,0,'L');
					$pdf->Cell($w[1],$h,' : ',0,0,'L');
					$pdf->Cell($w[2],$h,$telepon,0,0,'L');
					$pdf->Ln(5);
					$pdf->SetX(10);
					$pdf->Cell($w[0],$h,'Alamat',0,0,'L');
					$pdf->Cell($w[1],$h,' : ',0,0,'L');
					$pdf->Cell($w[2],$h,$alamat,0,0,'L');
					$pdf->Ln(10);

					$w = array(8,82,15,35,15,35);

					//Header
					$pdf->SetFont('Times','B',8);
					$pdf->Cell($w[0],$h,'No',1,0,'C');
					$pdf->Cell($w[1],$h,'Nama Item',1,0,'C');
					$pdf->Cell($w[2],$h,'Jumlah',1,0,'C');
					$pdf->Cell($w[3],$h,'Harga',1,0,'C');
					$pdf->Cell($w[4],$h,'Diskon',1,0,'C');
					$pdf->Cell($w[5],$h,'Total',1,0,'C');
					$pdf->Ln();

					//data
					//$pdf->SetFillColor(224,235,255);
					$pdf->SetFont('Times','',8);
					$pdf->SetFillColor(204,204,204);
    			$pdf->SetTextColor(0);
					$jml=0;
					$no=1;
					foreach($q->result() as $row)
					{
						$harga_item= $row->harga_item;
            $jumlah= $row->qty;
            $diskon= $row->diskon;
            $harga = $harga_item * $jumlah;
            $persen = ($harga * $diskon)/100;
            $total = $harga-$persen;
						$jml += $jumlah;
						$pdf->Cell($w[0],$h,$no,'LR',0,'C');
						$pdf->Cell($w[1],$h,$row->nama_item,'LR',0,'C');
						$pdf->Cell($w[2],$h,$row->qty,'LR',0,'C');
						$pdf->Cell($w[3],$h,'Rp. '.separator_harga2($harga),'LR',0,'C');
						$pdf->Cell($w[4],$h,$row->diskon.' %','LR',0,'C');
						$pdf->Cell($w[5],$h,'Rp. '.separator_harga2($total),'LR',0,'C');
						$pdf->Ln();
						$no++;
					}

					// Closing line
					$pdf->Cell(array_sum($w),0,'','T');
					$pdf->Ln(1);
					$pdf->SetX(10);
					$pdf->SetFont('Times','B',8);
					$pdf->Cell(20,$h,'Total Item    : ','C');
					$pdf->Cell(100,$h,$jml,'C');
					$pdf->Ln(5);
					$pdf->Cell(20,$h,'Catatan    : ','C');
					$pdf->Ln(10);
					$h = 5;
					$pdf->SetFont('Times','I',8);
					$pdf->SetX(10);
					$pdf->Cell(42,$h,'BARANG SUDAH DITERIMA DALAM KEADAAN BAIK DAN CUKUP oleh',0,0,'L');
					$pdf->Ln(3);
					$pdf->Cell(42,$h,'(tanda tangan dan cap(stemple) perusahaan)',0,0,'L');
					$pdf->Ln(5);
					$pdf->SetFont('Times','B',8);
					$pdf->SetX(10);
					$pdf->Cell(42,$h,'Penerima / Pembeli',0,0,'L');
					$pdf->Cell(42,$h,'Bagian Pengiriman',0,0,'L');
					$pdf->Cell(20,$h,'Petugas Gudang',0,0,'L');
					$pdf->Ln(10);
					$pdf->SetX(13);
					$pdf->Cell(42,$h,'(......................)',0,0,'L');
					$pdf->Cell(40,$h,'(......................)',0,0,'L');
					$pdf->Cell(30,$h,'(......................)',0,0,'L');
					$w = array(100);
					$pdf->Ln(-25);
					$pdf->SetX(140);
					$pdf->SetFont('Times','',6);
					$pdf->Cell($w[0],$h,'PERHATIAN :',0,0,'L');
					$pdf->Ln(3);
					$pdf->SetX(140);
					$pdf->Cell($w[0],$h,'1. Surat jalan ini merupakan bukti resmi penerimaan barang',0,0,'L');
					$pdf->Ln(3);
					$pdf->SetX(140);
					$pdf->Cell($w[0],$h,'2. Surat jalan ini bukan bukti penjualan',0,0,'L');
					$pdf->Ln(3);
					$pdf->SetX(140);
					$pdf->Cell($w[0],$h,'3. Surat jalan ini akan dilengkapi invoice sebagai bukti penjualan',0,0,'L');
					$pdf->Ln(3);
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
			$id['id_retur_penjualan']	= $this->uri->segment(3);

			if($this->model_retur_penjualan->ada($id))
			{
				$this->model_retur_penjualan->delete($id);
			}
			redirect('henkel_adm_retur_penjualan','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
