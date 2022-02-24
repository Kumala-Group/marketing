<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Marketing Department</title>
		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<!--basic styles-->
		<link rel="icon" href="<?php echo base_url();?>assets/img/favicon_kmg.png" type="image/gif">
		<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" />
		<link href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/font-awesome.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/icon/css/font-awesome.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-fonts.css" />

		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.autocomplete.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ui.jqgrid.min.css" />
		<!--ace styles-->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace2.min.css" class="ace-main-stylesheet" id="main-ace-style" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-responsive.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-skins.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/app.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/custom.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/datepicker.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.gritter.css" />
    <script src="<?php echo base_url();?>assets/js/jquery-1.8.2.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/date-time/bootstrap-datepicker.min.js"></script>
    <script src='<?php echo base_url();?>assets/js/jquery.autocomplete.js'></script>
        <!--Table-->
		<script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
		
  	
        <!--ace scripts-->
		<script type='text/javascript' src='<?php echo base_url()?>assets/js/app.js'></script>
    <script src="<?php echo base_url();?>assets/js/jquery.gritter.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/ace-elements.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/ace.min.js"></script>
	</head>
	<body>
		<div id="preloader">
		  <div id="loading"></div>
		</div>
		<div class="navbar">
			<div class="navbar-inner">
				<div class="container-fluid">
					<a href="#" class="brand">
							KUMALA MOTOR GROUP | Marketing Department
					</a>

					<?php echo $this->load->view('marketing_dept_notifikasi');?>
                </div>
			</div>
		</div>

		<?php echo $this->view('marketing_dept_menu');?>

			<div class="main-content">
				<div class="breadcrumbs" id="breadcrumbs">
					<ul class="breadcrumb">
						<li>
							<i class="icon-home home-icon"></i>
							<a href="<?php echo base_url();?>/marketing_dept_home">Home</a>
							<span class="divider">
								<i class="icon-angle-right arrow-icon"></i>
							</span>
						</li>
						<li class="active"><?php echo $judul;?></li>
					</ul><!--.breadcrumb-->
                    <div class="pull-right">
                     <!-- Content -->
                    </div>
				</div>

				<div class="page-content">
					<?php echo $this->load->view($content);?>
				</div><!--/.page-content-->
			</div><!--/.main-content-->
		</div><!--/.main-container-->
	</body>
</html>
