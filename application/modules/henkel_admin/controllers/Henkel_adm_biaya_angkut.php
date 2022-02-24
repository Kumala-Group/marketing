<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_biaya_angkut extends CI_Controller {

	public function __construct() {
	    parent::__construct();
		$this->load->model('model_biaya_angkut');
	}

	public function index() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Data Biaya Angkut";
			$d['class'] = "pembelian";
			$d['data'] = $this->model_biaya_angkut->all();
			$d['content'] = 'biaya_angkut/view';
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}


	public function tambah() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id_pesanan_pembelian = $this->model_biaya_angkut->cari_max_pesanan_pembelian();
			$id = $this->model_biaya_angkut->cari_max_pesanan_pembelian();
			$d = array('judul' 			=> 'Tambah Biaya Angkut',
						'class' 		=> 'pembelian',
						'id_pesanan_pembelian'=> $id_pesanan_pembelian,
						'tanggal'=> date("Y-m-d"),
						'no_inv_angkut'=> $this->create_kd(),
						'kode_supplier'	=> '',
						'nama_supplier'	=> '',
						'alamat'	=> '',
						'jt'	=> '0',
						'status'	=> 'Kredit',
						'keterangan'	=> '',
						'total_item'	=> '0',
						'total_akhir'	=> '0',
						'content' 		=> 'biaya_angkut/add',
						'data'		=>  $this->db_kpp->query("SELECT t_biaya_angkut.no_inv_supplier,pesanan_pembelian.no_po,pesanan_pembelian.kode_supplier	FROM t_biaya_angkut,pesanan_pembelian WHERE pesanan_pembelian.id_pesanan_pembelian=t_biaya_angkut.id_pesanan_pembelian")
						);
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function create_kd() {
		$tanggal = date("y-m");
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){

			$last_kd = $this->model_biaya_angkut->last_kode();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = $tanggal.'/INV-ANGKUT/'.sprintf("%03s", $no_akhir);
				//echo json_encode($d);
			}else{
				$kd = $tanggal.'/INV-ANGKUT/'.'001';
				//echo json_encode($d);
			}
			return $kd;
		}else{
			redirect('henkel','refresh');
		}
	}

	public function last_kode(){
		$q = $this->db_kpp->query("SELECT MAX(right(no_po,3)) as kode FROM biaya_angkut ");
		$row = $q->num_rows();

		if($row > 0){
            $rows = $q->result();
            $hasil = (int)$rows[0]->kode;
        }else{
            $hasil = 0;
        }
		return $hasil;
	}

	public function baru(){
		$id['id_biaya_angkut']=$this->input->post('id_new');
		if($this->model_biaya_angkut->t_ada_id_pesanan($id)) {
			$this->db_kpp->delete("t_pembelian",$id);
		}
	}

	public function cek_table(){
		$id['id_pesanan_pembelian']=$this->input->post('id_cek');
		$q 	 = $this->db_kpp->get_where("pesanan_pembelian",$id);
		$row = $q->num_rows();
		echo $row;
	}

	public function simpan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_biaya_angkut']= $this->input->post('id')+1;
				if($this->model_biaya_angkut->adaa($id)){
					$this->model_biaya_angkut->update($id, $dt);
					echo "Data Sukses diUpdate";
				}else{
					$dt['id_biaya_angkut'] = $this->input->post('id');
					$id_t=$this->input->post('no_inv_pengiriman');
					$tanggal_pengiriman=tgl_sql($this->input->post('tanggal_pengiriman'));
					$biaya_pengiriman=$this->input->post('biaya_pengiriman');
					if (
						$this->db_kpp->query("INSERT INTO biaya_angkut (no_inv_pengiriman,no_inv_supplier, id_pesanan_pembelian,tanggal_pengiriman,biaya_pengiriman)
	SELECT no_inv_pengiriman,no_inv_supplier,id_pesanan_pembelian,'$tanggal_pengiriman','$biaya_pengiriman'
	FROM t_biaya_angkut WHERE no_inv_pengiriman='$id_t'")&&
						$this->db_kpp->query("DELETE FROM t_biaya_angkut WHERE no_inv_pengiriman='$id_t'")
					) {
						echo "Data Sukses diSimpan";
					}else {
						echo error_reporting;
					}

				}
		}else{
			redirect('henkel','refresh');
		}

	}

public function t_simpan() {
	$cek = $this->session->userdata('logged_in');
	$level = $this->session->userdata('level');
	if(!empty($cek) && $level=='henkel_admin'){
		date_default_timezone_set('Asia/Makassar');
		$id['id_t_biaya_angkut']= $this->input->post('id_t_biaya_angkut');
		$dt['no_inv_supplier'] = $this->input->post('no_inv_supplier');
		$dt['no_inv_pengiriman'] = $this->input->post('no_inv_pengirimank');
		$dt['id_pesanan_pembelian'] = $this->input->post('id_pesanan_pembelian');
			if($this->model_biaya_angkut->ada($id)){
				$this->model_biaya_angkut->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_t_biaya_angkut'] = $this->input->post('id_t_biaya_angkut');
				$this->model_biaya_angkut->insert($dt);
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
		$no_po = base64_decode($this->input->get('no_po'));
		$cetak_invoice = $this->input->get('cetak_invoice');
		$number_of_invoice_clicked = $this->db_kpp->query("SELECT cetak_invoice FROM biaya_angkut WHERE no_po='$no_po'")->row();
		$invoice_recorded = $number_of_invoice_clicked->cetak_invoice;
		if($cetak_invoice>=$invoice_recorded){
			$this->db_kpp->query("UPDATE biaya_angkut
														SET cetak_invoice=$cetak_invoice
														WHERE no_po='$no_po'");
		}
		$id_c = base64_decode($this->input->get('id'));
		$tanggal=base64_decode($this->input->get('tanggal'));
		$kode_supplier = base64_decode($this->input->get('kode_supplier'));
		$q_supplier = $this->db_kpp->query("SELECT provinsi, telepon, fax, kontak FROM supplier WHERE kode_supplier='$kode_supplier'");
		$nama_supplier = base64_decode($this->input->get('nama_supplier'));
		$alamat = base64_decode($this->input->get('alamat'));
		$jt = base64_decode($this->input->get('jt'));
		$sub_total = base64_decode($this->input->get('sub_total'));
		$diskon_all = base64_decode($this->input->get('diskon_all'));
		$keterangan = $this->input->get('keterangan');
		$total_item = base64_decode($this->input->get('total_item'));
		$total_akhir = base64_decode($this->input->get('total_akhir'));
		/*$a = remove_separator2($total_akhir);
		$ppn = ($a*10)/100;
		$total_akhir_ppn = $a+$ppn;*/

		$q = $this->db_kpp->query("SELECT *
															 FROM pembelian JOIN item ON pembelian.kode_item=item.kode_item
															 WHERE pembelian.id_biaya_angkut='$id_c'");

		$r = $q->num_rows();
		$r_supplier = $q_supplier->num_rows();

		if($r>0){
			define('FPDF_FONTPATH', $this->config->item('fonts_path'));
			require(APPPATH.'plugins/fpdf.php');
			$pdf=new FPDF();
			$pdf->AddPage("P","A4");
			if ($invoice_recorded>0) {
				$pdf->Image("assets/img/copy.png", 65, 20);
			}
			//foreach($data->result() as $t){
				$A4[0]=210;
				$A4[1]=297;
				$Q[0]=216;
				$Q[1]=279;
				$pdf->SetTitle('FAKTUR PEMBELIAN ITEM');
				$pdf->SetCreator('IT Kumala');

				$h = 7;
				$pdf->SetFont('Times','B', 14);
				$pdf->Image('assets/img/kumala.png',10,6,20);
				$w = array(70,1,3,50);
				//Cop
				$pdf->SetY(5);
				$pdf->SetX(33);
				$pdf->SetFont('Times','B',8);
				$pdf->Cell($w[0],$h,'FAKTUR PEMBELIAN ITEM',0,0,'L');
				$pdf->Cell($w[1],$h,'PURCHASE ORDER',0,0,'L');
				$pdf->Ln(5);
				$pdf->SetX(33);
				$pdf->Cell($w[0],$h,'PT.KUMALA MOTOR SEJAHTERA',0,0,'L');
				$pdf->Cell($w[1],$h,'',0,0,'L');
				$pdf->Cell($w[2],$h,'No : '.$no_po,0,0,'L');
				//$pdf->Cell($w[3],$h,' : ',0,0,'L');
				//$pdf->Cell($w[4],$h,tgl_sql_gm($tanggal),0,0,'L');
				$pdf->Ln(5);
				$pdf->SetX(33);
				$pdf->Cell($w[0],$h,'Jl. A. Mappanyukki No.2',0,0,'L');
				/*$pdf->Cell($w[1],$h,'Kode Supplier',0,0,'L');
				$pdf->Cell($w[2],$h,' : ',0,0,'L');
				$pdf->Cell($w[3],$h,$kode_supplier.' - '.$nama_supplier,0,0,'L');*/
				$pdf->Ln(5);
				$pdf->SetX(33);
				$pdf->Cell($w[0],$h,'Telp : 0411-871408 '.' Fax: 0411 - 856555',0,0,'L');
				/*$pdf->Cell($w[1],$h,'Alamat',0,0,'L');
				$pdf->Cell($w[2],$h,' : ',0,0,'L');
				$pdf->MultiCell($w[3],$h,$alamat,0,'L');*/

				$pdf->Line(10, 34, 210-10, 34);

				$pdf->Ln(20);
				//Column widths
				if ($r_supplier>0) {
					foreach ($q_supplier->result() as $row) {
							$pdf->SetFont('Times','B',8);
							$pdf->Cell(0,0,'TO');
							$pdf->SetX(120);
							$pdf->Cell(0,0,'SHIP TO');
							$pdf->Ln(5);
							$pdf->SetFont('Times','',8);
							$pdf->Cell(0,0,$nama_supplier);
							$pdf->SetX(120);
							$pdf->Cell(0,0,'PT. Kumala Motor Sejahtera (Authorized Dealer HINO)');
							$pdf->Ln(5);
							$pdf->Cell(0,0,$row->kontak);
							$pdf->SetX(120);
							$pdf->Cell(0,0,'Jl.Ir.Sutami (Tol)');
							$pdf->Ln(5);
							$pdf->Cell(0,0,$alamat);
							$pdf->SetX(120);
							$pdf->Cell(0,0,'Makassar, Sulawesi Selatan - Indonesia');
							$pdf->Ln(5);
							$pdf->Cell(0,0,$row->provinsi);
							$pdf->SetX(120);
							$pdf->Cell(0,0,'Telp : 0411-871408 '.' Fax: 0411 - 856555');
							$pdf->Ln(5);
							$pdf->Cell(0,0,'Telp : '.$row->telepon);
							$pdf->Ln(5);
							$pdf->Cell(0,0,'Fax  : '.$row->fax);
					}
				}
				$pdf->Ln(10);

				//Column widths

				$w = array(8,15,92,15,25,10,25);

				//Header
				$pdf->SetFont('Times','B',8);
				$pdf->Cell($w[0],$h,'No',1,0,'C');
				$pdf->Cell($w[1],$h,'Kode Item',1,0,'C');
				$pdf->Cell($w[2],$h,'Nama Item',1,0,'C');
				$pdf->Cell($w[3],$h,'Jumlah',1,0,'C');
				$pdf->Cell($w[4],$h,'Harga',1,0,'C');
				$pdf->Cell($w[5],$h,'Diskon',1,0,'C');
				$pdf->Cell($w[6],$h,'Total',1,0,'C');
				$pdf->Ln();

				//data
				//$pdf->SetFillColor(224,235,255);
				$pdf->SetFont('Times','',8);
				$pdf->SetFillColor(204,204,204);
				$pdf->SetTextColor(0);
				$total_transaksi=0;
				$no=1;
				foreach($q->result() as $row)
				{
					$harga_item= $row->harga_item;
					$jumlah= $row->jumlah;
					$diskon= $row->diskon;
					$harga = $harga_item * $jumlah;
					$persen = ($harga * $diskon)/100;
					$total = $harga-$persen;
					$pdf->Cell($w[0],$h,$no,'LR',0,'C');
					$pdf->Cell($w[1],$h,$row->kode_item,'LR',0,'C');
					$pdf->Cell($w[2],$h,$row->nama_item,'LR',0,'C');
					$pdf->Cell($w[3],$h,$row->jumlah,'LR',0,'C');
					$pdf->Cell($w[4],$h,'Rp. '.separator_harga2($harga),'LR',0,'C');
					$pdf->Cell($w[5],$h,$row->diskon.' %','LR',0,'C');
					$pdf->Cell($w[6],$h,'Rp. '.separator_harga2($total),'LR',0,'C');
					$pdf->Ln();
					$no++;
				}
				// Closing line
				$pdf->Cell(array_sum($w),0,'','T');
				$pdf->Ln(1);
				$pdf->SetX(10);
				$pdf->Cell(100,$h,'Keterangan :','C');
				$pdf->SetX(26);
				$pdf->Cell(100,$h,$keterangan);
				$pdf->Ln(5);
				$pdf->SetX(10);
				$pdf->Cell(100,$h,'Jatuh Tempo :','C');
				$pdf->SetX(28);
				$pdf->Cell(100,$h,$jt.' Hari');
				$w = array(20,3,25,20,3,21);
				$pdf->Ln(0);
				$pdf->SetX(150);
				$pdf->Cell($w[0],$h,'Total Item',0,0,'L');
				$pdf->Cell($w[1],$h,' : ',0,0,'L');
				$pdf->Cell($w[2],$h,$total_item,0,0,'L');
				$pdf->Ln(5);
				$pdf->SetX(150);
				$pdf->Cell($w[0],$h,'Sub Total',0,0,'L');
				$pdf->Cell($w[1],$h,' : ',0,0,'L');
				$pdf->Cell($w[2],$h,$sub_total,0,0,'L');
				$pdf->Ln(5);
				$pdf->SetX(150);
				$pdf->Cell($w[0],$h,'Diskon',0,0,'L');
				$pdf->Cell($w[1],$h,' : ',0,0,'L');
				$pdf->Cell($w[2],$h,$diskon_all.' %',0,0,'L');
				$pdf->Ln(5);
				$pdf->SetX(150);
				$pdf->Cell($w[3],$h,'Total Akhir',0,0,'L');
				$pdf->Cell($w[4],$h,' : ',0,0,'L');
				$pdf->Cell($w[5],$h,'Rp. '.$total_akhir.'*',0,0,'R');
				$pdf->Ln(5);
				$h = 5;
				$pdf->SetFont('Times','I',6);
				$pdf->SetX(150);
				$pdf->Cell(10,$h,'*Harga Termasuk PPn 10%',0,0,'L');
				$pdf->SetFont('Times','B',8);
				$pdf->Ln(20);
				$pdf->SetX(151);
				$pdf->Cell(42,$h,'Authorized by',0,0,'L');

				$pdf->Ln(20);
				$pdf->SetX(150);
				$pdf->Cell(40,$h,'(.........................)',0,0,'L');
				$pdf->Ln(3);
				$w = array(20,3,20,18,3,38);
				$pdf->SetX(153);
				$pdf->Cell(42,$h,'Ricky Tjan',0,0,'L');
			  $pdf->Output('Faktur Pembelian Item - '.date('d-m-Y').'.pdf','I');
		}else{
			redirect($_SERVER['HTTP_REFERER']);

		}
	}else{
		redirect('henkel','refresh');
	}
}

	public function edit()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){

			$id_biaya_angkut 		= $this->uri->segment(3);
			$dt 	= $this->model_biaya_angkut->get($id_biaya_angkut);
			$no_po	= $dt->no_po;
			$tanggal 		= $dt->tanggal;
			$kode_supplier  = $dt->kode_supplier;
			$data_sp = $this->db_kpp->query("SELECT nama_supplier, alamat FROM supplier WHERE kode_supplier='$kode_supplier'");
			foreach($data_sp->result() as $dt_sp)
			{
				$nama_supplier = $dt_sp->nama_supplier;
				$alamat = $dt_sp->alamat;
			}
			$keterangan  = $dt->keterangan;
			$total_item  = $dt->total_item;
			$total_akhir  = $dt->total_akhir;
			$sub_total  = $dt->subtotal;
			$jt = $dt->jt;
			$kredit = $dt->kredit_a;
			$bayar = $dt->bayar;
			$diskon_all = $dt->diskon;
			$t_akhir = $this->db_kpp->query("SELECT SUM((o.harga_item*jumlah)-((o.harga_item*jumlah)*diskon/100)) as total_akhir
																			 FROM pembelian p
																			 INNER JOIN item o
																			 ON o.kode_item=p.kode_item
																			 WHERE id_biaya_angkut='$id_biaya_angkut'")->result();
			$tot_akhir=(int)$t_akhir[0]->total_akhir;
			$diskon_rp  = ($tot_akhir*$diskon_all)/100;
			$status = $dt->status;
			$d = array('judul' 			=> 'Edit Biaya Angkut ',
						'class' 		=> 'pembelian',
						'id_biaya_angkut'	=> $id_biaya_angkut,
						'no_po' 			=> $no_po,
						'tanggal'	=> $tanggal,
						'kode_supplier'	=> $kode_supplier,
						'nama_supplier'	=> $nama_supplier,
						'alamat'	=> $alamat,
						'bayar'	=> $bayar,
						'diskon_all'	=> $diskon_all,
						'diskon_rp'	=> separator_harga2($diskon_rp),
						'jt'	=> $jt,
						'kredit'	=> $kredit,
						'sub_total'	=> $sub_total,
						'status'	=> $status,
						'total_transaksi' => $total_akhir,
						'keterangan'	=> $keterangan,
						'content'	=> 'biaya_angkut/edit',
						'data' => $this->db_kpp->query("SELECT * FROM pembelian JOIN item ON pembelian.kode_item=item.kode_item WHERE pembelian.id_biaya_angkut='$id_biaya_angkut'")
						);
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_biaya_angkut']	= $this->uri->segment(3);

			if($this->model_biaya_angkut->ada($id))
			{
				$this->model_biaya_angkut->delete($id);
			}
			redirect('henkel_adm_biaya_angkut','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
