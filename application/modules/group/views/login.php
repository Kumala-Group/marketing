<!DOCTYPE html>
<html lang="en" style="height:100%">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kumala Group | Portal</title>

    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url();?>assets/group/assets/images/favicon-32x32.png">
    <!-- Bootstrap -->    
    <link href="<?php echo base_url();?>assets/group/assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url();?>assets/group/assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Custom Theme Style -->
    <link href="<?php echo base_url();?>assets/group/assets/css/login.min.css" rel="stylesheet">

  </head>

  <body class="login" style="height:100%">
    <section class="login-block" style="height:100%">
    <div class="container">
    	<div class="row">
    		<div class="col-md-8">
          <div class="row">
           
            <div class="col-md-12 p-2">
              <div class="banner-text text-center">
                  <img class="group-logo" style="background-color: #FFF;" src="<?php echo base_url();?>assets/group/assets/images/Kumala Group hitam.png"></img>
                  <h2>All Brands</h2>
                  <img class="s5 background-white" src="<?php echo base_url();?>assets/group/assets/images/mazda.png"></img>
                  <img class=" " src="<?php echo base_url();?>assets/group/assets/images/honda.png"></img>
                  <img src="<?php echo base_url();?>assets/group/assets/images/wuling.png"></img>
                  <img class=" background-white" src="<?php echo base_url();?>assets/group/assets/images/mercedes-benz-logo-2011-1920x1080.png"></img>
                  <img src="<?php echo base_url();?>assets/group/assets/images/LogoHino2.png"></img>
                  <img src="<?php echo base_url();?>assets/group/assets/images/xcxc.jpeg"></img>
                  <img src="<?php echo base_url();?>assets/group/assets/images/Eni_Logo.png"></img>
                  <img class="s3 background-white" src="<?php echo base_url();?>assets/group/assets/images/ccc.png"></img>
                  <img src="<?php echo base_url();?>assets/group/assets/images/434px-Henkel-Logo.svg.png"></img>
                  <img src="<?php echo base_url();?>assets/group/assets/images/1575451251.png"></img>
                  <img src="<?php echo base_url();?>assets/group/assets/images/aasa.jpg"></img>
                  <img src="<?php echo base_url();?>assets/group/assets/images/dba270323e410ea24db6476b21552796.jpg"></img>
                  <img src="<?php echo base_url();?>assets/group/assets/images/double-coin.png"></img>
                  <img class="background-white" src="<?php echo base_url();?>assets/group/assets/images/Ranger+tire+Logo_BLUE-01.png"></img>
                  <img src="<?php echo base_url();?>assets/group/assets/images/fgfg.jpeg"></img>
                  <img class="background-white s4" src="<?php echo base_url();?>assets/group/assets/images/fuchs-energy-vector-logo-115742722034rsyjzsr2w.png"></img>
              </div>
            </div>
          </div>
    	  </div>
        <div class="col-md-4 login-sec">
           <img class="group-logo-mobile" src="<?php echo base_url();?>assets/group/assets/images/Kumala Group hitam.png"></img>
                 
    		  <h5 class="text-center">Welcome</h5>
    		  <p class="text-center">Login For All Brands</p>
    		  <?php echo form_open('group/cek_login'); ?>
            <div class="form-group">
              <label for="Username" class="">Username</label>
              <input type="text" name="username" id="username" maxlength="20" class="form-control" placeholder="Username" value="<?php echo set_value('username');?>"/> <?php echo form_error('username');?>
            </div>
            <div class="form-group">
              <label for="Password" class="">Password</label>
              <input type="password" name="password" id="password" maxlength="20"  class="form-control" placeholder="*******" value="<?php echo set_value('password');?>"/> <?php echo form_error('password');?>
            </div>
            <?php
              if ($this->session->flashdata('f_error')){
              ?>
              <div style="color:rgb(255, 104, 104);margin-top:4px;">
              <?php
                echo '*'.$this->session->flashdata('f_error');
              ?>
              </div>
            <?php } ?>
            <div class="form-group mt-2">
              <button type="submit" class="btn btn-login col-md-12">Login</button>
            </div>
          </form>
          <div class="copy-text">Copyright &copy; <a href="#">IT Kumala Group</a></div>
    		</div>
      </div>
    </div>
    <div><center></center></div>
    </section>
  </body>
</html>
