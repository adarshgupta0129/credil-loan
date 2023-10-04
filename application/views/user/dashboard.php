	<div class="row">
		<div class="col-md-12">
			<h4 id="das" class="page-title"><?php echo $page; ?></h4>
			<ol class="breadcrumb">
				<li><a href="">User</a></li>
				<li class="active"><?php echo $form; ?></li>
			</ol>
		</div>
		<div class="col-md-12">
			<div class="card-box" style="padding: 0px 0px 40px 0px;">
				<div class="col-md-12">
				<h4>Welcome: <?= $rec1->user_name; ?></h4>
				</div>
			</div>
		</div>
	</div>
	<?php
		$ifLoan = q("SELECT IFNULL((SELECT SUM(ap_ln_apply_amt) FROM `tr04_apply_loan` WHERE ap_ln_status = 1 AND ap_ln_reg_id = ".session('profile_id')."),0) as k")->row()->k;
		?>
	<div class="row">
		<?php include('user_detail.php') ?>
		<?php if($ifLoan > 0) { ?>
			<div class="col-md-3 col-lg-3">
				<div class="widget-bg-color-icon card-box fadeInDown animated">
					<div class="bg-icon bg-icon-purple pull-left">
						<i class="fa-4x">₹</i>
					</div>
					<div class="text-right">
						<h3 class="text-dark"><b class=""><?=$ifLoan?></b></h3>
						<p class="text-muted">Total Wallet Amount</p>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		<?php } ?>			
	</div>
	
		
	<?php if(!empty($res)) {?>
		<script>
			$(document).ready(function(){
				$("#offer").modal('show');
			});
		</script>
		<div class="modal fade" id="offer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-body">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<div class="blog_carousel owl-carousel">
								<?php if(!empty($res)){ foreach($res as $img_ban) {?>
									<figure class="sn_pd_two_slide">
									<img src="<?php echo base_url()?>application/banner/<?php echo $img_ban->m33_image?>" alt="">
								</figure>
								
								<?php } } ?>
						</div>					
					</div>				
				</div>
			</div>
		</div>
		<?php }?>