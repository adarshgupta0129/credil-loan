<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="applyCouponLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<?php $i = 0; foreach($images as $poup){ if($poup->img_section_id == '4'){ if($i == 0){ ++$i; ?>
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel"><?=$poup->img_content?></h5>
					<!--button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i class="las la-times"></i>
					</button-->
				</div>
				
							<a href="<?php echo base_url() ?>welcome/all_products?page=1&source=home_page&menuId=<?=$poup->img_show_menu?>"> 
								<img src="<?= base_url() ?>images/front/<?=$poup->img_section_id?>/x/<?=$poup->img_image?>"  class="img-fluid" alt="">
							</a>
						
	
			<?php } } } ?>
		</div>
	</div>
</div>
