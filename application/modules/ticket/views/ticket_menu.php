<?php
if ($class == 'new_ticket') {
	$new_ticket = 'class="active"';
	$list_ticket = '';
} elseif ($class == 'list_ticket') {
	$new_ticket = '';
	$list_ticket = 'class="active"';
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
				<li <?php echo $new_ticket; ?>>
					<a href="<?php echo base_url(); ?>ticket">
						<i class="icon-plus"></i>
						<span class="menu-text"> New Ticket </span>
					</a>
				</li>
				<li <?php echo $list_ticket; ?>>
					<a href="<?php echo base_url(); ?>ticket_list">
						<i class="icon-list"></i>
						<span class="menu-text"> List Ticket </span>
					</a>
				</li>
			<li>
				<a href="<?php echo base_url(); ?>login_ticketing/logout">
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