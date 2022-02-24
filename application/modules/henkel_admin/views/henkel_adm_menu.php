<?php
if($class=='home'){
	$home = 'class="active"';
	$master ='';
	$akuntansi = '';
	$pembelian = '';
	$penjualan = '';
  $persediaan = '';
  $laporan = '';
	$pustaka = '';
	$pemberitahuan = '';
}elseif($class=='master'){
	$home = '';
	$master ='class="active"';
	$akuntansi = '';
	$pembelian = '';
	$penjualan = '';
  $persediaan = '';
  $laporan = '';
	$pustaka = '';
	$pemberitahuan = '';
}elseif($class=='akuntansi'){
	$home = '';
	$master ='';
	$akuntansi = 'class="active"';
	$pembelian = '';
	$penjualan = '';
  $persediaan = '';
  $laporan = '';
	$pustaka = '';
	$pemberitahuan = '';
}elseif($class=='pembelian'){
	$home = '';
	$master ='';
	$akuntansi = '';
	$pembelian = 'class="active"';
	$penjualan = '';
  $persediaan = '';
  $laporan = '';
	$pustaka = '';
	$pemberitahuan = '';
}elseif($class=='penjualan'){
	$home = '';
	$master ='';
	$akuntansi = '';
	$pembelian = '';
	$penjualan = 'class="active"';
  $persediaan = '';
  $laporan = '';
	$pustaka = '';
	$pemberitahuan = '';
}elseif($class=='persediaan'){
  $home = '';
  $master ='';
  $akuntansi = '';
  $laporan = '';
	$pembelian = '';
  $penjualan = '';
  $persediaan = 'class="active"';
  $laporan = '';
	$pustaka = '';
	$pemberitahuan = '';
}elseif($class=='laporan'){
  $home = '';
  $master ='';
  $akuntansi = '';
  $pembelian = '';
  $penjualan = '';
  $persediaan = '';
  $laporan = 'class="active"';
	$pustaka = '';
	$pemberitahuan = '';
}elseif($class=='pustaka') {
	$home = '';
  $master ='';
  $akuntansi = '';
  $pembelian = '';
  $penjualan = '';
  $persediaan = '';
  $laporan = '';
	$pustaka = 'class="active"';
	$pemberitahuan = '';
}else {
	$home = '';
  $master ='';
  $akuntansi = '';
  $pembelian = '';
  $penjualan = '';
  $persediaan = '';
  $laporan = '';
	$pustaka = '';
	$pemberitahuan = 'class="active"';
}

$this->load->model('model_isi');
$n_stok_kritis= $this->model_isi->n_stok_kritis();
$n_jt= $this->model_isi->n_jt();
$n_jt_inv_supp= $this->model_isi->n_jt_inv_supp();
$total= $n_stok_kritis+$n_jt+$n_jt_inv_supp;
?>
<div class="main-container container-fluid">
<a class="menu-toggler" id="menu-toggler" href="#">
    <span class="menu-text"></span>
</a>
<div class="sidebar" id="sidebar">
    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
        <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
            <span class="btn btn-success"></span>
            <span class="btn btn-info"></span>
            <span class="btn btn-warning"></span>
            <span class="btn btn-danger"></span>
        </div>
    </div><!--#sidebar-shortcuts-->
	<br>
    <div align="center" style="margin-bottom: 10px;margin-top: -10px;">
    <img src="<?php echo base_url();?>/assets/img/logo.png" width="80">
    </div>

    <ul class="nav nav-list">
        <li <?php echo $home;?> >
            <a href="<?php echo base_url();?>henkel_adm_home">
                <i class="icon-home"></i>
                <span class="menu-text"> Home </span>
            </a>
        </li>

        <li <?php echo $master;?> >
            <a href="#" class="dropdown-toggle">
                <i class="icon-desktop"></i>
                <span class="menu-text"> Master </span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                <li>
                    <a href="<?php echo base_url();?>henkel_adm">
                        <i class="icon-double-angle-right"></i>
                        Item
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>henkel_adm_supplier">
                        <i class="icon-double-angle-right"></i>
                        Supplier
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>henkel_adm_pelanggan">
                        <i class="icon-double-angle-right"></i>
                        Pelanggan
                    </a>
                </li>
				<li>
                    <a href="<?php echo base_url();?>henkel_adm_sales">
                        <i class="icon-double-angle-right"></i>
                        Sales
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>henkel_adm_satuan">
                        <i class="icon-double-angle-right"></i>
                        Satuan
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>henkel_adm_jenis_pembayaran">
                        <i class="icon-double-angle-right"></i>
                        Jenis Pembayaran
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>henkel_adm_bank">
                        <i class="icon-double-angle-right"></i>
                        Bank
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>henkel_adm_gudang">
                        <i class="icon-double-angle-right"></i>
                        Gudang
                    </a>
                </li>
								<li>
                    <a href="<?php echo base_url();?>henkel_adm_e_faktur">
                        <i class="icon-double-angle-right"></i>
                        E-Faktur
                    </a>
                </li>
            </ul>
        </li>

        <li <?php echo $pembelian;?>>
            <a href="#" class="dropdown-toggle">
                <i class="icon-shopping-cart"></i>
                <span class="menu-text"> Pembelian </span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                 <li>
                    <a href="<?php echo base_url();?>henkel_adm_pesanan_pembelian/tambah">
                        <i class="icon-double-angle-right"></i>
                        Pesanan Pembelian
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>henkel_adm_pesanan_pembelian">
                        <i class="icon-double-angle-right"></i>
                        Daftar Pesanan Pembelian
                    </a>
                </li>
								<li>
                    <a href="<?php echo base_url();?>henkel_adm_invoice_supplier">
                        <i class="icon-double-angle-right"></i>
                        Daftar Pembelian
                    </a>
                </li>
								<li>
                    <a href="<?php echo base_url();?>henkel_adm_pembayaran_hutang">
                        <i class="icon-double-angle-right"></i>
                        Pembayaran Hutang
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>henkel_adm_retur_pembelian">
                        <i class="icon-double-angle-right"></i>
                        Retur Pembelian
                    </a>
                </li>
							 <li>
									<a href="<?php echo base_url();?>henkel_adm_pesanan_pengiriman">
											<i class="icon-double-angle-right"></i>
											Pengiriman
									</a>
							</li>
            </ul>
        </li>

        <li <?php echo $penjualan;?>>
            <a href="#" class="dropdown-toggle">
                <i class="icon-bar-chart"></i>
                <span class="menu-text">
                    Penjualan
                </span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
               	 <!--<li>
                    <a href="<?php echo base_url();?>henkel_adm_pesanan_penjualan/tambah">
                        <i class="icon-double-angle-right"></i>
                        Pesanan Penjualan
                    </a>
                </li>-->
                <li>
                    <a href="<?php echo base_url();?>henkel_adm_pesanan_penjualan">
                        <i class="icon-double-angle-right"></i>
                        Daftar Penjualan
                    </a>
                </li>
				<li>
                    <a href="<?php echo base_url();?>henkel_adm_pembayaran_piutang">
                        <i class="icon-double-angle-right"></i>
                        Pembayaran Piutang
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>henkel_adm_konfirmasi_cekbg">
                        <i class="icon-double-angle-right"></i>
                        Konfirmasi Cek / BG
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>henkel_adm_retur_penjualan">
                        <i class="icon-double-angle-right"></i>
                        Retur Penjualan
                    </a>
                </li>
								<li>
								<a href="#" class="dropdown-toggle">
										<i class="icon-double-angle-right"></i>
										<span class="menu-text"> Komisi </span>
										<b class="arrow icon-angle-down"></b>
								</a>

								<ul class="submenu">
									<li>
										 <a href="<?php echo base_url();?>henkel_adm_target_penjualan">
												 <i class="icon-double-angle-right"></i>
												 Target Penjualan
										 </a>
								 </li>
									<li>
										 <a href="<?php echo base_url();?>henkel_adm_hitungan_komisi">
												 <i class="icon-double-angle-right"></i>
												 Hitungan Komisi
										 </a>
								 </li>
								 <li>
											<a href="<?php echo base_url();?>henkel_adm_penerima_komisi">
													<i class="icon-double-angle-right"></i>
													Penerima Komisi
											</a>
								 </li>
								 <li>
										  <a href="#" class="dropdown-toggle">
												  <i class="icon-double-angle-right"></i>
												  <span class="menu-text"> Rekap Komisi </span>
												  <b class="arrow icon-angle-down"></b>
										  </a>
											<ul class="submenu">
												<li>
													 <a href="<?php echo base_url();?>henkel_adm_lap_penerima_komisi_sales">
															 <i class="icon-double-angle-right"></i>
															 Sales/SPV/OM
													 </a>
											 </li>
												<li>
													 <a href="<?php echo base_url();?>henkel_adm_lap_penerima_komisi_admin">
															 <i class="icon-double-angle-right"></i>
															 Admin/Gudang
													 </a>
											 </li>
											 <li>
														<a href="<?php echo base_url();?>henkel_adm_lap_penerima_komisi_kolektor">
																<i class="icon-double-angle-right"></i>
																Kolektor
														</a>
											 </li>
											</ul>
								 </li>
								</ul>
								</li>
            </ul>
        </li>
        <li <?php echo $persediaan;?>>
            <a href="#" class="dropdown-toggle">
                <i class="icon-inbox"></i>
                <span class="menu-text">
                    Persediaan
                </span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                 <li>
                    <a href="<?php echo base_url();?>henkel_adm_item_masuk_non">
                        <i class="icon-double-angle-right"></i>
                        Item Masuk
                    </a>
                </li>
                <li>
										<a href="<?php echo base_url();?>henkel_adm_item_keluar">
                        <i class="icon-double-angle-right"></i>
                        Item Keluar
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>henkel_adm_stok_opname">
                        <i class="icon-double-angle-right"></i>
                        Stok Opname
                    </a>
                </li>
								<li>
                    <a href="<?php echo base_url();?>henkel_adm_mutasi_item">
                        <i class="icon-double-angle-right"></i>
                        Mutasi Item
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>henkel_adm_stok_awal_item">
                        <i class="icon-double-angle-right"></i>
                        Stok Awal Item
                    </a>
                </li>
								<li>
									 <a href="<?php echo base_url();?>henkel_adm_stok_item">
											 <i class="icon-double-angle-right"></i>
											 Stok Item
									 </a>
							 </li>
            </ul>
        </li>

				<li <?php echo $laporan;?>>
            <a href="#" class="dropdown-toggle">
                <i class="icon-print"></i>
                <span class="menu-text"> Laporan </span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
								<li>
										<a href="#" class="dropdown-toggle">
												<i class="icon-double-angle-right"></i>
												<span class="menu-text"> Laporan Pembelian </span>
												<b class="arrow icon-angle-down"></b>
										</a>
										<ul class="submenu">
 											<li>
 												 <a href="<?php echo base_url();?>henkel_adm_lap_pembelian">
 														 <i class="icon-double-angle-right"></i>
 														 Laporan Pembelian
 												 </a>
 										 </li>
				             <li>
				                  <a href="<?php echo base_url();?>henkel_adm_lap_pembelian_detail">
				                      <i class="icon-double-angle-right"></i>
				                        Laporan Pembelian Detail
				                   </a>
				             </li>
										 <li>
				                  <a href="<?php echo base_url();?>henkel_adm_lap_pembelian_item">
				                      <i class="icon-double-angle-right"></i>
				                        Laporan Pembelian Per Item
				                  </a>
				              </li>
											<li>
 				                  <a href="<?php echo base_url();?>henkel_adm_lap_pembelian_supplier">
 				                      <i class="icon-double-angle-right"></i>
 				                        Laporan Pembelian Per Supplier
 				                  </a>
 				              </li>
				            </ul>
				        </li>
								<li>
										<a href="#" class="dropdown-toggle">
												<i class="icon-double-angle-right"></i>
												<span class="menu-text"> Laporan Penjualan </span>
												<b class="arrow icon-angle-down"></b>
										</a>
										<ul class="submenu">
										 <li>
												 <a href="<?php echo base_url();?>henkel_adm_lap_penjualan">
														 <i class="icon-double-angle-right"></i>
														 Laporan Penjualan
												 </a>
										 </li>
										 <li>
												<a href="<?php echo base_url();?>henkel_adm_lap_penjualan_detail">
														<i class="icon-double-angle-right"></i>
														Laporan Penjualan Detail
												</a>
										 </li>
										 <li>
												 <a href="<?php echo base_url();?>henkel_adm_lap_penjualan_item">
														 <i class="icon-double-angle-right"></i>
														 Laporan Penjualan Per Item
												 </a>
										 </li>
										 <li>
												<a href="<?php echo base_url();?>henkel_adm_lap_penjualan_pelanggan">
														<i class="icon-double-angle-right"></i>
														Laporan Penjualan Per Pelanggan
												</a>
										</li>
										<li>
											 <a href="<?php echo base_url();?>henkel_adm_lap_penjualan_sales">
													 <i class="icon-double-angle-right"></i>
													 Laporan Penjualan Per Sales
											 </a>
									  </li>
				            </ul>
				        </li>
								<li>
										<a href="#" class="dropdown-toggle">
												<i class="icon-double-angle-right"></i>
												<span class="menu-text"> Laporan Hutang </span>
												<b class="arrow icon-angle-down"></b>
										</a>
										<ul class="submenu">
											<li>
												 <a href="<?php echo base_url();?>henkel_adm_lap_hutang">
														 <i class="icon-double-angle-right"></i>
														 Laporan Hutang Beredar
												 </a>
										 </li>
				             <li>
				                  <a href="<?php echo base_url();?>henkel_adm_lap_umur_hutang">
				                     <i class="icon-double-angle-right"></i>
				                        Laporan Umur Hutang
				                  </a>
				             </li>
				            </ul>
				        </li>
								<li>
										<a href="#" class="dropdown-toggle">
												<i class="icon-double-angle-right"></i>
												<span class="menu-text"> Laporan Piutang </span>
												<b class="arrow icon-angle-down"></b>
										</a>
										<ul class="submenu">
											<li>
												 <a href="<?php echo base_url();?>henkel_adm_lap_piutang">
														 <i class="icon-double-angle-right"></i>
														 Laporan Piutang Beredar
												 </a>
										 </li>
				             <li>
				                    <a href="<?php echo base_url();?>henkel_adm_lap_umur_piutang">
				                        <i class="icon-double-angle-right"></i>
				                        Laporan Umur Piutang
				                    </a>
				             </li>
				            </ul>
				        </li>
								<li>
										<a href="#" class="dropdown-toggle">
												<i class="icon-double-angle-right"></i>
												<span class="menu-text"> Laporan Akuntansi </span>
												<b class="arrow icon-angle-down"></b>
										</a>
										<ul class="submenu">
											<li>
												<a href="#" class="dropdown-toggle">
													 <i class="icon-double-angle-right"></i>
													 <span class="menu-text"> Laporan Kas </span>
													 <b class="arrow icon-angle-down"></b>
											 </a>
											 <ul class="submenu">
												 		<li>
															<a href="#" onclick="javascript:alert('Maaf, Fitur Sedang Dikerjakan')">
					                        <i class="icon-double-angle-right"></i>
					                        Laporan Kas Masuk
					                    </a>
														</li>
														<li>
															<a href="#" onclick="javascript:alert('Maaf, Fitur Sedang Dikerjakan')">
					                        <i class="icon-double-angle-right"></i>
					                        Laporan Kas Keluar
					                    </a>
														</li>
											 </ul>
										 </li>
 											<li>
 												<a href="#" class="dropdown-toggle">
 													 <i class="icon-double-angle-right"></i>
 													 <span class="menu-text"> Laporan Keuangan </span>
 													 <b class="arrow icon-angle-down"></b>
 											 </a>
 											 <ul class="submenu">
 												 		<li>
 															<a href="#" onclick="javascript:alert('Maaf, Fitur Sedang Dikerjakan')">
 					                        <i class="icon-double-angle-right"></i>
 					                        Laporan Neraca
 					                    </a>
 														</li>
 														<li>
 															<a href="#" onclick="javascript:alert('Maaf, Fitur Sedang Dikerjakan')">
 					                        <i class="icon-double-angle-right"></i>
 					                        Laporan Laba Rugi
 					                    </a>
 														</li>
 											 </ul>
 										 </li>

 											<li>
 												<a href="#" onclick="javascript:alert('Maaf, Fitur Sedang Dikerjakan')">
 													 <i class="icon-double-angle-right"></i>
 													 <span class="menu-text"> Laporan Buku Besar </span>
 											 </a>
 										 </li>
				            </ul>
				        </li>

            </ul>
        </li>

        <li <?php echo $akuntansi;?>>
            <a href="#" class="dropdown-toggle">
                <i class="icon-money"></i>
                <span class="menu-text"> Akuntansi </span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
								<li>
										<a href="#" class="dropdown-toggle">
												<i class="icon-double-angle-right"></i>
												<span class="menu-text"> Daftar Perkiraan </span>
												<b class="arrow icon-angle-down"></b>
										</a>
										<ul class="submenu">
				               	 <li>
				                    <a href="<?php echo base_url();?>henkel_adm_master_akun">
				                        <i class="icon-double-angle-right"></i>
				                        Master Akun
				                    </a>
				                </li>
				                <li>
				                    <a href="<?php echo base_url();?>henkel_adm_p_akun_group">
				                        <i class="icon-double-angle-right"></i>
				                        Jenis Akun
				                    </a>
				                </li>
				            </ul>
				        </li>
								<li>
										<a href="#" class="dropdown-toggle">
												<i class="icon-double-angle-right"></i>
												<span class="menu-text">Kas</span>
												<b class="arrow icon-angle-down"></b>
										</a>
										<ul class="submenu">
											<li>
													<a href="#" onclick="javascript:alert('Maaf, Fitur Sedang Dikerjakan')">
															<i class="icon-double-angle-right"></i>
															Kas Keluar
													</a>
											</li>
											<li>
													<a href="#" onclick="javascript:alert('Maaf, Fitur Sedang Dikerjakan')">
															<i class="icon-double-angle-right"></i>
															Kas Keluar (untuk dana)
													</a>
											</li>
											<li>
													<a href="#" onclick="javascript:alert('Maaf, Fitur Sedang Dikerjakan')">
															<i class="icon-double-angle-right"></i>
															Kas Masuk
													</a>
											</li>
											<li>
													<a href="#" onclick="javascript:alert('Maaf, Fitur Sedang Dikerjakan')">
															<i class="icon-double-angle-right"></i>
															Kas Masuk (dari dana)
													</a>
											</li>
											<li>
													<a href="#" onclick="javascript:alert('Maaf, Fitur Sedang Dikerjakan')">
															<i class="icon-double-angle-right"></i>
															Kas Transfer
													</a>
											</li>
				            </ul>
				        </li>

                <li>
                    <a href="#" onclick="javascript:alert('Maaf, Fitur Sedang Dikerjakan')">
                        <i class="icon-double-angle-right"></i>
                        Daftar Jurnal
                    </a>
                </li>
								<li>
										<a href="#" class="dropdown-toggle">
												<i class="icon-double-angle-right"></i>
												<span class="menu-text"> Pengaturan </span>
												<b class="arrow icon-angle-down"></b>
										</a>
										<ul class="submenu">
											<li>
													<!--<a href="<?php echo base_url();?>henkel_adm_saldo_awal_hutang">-->
													<a href="#" onclick="javascript:alert('Maaf, Fitur Sedang Dikerjakan')">
															<i class="icon-double-angle-right"></i>
															Saldo Awal Hutang (supplier)
													</a>
											</li>
											<li>
													<a href="#" onclick="javascript:alert('Maaf, Fitur Sedang Dikerjakan')">
															<i class="icon-double-angle-right"></i>
															Saldo Awal Hutang (pelanggan)
													</a>
											</li>
											<li>
													<!--<a href="<?php echo base_url();?>henkel_adm_saldo_awal_perkiraan">-->
													<a href="#" onclick="javascript:alert('Maaf, Fitur Sedang Dikerjakan')">
															<i class="icon-double-angle-right"></i>
															Saldo Awal Perkiraan
													</a>
											</li>
											<li>
												<a href="#" class="dropdown-toggle">
														<i class="icon-double-angle-right"></i>
														<span class="menu-text"> Setting Akun </span>
														<b class="arrow icon-angle-down"></b>
												</a>
													<ul class="submenu">
														<li>
																<!--<a href="<?php echo base_url();?>henkel_adm_setakun_datahenkel">-->
																<a href="#" onclick="javascript:alert('Maaf, Fitur Sedang Dikerjakan')">
																		<i class="icon-double-angle-right"></i>
																		Data Item
																</a>
														</li>
														<li>
																<!--<a href="<?php echo base_url();?>henkel_adm_setakun_pembelian">-->
																<a href="#" onclick="javascript:alert('Maaf, Fitur Sedang Dikerjakan')">
																		<i class="icon-double-angle-right"></i>
																		Pembelian
																</a>
														</li>
														<li>
																<!--<a href="<?php echo base_url();?>henkel_adm_setakun_penjualan">-->
																<a href="#" onclick="javascript:alert('Maaf, Fitur Sedang Dikerjakan')">
																		<i class="icon-double-angle-right"></i>
																		Penjualan
																</a>
														</li>
														<li>
																<!--<a href="<?php echo base_url();?>henkel_adm_setakun_hutangpiutang">-->
																<a href="#" onclick="javascript:alert('Maaf, Fitur Sedang Dikerjakan')">
																		<i class="icon-double-angle-right"></i>
																		Hutang Piutang
																</a>
														</li>
													</ul>
											</li>
				            </ul>
				        </li>

            </ul>
        </li>
				<li <?php echo $pustaka;?>>
            <a href="#" class="dropdown-toggle">
                <i class="icon-file"></i>
                <span class="menu-text"> Pustaka </span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                <li>
                    <a href="<?php echo base_url();?>henkel_adm_group_pelanggan">
                        <i class="icon-double-angle-right"></i>
                        Group Pelanggan
                    </a>
                </li>
								<li>
									 <a href="<?php echo base_url();?>henkel_adm_program_penjualan">
											 <i class="icon-double-angle-right"></i>
											 Program Penjualan
									 </a>
							  </li>
								<li>
									 <a href="<?php echo base_url();?>henkel_adm_jabatan_karyawan">
											 <i class="icon-double-angle-right"></i>
											 Jabatan Karyawan
									 </a>
							  </li>
            </ul>
        </li>

				<li <?php echo $pemberitahuan;?>>
						<a href="#" class="dropdown-toggle">
								<i class="icon-calendar"></i>
								<span class="menu-text">
										<?php if($total>0){echo $total.' ';} ?>Pemberitahuan
								</span>
								<b class="arrow icon-angle-down"></b>
						</a>
            <ul class="submenu">
									<li>
										 <a href="<?php echo base_url();?>henkel_adm_n_stok_kritis">
												 <i class="icon-double-angle-right"></i>
												 Stok Kritis
												 <?php if($n_stok_kritis>0) {?>
												 <span class="pull-right badge badge-info"><?php echo '+'.$n_stok_kritis ?></span>
												 <?php } ?>
										 </a>
								 </li>
								 <li>
										<a href="<?php echo base_url();?>henkel_adm_n_jt">
												<i class="icon-double-angle-right"></i>
												Jatuh Tempo Penjualan
												<?php if($n_jt>0) {?>
												<span class="pull-right badge badge-info"><?php echo '+'.$n_jt ?></span>
												<?php } ?>
										</a>
								</li>
								<li>
									 <a href="<?php echo base_url();?>henkel_adm_n_jt_inv_supp">
											 <i class="icon-double-angle-right"></i>
											 Jatuh Tempo Pembelian
											 <?php if($n_jt_inv_supp>0) {?>
											 <span class="pull-right badge badge-info"><?php echo '+'.$n_jt_inv_supp ?></span>
											 <?php } ?>
									 </a>
							 </li>
            </ul>
        </li>

        <li>
            <a href="<?php echo base_url();?>login/logout">
                <i class="icon-off"></i>
                <span class="menu-text"> Keluar </span>
            </a>
        </li>
    </ul><!--/.nav-list-->

    <div class="sidebar-collapse" id="sidebar-collapse">
        <i class="icon-double-angle-left"></i>
    </div>
		<br>
	    <div align="center" style="margin-bottom: 10px;margin-top: -10px;">
				<b>WERP | KSA</b>
				Versi 0.8
	    </div>
</div>
