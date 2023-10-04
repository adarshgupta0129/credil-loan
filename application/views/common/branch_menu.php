<body class="fixed-left">
	<!-- Begin page -->
	<div id="wrapper">
		<!-- Top Bar Start -->
		<div class="topbar">
			
			<!-- LOGO -->
			<div class="topbar-left">
				<div class="text-center">
					<a href="" class="logo"><i class="icon-c-logo"><?= substr(SITE_NAME,0,1); ?></i><span><?= SITE_NAME ?></span></a>
				</div>
			</div>
			
			<!-- Button mobile view to collapse sidebar menu -->
			<div class="navbar navbar-default" role="navigation">
				<div class="container">
					<div class="">
						<div class="pull-left">
							<button class="button-menu-mobile open-left waves-effect waves-light">
								<i class="md md-menu"></i>
							</button>
							<span class="clearfix"></span>
						</div>
						
						<ul class="nav navbar-nav navbar-right pull-right">
							
							<li class="hidden-xs">
								<a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="icon-size-fullscreen"></i></a>
							</li>
							
							<li class="dropdown top-menu-item-xs">
								<a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true"><i class="ti-user m-r-10"></i>  </a>								<ul class="dropdown-menu">
									<li class="divider"></li>
									<li><a href="<?php echo base_url('auth/logout') ?>"><i class="ti-power-off m-r-10 text-danger"></i> Logout</a></li>
								</ul>
							</li>
						</ul>
					</div>
					<!--/.nav-collapse -->
				</div>
			</div>
		</div>
		<!-- Top Bar End -->
		
		
		<!-- ========== Left Sidebar Start ========== -->
		
		<div class="left side-menu">
			<div class="sidebar-inner slimscrollleft">
				<!--- Divider -->
				<div id="sidebar-menu">
					<ul>
						<li class="menu-title">Navigation</li>					
						<li><a  class="waves-effect" href="<?php echo base_url(); ?>master/index"><i class="md md-dashboard"></i> <span>Dashboard</span></a></li>
						
						<?php 
							foreach($menu->result() as $m)
							{
							?> 
							<li class="nav-has_sub">
								<a href="javascript:void(0);" class="waves-effect"><i class="<?= $m->menu_fa_icon ?>"></i><?= $m->menu_name ?><span class="menu-arrow"></span></a>
								<ul class="list-unstyled">
									<?php
										$submenu = get_sub_menu($m->menu_id);
										if(!empty($submenu))
										{
											foreach($submenu as $sm)
											{
											?>
											<li><a href="<?= base_url().$sm->menu_url; ?>" class="menu-item"><i class="<?= $sm->menu_fa_icon ?>"></i> <?= $sm->submenu ?></a></li> 
											<?php 
											}
										}
									?>
								</ul>
							</li>
						<?php } ?>
						
						<li class=""><a class="waves-effect" href="<?php echo base_url('auth/logout') ?>"><i class="ion-log-out"></i> <span>Logout</span></a></li>
						
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<!-- Left Sidebar End -->	
		
		
		
		<div class="content-page">
			<!-- Start content -->
			<div class="content">
			<div class="container">			