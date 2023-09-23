<style>#ui-id-1{z-index: 99999;}.ui-state-active,
	.ui-widget-content .ui-state-active,
	.ui-widget-header .ui-state-active,
	a.ui-button:active,
	.ui-button:active,
	.ui-button.ui-state-active:hover, .ui-icon-background,
	.ui-state-active .ui-icon-background, .ui-state-active a,
	.ui-state-active a:link,
	.ui-state-active a:visited {
	border: 1px solid #efefef !important;
	background: none !important;
	box-shadow: 0px 3px 6px rgb(0 0 0 / 17%);
	color: #333 !important;
}</style>
<!-- header -->
<header class="site-header mo-left header primary pizza-header">
	<!-- main header -->
	<div class="sticky-header main-bar-wraper navbar-expand-lg">
		<div class="main-bar clearfix ">
			<div class="container-fluid clearfix">
				
				<!-- website logo -->
				<div class="logo-header mostion">
					<a href="<?php echo base_url() ?>"><img src="<?php echo base_url() ?>logo/logo.png" alt=""></a>
				</div>
				<!-- nav toggle button -->
				<button class="navbar-toggler collapsed navicon justify-content-end" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					<span></span>
					<span></span>
					<span></span>
				</button>
				<!-- extra nav -->
				<div class="extra-nav">
					<div class="extra-cell">
						<ul class="extra-info">
							<li id="custom-search-form">
								<div  class="form-search form-horizontal pull-right">
									<div class="input-append">
										<input type="text" id=mainHeaderSearch class="search-query  mac-style" placeholder="Search">
										<button type="button" class="btn"><i class="ti-search"></i></button>
									</div>
								</div>
							</li>
							<a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#DeliveryLocation">									
								<i class="las la-map-marker-alt"></i>
								<?php if(get('pincode') == '' || strlen(get('pincode')) <> 6){ ?>
									<span class="hidden-xs">Select Delivery Location<i class="las la-angle-right"></i></span>
									<?php } else { ?>
									<span class="hidden-xs">Your Location</span> : 
									<span class="hidden-xs"><?=get('pincode')?></span>
								<?php 	} ?>
							</a>	
						</li>
						<li class="hidden-xs">
							<div class="header-phone-no">
								<img src="<?php echo base_url() ?>assets/images/icons/telephone.png" alt=""/>
								<span>24/7 cake delivery service</span>
								<h2><?php echo CONTACT1; ?></h2>
							</div>
						</li>
						<?php if(fetch_method() <> "checkout"){ ?>
							<?php $this->load->view('front/product/product_cart'); ?>
						<?php } ?>
						<li>
							<a href="<?php echo base_url();
								if(session('profile_id')){
									echo 'userprofile';
									} else {
									echo 'user_login';
								}
								?>" target="_blank" class="cart">
								<i class="las la-user"></i>
							</a>
						</li>
						<li>
							<div class="menu-btn">
								<span></span>
								<span></span>
								<span></span>
							</div>
						</li>
						
						
					</ul>
				</div>
			</div>
			<!-- Quik search -->
			<div class="dlab-quik-search ">
				<form action="#">
					<input name="search" value="" type="text" class="form-control" placeholder="Type to search">
					<span id="quik-search-remove"><i class="ti-close"></i></span>
				</form>
			</div>
			<!-- main nav -->
			
			
			<div class="header-nav navbar-collapse collapse justify-content-end" id="navbarNavDropdown">
				
				<ul class="nav navbar-nav"> 
					<?php foreach($menu as $first){ ?>
						<li class="has-mega-menu">
							<a href="javascript:void(0);"><?=$first->front_menu_name?><i class="fa fa-chevron-down"></i></a>
							<ul class="mega-menu">
								<?php
									$submenu = front_menu_child($first->front_menu_id);
									if(!empty($submenu))
									{
										foreach($submenu as $second)
										{
										?>
										<li>
											<a href="<?php echo base_url() ?>"><?=$second->front_menu_name?></a>
											<ul>	
												<?php
													$subsubmenu = front_menu_child_third($second->front_menu_id);
													if(!empty($subsubmenu))
													{
														foreach($subsubmenu as $third)
														{
														?>
														<li class="icon-chain">
															<li><a href="<?php echo base_url() ?>welcome/all_products<?="?source=main_menu&page=1&menuId=".$third->front_menu_id?>"><?=$third->front_menu_name?><?=$third->badges_style?></a></li>
														</li>
														<?php 
														}
													}
												?>
											</ul>
											<?php 
											}
										}
									?>
									
									
								</li>
							</ul>
						</li>  
					<?php } ?> 
					<li>
						<a href="<?php echo base_url() ?>customize">Customize Cake</a>
					</li>
				</ul>
				
				<div class="pizza-btn-close">&times;</div>
			</div>
		</div>
	</div>
</div>
<!-- main header END -->
</header>


<!-- header END -->
<!-- Content -->
<div class="page-content bg-white">
	<!-- contact area -->
	<div class="content-block">
	<!-- Slider -->							