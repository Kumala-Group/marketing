<?php
$this->load->model('model_isi');
$count_pd=$this->model_isi->count_pd();
$total=$count_pd;
?>
<ul class="nav ace-nav pull-right">
    <li class="purple dropdown-modal">
                          <a data-toggle="dropdown" class="dropdown-toggle width-notif" href="#">
                              <i class="ace-icon fa fa-bell"></i>
                              <?php if($total>0) {?>
                              <span class="badge badge-important"><?php echo $total ?></span>
                              <?php } ?>
                          </a>

                          <ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
                              <li class="dropdown-header">
                                  <i class="ace-icon fa fa-exclamation-triangle"></i>
                                  Notification <?php echo $total ?>
                              </li>

                              <li class="dropdown-content">
                                  <ul class="dropdown-menu dropdown-navbar navbar-pink">
                                      <li>
                                          <a href="<?php echo base_url();?>wuling_gm_pengajuan_diskon">
                                              <div class="clearfix">
                                                  <span class="pull-left">
                                                      <i class="ace-icon fa fa-circle light-orange"></i>
                                                      <span class="content_notif">Approval Diskon</span>
                                                  </span>
                                                  <?php if($count_pd>0) {?>
                                                  <span class="pull-right badge badge-info"><?php echo '+'.$count_pd ?></span>
                                                  <?php } ?>
                                              </div>
                                          </a>
                                      </li>

                                  </ul>
                              </li>
                          </ul>
    </li>
    <li class="light-blue">
        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
        	<?php
          $this->load->model('model_admins');
          $u=$this->session->userdata('username');
          //$foto = $this->model_admins->cari_foto_username($u);
            	if(!empty($foto)){
    			?>
                	<img class="nav-user-photo" src="<?php echo base_url();?>assets/foto_karyawan/wuling/<?php echo $foto;?>" alt="<?php echo $u;?>" />
                <?php }else{ ?>
                <img class="nav-user-photo" src="<?php echo base_url();?>assets/avatars/inoout.com.jpg" alt="kmg" />
                <?php } ?>
                <span class="user-info">
                    <small>Welcome,</small>
                <?php echo $this->session->userdata('nama_lengkap');?>
            </span>

            <i class="icon-caret-down"></i>
        </a>
        <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer">
            <li>
                <a href="<?php echo base_url();?>wuling_gm_profil">
                    <i class="icon-user"></i>
                    Edit Profile
                </a>
            </li>

            <li class="divider"></li>

            <li>
                <a href="<?php echo base_url();?>hrd/logout">
                    <i class="icon-off"></i>
                    Keluar
                </a>
            </li>
        </ul>
    </li>
</ul><!--/.ace-nav-->
