<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
	<ol class="carousel-indicators">
		<li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"></li>
		<li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"></li>
		<li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"></li>
	</ol>
	<div class="carousel-inner">
		<div class="carousel-caption d-md-block content">
            <h4 class="sub-title">Welcome To <?php echo SITE_NAME; ?></h4>
            <h2 class="title">Best Cakes, Bouquets, Chocolates, Flowers</h2>
            <h4 class="sub-title">in Lucknow Delivering to you...</h4>
			<br>
			<div class="search">
				<div class="row no-gutters">
					<div class="col-4 col-lg-3 col-md-3 col-sm-3 border-right0">
						<a class="btn btn-block text-left" data-bs-toggle="modal" data-bs-target="#DeliveryLocation">							
							<i class="las la-map-marker-alt"></i>
							<span class="hidden-xs">Delivery Location</span>
						</a>
					</div>
					<div class="col-8 col-lg-9 col-md-9 col-sm-9">
						<div class="has-feedback">
							<input type="text" class="form-control" placeholder="Enter Pincode" id="pincode" name="pincode" maxlength="6" value="<?=get('pincode')?>" />
							<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
							<span class="form-control-feedback">
								<button type="button" class="btn" onclick="set_pincode($('#pincode').val());window.location.reload(true)"><i class="ti-search"></i></button>
							</span>
						</div>						
					</div>					
				</div>				
			</div>			
		</div>
		<?php $i = 0; foreach($images as $slider){ if($slider->img_section_id == '1'){ ?>
		<div class="carousel-item <?php echo ($i==0)?'active':''; ++$i; ?>" >
			<img src="<?= base_url() ?>images/front/<?=$slider->img_section_id?>/x/<?=$slider->img_image?>" class="d-block w-100" alt="...">			
		</div>
		<?php } } ?>
	</div>
	<a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-bs-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="visually-hidden"></span>
	</a>
	<a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-bs-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="visually-hidden"></span>
	</a>
</div>


<!-- Subscribe Now -->
<?php //$data['images'] = $images; $this->load->view('front/modal/popup', $data); ?>

<!-- Services -->
<!-- Faq And Our Info -->
<section class="section-full content-inner-3" style="background-image:url(<?php echo base_url() ?>assets/images/background/bg5.jpg);  background-size:100%;">
	<div class="container">
		<div class="row service-area1">
		<?php foreach($images as $img){ if($img->img_section_id == '2'){ ?>
			<div class="col-6 col-lg-2 col-md-2 col-sm-4">
				<div class="icon-bx-wraper text-center service-box1" style="background-image: url(<?= base_url() ?>images/front/<?=$img->img_section_id?>/x/<?=$img->img_image?>)">
					<div class="icon-content">
						<a href="<?php echo base_url() ?>welcome/all_products?page=1&source=home_page&menuId=<?=$img->img_show_menu?>"> 
							<h2 class="dlab-tilte text-white"><?=$img->img_content?></h2>
							<?=$img->img_short_content?>
							<div class="dlab-separator style1 bg-primary"></div>
						</a>
					</div>
				</div>
			</div>
			<?php } } ?>
		
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="section-head mb-0 text-center">
					<div class="icon-bx icon-bx-xl">
						<img src="<?php echo base_url() ?>assets/images/cake1.jpg" alt="">
					</div>
					<h3 >Fresh cake & Perfect Gifts for all Occasions</h3>
					<p class="main-text">
						<strong>3 Hour Delivery</strong> & Free Shipping in India. 20,325 Gift Ideas for your Beloved
					</p>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Services End -->
<section class="section-full bg-white">
	<?php foreach($menu as $men){
		$id = $men->front_menu_id;
		$show_cat = front_menu_child($id);//$this->db->query("SELECT * FROM `m06_front_menu` WHERE `front_menu_parent_id` = $id and front_menu_status = 1 and front_menu_isDisplay = 1")->result();
		if(count($show_cat) > 0){
	?>
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="section-head">
						<h3>Shop By <?= $men->front_menu_name ?> Categories</h3>
					</div>
				</div>
			</div>
			<div class="row">
				<?php 
					foreach($show_cat as $res){?>
					<div class="col-6 col-lg-2 col-md-2 col-sm-2">
						<div class="port-box1 text-white">
							<a href="<?php echo base_url() ?>welcome/all_products?page=1&source=home_page&menuId=<?= $res->front_menu_id;?>">
								<div class="dlab-media">
									<img src="<?php echo base_url();?>images/menu/<?= $res->front_menu_id;?>/m/<?= $res->front_menu_img;?>" alt=""  onerror="this.src='<?php echo base_url();?>notfound.jpg';this.onerror='';">
								</div>
								<div class="dlab-info">
									<h2 class="title"><?= $res->front_menu_name;?></h2>
								</div>
							</a>
						</div>
					</div>
				<?php }?>	
			</div>
		</div>
	<?php 
		} //end if not sub category found
		} // end of foreach
		?>
	
</section>
<section class="section-full content-inner" style="background-image:url(<?php echo base_url() ?>assets/images/background/bg5.jpg); background-size:100%;">
	
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="section-head">
					<h3>Trending Now
					</h3>
				</div>
			</div>
		</div>
		<div class="row">
 		<?php 
		foreach($trending as $prod) {
		$img = get_product_one_image($prod->pr_vari_id); ?>
			<div class="col-6 col-md-2 col-sm-3 m-b30">
				<div class="item-box shop-item style2">
						<a href="<?php echo base_url() ?>welcome/product/<?=url_title($prod->pr_name, 'dash')?>?productId=<?=$prod->pr_id?>&variantId=<?=$prod->pr_vari_id?>&pincode=<?=get('pincode')?>" target="_blank">
						<div class="item-img">
							<img src="<?= base_url() ?>images/product/<?=$prod->pr_vari_id?>/m/<?=$img->pr_img_name?>" onerror="this.src='<?php echo base_url();?>notfound.jpg';this.onerror='';" alt="<?=$prod->pr_name?>">
						</div>
						<div class="item-info text-center">
							<p class="item-title">
								<a href="<?php echo base_url() ?>welcome/product/<?=url_title($prod->pr_name, 'dash')?>?productId=<?=$prod->pr_id?>&variantId=<?=$prod->pr_vari_id?>&pincode=<?=get('pincode')?>" target="_blank">
									<?=$prod->pr_name?>
								</a>
								</p>
							<h5 class="price "><span><i class="fa fa-inr"></i> <?=$prod->pr_vari_actual_price?></span><del><i class="fa fa-inr"></i> <?=$prod->pr_vari_show_price?></del></h5>
							<div class="cart-btn">
								<a href="<?php echo base_url() ?>welcome/product/<?=url_title($prod->pr_name, 'dash')?>?productId=<?=$prod->pr_id?>&variantId=<?=$prod->pr_vari_id?>&pincode=<?=get('pincode')?>" class="btn btnhover radius-xl">
									<i class="ti-layout-media-right-alt"></i> More Details
								</a>
							</div>
						</div>
					</a>
				</div>
			</div>
		<?php  } ?>
	</div>
</div>
<!-- Product END -->
</section>
<!-- Slider Banner -->
<section class="section-full bg-white food-banner">
	<div class="container">
		<div class="row">
			<div class="col-lg-5 col-md-7">
				<div class="bnr3 banner-content">
					<h2 class="title">We Serve Best Cake With A Purpose</h2>
					<h4>We are <?php echo SITE_NAME; ?> India's Biggest Cake Provider</h4>
					<p><em>A surprise gift is always a great memory especially when it comes from the people you admire the most.</em> </p>
					<p>
						Making others happy gives a great satisfaction and that’s why one should not leave any opportunity to impress the other one.
					</p>
				</div>
				<div class="row service-list-area">
					<div class="col-4">
						<div class="icon-bx-wraper text-white service-box3 center bg-primary">
							<div class="icon-lg m-b10">
								<span class="icon-cell"><i class="flaticon-delivery-truck"></i></span>
							</div>
							<div class="icon-content">
								<h5 class="dlab-tilte">Fast Felivery</h5>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="icon-bx-wraper text-white service-box3 center bg-red">
							<div class="icon-lg m-b10">
								<span class="icon-cell"><i class="flaticon-menu"></i></span>
							</div>
							<div class="icon-content">
								<h5 class="dlab-tilte">Daily Menus</h5>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="icon-bx-wraper text-white service-box3 center bg-green">
							<div class="icon-lg m-b10">
								<span class="icon-cell"><i class="flaticon-roast-chicken"></i></span>
							</div>
							<div class="icon-content">
								<h5 class="dlab-tilte">Spicy Foods</h5>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="icon-bx-wraper text-white service-box3 center bg-yellow">
							<div class="icon-lg m-b10">
								<span class="icon-cell"><i class="flaticon-hot-cup-of-tea"></i></span>
							</div>
							<div class="icon-content">
								<h5 class="dlab-tilte">Coffee</h5>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="icon-bx-wraper text-white service-box3 center bg-pink">
							<div class="icon-lg m-b10">
								<span class="icon-cell"><i class="flaticon-wine	"></i></span>
							</div>
							<div class="icon-content">
								<h5 class="dlab-tilte">Hot Plates</h5>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="icon-bx-wraper text-white service-box3 center bg-blue">
							<div class="icon-lg m-b10">
								<span class="icon-cell"><i class="flaticon-dish"></i></span>
							</div>
							<div class="icon-content">
								<h5 class="dlab-tilte">Fresh Cake</h5>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-7 col-md-5">
				<img src="<?php echo base_url() ?>assets/images/main-slider/slide3.jpg" alt="" class="food-slide-img radius-sm"/>
			</div>
		</div>
	</div>
</section>
<!-- About Services -->
<section class="section-full content-inner service-area2 bg-img-fix bg-line-top bg-line-bottom" style="background-image: url(<?php echo base_url() ?>assets/images/background/bg4.jpg);  background-size: cover;">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="section-head text-center">
					<h2 class="text-white">What Do We Offer For You?</h2>
					<p class="text-bold">Our mission is to offer our customers a wow experience through continuous innovation of premium products and services by using world class technology and processes .</p>
					<div class="dlab-separator style1 bg-primary"></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4 m-b30">
				<img src="<?php echo base_url() ?>assets/images/about/pic1.jpg" class="img-cover radius-sm" alt="">
			</div>
			<div class="col-lg-8">
				<div class="row p-l30">
					<div class="col-lg-6 col-sm-6 m-b30">
						<div class="icon-bx-wraper text-white service-box2">
							<div class="icon-bx">
								<a href="javascript:void(0);" class="icon-cell"><img src="<?php echo base_url() ?>assets/images/icons/service-icon/icon2.png" alt=""></a>
							</div>
							<div class="icon-content">
								<h5 class="dlab-tilte">Pancakes</h5>
								<p>A pancake is a flat cak</p>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-sm-6 m-b30">
						<div class="icon-bx-wraper text-white service-box2">
							<div class="icon-bx">
								<a href="javascript:void(0);" class="icon-cell"><img src="<?php echo base_url() ?>assets/images/icons/service-icon/icon3.png" alt=""></a> 
							</div>
							<div class="icon-content">
								<h5 class="dlab-tilte">Muffin</h5>
								<p>A muffin is an individual-sized	</p>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-sm-6 m-b30">
						<div class="icon-bx-wraper text-white service-box2">
							<div class="icon-bx">
								<a href="javascript:void(0);" class="icon-cell"><img src="<?php echo base_url() ?>assets/images/icons/service-icon/icon4.png" alt=""></a> 
							</div>
							<div class="icon-content">
								<h5 class="dlab-tilte">Pumpkin cakes</h5>
								<p>Pumpkin Cake is exceptionally easy to make</p>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-sm-6 m-b30">
						<div class="icon-bx-wraper text-white service-box2">
							<div class="icon-bx">
								<a href="javascript:void(0);" class="icon-cell"><img src="<?php echo base_url() ?>assets/images/icons/service-icon/icon5.png" alt=""></a> 
							</div>
							<div class="icon-content">
								<h5 class="dlab-tilte">Pumpkin Cupcakes</h5>
								<p>Use grated pumpkin or butternut squash for these gorgeous</p>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-sm-6 m-b30">
						<div class="icon-bx-wraper text-white service-box2">
							<div class="icon-bx">
								<a href="javascript:void(0);" class="icon-cell"><img src="<?php echo base_url() ?>assets/images/icons/service-icon/icon5.png" alt=""></a> 
							</div>
							<div class="icon-content">
								<h5 class="dlab-tilte">Cake Services</h5>
								<p>Send Cake online from best cake shop in India</p>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-sm-6 m-b30">
						<div class="icon-bx-wraper text-white service-box2">
							<div class="icon-bx"> 
								<a href="javascript:void(0);" class="icon-cell"><img src="<?php echo base_url() ?>assets/images/icons/service-icon/icon1.png" alt=""></a> 
							</div>
							<div class="icon-content">
								<h5 class="dlab-tilte">Birthday Cake</h5>
								<p>Birthdays are incomplete without the delicious cakes</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- About Services End -->
<section class="section-full bg-white" style="background-image:url(<?php echo base_url() ?>assets/images/background/bg5.jpg); background-size:100%;">
	<div class="container content-inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="section-head text-center">
					<div class="icon-bx icon-bx-xl">
						<img src="<?php echo base_url() ?>assets/images/cake1.jpg" alt="">
					</div>
					<h3>We Are Professional at Our Skills</h3>
					<p>More than 2000+ customers trusted us</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3 col-md-6 col-sm-6 col-6 m-b30">
				<div class="counter-style-1 text-center">
					<div class="counter-num ">
						<span class="counter">53</span>
						<small>+</small>
					</div>
					<span class="counter-text">Years of Experience</span>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6 col-6 m-b30">
				<div class="counter-style-1 text-center">
					<div class="counter-num ">
						<span class="counter">102</span>
					</div>
					<span class="counter-text">Awards Wins</span>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6 col-6 m-b30">
				<div class="counter-style-1 text-center">
					<div class="counter-num ">
						<span class="counter">36</span>
						<small>k</small>
					</div>
					<span class="counter-text">Happy Clients</span>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6 col-6 m-b30">
				<div class="counter-style-1 text-center">
					<div class="counter-num ">
						<span class="counter">99</span>
					</div>
					<span class="counter-text">Perfect Products</span>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
	<?php foreach($images as $imgLimit){ if($imgLimit->img_section_id == '3'){ ?>
		<div class="row m-lr0 about-area1">
			<div class="col-lg-6 p-lr0">
				<img class="img-cover" src="<?= base_url() ?>images/front/<?=$imgLimit->img_section_id?>/x/<?=$imgLimit->img_image?>" alt="">
			</div>
			<div class="col-lg-6 p-lr0 d-flex align-items-center text-center">
				<div class="about-bx">
					<div class="section-head text-center text-white">
						<h4 class="text-white">Limited Time Offer</h4>
						<p><?=$imgLimit->img_content?></p>
						<div class="icon-bx">
							<img src="<?php echo base_url() ?>assets/images/icons/service-icon/icon2.png" alt="">
						</div>
					</div>
					<?=$imgLimit->img_short_content?>
					<a href="<?php echo base_url() ?>welcome/all_products?page=1&source=home_page&menuId=<?=$imgLimit->img_show_menu?>" class="btn-secondry white btnhover btn-md"><i class="fa fa-cart"></i>GET NOW</a>
				</div>
			</div>
		</div>
	<?php } } ?>
	</div>
	<div class="container">
		<div class="row client-area1 p-t80">
			<div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-6 m-b30">
				<div class="client-logo" data-name="Bakery">
					<img src="<?php echo base_url() ?>assets/images/logos/logo1.jpg" alt="">
				</div>
			</div>
			<div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-6 m-b30">
				<div class="client-logo" data-name="Bakery">
					<img src="<?php echo base_url() ?>assets/images/logos/logo2.jpg" alt="">
				</div>
			</div>
			<div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-6 m-b30">
				<div class="client-logo" data-name="Bakery">
					<img src="<?php echo base_url() ?>assets/images/logos/logo3.jpg" alt="">
				</div>
			</div>
			<div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-6 m-b30">
				<div class="client-logo" data-name="Bakery">
					<img src="<?php echo base_url() ?>assets/images/logos/logo4.jpg" alt="">
				</div>
			</div>
			<div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-6">
				<div class="client-logo" data-name="Bakery">
					<img src="<?php echo base_url() ?>assets/images/logos/logo5.jpg" alt="">
				</div>
			</div>
			<div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-6">
				<div class="client-logo" data-name="Bakery">
					<img src="<?php echo base_url() ?>assets/images/logos/logo6.jpg" alt="">
				</div>
			</div>
		</div>
	</div>
</section>
<!-- About End -->
<section class="section-full content-inner bg-white" style="background-image:url(<?php echo base_url() ?>assets/images/overlay/pt1.jpg)">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-12">
				<div class="adv-box">
					<a href="<?php echo base_url() ?>"><img src="<?php echo base_url() ?>assets/images/ads/adv1.jpg" alt=""/></a>
				</div>
			</div>
			<div class="col-lg-6 col-md-12">
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="adv-box">
							<a href="assets/shop-sidebar.html"><img src="<?php echo base_url() ?>assets/images/ads/adv2.jpg" alt=""/></a>
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="adv-box">
							<a href="assets/shop-sidebar.html"><img src="<?php echo base_url() ?>assets/images/ads/adv3.jpg" alt=""/></a>
						</div>
					</div>
					<div class="col-lg-12 col-md-12">
						<div class="adv-box">
							<a href="assets/shop-sidebar.html"><img src="<?php echo base_url() ?>assets/images/ads/adv4.jpg" alt=""/></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</section>						