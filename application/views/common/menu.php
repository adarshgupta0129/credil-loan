<body class="fixed-left">
	<!-- Begin page -->
	<div id="wrapper">
		<!-- Top Bar Start -->
		<div class="topbar">
			
			<!-- LOGO -->
			<div class="topbar-left">
				<div class="text-center"> <a href="" class="logo"><i class="icon-c-logo" >
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
								<a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true"><i class="ti-user m-r-10"></i>  </a>					
								<ul class="dropdown-menu">
									<li><a href="<?php echo base_url() ?>master/view_soft_login"><i class="ti-user m-r-10 text-custom"></i> Profile</a></li>
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
						<li ><a  class="waves-effect" href="<?php echo base_url(); ?>master/index"><i class="md md-dashboard"></i> <span>Dashboard</span></a></li>
						
						<li class="has_sub">
							<a href="javascript:void(0);" class="waves-effect"><i class="md-assignment-returned"></i> <span> Master </span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled">
								<li><a href="<?php echo base_url() ?>master/view_soft_login"><i class="fa fa-angle-double-right"></i> Manage Login</a></li>
								<li><a href="<?php echo base_url() ?>master/view_soft_setting"><i class="fa fa-angle-double-right"></i> Manage Settings</a></li>
 								<li><a href="<?php echo base_url() ?>master/view_location"><i class="fa fa-angle-double-right"></i> Manage Location</a></li>
 								<li><a href="<?php echo base_url() ?>master/view_bank"><i class="fa fa-angle-double-right"></i> Manage Bank</a></li>
 								<li><a href="<?php echo base_url() ?>master/view_admin_bank"><i class="fa fa-angle-double-right"></i> Manage Admin Bank</a></li>
 								<li><a href="<?php echo base_url() ?>master/view_payment_mode"><i class="fa fa-angle-double-right"></i> Manage Payment Mode</a></li>
 								<li><a href="<?php echo base_url() ?>master/view_relation"><i class="fa fa-angle-double-right"></i> Manage Relation</a></li>
 								<li><a href="<?php echo base_url() ?>master/view_proof"><i class="fa fa-angle-double-right"></i> Manage Proof</a></li>
 								<li><a href="<?php echo base_url() ?>master/view_loan_type"><i class="fa fa-angle-double-right"></i>Manage Loan Type</a></li>
 								<li><a href="<?php echo base_url() ?>master/view_loan_plan"><i class="fa fa-angle-double-right"></i> Manage Loan Plan</a></li>
 								<li><a href="<?php echo base_url() ?>branch/view_branch_reg"><i class="fa fa-angle-double-right"></i> Manage Branch</a></li>
								
								
								
								
								
								
								
								
								
								
								
								<?php /* 
 								<li><a href="<?php echo base_url() ?>master/view_location_group"><i class="fa fa-angle-double-right"></i> Location Group</a></li>
 								<li><a href="<?php echo base_url() ?>master/view_menu"><i class="fa fa-angle-double-right"></i> Manage Menu</a></li>
									<li><a href="<?php echo base_url() ?>master/view_banner"><i class="ti-image"></i> Upload Banner</a></li>
									<li><a href="<?php echo base_url() ?>master/view_send_sms"><i class="ion-navicon"></i> Sms Campaigning</a></li>
									<li><a href="<?php echo base_url() ?>master/add_event"><i class="ti-heart-broken"></i> Upload Event</a></li>
								*/ ?>
							</ul>
						</li>
						
						<li class="has_sub">
							<a href="javascript:void(0);" class="waves-effect"><i class="ion-android-social"></i> <span> Customers</span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled">
								<li><a href="<?php echo base_url() ?>Member/view_all_member"><i class="fa fa-users"></i> View Customers</a></li>
								<li><a href="<?php echo base_url() ?>Member/view_kyc"><i class="ti-star"></i> Manage Kyc</a></li>
								<!--li><a href="<?php echo base_url() ?>member/join_member"><i class="fa fa-plus-square"></i> Signup</a></li>
								<li><a href="<?php echo base_url() ?>member/view_member_edit"><i class="fa fa-edit"></i> Edit Member Detail</a></li>
								<li><a href="<?php echo base_url() ?>member/view_member_details"><i class="fa fa-th-list"></i> View Member Detail</a></li>
								<li><a href="<?php echo base_url() ?>member/view_activate_members"><i class="fa fa-thumbs-up"></i> Activate Member</a></li>
								<li><a href="<?php echo base_url() ?>member/view_deactivate_members"><i class="fa fa-thumbs-o-down"></i> Deactivate Member</a></li>
								<li><a href="<?php echo base_url() ?>member/view_bank_details"><i class="md-account-balance"></i> View Bank Details</a></li-->
							</ul>
						</li>
						
						<?php /*
						<li class="has_sub">
							<a href="javascript:void(0);" class="waves-effect"><i class="md-assignment-returned"></i> <span>Product Master </span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled">
								<!--li><a href="<?php echo base_url() ?>Product_Master/view_category"><i class="fa fa-angle-double-right"></i> Product Category</a></li-->
								<li><a href="<?php echo base_url() ?>Product_Master/view_type"><i class="fa fa-angle-double-right"></i> Product Type</a></li>
								<li><a href="<?php echo base_url() ?>Product_Master/view_unit"><i class="fa fa-angle-double-right"></i> Manage Unit</a></li>
								<li><a href="<?php echo base_url() ?>Product_Master/view_variant"><i class="fa fa-angle-double-right"></i> Manage Variant</a></li>
 								<li><a href="<?php echo base_url() ?>Product_Master/view_add_product"><i class="fa fa-angle-double-right"></i> Add Product</a></li>
								<li><a href="<?php echo base_url() ?>Product_Master/view_all_products"><i class="fa fa-angle-double-right"></i> View Products</a></li>
 								<li><a href="<?php echo base_url() ?>Product_Master/view_product_variant"><i class="fa fa-angle-double-right"></i> Add Product Variant</a></li>
 								<li><a href="<?php echo base_url() ?>Product_Master/view_all_product_variants"><i class="fa fa-angle-double-right"></i> View Product Variant</a></li>
 								<li><a href="<?php echo base_url() ?>Product_Master/view_product_addons"><i class="fa fa-angle-double-right"></i> Add Addons</a></li>
							</ul>
						</li>
						
						<li class="has_sub">
							<a href="javascript:void(0);" class="waves-effect"><i class="fa fa-tag"></i> <span>Coupon </span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled">
								<li><a href="<?php echo base_url() ?>Coupon"><i class="fa fa-angle-double-right"></i> Add Coupon</a></li>
								<li><a href="<?php echo base_url() ?>Coupon/view_coupons"><i class="fa fa-angle-double-right"></i> View Coupons</a></li>
							</ul>
						</li>
						
						<li class="has_sub">
							<a href="javascript:void(0);" class="waves-effect"><i class="fa fa-file"></i> <span>Images </span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled">
								<li><a href="<?php echo base_url() ?>Master/images"><i class="fa fa-angle-double-right"></i> Add Images</a></li>
								<li><a href="<?php echo base_url() ?>Master/view_images"><i class="fa fa-angle-double-right"></i> View Images</a></li>
							</ul>
						</li>
						<li class="has_sub">
							<a href="javascript:void(0);" class="waves-effect"><i class="md-assignment-returned"></i> <span>Orders </span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled">
								<li class=""><a href="<?php echo base_url() ?>Member/viewOrders"><i class="ion-log-out"></i> <span>Orders</span></a></li>
								<li><a href="<?php echo base_url() ?>master/view_customized"><i class="fa fa-angle-double-right"></i> Customize Cake</a></li>								
							</ul>
						</li>
						<li class=""><a class="waves-effect" href="<?php echo base_url('Member/view_all_member') ?>"><i class="fa fa-users"></i> <span>Customers</span></a></li>						
						*/?>
						<li class=""><a class="waves-effect" href="<?php echo base_url('auth/logout') ?>"><i class="ion-log-out"></i> <span>Logout</span></a></li>						
					</ul>
				</div>
			</div>
		</div>
		<!-- Left Sidebar End -->	
		
		
		
		
		<div class="content-page">
			<!-- Start content -->
			<div class="content">
			<div class="container">			