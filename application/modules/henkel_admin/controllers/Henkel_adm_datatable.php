<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Henkel_adm_datatable extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
			$this->load->model('model_pesanan_penjualan');
			$this->load->model('model_retur_penjualan');
	}


	public function no_penjualan()
    {
			  $id=$this->input->get('kode_pelanggan');
				$getnpwp = $this->db_kpp->query("SELECT npwp FROM pelanggan WHERE kode_pelanggan='$id'")->row();
				$npwp = $getnpwp->npwp;
				if ($npwp > 0) {
        $list = $this->db_kpp->query("SELECT * FROM pesanan_penjualan WHERE kode_pelanggan='$id' AND status_retur !='R'");
        $row = array();
        $no = 1;
        foreach ($list->result() as $dt) {
            $row[] = array(
							'no'=>'<center>'.$no++.'</center>',
							'no_transaksi'=>$dt->no_transaksi,
							'tanggal'=>'<center>'.tgl_sql($dt->tgl).'</center>',
							'kode_pelanggan'=>'<center>'.$dt->kode_pelanggan.'</center>',
							'kode_sales'=>'<center>'.$dt->kode_sales.'</center>',
							'total_item'=>'<center>'.$dt->total_item.'</center>',
							'total'=>"Rp. ".separator_harga2($dt->total_akhir)
						);
            $data= array('aaData'=>$row);
        	}
					echo json_encode($data);
				} else {
						echo "NPWP Kosong !";
				}
    }

		public function no_po_angkut()
	    {
				  $id=$this->input->get('no_po');
	        $list = $this->db_kpp->query("SELECT pesanan_pembelian.id_pesanan_pembelian,pesanan_pembelian.no_po, pesanan_pembelian.tanggal,pesanan_pembelian.kode_supplier,supplier.nama_supplier, pesanan_pembelian.keterangan FROM pesanan_pembelian, supplier WHERE pesanan_pembelian.kode_supplier=supplier.kode_supplier");
	        $row = array();
	        $no = 1;
	        foreach ($list->result() as $dt) {
	            $row[] = array(
								'no'=>'<center>'.$no++.'</center>',
								'no_po'=>$dt->no_po,
								'id_pesanan_pembelian'=>$dt->id_pesanan_pembelian,
								'tanggal'=>'<center>'.tgl_sql($dt->tanggal).'</center>',
								'kode_supplier'=>'<center>'.$dt->kode_supplier.'</center>',
								'nama_supplier'=>'<center>'.$dt->nama_supplier.'</center>',
								'keterangan'=>'<center>'.$dt->keterangan.'</center>'
							);
	            $data= array('aaData'=>$row);
	        }

	        echo json_encode($data);
	    }
		public function no_po()
	    {
				  $id=$this->input->get('no_po');
	        $list = $this->db_kpp->query("SELECT id_pesanan_pembelian ,no_po, tanggal, kode_supplier, total_item, total_akhir, keterangan
																				FROM pesanan_pembelian WHERE total_item!=0");
	        $row = array();
	        $no = 1;
	        foreach ($list->result() as $dt) {
	            $row[] = array(
								'no'=>'<center>'.$no++.'</center>',
								'no_po'=>$dt->no_po,
								'id_pesanan_pembelian'=>$dt->id_pesanan_pembelian,
								'tanggal'=>'<center>'.tgl_sql($dt->tanggal).'</center>',
								'kode_supplier'=>'<center>'.$dt->kode_supplier.'</center>',
								'total_item'=>'<center>'.$dt->total_item.'</center>',
								'total_akhir'=>"Rp. ".separator_harga2($dt->total_akhir),
								'keterangan'=>'<center>'.$dt->keterangan.'</center>'
							);

	            $data = array('aaData'=>$row);
	        }
					if (is_null($data)) {
						echo '0';
					} else {
						echo json_encode($data);
					}
	    }

			public function kode_supplier()
		    {
					  $kode_supplier=$this->input->get('kode_supplier');
		        $list = $this->db_kpp->query("SELECT * FROM pesanan_pembelian WHERE kode_supplier='$kode_supplier' AND status_retur !='R'");
		        $row = array();
		        $no = 1;
		        foreach ($list->result() as $dt) {
		            $row[] = array(
									'no'=>'<center>'.$no++.'</center>',
									'id_pesanan_pembelian'=>$dt->id_pesanan_pembelian,
									'no_po'=>$dt->no_po,
									'tanggal'=>'<center>'.tgl_sql($dt->tanggal).'</center>',
									'kode_supplier'=>'<center>'.$dt->kode_supplier.'</center>',
									'total_item'=>'<center>'.$dt->total_item.'</center>',
									'total_akhir'=>"Rp. ".separator_harga2($dt->total_akhir),
									'keterangan'=>'<center>'.$dt->keterangan.'</center>'
								);

		            $data= array('aaData'=>$row);
		        }

		        echo json_encode($data);
		    }

				public function search_no_invoice()
			    {
						  $kode_supplier=$this->input->get('kode_supplier');
			        $list = $this->db_kpp->query("SELECT om.*, SUM(omd.total_item_item_masuk) AS qty
																						FROM item_masuk om
																						JOIN item_masuk_detail omd ON om.id_item_masuk=omd.id_item_masuk
																						WHERE kode_supplier='$kode_supplier' AND status_retur !='r'
																						GROUP BY no_invoice");
			        $row = array();
			        $no = 1;
			        foreach ($list->result() as $dt) {
			            $row[] = array(
										'no'=>'<center>'.$no++.'</center>',
										'id_item_masuk'=>$dt->id_item_masuk,
										'no_invoice'=>$dt->no_invoice,
										'tanggal'=>'<center>'.tgl_sql($dt->tanggal_invoice).'</center>',
										'kode_supplier'=>'<center>'.$dt->kode_supplier.'</center>',
										'qty'=>'<center>'.$dt->qty.'</center>',
										'total_akhir'=>"Rp. ".separator_harga2($dt->total_akhir)
									);

			            $data= array('aaData'=>$row);
			        }

			        echo json_encode($data);
			    }

				public function kode_item()
			    {
						  $id=$this->input->get('kode_gudang');
			        $list = $this->db_kpp->query("SELECT so.id_stock,so.kode_item,o.nama_item,o.tipe,so.kode_gudang,g.nama_gudang,so.stok FROM stok_item so INNER JOIN item o ON so.kode_item=o.kode_item INNER JOIN gudang g ON so.kode_gudang=g.kode_gudang WHERE so.kode_gudang='$id'");
			        $row = array();
			        $no = 1;
			        foreach ($list->result() as $dt) {
			            $row[] = array(
										'no'=>'<center>'.$no++.'</center>',
										'kode_item'=>$dt->kode_item,
										'nama_item'=>'<center>'.$dt->nama_item.'</center>',
										'tipe'=>'<center>'.$dt->tipe.'</center>',
										'kode_gudang'=>'<center>'.$dt->kode_gudang.'</center>',
										'nama_gudang'=>'<center>'.$dt->nama_gudang.'</center>',
										'stok'=>'<center>'.$dt->stok.'</center>'
									);

			            $data= array('aaData'=>$row);
			        }

			        echo json_encode($data);
			    }

					public function search_item()
				    {
							  //$id=$this->input->get('kode_gudang');
				        $list = $this->db_kpp->query("SELECT kode_item, nama_item, harga_tebus_dpp FROM item");
				        $row = array();
				        $no = 1;
				        foreach ($list->result() as $dt) {
				            $row[] = array(
											'no'=>'<center>'.$no++.'</center>',
											'kode_item'=>$dt->kode_item,
											'nama_item'=>'<center>'.$dt->nama_item.'</center>',
											'harga_tebus_dpp'=>'<center>'.$dt->harga_tebus_dpp.'</center>'
										);

				            $data= array('aaData'=>$row);
				        }

				        echo json_encode($data);
				    }

						public function search_supplier() {
								  //$id=$this->input->get('kode_gudang');
					        $list = $this->db_kpp->query("SELECT kode_supplier, nama_supplier, alamat FROM supplier");
					        $row = array();
					        $no = 1;
					        foreach ($list->result() as $dt) {
					            $row[] = array(
												'no'=>'<center>'.$no++.'</center>',
												'kode_supplier'=>$dt->kode_supplier,
												'nama_supplier'=>'<center>'.$dt->nama_supplier.'</center>',
												'alamat'=>'<center>'.$dt->alamat.'</center>'
											);

					            $data= array('aaData'=>$row);
					        }

					        echo json_encode($data);
					    }

							public function search_sales() {
										$id_perusahaan=$this->session->userdata('id_perusahaan');
										$id_brand=$this->session->userdata('id_brand');
						        $list = $this->db->query("SELECT k.nik,k.nama_karyawan,k.id_jabatan,k.alamat,k.email FROM karyawan k INNER JOIN p_divisi pd ON k.id_divisi=pd.id_divisi WHERE k.id_perusahaan='20' AND pd.divisi='SALES' OR k.id_perusahaan='28' AND pd.divisi='SALES'
						        	UNION 
						        	SELECT db_kpp.sales.kode_sales, db_kpp.sales.nama_sales, db_kpp.sales.jabatan, db_kpp.sales.alamat, db_kpp.sales.email FROM db_kpp.sales");
						        $row = array();
						        $no = 1;
						        foreach ($list->result() as $dt) {
						            $row[] = array(
													'no'=>'<center>'.$no++.'</center>',
													'kode_sales'=>$dt->nik,
													'nama_sales'=>'<center>'.$dt->nama_karyawan.'</center>'
												);

						            $data= array('aaData'=>$row);
						        }
						        echo json_encode($data);
						    }

							public function search_laporan_pelanggan() {
									  //$id=$this->input->get('kode_gudang');
						        $list = $this->db_kpp->query("SELECT kode_pelanggan, nama_pelanggan, alamat FROM pelanggan");
						        $row = array();
						        $no = 1;
						        foreach ($list->result() as $dt) {
						            $row[] = array(
													'no'=>'<center>'.$no++.'</center>',
													'kode_pelanggan'=>$dt->kode_pelanggan,
													'nama_pelanggan'=>'<center>'.$dt->nama_pelanggan.'</center>',
													'alamat'=>'<center>'.$dt->alamat.'</center>'
												);

						            $data= array('aaData'=>$row);
						        }

						        echo json_encode($data);
						    }

						public function search_gudang()
					    {
								  //$id=$this->input->get('kode_gudang');
					        $list = $this->db_kpp->query("SELECT kode_gudang, nama_gudang FROM gudang");
					        $row = array();
					        $no = 1;
					        foreach ($list->result() as $dt) {
					            $row[] = array(
												'no'=>'<center>'.$no++.'</center>',
												'kode_gudang'=>$dt->kode_gudang,
												'nama_gudang'=>'<center>'.$dt->nama_gudang.'</center>'
											);

					            $data= array('aaData'=>$row);
					        }

					        echo json_encode($data);
					    }

						public function search_pelanggan()
					    {
								  //$id=$this->input->get('kode_gudang');
					        $list = $this->db_kpp->query("SELECT p.kode_pelanggan, p.nama_pelanggan, p.alamat, p.jt, p.limit_beli, gp.margin_min, gp.margin_max
																								FROM pelanggan p
																								LEFT JOIN group_pelanggan gp
																								ON p.kode_group_pelanggan=gp.kode_group_pelanggan");
					        $row = array();
					        $no = 1;
					        foreach ($list->result() as $dt) {

					            $row[] = array(
												'no'=>'<center>'.$no++.'</center>',
												'kode_pelanggan'=>$dt->kode_pelanggan,
												'nama_pelanggan'=>'<center>'.$dt->nama_pelanggan.'</center>',
												'alamat'=>'<center>'.$dt->alamat.'</center>',
												'margin_min'=>$dt->margin_min,
												'margin_max'=>$dt->margin_max,
												'jt'=>$dt->jt,
												'limit'=>separator_harga2($dt->limit_beli)
											);

					            $data= array('aaData'=>$row);
					        }

					        echo json_encode($data);
					    }

					    public function jenis_item()
			    {
				    $id=$this->input->get('jenis_item');
				    $jenis_item = 'ban_dalam';
			        $list = $this->db_kpp->query("SELECT kode_item, tipe, nama_item FROM item WHERE tipe='Tube' OR tipe='Flap'");
			        $row = array();
			        $no = 1;
			        foreach ($list->result() as $dt) {
			            $row[] = array(
										'no'=>'<center>'.$no++.'</center>',
										'kode_item'=>$dt->kode_item,
										'nama_item'=>'<center>'.$dt->nama_item.'</center>',
										'tipe'=>'<center>'.$dt->tipe.'</center>',
										'jenis_item'=>'<center>'.$jenis_item.'</center>'
									);

			            $data= array('aaData'=>$row);
			        }

			        echo json_encode($data);
			    }

			    public function item_master()
			    {
				    $list = $this->db_kpp->query("SELECT kode_item, nama_item, tipe FROM item");
			        $row = array();
			        $no = 1;
			        foreach ($list->result() as $dt) {
			            $row[] = array(
										'no'=>'<center>'.$no++.'</center>',
										'kode_item'=>$dt->kode_item,
										'nama_item'=>'<center>'.$dt->nama_item.'</center>',
										'tipe'=>'<center>'.$dt->tipe.'</center>'
									);

			            $data= array('aaData'=>$row);
			        }

			        echo json_encode($data);
			    }

							public function search_piutang_pelanggan()
						    {
									  //$id=$this->input->get('kode_gudang');
						        $list = $this->db_kpp->query("SELECT kode_pelanggan, nama_pelanggan, alamat
																									FROM pelanggan");
						        $row = array();
						        $no = 1;
						        foreach ($list->result() as $dt) {

						            $row[] = array(
													'no'=>'<center>'.$no++.'</center>',
													'kode_pelanggan'=>$dt->kode_pelanggan,
													'nama_pelanggan'=>'<center>'.$dt->nama_pelanggan.'</center>',
													'alamat'=>'<center>'.$dt->alamat.'</center>'
												);

						            $data= array('aaData'=>$row);
						        }

						        echo json_encode($data);
						    }

							public function search_data_transaksi()
						    {
									  //$id=$this->input->get('kode_gudang');
						        $list = $this->db_kpp->query("SELECT no_transaksi, tgl
																									FROM pesanan_penjualan
																									WHERE status='Lunas'
																								 ");

						        $row = array();
						        $no = 1;
						        foreach ($list->result() as $dt) {
											$tgl = $dt->tgl;
											$datetime1 = new DateTime($tgl);
						          $datetime2 = new DateTime(date('Y-m-d'));
						          $interval = $datetime1->diff($datetime2);
						          $umur_transaksi = $interval->format('%a Hari');
						            $row[] = array(
													'no'=>'<center>'.$no++.'</center>',
													'no_transaksi'=>$dt->no_transaksi,
													'umur_transaksi'=>'<center>'.$umur_transaksi.'</center>'
												);
						            $data= array('aaData'=>$row);
						        }

						        echo json_encode($data);
						    }

					public function pes_penj_per_hr()
				    {
							  $id=$this->input->get('hari');
								if($id==''){
									$list = $this->db_kpp->query("SELECT pp.id_pesanan_penjualan,pp.no_transaksi,pp.tgl,pp.kode_pelanggan,p.nama_pelanggan,pp.kode_sales,pp.jt FROM pesanan_penjualan pp INNER JOIN pelanggan p ON pp.kode_pelanggan=p.kode_pelanggan ORDER BY id_pesanan_penjualan DESC");
								}else {
									$list = $this->db_kpp->query("SELECT pp.id_pesanan_penjualan,pp.no_transaksi,pp.tgl,pp.kode_pelanggan,p.nama_pelanggan,pp.kode_sales,pp.jt FROM pesanan_penjualan pp INNER JOIN pelanggan p ON pp.kode_pelanggan=p.kode_pelanggan WHERE pp.tgl BETWEEN DATE_SUB(CURDATE(), INTERVAL '$id' DAY)  AND CURDATE() ORDER BY id_pesanan_penjualan DESC");
								}

				        $row = array();
				        $no = 1;
				        foreach ($list->result() as $dt) {
				            $row[] = array(
											'no'=>'<center>'.$no++.'</center>',
											'no_transaksi'=>$dt->no_transaksi,
											'tgl'=>$dt->tgl,
											'kode_pelanggan'=>'<center>'.$dt->kode_pelanggan.'</center>',
											'nama_pelanggan'=>'<center>'.$dt->nama_pelanggan.'</center>',
											'kode_sales'=>'<center>'.$dt->kode_sales.'</center>',
											'jt'=>'<center>'.$dt->jt.'</center>',
											'aksi'=>'<center><div class="hidden-phone visible-desktop action-buttons">
			                    <a class="green" href="henkel_adm_pesanan_penjualan/edit/'.$dt->id_pesanan_penjualan.'">
			                        <i class="icon-pencil bigger-130"></i>
			                    </a>

			                    <a class="red" href="henkel_adm_pesanan_penjualan/hapus/'.$dt->id_pesanan_penjualan.'" onClick="return confirm("Anda yakin ingin menghapus data ini?")">
			                        <i class="icon-trash bigger-130"></i>
			                    </a>
			                </div></center>'
										);

				            $data= array('aaData'=>$row);
				        }

				        echo json_encode($data);
				    }

						public function no_faktur()
					    {
									$list = $this->db_kpp->query("SELECT no_e_faktur FROM e_faktur WHERE status='0'");
					        $row = array();
					        $no = 1;
					        foreach ($list->result() as $dt) {
					            $row[] = array(
												'no'=>'<center>'.$no++.'</center>',
												'no_faktur'=>'<center>'.$dt->no_e_faktur.'</center>'
											);

					            $data= array('aaData'=>$row);
					        }

					        echo json_encode($data);
					    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
