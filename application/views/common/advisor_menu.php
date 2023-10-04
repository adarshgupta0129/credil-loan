<body class="fixed-left">
	<!-- Begin page -->
	<div id="wrapper">
		<!-- Top Bar Start -->
		<div class="topbar">

			<!-- LOGO -->
			<div class="topbar-left">
				<div class="text-center"> <a href="" class="logo"><i class="icon-c-logo">
							<img src="<?= base_url(); ?>favicon/favicon.png" alt="Logo" />
						</i><span>
							<img src="<?= base_url(); ?>logo/logo.png" alt="Logo" style="width: 60px;" />
						</span></a> </div>
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
								<a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true"><i class="ti-user m-r-10"></i> </a>
								<ul class="dropdown-menu">
									<li><a href="<?php echo base_url() ?><?=fetch_class()?>/index"><i class="ti-user m-r-10 text-custom"></i> Profile</a></li>
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
                        <li>
                            <a class="waves-effect" href="<?php echo base_url(); ?><?=fetch_class()?>/index"><i class="md md-dashboard"></i> <span>Dashboard</span></a>
                        </li>
                        
						<li class="has_sub">
							<a href="javascript:void(0);" class="waves-effect"><i class="ion-android-social"></i> <span> Customers</span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled">
								<li><a href="<?php echo base_url() ?>Advisor/view_all_member/6/Customers"><i class="fa fa-angle-double-right"></i> View Customers</a></li>
								<li><a href="<?php echo base_url() ?>Advisor/view_kyc"><i class="fa fa-angle-double-right"></i> Manage Kyc</a></li>
							</ul>
						</li>

                        <li class="">
                            <a class="waves-effect" href="<?php echo base_url('auth/logout') ?>"><i class="ion-log-out"></i> <span>Logout</span></a>
                        </li>
					</ul>
				</div>
			</div>
		</div>
		<!-- Left Sidebar End -->

		<div class="content-page">
			<!-- Start content -->
			<div class="content">
				<div class="container">