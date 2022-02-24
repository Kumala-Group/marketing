<?php
$this->load->model('model_isi');
$n_stok_kritis= $this->model_isi->n_stok_kritis();
$n_jt= $this->model_isi->n_jt();
$n_jt_inv_supp= $this->model_isi->n_jt_inv_supp();
$total= $n_stok_kritis+$n_jt+$n_jt_inv_supp;
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
                                  Pemberitahuan <?php echo $total ?>
                              </li>

                              <li class="dropdown-content">
                                  <ul class="dropdown-menu dropdown-navbar navbar-pink">
                                      <li>
                                          <a href="<?php echo base_url();?>henkel_adm_n_stok_kritis">
                                              <div class="clearfix">
                                                  <span class="pull-left">
                                                      <i class="ace-icon fa fa-circle light-orange"></i>
                                                      <span class="content_notif">Stok Kritis</span>
                                                  </span>
                                                  <?php if($n_stok_kritis>0) {?>
                                                  <span class="pull-right badge badge-info"><?php echo '+'.$n_stok_kritis ?></span>
                                                  <?php } ?>
                                              </div>
                                          </a>
                                      </li>
                                      <li>
                                          <a href="<?php echo base_url();?>henkel_adm_n_jt">
                                              <div class="clearfix">
                                                  <span class="pull-left">
                                                      <i class="ace-icon fa fa-circle light-green"></i>
                                                      <span class="content_notif">Jatuh Tempo Penjualan</span>
                                                  </span>
                                                  <?php if($n_jt>0) {?>
                                                  <span class="pull-right badge badge-info"><?php echo '+'.$n_jt ?></span>
                                                  <?php } ?>
                                              </div>
                                          </a>
                                      </li>
                                      <li>
                                          <a href="<?php echo base_url();?>henkel_adm_n_jt_inv_supp">
                                              <div class="clearfix">
                                                  <span class="pull-left">
                                                      <i class="ace-icon fa fa-circle light-blue"></i>
                                                      <span class="content_notif">Jatuh Tempo Pembelian</span>
                                                  </span>
                                                  <?php if($n_jt_inv_supp>0) {?>
                                                  <span class="pull-right badge badge-info"><?php echo '+'.$n_jt_inv_supp ?></span>
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
          $u=$this->session->userdata('username');
    			$foto = $this->session->userdata('foto');
        	if(!empty($foto)){
			?>
            	<img class="nav-user-photo" src="<?php echo base_url();?>assets/avatars/<?php echo $foto;?>" alt="<?php echo $u;?>" />
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
                <a href="<?php echo base_url();?>henkel_adm_profil">
                    <i class="icon-user"></i>
                    Edit Profile
                </a>
            </li>

            <li class="divider"></li>

            <li>
                <a href="<?php echo base_url();?>henkel/logout">
                    <i class="icon-off"></i>
                    Keluar
                </a>
            </li>
        </ul>
    </li>
</ul><!--/.ace-nav-->
