<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title>
		<?php
		$jabatan = $this->session->userdata('id_jabatan');
		$divisi = $this->session->userdata('id_divisi');
		if ($jabatan == '45' || $divisi == '3') {
			echo 'ADMIN IT | HelpDesk';
		} else {
			echo $this->session->userdata('nama_lengkap') . ' | HelpDesk';
		}
		?>

	</title>
	<meta name="description" content="overview &amp; stats" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="icon" href="<?php echo base_url(); ?>assets/img/favicon_kmg.png" type="image/gif">
	<!--basic styles-->
	<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/font-awesome.min.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/icon/css/font-awesome.min.css" />


	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.autocomplete.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ui.jqgrid.min.css" />
	<!--ace styles-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace2.min.css" class="ace-main-stylesheet" id="main-ace-style" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-responsive.min.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-skins.min.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-fonts.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/custom.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/hd.css" />
	<!--<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui-1.10.3.custom.min.css" />-->
	<!--<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/chosen.css" />-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-timepicker.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.gritter.css" />
	<script src="<?php echo base_url(); ?>assets/js/jquery-1.8.2.min.js"></script>
	<!--<script src="<?php echo base_url(); ?>assets/js/jquery.mobile.custom.min.js"></script>-->
	<script src="https://maxcdn.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
	<!--<script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>-->
	<!--<script src="<?php echo base_url(); ?>assets/js/jquery.ui.touch-punch.min.js"></script>-->
	<!--<script src="<?php echo base_url(); ?>assets/js/chosen.jquery.min.js"></script>-->
	<!--<script src="<?php echo base_url(); ?>assets/js/flot/jquery.flot.resize.min.js"></script>-->
	<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-datepicker.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-timepicker.min.js"></script>
	<script src='<?php echo base_url(); ?>assets/js/jquery.autocomplete.js'></script>
	<!--<script src="<?php echo base_url(); ?>assets/js/jquery.jqGrid.min.js"></script>-->
	<!--Table-->
	<script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>


	<!--ace scripts-->
	<script type='text/javascript' src='<?php echo base_url() ?>assets/js/app.js'></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.gritter.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/ace-elements.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/ace.min.js"></script>
	<!--<script src="<?php echo base_url(); ?>assets/js/dataTables.tableTools.min.js"></script>-->
</head>

<body>
	<div class="div_pop" style="justify-content: center; display: none; position: absolute; background-color: rgba(0,0,0,.8); top: 0; left: 0; width: 100vw; height: 100%; z-index: 999999;">
		<div class="div_image">
			<a href="#" onclick="close_image()" style="text-decoration: none; color: white; position: absolute; top: 10px; right: 50px;"><h1>x</h1></a>
			<img class="image_pop" style="padding: 25px 0px;" src="" />
		</div>
	</div>
	<div id="preloader">
		<div id="loading"></div>
	</div>
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a href="#" class="brand">
					<b style="font-size:20px;">
						<!--<i class="icon-leaf"></i>-->

						<?php
						$jabatan = $this->session->userdata('id_jabatan');
						if ($jabatan == '45' || $divisi = '3') {
							echo 'HelpDesk KUMALA GROUP | IT';
						} else {
							echo 'HelpDesk KUMALA GROUP | ' . $this->session->userdata('nama_lengkap');
						}

						?>

					</b>
				</a>
				<!--/.brand-->

				<?php echo $this->load->view('hd_adm_notifikasi'); ?>
			</div>
			<!--/.container-fluid-->
		</div>
		<!--/.navbar-inner-->
	</div>

	<?php echo $this->view('ticket_menu');?>

	<div class="main-content">
		<div class="breadcrumbs" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="icon-home home-icon"></i>
					<a href="<?php echo base_url(); ?>/hd_adm_home">Home</a>
					<span class="divider">
						<i class="icon-angle-right arrow-icon"></i>
					</span>
				</li>
				<li class="active"><?php echo $judul; ?></li>
			</ul>
			<!--.breadcrumb-->
			<div class="pull-right">
				<!-- Content -->
			</div>
		</div>

		<div class="page-content" style="min-height:1500px;">
			<?php 
				echo $this->load->view($content, $data); 
			?>
		</div>
		<div class="breadcrumbs" id="breadcrumbs">
			<div class="clearfix" style="background: #e6e6e6;">
				<center>
					<span style=" color: #222;">
						<?php
						$version = $this->db_helpdesk->select('MAX(versi_update) as versi_update')
							->where('brand', 'KMG')
							->get('update_versi')->row()->versi_update;
						?>
						<p style="margin-top: 15px;"> Copyright © 2017 <strong>Kumala Group</strong>. All Rights Reserved. Update Version : <strong><?php echo $version; ?></strong></p>
					</span>
				</center>
			</div>
		</div>
		<!--/.page-content-->
	</div>
	<!--/.main-content-->

</body>

</html>