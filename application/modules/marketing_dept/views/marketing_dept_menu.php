<?php
if($class=='home'){
	$home = 'class="active"';
	$corp ='';
	$wuling = '';

}elseif($class=='corp'){
    $home = '';
    $corp ='class="active"';
		$wuling = '';
		$wuling = '';

}elseif($class=='wuling'){
    $home = '';
    $wuling ='class="active"';
		$corp ='';

}else {
	$home = '';
  $corp ='';
	$wuling = '';
}

$this->load->model('model_isi');
$count_pd=$this->model_isi->count_pd();
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
    <img src="<?php echo base_url();?>assets/img/logo.png" height="80" width="80">
    </div>

    <ul class="nav nav-list">
        <li <?php echo $corp;?> >
            <a href="#" class="dropdown-toggle">
				<img src="<?php echo base_url();?>assets/img/favicon_kmg.png" height="20" width="20">
                <span class="menu-text"> Dashboard Corporate </span>
                <b class="arrow icon-angle-down"></b>
            </a>
        </li>

		<li <?php echo $corp;?> >
            <a href="#" class="dropdown-toggle">
                <img src="<?php echo base_url();?>assets/img/favicon_hino.png" height="12" width="20">
                <span class="menu-text"> Dashboard Hino </span>
                <b class="arrow icon-angle-down"></b>
            </a>

        </li>

		<li <?php echo $wuling;?> >
            <a href="#" class="dropdown-toggle">
                <img src="<?php echo base_url();?>assets/img/owner_wuling.png" height="20" width="20">
                <span class="menu-text"> Dashboard Wuling </span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                <li>
                        <a href="<?php echo base_url();?>marketing_dept_lap_summary">
                                <i class="icon-double-angle-right"></i>
                                Summary Activity
                        </a>
                </li>
                <li>
                        <a href="<?php echo base_url();?>marketing_dept_target_sm">
                                <i class="icon-double-angle-right"></i>
                                Prospek Activity
                        </a>
                </li>
                <li>
                        <a href="<?php echo base_url();?>marketing_dept_target_sm">
                                <i class="icon-double-angle-right"></i>
                                SPK Activity
                        </a>
                </li>
				<li>
                        <a href="<?php echo base_url();?>marketing_dept_target_sm">
                                <i class="icon-double-angle-right"></i>
                                Sumber Prospek Activity
                        </a>
                </li>
				<li>
                        <a href="<?php echo base_url();?>marketing_dept_target_sm">
                                <i class="icon-double-angle-right"></i>
                                Media Motivator Activity
                        </a>
                </li>
				<li>
                        <a href="<?php echo base_url();?>marketing_dept_target_sm">
                                <i class="icon-double-angle-right"></i>
                                Activity by Model Unit
                        </a>
                </li>
            </ul>
        </li>

		<li <?php echo $corp;?> >
            <a href="#" class="dropdown-toggle">
                <img src="<?php echo base_url();?>assets/img/owner_honda.png" height="20" width="20">
                <span class="menu-text"> Dashboard Honda </span>
                <b class="arrow icon-angle-down"></b>
            </a>

        </li>

		<li <?php echo $corp;?> >
            <a href="#" class="dropdown-toggle">
                <img src="<?php echo base_url();?>assets/img/mazda.png" height="15" width="20">
                <span class="menu-text"> Dashboard Mazda </span>
                <b class="arrow icon-angle-down"></b>
            </a>

        </li>

		<li <?php echo $corp;?> >
            <a href="#" class="dropdown-toggle">
                <img src="<?php echo base_url();?>assets/img/owner_mercedes.png" height="20" width="20">
                <span class="menu-text"> Dashboard Mercedes </span>
                <b class="arrow icon-angle-down"></b>
            </a>

        </li>

		<li <?php echo $corp;?> >
            <a href="#" class="dropdown-toggle">
                <img src="<?php echo base_url();?>assets/img/owner_tatax.png" height="20" width="20">
                <span class="menu-text"> Dashboard Tata </span>
                <b class="arrow icon-angle-down"></b>
            </a>

        </li>

		<li <?php echo $corp;?> >
            <a href="#" class="dropdown-toggle">
                <img src="<?php echo base_url();?>assets/img/owner_tire.png" height="20" width="20">
                <span class="menu-text"> Dashboard Ban </span>
                <b class="arrow icon-angle-down"></b>
            </a>

        </li>

		<li <?php echo $corp;?> >
            <a href="#" class="dropdown-toggle">
                <img src="<?php echo base_url();?>assets/img/owner_oil.png" height="20" width="20">
                <span class="menu-text"> Dashboard Oli </span>
                <b class="arrow icon-angle-down"></b>
            </a>

        </li>

		<li <?php echo $corp;?> >
            <a href="#" class="dropdown-toggle">
                <img src="<?php echo base_url();?>assets/img/owner_property.png" height="20" width="20">
                <span class="menu-text"> Dashboard Property </span>
                <b class="arrow icon-angle-down"></b>
            </a>

        </li>

				<!--<li <?php echo $edit_unit;?> >
            <a href="<?php echo base_url();?>marketing_dept_edit_unit">
                <i class="icon-edit"></i>
                <span class="menu-text"> Edit Unit </span>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url();?>wuling/logout">
                <i class="icon-off"></i>
                <span class="menu-text"> Keluar </span>
            </a>
        </li>
    </ul><!--/.nav-list-->

    <div class="sidebar-collapse" id="sidebar-collapse">
        <i class="icon-double-angle-left"></i>
    </div>
</div>
