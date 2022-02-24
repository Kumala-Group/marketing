<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Kumala Group | All Brands</title>
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url();?>assets/group/assets/images/favicon-32x32.png">

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>assets/group/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="<?php echo base_url();?>assets/group/assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
		<link href="<?php echo base_url();?>assets/group/assets/css/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/group/assets/css/slick.css"/>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/group/assets/css/dataTables.bootstrap4.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/group/assets/css/responsive.bootstrap4.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/group/assets/css/slick-theme.css"/>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/group/assets/css/sweetalert2.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/group/assets/css/bootstrap-select.min.css">
 
    <script src="<?php echo base_url();?>assets/group/assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/group/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/group/assets/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url();?>assets/robust/app-assets/vendors/js/highchart/code/highcharts.js"></script>
    <script src="<?php echo base_url();?>assets/robust/app-assets/vendors/js/highchart/code/modules/exporting.js"></script>
    <script src="<?php echo base_url();?>assets/robust/app-assets/vendors/js/highchart/code/modules/export-data.js"></script>
    <script src="<?php echo base_url();?>assets/robust/app-assets/vendors/js/highchart/code/modules/accessibility.js"></script>


  </head>

  <body id="page-top">
    <!-- Navigation -->

    <nav class="navbar navbar-expand-lg navbar-light fixed-nav p-0" id="mainNav">
      <?php ?>
      <?php echo $this->load->view('header');?>
    </nav>   

    <!-- Content -->
    <section class="content text-white p-0" style="background-color:#c9b75d;">
      <div class="container-fluid">
          <div class="row">
              <div class="col-lg-12 p-0 content-inner">  
                  <div class="content-wrapper">
                         <div id="loading" class="buttonload load">
                         <i class="fa fa-refresh fa-spin load-spinner"></i>
                         </div>
                         <div id="content"></div>
                  </div>
              </div>
          </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="text-center">
      <a class="" href="#" onclick="totop();">
          <i class="button-up fa fa-angle-double-up"></i>
      </a>
      <div class="info-box">
        <div class="footnote">IT Kumala Group<span class="highlight">©2017</span></div>
      </div>
    </footer>
    <script src="<?php echo base_url();?>assets/group/assets/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>assets/group/assets/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url();?>assets/group/assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url();?>assets/group/assets/js/responsive.bootstrap4.min.js"></script>
    <script src="<?php echo base_url();?>assets/group/assets/js/parsley.min.js"></script>
    <script src="<?php echo base_url();?>assets/group/assets/js/id.js"></script>
    <script src="<?php echo base_url();?>assets/group/assets/js/sweetalert2.min.js"></script>
    <script src="<?php echo base_url();?>assets/group/assets/js/custom.js"></script>
    <script>
      $('document').ready(function(){
        loadPage('g_wuling');
      });
    </script>
  </body>
</html>
