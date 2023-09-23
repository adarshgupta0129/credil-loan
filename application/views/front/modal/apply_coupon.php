<div class="modal fade" id="applyCoupon" tabindex="-1" role="dialog" aria-labelledby="applyCouponLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Apply Coupon</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<i class="las la-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<?php if(!empty($coupons)){ foreach($coupons as $coup){ ?>
				<div class="coupon">
					<div class="coupon_container">
						<h3>Use Promo Code: 
							<a href="javascript:void(0)" class="btn btn-warning" data-dismiss="modal" aria-label="Close" title="Apply to get discount of <?=CURRENCY.$coup->coupon_amount?>" onclick="applyCouponCode('<?=$coup->coupon_id?>', '<?=$coup->coupon_code?>', '<?=$coup->coupon_amount?>', '<?=$coup->coupon_min_amount?>')"><?=$coup->coupon_code?></a>
						</h3>
					</div>
					<div class="coupon_container" style="background-color:white">
						<h2><b><?=$coup->coupon_title?></b></h2> 
						<p><a href="javascript:void(0)" onclick="showModal('<?=$coup->coupon_id?>', '1')"> more</a></p>
					</div>
					<div class="coupon_container">
						<p class="expire">Expires: <?=date("MMM d, Y", strtotime($coup->coupon_valid_date));?></p>
					</div>
				</div>
				<?php } } else { ?>
				<h4>No coupon available at this moment!</h4>
				<?php } ?>
				
			</div>
		</div>
	</div>
</div>
<script>
	function applyCouponCode(id, code, amt, minAmt){
		var orderTotal = parseInt($("#_payable").text());
		if(orderTotal < minAmt){
			alert('Minimum order value for this coupon is ₹'+minAmt);
		} else {
			 $('#couponId').val(id);
			 $('#coupon_code').html(code);
			 $('#coupon_amt').html(amt);
 			 $('#totalPayble').html("<i class='fa fa-inr'></i> <span id='_payable'>"+(orderTotal-amt)+"</span>");
		}
		$('#applyCoupon').modal('hide');
	}
	
</script>
<style>
	
	.coupon {
	border: 5px dotted #bbb;
	width: 80%;
	border-radius: 15px;
	margin: 0 auto;
	max-width: 600px;
	}
	
	.coupon_container {
	padding: 2px 16px;
	background-color: #f1f1f1;
	}
	
	.promo {
	background: #ccc;
	padding: 3px;
	}
	
	.expire {
	color: red;
	}
</style>