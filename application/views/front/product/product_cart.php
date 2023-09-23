<li class="dropdown">
	<button class="dropdown-toggle cart" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
		<i class="lab la-opencart"></i> 
		<span class="cartcount"><?php if(empty($cart)){ echo"0";}else {$j1=count($cart);echo$j1;}?></span>
	</button>
	<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">

			<ul class="cartgrid">
				<?php $i = $amt = $amt1 = $amt2 = 0;if(!empty($cart)){ ?>
					<?php foreach($cart as $ro){  ?>
					<h2>Order-<?=++$i?></h2>
						<li><a href="<?=base_url()?>welcome/addon?cartId=<?=$ro->cart_id?>&productId=<?=$ro->pr_id?>&variantId=<?=$ro->cart_variant_id?>" class="btn btn-block btn-sm btn-danger text-uppercase Addons"><i class="ti-shopping-cart"></i> Add some Addons</a>

<img src="<?=PROD_PATH.$ro->cart_variant_id.'/s/'.$ro->pr_img_name?>" alt="">
				
							<p><?=$ro->pr_name?>
								<label class="text-info" id="product_unit1">(<?=$ro->pr_vari_unit_value?> <?=$ro->unit_name?>) x <?=$ro->cart_qty?></label>
							</p>
							<h4 class="price ">
								<span><i class="fa fa-inr"></i> <?=$ro->pr_vari_actual_price?></span>
								<del><i class="fa fa-inr"></i> <?=$ro->pr_vari_show_price?></del>                    
							</h4>
							<a href="javascript:void(0)" id="proremove" onclick="remove(<?=$ro->cart_id;?>)" value="<?=$ro->cart_id;?>" type="button" class="trash"><i class="las la-trash"></i></a>
						</li>
						
						
 						<h6>Addons Order-<?=$i?></h6>
						<?php $cart_addon = cart_addon_product($session_id, $ro->cart_id); foreach($cart_addon as $ro_add){ ?>			
							<li style="margin-left:50px">													
								<img src="<?=ADDON_PATH.$ro_add->cart_variant_id.'/s/'.$ro_add->pr_img_name?>" alt="">
								<p><?=$ro_add->pr_name?>
									<label class="text-info" id="product_unit1"> x <?=$ro_add->cart_qty?></label>
								</p>
								<h4 class="price ">
									<span><i class="fa fa-inr"></i> <?=$ro_add->pr_vari_actual_price?></span>                  
								</h4>
								<a href="javascript:void(0)" id="proremove" onclick="remove(<?=$ro_add->cart_id;?>)" value="<?=$ro->cart_id;?>" type="button" class="btn btn-sm trash"><i class="las la-trash"></i></a>
							</li>
							<hr/>
						<?php  $amt2 = $amt2 + ($ro_add->pr_vari_actual_price*$ro_add->cart_qty); } 
						 $amt1 = $amt1 + ($ro->pr_vari_actual_price*$ro->cart_qty); }  $amt = $amt1+$amt2; } else { ?>
					<li> Your cart is empty</li>
				<?php } ?>
			</ul> 
			<h4 class="price" style="margin: 10px 0;">
				CART TOTAL<span class="pull-right text-success"><i class="fa fa-inr"></i> <?=$amt?></span>
			</h4>	 
			<a href="<?=base_url()?>welcome/checkout" class="btn btn-block btn-danger text-uppercase">Continue Checkout <i class="las la-arrow-right"></i></a>
	</ul>
</li>
<script>
	function remove(id){
		$.ajax({
			url: "<?php echo base_url(); ?>welcome/remove_product",
			type: "post",
			dataType: "json",
			data: {
				id: id,
			},
			success: function(data) { 
				if(data == "1"){
					location.reload(true);
					}else{
					alert('somthing wrong');
				}
			},
			
		});
	}
</script>