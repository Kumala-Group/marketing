<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Login Page - HENKEL</title>
		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="icon" href="<?php echo base_url();?>assets/img/favicon_kmg.png" type="image/gif">
		<!--basic styles-->
		<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" />
		<link href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-fonts.min.css" />
		<!--fonts-->

		<!--ace styles-->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace2.min.css" class="ace-main-stylesheet" id="main-ace-style" />
<!--		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-responsive.min.css" />-->
<!--		<link rel="stylesheet" href="https://drive.google.com/uc?export=download&#038;id=1rNgNQsETcCRfLY28jhEzVyfvgl1X0edp" />-->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/henkel_login.min.css" />
		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->
		<!--inline styles related to this page-->
<!--
        <script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo base_url();?>assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>
-->
		<!--<![endif]-->
		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
<!--
		<script type="text/javascript">
			$(document).ready(function(){
				$('#username').focus();
			});
			if("ontouchend" in document) document.write("<script src='<?php echo base_url();?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="https://maxcdn.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
-->
        <!--page specific plugin scripts-->
		<!--ace scripts-->
<!--		<script src="<?php echo base_url();?>assets/js/ace-elements.min.js"></script>-->
<!--		<script src="<?php echo base_url();?>assets/js/ace.min.js"></script>-->

		<!--inline scripts related to this page-->

	</head>
	<body>
		<div class="login-layout">
		<div class="main-container container-fluid">
			<div class="main-content">
				<div class="row-fluid">
					<div class="span12">
						<div class="login-container">
							<div class="row-fluid">
							</div>
							<div class="space-6"></div>
							<div class="row-fluid">
								<div class="position-relative">
									<div id="login-box" class="login-box visible widget-box no-border" style="top: 70px !important;">
										<div class="center">
											<img src="<?php echo base_url();?>assets/img/logo.png" style="max-width:89px;">
										</div>
                                        <br>
										<div class="widget-body">
											<div class="toolbar clearfix">
												<center>
														<p style="font: arial bold; padding-top: 5px; color: white;"></p>
                                                </center>
											</div>
											<div class="widget-main">
												<h4 class="header lighter bigger">
													<i class="icon-laptop red"></i>
													Halaman Login Admin
												</h4>
												<div class="space-6"></div>
												<form id="validation-form" method="post" action="<?php echo base_url();?>henkel" >
													<fieldset>
                                                       <input type="hidden" class="span12" id="fp" name="fp"/>
													<label>
															<span class="block input-icon input-icon-right">
															<input type="text" class="span12" id="username" name="username" maxlength="30" placeholder="Username" />
																<i class="icon-user"></i>
															</span>
														</label>
														<label>
															<span class="block input-icon input-icon-right">
																<input type="password" id="password" name="password" class="span12" maxlength="30" placeholder="Password" />
																<i class="icon-lock"></i>
															</span>
														</label>
														<div class="space"></div>
														<div class="clearfix">
															<button type="submit" name="submit" class="width-35 pull-right btn btn-small btn-login">
																<i class="icon-key"></i>
																Login
															</button>
														</div>
														<div class="space-4"></div>
													</fieldset>
                                                    <?php
													$valid = validation_errors();
                                                    if(!empty($valid)){
													?>
                                                    <div class="alert alert-error">
                                                    <strong>Warning ..!!! </strong>
                                                   	<?php
														echo validation_errors();
													?>
                                                    </div>
                                                    <?php } ?>
                                                    <?php
													$info = $this->session->flashdata('result_login');
													if(!empty($info)){
													?>
                                                    <div class="alert alert-error">
                                                    <strong>Warning ..!!! </strong>
                                                   	<?php
														echo validation_errors();
														echo $this->session->flashdata('result_login');
													?>
                                                    </div>
                                                    <?php } ?>
												</form>
											</div><!--/widget-main-->
											<div class="toolbar clearfix">
												<center>
													<a href="" class="forgot-password-link">
														<p></p>
													</a>
                                                    </center>
											</div>
										</div><!--/widget-body-->
									</div><!--/login-box-->
								</div><!--/position-relative-->
							</div>
						</div>
					</div><!--/.span-->
				</div><!--/.row-fluid-->
			</div>
		</div><!--/.main-container-->
		<!--basic scripts-->
		<!--[if !IE]>-->





	</div>
	</body>

</html>
