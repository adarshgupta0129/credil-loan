<style>
.flavour {
    position: absolute;
    right: 29px;
    bottom: 12px;
    font-size: 14px;
    color: green;
    font-style: italic;
	border: 1px solid gainsboro;
    padding: 0px 10px;
}
}
</style>


<section class="dlab-bnr-inr overlay-black-middle bg-pt" style="background-image:url(<?php echo base_url() ?>assets/images/bnr1.jpg);">
	<div class="container">
		<div class="dlab-bnr-inr-entry text-left">
			<h1 class="text-white">
				Checkout
			</h1>
			<!-- Breadcrumb row -->
			<div class="breadcrumb-row">
				<ul class="list-inline">
					<li><a href="<?php echo base_url() ?>">Home</a></li>
					<li>Checkout</li>
				</ul>
			</div>
		</div>
	</div>
</section>

<section class="section-full content-inner">
	<div class="container">
		<div class="row">
			<div class="col-md-5 order-md-2 mb-4">
				<ul class="list-group mb-3">
					<?php $i = $amt = $amt1 = $amt2 = $amtDel = $totAmt = 0; if(!empty($cart)){ ?>
						<?php foreach($cart as $ro){ $amt = $amt1 = $amt2 =0; ?>
							<h4 class="d-flex justify-content-between align-items-center mb-3"> 
								<span class="badge badge-secondary badge-pill">Order-<?= ++$i ?></span>
							</h4>
							<li class="list-group-item d-flex justify-content-start lh-condensed">
								<a href="<?=PROD_PATH.$ro->cart_variant_id.'/s/'.$ro->pr_img_name?>">
									<img class="cart_new" src="<?=PROD_PATH.$ro->cart_variant_id.'/s/'.$ro->pr_img_name?>" alt="">
								</a>
								&nbsp&nbsp&nbsp&nbsp&nbsp	
								<div style="width: 65%;">
									<h6 class="my-0"><?=$ro->pr_name?> (<?=$ro->type_name?>)</h6>
									<small class="text-muted">(<?=$ro->pr_vari_unit_value?> <?=$ro->unit_name?>) x <?=$ro->cart_qty?></small>
								</div>&nbsp&nbsp&nbsp&nbsp&nbsp
								<div style="width: 30%;">
									<span class="text-muted">
										<i class="fa fa-inr"></i> <?=$ro->pr_vari_actual_price?>
									</span><br>
									<?php if($ro->cart_type_charge > 0): ?>
										<span class="text-muted" title="Egg-less Charge">
											+ <i class="fa fa-inr"></i> <?=$ro->cart_type_charge?>
										</span>
									<?php endif ?>
									
								</div>
								&nbsp;&nbsp
								<div style="width: 30%;">
									<del><i class="fa fa-inr text-muted"></i> <?=$ro->pr_vari_show_price?></del> 
								</div>
								<a href="javascript:void(0)" id="proremove" onclick="remove(<?=$ro->cart_id;?>)" value="<?=$ro->cart_id;?>" type="button" class="btn btn-sm"><i class="las la-trash"></i></a>
								<?php if($ro->is_designer == "YES"): ?>
									<div class="flavour">
										Flavour 
										<select class="ddFlavour" style="border:none" data-pr_id="<?=$ro->pr_id?>">
										<option value="">Not Selected</option>
											<?php foreach($flavours as $f): ?>
												<option value="<?=$f->m13_id?>" <?=$ro->flavour_id ==$f->m13_id ? "selected" : "" ?> ><?=$f->m13_flavor?></option>
											<?php endforeach ?>
										</select>
									</div>
								<?php endif ?>
								
							</li>
							<?php $amt1 = $amt1 + ($ro->pr_vari_actual_price*$ro->cart_qty);
							$cart_addon = cart_addon_product($session_id, $ro->cart_id);?>
							<?php if(!empty($cart_addon)){ ?>
								<h4 class="d-flex justify-content-between align-items-center mb-3">
									<span class="text-muted"> Addon</span>
								</h4>
								<?php  foreach($cart_addon as $ro_add){ ?>			
									<li class="list-group-item d-flex justify-content-start lh-condensed" style="margin-left:60px">
										<a href="<?=ADDON_PATH.$ro_add->cart_variant_id.'/s/'.$ro_add->pr_img_name?>">
											<img class="cart_new" src="<?=ADDON_PATH.$ro_add->cart_variant_id.'/s/'.$ro_add->pr_img_name?>" alt="">
										</a>
										&nbsp&nbsp&nbsp&nbsp&nbsp 
										<div style="width: 74%;">
											<h6 class="my-0"><?=$ro_add->pr_name?></h6>
											<small class="text-muted">x <?=$ro_add->cart_qty?></small>
										</div>
										<div style="width: 30%;">
											<span class="text-muted"><i class="fa fa-inr"></i> <?=$ro_add->pr_vari_actual_price?></span>
										</div>
										<a href="javascript:void(0)" id="proremove" onclick="remove(<?=$ro_add->cart_id;?>)" value="<?=$ro->cart_id;?>" type="button" class="btn btn-sm"><i class="las la-trash"></i></a>
									</li>
								<?php  $amt2 = $amt2 + ($ro_add->pr_vari_actual_price*$ro_add->cart_qty); } } $amt = $amt1+$amt2;  ?> 
								
								<li class="list-group-item d-flex justify-content-between  bg-light" style="margin-top: 5px;">
									<span>Delivery Date</span>
									<h6 class="my-0"><i class="fa fa-calendar"></i> <?php echo $ro->cart_delivery_date.' ('.$ro->delivery_timing.')';?></h6>
								</li>
								<li class="list-group-item d-flex justify-content-between  bg-light" style="margin-top: 5px;">
 									<span>Delivery Charges</span>
									<h6 class="my-0"><i class="fa fa-inr"></i> <?php echo $ro->deli_slot_charges; $amtDel = $ro->deli_slot_charges;?></h6>
								</li>

								<li class="list-group-item d-flex justify-content-between  bg-light" style="margin-top: 5px;">
									<span>Total Order-<?=$i?> (INR)</span>
									<h6 class="my-0"><i class="fa fa-inr"></i> <?php echo $amt+$amtDel+$ro->cart_type_charge; $totAmt = $totAmt+$amt+$amtDel+$ro->cart_type_charge;?></h6>
								</li>
						<?php } } ?>	
						
				</ul>
			</div>
			<div class="col-md-7 order-md-1">
				<?php if(session('profile_id') <> ""){ ?>
					
					<form method="post" action="" id="placeOrderForm">
						<?php if($totAmt > 0){ ?>
							<h4 class="mb-3"> Address
								<a class="btn btn-outline-dark btn-sm float-right" data-toggle="modal" data-target="#newAddress">Add New Address</a>
							</h4>
 							<div class="row"><?if($address ==!' '){?>
								<div class="col-md-12 mb-3">
									<div class="card p-3 mb-2 bg-light">
										<label>You haven't add any address</label>
									</div>
								</div>
								<?php } else { ?>
								<?php $i=1; foreach($address as $add){  $i++; ?>
									<div class="col-md-12 mb-3">
										<div class="card p-3 mb-2 bg-light">
											<div class="custom-control custom-radio p-0">
												<input type="radio" name="txtAddressId" name="txtAddressId" class="custom-control-input" id="<?= $add->user_addr_id;?>" value="<?= $add->user_addr_id;?>" <?php if($i==2){ echo"checked"; }?> >
												<label class="custom-control-label" for="<?= $add->user_addr_id;?>"> <?= $add->user_addr_name;?>  <?= $add->user_addr_mobile;?> <?= $add->user_addr_address;?> <?= $add->user_addr_pincode;?></label>
											</div>
											
										</div>
									</div>
								<?php } } ?>
							</div>
							<!--hr class="mb-4">
							<h4 class="mb-3">Suggestion</h4>
							<div class="row">
								<div class="col-md-12 mb-3">
									<textarea id="textarea" name="txtInstruction" rows="3" class="form-control" placeholder="Your Suggestion"></textarea>
								</div>
							</div-->
							<hr class="mb-4">
							<h4 class="mb-3">Payment Mode</h4>						
							<div class="d-block my-3">
								<div class="custom-control custom-radio">
									<input id="txtPaymentMode" Name="txtPaymentMode" value="COD" type="radio" class="custom-control-input" required>
									<label class="custom-control-label" for="txtPaymentMode">COD</label>
								</div>
								<div class="custom-control custom-radio">
									<input id="txtPaymentModeOnline" Name="txtPaymentMode" value="ONLINE" type="radio" class="custom-control-input" required checked>
									<label class="custom-control-label" for="txtPaymentModeOnline">Pay Online</label>
								</div>
							</div>	
							
 							<ul class="list-group mb-3">	
							 
							 <?php $wallet_dis = checkout_wallet_off($this->session->userdata("profile_id")); ?>
								<li class="list-group-item d-flex justify-content-between  bg-light" style="margin-top: 20px;">
									<span>Total Order Value</span>
									<h6 class="my-0"><i class="fa fa-inr"></i><?=$totAmt?></h6>
								</li> 

								<li class="list-group-item d-flex justify-content-between  bg-light" style="margin-top: 15px;">
 									<span>Wallet Discount</span>
									<h6 class="my-0">- <i class="fa fa-inr"></i> <?php echo $wallet_dis;?></h6>
								</li>
								
								<li class="list-group-item d-flex justify-content-between"> 
									<div class="text-success"> 
										<span>Promo code</span>&nbsp; 
										<a class="btn-link btn" data-toggle="modal" data-target="#applyCoupon" id="couponBtn" style="color:#cb4e83;border-bottom:2px dotted #cb4e83;padding: 6px 0;">Apply Promo Code</a>
										<input type="hidden" value="0" name="couponId" id="couponId" /><br/>
										<strong id="coupon_code"></strong>
									</div>
									<span class="text-success">-<i class="fa fa-inr"></i><strong id="coupon_amt"></strong> </span>
								</li>
								
								<li class="list-group-item d-flex justify-content-between  bg-light" style="margin-top: 20px;">
									<span>Total Payble</span>
 									<h6 class="my-0" id="totalPayble"><i class="fa fa-inr"></i> <span id="_payable"><?=$totAmt - $wallet_dis?></span></h6>
								</li> 
							</ul>
 						<?php } ?>
						<hr class="mb-4">
						
						<?php if($totAmt > 0){ ?>
							<button class="btn btn-primary btn-lg btn-block" type="button" id="placeOrderBtn" onclick="placeOrder()" >Place Order</button>
							<?php } else { ?>
							<a class="btn btn-primary btn-lg btn-block" href="<?=base_url()?>">Continue Purchase</a>
						<?php } ?>
					</form>
					<?php } else { ?>
					<div class="p-a30 border-1 radius-sm">
						<div class="tab-content tab-form nav">
							<form action="<?=base_url()?>Auth/login?login_src=checkout" method="POST" id="loginForm" class="tab-pane active col-12 p-a0 ">
								<h3 class="m-b5">Login</h3>
								<p>If you have an account with us, please log in.</p>
								<?php if($this->session->flashdata('info')){ ?>
									<div class="alert alert-info alert-dismissible">
										<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
										<strong>Info!</strong> <?=$this->session->flashdata('info')?>
									</div>
								<?php } ?>
								
								<div class="form-group">
									<label>Mobile Number <span class="required">*</span></label>
									<input type="text" name="txtlogin" id="txtlogin" class="form-control" placeholder="Your Mobile Number">
								</div>
								
								<div class="form-group">
									<label>Password <span class="required">*</span></label>
									<input type="password" name="txtpwd" id="txtpwd" class="form-control" placeholder="Type Password">
								</div>
								
								<input name="user_type" type="hidden" value="2">
								
								<div class="text-left">
									<button type="submit" class="btn btnhover btn-dark m-r5"><i class="las la-sign-in-alt"></i> Login</button>
									<a data-toggle="tab" href="#forgot-password" class="m-l5"><i class="fa fa-unlock-alt"></i> Forgot Password</a> 
								</div>
							</form>
							<form id="forgot-password" class="tab-pane fade col-12 p-a0">
								<h4>Forget Password ?</h4>
								<p>We will send you an email to reset your password. </p>
								<div class="form-group">
									<label>E-Mail *</label>
									<input name="dzName" required="" class="form-control" placeholder="Your Email Id" type="email">
								</div>
								<div class="text-left"> 
									<a class="btn btn-light" data-toggle="tab" href="#login"><i class="las la-undo-alt"></i> Back</a>
									<button class="btn btnhover btn-success pull-right"><i class="las la-share"></i> Submit</button>
									
								</div>
							</form>
						</div>
					</div> 
				<?php } ?>
			</div>
		</div>
	</div>
</section>


<?php $this->load->view('front/modal/new_address'); ?>

<?php 	$data['coupons'] = $coupons;
		$data['totAmt'] = $totAmt;
	$this->load->view('front/modal/apply_coupon', $data); ?>

<script>

function placeOrder()
{	
	var urlpost = baseUrl+txtclass+"/placeOrder";
	var txtAddressId = $("input[name='txtAddressId']").val();
  	if(txtAddressId == '' || txtAddressId == undefined)
	{
		bootbox.alert("Please select address for delivery");
	} else {
			$("#placeOrderBtn").prop('disabled', true);
			$.ajax({
			type: "POST",
			url : urlpost,
			data: $('#placeOrderForm').serialize(),
		 	beforeSend : function(){
				$.blockUI(
				{
					message: '<img src="'+baseUrl+'application/libraries/loading.gif" />'
				});
			},
			success: function(msg){
				if($('input[name="txtPaymentMode"]:checked').val() == "ONLINE"){
					window.location.href = baseUrl+"Welcome/online_payment/"+msg;
				}else{
					if(msg.trim() == "1" )
						window.location.href = baseUrl+"Userprofile/viewOrders/"+msg;
					else
						window.location.reload(true);
				}
			 	
			}
		});
	}
}

$(".ddFlavour").on("change", function() {
	   var f=$(this);
		if(f != ""){
			$.ajax({
				url: "<?=base_url()?>welcome/update_flavour",
  				type: "post",
				data: {product: f.attr("data-pr_id"),flavour:f.val()},
   				success: function(data) {
					bootbox.alert("Flavour Updated Successfully");
			   }		
   			});
		}
   });
</script>																												