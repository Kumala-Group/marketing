<div class="container-fluid">
  <div class="row">
    <div class="col-12">
        <a class="navbar-brand" href="#">
        <div class="background-logo">
            <img class="logo" src="<?php echo base_url();?>assets/group/assets/images/Kumala Group hitam.png"></img>
        </div>
        <div class="header-title">
                  <img id="g_mazda" class="active" src="<?php echo base_url();?>assets/group/assets/images/mazda.png" style="width: 53px;"></img>
                  <img id="g_honda" onclick="loadPage('g_honda');" class=" " src="<?php echo base_url();?>assets/group/assets/images/honda.png" style="width: 73px;"></img>
                  <img id="g_wuling" onclick="loadPage('g_wuling');" src="<?php echo base_url();?>assets/group/assets/images/wuling.png" style="width: 81px;"></img>
                  <img id="g_mercedes" onclick="loadPage('g_mercedes');" class=" background-white" src="<?php echo base_url();?>assets/group/assets/images/mercedes-benz-logo-2011-1920x1080.png"></img>
                  <img id="g_hino" onclick="loadPage('g_hino');" src="<?php echo base_url();?>assets/group/assets/images/LogoHino2.png" style="width: 81px;"></img>
        </div>
        </a>
       
    </div>
    <!-- <div class="col-6">
      <div class="user">
            <div class="user-description">
              <h5>Administrator</h5>
              <h3>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span id="user_name_head"><?php echo $nama;?></span></i></a>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="#" onclick="loadPage('a_profil');"><i class="fa fa-user-circle mr-1"></i>  Edit Profile</a>
                  <a class="dropdown-item" href="#"><i class="fa fa-info-circle mr-1"></i>  Help</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="<?php echo base_url();?>login/logout"> <i class="fa fa-power-off mr-1"></i>  Log Out</a>
                </div>
              </h3>
            </div>
            <div class="user-img">
              <img src="<?php echo $url_image;?>" id="img_header">  
            </div>        
      </div>
    </div>     -->
    
  </div>
  <div class="user">
            <div class="user-description">
              <h5>Owner</h5>
              <h3>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span id="user_name_head"><?php echo $nama;?></span></i></a>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="#" onclick="loadPage('g_profil');"><i class="fa fa-user-circle mr-1"></i>  Edit Profile</a>
                  <a class="dropdown-item" href="#"><i class="fa fa-info-circle mr-1"></i>  Help</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="<?php echo base_url();?>group/logout"> <i class="fa fa-power-off mr-1"></i>  Log Out</a>
                </div>
              </h3>
            </div>
            <div class="user-img">
              <img src="<?php echo $url_image;?>" id="img_header">  
            </div>        
      </div>
</div>
