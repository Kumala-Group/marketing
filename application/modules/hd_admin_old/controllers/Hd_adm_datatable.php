<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hd_adm_datatable extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	}


	public function no_penjualan()
    {
			  $id=$this->input->get('kode_pelanggan');
        $list = $this->db_ban->query("SELECT * FROM pesanan_penjualan WHERE kode_pelanggan='$id' AND status_retur !='R'");
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
							'total'=>"Rp. ".separator_harga($dt->total_akhir)
						);

            $data= array('aaData'=>$row);
        }

        echo json_encode($data);
    }

		public function no_po()
	    {
				  $id=$this->input->get('no_po');
	        $list = $this->db_ban->query("SELECT id_pesanan_pembelian ,no_po, tanggal, kode_supplier, total_item, total_akhir, keterangan
																				FROM pesanan_pembelian");
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
								'total_akhir'=>"Rp. ".separator_harga($dt->total_akhir),
								'keterangan'=>'<center>'.$dt->keterangan.'</center>'
							);
	            $data= array('aaData'=>$row);
	        }

	        echo json_encode($data);
	    }
			public function nik_karyawan()
		    {
						$idper=$this->session->userdata('sesi_id_perusahaan');
		        $list = $this->db->query("SELECT k.nik,k.nama_karyawan,k.handphone,k.email,j.nama_jabatan
																					FROM karyawan k, jabatan j WHERE k.id_perusahaan='$idper' AND k.status_aktif='Aktif' AND k.id_jabatan=j.id_jabatan");
		        $row = array();
		        $no = 1;
		        foreach ($list->result() as $dt) {
		            $row[] = array(
									'no'=>'<center>'.$no++.'</center>',
									'nik'=>$dt->nik,
									'nama_karyawan'=>'<center>'.$dt->nama_karyawan.'</center>',
									'handphone'=>'<center>'.$dt->handphone.'</center>',
									'email'=>'<center>'.$dt->email.'</center>',
									'jabatan'=>'<center>'.$dt->nama_jabatan.'</center>'
								);
		            $data= array('aaData'=>$row);
		        }

		        echo json_encode($data);
		    }
				public function nik_karyawan_it()
			    {
			        $list = $this->db->query("SELECT nik,nama_karyawan
																						FROM karyawan WHERE id_jabatan='45'");
			        $row = array();
			        $no = 1;
			        foreach ($list->result() as $dt) {
			            $row[] = array(
										'no'=>'<center>'.$no++.'</center>',
										'nik'=>$dt->nik,
										'nama_karyawan'=>'<center>'.$dt->nama_karyawan.'</center>'
									);
			            $data= array('aaData'=>$row);
			        }

			        echo json_encode($data);
			    }

					public function karyawan()
						{
							$id_perusahaan	= $this->uri->segment(3);
								$list = $this->db->query("SELECT k.nik,k.nama_karyawan,j.nama_jabatan
																							FROM karyawan k,jabatan j WHERE id_perusahaan='$id_perusahaan' && k.id_jabatan = j.id_jabatan");
								$row = array();
								$no = 1;
								foreach ($list->result() as $dt) {
										$row[] = array(
											'no'=>'<center>'.$no++.'</center>',
											'nik'=>$dt->nik,
											'nama_karyawan'=>'<center>'.$dt->nama_karyawan.'</center>',
											'nama_jabatan'=>'<center>'.$dt->nama_jabatan.'</center>'
										);
										$data= array('aaData'=>$row);
								}

								echo json_encode($data);
						}

			public function kode_supplier()
		    {
					  $kode_supplier=$this->input->get('kode_supplier');
		        $list = $this->db_ban->query("SELECT * FROM pesanan_pembelian WHERE kode_supplier='$kode_supplier' AND status_retur !='R'");
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
									'total_akhir'=>"Rp. ".separator_harga($dt->total_akhir),
									'keterangan'=>'<center>'.$dt->keterangan.'</center>'
								);

		            $data= array('aaData'=>$row);
		        }

		        echo json_encode($data);
		    }

				public function kode_ban()
			    {
						  $id=$this->input->get('kode_gudang');
			        $list = $this->db_ban->query("SELECT so.id_stock,so.kode_ban,o.nama_ban,o.tipe,so.kode_gudang,g.nama_gudang,so.stok FROM stok_ban so INNER JOIN ban o ON so.kode_ban=o.kode_ban INNER JOIN gudang g ON so.kode_gudang=g.kode_gudang WHERE so.kode_gudang='$id'");
			        $row = array();
			        $no = 1;
			        foreach ($list->result() as $dt) {
			            $row[] = array(
										'no'=>'<center>'.$no++.'</center>',
										'kode_ban'=>$dt->kode_ban,
										'nama_ban'=>'<center>'.$dt->nama_ban.'</center>',
										'tipe'=>'<center>'.$dt->tipe.'</center>',
										'kode_gudang'=>'<center>'.$dt->kode_gudang.'</center>',
										'nama_gudang'=>'<center>'.$dt->nama_gudang.'</center>',
										'stok'=>'<center>'.$dt->stok.'</center>'
									);

			            $data= array('aaData'=>$row);
			        }

			        echo json_encode($data);
			    }

					public function search_ban()
				    {
							  //$id=$this->input->get('kode_gudang');
				        $list = $this->db_ban->query("SELECT kode_ban, nama_ban, harga_ban FROM ban");
				        $row = array();
				        $no = 1;
				        foreach ($list->result() as $dt) {
				            $row[] = array(
											'no'=>'<center>'.$no++.'</center>',
											'kode_ban'=>$dt->kode_ban,
											'nama_ban'=>'<center>'.$dt->nama_ban.'</center>',
											'harga_ban'=>'<center>Rp. '.separator_harga($dt->harga_ban).'</center>'
										);

				            $data= array('aaData'=>$row);
				        }

				        echo json_encode($data);
				    }

						public function search_gudang()
					    {
								  //$id=$this->input->get('kode_gudang');
					        $list = $this->db_ban->query("SELECT kode_gudang, nama_gudang FROM gudang");
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
					        $list = $this->db_ban->query("SELECT p.kode_pelanggan, p.nama_pelanggan, p.alamat, gp.margin_harga_ban
																								FROM pelanggan p
																								JOIN group_pelanggan  gp
																								ON p.kode_group_pelanggan=gp.kode_group_pelanggan");
					        $row = array();
					        $no = 1;
					        foreach ($list->result() as $dt) {

					            $row[] = array(
												'no'=>'<center>'.$no++.'</center>',
												'margin_harga_ban'=>$dt->margin_harga_ban,
												'kode_pelanggan'=>$dt->kode_pelanggan,
												'nama_pelanggan'=>'<center>'.$dt->nama_pelanggan.'</center>',
												'alamat'=>'<center>'.$dt->alamat.'</center>'
											);

					            $data= array('aaData'=>$row);
					        }

					        echo json_encode($data);
					    }

					public function pes_penj_per_hr()
				    {
							  $id=$this->input->get('hari');
								if($id==''){
									$list = $this->db_ban->query("SELECT pp.id_pesanan_penjualan,pp.no_transaksi,pp.tgl,pp.kode_pelanggan,p.nama_pelanggan,pp.kode_sales,pp.jt FROM pesanan_penjualan pp INNER JOIN pelanggan p ON pp.kode_pelanggan=p.kode_pelanggan ORDER BY id_pesanan_penjualan DESC");
								}else {
									$list = $this->db_ban->query("SELECT pp.id_pesanan_penjualan,pp.no_transaksi,pp.tgl,pp.kode_pelanggan,p.nama_pelanggan,pp.kode_sales,pp.jt FROM pesanan_penjualan pp INNER JOIN pelanggan p ON pp.kode_pelanggan=p.kode_pelanggan WHERE pp.tgl BETWEEN DATE_SUB(CURDATE(), INTERVAL '$id' DAY)  AND CURDATE() ORDER BY id_pesanan_penjualan DESC");
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
			                    <a class="green" href="ban_adm_pesanan_penjualan/edit/'.$dt->id_pesanan_penjualan.'">
			                        <i class="icon-pencil bigger-130"></i>
			                    </a>

			                    <a class="red" href="ban_adm_pesanan_penjualan/hapus/'.$dt->id_pesanan_penjualan.'" onClick="return confirm("Anda yakin ingin menghapus data ini?")">
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
									$list = $this->db_ban->query("SELECT no_e_faktur FROM e_faktur WHERE status='0'");
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
