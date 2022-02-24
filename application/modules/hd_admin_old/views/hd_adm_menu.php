<?php
if ($class == 'home') {
	$home = 'class="active"';
	$absensi = '';
	$fingerscan = '';
	$update_version = '';
	$master = '';
	$ticketing = '';
	$laporan = '';
	$pustaka = '';
	$n_baru = '';
	$pemberitahuan = '';
} elseif ($class == 'absensi') {
	$home = '';
	$absensi = 'class="active"';
	$fingerscan = '';
	$update_version = '';
	$master = '';
	$ticketing = '';
	$laporan = '';
	$n_baru = '';
	$pustaka = '';
	$pemberitahuan = '';
} elseif ($class == 'fingerscan') {
	$home = '';
	$absensi = '';
	$fingerscan = 'class="active"';
	$update_version = '';
	$master = '';
	$ticketing = '';
	$laporan = '';
	$pustaka = '';
	$n_baru = '';
	$pemberitahuan = '';
} elseif ($class == 'dms update') {
	$home = '';
	$absensi = '';
	$fingerscan = '';
	$update_version = 'class="active"';
	$master = '';
	$ticketing = '';
	$laporan = '';
	$pustaka = '';
	$n_baru = '';
	$pemberitahuan = '';
} elseif ($class == 'master') {
	$home = '';
	$absensi = '';
	$fingerscan = '';
	$master = 'class="active"';
	$ticketing = '';
	$update_version = '';
	$laporan = '';
	$pustaka = '';
	$n_baru = '';
	$pemberitahuan = '';
} elseif ($class == 'ticketing') {
	$home = '';
	$absensi = '';
	$fingerscan = '';
	$update_version = '';
	$master = '';
	$ticketing = 'class="active"';
	$laporan = '';
	$pustaka = '';
	$pemberitahuan = '';
	$n_baru = '';
} elseif ($class == 'laporan') {
	$home = '';
	$absensi = '';
	$update_version = '';
	$fingerscan = '';
	$master = '';
	$ticketing = '';
	$laporan = 'class="active"';
	$pustaka = '';
	$n_baru = '';
	$pemberitahuan = '';
} elseif ($class == 'pustaka') {
	$home = '';
	$absensi = '';
	$update_version = '';
	$fingerscan = '';
	$master = '';
	$ticketing = '';
	$laporan = '';
	$pustaka = 'class="active"';
	$pemberitahuan = '';
	$n_baru = '';
} elseif ($class == 'n_baru') {
	$home = '';
	$absensi = '';
	$update_version = '';
	$fingerscan = '';
	$master = '';
	$ticketing = '';
	$laporan = '';
	$n_baru = 'class="active"';
	$pustaka = '';
	$pemberitahuan = '';
} else {
	$n_baru = '';
	$home = '';
	$absensi = '';
	$update_version = '';
	$fingerscan = '';
	$master = '';
	$ticketing = '';
	$laporan = '';
	$pustaka = '';
	$pemberitahuan = 'class="active"';
}
$this->load->model('model_isi');
$n_nik = $this->session->userdata('username');
$j_tiket = $this->model_isi->n_tiket($n_nik);
$total = $j_tiket;
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
		</div>
		<!--#sidebar-shortcuts-->
		<br>
		<div align="center" style="margin-bottom: 10px;margin-top: -10px;">
			<img src="<?= base_url('assets/img/logo.png') ?>" width="70">
		</div>

		<ul class="nav nav-list">

			<?php
			$jabatan = $this->session->userdata('id_jabatan');
			if ($jabatan == '45') {


			?>
				<li <?php echo $home; ?>>
					<a href="<?php echo base_url(); ?>hd_adm_home">
						<i class="icon-home"></i>
						<span class="menu-text"> Home </span>
					</a>
				</li>
				<li <?php echo $absensi; ?>>
					<a href="<?php echo base_url(); ?>hd_adm_absensi">
						<i class="icon-calendar"></i>
						<span class="menu-text"> Status Absensi </span>
					</a>
				</li>
				<li <?php echo $n_baru; ?>>
					<a href="<?php echo base_url(); ?>hd_adm_n_baru">
						<i class="icon-user"></i>
						<span class="menu-text"> Karyawan Baru
							<?php
							echo ' (' . $this->model_isi->n_baru() . ')';
							?> </span>
					</a>
				</li>
				<li <?php echo $fingerscan; ?>>
					<a href="#" class="dropdown-toggle">
						<i class="icon-thumbs-up-alt"></i>
						<span class="menu-text"> Fingerscan</span>
						<b class="arrow icon-angle-down"></b>
					</a>
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url(); ?>hd_adm_fingerscan">
								<i class="icon-double-angle-right"></i>
								Data Finger
							</a>
						</li>
						<!-- <li>
									<a href="<?php echo base_url(); ?>hd_adm_kontrak">
										<i class="icon-double-angle-right"></i>
										Status Koneksi Finger
									</a>
								</li> -->
					</ul>
				</li>
				<li <?php echo $update_version; ?>>
					<a href="#" class="dropdown-toggle">
						<i class="icon-tags"></i>
						<span class="menu-text"> DMS Update</span>
						<b class="arrow icon-angle-down"></b>
					</a>
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url(); ?>hd_adm_update_wuling">
								<i class="icon-double-angle-right"></i>
								WULING
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>hd_adm_update_honda">
								<i class="icon-double-angle-right"></i>
								HONDA
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>hd_adm_update_hino">
								<i class="icon-double-angle-right"></i>
								HINO
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>hd_adm_update_ban">
								<i class="icon-double-angle-right"></i>
								BAN
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>hd_adm_update_kmg">
								<i class="icon-double-angle-right"></i>
								KMG
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>hd_adm_update_kbc">
								<i class="icon-double-angle-right"></i>
								KBC
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>hd_adm_update_kss">
								<i class="icon-double-angle-right"></i>
								KSS
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>hd_adm_update_oli">
								<i class="icon-double-angle-right"></i>
								OLI
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>hd_adm_update_mazda">
								<i class="icon-double-angle-right"></i>
								MAZDA
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>hd_adm_update_mercedes">
								<i class="icon-double-angle-right"></i>
								MERCEDES
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>hd_adm_update_tanamera">
								<i class="icon-double-angle-right"></i>
								TANAMERA
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>hd_adm_update_hrd">
								<i class="icon-double-angle-right"></i>
								HRD
							</a>
						</li>
					</ul>
				</li>
				<li <?php echo $master; ?>>
					<a href="#" class="dropdown-toggle">
						<i class="icon-desktop"></i>
						<span class="menu-text"> Master </span>
						<b class="arrow icon-angle-down"></b>
					</a>
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url(); ?>hd_adm_hardware">
								<i class="icon-double-angle-right"></i>
								Hardware
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>hd_adm_kontrak">
								<i class="icon-double-angle-right"></i>
								Kontrak
							</a>
						</li>
					</ul>
				</li>
				<li <?php echo $ticketing; ?>>
					<a href="#" class="dropdown-toggle">
						<i class="icon-money"></i>
						<span class="menu-text"> Ticketing </span>
						<b class="arrow icon-angle-down"></b>
					</a>
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url(); ?>hd_adm_ticketing">
								<i class="icon-double-angle-right"></i>
								Daftar Pengaduan
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>hd_adm_solving">
								<i class="icon-double-angle-right"></i>
								Daftar Solving
							</a>
						</li>
					</ul>
				</li>

				<li <?php echo $laporan; ?>>
					<a href="#" class="dropdown-toggle">
						<i class="icon-print"></i>
						<span class="menu-text"> Laporan </span>
						<b class="arrow icon-angle-down"></b>
					</a>
					<ul class="submenu">
						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-double-angle-right"></i>
								<span class="menu-text"> Hardware </span>
								<b class="arrow icon-angle-down"></b>
							</a>
							<ul class="submenu">
								<li>
									<a href="<?php echo base_url(); ?>hd_adm_lap_penjualan">
										<i class="icon-double-angle-right"></i>
										per Cabang
									</a>
								</li>
								<li>
									<a href="<?php echo base_url(); ?>hd_adm_lap_piutang">
										<i class="icon-double-angle-right"></i>
										per Karyawan
									</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#">
								<i class="icon-double-angle-right"></i>
								Kontrak
							</a>
						</li>

					</ul>
				</li>
				<li <?php echo $pustaka; ?>>
					<a href="#" class="dropdown-toggle">
						<i class="icon-file"></i>
						<span class="menu-text"> Pustaka </span>
						<b class="arrow icon-angle-down"></b>
					</a>
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url(); ?>hd_adm_jenis_hardware">
								<i class="icon-double-angle-right"></i>
								Jenis Hardware
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>hd_adm_jenis_kontrak">
								<i class="icon-double-angle-right"></i>
								Jenis Kontrak
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>biodata">
								<i class="icon-dropbox"></i>
								Biodata
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>biodata_karyawan">
								<i class="icon-dropbox"></i>
								Biodata Karyawan
							</a>
						</li>
					</ul>
				</li>

				<li <?php echo $pemberitahuan; ?>>
					<a href="#" class="dropdown-toggle">
						<i class="icon-bell"></i>
						<span class="menu-text">
							Pemberitahuan

							<?php if ($total > 0) { ?>
								<span class="pull-right badge badge-info"><?php echo '+' . $total ?></span>
							<?php } ?>
						</span>
						<b class="arrow icon-angle-down"></b>
					</a>
					<ul class="submenu">
						<li>
							<a href="<?php echo base_url(); ?>hd_adm_n_tiket">
								<i class="icon-double-angle-right"></i>
								Ticketing
								<?php if ($j_tiket > 0) { ?>
									<span class="pull-right badge badge-info"><?php echo '+' . $j_tiket ?></span>
								<?php } ?>
							</a>
						</li>

					</ul>
				</li>
			<?php
			} else {


			?>
				<li <?php echo $ticketing; ?>>
					<a href="<?php echo base_url(); ?>hd_adm_ticketing\tambah" class="dropdown-toggle">
						<i class="icon-money"></i>
						<span class="menu-text"> Laporkan Tiket </span>
					</a>
				</li>

			<?php
			}


			?>

			<li>
				<a href="<?php echo base_url(); ?>login/logout">
					<i class="icon-off"></i>
					<span class="menu-text"> Keluar </span>
				</a>
			</li>
		</ul>
		<!--/.nav-list-->

		<div class="sidebar-collapse" id="sidebar-collapse">
			<i class="icon-double-angle-left"></i>
		</div>

		<!-- <div align="center" style="margin-bottom: 10px;margin-top: -10px;">
			<b>HelpDesk | Kumala Group</b>
			Versi 1.0
		</div> -->
	</div>