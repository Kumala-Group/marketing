<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_pesanan_penjualan extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_pesanan_penjualan');
	}

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Data Pesanan Penjualan";
			$d['class'] = "penjualan";
			$d['data'] = $this->model_pesanan_penjualan->all();
			$d['id_pes'] = $this->model_pesanan_penjualan->cari_max_pesanan_penjualan();
			$d['content'] = 'pesanan_penjualan/view';
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
			$id_pesanan_penjualan = $this->model_pesanan_penjualan->cari_max_pesanan_penjualan();
			$id = $this->model_pesanan_penjualan->cari_max_pesanan_penjualan();
			$d = array('judul' 			=> 'Tambah Pesanan Penjualan',
						'class' 		=> 'penjualan',
						'id_pesanan_penjualan'=> $id_pesanan_penjualan,
						'tanggal'=> date("Y-m-d"),
						'no_transaksi'=> $this->create_kd(),
						'kode_pelanggan'	=> '',
						'nama_pelanggan'	=> '',
						'margin_min'	=> '',
						'margin_max'	=> '',
						'alamat'	=> '',
						'kode_sales'	=> '',
						'nama_sales'	=> '',
						'diskon_all'	=> '0',
						'diskon_rp'	=> '0',
						'pajak'	=> '0',
						'jt'	=> '0',
						'total_item'	=> '0',
						'total_akhir'	=> '0',
						'bayar'	=> '0',
						'kredit'	=> '0',
						'status'	=> 'Kredit',
						'keterangan'	=> '',
						'content' 		=> 'pesanan_penjualan/add',
						'data'		=>  $this->db_kpp->query("SELECT *	FROM t_penjualan JOIN item ON t_penjualan.kode_item=item.kode_item WHERE t_penjualan.id_pesanan_penjualan='$id' ORDER BY id_t_penjualan ASC")
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

			$last_kd = $this->model_pesanan_penjualan->last_kode();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = $tanggal.'/PJL/'.sprintf("%03s", $no_akhir);
				//echo json_encode($d);
			}else{
				$kd = $tanggal.'/PJL/'.'001';
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

			$id_pesanan_penjualan 		= $this->uri->segment(3);
			$dt 	= $this->model_pesanan_penjualan->getByIdPPenjualan($id_pesanan_penjualan);
			$no_transaksi	= $dt->no_transaksi;
			$tgl 		= $dt->tgl;
			$kode_pelanggan  = $dt->kode_pelanggan;
			$data_pl = $this->db_kpp->query("SELECT nama_pelanggan, alamat, limit_beli, kode_group_pelanggan FROM pelanggan WHERE kode_pelanggan='$kode_pelanggan'");
			foreach($data_pl->result() as $dt_pl)
			{
				$nama_pelanggan = $dt_pl->nama_pelanggan;
				$alamat = $dt_pl->alamat;
				$kode_group_pelanggan  = $dt_pl->kode_group_pelanggan;
				$limit  = $dt_pl->limit_beli;
			}
			$kode_sales  = $dt->kode_sales;
			$data_s = $this->db->query("SELECT nama_karyawan FROM karyawan WHERE nik='$kode_sales'
				UNION
				SELECT db_kpp.sales.nama_sales AS nama_karyawan FROM db_kpp.sales WHERE db_kpp.sales.kode_sales='$kode_sales'");
			foreach($data_s->result() as $dt_s)
			{
				$nama_sales = $dt_s->nama_karyawan;
			}
			$data_margin = $this->db_kpp->query("SELECT margin_min, margin_max FROM group_pelanggan WHERE kode_group_pelanggan='$kode_group_pelanggan'");
			$margin_min=0;
			$margin_max=0;
			$data_margin = $this->db_kpp->query("SELECT margin_min, margin_max FROM group_pelanggan WHERE kode_group_pelanggan='$kode_group_pelanggan'");
			foreach($data_margin->result() as $dt_margin)
			{
				if ($dt_margin->margin_min=='') {
					$margin_min = 0;
				} else {
					$margin_min = $dt_margin->margin_min;
				}

				if ($dt_margin->margin_max=='') {
					$margin_max = 0;
				} else {
					$margin_max = $dt_margin->margin_max;
				}
			}
			$pajak=$dt->pajak;
			$jt  = $dt->jt;
			$total_item  = $dt->total_item;
			$bayar  = $dt->bayar;
			$t_akhir = $this->db_kpp->query("SELECT SUM((harga_jual*qty)-((harga_jual*qty)*diskon/100)) as total_akhir FROM penjualan WHERE id_pesanan_penjualan='$id_pesanan_penjualan'")->result();
			$tot_akhir=(int)$t_akhir[0]->total_akhir;
			$total_akhir_transaksi = $dt->total_akhir;
			$diskon_all  = $dt->diskon;
			$diskon_rp  = ($tot_akhir*$diskon_all)/100;
			$total_akhir_o= $tot_akhir-$diskon_rp;
			$pajak_o  = ($total_akhir_o*$dt->pajak)/100;
			$total_akhir= $total_akhir_o+$pajak_o;
			$no_e_faktur  = $dt->no_e_faktur;
			$status  = $dt->status;
			$kredit  = $dt->sisa_a;
			$keterangan  = $dt->keterangan;
			$admin  = $dt->admin;
			$id_program_penjualan=$this->model_pesanan_penjualan->getId_program_penjualan($dt->id_program_penjualan);
			$data = $this->db_kpp->from('program_penjualan')->get();
			$output ='';
			if(count($id_program_penjualan)>0){
				foreach ($id_program_penjualan as $row) {
						foreach ($data->result() as $dt_pp) {
							$output ='<option value="'.$dt_pp->id_program_penjualan.'">'.$dt_pp->nama_program.'</option>';
							$output .='<option value="">--Pilih Program Penjualan--</option>';
							$output .='<option value="'.$row->id_program_penjualan.'">'.$row->nama_program.'</option>';
						}
				}
			} else if(count($id_program_penjualan)<=0){
				foreach ($data->result() as $row) {
							$output ='<option value="">--Pilih Program Penjualan--</option>';
							$output .='<option value="'.$row->id_program_penjualan.'">'.$row->nama_program.'</option>';
				}
			}

			$d = array('judul' 			=> 'Edit Pesanan Penjualan ',
						'class' 		=> 'penjualan',
						'id_pesanan_penjualan'	=> $id_pesanan_penjualan,
						'no_transaksi' 			=> $no_transaksi,
						'tanggal'	=> $tgl,
						'kode_pelanggan'	=> $kode_pelanggan,
						'nama_pelanggan'	=> $nama_pelanggan,
						'alamat'	=> $alamat,
						'limit'	=> $limit,
						'kode_sales'	=> $kode_sales,
						'nama_sales'	=> $nama_sales,
						'diskon_all'	=> $diskon_all,
						'diskon_rp'	=> $diskon_rp,
						'pajak'	=> $pajak,
						'no_e_faktur'	=> $no_e_faktur,
						'jt'	=> $jt,
						'total_item' => $total_item,
						'margin_max' => $margin_max,
						'margin_min' => $margin_min,
						'total_akhir' => $total_akhir,
						'total_akhir_transaksi' => $total_akhir_transaksi,
						'bayar'	=> $bayar,
						'kredit' => $kredit,
						'status'	=> $status,
						'program_penjualan' => $output,
						'keterangan'	=> $keterangan,
						'admin'	=> $admin,
						'content'	=> 'pesanan_penjualan/edit',
						'data' => $this->db_kpp->query("SELECT *	FROM penjualan JOIN item ON penjualan.kode_item=item.kode_item WHERE penjualan.id_pesanan_penjualan='$id_pesanan_penjualan' ORDER BY id_penjualan ASC")
						);
			$this->load->view('henkel_adm_home',$d);
		}else{
			redirect('henkel','refresh');
		}
	}

	public function reset(){
		$id_pp['id_pesanan_penjualan']=$this->input->get('id');
		$data['diskon'] = 0;
		$data['bayar'] = 0;
		$data['sisa_a'] = 0;
		$data['sisa_o'] = 0;
		$data['status'] = '';
		$this->db_kpp->update('pesanan_penjualan',$data,$id_pp);
	}

	public function cek_table(){
		$id['id_pesanan_penjualan']=$this->input->post('id_cek');
		$q 	 = $this->db_kpp->get_where("t_penjualan",$id);
		$row = $q->num_rows();
		echo $row;
	}

	public function baru(){
		$id['id_pesanan_penjualan']=$this->input->post('id_new');
		if($this->model_pesanan_penjualan->t_ada_id_pesanan($id))
		{
			$this->db_kpp->delete("t_penjualan",$id);
		}
	}

	public function simpan()
	{

		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_pesanan_penjualan']= $this->input->post('id');
			$no_e_faktur = $this->input->post('no_faktur');
			$total_akhir = $this->input->post('total_akhir');
			$total_akhir2= remove_separator2($total_akhir);
			$bayar = $this->input->post('bayar');
			$bayar2= remove_separator2($bayar);
			$kredit=$this->input->post('kredit');
			if($bayar2==0){
				$sisa= $total_akhir2;
			}else {
				$sisa = remove_separator2($kredit);
			}
			$dt['no_transaksi'] = $this->input->post('no_transaksi');
			$dt['tgl'] = tgl_sql($this->input->post('tanggal'));
			$dt['kode_pelanggan'] = $this->input->post('kode_pelanggan');
			$dt['kode_sales'] = $this->input->post('kode_sales');
			$dt['diskon'] = $this->input->post('diskon_all');
			$dt['pajak'] = $this->input->post('pajak');
			$dt['no_e_faktur'] = $this->input->post('no_faktur');
			$dt['jt'] = $this->input->post('jt');
			$dt['total_item'] = $this->input->post('total_item');
			$dt['total_akhir'] = $total_akhir2;
			$dt['bayar'] = $bayar2;
			$dt['sisa_a'] = $sisa;
			$dt['sisa_o'] = $sisa;
			$dt['status'] = $this->input->post('status');
			$dt['id_program_penjualan'] = $this->input->post('program_penjualan');
			$dt['keterangan'] = $this->input->post('keterangan');
			$dt['admin'] = $this->session->userdata('nama_lengkap');
			$dt['w_update'] = date('Y-m-d H:i:s');
			$id_program_penjualan = $this->input->post('program_penjualan');
			if($this->model_pesanan_penjualan->ada($id)){
				$this->model_pesanan_penjualan->update($id, $dt);
				$this->db_kpp->query("UPDATE e_faktur
															SET status='1'
															WHERE no_e_faktur='$no_e_faktur'; ");
				if ($id_program_penjualan>0) {
					  $id_result = $this->db_kpp->query("SELECT jumlah_bonus, kode_gudang, kode_item FROM program_penjualan_detail WHERE id_program_penjualan='$id_program_penjualan'");

						foreach ($id_result->result() as $row_pp) {
											$this->db_kpp->query("UPDATE stok_item	SET stok=stok".'-'.$row_pp->jumlah_bonus.
																					" WHERE kode_gudang='".$row_pp->kode_gudang."' AND kode_item='".$row_pp->kode_item."'" );
											}
						}
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
		$no_e_faktur = $this->input->post('no_faktur');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_pesanan_penjualan']= $this->input->post('id');
			$total_akhir = $this->input->post('total_akhir');
			$bayar = $this->input->post('bayar');
			$sisa = $this->input->post('kredit');
			$dt['no_transaksi'] = $this->input->post('no_transaksi');
			$dt['tgl'] = tgl_sql($this->input->post('tanggal'));
			$dt['kode_pelanggan'] = $this->input->post('kode_pelanggan');
			$dt['kode_sales'] = $this->input->post('kode_sales');
			$dt['diskon'] = $this->input->post('diskon_all');
			$dt['pajak'] = $this->input->post('pajak');
			$dt['jt'] = $this->input->post('jt');
			$dt['no_e_faktur'] = $this->input->post('no_faktur');
			$dt['total_item'] = $this->input->post('total_item');
			$dt['total_akhir'] = remove_separator($total_akhir);
			if (empty($bayar)) {
    		$dt['bayar'] = 0;
			} else {
				$dt['bayar'] = remove_separator($bayar);
			}
			$dt['sisa_a'] = remove_separator($sisa);
			$dt['sisa_o'] = remove_separator($sisa);
			$dt['status'] = $this->input->post('status');
			$dt['keterangan'] = $this->input->post('keterangan');
			$dt['id_program_penjualan'] = $this->input->post('program_penjualan');
			$dt['admin'] = $this->session->userdata('nama_lengkap');
			$dt['w_insert'] = date('Y-m-d H:i:s');
			$dt['id_pesanan_penjualan'] = $this->input->post('id');
			$id_t=$this->input->post('id');
			$id_program_penjualan = $this->input->post('program_penjualan');

			$id_result = $this->db_kpp->query("SELECT jumlah_bonus, kode_gudang, kode_item FROM program_penjualan_detail WHERE id_program_penjualan='$id_program_penjualan'");

			foreach ($id_result->result() as $row_pp) {
					   $this->db_kpp->query("UPDATE stok_item	SET stok=stok".'-'.$row_pp->jumlah_bonus.
															    " WHERE kode_gudang='".$row_pp->kode_gudang."' AND kode_item='".$row_pp->kode_item."'" );
			}
			$this->db_kpp->query("INSERT INTO penjualan (id_pesanan_penjualan, kode_item,harga_jual,kode_gudang, qty, diskon)
														SELECT id_pesanan_penjualan, kode_item,harga_jual, kode_gudang, qty, diskon
														FROM t_penjualan
														WHERE id_pesanan_penjualan='$id_t'");
			$this->db_kpp->query("DELETE FROM t_penjualan WHERE id_pesanan_penjualan='$id_t'");
			$this->db_kpp->query("UPDATE e_faktur
														SET status='1'
														WHERE no_e_faktur='$no_e_faktur'; ");
			$this->model_pesanan_penjualan->insert($dt);
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
			$cetak_invoice = $this->input->get('cetak_invoice');
			$number_of_invoice_clicked = $this->db_kpp->query("SELECT cetak_invoice FROM pesanan_penjualan WHERE no_transaksi='$no_transaksi'")->row();
			$invoice_recorded = $number_of_invoice_clicked->cetak_invoice;
			if($cetak_invoice>=$invoice_recorded){
				$this->db_kpp->query("UPDATE pesanan_penjualan
															SET cetak_invoice=$cetak_invoice
															WHERE no_transaksi='$no_transaksi'");
			}
			$kode_pelanggan = $this->input->get('kode_pelanggan');
			$nama_pelanggan = $this->input->get('nama_pelanggan');
			$tgl=$this->input->get('tanggal');
			$alamat = $this->input->get('alamat');
			$kode_sales = $this->input->get('kode_sales');
			$nama_sales = $this->input->get('nama_sales');
			$getidprogrampenjualan = $this->db_kpp->query("SELECT id_program_penjualan
																										 FROM pesanan_penjualan
																										 WHERE no_transaksi='$no_transaksi'")->row();
			$getprogrampenjualan = $this->db_kpp->query("SELECT prog_p.nama_program AS nama_program
																									 FROM pesanan_penjualan pes_p
																									 JOIN program_penjualan prog_p ON pes_p.id_program_penjualan=prog_p.id_program_penjualan
																									 WHERE no_transaksi='$no_transaksi'")->row();
			$id_program_penjualan = $getidprogrampenjualan->id_program_penjualan;
			$program_penjualan = '';
			if ($id_program_penjualan>0) {
				$program_penjualan = $getprogrampenjualan->nama_program;
			} else {
				$program_penjualan = '';
			}
			//$program_penjualan = $getprogrampenjualan->nama_program;
			$potongan = $this->input->get('diskon_all');
			$pajak = $this->input->get('pajak');
			$no_e_faktur = '';
			$e_faktur_exist = $this->db_kpp->query("SELECT no_e_faktur FROM pesanan_penjualan WHERE no_transaksi='$no_transaksi'")->row();
			$e_faktur_recorded = $e_faktur_exist->no_e_faktur;
			if ($e_faktur_recorded>0) {
				$no_e_faktur = $this->input->get('no_e_faktur');
			} else {
				$no_e_faktur = '-';
			}
			$jt = $this->input->get('jt');
			$tgl_jt = strtotime($tgl);
			$date = date('Y-m-j', strtotime('+'.$jt.' day', $tgl_jt));
			$sub_total = $this->input->get('total_transaksi');
			$sub_total2 = remove_separator($this->input->get('total_transaksi'));
			$diskon_rp  = ((float)$sub_total2*$potongan)/100;
			$potongan_rp = (float)$sub_total2-$diskon_rp;
			$pajak_rp = ($potongan_rp*$pajak)/100;
			$total_akhir = $this->input->get('total_akhir');
			$q = $this->db_kpp->query("SELECT *	FROM penjualan JOIN item ON penjualan.kode_item=item.kode_item WHERE penjualan.id_pesanan_penjualan='$id_c' ORDER BY id_penjualan ASC");
			$q_progpen = $this->db_kpp->query("SELECT *	FROM program_penjualan_detail
																				 JOIN item ON program_penjualan_detail.kode_item=item.kode_item
																				 JOIN gudang ON program_penjualan_detail.kode_gudang=gudang.kode_gudang
																				 WHERE program_penjualan_detail.id_program_penjualan='$id_program_penjualan'");

			$r = $q->num_rows();

			if($r>0){
				define('FPDF_FONTPATH', $this->config->item('fonts_path'));
				require(APPPATH.'plugins/fpdf.php');
			  $pdf=new FPDF();
			  $pdf->AddPage('P',array(297,210));

				if ($invoice_recorded>0) {
					$pdf->Image("assets/img/copy.png", 65, 20);
				}
				//foreach($data->result() as $t){
					$A4[0]=210;
					$A4[1]=297;
					$Q[0]=216;
					$Q[1]=279;
					$pdf->SetTitle('FAKTUR PENJUALAN ITEM');
					$pdf->SetCreator('IT Kumala');

					$h = 7;
					$pdf->SetFont('Arial','B', 14);
					$pdf->Image('assets/img/kumala.png',10,5,13.5);
					$w = array(45,22,3,65,10,3,10);
					//Cop
					$pdf->SetY(5);
					$pdf->SetX(23);
					$pdf->SetCharSpacing(0.25);
					$pdf->SetFont('Arial','B',7);
					$pdf->Cell($w[0],$h,'FAKTUR PENJUALAN ITEM',0,0,'L');
					$pdf->Cell($w[1],$h,'No. Transaksi',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($w[3],$h,$no_transaksi,0,0,'L');
					$pdf->Cell($w[4],$h,'Admin',0,0,'L');
					$pdf->Cell($w[5],$h,' : ',0,0,'L');
					$pdf->Cell($w[6],$h,$admin,0,0,'L');
					$pdf->Ln(3.25);
					$pdf->SetX(23);
					$pdf->Cell($w[0],$h,'PT. KUMALA PUTRA PRIMA',0,0,'L');
					$pdf->Cell($w[1],$h,'Tanggal',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($w[3],$h,tgl_sql_gm($tgl),0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'L');
					$pdf->Cell($w[6],$h,'',0,0,'L');
					$pdf->Ln(3.25);
					$pdf->SetX(23);
					$pdf->Cell($w[0],$h,'Jl. Kumala No.1',0,0,'L');
					$pdf->Cell($w[1],$h,'Kode Sales',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($w[3],$h,$kode_sales.' - '.$nama_sales,0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'L');
					$pdf->Cell($w[6],$h,'',0,0,'L');
					$pdf->Ln(3.25);
					$pdf->SetX(23);
					$pdf->Cell($w[0],$h,'0411 - 833133',0,0,'L');
					$pdf->Cell($w[1],$h,'Pelanggan',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($w[3],$h,$kode_pelanggan.' - '.$nama_pelanggan,0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'L');
					$pdf->Cell($w[6],$h,'',0,0,'L');
					$pdf->Ln(3.25);
					$pdf->SetX(23);
					$pdf->Cell($w[0],$h,'',0,0,'L');
					$pdf->Cell($w[1],$h,'Alamat',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($pdf->GetStringWidth($w[3]),$h,$alamat,0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'L');
					$pdf->Cell($w[6],$h,'',0,0,'L');


					$pdf->Ln(7);

					//Column widths

					$w = array(8,20,62,15,35,15,35);

					//Header
					$h = 4.1;
					$pdf->SetFont('Arial','B',6.5);
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
					$pdf->SetFont('Arial','',6.5);
					$pdf->SetFillColor(204,204,204);
    				$pdf->SetTextColor(0);
					$total_transaksi=0;
					$no=1;
					foreach($q->result() as $row)
					{
						$harga_jual= $row->harga_jual;
            $jumlah= $row->qty;
            $diskon= $row->diskon;
            $harga = $harga_jual * $jumlah;
            $persen = ($harga * $diskon)/100;
            $total = $harga-$persen;
						$pdf->Cell($w[0],$h,$no,'LR',0,'C');
						$pdf->Cell($w[1],$h,$row->kode_item,'LR',0,'C');
						$pdf->Cell($w[2],$h,$row->nama_item,'LR',0,'C');
						$pdf->Cell($w[3],$h,$row->qty,'LR',0,'C');
						$pdf->Cell($w[4],$h,'Rp. '.separator_harga2($harga_jual),'LR',0,'C');
						$pdf->Cell($w[5],$h,$row->diskon.' %','LR',0,'C');
						$pdf->Cell($w[6],$h,'Rp. '.separator_harga2($total),'LR',0,'C');
						$pdf->Ln();
						$no++;
					}
					// Closing line
					$pdf->Cell(array_sum($w),0,'','T');

					$h = 7;
					if ($id_program_penjualan>0) {
						$pdf->Ln(8);
						$pdf->SetFont('Arial','B',7);
						$pdf->Cell(0,0,'Program Penjualan : '.$program_penjualan,'L');
						$pdf->SetX(10);
						$pdf->Ln(3);

						//Header
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell($w[0],$h,'No',1,0,'C');
						$pdf->Cell($w[1],$h,'Kode Item',1,0,'C');
						$pdf->Cell($w[2],$h,'Nama Item',1,0,'C');
						$pdf->Cell($w[3],$h,'Jumlah',1,0,'C');
						$pdf->Cell($w[4],$h,'Harga',1,0,'C');
						$pdf->Cell($w[5],$h,'Diskon',1,0,'C');
						$pdf->Cell($w[6],$h,'Total',1,0,'C');
						$pdf->Ln();
						$no_progpen=1;
						$pdf->SetFont('Arial','',8);
								foreach($q_progpen->result() as $row)
								{
									$pdf->Cell($w[0],$h,$no_progpen,'LR',0,'C');
									$pdf->Cell($w[1],$h,$row->kode_item,'LR',0,'C');
									$pdf->Cell($w[2],$h,$row->nama_item,'LR',0,'C');
									$pdf->Cell($w[3],$h,$row->jumlah_bonus,'LR',0,'C');
									$pdf->Cell($w[4],$h,'0','LR',0,'C');
									$pdf->Cell($w[5],$h,'0','LR',0,'C');
									$pdf->Cell($w[6],$h,'0','LR',0,'C');
									$no_progpen++;
									$pdf->Ln();
								}
								// Closing line
								$pdf->Cell(array_sum($w),0,'','T');

					// Closing line
					$pdf->SetX(10);
					$pdf->Cell(100,$h,'Keterangan :','C');
					$pdf->Ln(3.5);
					$pdf->SetX(12);
					$pdf->Cell(100,$h,'Terbilang      : '.penyebut(remove_separator($total_akhir)).'Rupiah','C');
					$pdf->Ln(5);
					$h = 5;
					$pdf->SetFont('Arial','B',8);
					$pdf->SetX(15);
					$pdf->Cell(42,$h,'Hormat Kami',0,0,'L');
					$pdf->Cell(20,$h,'Penerima',0,0,'L');
					$pdf->SetX(20);
					$pdf->Ln(10);
					$pdf->SetX(16);
					$pdf->Cell(37,$h,'(Ricky Tjan)',0,0,'L');
					$pdf->Cell(30,$h,'(......................)',0,0,'L');

					$pdf->Ln(3);
					$pdf->SetX(10);
					$pdf->Cell(40,$h,'(Operational Manager)',0,0,'L');
					$w = array(20,3,20,18,3,33);
					$pdf->Ln(-13);
					$pdf->SetX(90);
					$pdf->SetFont('Arial','',7);
					$pdf->Cell($w[0],$h,'Potongan',0,0,'L');
					$pdf->Cell($w[1],$h,' : ',0,0,'L');
					$pdf->Cell($w[2],$h,$potongan.' %',0,0,'L');
					$pdf->SetX(140);
					$pdf->Cell($w[3],$h,'Sub Total',0,0,'L');
					$pdf->Cell($w[4],$h,' : ',0,0,'L');
					$pdf->Cell($w[5],$h,'Rp. '.$sub_total,0,0,'R');
					$pdf->Ln(3.5);
					$pdf->SetX(90);
					$pdf->Cell($w[0],$h,'Pajak',0,0,'L');
					$pdf->Cell($w[1],$h,' : ',0,0,'L');
					$pdf->Cell($w[2],$h,$pajak.' %',0,0,'L');
					$pdf->SetFont('Arial','',7.5);

					$pdf->SetX(140);
					$pdf->Cell($w[3],$h,'Potongan',0,0,'L');
					$pdf->Cell($w[4],$h,' : ',0,0,'L');
					$pdf->Cell($w[5],$h,'Rp. '.separator_harga2($diskon_rp),0,0,'R');
					$pdf->SetFont('Arial','',7);
					$pdf->Ln(3.5);
					$pdf->SetX(90);
					$pdf->Cell($w[0],$h,'No E - Faktur',0,0,'L');
					$pdf->Cell($w[1],$h,' : ',0,0,'L');
					$pdf->Cell($w[2],$h,$no_e_faktur,0,0,'L');
					$pdf->SetFont('Arial','',7.5);
					$pdf->SetX(140);
					$pdf->Cell($w[3],$h,'',0,0,'L');
					$pdf->Cell($w[4],$h,' : ',0,0,'L');
					$pdf->Cell($w[5],$h,'Rp. '.separator_harga2($potongan_rp),0,0,'R');
					$pdf->Ln(3.5);
					$pdf->SetX(90);
					$pdf->Cell($w[0],$h,'Tanggal Jt',0,0,'L');
					$pdf->Cell($w[1],$h,' : ',0,0,'L');
					$pdf->Cell($w[2],$h,tgl_sql_gm($date),0,0,'L');
					$pdf->SetFont('Arial','',7.5);
					$pdf->SetX(140);
					$pdf->Cell($w[3],$h,'Pajak',0,0,'L');
					$pdf->Cell($w[4],$h,' : ',0,0,'L');
					$pdf->Cell($w[5],$h,'Rp. '.separator_harga2($pajak_rp),0,0,'R');
					$pdf->Ln(3.5);
					$pdf->SetX(90);
					$pdf->Cell($w[0],$h,'',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'',0,0,'L');
					$pdf->SetFont('Arial','B',7.5);
					$pdf->SetX(140);
					$pdf->Cell($w[3],$h,'Total Akhir',0,0,'L');
					$pdf->Cell($w[4],$h,' : ',0,0,'L');
					$pdf->Cell($w[5],$h,'Rp. '.$total_akhir,0,0,'R');
					$pdf->Ln(3);
					$pdf->SetFont('Arial','',6);
					$pdf->Cell(100,$h,'*Pembayaran ditransfer ke rek. Mandiri (174-05-8887777-9) an. PT Kumala Putra Prima.','C');
					$pdf->Ln(2.5);
					$pdf->Cell(100,$h,'*Pembayaran dengan Cek/Bilyet Giro/Transfer dianggap SAH apabila telah diterima di rekening PT. Kumala Putra Prima.','C');
					} else {
					$pdf->SetX(10);
					$pdf->Cell(100,$h,'Keterangan :','C');
					$pdf->Ln(3.5);
					$pdf->SetX(12);
					$pdf->Cell(100,$h,'Terbilang      : '.penyebut(remove_separator($total_akhir)).'Rupiah','C');
					$pdf->Ln(5);
					$h = 5;
					$pdf->SetFont('Arial','B',8);
					$pdf->SetX(15);
					$pdf->Cell(42,$h,'Hormat Kami',0,0,'L');
					$pdf->Cell(20,$h,'Penerima',0,0,'L');
					$pdf->SetX(20);
					$pdf->Ln(10);
					$pdf->SetX(16);
					$pdf->Cell(37,$h,'(Ricky Tjan)',0,0,'L');
					$pdf->Cell(30,$h,'(......................)',0,0,'L');

					$pdf->Ln(3);
					$pdf->SetX(10);
					$pdf->Cell(40,$h,'(Operational Manager)',0,0,'L');
					$w = array(20,3,20,18,3,33);
					$pdf->Ln(-13);
					$pdf->SetX(90);
					$pdf->SetFont('Arial','',7);
					$pdf->Cell($w[0],$h,'Potongan',0,0,'L');
					$pdf->Cell($w[1],$h,' : ',0,0,'L');
					$pdf->Cell($w[2],$h,$potongan.' %',0,0,'L');
					$pdf->SetX(140);
					$pdf->Cell($w[3],$h,'Sub Total',0,0,'L');
					$pdf->Cell($w[4],$h,' : ',0,0,'L');
					$pdf->Cell($w[5],$h,'Rp. '.$sub_total,0,0,'R');
					$pdf->Ln(3.5);
					$pdf->SetX(90);
					$pdf->Cell($w[0],$h,'Pajak',0,0,'L');
					$pdf->Cell($w[1],$h,' : ',0,0,'L');
					$pdf->Cell($w[2],$h,$pajak.' %',0,0,'L');
					$pdf->SetFont('Arial','',7.5);

					$pdf->SetX(140);
					$pdf->Cell($w[3],$h,'Potongan',0,0,'L');
					$pdf->Cell($w[4],$h,' : ',0,0,'L');
					$pdf->Cell($w[5],$h,'Rp. '.separator_harga2($diskon_rp),0,0,'R');
					$pdf->SetFont('Arial','',7);
					$pdf->Ln(3.5);
					$pdf->SetX(90);
					$pdf->Cell($w[0],$h,'No E - Faktur',0,0,'L');
					$pdf->Cell($w[1],$h,' : ',0,0,'L');
					$pdf->Cell($w[2],$h,$no_e_faktur,0,0,'L');
					$pdf->SetFont('Arial','',7.5);
					$pdf->SetX(140);
					$pdf->Cell($w[3],$h,'',0,0,'L');
					$pdf->Cell($w[4],$h,' : ',0,0,'L');
					$pdf->Cell($w[5],$h,'Rp. '.separator_harga2($potongan_rp),0,0,'R');
					$pdf->Ln(3.5);
					$pdf->SetX(90);
					$pdf->Cell($w[0],$h,'Tanggal Jt',0,0,'L');
					$pdf->Cell($w[1],$h,' : ',0,0,'L');
					$pdf->Cell($w[2],$h,tgl_sql_gm($date),0,0,'L');
					$pdf->SetFont('Arial','',7.5);
					$pdf->SetX(140);
					$pdf->Cell($w[3],$h,'Pajak',0,0,'L');
					$pdf->Cell($w[4],$h,' : ',0,0,'L');
					$pdf->Cell($w[5],$h,'Rp. '.separator_harga2($pajak_rp),0,0,'R');
					$pdf->Ln(3.5);
					$pdf->SetX(90);
					$pdf->Cell($w[0],$h,'',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'',0,0,'L');
					$pdf->SetFont('Arial','B',7.5);
					$pdf->SetX(140);
					$pdf->Cell($w[3],$h,'Total Akhir',0,0,'L');
					$pdf->Cell($w[4],$h,' : ',0,0,'L');
					$pdf->Cell($w[5],$h,'Rp. '.$total_akhir,0,0,'R');
					$pdf->Ln(3);
					$pdf->SetFont('Arial','',6);
					$pdf->Cell(100,$h,'*Pembayaran ditransfer ke rek. Mandiri (174-05-8887777-9) an. PT Kumala Putra Prima.','C');
					$pdf->Ln(2.5);
					$pdf->Cell(100,$h,'*Pembayaran dengan Cek/Bilyet Giro/Transfer dianggap SAH apabila telah diterima di rekening PT. Kumala Putra Prima.','C');
				//}
			}
				//}
				$pdf->Output('Faktur Penjualan Item - '.date('d-m-Y').'.pdf','I');
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
			//$telepon = $this->model_pesanan_penjualan->getTelephonePel($kode_pelanggan);
			$nama_pelanggan = $this->input->get('nama_pelanggan');
			$tgl=$this->input->get('tanggal');
			$alamat = $this->input->get('alamat');
			$kode_sales = $this->input->get('kode_sales');
			$q = $this->db_kpp->query("SELECT *	FROM penjualan JOIN item ON penjualan.kode_item=item.kode_item WHERE penjualan.id_pesanan_penjualan='$id_c' ORDER BY id_penjualan ASC");
			$getidprogrampenjualan = $this->db_kpp->query("SELECT id_program_penjualan
																										 FROM pesanan_penjualan
																										 WHERE no_transaksi='$no_transaksi'")->row();
			$getprogrampenjualan = $this->db_kpp->query("SELECT prog_p.nama_program AS nama_program
																									 FROM pesanan_penjualan pes_p
																									 JOIN program_penjualan prog_p ON pes_p.id_program_penjualan=prog_p.id_program_penjualan
																									 WHERE no_transaksi='$no_transaksi'")->row();
			$id_program_penjualan = $getidprogrampenjualan->id_program_penjualan;
			$program_penjualan = '';
			if ($id_program_penjualan>0) {
				$program_penjualan = $getprogrampenjualan->nama_program;
			} else {
				$program_penjualan = '';
			}
			$q_progpen = $this->db_kpp->query("SELECT *	FROM program_penjualan_detail
																				 JOIN item ON program_penjualan_detail.kode_item=item.kode_item
																				 JOIN gudang ON program_penjualan_detail.kode_gudang=gudang.kode_gudang
																				 WHERE program_penjualan_detail.id_program_penjualan='$id_program_penjualan'");

			$r = $q->num_rows();

			if($r>0){
				define('FPDF_FONTPATH', $this->config->item('fonts_path'));
				require(APPPATH.'plugins/fpdf.php');
			  $pdf=new FPDF();
			  $pdf->AddPage('P',array(297,210));
					$A4[0]=210;
					$A4[1]=297;
					$Q[0]=216;
					$Q[1]=279;
					$pdf->SetTitle('SURAT JALAN');
					$pdf->SetCreator('IT Kumala');

					$h = 4.5;
					$pdf->SetFont('Arial','B', 14);
					$pdf->Image('assets/img/kumala.png',10,5,10);
					$w = array(50,70,22,7,50);
					//Cop
					$pdf->SetY(7);
					$pdf->SetX(20);
					$pdf->SetCharSpacing(0.3);
					$pdf->SetFont('Arial','B',7);
					$pdf->Cell($w[0],$h,'SURAT JALAN',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'No. Transaksi',0,0,'L');
					$pdf->Cell($w[3],$h,' : ',0,0,'L');
					$pdf->Cell($w[4],$h,$no_transaksi,0,0,'L');
					$pdf->Ln(3.25);
					$pdf->SetX(20);
					$pdf->Cell($w[0],$h,'PT.KUMALA PUTRA PRIMA',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'Tanggal',0,0,'L');
					$pdf->Cell($w[3],$h,' : ',0,0,'L');
					$pdf->Cell($w[4],$h,tgl_sql_gm($tgl),0,0,'L');
					$pdf->Ln(3.25);
					$pdf->SetX(20);
					$pdf->Cell($w[0],$h,'Jl. Kumala No.1',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'',0,0,'L');
					$pdf->Cell($w[3],$h,' ',0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Ln(3.25);
					$pdf->SetX(20);
					$pdf->Cell($w[0],$h,'0411 - 833133',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'',0,0,'L');
					$pdf->Cell($w[3],$h,'  ',0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Ln(3.25);
					$pdf->SetX(20);
					$pdf->Cell($w[0],$h,'',0,0,'L');
					$pdf->Cell($w[1],$h,'',0,0,'L');
					$pdf->Cell($w[2],$h,'',0,0,'L');
					$pdf->Cell($w[3],$h,'  ',0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');

					$pdf->Line(10, 21, 200, 21);

					$pdf->Ln(2.75);

					$pdf->SetX(10);
					$pdf->Cell(100,$h,'Kepada Yth.','C');
					$pdf->Ln(3);
					$w = array(20,3,62);
					$pdf->SetX(10);
					$pdf->SetFont('Arial','B',7);
					$pdf->Cell($w[0],$h,'Nama',0,0,'L');
					$pdf->Cell($w[1],$h,' : ',0,0,'L');
					$pdf->Cell($w[2],$h,$nama_pelanggan,0,0,'L');
					$pdf->Ln(3);
					$pdf->SetX(10);
					$pdf->Cell($w[0],$h,'Alamat',0,0,'L');
					$pdf->Cell($w[1],$h,' : ',0,0,'L');
					$pdf->Cell($w[2],$h,$alamat,0,0,'L');
					/*$pdf->SetX(10);
					$pdf->Cell($w[0],$h,'Telephone',0,0,'L');
					$pdf->Cell($w[1],$h,' : ',0,0,'L');
					$pdf->Cell($w[2],$h,$telepon,0,0,'L');
					$pdf->Ln(5);*/
					$pdf->Ln(5);

					$w = array(8,45,25);

					//Header
					$pdf->SetFont('Arial','B',6.5);
					$pdf->Cell($w[0],$h,'No',1,0,'C');
					$pdf->Cell($w[1],$h,'Nama Item',1,0,'C');
					$pdf->Cell($w[2],$h,'Jumlah',1,0,'C');
					//$pdf->Cell($w[3],$h,'Harga',1,0,'C');
					//$pdf->Cell($w[4],$h,'Diskon',1,0,'C');
					//$pdf->Cell($w[5],$h,'Total',1,0,'C');
					$pdf->Ln();

					//data
					//$pdf->SetFillColor(224,235,255);
					$pdf->SetFont('Arial','',6.5);
					$pdf->SetFillColor(204,204,204);
    			$pdf->SetTextColor(0);
					$jml=0;
					$no=1;
					foreach($q->result() as $row)
					{
						$harga_jual= $row->harga_jual;
            $jumlah= $row->qty;
            $diskon= $row->diskon;
            $harga = $harga_jual * $jumlah;
            $persen = ($harga * $diskon)/100;
            $total = $harga-$persen;
						$jml += $jumlah;
						$pdf->Cell($w[0],$h,$no,'LR',0,'C');
						$pdf->Cell($w[1],$h,$row->nama_item,'LR',0,'C');
						$pdf->Cell($w[2],$h,$row->qty,'LR',0,'C');
						//$pdf->Cell($w[3],$h,'Rp. '.separator_harga2($harga),'LR',0,'C');
						//$pdf->Cell($w[4],$h,$row->diskon.' %','LR',0,'C');
						//$pdf->Cell($w[5],$h,'Rp. '.separator_harga2($total),'LR',0,'C');
						$pdf->Ln();
						$no++;
					}
					$pdf->Cell(array_sum($w),0,'','T');
					$jml_bonus=0;
					if ($id_program_penjualan>0) {
						$pdf->Ln(8);
						$pdf->SetFont('Arial','B',7);
						$pdf->Cell(0,0,'Program Penjualan : '.$program_penjualan,'L');
						$pdf->SetX(10);
						$pdf->Ln(3);

						//Header
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell($w[0],$h,'No',1,0,'C');
						$pdf->Cell($w[1],$h,'Nama Item',1,0,'C');
						$pdf->Cell($w[2],$h,'Jumlah',1,0,'C');
						$pdf->Ln();
						$no_progpen=1;
						$pdf->SetFont('Arial','',8);
								foreach($q_progpen->result() as $row)
								{
									$jumlah_bonus=$row->jumlah_bonus;
									$jml_bonus += $jumlah_bonus;
									$pdf->Cell($w[0],$h,$no_progpen,'LR',0,'C');
									$pdf->Cell($w[1],$h,$row->nama_item,'LR',0,'C');
									$pdf->Cell($w[2],$h,$row->jumlah_bonus,'LR',0,'C');
									$no_progpen++;
									$pdf->Ln();
								}
							}

					// Closing line
					$pdf->Cell(array_sum($w),0,'','T');
					$pdf->Ln(1);
					$pdf->SetX(10);
					$pdf->SetFont('Arial','B',7);
					$pdf->Cell(20,$h,'Total Item    : ','C');
					$pdf->Cell(100,$h,(int) $jml+$jml_bonus,'C');
					$pdf->Ln(3);
					$pdf->Cell(20,$h,'Catatan    : ','C');
					$pdf->Ln(3);
					$h = 5;
					$pdf->SetFont('Arial','I',6);
					$pdf->SetX(10);
					$pdf->Cell(42,$h,'BARANG SUDAH DITERIMA DALAM KEADAAN BAIK DAN CUKUP oleh',0,0,'L');
					$pdf->Ln(2.5);
					$pdf->Cell(42,$h,'(tanda tangan dan cap(stemple) perusahaan)',0,0,'L');
					$pdf->Ln(2.5);
					$pdf->SetFont('Arial','B',7);
					$pdf->SetX(10);
					$pdf->Cell(42,$h,'Penerima / Pembeli',0,0,'L');
					$pdf->Cell(42,$h,'Bagian Pengiriman',0,0,'L');
					$pdf->Cell(20,$h,'Petugas Gudang',0,0,'L');
					$pdf->Ln(8.5);
					$pdf->SetX(13);
					$pdf->Cell(42,$h,'(......................)',0,0,'L');
					$pdf->Cell(40,$h,'(......................)',0,0,'L');
					$pdf->Cell(30,$h,'(......................)',0,0,'L');
					$w = array(100);
					$pdf->Ln(-10);
					$pdf->SetX(123);
					$pdf->SetFont('Arial','',6);
					$pdf->Cell($w[0],$h,'PERHATIAN :',0,0,'L');
					$pdf->Ln(3);
					$pdf->SetX(123);
					$pdf->Cell($w[0],$h,'1. Surat jalan ini merupakan bukti resmi penerimaan barang',0,0,'L');
					$pdf->Ln(3);
					$pdf->SetX(123);
					$pdf->Cell($w[0],$h,'2. Surat jalan ini bukan bukti penjualan',0,0,'L');
					$pdf->Ln(3);
					$pdf->SetX(123);
					$pdf->Cell($w[0],$h,'3. Surat jalan ini akan dilengkapi invoice sebagai bukti penjualan',0,0,'L');
					$pdf->SetFont('Arial','',6);
					$pdf->Ln(5);
					$pdf->Cell(100,$h,'*Pembayaran ditransfer ke rek. Mandiri (174-05-8887777-9) an. PT Kumala Putra Prima.','C');
					$pdf->Ln(2.5);
					$pdf->Cell(100,$h,'*Pembayaran dengan Cek/Bilyet Giro/Transfer dianggap SAH apabila telah diterima di rekening PT. Kumala Putra Prima.','C');
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
			$id['id_pesanan_penjualan']	= $this->uri->segment(3);

			if($this->model_pesanan_penjualan->ada($id))
			{
				$this->model_pesanan_penjualan->delete($id);
			}
			redirect('henkel_adm_pesanan_penjualan','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
