<?php $a=1; if(!(empty($rec))){ foreach($rec as $prod){ ?>
	
	<div class="blog-post col-xl-3 col-lg-3 col-md-3 col-sm-3 blog-lg blog-rounded">		
		<div class="dlab-post-media dlab-img-effect zoom-slow">
			<?=$prod->badges_style?>
			
			<a href="<?php echo base_url() ?>welcome/product/<?=url_title($prod->pr_name, 'dash')?>?productId=<?=$prod->pr_id?>&variantId=<?=$prod->pr_vari_id?>&catId=<?=$prod->pr_cat3?>&pincode=<?=get('pincode')?>">					
			<div class="">
				<?php $image = get_product_image($prod->pr_id, $prod->pr_vari_id); foreach($image as $img){ ?>
					<img src="<?= base_url() ?>images/product/<?=$img->pr_img_pr_vari_id?>/m/<?=$img->pr_img_name?>"  class="img-fluid mySlides<?= $a;?>" alt="" />
				<?php } ?>
			</div>
				</a>
		</div>
		<div class="bt">			
			<button class="left" onclick="plusDivs<?= $a;?>(-1)">❮</button>
			<button class="right" onclick="plusDivs<?= $a;?>(1)">❯</button>			
		</div>
		<div class="dlab-info">
			<a href="<?php echo base_url() ?>welcome/product/<?=url_title($prod->pr_name, 'dash')?>?productId=<?=$prod->pr_id?>&variantId=<?=$prod->pr_vari_id?>&pincode=<?=get('pincode')?>">					
				<div class="dlab-post-title">
					<p><?=$prod->pr_name?></p>
					<h4 class="price "><span>
					<i class="fa fa-inr"></i> <?=$prod->pr_vari_actual_price?></span>
					<del><i class="fa fa-inr"></i> <?=$prod->pr_vari_show_price?></del>
					<span class="badge bg-success"><?=discount($prod->pr_vari_actual_price, $prod->pr_vari_show_price)?></span>
					</h4>
					<div class="rating">
						<p class="rating1">4.6<i class="las la-star-half-alt"></i></p>
						<p class="Reviews">1549 Reviews</p>
					</div>
				</div>
			</a>
		</div>
	</div>
	<script>
		var slideIndex = 1;
		showDivs<?= $a;?>(slideIndex);
		
		function plusDivs<?= $a;?>(n) {
			showDivs<?= $a;?>(slideIndex += n);
		}
		
		function currentDiv<?= $a;?>(n) {
			showDivs<?= $a;?>(slideIndex = n);
		}
		
		function showDivs<?= $a;?>(n) {
			var i;
			var x = document.getElementsByClassName("mySlides<?= $a;?>");
			var dots = document.getElementsByClassName("demo<?= $a;?>");
			if (n > x.length) {slideIndex = 1}    
			if (n < 1) {slideIndex = x.length}
			for (i = 0; i < x.length; i++) {
				x[i].style.display = "none";  
			}
			for (i = 0; i < dots.length; i++) {
				dots[i].className = dots[i].className.replace(" w3-red", "");
			}
			x[slideIndex-1].style.display = "block";  
			//dots[slideIndex-1].className += " w3-red";
		}
	</script>
<?php $a++; } } else { ?>
<h5> No product available! </h5>
<?php } ?>
