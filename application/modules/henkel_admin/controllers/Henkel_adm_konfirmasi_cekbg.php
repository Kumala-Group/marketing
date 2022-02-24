<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class henkel_adm_konfirmasi_cekbg extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_item_keluar');
	}

	public function index() {
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$d['judul']=" Data Piutang Cek / BG";
			$d['class'] = "penjualan";
			$d['data'] = $this->db_kpp->query("SELECT * FROM piutang_exception_pembayaran");
			$d['kode_item_keluar'] = $this->create_kd();
			$d['content'] = 'konfirmasi_cekbg/view';
			$this->load->view('henkel_adm_home',$d);
		}else{
			//redirect('henkel','refresh');
		}
	}

	public function simpan()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			date_default_timezone_set('Asia/Makassar');
			$id['id_item_keluar']= $this->input->post('id_item_keluar');
			$dt['kode_item_keluar'] 			= $this->input->post('kode_item_keluar');
			$dt['kode_gudang'] 			= $this->input->post('kode_gudang');
			$dt['kode_item'] 			= $this->input->post('kode_item');
			$dt['jumlah'] 			= $this->input->post('jumlah');
			$dt['kode_satuan'] 			= $this->input->post('kode_satuan');
			$dt['tanggal_item_keluar']= tgl_sql($this->input->post('tanggal_item_keluar'));
			$dt['tanggal_input']= tgl_sql($this->input->post('tanggal_input'));
			$dt['keterangan'] 			= $this->input->post('keterangan');
			$dt['admin'] = $this->session->userdata('nama_lengkap');
			if($this->model_item_keluar->ada($id)){
				$dt['w_update'] = date('Y-m-d H:i:s');
				$this->model_item_keluar->update($id, $dt);
				echo "Data Sukses diUpdate";
			}else{
				$dt['id_item_keluar'] 	= $this->model_item_keluar->cari_max_item_keluar();
				$dt['w_insert'] = date('Y-m-d H:i:s');
				$this->model_item_keluar->insert($dt);
				echo "Data Sukses diSimpan";
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

			$last_kd = $this->model_item_keluar->last_kode();
			if($last_kd > 0){
				$no_akhir = $last_kd+1;
				$kd = "OLIKEL".sprintf("%03s", $no_akhir);
				//echo json_encode($d);
			}else{
				$kd = 'OLIKEL001';
				//echo json_encode($d);
			}
			return $kd;
		}else{
			redirect('henkel','refresh');
		}

	}

	public function cari_berita_acara(){
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_item_keluar']	= $this->input->get('cari');

			if($this->model_item_keluar->ada($id)) {
				$dt = $this->model_item_keluar->get($id);

				$d['id_item_keluar']	= $dt->id_item_keluar;
				$d['kode_item_keluar']	= $dt->kode_item_keluar;
				$d['kode_gudang']	= $dt->kode_gudang;
				$data_gudang = $this->db_oli_dev->from('gudang')->where('kode_gudang',$dt->kode_gudang)->get();
				foreach($data_gudang->result() as $dt_gudang)
				{
					$d['nama_gudang'] = $dt_gudang->nama_gudang;
				}

				$data_item = $this->db_oli_dev->from('item')->where('kode_item',$dt->kode_item)->get();
				foreach($data_item->result() as $dts)
				{
					$d['nama_item'] = $dts->nama_item;
					$d['tipe'] = $dts->tipe;
				}

				$data_satuan = $this->db_oli_dev->from('satuan')->where('kode_satuan',$dt->kode_satuan)->get();
				foreach($data_satuan->result() as $dt_satuan)
				{
					$d['satuan'] = $dt_satuan->satuan;
				}
				$d['tanggal_item_keluar'] = $dt->tanggal_item_keluar;
				$d['tanggal_input'] = $dt->tanggal_input;
				$d['keterangan'] = $dt->keterangan;

				echo json_encode($d);
			} else {
				$d['id_item_keluar']		= '';
				$d['kode_item_keluar']  	= '';
				$d['kode_gudang']  	= '';
				$d['nama_gudang']  	= '';
				$d['nama_item'] = '';
				$d['tipe'] = '';
				$d['satuan'] 	= '';
				$d['tanggal_item_keluar'] 	= '';
				$d['tanggal_input'] 	= '';
				$d['keterangan'] 	= '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function cari()
	{
		$cek 	= $this->session->userdata('logged_in');
		$level 	= $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['id_item_keluar']	= $this->input->get('cari');

			if($this->model_item_keluar->ada($id)) {
				$dt = $this->model_item_keluar->get($id);
				//$dt = $this->model_prodi->get2($id);

				$d['id_item_masuk']	= $dt->id_item_masuk;
				$d['no_po'] 	= $dt->no_po;
				$data_po = $this->db_oli_dev->from('pesanan_pembelian')->where('no_po',$dt->no_po)->get();
				foreach($data_po->result() as $dt_nopo)
				{
					$d['tanggal'] = $dt_nopo->tanggal;
				}

				$id_pes = $this->model_item_masuk->getId_pesanan($dt->no_po);
				$kode_item=$this->model_item_masuk->getKd_item($id_pes);
				if(count($kode_item)>0){
					$d['kode_item']='';
					$d['kode_item'].='<option value="'.$dt->kode_item.'">'.$dt->kode_item.'</option>';
					$d['kode_item'].='<option value="">-- Pilih Kode Item --</option>';

					foreach ($kode_item as $row) {
						$d['kode_item'].='<option value="'.$row->kode_item.'">'.$row->kode_item.'</option>';
					}

				}


				$data = $this->db_oli_dev->from('item')->where('kode_item',$dt->kode_item)->get();
				foreach($data->result() as $dt)
				{
					$d['nama_item'] = $dt->nama_item;
					$d['tipe'] = $dt->tipe;
				}
				$d['total_item'] = $dt->total_item;

				echo json_encode($d);
			} else {
				$d['id_item_masuk']		= '';
				$d['no_po']  	= '';
				$d['tanggal']  	= '';
				$d['kode_item']  	= '';
				$d['nama_item'] = '';
				$d['tipe'] = '';
				$d['total_item'] 	= '';
				echo json_encode($d);
			}
		}
		else {
			redirect('henkel','refresh');
		}
	}

	public function search_no_po()
	{
		// tangkap variabel keyword dari URL
		$keyword = $this->uri->segment(3);

		// cari di database
		$data = $this->db_oli_dev->from('pesanan_pembelian')
												 ->like('no_po',$keyword)
												 ->get();
		foreach($data->result() as $dt)
		{
			$id['id_pesanan_pembelian']=$dt->id_pesanan_pembelian;
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$dt->no_po,
				'tanggal'	=>$dt->tanggal,
				'id_pesanan_pembelian'=>$dt->id_pesanan_pembelian
			);
		}
		echo json_encode($arr);
	}

	public function search_kd_item()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id	= $this->input->post('id_pes');
			$kode_item=$this->model_item_masuk->getKd_item($id);
			if(count($kode_item)>0){
				$output='';
				$output.='<option value="">-- Pilih Kode Item --</option>';
				foreach ($kode_item as $dt) {
					$output.='<option value="'.$dt->kode_item.'">'.$dt->kode_item.'</option>';
				}
				echo json_encode($output);
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function search_nm_item(){
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['kode_item']	= $this->input->post('kode_item');
			$q = $this->db_oli_dev->get_where('item',$id);
			$row = $q->num_rows();
			if($row>0){
				foreach($q->result() as $dt){
					$d['nama_item'] = $dt->nama_item;
					$d['tipe'] = $dt->tipe;
				}
				echo json_encode($d);
			}else{
					$d['nama_item'] = '';
					$d['tipe'] = '';
				echo json_encode($d);
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function search_stok_item(){
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if(!empty($cek) && $level=='henkel_admin'){
			$id['kode_item']	= $this->input->post('kode_item');
			$q = $this->db_oli_dev->get_where('stok_item',$id);
			$row = $q->num_rows();
			if($row>0){
				foreach($q->result() as $dt){
					$d['stok'] = $dt->stok;
				}
				echo json_encode($d);
			}else{
					$d['stok'] = '';
				echo json_encode($d);
			}
		}else{
			redirect('henkel','refresh');
		}
	}

	public function berita_acara()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$id_c = base64_decode($this->input->get('id_item_keluar'));
			$admin = $this->session->userdata('nama_lengkap');
			$kode_item_keluar = base64_decode($this->input->get('kode_item_keluar'));
			$tanggal = base64_decode(tgl_sql($this->input->get('tanggal_item_keluar')));
			$kode_gudang = base64_decode($this->input->get('kode_gudang'));
			$nama_gudang = $this->input->get('nama_gudang');
			$kode_item=base64_decode($this->input->get('kode_item'));
			$nama_item = $this->input->get('nama_item');
			$jumlah = $this->input->get('jumlah');
			$satuan = $this->input->get('kode_satuan');
			$keterangan = $this->input->get('keterangan');
			$q = $this->db_oli_dev->query("SELECT *
																 FROM item_keluar
																 JOIN item
																 ON item_keluar.kode_item=item.kode_item
																 JOIN gudang
																 ON item_keluar.kode_gudang=gudang.kode_gudang
																 WHERE item_keluar.id_item_keluar='$id_c'");

			$r = $q->num_rows();

			if($r>0){
				define('FPDF_FONTPATH', $this->config->item('fonts_path'));
				require(APPPATH.'plugins/fpdf.php');
				foreach($q->result() as $row){
					$nama_gudang= $row->nama_gudang;
				}

			  $pdf=new FPDF();
			  $pdf->AddPage("P","A4");
				//foreach($data->result() as $t){
					$A4[0]=210;
					$A4[1]=297;
					$Q[0]=216;
					$Q[1]=279;
					$pdf->SetTitle('BERITA ACARA ITEM KELUAR');
					$pdf->SetCreator('IT Kumala');

					$h = 7;
					$pdf->SetFont('Times','B', 14);
					$pdf->Image('assets/img/kumala.png',10,6,20);
					$w = array(50,22,3,50,10,3,10);
					//Cop
					$pdf->SetY(5);
					$pdf->SetX(33);
					$pdf->SetFont('Times','B',8);
					$pdf->Cell($w[0],$h,'BERITA ACARA ITEM KELUAR',0,0,'L');
					$pdf->SetX(125);
					$pdf->Cell($w[1],$h,'No. Transaksi',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($w[3],$h,$kode_item_keluar,0,0,'L');
					$pdf->Ln(5);
					$pdf->SetX(33);
					$pdf->Cell($w[0],$h,'PT.KUMALA MOTOR SEJAHTERA',0,0,'L');
					$pdf->SetX(125);
					$pdf->Cell($w[1],$h,'Tanggal',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($w[3],$h,$tanggal,0,0,'L');
					$pdf->Ln(5);
					$pdf->SetX(33);
					$pdf->Cell($w[0],$h,'Jl. A. Mappanyukki No.2',0,0,'L');
					$pdf->SetX(125);
					$pdf->Cell($w[1],$h,'Admin',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($w[3],$h,$admin,0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'L');
					$pdf->Cell($w[6],$h,'',0,0,'L');
					$pdf->Ln(5);
					$pdf->SetX(33);
					$pdf->Cell($w[0],$h,'0411 - 871408',0,0,'L');
					$pdf->SetX(125);
					$pdf->Cell($w[1],$h,'Kode Gudang',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($w[3],$h,$kode_gudang,0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'L');
					$pdf->Cell($w[6],$h,'',0,0,'L');
					$pdf->Ln(5);
					$pdf->SetX(33);
					$pdf->Cell($w[0],$h,'0411 - 856555',0,0,'L');
					$pdf->SetX(125);
					$pdf->Cell($w[1],$h,'Nama Gudang',0,0,'L');
					$pdf->Cell($w[2],$h,' : ',0,0,'L');
					$pdf->Cell($w[3],$h,$nama_gudang,0,0,'L');
					$pdf->Cell($w[4],$h,'',0,0,'L');
					$pdf->Cell($w[5],$h,'',0,0,'L');
					$pdf->Cell($w[6],$h,'',0,0,'L');

					$pdf->Line(10, 33, 210-10, 33);

					$pdf->Ln(15);

					/*$w = array(8,20,42,45,35,40);
					$pdf->SetFont('Times','',10);
					$pdf->Cell($w[0],'','Tabe item keluar ta');
					$pdf->Ln(5);*/

					$w = array(8,20,55,45,22,40);
					//Header
					$pdf->SetFont('Times','B',8);
					$pdf->Cell($w[0],$h,'No',1,0,'C');
					$pdf->Cell($w[1],$h,'Kode Item',1,0,'C');
					$pdf->Cell($w[2],$h,'Nama Item',1,0,'C');
					$pdf->Cell($w[3],$h,'Tipe',1,0,'C');
					$pdf->Cell($w[4],$h,'Jumlah',1,0,'C');
					$pdf->Cell($w[5],$h,'Keterangan',1,0,'C');

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
						//$harga_item= $row->harga_item;
						$jumlah= $row->jumlah;
						//$harga = $harga_item * $jumlah;
						$pdf->Cell($w[0],$h,$no,'LR',0,'C');
						$pdf->Cell($w[1],$h,$row->kode_item,'LR',0,'C');
						$pdf->Cell($w[2],$h,$row->nama_item.' %','LR',0,'C');
						$pdf->Cell($w[3],$h,$row->tipe,'LR',0,'C');
						$pdf->Cell($w[4],$h,$row->jumlah,'LR',0,'C');
						$pdf->Cell($w[5],$h,$row->keterangan,'LR',0,'C');
						$pdf->Ln();
						$no++;
					}
					// Closing line
					$pdf->Cell(array_sum($w),0,'','T');
					$pdf->Ln(1);
					$w = array(20,3,25,20,3,20);
					$pdf->Ln(10);

					$h = 5;
					$pdf->SetFont('Times','B',8);
					$pdf->SetX(10);
					$pdf->Cell(42,$h,'Menyetujui',0,0,'L');
					$pdf->SetX(40);
					$pdf->Cell(42,$h,'Authorized by',0,0,'L');
					$pdf->SetX(70);
					$pdf->Cell(42,$h,'Mengetahui',0,0,'L');
					$pdf->Ln(20);
					$pdf->SetX(10);
					$pdf->Cell(40,$h,'(.........................)',0,0,'L');
					$pdf->SetX(40);
					$pdf->Cell(40,$h,'(.........................)',0,0,'L');
					$pdf->SetX(70);
					$pdf->Cell(40,$h,'(.........................)',0,0,'L');
					$pdf->Ln(3);
					$w = array(20,3,20,18,3,38);
					$pdf->SetX(13);
					$pdf->Cell(42,$h,'Ricky Tjan',0,0,'L');
					$pdf->SetX(40);
					$pdf->Cell(42,$h,'Admin Gudang',0,0,'L');
					$pdf->SetX(73);
					$pdf->Cell(42,$h,'Admin Item',0,0,'L');
					$pdf->Output('Berita Acara Item Keluar - '.date('d-m-Y').'.pdf','I');

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
			$id['id_item_keluar']	= $this->uri->segment(3);

			if($this->model_item_keluar->ada($id))
			{
				$this->model_item_keluar->delete($id);
			}
			redirect('oli_adm_dev_item_keluar','refresh');
		}
		else
		{
			redirect('henkel','refresh');
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
