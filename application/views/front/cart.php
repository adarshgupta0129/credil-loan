<section class="dlab-bnr-inr overlay-black-middle bg-pt" style="background-image:url(<?php echo base_url() ?>assets/images/bnr1.jpg);">
	<div class="container">
		<div class="dlab-bnr-inr-entry text-left">
			<h1 class="text-white">
				Your Cart
			</h1>
			<!-- Breadcrumb row -->
			<div class="breadcrumb-row">
				<ul class="list-inline">
					<li><a href="<?php echo base_url() ?>">Home</a></li>
					<li>Your Cart</li>
				</ul>
			</div>
		</div>
	</div>
</section>
<!-- contact area -->

<section class="section-full content-inner">
	<!-- Product -->
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="table-responsive m-b50">
					<table class="table check-tbl">
						<thead>
							<tr>
								<th style="width: 104px;">Product</th>
								<th>Product Name</th>
								<th>Unit Price</th>
								<th>Quantity</th>
								<th>Total</th>
								<th style="width: 50px;">Remove</th>
							</tr>
						</thead>
						<tbody>
							<?php $amt = 0;if(!empty($cart)){ foreach($cart as $ro){  ?>
								<tr class="alert">
									<td class="product-item-img">
										<img src="<?=PROD_PATH.$ro->cart_variant_id.'/s/'.$ro->pr_img_name?>" alt="">
									</td>
									<td class="product-item-name">
										<?=$ro->pr_name?>
										<label class="label alert-info" id="product_unit"><?=$ro->pr_vari_unit_value?> <?=$ro->unit_name?></label>
									</td>
									<td class="product-item-price"><i class="fa fa-inr"></i> <?=$ro->pr_vari_actual_price?></td>
									<td class="product-item-quantity">
										<div class="quantity btn-quantity max-w80">
											<input id="prod_qty"  type="text" value="<?=$ro->cart_qty?>" name="prod_qty"  style="width: 31px;" />
											<input type="button" value="-" class="qtyminus looking" onclick="qty_update(1,<?=$ro->cart_id?>)" style="float: left;margin-right: 2px;">
											<input type="button" value="+" class="qtyplus looking" onclick="qty_update(2,<?=$ro->cart_id?>)" style="float: right;margin-left: 2px;">
										</div>
									</td>
									<td class="product-item-totle"><i class="fa fa-inr"></i> <?php echo ($ro->cart_qty*$ro->pr_vari_actual_price)?></td>
									<td class="product-item-close">
										<a href="javascript:void(0);" data-dismiss="alert" aria-label="close" class="ti-close"></a>
									</td>
								</tr>
							<?php $amt = $amt + $ro->pr_vari_actual_price; }} else { ?>
							<p> Your cart is empty</p>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="row">
			<!--div class="col-lg-6 col-md-6 m-b30">
				<form class="shop-form"> 
				<h3>Add Card</h3>
				<div class="form-group">
				<select>
				<option value="">Credit Card Type</option>
				
				</select>	
				</div>	
				<div class="row">
				<div class="form-group col-lg-6">
				<input type="text" class="form-control" placeholder="Credit Card Number">
				</div>
				<div class="form-group col-lg-6">
				<input type="text" class="form-control" placeholder="Card Verification Number">
				</div>
				</div>
				<div class="form-group">
				<input type="text" class="form-control" placeholder="Coupon Code">
				</div>
				<div class="form-group">
				<button class="btn btnhover blue" type="button">Apply Coupon</button>
				</div>
				</form>	
			</div-->
			<div class="col-lg-6 col-md-6 offset-6">
				<h3>Cart Subtotal</h3>
				<table class="table-bordered check-tbl">
					<tbody>
						<tr>
							<td>Order Subtotal</td>
							<td><i class="fa fa-inr"></i> <?=$amt?></td>
						</tr>
						<tr>
							<td>Shipping</td>
							<td>Free Shipping</td>
						</tr>
						<!--tr>
							<td>Coupon</td>
							<td><i class="fa fa-inr"></i> 0</td>
						</tr-->
						<tr>
							<td>Total</td>
							<td><i class="fa fa-inr"></i>  <?=$amt?></td>
						</tr>
					</tbody>
				</table>
				<div class="form-group">
					<button class="btn btnhover pink" type="button">Proceed to Checkout</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Product END -->
</section>


<script>
	function qty_update(type,id)
	{ 
		$.ajax({
			type: "POST",
			url:baseUrl+"get_details/qty_update",
			data: "type="+type+"&id="+id,
			success: function(msg) {
				window.location.href = baseUrl+txtclass+"/"+txtmethod;
			}
		});	
	} 
</script>
